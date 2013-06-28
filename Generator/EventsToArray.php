<?php

namespace Sg\CalendarBundle\Generator;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sg\CalendarBundle\Entity\EventInterface;

/**
 * Class EventsToArray
 *
 * @package Sg\CalendarBundle\Generator
 */
class EventsToArray
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;


    /**
     * Ctor.
     *
     * @param UrlGeneratorInterface $router A UrlGeneratorInterface instance
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Convert Events to an array.
     *
     * @param EventInterface $events
     *
     * @return array
     */
    public function generateArray($events)
    {
        $returnEvents = array();

        foreach ($events as $event) {
            $returnEvents[] = $this->toArray($event);
        }

        return $returnEvents;
    }

    /**
     * Convert Event to an array.
     *
     * @param EventInterface $event
     *
     * @return array
     */
    private function toArray($event)
    {
        $result = array();

        $result['id'] = $event->getId();
        $result['title'] = $event->getTitle();
        $result['allDay'] = $event->getAllDay();
        $result['start'] = $event->getStart()->format(DATE_ISO8601);

        if ($event->getEnd() !== null) {
            $result['end'] = $event->getEnd()->format(DATE_ISO8601);
        }

        if ($event->getUrl() !== null) {
            $result['url'] = $event->getUrl();
        } else {
            $result['url'] = $this->router->generate('sg_calendar_get_event', array('id' => $event->getId()));
        }

        if ($event->getClassName() !== null) {
            $result['className'] = $event->getClassName();
        }

        $result['editable'] = $event->getEditable();

        if ($event->getColor() !== null) {
            $result['color'] = $event->getColor();
        }

        if ($event->getBgColor() !== null) {
            $result['backgroundColor'] = $event->getBgColor();
        }

        if ($event->getBorderColor() !== null) {
            $result['borderColor'] = $event->getBorderColor();
        }

        if ($event->getTextColor() !== null) {
            $result['textColor'] = $event->getTextColor();
        }

        return $result;
    }
}