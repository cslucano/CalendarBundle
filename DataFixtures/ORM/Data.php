<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures
 */
class Data extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        $calendar = $this->getCalendarManager()->create();
        $calendar->setName('UserCalendar');
        $calendar->setCreatedAt(new \DateTime());
        $calendar->setUpdatedAt(new \DateTime());
        $calendar->setCreatedBy($this->getReference('user'));
        $calendar->setUpdatedBy($this->getReference('user'));

        $event = $this->getEventManager()->create();
        $event->setCalendar($calendar);
        $event->setTitle('UserTestevent');
        $event->setStart(new \DateTime());
        $event->setAllDay(true);
        $event->setEnd(null);
        $event->setCreatedAt(new \DateTime());
        $event->setUpdatedAt(new \DateTime());
        $event->setCreatedBy($this->getReference('user'));
        $event->setUpdatedBy($this->getReference('user'));

        $manager->persist($calendar);
        $manager->persist($event);

        $manager->flush();
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    private function getCalendarManager()
    {
        return $this->container->get('sg_calendar.calendar_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    protected function getEventManager()
    {
        return $this->container->get('sg_calendar.event_manager');
    }
}
