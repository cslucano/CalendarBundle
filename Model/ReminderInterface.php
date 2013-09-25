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
 * Class ReminderInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface ReminderInterface
{
    /**
     * Reminders are sent via email.
     *
     * @var string
     */
    const METHOD_EMAIL = 'EMAIL';

    /**
     * Reminders are sent via a UI popup.
     *
     * @var string
     */
    const METHOD_POPUP = 'POPUP';


    /**
     * Get id.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set method.
     *
     * @param string $method
     *
     * @return self
     */
    public function setMethod($method);

    /**
     * Get method.
     *
     * @return string
     */
    public function getMethod();

    /**
     * @param EventInterface $event
     *
     * @return self
     */
    public function setEvent(EventInterface $event);

    /**
     * Get event.
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Set minutes.
     *
     * @param integer $minutes
     *
     * @return self
     */
    public function setMinutes($minutes);

    /**
     * Get minutes.
     *
     * @return integer
     */
    public function getMinutes();
}