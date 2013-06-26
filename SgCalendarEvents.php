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
}