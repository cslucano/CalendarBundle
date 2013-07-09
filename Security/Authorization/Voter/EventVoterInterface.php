<?php

namespace Sg\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\User\UserInterface;
use Sg\CalendarBundle\Model\EventInterface;

/**
 * Class EventVoterInterface
 *
 * @package Sg\CalendarBundle\Security\Authorization\Voter
 */
interface EventVoterInterface
{
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