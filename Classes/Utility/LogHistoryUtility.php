<?php
namespace X4e\X4ebase\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
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
 */
class LogHistoryUtility {


	static public function writeHistoryEntry($tablename, $recuid, $fieldArray = array(), $recpid = 0, $userId = 0, $workspaceId = 0){
		/**
		 * @var \TYPO3\CMS\Core\DataHandling\DataHandler
		 */
		$dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');

		self::fillMmHistoryRecords($dataHandler, $tablename, $fieldArray, $recuid);

		$logId = self::writeLog(
				4, // type, 4 = ext
				0, // action
				0, // error
				0, // details nr
				'', //details
				'', // data
				$tablename,
				$recuid,
				$recpid,
				-1, // eventpid
				'', // NEWid
				$userId,
				$workspaceId
		);

		$feuser = $GLOBALS['TSFE']->fe_user->user;
		if(isset($feuser['uid'])){
			$fieldArray['lastchange'] = $feuser['username'] . ' (' . $feuser['uid'] . ')';
		}

		$dataHandler->compareFieldArrayWithCurrentAndUnset($tablename, $recuid, $fieldArray);
		// Set History data:
		$dataHandler->setHistory($tablename, $recuid, $logId);
	}
	/**
	 * Writes an entry in the logfile/table
	 * Documentation in "TYPO3 Core API"
	 *
	 * @param integer $type Denotes which module that has submitted the entry. See "TYPO3 Core API". Use "4" for extensions.
	 * @param integer $action Denotes which specific operation that wrote the entry. Use "0" when no sub-categorizing applies
	 * @param integer $error Flag. 0 = message, 1 = error (user problem), 2 = System Error (which should not happen), 3 = security notice (admin)
	 * @param integer $details_nr The message number. Specific for each $type and $action. This will make it possible to translate errormessages to other languages
	 * @param string $details Default text that follows the message (in english!). Possibly translated by identification through type/action/details_nr
	 * @param array $data Data that follows the log. Might be used to carry special information. If an array the first 5 entries (0-4) will be sprintf'ed with the details-text
	 * @param string $tablename Table name. Special field used by tce_main.php.
	 * @param integer $recuid Record UID. Special field used by tce_main.php.
	 * @param integer $recpid Record PID. Special field used by tce_main.php. OBSOLETE
	 * @param integer $event_pid The page_uid (pid) where the event occurred. Used to select log-content for specific pages.
	 * @param string $NEWid Special field used by tce_main.php. NEWid string of newly created records.
	 * @param integer $userId Alternative Backend User ID (used for logging login actions where this is not yet known).
	 * @return integer Log entry ID.
	 * @todo Define visibility
	 */
	static public function writelog($type, $action, $error, $details_nr, $details, $data, $tablename = '', $recuid = '', $recpid = '', $event_pid = -1, $NEWid = '', $userId = 0, $workspace = 0) {
		$fields_values = array(
			'userid' => $userId,
			'type' => intval($type),
			'action' => intval(2),
			'error' => intval($error),
			'details_nr' => intval($details_nr),
			'details' => $details,
			'log_data' => serialize($data),
			'tablename' => $tablename,
			'recuid' => intval($recuid),
			'tstamp' => $GLOBALS['EXEC_TIME'],
			'event_pid' => intval($event_pid),
			'NEWid' => $NEWid,
			'workspace' => $workspace
		);
		
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REMOTE_ADDR')) {
			$fields_values['IP'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REMOTE_ADDR');
		}
		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery('sys_log', $fields_values);
		return $GLOBALS['TYPO3_DB']->sql_insert_id();
	}


	/**
	 * Fill mm relations for history records to provide a corrent oldRecord entry in sys_history
	 *
	 * @global array $TCA
	 * @param object $dataHandler
	 * @param string $tablename
	 * @param array $fieldArray
	 * @param integer $recUid
	 */
	static public function fillMmHistoryRecords($dataHandler, $tablename, $fieldArray, $recUid){
		global $TCA;

		foreach($fieldArray as $fN => $v){
			$fieldConf = $TCA[$tablename]['columns'][$fN]['config'];
			if(isset($fieldConf['MM'])){
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_foreign', $fieldConf['MM'], 'uid_local=' . (INT)$recUid, '', 'sorting');
				$uids = array();
				while($currentRecord = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
					$uids[] = $currentRecord['uid_foreign'];
				}
				$dataHandler->mmHistoryRecords[($tablename . ':' . $recUid)]['oldRecord'][$fN] = implode(',',$uids);
			}
		}
	}

}