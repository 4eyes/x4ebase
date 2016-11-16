<?php
namespace X4e\X4ebase\ContentObject\Exception;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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

use Lemming\SentryClient\Client;
use TYPO3\CMS\Frontend\ContentObject\Exception\ProductionExceptionHandler;

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SentryProductionExceptionHandler extends ProductionExceptionHandler
{
    protected function logException(\Exception $exception, $errorMessage, $code)
    {
        parent::logException($exception, $errorMessage, $code);

        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sentry_client'])) {
            $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sentry_client']);
            if (isset($configuration['dsn']) && $configuration['dsn'] != '') {
                if (isset($configuration['productionOnly']) && (bool)$configuration['productionOnly'] === true) {
                    if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isProduction()) {
                        $this->handleSentryException($exception);
                    }
                } else {
                    $this->handleSentryException($exception);
                }
            }
        }
    }

    /**
     * @param \Exception $exception
     */
    public function handleSentryException($exception)
    {
        $client = new Client();
        $errorHandler = new \Raven_ErrorHandler($client, true);
        $errorHandler->handleException($exception);
    }
}
