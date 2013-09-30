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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DateTime;

/**
 * Class ReminderController
 *
 * @Route("/")
 *
 * @package Sg\CalendarBundle\Controller
 */
class ReminderController extends AbstractBaseController
{
    /**
     * @param Request $request A Request instance
     *
     * @Route("calendar/event/reminders", name="sg_calendar_get_reminders")
     * @Method("POST")
     *
     * @return Response
     */
    public function getRemindersAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            // get all events by given user
            $events = $this->getEventManager()->findEventsByUser($this->getUser());

            /**
             * Get all reminders of the event.
             *
             * @var \Sg\CalendarBundle\Model\EventInterface $event
             */
            foreach ($events as $event) {
                $reminders = $event->getReminders();

                /**
                 * @var \Sg\CalendarBundle\Model\ReminderInterface $reminder
                 */
                foreach ($reminders as $reminder) {
                    if (false === $reminder->getDone()) {
                        $method = $reminder->getMethod();
                        $minutes = $reminder->getMinutes();
                        $startEvent = $event->getStart();
                        $now = new DateTime();
                        $interval = $now->diff($startEvent);
                        $minDiff = $interval->format('%r%i');
                        $minDiff = (int) $minDiff + 1;

                        if ($minDiff == $minutes) {
                            $data = array(
                                'method' => $method,
                                'title' => $event->getTitle() . ' fängt in ' . $minutes . 'Minuten an.'
                            );

                            $reminder = $this->getReminderById($reminder->getId());
                            $reminder->setDone(true);
                            $this->getReminderManager()->save($reminder);

                            $response = new Response(json_encode($data), 200);
                            $response->headers->set('Content-Type', 'application/json');

                            return $response;
                        }
                    }
                }
            }

            $data = array(
                'title' => 'Keine Erinnerungen.'
            );

            $response = new Response(json_encode($data), 200);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new Response('This is not ajax.', 400);
    }
}