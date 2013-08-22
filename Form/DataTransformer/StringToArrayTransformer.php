<?php

namespace Sg\CalendarBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class StringToArrayTransformer
 *
 * @package Sg\CalendarBundle\Form\DataTransformer
 */
class StringToArrayTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (!$value) {
            $value = array(); // default
        }

        return implode(', ', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            $value = ''; // default
        }

        return array_filter(array_map('trim', explode(',', $value)));
        // 1. Split the string with commas
        // 2. Remove whitespaces around the values
        // 3. Remove empty elements (like in "1,2, ,,3,4")
    }
}