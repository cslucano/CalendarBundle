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
     * Ctor.
     *
     * @param Twig $twig A Twig instance
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
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
     * @param string $eventSourceUrl
     *
     * @return mixed
     */
    public function calendarRender($eventSourceUrl)
    {
        $options['eventSourceUrl'] = $eventSourceUrl;

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