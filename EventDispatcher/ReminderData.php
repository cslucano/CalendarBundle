<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\EventDispatcher;

use Sg\CalendarBundle\Model\ReminderInterface;
use Sg\CalendarBundle\Model\EventInterface;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ReminderData
 *
 * @package Sg\CalendarBundle\EventDispatcher
 */
class ReminderData extends Event
{
    /**
     * @var ReminderInterface
     */
    private $reminder;

    /**
     * @var EventInterface
     */
    private $event;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var Response
     */
    private $response;


    /**
     * Ctor.
     *
     * @param ReminderInterface $reminder A ReminderInterface
     * @param EventInterface    $event    An EventInterface
     * @param UserInterface     $user     The current User
     */
    public function __construct(ReminderInterface $reminder, EventInterface $event, UserInterface $user)
    {
        $this->reminder = $reminder;
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Get reminder.
     *
     * @return ReminderInterface
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * Get event.
     *
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Get user.
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set response.
     *
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get response.
     *
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}