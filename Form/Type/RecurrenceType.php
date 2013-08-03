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
                        RecurrenceInterface::PERIOD_DAILY => 'daily',
                        RecurrenceInterface::PERIOD_WEEKLY => 'weekly',
                        RecurrenceInterface::PERIOD_MONTHLY => 'monthly',
                        RecurrenceInterface::PERIOD_YEARLY => 'yearly'
                    ),
                    'label' => 'Periode'
                ))
            ->add('multiple', null, array('label' => 'Multiplikator'))
            ->add('end', 'datePicker', array('label' => 'Ende'));
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
