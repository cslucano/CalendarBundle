<?php

namespace Sg\CalendarBundle\Entity;

use Sg\CalendarBundle\Model\AbstractRecurrence as BaseRecurrence;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Recurrence
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Recurrence extends BaseRecurrence
{
}