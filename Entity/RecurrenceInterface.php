<?php

namespace Sg\CalendarBundle\Entity;

/**
 * Class RecurrenceInterface
 *
 * @package Sg\CalendarBundle\Entity
 */
interface RecurrenceInterface
{
    //-------------------------------------------------
    // Specifies the most appropriate periods
    //-------------------------------------------------

    const PERIOD_DAILY   = 'day';
    const PERIOD_WEEKLY  = 'week';
    const PERIOD_MONTHLY = 'month';
    const PERIOD_YEARLY  = 'year';


    //-------------------------------------------------
    // Determines the day(s) of the week
    //-------------------------------------------------

    const WEEKDAY_NONE      = 'none';
    const WEEKDAY_MONDAY    = 'monday';
    const WEEKDAY_TUESDAY   = 'tuesday';
    const WEEKDAY_WEDNESDAY = 'wednesday';
    const WEEKDAY_THURSDAY  = 'thursday';
    const WEEKDAY_FRIDAY    = 'friday';
    const WEEKDAY_SATURDAY  = 'saturday';
    const WEEKDAY_SUNDAY    = 'sunday';
    const WEEKDAY_ALL       = 'all';
}