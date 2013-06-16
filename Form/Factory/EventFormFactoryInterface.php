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
     * @return FormInterface
     */
    public function createForm();
}