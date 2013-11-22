<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

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
     * Identifier of the calendar.
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
     * Description of the calendar.
     *
     * @var text
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * The gcal. events url of the calendar.
     * e.g. https://www.google.com/calendar/feeds/german__de%40holiday.calendar.google.com/public/basic
     *
     * @var string
     *
     * @ORM\Column(name="eventsUrl", type="string", length=255, nullable=true)
     */
    protected $eventsUrl;

    /**
     * The events of the calendar.
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
     * Determines whether the calendar is private or public.
     *
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=true)
     */
    protected $visible;

    /**
     * Many calendars are favorited by many users.
     *
     * @ORM\ManyToMany(
     *     targetEntity="Symfony\Component\Security\Core\User\UserInterface",
     *     mappedBy="favorites"
     * )
     */
    protected $userFavorites;

    /**
     * Creation time of the calendar.
     *
     * @var DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Last modification time of the calendar.
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
        $this->visible = true;
        $this->userFavorites = new ArrayCollection();
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
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
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

        return $this;
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
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * {@inheritdoc}
     */
    public function addUserFavorite(UserInterface $userFavorite)
    {
        $this->userFavorites[] = $userFavorite;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeUserFavorite(UserInterface$userFavorite)
    {
        $this->userFavorites->removeElement($userFavorite);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserFavorites()
    {
        return $this->userFavorites;
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