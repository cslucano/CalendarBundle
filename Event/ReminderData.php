<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Sg\CalendarBundle\Model\ReminderInterface;
use Sg\CalendarBundle\Model\EventInterface;

/**
 * Class ReminderData
 *
 * @package Sg\CalendarBundle\Event
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
     * @var Response
     */
    private $response;


    /**
     * Ctor.
     *
     * @param ReminderInterface $reminder A ReminderInterface
     * @param EventInterface    $event    An EventInterface
     */
    public function __construct(ReminderInterface $reminder, EventInterface $event)
    {
        $this->reminder = $reminder;
        $this->event = $event;
    }

    /**
     * @return ReminderInterface
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}