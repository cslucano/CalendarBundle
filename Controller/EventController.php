<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sg\CalendarBundle\Event\CalendarEvent;
use Sg\CalendarBundle\SgCalendarEvents;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class EventController
 *
 * @Route("/calendar/events")
 *
 * @package Sg\CalendarBundle\Controller
 */
class EventController extends Controller
{
    /**
     * Returns the overall Events list as JSON object via XHR.
     *
     * @Route("/", name="sg_calendar_get_xhr_events")
     * @Method("GET")
     * @ApiDoc()
     *
     * @return Response
     */
    public function cgetXhrAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $events = $this->getEventManager()->findEvents();

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $returnEvents = array();

            /**
             * @var \Sg\CalendarBundle\Entity\EventInterface $event
             */
            foreach ($events as $event) {
                $returnEvents[] = $event->toArray();
            }

            $response->setContent(json_encode($returnEvents));

            return $response;
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Updates an existing Event entity via XHR.
     * Drag and Drop functionality.
     *
     * @Route("/update", name="sg_calendar_update_xhr_event")
     * @Method("POST")
     * @ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateXhrAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $params  = $request->request->all();
            $id      = $params['id'];
            $start   = new \DateTime($params['start']);
            $end     = new \DateTime($params['end']);

            $event = $this->getEventById($id);
            $event->setStart($start);
            $event->setEnd($end);

            $this->getEventManager()->updateEvent($event);

            return new Response('This is ajax response.');
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Creates a new Event entity.
     *
     * @param Request $request
     *
     * @Route("/create", name="sg_calendar_create_event")
     * @Method("POST")
     * @Template("SgCalendarBundle:Event:new.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction(Request $request)
    {
        $event = $this->getEventManager()->newEvent();
        $form = $this->getEventFormFactory()->createForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $calendarEvent = new CalendarEvent($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_CREATE_SUCCESS, $calendarEvent);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_CREATE_COMPLETED, $calendarEvent);

            return $calendarEvent->getResponse();
        }

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="sg_calendar_new_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     */
    public function newAction()
    {
        $event = $this->getEventManager()->newEvent();
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
     * @Route("/{id}/show", name="sg_calendar_get_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     */
    public function getAction($id)
    {
        $event = $this->getEventById($id);

        return array(
            'entity' => $event
        );
    }

    /**
     * Displays a form to update an existing Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/{id}/edit", name="sg_calendar_edit_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     */
    public function editAction($id)
    {
        $event = $this->getEventById($id);
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
     * @Route("/{id}/update", name="sg_calendar_update_event")
     * @Method("PUT")
     * @Template("SgCalendarBundle:Event:edit.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function putAction(Request $request, $id)
    {
        $event = $this->getEventById($id);
        $editForm = $this->getEventFormFactory()->createForm($event, array('method' => 'PUT'));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $calendarEvent = new CalendarEvent($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_SUCCESS, $calendarEvent);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_COMPLETED, $calendarEvent);

            return $calendarEvent->getResponse();
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
     * @Route("/{id}/remove", name="sg_calendar_remove_event")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     */
    public function removeAction($id)
    {
        $event = $this->getEventById($id);
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
     * @Route("/{id}/delete", name="sg_calendar_delete_event")
     * @Method("DELETE")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $event = $this->getEventById($id);
        $removeForm = $this->createDeleteForm($id);
        $removeForm->handleRequest($request);

        if ($removeForm->isValid()) {
            $calendarEvent = new CalendarEvent($event);

            $this->getEventManager()->removeEvent($event);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::EVENT_REMOVE_SUCCESS, $calendarEvent);
            $dispatcher->dispatch(SgCalendarEvents::EVENT_REMOVE_COMPLETED, $calendarEvent);

            return $calendarEvent->getResponse();
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
     * Return an event by id.
     *
     * @param integer $id
     *
     * @return \Sg\CalendarBundle\Entity\EventInterface
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

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * @return \Sg\CalendarBundle\Manager\EventManagerInterface
     */
    private function getEventManager()
    {
        return $this->container->get('sg_calendar.event_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Form\Factory\EventFormFactoryInterface
     */
    private function getEventFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.event');
    }
}
