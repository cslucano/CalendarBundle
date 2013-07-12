<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sg\CalendarBundle\Event\EventData;
use Sg\CalendarBundle\SgCalendarEvents;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class EventController
 *
 * @Route("/")
 *
 * @package Sg\CalendarBundle\Controller
 */
class EventController extends Controller
{
    //-------------------------------------------------
    // Actions
    //-------------------------------------------------

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
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function cgetXhrAction(Request $request, $id)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $calendar = $this->getCalendarManager()->findCalendarBy(array('id' => $id));
            if (!$calendar) {
                throw $this->createNotFoundException('Unable to find Calendar entity.');
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
            $event->setStart($start);
            $event->setEnd($end);
            $event->setAllDay($allDay);

            $this->getEventManager()->updateEvent($event);

            return new Response('This is ajax response.');
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Creates a new Event entity.
     *
     * @param Request $request A Request instance
     *
     * @Route("calendar/event/create", name="sg_calendar_create_event")
     * @Method("POST")
     * @Template("SgCalendarBundle:Event:new.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function postAction(Request $request)
    {
        $event = $this->getEventManager()->newEvent();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $form = $this->getEventFormFactory()->createForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventData = new EventData($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_CREATE_SUCCESS, $eventData);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_CREATE_COMPLETED, $eventData);

            return $eventData->getResponse();
        }

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("calendar/event/new", name="sg_calendar_new_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newAction()
    {
        $event = $this->getEventManager()->newEvent();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $form = $this->getEventFormFactory()->createForm($event);

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays an existing Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("calendar/event/{id}/show", name="sg_calendar_get_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function getAction($id)
    {
        $event = $this->getEventById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('VIEW', $event)) {
                throw new AccessDeniedException();
            }
        }

        return array(
            'entity' => $event
        );
    }

    /**
     * Displays a form to update an existing Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("calendar/event/{id}/edit", name="sg_calendar_edit_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editAction($id)
    {
        $event = $this->getEventById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('EDIT', $event)) {
                throw new AccessDeniedException();
            }
        }

        $editForm = $this->getEventFormFactory()->createForm($event, array('method' => 'PUT'));

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Updates an existing Event entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("calendar/event/{id}/update", name="sg_calendar_update_event")
     * @Method("PUT")
     * @Template("SgCalendarBundle:Event:edit.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function putAction(Request $request, $id)
    {
        $event = $this->getEventById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('EDIT', $event)) {
                throw new AccessDeniedException();
            }
        }

        $editForm = $this->getEventFormFactory()->createForm($event, array('method' => 'PUT'));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $eventData = new EventData($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_SUCCESS, $eventData);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_COMPLETED, $eventData);

            return $eventData->getResponse();
        }

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Displays a form to delete an existing Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("calendar/event/{id}/remove", name="sg_calendar_remove_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function removeAction($id)
    {
        $event = $this->getEventById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('DELETE', $event)) {
                throw new AccessDeniedException();
            }
        }

        $removeForm = $this->createDeleteForm($id);

        return array(
            'entity' => $event,
            'remove_form' => $removeForm->createView()
        );
    }

    /**
     * Deletes an existing Event entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("calendar/event/{id}/delete", name="sg_calendar_delete_event")
     * @Method("DELETE")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteAction(Request $request, $id)
    {
        $event = $this->getEventById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('DELETE', $event)) {
                throw new AccessDeniedException();
            }
        }

        $removeForm = $this->createDeleteForm($id);
        $removeForm->handleRequest($request);

        if ($removeForm->isValid()) {
            $eventData = new EventData($event);

            $this->getEventManager()->removeEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_REMOVE_SUCCESS, $eventData);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_REMOVE_COMPLETED, $eventData);

            return $eventData->getResponse();
        }

        return array(
            'entity' => $event,
            'remove_form' => $removeForm->createView()
        );
    }


    //-------------------------------------------------
    // Private
    //-------------------------------------------------

    /**
     * Returns an Event by id.
     *
     * @param integer $id
     *
     * @return \Sg\CalendarBundle\Model\EventInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function getEventById($id)
    {
        $event = $this->getEventManager()->findEventBy(array('id' => $id));
        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        return $event;
    }

    /**
     * Creates a form to delete an Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setMethod('DELETE')
            ->getForm();
    }


    //-------------------------------------------------
    // Services
    //-------------------------------------------------

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    private function getSecurity()
    {
        return $this->container->get('security.context');
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * @return \Sg\CalendarBundle\Model\EventManagerInterface
     */
    private function getEventManager()
    {
        return $this->container->get('sg_calendar.event_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Model\CalendarManagerInterface
     */
    private function getCalendarManager()
    {
        return $this->container->get('sg_calendar.calendar_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Form\Factory\EventFormFactoryInterface
     */
    private function getEventFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.event');
    }

    /**
     * @return \Sg\CalendarBundle\Generator\EventsToArray
     */
    private function getArrayGenerator()
    {
        return $this->container->get('sg_calendar.array_generator');
    }
}
