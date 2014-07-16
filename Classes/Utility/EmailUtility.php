<?php

namespace X4E\X4ebase\Utility;

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
class EmailUtility {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected static $objectManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 */
	protected static $persistenceManager;

	/**
	 * Sends a email with a standalone view.
	 * The email and it's content will be logged
	 *
	 * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
	 * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
	 * @param string $subject subject of the email
	 * @param string $templateName template name (UpperCamelCase)
	 * @param string $templateRootPath
	 * @param string $layoutRootPath
	 * @param string $partialRootPath
	 * @param array $variables variables to be passed to the Fluid view
	 * @param string $extensionName needed for f:translate
	 * @param string $templateFolder
	 * @param boolean $isHtml true for html emails
	 * @param array $attachments
	 * @param array $replyTo
	 * @return boolean TRUE on success, otherwise false
	 */
	public static function sendTemplateEmail(array $recipient, array $sender, $subject, $templateName, $templateRootPath, $layoutRootPath, $partialRootPath, $variables = array(), $extensionName = 'x4ebase', $templateFolder = 'Email', $isHtml = true, $attachments = array(), $replyTo = array()) {
		$objectManager = self::getObjectManagerInstance();
		$isSent = false;
		$emailBody = '';
		try {
			/**
			 * @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView
			 */
			$emailView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');

			$templatePathAndFilename = $templateRootPath . $templateFolder . '/' . $templateName . '.html';
			$emailView->setLayoutRootPath($layoutRootPath);
			$emailView->setPartialRootPath($partialRootPath);
			$emailView->setTemplatePathAndFilename($templatePathAndFilename);
			$emailView->assignMultiple($variables);
			$emailView->getRequest()->setControllerExtensionName($extensionName);
			$emailBody = $emailView->render();

			/**
			 * @var $message \TYPO3\CMS\Core\Mail\MailMessage
			 */
			$message = $objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
			$message->setTo($recipient)
					->setFrom($sender)
					->setReplyTo($replyTo)
					->setSubject($subject);

			// Add attachments
			if(count($attachments)){
				foreach ($attachments as $attachment) {
					$message->attach($attachment);
				}
			}

			if($isHtml){
				// HTML Email
				$message->setBody($emailBody, 'text/html');
			} else {
				// Plain text Email
				$message->setBody($emailBody, 'text/plain');
			}

			$message->send();
			$isSent = $message->isSent();
			self::logEmail($recipient, $sender, $subject, $emailBody, $isSent, $e);
		} catch(\Exception $e){
			self::logEmail($recipient, $sender, $subject, $emailBody, $isSent, $e->getMessage());
		}
		return $isSent;
	}

	public static function logEmail($recipient, $sender, $subject, $message, $isSent, $error = NULL){
		$objectManager = self::getObjectManagerInstance();
		$persistenceManager = self::getPersistenceManagerInstance();

		$emailLogRepository = $objectManager->get('X4E\\X4ebase\\Domain\\Repository\\EmailLogRepository');

		if($emailLogRepository){
			$emailLog = $objectManager->get('X4E\\X4ebase\\Domain\\Model\\EmailLog');
			$emailLog->setRecipient(serialize($recipient))
					 ->setSender(serialize($sender))
					 ->setSubject($subject)
					 ->setMessage($message)
					 ->setIsSent($isSent)
					 ->setError($error);
					 //->setPid;

			$emailLogRepository->add($emailLog);
			$persistenceManager->persistAll();
		} else {
			throw new \TYPO3\CMS\Extbase\Persistence\Exception;
		}
	}

	protected static function getObjectManagerInstance(){
		if(!self::$objectManager){
			self::$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
		return self::$objectManager;
	}

	protected static function getPersistenceManagerInstance(){
		if(!self::$persistenceManager){
			self::$persistenceManager = self::$objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		}
		return self::$persistenceManager;
	}
}