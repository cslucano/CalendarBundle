<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FavoriteVoter
 *
 * @package Sg\CalendarBundle\Security\Authorization\Voter
 */
class FavoriteVoter implements VoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return 'FAVORITE' === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return in_array('Sg\CalendarBundle\Model\CalendarInterface', class_implements($class));
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if ( !($this->supportsClass(get_class($object))) ) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        foreach ($attributes as $attribute) {
            if ( !($this->supportsAttribute($attribute)) ) {
                return VoterInterface::ACCESS_ABSTAIN;
            }
        }

        $user = $token->getUser();
        if ( !($user instanceof UserInterface) ) {
            return VoterInterface::ACCESS_DENIED;
        }

        if ( $user->getFavorites()->contains($object) ) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_DENIED;
    }
} 