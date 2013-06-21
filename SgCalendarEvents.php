<?php

namespace Sg\CalendarBundle;

/**
 * Class SgCalendarEvents
 *
 * @package Sg\CalendarBundle
 */
final class SgCalendarEvents
{
    /**
     * EVENT_CREATE_COMPLETED is called each time a new event is saved.
     *
     * @var string
     */
    const EVENT_CREATE_COMPLETED = 'sg_calendar.event.create.completed';

    /**
     * EVENT_UPDATE_COMPLETED is called each time an event is updated.
     *
     * @var string
     */
    const EVENT_UPDATE_COMPLETED = 'sg_calendar.event.update.completed';
}