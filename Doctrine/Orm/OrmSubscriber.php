<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Doctrine\Orm;

use Sg\CalendarBundle\Model\EventInterface;
use Sg\CalendarBundle\Model\CalendarInterface;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DateTime;

/**
 * Class OrmSubscriber
 *
 * @package Sg\CalendarBundle\Doctrine\Orm
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
             * @var \Sg\CalendarBundle\Model\EventInterface $entity
             */
            $entity = $args->getEntity();

            if ($entity instanceof EventInterface || $entity instanceof CalendarInterface) {
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
         * @var \Sg\CalendarBundle\Model\EventInterface $entity
         */
        $entity = $args->getEntity();

        if ($entity instanceof EventInterface || $entity instanceof CalendarInterface) {
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