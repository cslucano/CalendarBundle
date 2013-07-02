<?php

namespace Sg\CalendarBundle\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Sg\CalendarBundle\Entity\EventInterface;

/**
 * Class OwnerVoter
 *
 * @package Sg\CalendarBundle\Voter
 */
class OwnerVoter implements VoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return 'OWNER' === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class instanceof EventInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute) && $this->supportsClass($object)) {
                $user = $token->getUser();

                if (method_exists($user, 'isEqualTo')) {
                    if ($object instanceof EventInterface && $user->isEqualTo($object->getCreatedBy())) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                } else {
                    if ($object instanceof EventInterface && $this->equal($user, $object->getCreatedBy())) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }

    /**
     * @param UserInterface $user      The logged in user
     * @param UserInterface $createdBy The creator of the event
     *
     * @return boolean
     */
    private function equal(UserInterface $user, UserInterface $createdBy)
    {
        return md5($user->getUsername()) == md5($createdBy->getUsername());
    }
}