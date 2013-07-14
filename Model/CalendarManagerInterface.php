<?php

namespace Sg\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

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
     * Find all calendars by the given visibility.
     *
     * @param boolean       $visible The visibility of the calendar
     * @param integer       $max     Limit the number of results returned from the query
     * @param UserInterface $user    If a user passed, this is an exclusion criteria
     *
     * @return array The calendars
     */
    public function findCalendarsByVisible($visible, $max, UserInterface $user = null);

    /**
     * Find all calendars by the given user.
     *
     * @param UserInterface $user
     *
     * @return array The calendars
     */
    public function findCalendarsByUser(UserInterface $user);

    /**
     * Returns the calendars fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}