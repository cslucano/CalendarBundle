<?php

namespace Sg\CalendarBundle\Manager;

use Sg\CalendarBundle\Entity\EventInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class EventManager
 *
 * @package Sg\CalendarBundle\Manager
 */
class EventManager implements EventManagerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * The fully qualified class name of event entity.
     *
     * @var string
     */
    private $class;

    /**
     * @var EntityRepository
     */
    private $repository;


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
    public function newEvent()
    {
        $class = $this->class;
        $event = new $class();

        return $event;
    }

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

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}