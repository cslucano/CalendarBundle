<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Subscriber;

use Sg\CalendarBundle\SgCalendarEvents;
use Sg\CalendarBundle\Event\EventData;
use Sg\CalendarBundle\Event\CalendarData;
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
     * @param UrlGeneratorInterface $router     An UrlGeneratorInterface
     * @param TranslatorInterface   $translator A TranslatorInterface
     */
    public function __construct(Session $session, UrlGeneratorInterface $router, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->router = $router;
        $this->translator = $translator;
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
            SgCalendarEvents::CALENDAR_CREATE_SUCCESS => 'onCalendarCreateSuccess',
            SgCalendarEvents::CALENDAR_UPDATE_SUCCESS => 'onCalendarUpdateSuccess',
            SgCalendarEvents::CALENDAR_REMOVE_SUCCESS => 'onCalendarRemoveSuccess',
            SgCalendarEvents::CALENDAR_CREATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_UPDATE_COMPLETED => 'addSuccessFlash',
            SgCalendarEvents::CALENDAR_REMOVE_COMPLETED => 'addSuccessFlash'
        );
    }
}