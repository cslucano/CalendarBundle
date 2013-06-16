<?php

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EventType
 *
 * @package Sg\CalendarBundle\Form
 */
class EventType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class The Event class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('allDay')
            ->add('start')
            ->add('end')
            ->add('url')
            ->add('className')
            ->add('editable')
            ->add('color')
            ->add('bgColor')
            ->add('borderColor')
            ->add('textColor');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sg_calendar_eventtype';
    }
}
