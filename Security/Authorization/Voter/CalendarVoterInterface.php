<?php

namespace Sg\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\User\UserInterface;
use Sg\CalendarBundle\Model\CalendarInterface;

/**
 * Class CalendarVoterInterface
 *
 * @package Sg\CalendarBundle\Security\Authorization\Voter
 */
interface CalendarVoterInterface
{
    /**
     * Checks if the user should be able to get all calendar events.
     *
     * @param UserInterface     $user     The logged in user
     * @param CalendarInterface $calendar An Calendar instance
     *
     * @return boolean
     */
    public function canGetevents(UserInterface $user, CalendarInterface $calendar);

    /**
     * Checks if the user should be able to view an calendar.
     *
     * @param UserInterface     $user     The logged in user
     * @param CalendarInterface $calendar An Calendar instance
     *
     * @return boolean
     */
    public function canView(UserInterface $user, CalendarInterface $calendar);

    /**
     * Checks if the user should be able to edit an calendar.
     *
     * @param UserInterface     $user     The logged in user
     * @param CalendarInterface $calendar An Calendar instance
     *
     * @return boolean
     */
    public function canEdit(UserInterface $user, CalendarInterface $calendar);

    /**
     * Checks if the user should be able to delete an calendar.
     *
     * @param UserInterface     $user     The logged in user
     * @param CalendarInterface $calendar An Calendar instance
     *
     * @return boolean
     */
    public function canDelete(UserInterface $user, CalendarInterface $calendar);
}