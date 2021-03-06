<?php
namespace X4e\X4ebase\ViewHelpers\Be\PageRenderer;

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
 *
 */
class AddCssFileViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper {

	/**
	 * Initialize all arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('rel', 'string', 'Rel argument - see PageRenderer documentation', FALSE, 'stylesheet');
		$this->registerArgument('media', 'strong', 'Media argument - see PageRenderer documentation', FALSE, 'all');
		$this->registerArgument('title', 'string', 'Title argument - see PageRenderer documentation', FALSE, '');
		$this->registerArgument('compress', 'boolean', 'Compress argument - see PageRenderer documentation', FALSE, TRUE);
		$this->registerArgument('forceOnTop', 'boolean', 'ForceOnTop argument - see PageRenderer documentation', FALSE, FALSE);
		$this->registerArgument('allWrap', 'string', 'AllWrap argument - see PageRenderer documentation', FALSE, '');
		$this->registerArgument('excludeFromConcatenation', 'string', 'ExcludeFromConcatenation argument - see PageRenderer documentation', FALSE, FALSE);
		$this->registerArgument('external', 'boolean', 'If set, there is no file existence check. Useful for inclusion of external files.', FALSE, FALSE);
	}

	/**
	 * Renders a CSS file in the page header.
	 *
	 * @param string $file
	 */
	public function render($file) {
		$doc = $this->getDocInstance();
		$pageRenderer = $doc->getPageRenderer();
		if ($this->arguments['external']) {
			$fullPath = $file;
		} else {
			$fullPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($file);
			$fullPath = \rtrim(\TYPO3\CMS\Core\Utility\PathUtility::getRelativePath(PATH_typo3, $fullPath), '/');
		}
		$pageRenderer->addCssFile(
			$fullPath,
			$this->arguments['rel'],
			$this->arguments['media'],
			$this->arguments['title'],
			$this->arguments['compress'],
			$this->arguments['forceOnTop'],
			$this->arguments['allWrap'],
			$this->arguments['excludeFromConcatenation']
		);
	}
	
}