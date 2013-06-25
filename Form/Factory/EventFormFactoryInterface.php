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
     * Returns a form.
     *
     * @param mixed $data    The initial data
     * @param array $options The options
     *
     * @return FormInterface The form
     */
    public function createForm($data = null, array $options = array());
}