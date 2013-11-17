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
     * Count all visible calendars.
     *
     * @return integer
     */
    public function countVisibleCalendars()
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->select('COUNT(c.id)');
        $qb->where('c.visible = :visible');
        $qb->setParameter('visible', true);

        return $qb->getQuery()->getSingleScalarResult();
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