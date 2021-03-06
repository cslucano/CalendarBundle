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

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CalendarManager
 *
 * @package Sg\CalendarBundle\Doctrine
 */
class CalendarManager extends ModelManager
{
    protected $autocompleteMaxResults;


    /**
     * Ctor.
     *
     * @param EntityManager $em                     An EntityManager instance
     * @param string        $class                  The class name
     * @param integer       $autocompleteMaxResults Autocomplete max results
     */
    public function __construct(EntityManager $em, $class, $autocompleteMaxResults)
    {
        parent::__construct($em, $class);

        $this->autocompleteMaxResults = $autocompleteMaxResults;
    }

    /**
     * Count all public calendars of other users.
     *
     * @param UserInterface $user
     *
     * @return integer
     */
    public function countPublicCalendars(UserInterface $user)
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->select('COUNT(c.id)');
        $qb->where('c.visible = :visible');
        $qb->andwhere('c.createdBy != :user');
        $qb->setParameter('visible', true);
        $qb->setParameter('user', $user);

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

    /**
     * Find all public calendars by given term (name, description or creator of the calendar) of other users.
     *
     * @param string        $term The search string
     * @param UserInterface $user The current user
     *
     * @return array
     */
    public function findPublicCalendarsByTerm($term, UserInterface $user)
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->select('c.id, c.name, u.username');
        $qb->join('c.createdBy', 'u');
        $qb->where('c.name LIKE :term');
        $qb->orWhere('c.description LIKE :term');
        $qb->orWhere('u.username LIKE :term');
        $qb->andWhere('c.visible = :visible');
        $qb->andwhere('c.createdBy != :user');
        $qb->setMaxResults($this->autocompleteMaxResults);
        $qb->orderBy('c.name', 'ASC');
        $qb->setParameter('term', '%' . $term . '%');
        $qb->setParameter('visible', true);
        $qb->setParameter('user', $user);

       return $qb->getQuery()->getScalarResult();
    }
}