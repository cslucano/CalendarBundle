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

use Sg\CalendarBundle\Event\ReminderData;
use Sg\CalendarBundle\SgCalendarEvents;
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

            // get current DateTime
            $now = new DateTime();

            /**
             * @var \Sg\CalendarBundle\Model\EventInterface $event
             */
            foreach ($events as $event) {
                // get all the reminders of the event
                $reminders = $event->getReminders();
                // get start DatTime of the event
                $startEvent = $event->getStart();
                // get the difference between the two DateTime objects
                $interval = $now->diff($startEvent);
                // formats the interval (sign "-" when negative, empty when positive; minutes numeric)
                $diff = $interval->format('%r%i');
                $diff = (int) $diff + 1;

                /**
                 * @var \Sg\CalendarBundle\Model\ReminderInterface $reminder
                 */
                foreach ($reminders as $reminder) {
                    if (false === $reminder->getDone()) {
                        $minutes = $reminder->getMinutes();

                        if ($diff == $minutes) {
                            $reminder = $this->getReminderById($reminder->getId());
                            $reminder->setDone(true);
                            $this->getReminderManager()->save($reminder);

                            $dispatcher = $this->getDispatcher();
                            $reminderData = new ReminderData($reminder, $event);

                            $dispatcher->dispatch(SgCalendarEvents::REMINDER_TRIGGER, $reminderData);

                            return $reminderData->getResponse();
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