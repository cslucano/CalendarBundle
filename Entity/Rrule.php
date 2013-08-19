<?php

namespace Sg\CalendarBundle\Entity;

use Sg\CalendarBundle\Model\AbstractRrule as BaseRrule;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rrule
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Rrule extends BaseRrule
{
    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();

        // your own logic
    }
}