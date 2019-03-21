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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendUtility
{

    /**
     * Returns the page uid of the selected storage folder from the context of the given page uid.
     *
     * @param	int		$pageUid					Context page uid
     * @param	string		$modTSConfigStorageRef		An object string which determines the path of the TSconfig to return
     * @return	int		PID of the storage folder
     */
    public static function getStorageFolderPid($pageUid, $modTSConfigStorageRef = null)
    {
        // Negative PID values are pointing to a page on the same level as the current
        if ($pageUid < 0) {
            $pidRow = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecordWSOL('pages', abs($pageUid), 'pid');
            $pageUid = $pidRow['pid'];
        }
        $row = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecordWSOL('pages', $pageUid);

        $TSconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getTCEFORM_TSconfig('pages', $row);
        $storagePid = intval($TSconfig['_STORAGE_PID']);

            // Check for alternative storage folder
        if ($modTSConfigStorageRef !== null) {
            $modTSConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getModTSconfig($pageUid, $modTSConfigStorageRef);
            if (is_array($modTSConfig) && \TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($modTSConfig['value'])) {
                $storagePid = intval($modTSConfig['value']);
            }
        }

        return $storagePid;
    }

    /**
     * Returns a SQL query for selecting sys_language records.
     *
     * @global \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $BE_USER
     * @global \TYPO3\CMS\Core\Database\DatabaseConnection $TYPO3_DB
     * @param int $id Page id: If zero, the query will select all sys_language records from root level which are NOT hidden. If set to another value, the query will select all sys_language records that has a pages_language_overlay record on that page (and is not hidden, unless you are admin user)
     * @return string Return query string.
     * @see \TYPO3\CMS\Backend\Controller\PageLayoutController::exec_languageQuery()
     */
    public static function exec_languageQuery($id)
    {
        global $BE_USER, $TYPO3_DB;
        if ($id) {
            $exQ = \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause('pages_language_overlay') .
                ($BE_USER->isAdmin() ? '' : ' AND sys_language.hidden=0');
            return $TYPO3_DB->exec_SELECTquery(
                'sys_language.*',
                'pages_language_overlay,sys_language',
                'pages_language_overlay.sys_language_uid=sys_language.uid AND pages_language_overlay.pid=' . intval($id) . $exQ .
                    \TYPO3\CMS\Backend\Utility\BackendUtility::versioningPlaceholderClause('pages_language_overlay'),
                'pages_language_overlay.sys_language_uid,sys_language.uid,sys_language.pid,sys_language.tstamp,sys_language.hidden,sys_language.title,sys_language.static_lang_isocode,sys_language.flag',
                'sys_language.title'
            );
        } else {
            return $TYPO3_DB->exec_SELECTquery(
                'sys_language.*',
                'sys_language',
                'sys_language.hidden=0',
                '',
                'sys_language.title'
            );
        }
    }

    /**
     * Initialize Frontend
     * @param int $pageUid
     */
    public static function initTSFE($pid)
    {
        global $TYPO3_CONF_VARS;
        if ($pid == 0) {
            throw new Exception('No pageId defined!');
        } else {
            if (!isset($GLOBALS['TSFE'])) {
                // TODO: refactor as compatibility layer is removed with 6.2
                //require_once(PATH_tslib . 'class.tslib_content.php');

                \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
                \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser(); //Initializes FeUser

                /* @var $GLOBALS['TT'] \TYPO3\CMS\Core\TimeTracker\TimeTracker */
                $GLOBALS['TT'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TimeTracker\\TimeTracker');
                $GLOBALS['TT']->start();

                $GLOBALS['TSFE'] = new \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController($TYPO3_CONF_VARS, $pid, 0, true);
                $GLOBALS['TSFE']->initFEuser();
                $GLOBALS['TSFE']->determineId();
                $GLOBALS['TSFE']->newCObj();
                $GLOBALS['TSFE']->renderCharset = 'utf-8';
                self::initTypoScript();
                $GLOBALS['TSFE']->absRefPrefix = $GLOBALS['TSFE']->config['config']['absRefPrefix'];
            }
        }
    }

    /**
     * @return void
     */
    protected static function initTypoScript()
    {
        $GLOBALS['TSFE']->getPageAndRootline();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->getConfigArray();
    }
}
