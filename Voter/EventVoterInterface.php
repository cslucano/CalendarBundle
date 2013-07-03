<?php

namespace Sg\CalendarBundle\Voter;

use Symfony\Component\Security\Core\User\UserInterface;
use Sg\CalendarBundle\Entity\EventInterface;

/**
 * Class EventVoterInterface
 *
 * Any event voter to be used by Sg\CalendarBundle must implement this interface.
 *
 * @package Sg\CalendarBundle\Voter
 */
interface EventVoterInterface
{
    /**
     * Checks if the user should be able to create an event.
     *
     * @param UserInterface  $user  The logged in user
     * @param EventInterface $event An Event instance
     *
     * @return boolean
     */
    public function canCreate(UserInterface $user, EventInterface $event);

    /**
     * Checks if the user should be able to view an event.
     *
     * @param UserInterface  $user  The logged in user
     * @param EventInterface $event An Event instance
     *
     * @return boolean
     */
    public function canView(UserInterface $user, EventInterface $event);

    /**
     * Checks if the user should be able to edit an event.
     *
     * @param UserInterface  $user  The logged in user
     * @param EventInterface $event An Event instance
     *
     * @return boolean
     */
    public function canEdit(UserInterface $user, EventInterface $event);

    /**
     * Checks if the user should be able to delete an event.
     *
     * @param UserInterface  $user  The logged in user
     * @param EventInterface $event An Event instance
     *
     * @return boolean
     */
    public function canDelete(UserInterface $user, EventInterface $event);
}