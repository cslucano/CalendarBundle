<?php

namespace Sg\CalendarBundle\Generator;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sg\CalendarBundle\Model\EventInterface;

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
     * @param UrlGeneratorInterface $router A UrlGeneratorInterface
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Convert all events to an array.
     *
     * @param EventInterface[] $events
     *
     * @return array
     */
    public function generateArray($events)
    {
        $returnEvents = array();

        foreach ($events as $event) {
            $returnEvents[] = $this->toArray($event);

            $rrule = $event->getRrule();

            if ($rrule) {
                $occurrences = $rrule->getOccurrences();

                /**
                 * @var \Sg\RruleBundle\Model\OccurrenceInterface $occurrence
                 */
                foreach ($occurrences as $occurrence) {
                    $start = $occurrence->getStart();
                    $end = $occurrence->getEnd();

                    $returnEvents[] = $this->toArray($event, $start, $end);
                }
            }
        }

        return $returnEvents;
    }

    /**
     * Convert Event to an array.
     *
     * @param EventInterface $event An EventInterface
     * @param \DateTime      $start Start value of a recurring event
     * @param \DateTime      $end   End value of a recurring event
     *
     * @return array
     */
    private function toArray($event, $start = null, $end = null)
    {
        $result = array();

        $result['id'] = $event->getId();
        $result['title'] = $event->getTitle();
        $result['allDay'] = $event->getAllDay();

        if ($start !== null) {
            $result['start'] = $start->format(DATE_ISO8601);
            if ($end !== null) {
                $result['end'] = $end->format(DATE_ISO8601);
            }
        } else {
            $result['start'] = $event->getStart()->format(DATE_ISO8601);
            if ($event->getEnd() !== null) {
                $result['end'] = $event->getEnd()->format(DATE_ISO8601);
            }
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