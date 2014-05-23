<?php
namespace X4E\X4ebase\ViewHelpers;

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

class ContentElementViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager; 

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 * @inject
	 */
	protected $cObj;

    /**
     * Parse a content element
     *
	 * @param	int			UID of any content element
     * @return 	string		Parsed Content Element
     */
    public function render($uid) {

		$conf = array( // config
			'tables' => 'tt_content',
			'source' => $uid,
			'dontCheckPid' => 1
		);
		ssdf
		return $this->cObj->RECORDS($conf);
    }
}