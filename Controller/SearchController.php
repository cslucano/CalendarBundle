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

use Sg\CalendarBundle\Entity\Calendar;
use Sg\CalendarBundle\Form\Type\CalendarSearchType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     */
    public function newCalendarSearchAction()
    {
        $form = $this->createForm(new CalendarSearchType(), new Calendar());

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Search Calendar entities.
     *
     * @param Request $request
     *
     * @Route("calendar/search", name="sg_calendar_search")
     * @Method("GET")
     *
     * @return Response
     */
    public function calendarSearchAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $results = $this->getCalendarManager()->findCalendarsByTerm($request->query->get('term'));

            $json = array();
            foreach ($results as $result) {
                $json[] = $result['name'];
            };

            return new Response(json_encode($json));
        }

        return new Response('This is not ajax.', 400);
    }

} 