<?php

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
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
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