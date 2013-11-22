<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Controller;

use Sg\CalendarBundle\EventDispatcher\CalendarData;
use Sg\CalendarBundle\SgCalendarEvents;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class CalendarController
 *
 * @Route("/calendar")
 *
 * @package Sg\CalendarBundle\Controller
 */
class CalendarController extends AbstractBaseController
{
    /**
     * Start action.
     *
     * @Route("/{_locale}", defaults={"_locale"="%locale%"}, requirements={"_locale" = "en|de"}, name="sg_calendar")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $userCalendars = array();
        $userFavoritePublicCalendars = array();
        $countPublicCalendars = $this->getCalendarManager()->countPublicCalendars();

        if (true === $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            $userCalendars = $this->getCalendarManager()->findCalendarsByUser($user);
            $userFavoritePublicCalendars = $user->getFavorites();
        }

        return array(
            'update_xhr_event_url' => $this->generateUrl('sg_calendar_update_xhr_event'),
            'user_calendars' => $userCalendars,
            'user_favorite_public_calendars' => $userFavoritePublicCalendars,
            'count_public_calendars' => $countPublicCalendars,
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
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function postAction(Request $request)
    {
        /**
         * @var \Sg\CalendarBundle\Model\CalendarInterface $calendar
         */
        $calendar = $this->getCalendarManager()->create();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $form = $this->getCalendarFormFactory()->createForm($calendar);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->save($calendar);

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
     * @Route("/{_locale}/new", defaults={"_locale"="%locale%"}, requirements={"_locale" = "en|de"}, name="sg_calendar_new_calendar")
     * @Method("GET")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newAction()
    {
        $calendar = $this->getCalendarManager()->create();

        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
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
     * @Route("/{_locale}/{id}/show", defaults={"_locale"="%locale%"}, requirements={"_locale" = "en|de"}, name="sg_calendar_get_calendar")
     * @Method("GET")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function getAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
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
     * @Route("/{_locale}/{id}/edit", defaults={"_locale"="%locale%"}, requirements={"_locale" = "en|de"}, name="sg_calendar_edit_calendar")
     * @Method("GET")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
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
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function putAction(Request $request, $id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $editForm = $this->getCalendarFormFactory()->createForm($calendar, array('method' => 'PUT'));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->save($calendar);

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
     * @Route("/{_locale}/{id}/remove", defaults={"_locale"="%locale%"}, requirements={"_locale" = "en|de"}, name="sg_calendar_remove_calendar")
     * @Method("GET")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function removeAction($id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
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
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteAction(Request $request, $id)
    {
        $calendar = $this->getCalendarById($id);

        if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            if (false === $this->getSecurity()->isGranted('OWNER', $calendar)) {
                throw new AccessDeniedException();
            }
        }

        $removeForm = $this->createDeleteForm($id);
        $removeForm->handleRequest($request);

        if ($removeForm->isValid()) {
            $calendarData = new CalendarData($calendar);

            $this->getCalendarManager()->remove($calendar);

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
}