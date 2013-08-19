<?php

namespace Sg\CalendarBundle\Model;

use DateTime;

/**
 * Class OccurrenceInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface OccurrenceInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set start.
     *
     * @param DateTime $start
     *
     * @return self
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
     * @return self
     */
    public function setEnd($end);

    /**
     * Get end.
     *
     * @return DateTime
     */
    public function getEnd();

    /**
     * Set rrule.
     *
     * @param RruleInterface $rrule
     *
     * @return self
     */
    public function setRrule(RruleInterface $rrule);

    /**
     * Get rrule.
     *
     * @return RruleInterface
     */
    public function getRrule();
}