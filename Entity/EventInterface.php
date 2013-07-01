<?php

namespace Sg\CalendarBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

/**
 * Class EventInterface
 *
 * Any event to be used by Sg\CalendarBundle must implement this interface.
 *
 * @package Sg\CalendarBundle\Entity
 */
interface EventInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set allDay.
     *
     * @param boolean $allDay
     *
     * @return Event
     */
    public function setAllDay($allDay);

    /**
     * Get allDay.
     *
     * @return boolean
     */
    public function getAllDay();

    /**
     * Set start.
     *
     * @param DateTime $start
     *
     * @return Event
     */
    public function setStart($start);

    /**
     * Get start.
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Set end.
     *
     * @param DateTime $end
     *
     * @return Event
     */
    public function setEnd($end);

    /**
     * Get end.
     *
     * @return DateTime
     */
    public function getEnd();

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Event
     */
    public function setUrl($url);

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set className.
     *
     * @param string $className
     *
     * @return Event
     */
    public function setClassName($className);

    /**
     * Get className.
     *
     * @return string
     */
    public function getClassName();

    /**
     * Set editable.
     *
     * @param boolean $editable
     *
     * @return Event
     */
    public function setEditable($editable);

    /**
     * Get editable.
     *
     * @return boolean
     */
    public function getEditable();

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return Event
     */
    public function setColor($color);

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor();

    /**
     * Set bgColor.
     *
     * @param string $bgColor
     *
     * @return Event
     */
    public function setBgColor($bgColor);

    /**
     * Get bgColor.
     *
     * @return string
     */
    public function getBgColor();

    /**
     * Set borderColor.
     *
     * @param string $borderColor
     *
     * @return Event
     */
    public function setBorderColor($borderColor);

    /**
     * Get borderColor.
     *
     * @return string
     */
    public function getBorderColor();

    /**
     * Set textColor.
     *
     * @param string $textColor
     *
     * @return Event
     */
    public function setTextColor($textColor);

    /**
     * Get textColor.
     *
     * @return string
     */
    public function getTextColor();

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return Event
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set createdBy.
     *
     * @param UserInterface $createdBy
     *
     * @return Event
     */
    public function setCreatedBy(UserInterface $createdBy);

    /**
     * Get createdBy.
     *
     * @return UserInterface
     */
    public function getCreatedBy();
}