<?php
namespace X4E\X4ebase\Session;

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
class BackendSessionStorage extends \X4E\X4ebase\Session\AbstractSessionStorage {

	/**
	 * Read session data
	 * 
	 * @param string $key
	 * @param string $type
	 * @return mixed
	 */
	public function get($key, $type = '') {
		return $this->getBackendUser()->getSessionData($this->getKey($key));
	}

	/**
	 * Write data to the session
	 * 
	 * @param string $key
	 * @param mixed $data
	 * @param string $type
	 * @return void
	 */
	public function set($key, $data, $type = '') {
		$this->getBackendUser()->setAndSaveSessionData($this->getKey($key), $data);
	}
	
	/**
	 * Remove data from the session
	 * 
	 * @param string $key
	 * @param string $type
	 * @return void
	 */
	public function remove($key, $type = '') {
		if ($this->has($key)) {
			$sesDat = unserialize($this->getBackendUser()->user['ses_data']);
			unset($sesDat[$this->getKey($key)]);
			$this->getBackendUser()->user['ses_data'] = (!empty($sesDat) ? serialize($sesDat) : '');
			if ($this->getBackendUser()->writeDevLog) {
				\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('setAndSaveSessionData: ses_id = ' . $this->getBackendUser()->user['ses_id'], 'TYPO3\CMS\Core\Authentication\AbstractUserAuthentication');
			}
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
					$this->getBackendUser()->session_table, 
					'ses_id=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->getBackendUser()->user['ses_id'], $this->getBackendUser()->session_table), 
					array('ses_data' => $this->getBackendUser()->user['ses_data'])
				);
		}
	}

	/**
	 *
	 * @param \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
	 */
	protected function getBackendUser() {
		return $GLOBALS['BE_USER'];
	}

}