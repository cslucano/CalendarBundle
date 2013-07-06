<?php

namespace Sg\CalendarBundle\Model;

/**
 * Class AbstractCalendarManager
 *
 * Abstract Calendar-Manager implementation which can be used as base class for a concrete manager.
 *
 * @package Sg\CalendarBundle\Model
 */
abstract class AbstractCalendarManager implements CalendarManagerInterface
{
    /**
     * The fully qualified class name of calendar entity.
     *
     * @var string
     */
    protected $class;


    //-------------------------------------------------
    // CalendarManagerInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function newCalendar()
    {
        $class = $this->class;
        $event = new $class();

        return $event;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}