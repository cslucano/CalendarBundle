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

use Sg\CalendarBundle\Model\AbstractEvent as BaseEvent;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 *
 * @ORM\Entity()
 * @ORM\Table()
 *
 * @package Sg\CalendarBundle\Entity
 */
class Event extends BaseEvent
{
    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();
    }
} 