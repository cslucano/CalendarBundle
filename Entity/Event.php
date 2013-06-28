<?php

namespace Sg\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;

/**
 * Class Event
 *
 * @ORM\MappedSuperclass
 *
 * @package Sg\CalendarBundle\Entity
 */
abstract class Event implements EventInterface
{
    /**
     * Uniquely identifies the given event.
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The text on an event's element.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * This property affects whether an event's time is shown.
     *
     * @var boolean
     *
     * @ORM\Column(name="allDay", type="boolean", nullable=true)
     */
    private $allDay;

    /**
     * The date/time an event begins.
     *
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    private $start;

    /**
     * The date/time an event ends.
     *
     * @var DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * A URL that will be visited when this event is clicked by the user.
     *
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * A CSS class (or array of classes) that will be attached to this event's element.
     *
     * @var string
     *
     * @ORM\Column(name="className", type="string", length=255, nullable=true)
     */
    private $className;

    /**
     * This determines if the events can be dragged and resized.
     *
     * @var boolean
     *
     * @ORM\Column(name="editable", type="boolean", nullable=true)
     */
    private $editable;

    /**
     * Sets an event's background  - and - border color.
     *
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * Sets an event's background color.
     *
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=255, nullable=true)
     */
    private $bgColor;

    /**
     * Sets an event's border color.
     *
     * @var string
     *
     * @ORM\Column(name="borderColor", type="string", length=255, nullable=true)
     */
    private $borderColor;

    /**
     * Sets an event's text color.
     *
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=255, nullable=true)
     */
    private $textColor;

    /**
     * Create datetime.
     *
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;


    //-------------------------------------------------
    // Ctor. && toString
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->allDay = true;
        $this->editable = false;
        $this->start = new DateTime();
        $this->end = new DateTime();
        $this->createdAt = new DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }


    //-------------------------------------------------
    // Getters && Setters
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
     * Set title.
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set allDay.
     *
     * @param boolean $allDay
     *
     * @return Event
     */
    public function setAllDay($allDay)
    {
        $this->allDay = (boolean) $allDay;

        return $this;
    }

    /**
     * Get allDay.
     *
     * @return boolean 
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * Set start.
     *
     * @param DateTime $start
     *
     * @return Event
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
     * Set end.
     *
     * @param DateTime $end
     *
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end.
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Event
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set className.
     *
     * @param string $className
     *
     * @return Event
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className.
     *
     * @return string 
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set editable.
     *
     * @param boolean $editable
     *
     * @return Event
     */
    public function setEditable($editable)
    {
        $this->editable = (boolean) $editable;

        return $this;
    }

    /**
     * Get editable.
     *
     * @return boolean 
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return Event
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set bgColor.
     *
     * @param string $bgColor
     *
     * @return Event
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get bgColor.
     *
     * @return string 
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Set borderColor.
     *
     * @param string $borderColor
     *
     * @return Event
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    /**
     * Get borderColor.
     *
     * @return string 
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * Set textColor.
     *
     * @param string $textColor
     *
     * @return Event
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Get textColor.
     *
     * @return string 
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Convert Event to an array.
     *
     * @return array $event
     */
    public function toArray()
    {
        $event = array();

        $event['id'] = $this->id;
        $event['title'] = $this->title;
        $event['allDay'] = $this->allDay;
        $event['start'] = $this->start->format(DATE_ISO8601);

        if ($this->end !== null) {
            $event['end'] = $this->end->format(DATE_ISO8601);
        }

        if ($this->url !== null) {
            $event['url'] = $this->url;
        }

        if ($this->className !== null) {
            $event['className'] = $this->className;
        }

        $event['editable'] = $this->editable;

        if ($this->color !== null) {
            $event['color'] = $this->color;
        }

        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
        }

        if ($this->borderColor !== null) {
            $event['borderColor'] = $this->borderColor;
        }

        if ($this->textColor !== null) {
            $event['textColor'] = $this->textColor;
        }

        return $event;
    }
}
