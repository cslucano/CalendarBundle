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

use Sg\RruleBundle\Model\RruleInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * Class EventInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface EventInterface
{
    /**
     * The event is confirmed. This is the default status.
     *
     * @var string
     */
    const STATUS_CONFIRMED = 'CONFIRMED';

    /**
     * The event is tentatively confirmed.
     *
     * @var string
     */
    const STATUS_TENTATIVE = 'TENTATIVE';

    /**
     * The event is cancelled.
     *
     * @var string
     */
    const STATUS_CANCELLED = 'CANCELLED';


    /**
     * Get id.
     *
     * @return mixed
     */
    public function getId();

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setStart(DateTime $start);

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
     * @return self
     */
    public function setEnd(DateTime $end = null);

    /**
     * Get end.
     *
     * @return DateTime
     */
    public function getEnd();

    /**
     * Set rrule.
     *
     * @param RruleInterface $rrule
     *
     * @return self
     */
    public function setRrule(RruleInterface $rrule = null);

    /**
     * Get rrule.
     *
     * @return RruleInterface
     */
    public function getRrule();

    /**
     * Set description.
     *
     * @param text $description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return text
     */
    public function getDescription();

    /**
     * Set calendar.
     *
     * @param CalendarInterface $calendar
     *
     * @return self
     */
    public function setCalendar(CalendarInterface $calendar);

    /**
     * Get calendar.
     *
     * @return CalendarInterface
     */
    public function getCalendar();

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setTextColor($textColor);

    /**
     * Get textColor.
     *
     * @return string
     */
    public function getTextColor();

    /**
     * Set attendable.
     *
     * @param boolean $attendable
     *
     * @return self
     */
    public function setAttendable($attendable);

    /**
     * Get attendable.
     *
     * @return boolean
     */
    public function getAttendable();

    /**
     * Get attendees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttendees();

    /**
     * Has attendee.
     *
     * @param UserInterface $user
     *
     * @return boolean
     */
    public function hasAttendee(UserInterface $user);

    /**
     * Add reminder.
     *
     * @param ReminderInterface $reminder
     *
     * @return self
     */
    public function addReminder(ReminderInterface $reminder);

    /**
     * Remove reminder.
     *
     * @param ReminderInterface $reminder
     *
     * @return self
     */
    public function removeReminder(ReminderInterface $reminder);

    /**
     * Get reminders.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReminders();

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set updatedAt.
     *
     * @param DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Get updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Set createdBy.
     *
     * @param UserInterface $createdBy
     *
     * @return self
     */
    public function setCreatedBy(UserInterface $createdBy);

    /**
     * Get createdBy.
     *
     * @return UserInterface
     */
    public function getCreatedBy();

    /**
     * Set updatedBy.
     *
     * @param UserInterface $updatedBy
     *
     * @return self
     */
    public function setUpdatedBy(UserInterface $updatedBy);

    /**
     * Get updatedBy.
     *
     * @return UserInterface
     */
    public function getUpdatedBy();
}