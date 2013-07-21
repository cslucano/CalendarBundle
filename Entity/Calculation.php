<?php

namespace Sg\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use \DateTime;

/**
 * Class Calculation
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Calculation
{
    /**
     * The identifier.
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
     * @var Recurrence
     *
     * @ORM\ManyToOne(
     *     targetEntity="Recurrence",
     *     inversedBy="calculations"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $recurrence;

    /**
     * The new calculated start time of the event.
     *
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    protected $start;


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
     * Set start.
     *
     * @param DateTime $start
     *
     * @return Calculation
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set recurrence.
     *
     * @param Recurrence $recurrence
     *
     * @return Calculation
     */
    public function setRecurrence(Recurrence $recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get recurrence.
     *
     * @return Recurrence
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }
}