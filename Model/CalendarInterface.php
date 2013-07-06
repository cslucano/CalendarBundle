<?php

namespace Sg\CalendarBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

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