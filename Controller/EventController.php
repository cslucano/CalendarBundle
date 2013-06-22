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
//use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class EventController
 *
 * @Route("/calendar")
 *
 * @package Sg\CalendarBundle\Controller
 */
class EventController extends Controller
{
    /**
     * Shows the calendar.
     *
     * @Route("/", name="sg_calendar_show")
     * @Method("GET")
     * @Template()
     * ApiDoc()
     *
     * @return array
     */
    public function calendarAction()
    {
        return array(
            'event_source_url' => $this->generateUrl('sg_calendar_events')
        );
    }

    /**
     * Get all Event entities.
     *
     * @Route("/events", name="sg_calendar_events")
     * @Method("GET")
     * ApiDoc()
     *
     * @return Response
     */
    public function getEventsAction()
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
     * Creates a new Event entity.
     *
     * @param Request $request
     *
     * @Route("/event/create", name="sg_calendar_event_create")
     * @Method("POST")
     * @Template("SgCalendarBundle:Event:new.html.twig")
     * ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $dispatcher = $this->getDispatcher();

        $event = $this->getEventManager()->newEvent();

        $form = $this->getEventFormFactory()->createForm();
        $form->setData($event);
        $form->bind($request);

        if ($form->isValid()) {
            $calendarEvent = new CalendarEvent($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response
            $dispatcher->dispatch(SgCalendarEvents::EVENT_CREATE_SUCCESS, $calendarEvent);

            // Set flash message
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
     * @Route("/event/new", name="sg_calendar_event_new")
     * @Method("GET")
     * @Template()
     * ApiDoc()
     *
     * @return array
     */
    public function newAction()
    {
        $event = $this->getEventManager()->newEvent();

        $form = $this->getEventFormFactory()->createForm();

        return array(
            'entity' => $event,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays an Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/event/{id}/show", name="sg_calendar_event_show")
     * @Method("GET")
     * @Template()
     * ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($id)
    {
        $event = $this->getEventManager()->findEventBy(array('id' => $id));
        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $event,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/event/{id}/edit", name="sg_calendar_event_edit")
     * @Method("GET")
     * @Template()
     * ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction($id)
    {
        $event = $this->getEventManager()->findEventBy(array('id' => $id));
        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->getEventFormFactory()->createForm();
        $editForm->setData($event);

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Edits an existing Event entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("/event/{id}/update", name="sg_calendar_event_update")
     * @Method("PUT")
     * @Template("SgCalendarBundle:Event:edit.html.twig")
     * ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, $id)
    {
        $event = $this->getEventManager()->findEventBy(array('id' => $id));
        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $dispatcher = $this->getDispatcher();

        $editForm = $this->getEventFormFactory()->createForm();
        $editForm->setData($event);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $calendarEvent = new CalendarEvent($event);

            $this->getEventManager()->updateEvent($event);

            // Set (redirect) response
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_SUCCESS, $calendarEvent);

            // Set flash message
            $dispatcher->dispatch(SgCalendarEvents::EVENT_UPDATE_COMPLETED, $calendarEvent);

            return $calendarEvent->getResponse();
        }

        return array(
            'entity' => $event,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Deletes an Event entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("/event/{id}/delete", name="sg_calendar_event_delete")
     * @Method("DELETE")
     * ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $event = $this->getEventManager()->findEventBy(array('id' => $id));
            if (!$event) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $this->getEventManager()->removeEvent($event);
        }

        return $this->redirect($this->generateUrl('sg_calendar_show'));
    }


    //-------------------------------------------------
    // Private
    //-------------------------------------------------

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
