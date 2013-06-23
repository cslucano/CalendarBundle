<?php

namespace Sg\CalendarBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Class EventFormFactoryInterface
 *
 * @package Sg\CalendarBundle\Form\Factory
 */
interface EventFormFactoryInterface
{
    /**
     * Creates an event form.
     *
     * @return FormInterface The form
     */
    public function createForm();
}