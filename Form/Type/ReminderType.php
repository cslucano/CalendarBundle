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

use Sg\CalendarBundle\Model\ReminderInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ReminderType
 *
 * @package Sg\CalendarBundle\Form\Type
 */
class ReminderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('method', 'choice', array(
                    'choices' => array(
                        ReminderInterface::METHOD_POPUP => 'calendar.entity.reminder.popup',
                        ReminderInterface::METHOD_EMAIL => 'calendar.entity.reminder.email'
                    ),
                    'empty_value' => 'calendar.form.empty.value',
                    'empty_data'  => null,
                    'label' => 'calendar.entity.reminder.method',
                    'translation_domain' => 'messages',
                    'required' => true,
                    'attr' => array(
                        'class' => 'span2'
                    )
                ))
            ->add('minutes', 'choice', array(
                    'choices' => array(
                         5 => '5',
                        10 => '10',
                        15 => '15',
                        30 => '30',
                        45 => '45',
                        60 => '60'
                    ),
                    'empty_value' => 'calendar.form.empty.value',
                    'empty_data'  => null,
                    'label' => 'calendar.entity.reminder.minutes',
                    'translation_domain' => 'messages',
                    'required' => true,
                    'attr' => array(
                        'class' => 'span2'
                    )
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Sg\CalendarBundle\Entity\Reminder'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sg_calendar_remindertype';
    }
}