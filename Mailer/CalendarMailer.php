<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Mailer;

use Swift_Mailer;
use Swift_Message;

/**
 * Class CalendarMailer
 *
 * @package Sg\CalendarBundle\Mailer
 */
class CalendarMailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $fromAddress;

    /**
     * @var string
     */
    private $fromName;


    /**
     * Ctor.
     *
     * @param Swift_Mailer $mailer      A Swift_Mailer instance
     * @param string       $fromAddress From address
     * @param string       $fromName    From name
     */
    public function __construct(Swift_Mailer $mailer, $fromAddress, $fromName)
    {
        $this->mailer = $mailer;
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
    }

    /**
     * Send an email.
     *
     * @param string $to      The recipient email address
     * @param string $body    The body
     * @param string $subject The subject
     */
    public function sendEmail($to, $body, $subject = '')
    {
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->fromAddress)
            ->setTo($to)
            ->setBody($body);

        $this->mailer->send($message);
    }

}