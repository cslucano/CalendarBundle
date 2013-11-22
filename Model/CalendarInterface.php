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

use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * Class CalendarInterface
 *
 * @package Sg\CalendarBundle\Model
 */
interface CalendarInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set description.
     *
     * @param text $description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return text
     */
    public function getDescription();

    /**
     * Set eventsUrl.
     *
     * @param string $eventsUrl
     *
     * @return self
     */
    public function setEventsUrl($eventsUrl);

    /**
     * Get eventsUrl.
     *
     * @return string
     */
    public function getEventsUrl();

    /**
     * Add event.
     *
     * @param EventInterface $event
     *
     * @return self
     */
    public function addEvent(EventInterface $event);

    /**
     * Remove event.
     *
     * @param EventInterface $event
     *
     * @return self
     */
    public function removeEvent(EventInterface $event);

    /**
     * Get events.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents();

    /**
     * Set visible.
     *
     * @param boolean $visible
     *
     * @return self
     */
    public function setVisible($visible);

    /**
     * Get visible.
     *
     * @return boolean
     */
    public function getVisible();

    /**
     * Add userFavorite.
     *
     * @param UserInterface $userFavorite
     *
     * @return self
     */
    public function addUserFavorite(UserInterface $userFavorite);

    /**
     * Remove userFavorite.
     *
     * @param UserInterface $userFavorite
     *
     * @return self
     */
    public function removeUserFavorite(UserInterface$userFavorite);

    /**
     * Get userFavorites.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserFavorites();

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set updatedAt.
     *
     * @param DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Set createdBy.
     *
     * @param UserInterface $createdBy
     *
     * @return self
     */
    public function setCreatedBy(UserInterface $createdBy);

    /**
     * Get createdBy.
     *
     * @return UserInterface
     */
    public function getCreatedBy();

    /**
     * Set updatedBy.
     *
     * @param UserInterface $updatedBy
     *
     * @return self
     */
    public function setUpdatedBy(UserInterface $updatedBy);

    /**
     * Get updatedBy.
     *
     * @return UserInterface
     */
    public function getUpdatedBy();
}