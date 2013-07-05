<?php

namespace Sg\CalendarBundle\Model;

/**
 * Class AbstractEventManager
 *
 * Abstract Event-Manager implementation which can be used as base class for a concrete manager.
 *
 * @package Sg\CalendarBundle\Model
 */
abstract class AbstractEventManager implements EventManagerInterface
{
    /**
     * The fully qualified class name of event entity.
     *
     * @var string
     */
    protected $class;


    //-------------------------------------------------
    // EventManagerInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function newEvent()
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