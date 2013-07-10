<?php

namespace Sg\CalendarBundle\Model;

/**
 * Class EventManagerInterface
 *
 * Interface to be implemented by event managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to events should happen through this interface.
 *
 * @package Sg\CalendarBundle\Model
 */
interface EventManagerInterface
{
    /**
     * Returns a new empty event instance.
     *
     * @return EventInterface
     */
    public function newEvent();

    /**
     * Remove an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function removeEvent(EventInterface $event);

    /**
     * Update an event.
     *
     * @param EventInterface $event    An event instance
     * @param Boolean        $andFlush Whether to flush the changes (default true)
     *
     * @return void
     */
    public function updateEvent(EventInterface $event, $andFlush = true);

    /**
     * Find an event by the given criteria.
     *
     * @param array $criteria
     *
     * @return EventInterface
     */
    public function findEventBy(array $criteria);

    /**
     * Find all events by given calendar.
     *
     * @param CalendarInterface $calendar
     *
     * @return array The events
     */
    public function findEventsByCalendar(CalendarInterface $calendar);

    /**
     * Returns the events fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}