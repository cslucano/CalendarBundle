<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
class EventController extends AbstractBaseController
{
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

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
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

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
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
        $calendar = $event->getCalendar();

        if (false === $calendar->getVisible()) {
            if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
                if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
                    throw new AccessDeniedException();
                }
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
            if (false === $this->getSecurity()->isGranted('OWNER', $event)) {
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
            if (false === $this->getSecurity()->isGranted('OWNER', $event)) {
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
            if (false === $this->getSecurity()->isGranted('OWNER', $event)) {
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
            if (false === $this->getSecurity()->isGranted('OWNER', $event)) {
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

    /**
     * Attend an Event.
     *
     * @param integer $id The entity id
     *
     * @Route("calendar/event/{id}/attend", name="sg_calendar_attend_event")
     * @Method("GET")
     * @ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function attendAction($id)
    {
        $event = $this->getEventById($id);

        // @todo: access control

        if (!$event->hasAttendee($this->getUser())) {
            $event->getAttendees()->add($this->getUser());
        }

        $this->getEventManager()->updateEvent($event);

        return $this->redirect($this->generateUrl('sg_calendar_get_event', array(
                    'id' => $event->getId()
                )));
    }

    /**
     * Unattend an Event.
     *
     * @param integer $id The entity id
     *
     * @Route("calendar/event/{id}/unattend", name="sg_calendar_unattend_event")
     * @Method("GET")
     * @ApiDoc()
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unattendAction($id)
    {
        $event = $this->getEventById($id);

        // @todo: access control

        if ($event->hasAttendee($this->getUser())) {
            $event->getAttendees()->removeElement($this->getUser());
        }

        $this->getEventManager()->updateEvent($event);

        return $this->redirect($this->generateUrl('sg_calendar_get_event', array(
                    'id' => $event->getId()
                )));

    }
}
