<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sg\CalendarBundle\Event\CalendarData;
use Sg\CalendarBundle\SgCalendarEvents;
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
    //-------------------------------------------------
    // Actions
    //-------------------------------------------------

    /**
     * Shows all available Calendars, without the associated Events.
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
        $userCalendars = array();
        $visibleCalendars = array();
        $maxResults = $this->container->getParameter('sg_calendar.doctrine.calendar_max_results');

        if (true === $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $visibleCalendars = $this->getCalendarManager()->findCalendarsByVisible(true, $maxResults, $this->getUser());
            $userCalendars = $this->getCalendarManager()->findCalendarsByUser($this->getUser());
        } else {
            $visibleCalendars = $this->getCalendarManager()->findCalendarsByVisible(true, $maxResults);
        }

        return array(
            'update_xhr_event_url' => $this->generateUrl('sg_calendar_update_xhr_event'),
            'visible_calendars' => $visibleCalendars,
            'user_calendars' => $userCalendars
        );
    }

    /**
     * Creates a new Calendar entity.
     *
     * @param Request $request
     *
     * @Route("/create", name="sg_calendar_create_calendar")
     * @Method("POST")
     * @Template("SgCalendarBundle:Calendar:new.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function postAction(Request $request)
    {
        $calendar = $this->getCalendarManager()->newCalendar();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $form = $this->getCalendarFormFactory()->createForm($calendar);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->updateCalendar($calendar);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_CREATE_SUCCESS, $calendarData);
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_CREATE_COMPLETED, $calendarData);

            return $calendarData->getResponse();
        }

        return array(
            'entity' => $calendar,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Calendar entity.
     *
     * @Route("/new", name="sg_calendar_new_calendar")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newAction()
    {
        $calendar = $this->getCalendarManager()->newCalendar();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $form = $this->getCalendarFormFactory()->createForm($calendar);

        return array(
            'entity' => $calendar,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Calendar entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/{id}/show", name="sg_calendar_get_calendar")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function getAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('VIEW', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        return array(
            'entity' => $calendar
        );
    }

    /**
     * Displays a form to update an existing Calendar entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/{id}/edit", name="sg_calendar_edit_calendar")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('EDIT', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $editForm = $this->getCalendarFormFactory()->createForm($calendar, array('method' => 'PUT'));

        return array(
            'entity' => $calendar,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Updates an existing Calendar entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("/{id}/update", name="sg_calendar_update_calendar")
     * @Method("PUT")
     * @Template("SgCalendarBundle:Calendar:edit.html.twig")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function putAction(Request $request, $id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('EDIT', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $editForm = $this->getCalendarFormFactory()->createForm($calendar, array('method' => 'PUT'));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->updateCalendar($calendar);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_UPDATE_SUCCESS, $calendarData);
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_UPDATE_COMPLETED, $calendarData);

            return $calendarData->getResponse();
        }

        return array(
            'entity' => $calendar,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Displays a form to delete an existing Calendar entity.
     *
     * @param integer $id The entity id
     *
     * @Route("/{id}/remove", name="sg_calendar_remove_calendar")
     * @Method("GET")
     * @Template()
     * @ApiDoc()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function removeAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('DELETE', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $removeForm = $this->createDeleteForm($id);

        return array(
            'entity' => $calendar,
            'remove_form' => $removeForm->createView()
        );
    }

    /**
     * Deletes an existing Calendar entity.
     *
     * @param Request $request A Request instance
     * @param integer $id      The entity id
     *
     * @Route("/{id}/delete", name="sg_calendar_delete_calendar")
     * @Method("DELETE")
     * @ApiDoc()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteAction(Request $request, $id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('DELETE', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $removeForm = $this->createDeleteForm($id);
        $removeForm->handleRequest($request);

        if ($removeForm->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->removeCalendar($calendar);

            // Set (redirect) response and flash message
            $dispatcher = $this->getDispatcher();
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_REMOVE_SUCCESS, $calendarData);
            $dispatcher->dispatch(SgCalendarEvents::CALENDAR_REMOVE_COMPLETED, $calendarData);

            return $calendarData->getResponse();
        }

        return array(
            'entity' => $calendar,
            'remove_form' => $removeForm->createView()
        );
    }


    //-------------------------------------------------
    // Private
    //-------------------------------------------------

    /**
     * Return an Calendar by id.
     *
     * @param integer $id
     *
     * @return \Sg\CalendarBundle\Model\CalendarInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function getCalendarById($id)
    {
        $calendar = $this->getCalendarManager()->findCalendarBy(array('id' => $id));
        if (!$calendar) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        return $calendar;
    }

    /**
     * Creates a form to delete a Calendar entity by id.
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
     * @return \Sg\CalendarBundle\Model\CalendarManagerInterface
     */
    private function getCalendarManager()
    {
        return $this->container->get('sg_calendar.calendar_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Form\Factory\CalendarFormFactoryInterface
     */
    private function getCalendarFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.calendar');
    }
}