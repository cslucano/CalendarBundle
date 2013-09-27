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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractReminder
 *
 * @ORM\MappedSuperclass
 *
 * @package Sg\CalendarBundle\Model
 */
abstract class AbstractReminder implements ReminderInterface
{
    /**
     * Identifier of the reminder.
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The method used by this reminder.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $method;

    /**
     * The event.
     *
     * @var EventInterface
     *
     * @ORM\ManyToOne(
     *     targetEntity="Sg\CalendarBundle\Model\EventInterface",
     *     inversedBy="reminders"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    protected $event;

    /**
     * Number of minutes before the start of the event when the reminder should trigger.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    protected $minutes;


    //-------------------------------------------------
    // Ctor. && toString
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->method = self::METHOD_POPUP;
        $this->minutes = 30;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }


    //-------------------------------------------------
    // ReminderInterface
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
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
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
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinutes()
    {
        return $this->minutes;
    }
}