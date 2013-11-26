<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Model;

/**
 * Interface CalendarUserInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface CalendarUserInterface
{
    /**
     * Add favorite.
     *
     * @param CalendarInterface $favorite
     *
     * @return self
     */
    public function addFavorite(CalendarInterface $favorite);

    /**
     * Remove favorite.
     *
     * @param CalendarInterface $favorite
     *
     * @return self
     */
    public function removeFavorite(CalendarInterface $favorite);

    /**
     * Get favorites.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavorites();
} 