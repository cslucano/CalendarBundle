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
use DateTime;

/**
 * Class Data
 *
 * @package Sg\CalendarBundle\DataFixtures\ORM
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

        $calendar0 = $this->getCalendarManager()->create();
        $calendar0->setName('My Calendar');
        $calendar0->setDescription('German Holidays');
        $calendar0->setCreatedAt(new DateTime());
        $calendar0->setUpdatedAt(new DateTime());
        $calendar0->setCreatedBy($this->getReference('user'));
        $calendar0->setUpdatedBy($this->getReference('user'));

        $calendar1 = $this->getCalendarManager()->create();
        $calendar1->setName('My Calendar 1');
        $calendar1->setDescription('Events');
        $calendar1->setCreatedAt(new DateTime());
        $calendar1->setUpdatedAt(new DateTime());
        $calendar1->setCreatedBy($this->getReference('admin'));
        $calendar1->setUpdatedBy($this->getReference('admin'));

        $calendar2 = $this->getCalendarManager()->create();
        $calendar2->setName('My Calendar 2');
        $calendar2->setDescription('Meetings');
        $calendar2->setCreatedAt(new DateTime());
        $calendar2->setUpdatedAt(new DateTime());
        $calendar2->setCreatedBy($this->getReference('superadmin'));
        $calendar2->setUpdatedBy($this->getReference('superadmin'));

        $event0 = $this->getEventManager()->create();
        $event0->setCalendar($calendar0);
        $event0->setTitle('UserTestevent');
        $event0->setStart(new DateTime());
        $event0->setAllDay(true);
        $event0->setEnd(null);
        $event0->setCreatedAt(new DateTime());
        $event0->setUpdatedAt(new DateTime());
        $event0->setCreatedBy($this->getReference('user'));
        $event0->setUpdatedBy($this->getReference('user'));
        $event0->setEditable(true);

        $event1 = $this->getEventManager()->create();
        $event1->setCalendar($calendar1);
        $event1->setTitle('AdminTestevent');
        $event1->setStart(new DateTime());
        $event1->setAllDay(true);
        $event1->setEnd(null);
        $event1->setCreatedAt(new DateTime());
        $event1->setUpdatedAt(new DateTime());
        $event1->setCreatedBy($this->getReference('admin'));
        $event1->setUpdatedBy($this->getReference('admin'));
        $event1->setEditable(true);

        $manager->persist($calendar0);
        $manager->persist($calendar1);
        $manager->persist($calendar2);
        $manager->persist($event0);
        $manager->persist($event1);

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
