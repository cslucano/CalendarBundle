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
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Class AutocompleteType
 *
 * @package Sg\CalendarBundle\Form\Type
 */
class AutocompleteType extends AbstractType
{
    /**
     * @var string
     */
    private $fullcalendarId;


    /**
     * @param string $fullcalendarId
     */
    public function __construct($fullcalendarId)
    {
        $this->fullcalendarId = $fullcalendarId;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['fullcalendar_id'] = $this->fullcalendarId;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'autocomplete';
    }
} 