<?php

namespace Sg\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sg\CalendarBundle\Model\RecurrenceInterface;

/**
 * Class RecurrenceType
 *
 * @package Sg\CalendarBundle\Form
 */
class RecurrenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weekday', 'choice', array(
                    'choices' => array(
                        RecurrenceInterface::WEEKDAY_NONE => 'none',
                        RecurrenceInterface::WEEKDAY_MONDAY => 'monday',
                        RecurrenceInterface::WEEKDAY_TUESDAY => 'tuesday',
                        RecurrenceInterface::WEEKDAY_WEDNESDAY => 'wednesday',
                        RecurrenceInterface::WEEKDAY_THURSDAY => 'thursday',
                        RecurrenceInterface::WEEKDAY_FRIDAY => 'friday',
                        RecurrenceInterface::WEEKDAY_SATURDAY => 'saturday',
                        RecurrenceInterface::WEEKDAY_SUNDAY => 'sunday',
                        RecurrenceInterface::WEEKDAY_ALL => 'all'
                    ),
                    'label' => 'Wochentag'
                ))
            ->add('month', null, array('label' => 'Monat'))
            ->add('period', 'choice', array(
                    'choices' => array(
                        RecurrenceInterface::PERIOD_DAILY => 'day',
                        RecurrenceInterface::PERIOD_WEEKLY => 'week',
                        RecurrenceInterface::PERIOD_MONTHLY => 'month',
                        RecurrenceInterface::PERIOD_YEARLY => 'year'
                    ),
                    'label' => 'Periode'
                ))
            ->add('multiple', null, array('label' => 'Multiplikator'))
            ->add('end', 'datePicker', array('label' => 'Ende'))
            ->add('event', null, array('label' => 'Ereignis'));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sg\CalendarBundle\Entity\Recurrence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sg_calendarbundle_recurrencetype';
    }
}
