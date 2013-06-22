<?php

namespace Sg\CalendarBundle\EventSubscriber;

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
        SgCalendarEvents::EVENT_CREATE_COMPLETED => 'sg.calendar.event.flash.created',
        SgCalendarEvents::EVENT_UPDATE_COMPLETED => 'sg.calendar.event.flash.updated',
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
        $url = $this->router->generate('sg_calendar_event_show', array('id' => $event->getId()));
        $calendarEvent->setResponse(new RedirectResponse($url));
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function onEventUpdateSuccess(CalendarEvent $calendarEvent)
    {
        $event = $calendarEvent->getEvent();
        $url = $this->router->generate('sg_calendar_event_show', array('id' => $event->getId()));
        $calendarEvent->setResponse(new RedirectResponse($url));
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function addSuccessFlash(CalendarEvent $calendarEvent)
    {
        $eventName = $calendarEvent->getName();
        $this->session->getFlashBag()->add('success', $this->translator->trans(self::$messages[$eventName], array(), 'CalendarBundle'));
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
            SgCalendarEvents::EVENT_CREATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::EVENT_UPDATE_COMPLETED => 'addSuccessFlash'
        );
    }
}