<?php

namespace Sg\CalendarBundle\Model;

use \DateTime;

/**
 * Class RecurrenceInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface RecurrenceInterface
{
    /**
     * Occurs every day.
     *
     * @var string
     */
    const PERIOD_DAILY   = 'daily';

    /**
     * Occurs every week.
     *
     * @var string
     */
    const PERIOD_WEEKLY  = 'weekly';

    /**
     * Occurs every month.
     *
     * @var string
     */
    const PERIOD_MONTHLY = 'monthly';

    /**
     * Occurs every year.
     *
     * @var string
     */
    const PERIOD_YEARLY  = 'yearly';


    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set period.
     *
     * @param string $period
     *
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setPeriod($period);

    /**
     * Get period.
     *
     * @return string
     */
    public function getPeriod();

    /**
     * Set multiple.
     *
     * @param integer $multiple
     *
     * @return self
     */
    public function setMultiple($multiple);

    /**
     * Get multiple.
     *
     * @return integer
     */
    public function getMultiple();

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
     * Add calculation.
     *
     * @param CalculationInterface $calculation
     *
     * @return self
     */
    public function addCalculation(CalculationInterface $calculation);

    /**
     * Remove calculation.
     *
     * @param CalculationInterface $calculation
     */
    public function removeCalculation(CalculationInterface $calculation);

    /**
     * Get calculations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalculations();

    /**
     * Set event.
     *
     * @param EventInterface $event
     *
     * @return self
     */
    public function setEvent(EventInterface $event);

    /**
     * Get event.
     *
     * @return EventInterface
     */
    public function getEvent();
}