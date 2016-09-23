<?php
namespace X4e\X4ebase\XClasses\Controller;

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
 * @author Claus Due <claus@namelesscoder.net>
 */
class ConfigurationController extends \TYPO3\CMS\Extensionmanager\Controller\ConfigurationController
{
    public function saveConfiguration(array $config, $extensionKey)
    {
        parent::saveConfiguration($config, $extensionKey);
    }
}
