<?php
namespace X4E\X4ebase\XClasses\Persistence\Generic\Storage;

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
 * A Storage backend
 */
class Typo3DbBackend extends \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbBackend {
	
	/**
	 * Adds additional WHERE statements according to the query settings.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings The TYPO3 CMS specific query settings
	 * @param string $tableName The table name to add the additional where clause for
	 * @param string &$sql
	 * @return void
	 */
	protected function addAdditionalWhereClause(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings, $tableName, &$sql) {
		$this->addVisibilityConstraintStatement($querySettings, $tableName, $sql);
		if ($querySettings->getRespectSysLanguage()) {
			$this->addSysLanguageStatement($tableName, $sql, $querySettings);
		}
		/* NEW @ 4eyes -- start */
		elseif ($querySettings instanceof \X4E\X4ebase\XClasses\Persistence\Generic\AlternativeQuerySettingsInterface && $querySettings->getRespectSysLanguageAlternative()) {
			$this->addAlternativeSysLanguageStatement($tableName, $sql, $querySettings);
		}
		/* NEW @ 4eyes -- end */
		if ($querySettings->getRespectStoragePage()) {
			$this->addPageIdStatement($tableName, $sql, $querySettings->getStoragePageIds());
		}
	}
	
	/**
	 * Builds the language field statement
	 *
	 * @param string $tableName The database table name
	 * @param array &$sql The query parts
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings The TYPO3 CMS specific query settings
	 * @return void
	 */
	protected function addSysLanguageStatement($tableName, array &$sql, $querySettings) {
		if (is_array($GLOBALS['TCA'][$tableName]['ctrl'])) {
			if (!empty($GLOBALS['TCA'][$tableName]['ctrl']['languageField'])) {
				// Select all entries for the current language
				$additionalWhereClause = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (' . intval($querySettings->getLanguageUid()) . ',-1)';
				// If any language is set -> get those entries which are not translated yet
				// They will be removed by t3lib_page::getRecordOverlay if not matching overlay mode
				if (isset($GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'])
					&& $querySettings->getLanguageUid() > 0
				) {
					$additionalWhereClause .= ' OR (' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=0' .
						' AND ' . $tableName . '.uid NOT IN (SELECT ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] .
						' FROM ' . $tableName .
						' WHERE ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '>0' .
						/* NEW @ 4eyes -- start */
						//' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '>0';
						' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval($querySettings->getLanguageUid());
						/* NEW @ 4eyes -- end */

					// Add delete clause to ensure all entries are loaded
					if (isset($GLOBALS['TCA'][$tableName]['ctrl']['delete'])) {
						$additionalWhereClause .= ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['delete'] . '=0';
					}
					$additionalWhereClause .= '))';
				}
				$sql['additionalWhereClause'][] = '(' . $additionalWhereClause . ')';
			}
		}
	}
	
	/**
	 * NEW @ 4eyes
	 * Builds the alternative language field statement
	 *
	 * @param string $tableName The database table name
	 * @param array &$sql The query parts
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings The TYPO3 CMS specific query settings
	 * @return void
	 */
	protected function addAlternativeSysLanguageStatement($tableName, array &$sql, $querySettings) {
		if (is_array($GLOBALS['TCA'][$tableName]['ctrl'])) {
			if (!empty($GLOBALS['TCA'][$tableName]['ctrl']['languageField'])) {
				// Select all entries for the current language
				$additionalWhereClause = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (-1,0)';
				// If any language is set -> get those entries which are not translated yet
				// They will be removed by t3lib_page::getRecordOverlay if not matching overlay mode
				if (isset($GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'])
					&& $querySettings->getLanguageUid() > 0
				) {
					$additionalWhereClause .= ' OR ('
						. $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval($querySettings->getLanguageUid())
						. ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '=0'
						. ')';
				}
				$sql['additionalWhereClause'][] = '(' . $additionalWhereClause . ')';
			}
		}
	}
	
	/**
	 * Performs workspace and language overlay on the given row array. The language and workspace id is automatically
	 * detected (depending on FE or BE context). You can also explicitly set the language/workspace id.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source The source (selector od join)
	 * @param array $rows
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings The TYPO3 CMS specific query settings
	 * @param null|integer $workspaceUid
	 * @return array
	 */
	protected function doLanguageAndWorkspaceOverlay(\TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source, array $rows, $querySettings, $workspaceUid = NULL) {
		if ($source instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SelectorInterface) {
			$tableName = $source->getSelectorName();
		} elseif ($source instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Qom\JoinInterface) {
			$tableName = $source->getRight()->getSelectorName();
		}
		// If we do not have a table name here, we cannot do an overlay and return the original rows instead.
		if (isset($tableName)) {
			$pageRepository = $this->getPageRepository();
			if (is_object($GLOBALS['TSFE'])) {
				$languageMode = $GLOBALS['TSFE']->sys_language_mode;
				if ($workspaceUid !== NULL) {
					$pageRepository->versioningWorkspaceId = $workspaceUid;
				}
			} else {
				$languageMode = '';
				if ($workspaceUid === NULL) {
					$workspaceUid = $GLOBALS['BE_USER']->workspace;
				}
				$pageRepository->versioningWorkspaceId = $workspaceUid;
			}

			$overlayedRows = array();
			foreach ($rows as $row) {
				// If current row is a translation select its parent
				if (isset($tableName) && isset($GLOBALS['TCA'][$tableName])
					&& isset($GLOBALS['TCA'][$tableName]['ctrl']['languageField'])
					&& isset($GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'])
				) {
					if (isset($row[$GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField']])
						&& $row[$GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField']] > 0
					) {
						$newRow = $this->databaseHandle->exec_SELECTgetSingleRow(
							$tableName . '.*',
							$tableName,
							$tableName . '.uid=' . (integer) $row[$GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField']] .
								' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=0'
						);
						/* NEW @ 4eyes -- start */
						if (!$newRow) {
							$overlayedRows[] = $row;
							continue;
						} else {
							$row = $newRow;
						}
						/* NEW @ 4eyes -- end */
						unset($newRow);
					}
				}
				$pageRepository->versionOL($tableName, $row, TRUE);
				if ($pageRepository->versioningPreview && isset($row['_ORIG_uid'])) {
					$row['uid'] = $row['_ORIG_uid'];
				}
				if ($tableName == 'pages') {
					$row = $pageRepository->getPageOverlay($row, $querySettings->getLanguageUid());
				} elseif (isset($GLOBALS['TCA'][$tableName]['ctrl']['languageField'])
					&& $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] !== ''
				) {
					if (in_array($row[$GLOBALS['TCA'][$tableName]['ctrl']['languageField']], array(-1, 0))) {
						$overlayMode = $languageMode === 'strict' ? 'hideNonTranslated' : '';
						$row = $pageRepository->getRecordOverlay($tableName, $row, $querySettings->getLanguageUid(), $overlayMode);
					}
				}
				if ($row !== NULL && is_array($row)) {
					$overlayedRows[] = $row;
				}
			}
		} else {
			$overlayedRows = $rows;
		}
		return $overlayedRows;
	}
	
}