<?php

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CalendarType
 *
 * @package Sg\CalendarBundle\Form\Type
 */
class CalendarType extends AbstractType
{
    /**
     * @var string
     */
    private $class;


    /**
     * @param string $class The Calendar class name
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
            ->add('name', null, array('label' => 'calendar.entity.calendar.name', 'translation_domain' => 'messages'))
            ->add('eventsUrl', null, array('label' => 'calendar.entity.calendar.eventsUrl', 'translation_domain' => 'messages'))
            ->add('visible', null, array('label' => 'calendar.entity.calendar.visible', 'translation_domain' => 'messages'));
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
        return 'sg_calendar_calendartype';
    }
}
