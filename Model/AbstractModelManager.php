<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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