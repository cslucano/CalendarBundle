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
            'event_source_url' => $this->generateUrl('sg_calendar_events'),
            'event_update_xhr_url' => $this->generateUrl('sg_calendar_event_update_xhr')
        );
    }
}