<?php

namespace Sg\CalendarBundle\Generator;

use Sg\CalendarBundle\Model\EventInterface;
use Sg\CalendarBundle\Model\RecurrenceInterface;
use Sg\CalendarBundle\Model\ModelManagerInterface;
use \DatePeriod;
use \DateTime;
use \DateInterval;

/**
 * Class CalculateRecurrences
 *
 * @package Sg\CalendarBundle\Generator
 */
class CalculateRecurrences
{
    /**
     * @var ModelManagerInterface
     */
    private $calculationManager;

    /**
     * @var DateTime
     */
    private $eventStart;

    /**
     * @var DateTime
     */
    private $eventEnd;

    /**
     * @var DateInterval
     */
    private $interval;

    /**
     * @var integer
     */
    private $counter;

    /**
     * @var DateTime
     */
    private $recurrenceEnd;

    /**
     * @var integer
     */
    private $recurrenceMultiple;

    /**
     * @var array
     */
    private $starts;

    /**
     * @var array
     */
    private $ends;


    /**
     * Ctor.
     *
     * @param ModelManagerInterface $calculationManager A ModelManagerInterface
     */
    public function __construct(ModelManagerInterface $calculationManager)
    {
        $this->calculationManager = $calculationManager;
        $this->starts = array();
        $this->ends = array();
    }

    /**
     * Calculate recurrences.
     *
     * @param EventInterface $event
     */
    public function calc(EventInterface $event)
    {
        $this->initEvent($event);

        /**
         * @var \Sg\CalendarBundle\Entity\Recurrence $recurrence
         */
        foreach ($event->getRecurrences() as $recurrence) {
            $this->initRecurrence($recurrence);

            $pStarts = new DatePeriod($this->eventStart, $this->interval, $this->recurrenceEnd, DatePeriod::EXCLUDE_START_DATE);
            $this->setStarts($pStarts);

            if (null !== $this->eventEnd) {
                $pEnds = new DatePeriod($this->eventEnd, $this->interval, $this->recurrenceEnd, DatePeriod::EXCLUDE_START_DATE);
                $this->setEnds($pEnds);
            }

            $this->setCounter();
            $this->saveCalcs($recurrence);
        }
    }


    //-------------------------------------------------
    // Init
    //-------------------------------------------------

    /**
     * Init event.
     *
     * @param EventInterface $event
     */
    private function initEvent(EventInterface $event)
    {
        $this->eventStart = $event->getStart();
        $this->eventEnd = $event->getEnd();
    }

    /**
     * Init recurrence.
     *
     * @param RecurrenceInterface $recurrence
     */
    private function initRecurrence(RecurrenceInterface $recurrence)
    {
        $this->recurrenceEnd = $recurrence->getEnd();
        $this->recurrenceMultiple = $recurrence->getMultiple();
        $this->counter = 0;
        unset($this->starts);
        unset($this->ends);

        if (RecurrenceInterface::PERIOD_DAILY === $recurrence->getPeriod()) {
            $this->interval = new \DateInterval('P'.$this->recurrenceMultiple.'D');
        }

        if (RecurrenceInterface::PERIOD_WEEKLY === $recurrence->getPeriod()) {
            $this->interval = new \DateInterval('P'.$this->recurrenceMultiple.'W');
        }

        if (RecurrenceInterface::PERIOD_MONTHLY === $recurrence->getPeriod()) {
            $this->interval = new \DateInterval('P'.$this->recurrenceMultiple.'M');
        }

        if (RecurrenceInterface::PERIOD_YEARLY === $recurrence->getPeriod()) {
            $this->interval = new \DateInterval('P'.$this->recurrenceMultiple.'Y');
        }
    }


    //-------------------------------------------------
    // Save
    //-------------------------------------------------

    /**
     * Save calculated events.
     *
     * @param RecurrenceInterface $recurrence
     */
    private function saveCalcs(RecurrenceInterface $recurrence)
    {
        foreach ($recurrence->getCalculations() as $calculation) {
            $this->calculationManager->remove($calculation);
        }

        if (0 === $recurrence->getCalculations()->count()) {
            /**
             * @var \Sg\CalendarBundle\Model\CalculationInterface[] $calc
             */
            for ($i = 0; $i < $this->counter; $i++) {
                $calc[$i] = $this->calculationManager->create();

                $calc[$i]->setStart($this->starts[$i]);
                if ( (isset($this->ends) &&  count($this->ends) > 0) ) {
                    $calc[$i]->setEnd($this->ends[$i]);
                } else {
                    $calc[$i]->setEnd(null);
                }

                $recurrence->addCalculation($calc[$i]);
            }
        }
    }


    //-------------------------------------------------
    // Setters
    //-------------------------------------------------

    /**
     * Set counter.
     */
    private function setCounter()
    {
        $this->counter = 0;

        if ( (isset($this->ends) &&  count($this->ends) > 0) ) {
            if (count($this->starts) < count($this->ends)) {
                $this->counter = count($this->starts);
            } else {
                $this->counter = count($this->ends);
            }
        } else {
            $this->counter = count($this->starts);
        }
    }

    /**
     * Set ends.
     *
     * @param DatePeriod $pEnds
     *
     * @return $this
     */
    public function setEnds(DatePeriod $pEnds)
    {
        unset($this->ends);

        foreach ($pEnds as $pEnd) {
            $this->ends[] = $pEnd;
        }

        return $this;
    }

    /**
     * Set starts.
     *
     * @param DatePeriod $pStarts
     *
     * @return $this
     */
    public function setStarts(DatePeriod $pStarts)
    {
        unset($this->starts);

        foreach ($pStarts as $pStart) {
            $this->starts[] = $pStart;
        }

        return $this;
    }
}