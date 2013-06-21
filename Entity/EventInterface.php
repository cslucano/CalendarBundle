<?php

namespace Sg\CalendarBundle\Entity;

use \DateTime;

/**
 * Class EventInterface
 *
 * Any event to be used by Sg\CalendarBundle must implement this interface.
 *
 * @package Sg\CalendarBundle\Entity
 */
interface EventInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set allDay.
     *
     * @param boolean $allDay
     *
     * @return Event
     */
    public function setAllDay($allDay);

    /**
     * Get allDay.
     *
     * @return boolean
     */
    public function getAllDay();

    /**
     * Set start.
     *
     * @param DateTime $start
     *
     * @return Event
     */
    public function setStart($start);

    /**
     * Get start.
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Set end.
     *
     * @param DateTime $end
     *
     * @return Event
     */
    public function setEnd($end);

    /**
     * Get end.
     *
     * @return DateTime
     */
    public function getEnd();

    /**
     * Convert calendar event details to an array
     *
     * @return array $event
     */
    public function toArray();
}