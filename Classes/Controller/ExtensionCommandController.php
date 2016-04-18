<?php
namespace X4E\X4ebase\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * CommandController for working with extension management through CLI/scheduler
 *
 * @author Markus Stauffiger <markus@4eyes.ch>
 */
class ExtensionCommandController extends \TYPO3\CMS\Extensionmanager\Command\ExtensionCommandController {

    /**
     * Command to configure a extension
     *
     * @param string $config
     * @param string $extensionKey
     */
    public function configureCommand($config, $extensionKey) {
        parse_str($config, $configArr);
        /** @var $service \TYPO3\CMS\Extensionmanager\Controller\ConfigurationController */
        $service = $this->objectManager->get('TYPO3\\CMS\\Extensionmanager\\Controller\\ConfigurationController');
        $service->saveConfiguration($configArr, $extensionKey);
    }

}
