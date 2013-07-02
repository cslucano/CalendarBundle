<?php

namespace Sg\CalendarBundle\Subscriber;

use Sg\CalendarBundle\SgCalendarEvents;
use Sg\CalendarBundle\Event\CalendarEvent;
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
     * @var array
     */
    private static $messages = array(
        SgCalendarEvents::EVENT_CREATE_COMPLETED => 'calendar.flash.success.event.created',
        SgCalendarEvents::EVENT_UPDATE_COMPLETED => 'calendar.flash.success.event.updated',
        SgCalendarEvents::EVENT_REMOVE_COMPLETED => 'calendar.flash.success.event.removed'
    );


    /**
     * Ctor.
     *
     * @param Session               $session    A Session instance
     * @param UrlGeneratorInterface $router     A UrlGeneratorInterface instance
     * @param TranslatorInterface   $translator A TranslatorInterface instance
     */
    public function __construct(Session $session, UrlGeneratorInterface $router, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function onEventCreateSuccess(CalendarEvent $calendarEvent)
    {
        $event = $calendarEvent->getEvent();
        $url = $this->router->generate('sg_calendar_get_event', array('id' => $event->getId()));
        $calendarEvent->setResponse(new RedirectResponse($url));
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function onEventUpdateSuccess(CalendarEvent $calendarEvent)
    {
        $event = $calendarEvent->getEvent();
        $url = $this->router->generate('sg_calendar_get_event', array('id' => $event->getId()));
        $calendarEvent->setResponse(new RedirectResponse($url));
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function onEventRemoveSuccess(CalendarEvent $calendarEvent)
    {
        $url = $this->router->generate('sg_calendar');
        $calendarEvent->setResponse(new RedirectResponse($url));
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function addSuccessFlash(CalendarEvent $calendarEvent)
    {
        $eventName = $calendarEvent->getName();
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
            SgCalendarEvents::EVENT_REMOVE_COMPLETED => 'addSuccessFlash'
        );
    }
}