<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Entity;

use Sg\CalendarBundle\Model\AbstractCalendar as BaseCalendar;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Calendar
 *
 * @ORM\Entity()
 * @ORM\Table()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Calendar extends BaseCalendar
{
    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();
    }
} 