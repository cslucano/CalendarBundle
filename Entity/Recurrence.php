<?php

namespace Sg\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Sg\CalendarBundle\Model\RecurrenceInterface;
use Sg\CalendarBundle\Model\EventInterface;

/**
 * Class Recurrence
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Recurrence implements RecurrenceInterface
{
    /**
     * Identifier of the recurrence.
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The recurring event.
     *
     * @var \Sg\CalendarBundle\Model\EventInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Sg\CalendarBundle\Model\EventInterface",
     *     inversedBy="recurrences"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $event;

    /**
     * @var string
     *
     * @ORM\Column(name="weekday", type="string", length=255, nullable=false)
     */
    protected $weekday;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer", nullable=false)
     */
    protected $month;

    /**
     * Specifies the period.
     *
     * @var string
     *
     * @ORM\Column(name="period", type="string", length=255, nullable=false)
     */
    protected $period;

    /**
     * Specifies how many intervals of Period-length are between occurrences
     * (i.e., every 4 days, every 3 weeks, or every 6 months).
     *
     * @var integer
     *
     * @ORM\Column(name="multiple", type="integer", nullable=false)
     */
    protected $multiple;

    /**
     * Date on which recurrence expires.
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * The calculated events.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Calculation",
     *     mappedBy="recurrence"
     * )
     */
    protected $calculations;


    //-------------------------------------------------
    // Ctor. && toString
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->month = '0';
        $this->multiple = '0';
        $this->calculations = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Recurrence #' . $this->id;
    }


    //-------------------------------------------------
    // Getters and Setters
    //-------------------------------------------------

    /**
     * Get id.
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set weekday.
     *
     * @param string $weekday
     *
     * @return Recurrence
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday.
     *
     * @return string 
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * Set month.
     *
     * @param integer $month
     *
     * @return Recurrence
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month.
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set period.
     *
     * @param string $period
     *
     * @return Recurrence
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period.
     *
     * @return string 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set multiple.
     *
     * @param integer $multiple
     *
     * @return Recurrence
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple.
     *
     * @return integer 
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set event.
     *
     * @param EventInterface $event
     *
     * @return Recurrence
     */
    public function setEvent(EventInterface $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end
     *
     * @return Recurrence
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Add calculation.
     *
     * @param Calculation $calculation
     *
     * @return Recurrence
     */
    public function addCalculation(Calculation $calculation)
    {
        $this->calculations[] = $calculation;

        return $this;
    }

    /**
     * Remove calculation.
     *
     * @param Calculation $calculation
     */
    public function removeCalculation(Calculation $calculation)
    {
        $this->calculations->removeElement($calculation);
    }

    /**
     * Get calculations.
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalculations()
    {
        return $this->calculations;
    }
}