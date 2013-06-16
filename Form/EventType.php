<?php

namespace Sg\CalendarBundle\Form;

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
            'data_class' => 'Sg\CalendarBundle\Entity\Event'
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
