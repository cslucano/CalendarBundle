<?php

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

/**
 * Class AbstractCalendar
 *
 * @ORM\MappedSuperclass
 *
 * @package Sg\CalendarBundle\Model
 */
class AbstractCalendar implements CalendarInterface
{
    /**
     * Uniquely identifies the given calendar.
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The name of the calendar.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * The gcal. events url.
     * e.g. https://www.google.com/calendar/feeds/german__de%40holiday.calendar.google.com/public/basic
     *
     * @var string
     *
     * @ORM\Column(name="eventsUrl", type="string", length=255, nullable=true)
     */
    protected $eventsUrl;

    /**
     * The events.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Sg\CalendarBundle\Model\EventInterface",
     *     mappedBy="calendar",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     */
    protected $events;

    /**
     * Create datetime.
     *
     * @var DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Update datetime.
     *
     * @var DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * The creator and owner of the calendar.
     *
     * @var UserInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Symfony\Component\Security\Core\User\UserInterface"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $createdBy;

    /**
     * The user of the last change of the calendar.
     *
     * @var UserInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Symfony\Component\Security\Core\User\UserInterface"
     * )
     * @JoinColumn(
     *     nullable=false
     * )
     */
    protected $updatedBy;


    //-------------------------------------------------
    // Ctor. && toString
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }


    //-------------------------------------------------
    // CalendarInterface
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setEventsUrl($eventsUrl)
    {
        $this->eventsUrl = $eventsUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventsUrl()
    {
        return $this->eventsUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEvent(EventInterface $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedBy(UserInterface $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedBy(UserInterface $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}