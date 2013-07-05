<?php

namespace Sg\CalendarBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sg\CalendarBundle\Model\EventInterface;
use Sg\CalendarBundle\Model\AbstractEventManager as BaseEventManager;

/**
 * Class EventManager
 *
 * @package Sg\CalendarBundle\Doctrine
 */
class EventManager extends BaseEventManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;


    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param EntityManager $em    An EntityManager instance
     * @param string        $class The class name of event entity
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->getName();
    }


    //-------------------------------------------------
    // EventManagerInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function removeEvent(EventInterface $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function updateEvent(EventInterface $event, $andFlush = true)
    {
        $this->em->persist($event);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findEventBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findEvents()
    {
        return $this->repository->findAll();
    }
}