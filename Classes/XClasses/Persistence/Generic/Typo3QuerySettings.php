<?php
namespace X4E\X4ebase\XClasses\Persistence\Generic;

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
 * Query settings. This class is NOT part of the FLOW3 API.
 * It reflects the settings unique to TYPO3 4.x.
 */
class Typo3QuerySettings extends \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings implements AlternativeQuerySettingsInterface {

	/**
	 * Flag if the alternative implementation of sys_language_uid should be respected (default is FALSE).
	 *
	 * @var boolean
	 */
	protected $respectSysLanguageAlternative = FALSE;

	/**
	 * Returns the state, if an alternative language overlay should be performed.
	 *
	 * @return boolean TRUE, if a  and language overlay should be performed; otherwise FALSE.
	 */
	public function getRespectSysLanguageAlternative() {
		return $this->respectSysLanguageAlternative;
	}
	
	/**
	 * Sets the flag if an alternative language overlay should be performed.
	 *
	 * @param boolean $respectSysLanguageAlternative TRUE if a  and language overlay should be performed.
	 * @return \X4E\X4ebase\XClasses\Persistence\Generic\AlternativeQuerySettingsInterface (fluent interface)
	 * @api
	 */
	public function setRespectSysLanguageAlternative($respectSysLanguageAlternative) {
		$this->respectSysLanguageAlternative = $respectSysLanguageAlternative;
		return $this;
	}

}