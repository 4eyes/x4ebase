<?php

namespace X4E\X4ebase\ViewHelpers\PageRenderer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
class BackendLayoutViewHelper extends AbstractPageRendererViewHelper {

	/**
	 * Initialize all arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('pageUid', 'int', 'uid of page the backend layout should be returned', FALSE, NULL);
	}

	/**
	 * Returns the backend layout of the given pageuid. If no pageUid given the backend layout of current page is returned
	 * 
	 * @global \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $TSFE
	 * @global \TYPO3\CMS\Dbal\Database\DatabaseConnection $TYPO3_DB
	 * @return mixed integer|FALSE
	 */
	public function render() {
		global $TSFE;
		global $TYPO3_DB;
		
		$pageUid = $this->arguments['pageUid'] ? $this->arguments['pageUid'] : $GLOBALS['TSFE']->id;
		$page = $TYPO3_DB->exec_SELECTgetSingleRow('*', 'pages', 'uid=' . $pageUid);
		if ($page) {
			if ($page['backend_layout'] > 0 && $page['backend_layout']) {
				return $page["backend_layout"];
			}
			$rootline = $TSFE->sys_page->getRootLine($pageUid);
			foreach ($rootline as $p) {
				if ($p['backend_layout_next_level'] > 0) {
					if ($p['backend_layout_next_level'] && $p['uid'] !== $pageUid) {
						return $p['backend_layout_next_level'];
					} else {
						return FALSE;
					}
				}
			}
		}
		return FALSE;
	}
}