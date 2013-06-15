<?php

namespace Sg\CalendarBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sg\CalendarBundle\Entity\Event;

/**
 * Class EventManager
 *
 * @package Sg\CalendarBundle\Manager
 */
class EventManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $class;


    /**
     * Ctor.
     *
     * @param EntityManager $em    A EntityManager instance
     * @param string        $class The fully qualified class name of event entity
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($class);
    }

    /**
     * @return Event
     */
    public function newEvent()
    {
        $class = $this->class;
        $event = new $class();

        return $event;
    }

    /**
     * @param integer $id
     *
     * @return Event
     */
    public function findById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Event $event
     */
    public function persistEvent(Event $event)
    {
        $this->em->persist($event);
        $this->em->flush();
    }

    /**
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }
}