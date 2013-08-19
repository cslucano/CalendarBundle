<?php

namespace Sg\CalendarBundle\Entity;

use Sg\CalendarBundle\Model\AbstractOccurrence as BaseOccurrence;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Occurrence
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Occurrence extends BaseOccurrence
{
}