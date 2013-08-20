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
    const DAILY     = 'DAILY';
    const WEEKLY    = 'WEEKLY';
    const MONTHLY   = 'MONTHLY';
    const YEARLY    = 'YEARLY';
    const SECONDLY  = 'SECONDLY';
    const MINUTELY  = 'MINUTELY';
    const HOURLY    = 'HOURLY';

    const MONDAY    = 'MO';
    const TUESDAY   = 'TU';
    const WEDNESDAY = 'WE';
    const THURSDAY  = 'TH';
    const FRIDAY    = 'FR';
    const SATURDAY  = 'SA';
    const SUNDAY    = 'SU';

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
     * Set dtstart.
     *
     * @param DateTime $dtstart
     *
     * @return self
     */
    public function setDtstart($dtstart);

    /**
     * Get dtstart.
     *
     * @return DateTime
     */
    public function getDtstart();

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
     * Add byweekday.
     *
     * @param string $weekday
     *
     * @return self
     */
    public function addByweekday($weekday);

    /**
     * Set byweekday.
     *
     * @param array $byweekday
     *
     * @return self
     */
    public function setByweekday(array $byweekday);

    /**
     * Get byweekday.
     *
     * @return array
     */
    public function getByweekday();

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
     * @param array $bymonth
     *
     * @return self
     */
    public function setBymonth(array $bymonth);

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
     * @param array $bysetpos
     *
     * @return self
     */
    public function setBysetpos(array $bysetpos);

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
     * @param array $bymonthday
     *
     * @return self
     */
    public function setBymonthday(array $bymonthday);

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
     * @param array $byyearday
     *
     * @return self
     */
    public function setByyearday(array $byyearday);

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
     * @param array $byweekno
     *
     * @return self
     */
    public function setByweekno(array $byweekno);

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
     * @param array $byhour
     *
     * @return self
     */
    public function setByhour(array $byhour);

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
     * @param array $byminute
     *
     * @return self
     */
    public function setByminute(array $byminute);

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
     * @param array $bysecond
     *
     * @return self
     */
    public function setBysecond(array $bysecond);

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