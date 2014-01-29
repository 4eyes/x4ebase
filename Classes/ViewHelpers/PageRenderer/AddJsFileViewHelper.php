<?php
namespace X4E\X4ebase\ViewHelpers\PageRenderer;

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
class AddJsFileViewHelper extends AbstractPageRendererViewHelper {

	/**
	 * Initialize all arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('type', 'string', 'Type argument - see PageRenderer documentation', FALSE, 'text/javascript');
		$this->registerArgument('compress', 'boolean', 'Compress argument - see PageRenderer documentation', FALSE, TRUE);
		$this->registerArgument('forceOnTop', 'boolean', 'ForceOnTop argument - see PageRenderer documentation', FALSE, FALSE);
		$this->registerArgument('allWrap', 'string', 'AllWrap argument - see PageRenderer documentation', FALSE, '');
		$this->registerArgument('excludeFromConcatenation', 'string', 'ExcludeFromConcatenation argument - see PageRenderer documentation', FALSE, FALSE);
		$this->registerArgument('external', 'boolean', 'If set, there is no file existence check. Useful for inclusion of external files.', FALSE, FALSE);
	}

	/**
	 * Renders a JavaScript file in the page header.
	 *
	 * @global \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $TSFE
	 * @param string $file
	 */
	public function render($file) {
		global $TSFE;
		$fullPath = $this->arguments['external'] ? $file : $TSFE->tmpl->getFileName($file);
		if ($this->isCached()) {
			$this->pageRenderer->addJsFile(
				$fullPath,
				$this->arguments['type'],
				$this->arguments['compress'],
				$this->arguments['forceOnTop'],
				$this->arguments['allWrap'],
				$this->arguments['excludeFromConcatenation']
			);
		} else {
			$TSFE->additionalHeaderData[\md5($fullPath)] = '<script type="text/javascript" src="' . \htmlspecialchars($fullPath) . '"></script>';
		}
	}
}