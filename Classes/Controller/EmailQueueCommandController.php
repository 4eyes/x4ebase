<?php
namespace X4e\X4ebase\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Markus Stauffiger <markus@4eyes.ch>, 4eyes GmbH
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
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailQueueCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * emailLogRepository
     *
     * @var \X4e\X4ebase\Domain\Repository\EmailLogRepository
     * @inject
     */
    protected $emailLogRepository;

    /**
     * The settings.
     * @var array
     */
    protected $settings = [];

    /**
     * @var int
     */
    protected $mailsPerRun = 30;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @inject
     */
    protected $configurationManager;

    /**
     * Command which replicates DB
     *
     * @return void
     */
    public function processEmailQueueCommand()
    {
        $this->settings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'x4ebase',
            'tx_x4ebase'
        );
        $mailsInQueue = $this->emailLogRepository->findByQueued(true);

        if ($this->settings['emailQueueCommandController']['mailsPerRun']) {
            $mailsPerRun = $this->settings['emailQueueCommandController']['mailsPerRun'];
        } else {
            $mailsPerRun = $this->mailsPerRun;
        }

        $i = 0;
        foreach ($mailsInQueue as $mail) {
            if ($i >= $mailsPerRun) {
                break;
            }

            $sent = \X4e\X4ebase\Utility\EmailUtility::sendQueuedEmail($mail);
            if ($sent) {
                $this->addFlashMessage(
                    $mail->getRecipient(),
                    'mail sent'
                );
            } else {
                $this->addFlashMessage(
                    'Mail to ' . $mail->getRecipient() . ' not send. Trying in the next run',
                    'mail not sent',
                    FlashMessage::INFO
                );
            }
            $i++;
        }

        return true;
    }

    /**
     * Adds a flash message to the queue
     *
     * @param string $message
     * @param string $title
     * @param int $status
     */
    public function addFlashMessage($message, $title, $status = FlashMessage::OK)
    {
        /** @var $flashMessage FlashMessage */
        $flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            FlashMessage::class,
            $message,
            $title,
            $status
        );
        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        /** @var FlashMessageQueue $defaultFlashMessageQueue */
        $defaultFlashMessageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $defaultFlashMessageQueue->enqueue($flashMessage);
    }
}
