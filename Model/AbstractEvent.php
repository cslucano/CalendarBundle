<?php

namespace Sg\CalendarBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

/**
 * Class AbstractEvent
 *
 * @ORM\MappedSuperclass
 * @Assert\Callback(methods={"isEndValid"})
 *
 * @package Sg\CalendarBundle\Model
 */
abstract class AbstractEvent implements EventInterface
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
    protected $id;

    /**
     * The text on an event's element.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * This property affects whether an event's time is shown.
     *
     * @var boolean
     *
     * @ORM\Column(name="allDay", type="boolean", nullable=true)
     */
    protected $allDay;

    /**
     * The date/time an event begins.
     *
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    protected $start;

    /**
     * The date/time an event ends.
     *
     * @var DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    protected $end;

    /**
     * A URL that will be visited when this event is clicked by the user.
     *
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * A CSS class (or array of classes) that will be attached to this event's element.
     *
     * @var string
     *
     * @ORM\Column(name="className", type="string", length=255, nullable=true)
     */
    protected $className;

    /**
     * This determines if the events can be dragged and resized.
     *
     * @var boolean
     *
     * @ORM\Column(name="editable", type="boolean", nullable=true)
     */
    protected $editable;

    /**
     * Sets an event's background  - and - border color.
     *
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    protected $color;

    /**
     * Sets an event's background color.
     *
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=255, nullable=true)
     */
    protected $bgColor;

    /**
     * Sets an event's border color.
     *
     * @var string
     *
     * @ORM\Column(name="borderColor", type="string", length=255, nullable=true)
     */
    protected $borderColor;

    /**
     * Sets an event's text color.
     *
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=255, nullable=true)
     */
    protected $textColor;

    /**
     * Create datetime.
     *
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Update datetime.
     *
     * @var DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * The creator and owner of the event.
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
     * The user of the last change of the event.
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
        $this->allDay = true;
        $this->editable = false;
        $this->start = new DateTime();
        $this->end = new DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }


    //-------------------------------------------------
    // EventInterface
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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setAllDay($allDay)
    {
        $this->allDay = (boolean) $allDay;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDay()
    {
        return $this->allDay;
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
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * {@inheritdoc}
     */
    public function setEditable($editable)
    {
        $this->editable = (boolean) $editable;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     * {@inheritdoc}
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * {@inheritdoc}
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * {@inheritdoc}
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTextColor()
    {
        return $this->textColor;
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


    //-------------------------------------------------
    // Validate
    //-------------------------------------------------

    /**
     * @param ExecutionContextInterface $context
     */
    public function isEndValid(ExecutionContextInterface $context)
    {
        $isValid = $this->start <= $this->end;

        if (!$isValid) {
            $context->addViolationAt('end', 'calendar.event.end_callback', array(), null);
        }
    }
}
