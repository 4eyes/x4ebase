<?php

namespace X4e\X4ebase\Utility;

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
class EmailUtility
{

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
     * @param bool $isHtml true for html emails
     * @param array $attachments filepaths to attach to email
     * @param array $replyTo
     * @param bool $queued put email in queue rather than sent right away
     *
     * @return bool TRUE if send or queued
     */
    public static function sendTemplateEmail(array $recipient, array $sender, $subject, $templateName, $templateRootPath,
                                                $layoutRootPath, $partialRootPath,
                                                $variables = [], $extensionName = 'x4ebase',
                                                $templateFolder = 'Email', $isHtml = true, $attachments = [],
                                                $replyTo = [], $queued = false)
    {
        $success = false;
        $emailBody = '';
        try {
            $message = self::createMailMessage($recipient, $sender, $subject, $templateName, $templateRootPath, $layoutRootPath, $partialRootPath, $variables, $extensionName, $templateFolder, $isHtml, $attachments, $replyTo);
            $emailBody = $message->getBody();

                // queue can't handle mails with attachments
            if ($queued && empty($attachments)) {
                self::logEmail($recipient, $sender, $subject, $emailBody, $isHtml, $replyTo, $queued, $success, null);
                $success = true;
            } else {
                $message->send();
                $success = $message->isSent();
                self::logEmail($recipient, $sender, $subject, $emailBody, $isHtml, $replyTo, $queued, $success, null);
            }
        } catch (\Exception $e) {
            self::logEmail($recipient, $sender, $subject, $emailBody, $isHtml, $replyTo, $queued, $success, $e->getMessage());
        }
        return $success;
    }

            /**
     * Sends a mail from the queue
     *
     * @param \X4e\X4ebase\Domain\Model\EmailLog $emailLog
     * @return bool
     */
    public static function sendQueuedEmail(\X4e\X4ebase\Domain\Model\EmailLog $emailLog)
    {
        $objectManager = self::getObjectManagerInstance();
        $persistenceManager = self::getPersistenceManagerInstance();
        $emailLogRepository = $objectManager->get('X4e\\X4ebase\\Domain\\Repository\\EmailLogRepository');
        $isSent = false;

        try {
            $message = self::createBasicMailMessage(
                unserialize($emailLog->getRecipient()),
                unserialize($emailLog->getSender()),
                $emailLog->getSubject(),
                $emailLog->getMessage(),
                $emailLog->getIsHtml(),
                $emailLog->getReplyTo()
            );

            $isSent = $message->send();
            $emailLog->setIsSent($isSent);
            $emailLog->setQueued(!$isSent);
            $emailLog->setError('');
            $emailLogRepository->update($emailLog);
            $persistenceManager->persistAll();

            return $isSent;
        } catch (\Exception $e) {
            $emailLog->setError($e->getMessage());
            $emailLog->setIsSent(false);
            $emailLogRepository->update($emailLog);
            $persistenceManager->persistAll();

            // Write to Log
            $logManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager');
            $logger = $logManager->getLogger(__CLASS__);
            $logger->log(
                \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                '[1456846025] Exception while sending email: ' . $e->getMessage(),
                [
                    [
                        'emailData' => [
                            'sender' => $emailLog->getSender(),
                            'recipient' => $emailLog->getRecipient(),
                            'subject' => $emailLog->getSubject(),
                            'message' => $emailLog->getMessage()
                        ]
                    ],
                    [
                        'error' => $e->getTraceAsString()
                    ]
                ]
            );
        }

        return $isSent;
    }

    public static function logEmail($recipient, $sender, $subject, $message, $isHtml, $replyTo, $queued, $isSent, $error = null)
    {
        $objectManager = self::getObjectManagerInstance();
        $persistenceManager = self::getPersistenceManagerInstance();

        $emailLogRepository = $objectManager->get('X4e\\X4ebase\\Domain\\Repository\\EmailLogRepository');

        if ($emailLogRepository) {
            $emailLog = $objectManager->get('X4e\\X4ebase\\Domain\\Model\\EmailLog');
            $emailLog->setRecipient(serialize($recipient))
                     ->setSender(serialize($sender))
                     ->setSubject($subject)
                     ->setMessage($message)
                     ->setIsSent($isSent)
                     ->setError($error)
                     ->setQueued($queued)
                     ->setIsHtml($isHtml)
                     ->setReplyTo($replyTo);
                     //->setPid;

            $emailLogRepository->add($emailLog);
            $persistenceManager->persistAll();
        } else {
            throw new \TYPO3\CMS\Extbase\Persistence\Exception;
        }
    }

    /**
     * Creates a mail message according to the input, ready to send
     *
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param string $templateRootPath
     * @param array $layoutRootPaths
     * @param array $partialRootPaths
     * @param array $variables variables to be passed to the Fluid view
     * @param string $extensionName needed for f:translate
     * @param string $templateFolder
     * @param bool $isHtml true for html emails
     * @param array $attachments filepaths to attach to email
     * @param array $replyTo
     *
     * @return TYPO3\CMS\Core\Mail\MailMessage
     */
    protected static function createMailMessage(array $recipient, array $sender, $subject, $templateName, $templateRootPath, array $layoutRootPaths, array $partialRootPaths, $variables = [], $extensionName = 'x4ebase', $templateFolder = 'Email', $isHtml = true, $attachments = [], $replyTo = [])
    {
        $objectManager = self::getObjectManagerInstance();

        /**
             * @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView
             */
            $emailView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');

        $templatePathAndFilename = $templateRootPath . $templateFolder . '/' . $templateName . '.html';
        $emailView->setLayoutRootPaths($layoutRootPaths);
        $emailView->setPartialRootPaths($partialRootPaths);
        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($variables);
        $emailView->getRequest()->setControllerExtensionName($extensionName);
        $emailBody = $emailView->render();

        $message = self::createBasicMailMessage($recipient, $sender, $subject, $emailBody, $isHtml, $replyTo);

        // Add attachments
        if (count($attachments)) {
            foreach ($attachments as $attachment) {
                $message->attach(\Swift_Attachment::fromPath($attachment));
            }
        }

        return $message;
    }

            /**
     * Creates a basic MailMessage without attachments
     *
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $emailBody
     * @param bool|true $isHtml true for html emails
     * @param array $replyTo
     *
     * @return \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected static function createBasicMailMessage(array $recipient, array $sender, $subject, $emailBody, $isHtml = true, $replyTo = [])
    {
        $objectManager = self::getObjectManagerInstance();

        /**
             * @var $message \TYPO3\CMS\Core\Mail\MailMessage
             */
            $message = $objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($recipient)
                    ->setFrom($sender)
                    ->setReplyTo($replyTo)
                    ->setSubject($subject);

        if ($isHtml) {
            // HTML Email
                $message->setBody($emailBody, 'text/html');
        } else {
            // Plain text Email
                $message->setBody($emailBody, 'text/plain');
        }

        return $message;
    }

    protected static function getObjectManagerInstance()
    {
        if (!self::$objectManager) {
            self::$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        }
        return self::$objectManager;
    }

    protected static function getPersistenceManagerInstance()
    {
        if (!self::$persistenceManager) {
            self::$persistenceManager = self::$objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        }
        return self::$persistenceManager;
    }
}
