<?php

namespace Sg\CalendarBundle\Doctrine;

use Sg\CalendarBundle\Model\CalendarInterface;

/**
 * Class EventManager
 *
 * @package Sg\CalendarBundle\Doctrine
 */
class EventManager extends ModelManager
{
    /**
     * Find all events by given calendar.
     *
     * @param CalendarInterface $calendar
     *
     * @return mixed
     */
    public function findEventsByCalendar(CalendarInterface $calendar)
    {
        $qb = $this->repository->createQueryBuilder('e');
        $qb->where('e.calendar = :calendar');
        $qb->setParameter('calendar', $calendar);

        return $qb->getQuery()->execute();
    }
}