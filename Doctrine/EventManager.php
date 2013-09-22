<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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