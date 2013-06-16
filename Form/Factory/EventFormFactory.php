<?php

namespace Sg\CalendarBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class EventFormFactory
 *
 * @package Sg\CalendarBundle\Form\Factory
 */
class EventFormFactory implements EventFormFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var string|integer The name of the form
     */
    private $name;

    private $type;



    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param FormFactoryInterface $formFactory FormFactory
     * @param string|integer       $name        The name of the form
     * @param string               $type        Type
     */
    public function __construct(FormFactoryInterface $formFactory, $name, $type)
    {
        $this->formFactory = $formFactory;
        $this->name = $name;
        $this->type = $type;
    }


    //-------------------------------------------------
    // FactoryInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function createForm()
    {
        return $this->formFactory->createNamed($this->name, $this->type, null);
    }
}