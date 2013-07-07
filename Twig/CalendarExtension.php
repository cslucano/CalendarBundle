<?php

namespace Sg\CalendarBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_Environment as Twig;

/**
 * Class CalendarExtension
 *
 * @package Sg\CalendarBundle\Twig
 */
class CalendarExtension extends Twig_Extension
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * The jQuery fullcalendar id selector
     *
     * @var string
     */
    private $fullcalendarId;

    /**
     * The jQuery datepicker id selector
     *
     * @var string
     */
    private $datepickerId;

    /**
     * The day that each week begins.
     * Sunday=0, Monday=1 etc.
     *
     * @var integer
     */
    private $firstDay;

    /**
     * Determines the time-text that will be displayed on each event.
     *
     * @var string
     */
    private $timeFormat;


    /**
     * Ctor.
     *
     * @param Twig    $twig           A Twig instance
     * @param string  $fullcalendarId The jQuery fullcalendar id selector
     * @param string  $datepickerId   The jQuery datepicker id selector
     * @param integer $firstDay       The day that each week begins
     * @param string  $timeFormat     Determines the time-text that will be displayed on each event
     */
    public function __construct(Twig $twig, $fullcalendarId, $datepickerId, $firstDay, $timeFormat)
    {
        $this->twig = $twig;
        $this->fullcalendarId = $fullcalendarId;
        $this->datepickerId = $datepickerId;
        $this->firstDay = $firstDay;
        $this->timeFormat = $timeFormat;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('render_full_calendar', array($this, 'renderFullCalendar'), array('is_safe' => array('all'))),
            new Twig_SimpleFunction('render_datepicker', array($this, 'renderDatepicker'), array('is_safe' => array('all')))
        );
    }

    /**
     * Renders the FullCalendar.
     *
     * @param string $getXhrEventsUrl   The generated URL
     * @param string $updateXhrEventUrl The generated URL
     *
     * @return mixed
     */
    public function renderFullCalendar($getXhrEventsUrl, $updateXhrEventUrl)
    {
        $options['first_day'] = $this->firstDay;
        $options['time_format'] = $this->timeFormat;
        $options['fullcalendar_id'] = $this->fullcalendarId;
        $options['get_xhr_events_url'] = $getXhrEventsUrl;
        $options['update_xhr_event_url'] = $updateXhrEventUrl;

        return $this->twig->render('SgCalendarBundle:Extension:fullCalendar.html.twig', $options);
    }

    /**
     * Renders the Datepicker.
     *
     * @return string
     */
    public function renderDatepicker()
    {
        $options['fullcalendar_id'] = $this->fullcalendarId;
        $options['datepicker_id'] = $this->datepickerId;

        return $this->twig->render('SgCalendarBundle:Extension:datepicker.html.twig', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sg_calendar_twig_extension';
    }
}