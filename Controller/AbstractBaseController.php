<?php

namespace Sg\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractBaseController
 *
 * @package Sg\CalendarBundle\Controller
 */
abstract class AbstractBaseController extends Controller
{
    /**
     * Return an Calendar by id.
     *
     * @param integer $id
     *
     * @return \Sg\CalendarBundle\Model\CalendarInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getCalendarById($id)
    {
        $calendar = $this->getCalendarManager()->find($id);
        if (!$calendar) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        return $calendar;
    }

    /**
     * Returns an Event by id.
     *
     * @param integer $id
     *
     * @return \Sg\CalendarBundle\Model\EventInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getEventById($id)
    {
        $event = $this->getEventManager()->find($id);
        if (!$event) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        return $event;
    }

    /**
     * Creates a form to delete a entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    protected function getSecurity()
    {
        return $this->container->get('security.context');
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    protected function getCalendarManager()
    {
        return $this->container->get('sg_calendar.calendar_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    protected function getEventManager()
    {
        return $this->container->get('sg_calendar.event_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    protected function getRecurrenceManager()
    {
        return $this->container->get('sg_calendar.recurrence_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Model\ModelManagerInterface
     */
    protected function getCalculationManager()
    {
        return $this->container->get('sg_calendar.calculation_manager');
    }

    /**
     * @return \Sg\CalendarBundle\Form\Factory\CalendarFormFactory
     */
    protected function getCalendarFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.calendar');
    }

    /**
     * @return \Sg\CalendarBundle\Form\Factory\EventFormFactory
     */
    protected function getEventFormFactory()
    {
        return $this->container->get('sg_calendar.form_factory.event');
    }

    /**
     * @return \Sg\CalendarBundle\Generator\EventsToArray
     */
    protected function getArrayGenerator()
    {
        return $this->container->get('sg_calendar.array_generator');
    }
}