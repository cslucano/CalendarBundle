<?php

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EventType
 *
 * @package Sg\CalendarBundle\Form\Type
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
            ->add('title', null, array('label' => 'calendar.form.event.title', 'translation_domain' => 'messages'))
            ->add('allDay', null, array('label' => 'calendar.form.event.allDay', 'translation_domain' => 'messages'))
            ->add('start', null, array('label' => 'calendar.form.event.start', 'translation_domain' => 'messages'))
            ->add('end', null, array('label' => 'calendar.form.event.end', 'translation_domain' => 'messages'))
            ->add('calendar', null, array('label' => 'calendar.form.event.calendar', 'translation_domain' => 'messages'))
            ->add('url', null, array('label' => 'calendar.form.event.url', 'translation_domain' => 'messages'))
            ->add('className', null, array('label' => 'calendar.form.event.className', 'translation_domain' => 'messages'))
            ->add('editable', null, array('label' => 'calendar.form.event.editable', 'translation_domain' => 'messages'))
            ->add('color', null, array('label' => 'calendar.form.event.color', 'translation_domain' => 'messages'))
            ->add('bgColor', null, array('label' => 'calendar.form.event.bgColor', 'translation_domain' => 'messages'))
            ->add('borderColor', null, array('label' => 'calendar.form.event.borderColor', 'translation_domain' => 'messages'))
            ->add('textColor', null, array('label' => 'calendar.form.event.textColor', 'translation_domain' => 'messages'));
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
