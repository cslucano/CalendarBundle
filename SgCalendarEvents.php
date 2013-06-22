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
     * EVENT_CREATE_SUCCESS occurs when the event creation form is submitted successfully.
     *
     * @var string
     */
    const EVENT_CREATE_SUCCESS = 'sg_calendar.event.create.success';

    /**
     * EVENT_UPDATE_SUCCESS occurs when the event update form is submitted successfully.
     *
     * @var string
     */
    const EVENT_UPDATE_SUCCESS = 'sg_calendar.event.update.success';

    /**
     * EVENT_CREATE_COMPLETED occurs after saving the event in the creation process.
     *
     * @var string
     */
    const EVENT_CREATE_COMPLETED = 'sg_calendar.event.create.completed';

    /**
     * EVENT_CREATE_COMPLETED occurs after saving the event in the update process.
     *
     * @var string
     */
    const EVENT_UPDATE_COMPLETED = 'sg_calendar.event.update.completed';
}