<?php

namespace Sg\CalendarBundle\Manager;

use Sg\CalendarBundle\Entity\EventInterface;

/**
 * Class EventManagerInterface
 *
 * Interface to be implemented by event managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to events should happen through this interface.
 *
 * @package Sg\CalendarBundle\Manager
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
     * Removes an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function removeEvent(EventInterface $event);

    /**
     * Updates an event.
     *
     * @param EventInterface $event    An EventInterface instance
     * @param Boolean        $andFlush Whether to flush the changes (default true)
     *
     * @return void
     */
    public function updateEvent(EventInterface $event, $andFlush = true);

    /**
     * Finds one event by the given criteria.
     *
     * @param array $criteria
     *
     * @return EventInterface
     */
    public function findEventBy(array $criteria);

    /**
     * Returns a collection with all event instances.
     *
     * @return \Traversable
     */
    public function findEvents();

    /**
     * Returns the event's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}