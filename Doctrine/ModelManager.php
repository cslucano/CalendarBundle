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

use Sg\CalendarBundle\Model\AbstractModelManager as BaseManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class ModelManager
 *
 * @package Sg\CalendarBundle\Doctrine
 */
class ModelManager extends BaseManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;


    /**
     * Ctor.
     *
     * @param EntityManager $em    An EntityManager instance
     * @param string        $class The class name
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Write all changes to the database.
     */
    public function flushAllChanges()
    {
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function save($object, $andFlush = true)
    {
        $this->em->persist($object);

        if (true === $andFlush) {
            $this->flushAllChanges();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function remove($object, $andFlush = true)
    {
        $this->em->remove($object);

        if (true === $andFlush) {
            $this->flushAllChanges();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria = array())
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria = array())
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }
}