<?php

namespace Sg\CalendarBundle\Entity;

use Sg\CalendarBundle\Model\AbstractCalculation as BaseCalculation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Calculation
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Calculation extends BaseCalculation
{
}