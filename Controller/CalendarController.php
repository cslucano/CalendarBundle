<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class CalendarController
 *
 * @Route("/calendar")
 *
 * @package Sg\CalendarBundle\Controller
 */
class CalendarController extends Controller
{
    /**
     * Shows the calendar.
     *
     * @Route("/", name="sg_calendar")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     */
    public function indexAction()
    {
        return array(
            'get_xhr_events_url' => $this->generateUrl('sg_calendar_get_xhr_events'),
            'update_xhr_event_url' => $this->generateUrl('sg_calendar_update_xhr_event')
        );
    }
}