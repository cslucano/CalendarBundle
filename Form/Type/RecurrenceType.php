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
            ->add('period', 'choice', array(
                    'choices' => array(
                        RecurrenceInterface::PERIOD_DAILY => 'calendar.period.daily',
                        RecurrenceInterface::PERIOD_WEEKLY => 'calendar.period.weekly',
                        RecurrenceInterface::PERIOD_MONTHLY => 'calendar.period.monthly',
                        RecurrenceInterface::PERIOD_YEARLY => 'calendar.period.yearly'
                    ),
                    'label' => 'calendar.entity.recurrence.period',
                    'translation_domain' => 'messages'
                ))
            ->add('multiple', 'integer', array('label' => 'calendar.entity.recurrence.multiple', 'translation_domain' => 'messages'))
            ->add('end', 'datePicker', array('label' => 'calendar.entity.recurrence.end', 'translation_domain' => 'messages'));
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
