<?php

namespace Sg\CalendarBundle\Model;

/**
 * Class CalendarManagerInterface
 *
 * Interface to be implemented by calendar managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to calendars should happen through this interface.
 *
 * @package Sg\CalendarBundle\Model
 */
interface CalendarManagerInterface
{
    /**
     * Return a new empty calendar instance.
     *
     * @return CalendarInterface
     */
    public function newCalendar();

    /**
     * Remove a calendar.
     *
     * @param CalendarInterface $calendar
     *
     * @return void
     */
    public function removeCalendar(CalendarInterface $calendar);

    /**
     * Update a calendar.
     *
     * @param CalendarInterface $calendar A calendar instance
     * @param boolean           $andFlush Whether to flush the changes (default true)
     *
     * @return void
     */
    public function updateCalendar(CalendarInterface $calendar, $andFlush = true);

    /**
     * Find a calendar by the given criteria.
     *
     * @param array $criteria
     *
     * @return CalendarInterface
     */
    public function findCalendarBy(array $criteria);

    /**
     * Find all calendars.
     *
     * @return array The calendars
     */
    public function findCalendars();

    /**
     * Returns the calendars fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}