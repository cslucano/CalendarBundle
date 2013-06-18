<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sg\CalendarBundle\Entity\Event;
use Sg\CalendarBundle\Manager\EventManager;
use Sg\CalendarBundle\Form\Factory\EventFormFactory;

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
     *
     * @return array
     */
    public function calendarAction()
    {
        return array(
            'eventSourceUrl' => $this->generateUrl('sg_calendar_events')
        );
    }

    /**
     * Get all Event entities.
     *
     * @Route("/events", name="sg_calendar_events")
     * @Method("GET")
     *
     * @return array
     */
    public function getEventsAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $entities = $this->getEventManager()->findEvents();

            /*$results = array();
            foreach ($entities as $result) {
                $result['start'] = $result['start']->format('Y-m-d');
                $result['end'] = $result['end']->format('Y-m-d');

                array_push($results, $result);
            };*/

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $returnEvents = array();

            /**
             * @var \Sg\CalendarBundle\Entity\Event $event
             */
            foreach ($entities as $event) {
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
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = $this->getEventManager()->newEvent();
        $form = $this->getEventFormFactory()->createForm();
        $form->setData($entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->getEventManager()->updateEvent($entity);

            return $this->redirect($this->generateUrl('sg_calendar_event_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/event/new", name="sg_calendar_event_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $entity = $this->getEventManager()->newEvent();
        $form = $this->getEventFormFactory()->createForm();

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays an Event entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/event/{id}", name="sg_calendar_event_show")
     * @Method("GET")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($id)
    {
        $entity = $this->getEventManager()->findEventBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
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
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction($id)
    {
        $entity = $this->getEventManager()->findEventBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->getEventFormFactory()->createForm();
        $editForm->setData($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getEventManager()->findEventBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->getEventFormFactory()->createForm();
        $editForm->setData($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->getEventManager()->updateEvent($entity);

            return $this->redirect($this->generateUrl('sg_calendar_event_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getEventManager()->findEventBy(array('id' => $id));

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $this->getEventManager()->removeEvent($entity);
        }

        return $this->redirect($this->generateUrl('sg_calendar_show'));
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
            ->getForm();
    }

    /**
     * @return EventManager
     */
    private function getEventManager()
    {
        return $this->container->get('sg_calendar.event_manager');
    }

    /**
     * @return EventFormFactory
     */
    private function getEventFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.event');
    }
}
