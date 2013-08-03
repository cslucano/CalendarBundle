<?php

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use \DateTime;

/**
 * Class AbstractCalculation
 *
 * @ORM\MappedSuperclass
 *
 * @package Sg\CalendarBundle\Model
 */
class AbstractCalculation implements CalculationInterface
{
    /**
     * Identifier of the calculation.
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The recurrence.
     *
     * @var RecurrenceInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Sg\CalendarBundle\Model\RecurrenceInterface",
     *     inversedBy="calculations"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $recurrence;

    /**
     * The calculated start time of the event.
     *
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    protected $start;

    /**
     * The calculated end time of the event.
     *
     * @var DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    protected $end;


    //-------------------------------------------------
    // CalculationInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecurrence(RecurrenceInterface $recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }
}