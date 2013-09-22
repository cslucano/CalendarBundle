<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Doctrine;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CalendarManager
 *
 * @package Sg\CalendarBundle\Doctrine
 */
class CalendarManager extends ModelManager
{
    /**
     * Find all calendars by given visibility.
     *
     * @param boolean       $visible The visibility of the calendar
     * @param string        $max     Limit the number of results returned from the query
     * @param UserInterface $user    If a user passed, this is an exclusion criteria
     *
     * @return mixed
     */
    public function findCalendarsByVisible($visible, $max, UserInterface $user = null)
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->where('c.visible = :visible');
        $qb->setParameter('visible', $visible);

        if (!(null === $user)) {
            $qb->andWhere('c.createdBy != :user');
            $qb->setParameter('user', $user);
        }

        $qb->setMaxResults($max);

        return $qb->getQuery()->execute();
    }

    /**
     * Find all calendars by given user.
     *
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function findCalendarsByUser(UserInterface $user)
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->where('c.createdBy = :user');
        $qb->setParameter('user', $user);

        return $qb->getQuery()->execute();
    }
}