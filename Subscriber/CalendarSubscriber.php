<?php

namespace Sg\CalendarBundle\Subscriber;

use Sg\CalendarBundle\SgCalendarEvents;
use Sg\CalendarBundle\Model\RecurrenceInterface;
use Sg\CalendarBundle\Entity\Calculation;
use Sg\CalendarBundle\Event\EventData;
use Sg\CalendarBundle\Event\CalendarData;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CalendarSubscriber
 *
 * @package Sg\CalendarBundle\EventSubscriber
 */
class CalendarSubscriber implements EventSubscriberInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var EntityManager
     */
    protected $em;


    /**
     * @var array
     */
    private static $messages = array(
        SgCalendarEvents::EVENT_CREATE_COMPLETED => 'calendar.flash.success.event.created',
        SgCalendarEvents::EVENT_UPDATE_COMPLETED => 'calendar.flash.success.event.updated',
        SgCalendarEvents::EVENT_REMOVE_COMPLETED => 'calendar.flash.success.event.removed',
        SgCalendarEvents::CALENDAR_CREATE_COMPLETED => 'calendar.flash.success.calendar.created',
        SgCalendarEvents::CALENDAR_UPDATE_COMPLETED => 'calendar.flash.success.calendar.updated',
        SgCalendarEvents::CALENDAR_REMOVE_COMPLETED => 'calendar.flash.success.calendar.removed'
    );


    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param Session               $session    A Session instance
     * @param UrlGeneratorInterface $router     A UrlGeneratorInterface instance
     * @param TranslatorInterface   $translator A TranslatorInterface instance
     * @param EntityManager         $em         An EntityManager instance
     */
    public function __construct(Session $session, UrlGeneratorInterface $router, TranslatorInterface $translator, EntityManager $em)
    {
        $this->session = $session;
        $this->router = $router;
        $this->translator = $translator;
        $this->em = $em;
    }


    //-------------------------------------------------
    // EventController
    //-------------------------------------------------

    /**
     * Set Response.
     *
     * @param EventData $eventData
     */
    public function onEventCreateSuccess(EventData $eventData)
    {
        $event = $eventData->getEvent();
        $url = $this->router->generate('sg_calendar_get_event', array('id' => $event->getId()));
        $eventData->setResponse(new RedirectResponse($url));
    }

    /**
     * Set Response.
     *
     * @param EventData $eventData
     */
    public function onEventUpdateSuccess(EventData $eventData)
    {
        $event = $eventData->getEvent();
        $url = $this->router->generate('sg_calendar_get_event', array('id' => $event->getId()));
        $eventData->setResponse(new RedirectResponse($url));
    }

    /**
     * Set Response.
     *
     * @param EventData $eventData
     */
    public function onEventRemoveSuccess(EventData $eventData)
    {
        $url = $this->router->generate('sg_calendar');
        $eventData->setResponse(new RedirectResponse($url));
    }

    /**
     * Calculate recurrences.
     *
     * @param EventData $eventData
     */
    public function onEventHasRecurrences(EventData $eventData)
    {
        $event = $eventData->getEvent();
        $eventStart = $event->getStart();

        /**
         * @var \Sg\CalendarBundle\Entity\Recurrence $recurrence
         */
        foreach ($event->getRecurrences() as $recurrence) {
            $recurrencePeriod = $recurrence->getPeriod();
            $recurrenceEnd = $recurrence->getEnd();

            if (RecurrenceInterface::PERIOD_WEEKLY === $recurrencePeriod) {
                $intervall = new \DateInterval('P7D');
                $p = new \DatePeriod($eventStart, $intervall, $recurrenceEnd, \DatePeriod::EXCLUDE_START_DATE);
                $i = 0;
                foreach ($p as $item) {
                    //print $item->format(\DateTime::ISO8601).'<br>';
                    $calc[$i] = new Calculation();
                    $calc[$i]->setRecurrence($recurrence);
                    $calc[$i]->setStart($item);
                    $calc[$i]->setEnd($item);
                    $this->em->persist($calc[$i]);
                    $i++;
                }
            }
        }

        $this->em->flush();
    }


    //-------------------------------------------------
    // CalendarController
    //-------------------------------------------------

    /**
     * Set Response.
     *
     * @param CalendarData $calendarData
     */
    public function onCalendarCreateSuccess(CalendarData $calendarData)
    {
        $url = $this->router->generate('sg_calendar');
        $calendarData->setResponse(new RedirectResponse($url));
    }

    /**
     * Set Response.
     *
     * @param CalendarData $calendarData
     */
    public function onCalendarUpdateSuccess(CalendarData $calendarData)
    {
        $url = $this->router->generate('sg_calendar');
        $calendarData->setResponse(new RedirectResponse($url));
    }

    /**
     * Set Response.
     *
     * @param CalendarData $calendarData
     */
    public function onCalendarRemoveSuccess(CalendarData $calendarData)
    {
        $url = $this->router->generate('sg_calendar');
        $calendarData->setResponse(new RedirectResponse($url));
    }


    //-------------------------------------------------
    // Common
    //-------------------------------------------------

    /**
     * Set FlashBag.
     *
     * @param Event $event
     */
    public function addSuccessFlash(Event $event)
    {
        $eventName = $event->getName();
        $this->session->getFlashBag()->add('success', $this->translator->trans(self::$messages[$eventName], array(), 'flashes'));
    }


    //-------------------------------------------------
    // EventSubscriberInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            SgCalendarEvents::EVENT_CREATE_SUCCESS => 'onEventCreateSuccess',
            SgCalendarEvents::EVENT_UPDATE_SUCCESS => 'onEventUpdateSuccess',
            SgCalendarEvents::EVENT_REMOVE_SUCCESS => 'onEventRemoveSuccess',
            SgCalendarEvents::EVENT_CREATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::EVENT_UPDATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::EVENT_REMOVE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::EVENT_CALCULATE_RECURRENCES => 'onEventHasRecurrences',
            SgCalendarEvents::CALENDAR_CREATE_SUCCESS => 'onCalendarCreateSuccess',
            SgCalendarEvents::CALENDAR_UPDATE_SUCCESS => 'onCalendarUpdateSuccess',
            SgCalendarEvents::CALENDAR_REMOVE_SUCCESS => 'onCalendarRemoveSuccess',
            SgCalendarEvents::CALENDAR_CREATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_UPDATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_REMOVE_COMPLETED => 'addSuccessFlash'
        );
    }
}