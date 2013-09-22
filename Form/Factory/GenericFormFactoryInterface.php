<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Class GenericFormFactoryInterface
 *
 * @package Sg\CalendarBundle\Form\Factory
 */
interface GenericFormFactoryInterface
{
    /**
     * Returns a form.
     *
     * @param mixed $data    The initial data
     * @param array $options The options
     *
     * @return FormInterface The form
     */
    public function createForm($data = null, array $options = array());
}