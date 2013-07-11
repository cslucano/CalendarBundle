<?php

namespace Sg\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Sg\CalendarBundle\Model\CalendarInterface;

/**
 * Class CalendarData
 *
 * @package Sg\CalendarBundle\Event
 */
class CalendarData extends Event
{
    /**
     * @var CalendarInterface
     */
    private $calendar;

    /**
     * @var Response
     */
    private $response;


    /**
     * @param CalendarInterface $calendar
     */
    public function __construct(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * @return CalendarInterface
     */
    public function getCalendar()
    {
        return $this->calendar;
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