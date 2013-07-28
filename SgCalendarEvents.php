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
     * @var string
     */
    const EVENT_CREATE_SUCCESS = 'sg_calendar.event.create.success';

    /**
     * @var string
     */
    const EVENT_UPDATE_SUCCESS = 'sg_calendar.event.update.success';

    /**
     * @var string
     */
    const EVENT_REMOVE_SUCCESS = 'sg_calendar.event.remove.success';

    /**
     * @var string
     */
    const EVENT_CREATE_COMPLETED = 'sg_calendar.event.create.completed';

    /**
     * @var string
     */
    const EVENT_UPDATE_COMPLETED = 'sg_calendar.event.update.completed';

    /**
     * @var string
     */
    const EVENT_REMOVE_COMPLETED = 'sg_calendar.event.remove.completed';

    /**
     * @var string
     */
    const EVENT_CALCULATE_RECURRENCES = 'sg_calendar.event.calculate.recurrences';

    /**
     * @var string
     */
    const CALENDAR_CREATE_SUCCESS = 'sg_calendar.calendar.create.success';

    /**
     * @var string
     */
    const CALENDAR_UPDATE_SUCCESS = 'sg_calendar.calendar.update.success';

    /**
     * @var string
     */
    const CALENDAR_REMOVE_SUCCESS = 'sg_calendar.calendar.remove.success';

    /**
     * @var string
     */
    const CALENDAR_CREATE_COMPLETED = 'sg_calendar.calendar.create.completed';

    /**
     * @var string
     */
    const CALENDAR_UPDATE_COMPLETED = 'sg_calendar.calendar.update.completed';

    /**
     * @var string
     */
    const CALENDAR_REMOVE_COMPLETED = 'sg_calendar.calendar.remove.completed';
}