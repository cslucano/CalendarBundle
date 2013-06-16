<?php

namespace Sg\CalendarBundle\Manager;

use Sg\CalendarBundle\Manager\EventManagerInterface;
use Sg\CalendarBundle\Entity\Event;
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
     * @param string        $class The fully qualified class name of event entity
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        /**
         * var 1
         */
        $this->class = $class;

        /**
         * var 2
         */
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
    public function removeEvent(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function updateEvent(Event $event, $andFlush = true)
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