<?php

namespace Sg\CalendarBundle\Model;

use \DateTime;

/**
 * Class CalculationInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface CalculationInterface
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
     * Set recurrence.
     *
     * @param RecurrenceInterface $recurrence
     *
     * @return self
     */
    public function setRecurrence(RecurrenceInterface $recurrence);

    /**
     * Get recurrence.
     *
     * @return RecurrenceInterface
     */
    public function getRecurrence();
}