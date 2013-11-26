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

use Sg\CalendarBundle\Form\Type\CalendarSearchType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SearchController
 *
 * @Route("/")
 *
 * @package Sg\CalendarBundle\Controller
 */
class SearchController extends AbstractBaseController
{
    /**
     * Displays a form to search a Calendar entity.
     *
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newCalendarSearchAction()
    {
        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new CalendarSearchType());

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Search public Calendar entities.
     *
     * @param Request $request
     *
     * @Route("calendar/search", name="sg_calendar_search_calendars")
     * @Method("GET")
     *
     * @return Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function calendarSearchAction(Request $request)
    {
        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $results = $this->getCalendarManager()->findPublicCalendarsByTerm($request->query->get('term'), $this->getUser());

            $json = array();
            foreach ($results as $result) {
                $json[] = $result;
            };

            return new Response(json_encode($json));
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Save a public Calendar entity as user favorite.
     *
     * @param Request $request
     *
     * @Template("SgCalendarBundle:Calendar:calendarListRow.html.twig")
     * @Route("calendar/search/save/favorite", name="sg_calendar_save_favorite")
     * @Method("GET")
     *
     * @return array|Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function saveFavoriteAction(Request $request)
    {
        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $id = $request->query->get('id');
            $calendar = $this->getCalendarById($id);

            $user = $this->getUser();

            if (false === $this->getSecurity()->isGranted('FAVORITE', $calendar)) {
                $calendar->addUserFavorite($user);
                $user->addFavorite($calendar);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return array(
                    'calendar' => $calendar
                );
            } else {
                $json = array('message' => $this->get('translator')->trans('calendar.search.action.saveFavorite.errorMessage'));
                $response = new Response(json_encode($json));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response('This is not ajax.', 400);
    }

    /**
     * Deletes an existing user favorite Calendar entity.
     *
     * @param Request $request
     *
     * @Route("calendar/search/delete/favorite", name="sg_calendar_delete_favorite")
     * @Method("GET")
     *
     * @return Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteFavoriteAction(Request $request)
    {
        if (false === $this->getSecurity()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $id = $request->query->get('id');
            $calendar = $this->getCalendarById($id);

            $user = $this->getUser();

            if (true === $this->getSecurity()->isGranted('FAVORITE', $calendar)) {
                $calendar->removeUserFavorite($user);
                $user->removeFavorite($calendar);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $json = array('message' => $this->get('translator')->trans('calendar.search.action.deleteFavorite.successMessage'));
                $response = new Response(json_encode($json));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                $json = array('message' => $this->get('translator')->trans('calendar.search.action.deleteFavorite.errorMessage'));
                $response = new Response(json_encode($json));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response('This is not ajax.', 400);
    }
}