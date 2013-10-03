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
use Sg\CalendarBundle\Model\EventInterface;

/**
 * Class EventData
 *
 * @package Sg\CalendarBundle\Event
 */
class EventData extends Event
{
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
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
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