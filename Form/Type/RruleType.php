<?php

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sg\CalendarBundle\Model\RruleInterface;

/**
 * Class RruleType
 *
 * @package Sg\CalendarBundle\Form\Type
 */
class RruleType extends AbstractType
{
    /**
     * @var string
     */
    private $class;


    /**
     * @param string $class The Rrule class name
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
            ->add('rule', null, array('label' => 'calendar.entity.rrule.rule', 'translation_domain' => 'messages'))
            ->add('freq', 'choice', array(
                    'choices' => array(
                        RruleInterface::DAILY => 'calendar.frequency.daily',
                        RruleInterface::WEEKLY => 'calendar.frequency.weekly',
                        RruleInterface::MONTHLY => 'calendar.frequency.monthly',
                        RruleInterface::YEARLY => 'calendar.frequency.yearly',
                        RruleInterface::HOURLY => 'calendar.frequency.hourly',
                        RruleInterface::MINUTELY => 'calendar.frequency.minutely',
                        RruleInterface::SECONDLY => 'calendar.frequency.secondly'
                    ),
                    'label' => 'calendar.entity.rrule.freq',
                    'translation_domain' => 'messages'
                ))
            ->add('dtstart', 'datePicker', array('label' => 'calendar.entity.rrule.dtstart', 'translation_domain' => 'messages'))
            ->add('until', 'datePicker', array('label' => 'calendar.entity.rrule.until', 'translation_domain' => 'messages'))
            ->add('count', null, array('label' => 'calendar.entity.rrule.count', 'translation_domain' => 'messages'))
            ->add('ival', null, array('label' => 'calendar.entity.rrule.ival', 'translation_domain' => 'messages'))
            ->add('wkst', null, array('label' => 'calendar.entity.rrule.wkst', 'translation_domain' => 'messages'))
            ->add('byweekday', 'choice', array(
                    'multiple' => true,
                    'choices'  => array(
                        RruleInterface::MONDAY => 'calendar.fullcalendar.day.short.mon',
                        RruleInterface::TUESDAY => 'calendar.fullcalendar.day.short.tue',
                        RruleInterface::WEDNESDAY => 'calendar.fullcalendar.day.short.wed',
                        RruleInterface::THURSDAY => 'calendar.fullcalendar.day.short.thu',
                        RruleInterface::FRIDAY => 'calendar.fullcalendar.day.short.fri',
                        RruleInterface::SATURDAY => 'calendar.fullcalendar.day.short.sat',
                        RruleInterface::SUNDAY => 'calendar.fullcalendar.day.short.sun'
                    ),
                    'label' => 'calendar.entity.rrule.byweekday',
                    'translation_domain' => 'messages'
                ))
            ->add('bymonth', null, array('label' => 'calendar.entity.rrule.bymonth', 'translation_domain' => 'messages'))
            ->add('bysetpos', null, array('label' => 'calendar.entity.rrule.bysetpos', 'translation_domain' => 'messages'))
            ->add('bymonthday', null, array('label' => 'calendar.entity.rrule.bymonthday', 'translation_domain' => 'messages'))
            ->add('byyearday', null, array('label' => 'calendar.entity.rrule.byyearday', 'translation_domain' => 'messages'))
            ->add('byweekno', null, array('label' => 'calendar.entity.rrule.byweekno', 'translation_domain' => 'messages'))
            ->add('byhour', null, array('label' => 'calendar.entity.rrule.byhour', 'translation_domain' => 'messages'))
            ->add('byminute', null, array('label' => 'calendar.entity.rrule.byminute', 'translation_domain' => 'messages'))
            ->add('bysecond', null, array('label' => 'calendar.entity.rrule.bysecond', 'translation_domain' => 'messages'));
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
        return 'sg_calendar_rruletype';
    }
}
