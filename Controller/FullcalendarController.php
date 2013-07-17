<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class FullcalendarController
 *
 * @Route("/")
 *
 * @package Sg\CalendarBundle\Controller
 */
class FullcalendarController extends AbstractBaseController
{
    /**
     * Returns all Events by a given Calendar-Id as JSON object via XHR.
     *
     * @param Request $request A Request instance
     * @param integer $id      The Calendar entity id
     *
     * @Route("calendar/{id}/events", name="sg_calendar_get_xhr_events")
     * @Method("GET")
     * @ApiDoc()
     *
     * @return Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function cgetXhrAction(Request $request, $id)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $calendar = $this->getCalendarById($id);

            if (false === $calendar->getVisible()) {
                if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
                    if (false === $this->getSecurity()->isGranted('VIEW', $calendar)) {
                        throw new AccessDeniedException();
                    }
                }
            }

            $events = $this->getEventManager()->findEventsByCalendar($calendar);

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json', 'charset=utf-8');

            $generator = $this->getArrayGenerator();
            $returnEvents = $generator->generateArray($events);

            $response->setContent(json_encode($returnEvents));

            return $response;
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Updates an existing Event entity via XHR.
     * Drag and Drop functionality.
     *
     * @param Request $request A Request instance
     *
     * @Route("calendar/event/update", name="sg_calendar_update_xhr_event")
     * @Method("POST")
     * @ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function updateXhrAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $params = $request->request->all();
            $id = $params['id'];
            $start = new \DateTime($params['start']);

            if (!$params['end']) {
                $end = null;
            } else {
                $end = new \DateTime($params['end']);
            }

            $allDay = $params['allDay'];

            $event = $this->getEventById($id);

            if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
                if (false === $this->getSecurity()->isGranted('EDIT', $event)) {
                    throw new AccessDeniedException();
                }
            }

            $event->setStart($start);
            $event->setEnd($end);
            $event->setAllDay($allDay);

            $this->getEventManager()->updateEvent($event);

            return new Response('This is ajax response.');
        }

        return new Response('This is not ajax.', 400);
    }
}