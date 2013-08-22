<?php

namespace Sg\CalendarBundle\Subscriber;

use Sg\CalendarBundle\SgCalendarEvents;
use Sg\CalendarBundle\Event\EventData;
use Sg\CalendarBundle\Event\CalendarData;
use Sg\CalendarBundle\Model\ModelManagerInterface;
use Sg\WhenBundle\When\When;
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
     * @var When
     */
    private $when;

    /**
     * @var ModelManagerInterface
     */
    private $occurrenceManager;

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
     * @param Session               $session           A Session instance
     * @param UrlGeneratorInterface $router            An UrlGeneratorInterface
     * @param TranslatorInterface   $translator        A TranslatorInterface
     * @param When                  $when              A When instance
     * @param ModelManagerInterface $occurrenceManager A ModelManagerInterface
     */
    public function __construct(Session $session, UrlGeneratorInterface $router, TranslatorInterface $translator,
        When $when, ModelManagerInterface $occurrenceManager)
    {
        $this->session = $session;
        $this->router = $router;
        $this->translator = $translator;
        $this->when = $when;
        $this->occurrenceManager = $occurrenceManager;
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
     * Generate occurrences.
     *
     * @param EventData $eventData
     */
    public function onEventHasRrules(EventData $eventData)
    {
        $event = $eventData->getEvent();

        /**
         * @var \Sg\CalendarBundle\Model\RruleInterface $rrule
         */
        foreach ($event->getRrules() as $rrule) {

            $when = $this->when;

            // required
            $when->startDate($rrule->getStart())
                 ->freq($rrule->getFreq())
                 ->interval($rrule->getIval());

            // optional
            if ($rrule->getCount()) {
                $when->count($rrule->getCount());
            }

            if ($rrule->getUntil()) {
                $when->until($rrule->getUntil());
            }

            if ($rrule->getWkst()) {
                $when->wkst($rrule->getWkst());
            }

            if ($rrule->getBysetpos()) {
                $when->bysetpos($rrule->getBysetpos());
            }

            if ($rrule->getByday()) {
                $when->byday($rrule->getByday());
            }

            if ($rrule->getBymonth()) {
                $when->bymonth($rrule->getBymonth());
            }

            if ($rrule->getBymonthday()) {
                $when->bymonthday($rrule->getBymonthday());
            }

            if ($rrule->getByyearday()) {
                $when->byyearday($rrule->getByyearday());
            }

            if ($rrule->getByweekno()) {
                $when->byweekno($rrule->getByweekno());
            }

            // byhour, byminute, bysecond

            // generate...
            $when->generateOccurences();

            /**
             * @var \Sg\CalendarBundle\Model\OccurrenceInterface $occurrence
             */
            foreach ($when->occurences as $result) {
                $occurrence = $this->occurrenceManager->create();
                $rrule->addOccurrence($occurrence);
                $occurrence->setStart($result);
                $occurrence->setEnd($result);
                $occurrence->setRrule($rrule);
            }

        }
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
            SgCalendarEvents::EVENT_GENERATE_OCCURRENCES => 'onEventHasRrules',
            SgCalendarEvents::CALENDAR_CREATE_SUCCESS => 'onCalendarCreateSuccess',
            SgCalendarEvents::CALENDAR_UPDATE_SUCCESS => 'onCalendarUpdateSuccess',
            SgCalendarEvents::CALENDAR_REMOVE_SUCCESS => 'onCalendarRemoveSuccess',
            SgCalendarEvents::CALENDAR_CREATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_UPDATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_REMOVE_COMPLETED => 'addSuccessFlash'
        );
    }
}