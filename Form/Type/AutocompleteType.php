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

/**
 * Class AutocompleteType
 *
 * @package Sg\CalendarBundle\Form\Type
 */
class AutocompleteType extends AbstractType
{
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