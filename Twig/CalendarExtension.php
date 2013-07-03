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
     * @param Twig    $twig       A Twig instance
     * @param integer $firstDay   The day that each week begins
     * @param string  $timeFormat Determines the time-text that will be displayed on each event
     */
    public function __construct(Twig $twig, $firstDay, $timeFormat)
    {
        $this->twig = $twig;
        $this->firstDay = $firstDay;
        $this->timeFormat = $timeFormat;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('calendar_render', array($this, 'calendarRender'), array('is_safe' => array('all')))
        );
    }

    /**
     * @param string $getXhrEventsUrl   The generated URL
     * @param string $updateXhrEventUrl The generated URL
     *
     * @return mixed
     */
    public function calendarRender($getXhrEventsUrl, $updateXhrEventUrl)
    {
        $options['first_day'] = $this->firstDay;
        $options['time_format'] = $this->timeFormat;
        $options['get_xhr_events_url'] = $getXhrEventsUrl;
        $options['update_xhr_event_url'] = $updateXhrEventUrl;

        return $this->twig->render('SgCalendarBundle:Extension:calendar.html.twig', $options);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sg_calendar_twig_extension';
    }
}