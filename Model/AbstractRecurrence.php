<?php

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use \DateTime;

/**
 * Class AbstractRecurrence
 *
 * @ORM\MappedSuperclass
 * @Assert\Callback(methods={"isDailyValid"})
 *
 * @package Sg\CalendarBundle\Model
 */
class AbstractRecurrence implements RecurrenceInterface
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
     * @var EventInterface
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
     * The period-length.
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
     * @var DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=false)
     */
    protected $end;

    /**
     * The calculated events.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Sg\CalendarBundle\Model\CalculationInterface",
     *     mappedBy="recurrence",
     *     cascade={"persist"},
     *     orphanRemoval=true
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
        $this->multiple = 1;
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
    // RecurrenceInterface
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
    public function setPeriod($period)
    {
        if (!in_array($period, array(
                self::PERIOD_DAILY,
                self::PERIOD_WEEKLY,
                self::PERIOD_MONTHLY,
                self::PERIOD_YEARLY
            ))) {
            throw new \InvalidArgumentException("Invalid period!");
        }

        $this->period = $period;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * {@inheritdoc}
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMultiple()
    {
        return $this->multiple;
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
    public function addCalculation(CalculationInterface $calculation)
    {
        $this->calculations[] = $calculation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCalculation(CalculationInterface $calculation)
    {
        $this->calculations->removeElement($calculation);
    }

    /**
     * {@inheritdoc}
     */
    public function getCalculations()
    {
        return $this->calculations;
    }

    /**
     * {@inheritdoc}
     */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent()
    {
        return $this->event;
    }


    //-------------------------------------------------
    // Validate
    //-------------------------------------------------

    /**
     * @param ExecutionContextInterface $context
     */
    public function isDailyValid(ExecutionContextInterface $context)
    {
        if (null !== $this->getEvent()->getEnd()) {
            if (self::PERIOD_DAILY === $this->getPeriod()) {
                $context->addViolationAt('period', 'Das Ereignis ist bereits mehrtägig.', array(), null);
            }
        }
    }
}