<?php

namespace Sg\CalendarBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Class CalendarFormFactory
 *
 * @package Sg\CalendarBundle\Form\Factory
 */
class CalendarFormFactory implements GenericFormFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var string|integer The name of the form
     */
    private $name;

    /**
     * @var string|FormTypeInterface The type of the form
     */
    private $type;


    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param FormFactoryInterface     $formFactory A FormFactoryInterface instance
     * @param string|integer           $name        The name of the form
     * @param string|FormTypeInterface $type        The type of the form
     */
    public function __construct(FormFactoryInterface $formFactory, $name, $type)
    {
        $this->formFactory = $formFactory;
        $this->name = $name;
        $this->type = $type;
    }


    //-------------------------------------------------
    // GenericFormFactoryInterface
    //-------------------------------------------------

    /**
     * {@inheritDoc}
     */
    public function createForm($data = null, array $options = array())
    {
        return $this->formFactory->createNamed($this->name, $this->type, $data, $options);
    }
}