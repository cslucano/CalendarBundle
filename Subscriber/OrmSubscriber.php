<?php

namespace Sg\CalendarBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Sg\CalendarBundle\Entity\EventInterface;
use \DateTime;

/**
 * Class OrmSubscriber
 *
 * @package Sg\CalendarBundle\EventSubscriber
 */
class OrmSubscriber implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * Ctor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Stores the current user into createdBy and updatedBy properties.
     * Stores the current DateTime into createdAt and updatedAt properties.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        if (PHP_SAPI != 'cli') {

            /**
             * @var \Sg\CalendarBundle\Entity\EventInterface $entity
             */
            $entity = $args->getEntity();

            if ($entity instanceof EventInterface) {
                $user = $this->getUser();
                $entity->setCreatedBy($user);
                $entity->setUpdatedBy($user);
                $entity->setCreatedAt(new DateTime());
                $entity->setUpdatedAt(new DateTime());
            }

        }
    }

    /**
     * Stores the current user into updatedBy property.
     * Stores the current DateTime into updatedAt property.
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        /**
         * @var \Sg\CalendarBundle\Entity\EventInterface $entity
         */
        $entity = $args->getEntity();

        if ($entity instanceof EventInterface) {
            $user = $this->getUser();
            $entity->setUpdatedBy($user);
            $entity->setUpdatedAt(new DateTime());

            /**
             * @var \Doctrine\ORM\EntityManager $em
             */
            $em = $args->getEntityManager();
            $uow = $em->getUnitOfWork();
            $meta = $em->getClassMetadata(get_class($entity));
            $uow->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }


    //-------------------------------------------------
    // Private
    //-------------------------------------------------

    /***
     * @return mixed
     */
    private function getUser()
    {
        /**
         * @var \Symfony\Component\Security\Core\SecurityContext $securityContext
         */
        $securityContext = $this->container->get('security.context');
        $token = $securityContext->getToken();
        $user = $token->getUser();

        return $user;
    }


    //-------------------------------------------------
    // EventSubscriberInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate
        );
    }
}