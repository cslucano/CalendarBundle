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
            ->add('rule', 'text', array(
                    'label' => 'calendar.entity.rrule.rule',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
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
                    'translation_domain' => 'messages',
                    'required' => true
                ))
            ->add('start', 'datePicker', array(
                    'label' => 'calendar.entity.rrule.start',
                    'translation_domain' => 'messages',
                    'required' => true
                ))
            ->add('until', 'datePicker', array(
                    'label' => 'calendar.entity.rrule.until',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('count', 'integer', array(
                    'label' => 'calendar.entity.rrule.count',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('ival', 'integer', array(
                    'label' => 'calendar.entity.rrule.ival',
                    'translation_domain' => 'messages',
                    'required' => true
                ))
            ->add('wkst', 'choice', array(
                    'choices'  => array(
                        RruleInterface::MONDAY => 'calendar.fullcalendar.day.monday',
                        RruleInterface::TUESDAY => 'calendar.fullcalendar.day.tuesday',
                        RruleInterface::WEDNESDAY => 'calendar.fullcalendar.day.wednesday',
                        RruleInterface::THURSDAY => 'calendar.fullcalendar.day.thursday',
                        RruleInterface::FRIDAY => 'calendar.fullcalendar.day.friday',
                        RruleInterface::SATURDAY => 'calendar.fullcalendar.day.saturday',
                        RruleInterface::SUNDAY => 'calendar.fullcalendar.day.sunday'
                    ),
                    'label' => 'calendar.entity.rrule.wkst',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('byday', 'choice', array(
                    'multiple' => true,
                    'choices'  => array(
                        RruleInterface::MONDAY => 'calendar.fullcalendar.day.monday',
                        RruleInterface::TUESDAY => 'calendar.fullcalendar.day.tuesday',
                        RruleInterface::WEDNESDAY => 'calendar.fullcalendar.day.wednesday',
                        RruleInterface::THURSDAY => 'calendar.fullcalendar.day.thursday',
                        RruleInterface::FRIDAY => 'calendar.fullcalendar.day.friday',
                        RruleInterface::SATURDAY => 'calendar.fullcalendar.day.saturday',
                        RruleInterface::SUNDAY => 'calendar.fullcalendar.day.sunday'
                    ),
                    'label' => 'calendar.entity.rrule.byday',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('bymonth', 'choice', array(
                    'multiple' => true,
                    'choices'  => array(
                        RruleInterface::JANUARY => 'calendar.fullcalendar.month.january',
                        RruleInterface::FEBRUARY => 'calendar.fullcalendar.month.february',
                        RruleInterface::MARCH => 'calendar.fullcalendar.month.march',
                        RruleInterface::APRIL => 'calendar.fullcalendar.month.april',
                        RruleInterface::MAY => 'calendar.fullcalendar.month.may',
                        RruleInterface::JUNE => 'calendar.fullcalendar.month.june',
                        RruleInterface::JULY => 'calendar.fullcalendar.month.july',
                        RruleInterface::AUGUST => 'calendar.fullcalendar.month.august',
                        RruleInterface::SEPTEMBER => 'calendar.fullcalendar.month.september',
                        RruleInterface::OCTOBER => 'calendar.fullcalendar.month.october',
                        RruleInterface::NOVEMBER => 'calendar.fullcalendar.month.november',
                        RruleInterface::DECEMBER => 'calendar.fullcalendar.month.december'
                    ),
                    'label' => 'calendar.entity.rrule.bymonth',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('bysetpos', 'array', array(
                    'label' => 'calendar.entity.rrule.bysetpos',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('bymonthday', 'array', array(
                    'label' => 'calendar.entity.rrule.bymonthday',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('byyearday', 'array', array(
                    'label' => 'calendar.entity.rrule.byyearday',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('byweekno', 'array', array(
                    'label' => 'calendar.entity.rrule.byweekno',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('byhour', 'array', array(
                    'label' => 'calendar.entity.rrule.byhour',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('byminute', 'array', array(
                    'label' => 'calendar.entity.rrule.byminute',
                    'translation_domain' => 'messages',
                    'required' => false
                ))
            ->add('bysecond', 'array', array(
                    'label' => 'calendar.entity.rrule.bysecond',
                    'translation_domain' => 'messages',
                    'required' => false
                ));
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
