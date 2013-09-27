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
use Sg\CalendarBundle\Model\ReminderInterface;

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
                        ReminderInterface::METHOD_POPUP => 'Popup',
                        ReminderInterface::METHOD_EMAIL => 'Email'
                    ),
                    'empty_value' => 'Choose',
                    'empty_data'  => null,
                    'label' => 'Method',
                    //'translation_domain' => 'messages',
                    'required' => true,
                    'attr' => array(
                        'class' => 'span2'
                    )
                ))
            ->add('minutes', 'choice', array(
                    'choices' => array(
                        15 => '15',
                        30 => '30',
                        45 => '45'
                    ),
                    'empty_value' => 'Choose',
                    'empty_data'  => null,
                    'label' => 'Minutes',
                    //'translation_domain' => 'messages',
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
        return 'sg_calendar_remindtype';
    }
}