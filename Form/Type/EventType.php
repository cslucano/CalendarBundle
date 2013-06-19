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
            ->add('title', null, array('label' => 'sg.calendar.form.title', 'translation_domain' => 'CalendarBundle'))
            ->add('allDay', null, array('label' => 'sg.calendar.form.allDay', 'translation_domain' => 'CalendarBundle'))
            ->add('start', null, array('label' => 'sg.calendar.form.start', 'translation_domain' => 'CalendarBundle'))
            ->add('end', null, array('label' => 'sg.calendar.form.end', 'translation_domain' => 'CalendarBundle'))
            ->add('url', null, array('label' => 'sg.calendar.form.url', 'translation_domain' => 'CalendarBundle'))
            ->add('className', null, array('label' => 'sg.calendar.form.className', 'translation_domain' => 'CalendarBundle'))
            ->add('editable', null, array('label' => 'sg.calendar.form.editable', 'translation_domain' => 'CalendarBundle'))
            ->add('color', null, array('label' => 'sg.calendar.form.color', 'translation_domain' => 'CalendarBundle'))
            ->add('bgColor', null, array('label' => 'sg.calendar.form.bgColor', 'translation_domain' => 'CalendarBundle'))
            ->add('borderColor', null, array('label' => 'sg.calendar.form.borderColor', 'translation_domain' => 'CalendarBundle'))
            ->add('textColor', null, array('label' => 'sg.calendar.form.textColor', 'translation_domain' => 'CalendarBundle'));
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
