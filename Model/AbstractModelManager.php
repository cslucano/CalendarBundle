<?php

namespace Sg\CalendarBundle\Model;

/**
 * Class AbstractModelManager
 *
 * @package Sg\CalendarBundle\Model
 */
abstract class AbstractModelManager implements ModelManagerInterface
{
    /**
     * The fully qualified class name.
     *
     * @var string
     */
    protected $class;


    /**
     * {@inheritDoc}
     */
    public function create()
    {
        $class = $this->class;
        $object = new $class();

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}