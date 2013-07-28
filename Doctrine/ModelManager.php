<?php

namespace Sg\CalendarBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sg\CalendarBundle\Model\AbstractModelManager as BaseManager;

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
     * {@inheritDoc}
     */
    public function save($calendar, $andFlush = true)
    {
        $this->em->persist($calendar);

        if (true === $andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function remove($calendar, $andFlush = true)
    {
        $this->em->remove($calendar);

        if (true === $andFlush) {
            $this->em->flush();
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
}