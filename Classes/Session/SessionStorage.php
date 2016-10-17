<?php
namespace X4e\X4ebase\Session;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *           Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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
class SessionStorage implements \X4e\X4ebase\Session\SessionStorageInterface
{
    const COOKIE_SESSION_STORAGE = 'ses';

    const DB_SESSION_STORAGE = 'user';

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * @var \X4e\X4ebase\Session\SessionStorageInterface
     */
    protected $concreteSessionStorage = null;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->initializeConcreteSessionStorage();
    }

    /**
     * @return void
     */
    protected function initializeConcreteSessionStorage()
    {
        /* @var $environmentService \TYPO3\CMS\Extbase\Service\EnvironmentService */
        $environmentService = $this->objectManager->get('TYPO3\CMS\Extbase\Service\EnvironmentService');
        if ($environmentService->isEnvironmentInFrontendMode()) {
            $this->concreteSessionStorage = $this->objectManager->get('X4e\X4ebase\Session\FrontendSessionStorage');
        } elseif ($environmentService->isEnvironmentInBackendMode()) {
            $this->concreteSessionStorage = $this->objectManager->get('X4e\X4ebase\Session\BackendSessionStorage');
        } else {
            $this->concreteSessionStorage = $this->objectManager->get('X4e\X4ebase\Session\NullSessionStorage');
        }
    }

    /**
     *
     * @param string $key
     */
    public function get($key, $type = self::COOKIE_SESSION_STORAGE)
    {
        return $this->concreteSessionStorage->get($key, $type);
    }

    /**
     * Write data to session
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data, $type = self::COOKIE_SESSION_STORAGE)
    {
        $this->concreteSessionStorage->set($key, $data, $type);
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function has($key, $type = self::COOKIE_SESSION_STORAGE)
    {
        return $this->concreteSessionStorage->has($key, $type);
    }

    /**
     *
     * @param string $key
     */
    public function remove($key, $type = self::COOKIE_SESSION_STORAGE)
    {
        $this->concreteSessionStorage->remove($key, $type);
    }

    /**
     *
     * @return \X4e\X4ebase\Session\SessionStorageInterface
     */
    public function getConcreteSessionStorage()
    {
        return $this->concreteSessionStorage;
    }
}
