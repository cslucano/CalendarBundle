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
     * Whether an event occurs at a specific time-of-day.
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
     * @ORM\Column(name="end", type="datetime", nullable=false)
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
     * Overrides the master editable option for this single event.
     *
     * @var boolean
     *
     * @ORM\Column(name="editable", type="boolean", nullable=true)
     */
    private $editable;

    /**
     * Sets an event's background and border color just like the calendar-wide eventColor option.
     *
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * Sets an event's background color just like the calendar-wide eventBackgroundColor option.
     *
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=255, nullable=true)
     */
    private $bgColor;

    /**
     * Sets an event's border color just like the the calendar-wide eventBorderColor option.
     *
     * @var string
     *
     * @ORM\Column(name="borderColor", type="string", length=255, nullable=true)
     */
    private $borderColor;

    /**
     * Sets an event's text color just like the calendar-wide eventTextColor option.
     *
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=255, nullable=true)
     */
    private $textColor;


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
     * Convert calendar event details to an array
     *
     * @return array $event
     */
    public function toArray()
    {
        $event = array();

        if ($this->id !== null) {
            $event['id'] = $this->id;
        }

        $event['title'] = $this->title;
        $event['start'] = $this->start->format("Y-m-d\TH:i:sP");

        if ($this->url !== null) {
            $event['url'] = $this->url;
        }

        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }

        if ($this->color !== null) {
            $event['textColor'] = $this->color;
        }

        if ($this->className !== null) {
            $event['className'] = $this->className;
        }

        if ($this->end !== null) {
            $event['end'] = $this->end->format("Y-m-d\TH:i:sP");
        }

        $event['allDay'] = $this->allDay;

        return $event;
    }
}
