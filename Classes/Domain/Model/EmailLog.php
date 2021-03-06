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
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailLog extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * @var boolean
	 */
	protected $isSent = FALSE;

	/**
	 * queued
	 *
	 * @var boolean
	 */
	protected $queued = FALSE;

	/**
	 * isHTML
	 *
	 * @var boolean
	 */
	protected $isHtml = TRUE;

	/**
	 * error
	 *
	 * @var string
	 */
	protected $error;

	/**
	 * Returns the sender
	 *
	 * @return string $sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Sets the sender
	 *
	 * @param string $sender
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setSender($sender) {
		$this->sender = $sender;
		return $this;
	}

	/**
	 * Returns the recipient
	 *
	 * @return string $recipient
	 */
	public function getRecipient() {
		return $this->recipient;
	}

	/**
	 * Sets the recipient
	 *
	 * @param string $recipient
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setRecipient($recipient) {
		$this->recipient = $recipient;
		return $this;
	}

	/**
	 * Returns the replyto
	 *
	 * @return string $replyTo
	 */
	public function getReplyTo() {
		return $this->getReplyTo;
	}

	/**
	 * Sets the replyTo
	 *
	 * @param string $replyTo
	 * @return void
	 */
	public function setReplyTo($replyTo) {
		$this->replyTo = $replyTo;
		return $this;
	}

	/**
	 * Returns the subject
	 *
	 * @return string $subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Sets the subject
	 *
	 * @param string $subject
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * Returns the message
	 *
	 * @return string $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets the message
	 *
	 * @param string $message
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * Returns the isSent
	 *
	 * @return boolean $isSent
	 */
	public function getIsSent() {
		return $this->isSent;
	}

	/**
	 * Sets the isHtml
	 *
	 * @param boolean $isHtml
	 * @return void
	 */
	public function setIsHtml($isHtml) {
		$this->isHtml = $isHtml;
		return $this;
	}

	/**
	 * Returns the isHtml
	 *
	 * @return boolean $isHtml
	 */
	public function getIsHtml() {
		return $this->isHtml;
	}

	/**
	 * Sets the isSent
	 *
	 * @param boolean $isSent
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setIsSent($isSent) {
		$this->isSent = $isSent;
		return $this;
	}

	/**
	 * Returns the inQueue
	 *
	 * @return boolean $inQueue
	 */
	public function getQueued() {
		return $this->queued();
	}

	/**
	 * Sets the inQueue
	 *
	 * @param boolean $queued
	 * @return void
	 */
	public function setQueued($queued) {
		$this->queued = $queued;
		return $this;
	}

	/**
	 * Returns the boolean state of isSent
	 *
	 * @return boolean
	 */
	public function isIsSent() {
		return $this->getIsSent();
	}

	/**
	 * Returns the error
	 *
	 * @return string $error
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * Sets the error
	 *
	 * @param string $error
	 * @return \X4e\X4ebase\Domain\Model\EmailLog
	 */
	public function setError($error) {
		$this->error = $error;
		return $this;
	}

}