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

    /**
     * Find all visible calendars by given term (name, description or creator of the calendar).
     *
     * @param string $term
     *
     * @return array
     */
    public function findVisibleCalendarsByTerm($term)
    {
        $qb = $this->repository->createQueryBuilder('c');
        $qb->select('c.id, c.name, u.username');
        $qb->join('c.createdBy', 'u');
        $qb->where('c.name LIKE :term');
        $qb->orWhere('c.description LIKE :term');
        $qb->orWhere('u.username LIKE :term');
        $qb->andWhere('c.visible = :visible');
        $qb->setMaxResults($this->autocompleteMaxResults);
        $qb->orderBy('c.name', 'ASC');
        $qb->setParameter('term', '%' . $term . '%');
        $qb->setParameter('visible', true);

       return $qb->getQuery()->getScalarResult();
    }
}