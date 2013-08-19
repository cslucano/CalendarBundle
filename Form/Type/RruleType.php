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
            ->add('rule', null, array('label' => 'RRule'))
            ->add('freq', 'choice', array(
                    'choices' => array(
                        RruleInterface::DAILY => 'calendar.period.daily',
                        RruleInterface::WEEKLY => 'calendar.period.weekly',
                        RruleInterface::MONTHLY => 'calendar.period.monthly',
                        RruleInterface::YEARLY => 'calendar.period.yearly',
                        RruleInterface::HOURLY => 'Stündlich',
                        RruleInterface::MINUTELY => 'Minütlich',
                        RruleInterface::SECONDLY => 'Sekündlich'
                    ),
                    'label' => 'calendar.entity.recurrence.period',
                    'translation_domain' => 'messages'
                ))
            ->add('dtstart', 'datePicker', array('label' => 'Start', 'translation_domain' => 'messages'))
            ->add('until', 'datePicker', array('label' => 'calendar.entity.recurrence.end', 'translation_domain' => 'messages'))
            ->add('count', null, array('label' => 'Wiederholungen'))
            ->add('ival', null, array('label' => 'Interval'))
            ->add('wkst', null, array('label' => 'Wochenstart'))
            ->add('byweekday', 'choice', array(
                    'multiple' => true,
                    'choices'  => array(
                        RruleInterface::MONDAY => 'Montag',
                        RruleInterface::TUESDAY => 'Dienstag',
                        RruleInterface::WEDNESDAY => 'Mittwoch',
                        RruleInterface::THURSDAY => 'Donnerstag',
                        RruleInterface::FRIDAY => 'Freitag',
                        RruleInterface::SATURDAY => 'Samstag',
                        RruleInterface::SUNDAY => 'Sonntag'
                    ),
                    'label' => 'Wochentage',
                    'translation_domain' => 'messages'
                ))
            ->add('bymonth', null, array('label' => 'ByMonth'))
            ->add('bysetpos', null, array('label' => 'BySetpos'))
            ->add('bymonthday', null, array('label' => 'ByMonthday'))
            ->add('byyearday', null, array('label' => 'Byyearday'))
            ->add('byweekno', null, array('label' => 'ByWeekno'))
            ->add('byhour', null, array('label' => 'Byhour'))
            ->add('byminute', null, array('label' => 'Byminute'))
            ->add('bysecond', null, array('label' => 'Bysecond'));
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
