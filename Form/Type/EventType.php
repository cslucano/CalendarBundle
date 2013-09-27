<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sg\CalendarBundle\Model\EventInterface;

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
            ->add('title', null, array('label' => 'calendar.entity.event.title', 'translation_domain' => 'messages'))
            ->add('allDay', null, array('label' => 'calendar.entity.event.allDay', 'translation_domain' => 'messages'))
            ->add('start', 'dateTimePicker', array('label' => 'calendar.entity.event.start', 'translation_domain' => 'messages'))
            ->add('end', 'dateTimePicker', array('label' => 'calendar.entity.event.end', 'translation_domain' => 'messages', 'required' => false))
            ->add('description', null, array('label' => 'calendar.entity.event.description', 'translation_domain' => 'messages'))
            ->add('calendar', null, array('label' => 'calendar.entity.event.calendar', 'translation_domain' => 'messages'))
            ->add('url', null, array('label' => 'calendar.entity.event.url', 'translation_domain' => 'messages'))
            ->add('className', null, array('label' => 'calendar.entity.event.className', 'translation_domain' => 'messages'))
            ->add('editable', null, array('label' => 'calendar.entity.event.editable', 'translation_domain' => 'messages'))
            ->add('attendable', null, array('label' => 'calendar.entity.event.attendable', 'translation_domain' => 'messages'))
            ->add('color', null, array('label' => 'calendar.entity.event.color', 'translation_domain' => 'messages'))
            ->add('bgColor', null, array('label' => 'calendar.entity.event.bgColor', 'translation_domain' => 'messages'))
            ->add('borderColor', null, array('label' => 'calendar.entity.event.borderColor', 'translation_domain' => 'messages'))
            ->add('textColor', null, array('label' => 'calendar.entity.event.textColor', 'translation_domain' => 'messages'))
            ->add('status', 'choice', array(
                    'choices' => array(
                        EventInterface::STATUS_CONFIRMED => 'calendar.status.event.confirmed',
                        EventInterface::STATUS_TENTATIVE => 'calendar.status.event.tentative',
                        EventInterface::STATUS_CANCELLED => 'calendar.status.event.cancelled',
                    ),
                    'label' => 'calendar.entity.event.status',
                    'translation_domain' => 'messages'
                ))
            ->add('reminders', 'collection', array(
                    'type' => new ReminderType(),
                    'label' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ))
            ->add('rrule', 'rrule', array('label' => 'calendar.entity.event.rrule', 'translation_domain' => 'messages'));
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
