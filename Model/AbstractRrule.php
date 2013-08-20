<?php

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Class AbstractRrule
 *
 * @ORM\MappedSuperclass
 *
 * @package Sg\CalendarBundle\Model
 */
class AbstractRrule implements RruleInterface
{
    /**
     * Identifier of the rrule.
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The event.
     *
     * @var EventInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Sg\CalendarBundle\Model\EventInterface",
     *     inversedBy="rrules"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $event;

    /**
     * A RRule string.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $rule;

    /**
     * The recurrence frequency.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $freq;

    /**
     * The recurrence start.
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dtstart;

    /**
     * Specify the limit of the recurrence.
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $until;

    /**
     * How many occurences will be generated.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $count;

    /**
     * The interval between each freq iteration.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $ival;

    /**
     * The week start day.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $wkst;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $byweekday;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $bymonth;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $bysetpos;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $bymonthday;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $byyearday;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $byweekno;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $byhour;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $byminute;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $bysecond;

    /**
     * The list of occurrences from this rrule.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Sg\CalendarBundle\Model\OccurrenceInterface",
     *     mappedBy="rrule",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     */
    protected $occurrences;


    //-------------------------------------------------
    // Ctor. && toString
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->byweekday = array();
        $this->bymonth = array();
        $this->bysetpos = array();
        $this->bymonthday = array();
        $this->byyearday = array();
        $this->byweekno = array();
        $this->byhour = array();
        $this->byminute = array();
        $this->bysecond = array();
        $this->occurrences = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'RRULE #' . $this->id;
    }


    //-------------------------------------------------
    // RruleInterface
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
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * {@inheritdoc}
     */
    public function setFreq($freq)
    {
        $this->freq = $freq;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * {@inheritdoc}
     */
    public function setDtstart($dtstart)
    {
        $this->dtstart = $dtstart;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDtstart()
    {
        return $this->dtstart;
    }

    /**
     * {@inheritdoc}
     */
    public function setUntil($until)
    {
        $this->until = $until;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * {@inheritdoc}
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function setIval($interval)
    {
        $this->ival = $interval;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIval()
    {
        return $this->ival;
    }

    /**
     * {@inheritdoc}
     */
    public function setWkst($wkst)
    {
        $this->wkst = $wkst;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWkst()
    {
        return $this->wkst;
    }

    /**
     * {@inheritdoc}
     */
    public function addByweekday($weekday)
    {
        $this->byweekday[] = $weekday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setByweekday(array $byweekday)
    {
        $this->byweekday = $byweekday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByweekday()
    {
        return $this->byweekday;
    }

    /**
     * {@inheritdoc}
     */
    public function addBymonth($month)
    {
        $this->bymonth[] = $month;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBymonth(array $bymonth)
    {
        $this->bymonth = $bymonth;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBymonth()
    {
        return $this->bymonth;
    }

    /**
     * {@inheritdoc}
     */
    public function addBysetpos($setpos)
    {
        $this->bysetpos[] = $setpos;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBysetpos(array $bysetpos)
    {
        $this->bysetpos = $bysetpos;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBysetpos()
    {
        return $this->bysetpos;
    }

    /**
     * {@inheritdoc}
     */
    public function addBymonthday($monthday)
    {
        $this->bymonthday[] = $monthday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBymonthday(array $bymonthday)
    {
        $this->bymonthday = $bymonthday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBymonthday()
    {
        return $this->bymonthday;
    }

    /**
     * {@inheritdoc}
     */
    public function addByyearday($yearday)
    {
        $this->byyearday[] = $yearday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setByyearday(array $byyearday)
    {
        $this->byyearday = $byyearday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByyearday()
    {
        return $this->byyearday;
    }

    /**
     * {@inheritdoc}
     */
    public function addByweekno($weekno)
    {
        $this->byweekno[] = $weekno;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setByweekno(array $byweekno)
    {
        $this->byweekno = $byweekno;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByweekno()
    {
        return $this->byweekno;
    }

    /**
     * {@inheritdoc}
     */
    public function addByhour($hour)
    {
        $this->byhour[] = $hour;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setByhour(array $byhour)
    {
        $this->byhour = $byhour;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByhour()
    {
        return $this->byhour;
    }

    /**
     * {@inheritdoc}
     */
    public function addByminute($minute)
    {
        $this->byminute[] = $minute;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setByminute(array $byminute)
    {
        $this->byminute = $byminute;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByminute()
    {
        return $this->byminute;
    }

    /**
     * {@inheritdoc}
     */
    public function addBySecond($second)
    {
        $this->bysecond[] = $second;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBysecond(array $bysecond)
    {
        $this->bysecond = $bysecond;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBysecond()
    {
        return $this->bysecond;
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

    /**
     * {@inheritdoc}
     */
    public function addOccurrence(OccurrenceInterface $occurrence)
    {
        $occurrence->setRrule($this);
        $this->occurrences[] = $occurrence;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOccurrence(OccurrenceInterface $occurrence)
    {
        $this->occurrences->removeElement($occurrence);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOccurrences()
    {
        return $this->occurrences;
    }
}