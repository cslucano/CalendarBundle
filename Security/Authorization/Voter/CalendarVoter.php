<?php

namespace Sg\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Sg\CalendarBundle\Model\CalendarInterface;

/**
 * Class CalendarVoter
 *
 * @package Sg\CalendarBundle\Security\Authorization\Voter
 */
class CalendarVoter implements VoterInterface, CalendarVoterInterface
{
    //-------------------------------------------------
    // VoterInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
                'view',
                'edit',
                'delete',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class instanceof CalendarInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass($object)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                return VoterInterface::ACCESS_DENIED;
            }

            $suffix = ucfirst(strtolower($attribute));

            if (!$this->{"can".$suffix}($user, $object)) {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_GRANTED;
    }


    //-------------------------------------------------
    // CalendarVoterInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function canView(UserInterface $user, CalendarInterface $calendar)
    {
        return $user->isEqualTo($calendar->getCreatedBy());
    }

    /**
     * {@inheritDoc}
     */
    public function canEdit(UserInterface $user, CalendarInterface $calendar)
    {
        return $user->isEqualTo($calendar->getCreatedBy());
    }

    /**
     * {@inheritDoc}
     */
    public function canDelete(UserInterface $user, CalendarInterface $calendar)
    {
        return $user->isEqualTo($calendar->getCreatedBy());
    }
}