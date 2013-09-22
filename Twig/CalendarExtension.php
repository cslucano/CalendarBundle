<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Twig_Environment as Twig;
use Symfony\Component\Translation\Translator;

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
     * @var Translator
     */
    private $translator;

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
     * @param Twig       $twig           A Twig instance
     * @param Translator $translator     A Translator instance
     * @param string     $fullcalendarId The jQuery fullcalendar id selector
     * @param string     $datepickerId   The jQuery datepicker id selector
     * @param integer    $firstDay       The day that each week begins
     * @param string     $timeFormat     Determines the time-text that will be displayed on each event
     */
    public function __construct(Twig $twig, Translator $translator, $fullcalendarId, $datepickerId, $firstDay, $timeFormat)
    {
        $this->twig = $twig;
        $this->translator = $translator;
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
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('boolean', array($this, 'booleanFilter'))
        );
    }

    /**
     * Renders the FullCalendar.
     *
     * @param string $updateXhrEventUrl The generated update URL
     *
     * @return mixed
     */
    public function renderFullCalendar($updateXhrEventUrl)
    {
        $options['first_day'] = $this->firstDay;
        $options['time_format'] = $this->timeFormat;
        $options['fullcalendar_id'] = $this->fullcalendarId;
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
     * Replacing "0" and "1" for boolean fields.
     *
     * @param boolean $value
     *
     * @return string
     */
    public function booleanFilter($value)
    {
        if ($value == '0') {
            return $this->translator->trans('calendar.filter.no');
        } else {
            return $this->translator->trans('calendar.filter.yes');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sg_calendar_twig_extension';
    }
}