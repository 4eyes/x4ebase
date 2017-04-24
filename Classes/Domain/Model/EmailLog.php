<?php
namespace X4e\X4ebase\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailLog extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * sender
     *
     * @var string
     */
    protected $sender;

    /**
     * recipient
     *
     * @var string
     */
    protected $recipient;

    /**
     * replyTo
     *
     * @var string
     */
    protected $replyTo;

    /**
     * subject
     *
     * @var string
     */
    protected $subject;

    /**
     * message
     *
     * @var string
     */
    protected $message;

    /**
     * isSent
     *
     * @var bool
     */
    protected $isSent = false;

    /**
     * queued
     *
     * @var bool
     */
    protected $queued = false;

    /**
     * isHTML
     *
     * @var bool
     */
    protected $isHtml = true;

    /**
     * error
     *
     * @var string
     */
    protected $error;

    /**
     * Returns the sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Sets the sender
     *
     * @param string $sender
     * @return $this
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Returns the recipient
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Sets the recipient
     *
     * @param string $recipient
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * Returns the replyto
     *
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Sets the replyTo
     *
     * @param string $replyTo
     * @return $this
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * Returns the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the subject
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Returns the message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Returns the isSent
     *
     * @return bool
     */
    public function getIsSent()
    {
        return $this->isSent;
    }

    /**
     * Sets the isHtml
     *
     * @param bool $isHtml
     * @return $this
     */
    public function setIsHtml($isHtml)
    {
        $this->isHtml = $isHtml;
        return $this;
    }

    /**
     * Returns the isHtml
     *
     * @return bool
     */
    public function getIsHtml()
    {
        return $this->isHtml;
    }

    /**
     * Sets the isSent
     *
     * @param bool $isSent
     * @return $this
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;
        return $this;
    }

    /**
     * Returns the inQueue
     *
     * @return bool
     */
    public function getQueued()
    {
        return $this->queued;
    }

    /**
     * Sets the inQueue
     *
     * @param bool $queued
     * @return $this
     */
    public function setQueued($queued)
    {
        $this->queued = $queued;
        return $this;
    }

    /**
     * Returns the boolean state of isSent
     *
     * @return bool
     */
    public function isIsSent()
    {
        return $this->getIsSent();
    }

    /**
     * Returns the error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Sets the error
     *
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
}
