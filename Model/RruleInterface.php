<?php

namespace Sg\CalendarBundle\Model;

use DateTime;

/**
 * Class RruleInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface RruleInterface
{
    const DAILY     = 'daily';
    const WEEKLY    = 'weekly';
    const MONTHLY   = 'monthly';
    const YEARLY    = 'yearly';
    const SECONDLY  = 'secondly';
    const MINUTELY  = 'minutely';
    const HOURLY    = 'hourly';

    const MONDAY    = 'mo';
    const TUESDAY   = 'tu';
    const WEDNESDAY = 'we';
    const THURSDAY  = 'th';
    const FRIDAY    = 'fr';
    const SATURDAY  = 'sa';
    const SUNDAY    = 'su';

    const JANUARY   = 1;
    const FEBRUARY  = 2;
    const MARCH     = 3;
    const APRIL     = 4;
    const MAY       = 5;
    const JUNE      = 6;
    const JULY      = 7;
    const AUGUST    = 8;
    const SEPTEMBER = 9;
    const OCTOBER   = 10;
    const NOVEMBER  = 11;
    const DECEMBER  = 12;


    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set rule.
     *
     * @param string $rule
     *
     * @return self
     */
    public function setRule($rule);

    /**
     * Get rule.
     *
     * @return string
     */
    public function getRule();

    /**
     * Set freq.
     *
     * @param string $freq
     *
     * @return self
     */
    public function setFreq($freq);

    /**
     * Get freq.
     *
     * @return string
     */
    public function getFreq();

    /**
     * Set start.
     *
     * @param DateTime $start
     *
     * @return self
     */
    public function setStart($start);

    /**
     * Get start.
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Set until.
     *
     * @param DateTime $until
     *
     * @return self
     */
    public function setUntil($until);

    /**
     * Get until.
     *
     * @return DateTime
     */
    public function getUntil();

    /**
     * Set count.
     *
     * @param integer $count
     *
     * @return self
     */
    public function setCount($count);

    /**
     * Get count.
     *
     * @return integer
     */
    public function getCount();

    /**
     * Set ival.
     *
     * @param integer $interval
     *
     * @return self
     */
    public function setIval($interval);

    /**
     * Get ival.
     *
     * @return integer
     */
    public function getIval();

    /**
     * Set wkst.
     *
     * @param string $wkst
     *
     * @return self
     */
    public function setWkst($wkst);

    /**
     * Get wkst.
     *
     * @return string
     */
    public function getWkst();

    /**
     * Add byday.
     *
     * @param string $day
     *
     * @return self
     */
    public function addByday($day);

    /**
     * Set byday.
     *
     * @param array $days
     *
     * @return self
     */
    public function setByday(array $days);

    /**
     * Get byday.
     *
     * @return array
     */
    public function getByday();

    /**
     * Add bymonth.
     *
     * @param string $month
     *
     * @return self
     */
    public function addBymonth($month);

    /**
     * Set bymonth.
     *
     * @param array $months
     *
     * @return self
     */
    public function setBymonth(array $months);

    /**
     * Get bymonth.
     *
     * @return array
     */
    public function getBymonth();

    /**
     * Add bysetpos.
     *
     * @param string $setpos
     *
     * @return self
     */
    public function addBysetpos($setpos);

    /**
     * Set bysetpos.
     *
     * @param array $setpos
     *
     * @return self
     */
    public function setBysetpos(array $setpos);

    /**
     * Get bysetpos.
     *
     * @return array
     */
    public function getBysetpos();

    /**
     * Add bymonthday.
     *
     * @param string $monthday
     *
     * @return self
     */
    public function addBymonthday($monthday);

    /**
     * Set bymonthday.
     *
     * @param array $monthdays
     *
     * @return self
     */
    public function setBymonthday(array $monthdays);

    /**
     * Get bymonthday.
     *
     * @return array
     */
    public function getBymonthday();

    /**
     * Add byyearday.
     *
     * @param string $yearday
     *
     * @return self
     */
    public function addByyearday($yearday);

    /**
     * Set byyearday.
     *
     * @param array $yeardays
     *
     * @return self
     */
    public function setByyearday(array $yeardays);

    /**
     * Get byyearday.
     *
     * @return array
     */
    public function getByyearday();

    /**
     * Add byweekno.
     *
     * @param string $weekno
     *
     * @return self
     */
    public function addByweekno($weekno);

    /**
     * Set byweekno.
     *
     * @param array $weekno
     *
     * @return self
     */
    public function setByweekno(array $weekno);

    /**
     * Get byweekno.
     *
     * @return array
     */
    public function getByweekno();

    /**
     * Add byhour.
     *
     * @param string $hour
     *
     * @return self
     */
    public function addByhour($hour);

    /**
     * Set byhour.
     *
     * @param array $hours
     *
     * @return self
     */
    public function setByhour(array $hours);

    /**
     * Get byhour.
     *
     * @return array
     */
    public function getByhour();

    /**
     * Add byminute.
     *
     * @param string $minute
     *
     * @return self
     */
    public function addByminute($minute);

    /**
     * Set byminute.
     *
     * @param array $minutes
     *
     * @return self
     */
    public function setByminute(array $minutes);

    /**
     * Get byminute.
     *
     * @return array
     */
    public function getByminute();

    /**
     * Add bysecond.
     *
     * @param string $second
     *
     * @return self
     */
    public function addBySecond($second);

    /**
     * Set bysecond.
     *
     * @param array $seconds
     *
     * @return self
     */
    public function setBysecond(array $seconds);

    /**
     * Get bysecond.
     *
     * @return array
     */
    public function getBysecond();

    /**
     * Set event.
     *
     * @param EventInterface $event
     *
     * @return self
     */
    public function setEvent(EventInterface $event);

    /**
     * Get event.
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Add occurrence.
     *
     * @param OccurrenceInterface $occurrence
     *
     * @return self
     */
    public function addOccurrence(OccurrenceInterface $occurrence);

    /**
     * Remove occurrence.
     *
     * @param OccurrenceInterface $occurrence
     *
     * @return self
     */
    public function removeOccurrence(OccurrenceInterface $occurrence);

    /**
     * Get occurrences.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOccurrences();
}