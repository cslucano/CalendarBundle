<?php

namespace Sg\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Sg\CalendarBundle\Entity\EventInterface;

/**
 * Class CalendarEvent
 *
 * @package Sg\CalendarBundle\Event
 */
class CalendarEvent extends Event
{
    /**
     * @var EventInterface
     */
    private $event;


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
}