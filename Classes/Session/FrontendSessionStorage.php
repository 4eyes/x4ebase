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
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FrontendSessionStorage extends \X4e\X4ebase\Session\AbstractSessionStorage {

	/**
	 * Read session data
	 *
	 * @param string $key
	 * @param string $type
	 * @return mixed
	 */
	public function get($key, $type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE) {
		return $this->getFrontendUser()->getKey($type, $this->getKey($key));
	}

	/**
	 * Write data to the session
	 *
	 * @param string $key
	 * @param mixed $data
	 * @param string $type
	 * @return void
	 */
	public function set($key, $data, $type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE) {
		$this->getFrontendUser()->setKey($type, $this->getKey($key), $data);
		//$this->getFrontendUser()->storeSessionData();
	}

	/**
	 * Remove data from the session
	 *
	 * @param string $key
	 * @param string $type
	 * @return void
	 */
	public function remove($key, $type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE) {
		if ($this->has($key, $type)) {
			$this->set($key, NULL, $type);
		}
	}

	/**
	 * Returns the whole sesData array
	 *
	 * @return array
	 */
	public function getAll(){
		return $this->getFrontendUser()->sesData;
	}

	/**
	 *
	 * @return \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
	 */
	protected function getFrontendUser() {
		return $GLOBALS['TSFE']->fe_user;
	}
}
