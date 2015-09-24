<?php
namespace X4E\X4ebase\Domain\Repository;

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
 * A TYPO3 page record repository for extbase
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PageLanguageOverlayRepository extends AbstractRepository {

	/**
	 * Initializes the object
	 *
	 * @return void
	 */
	public function initializeObject() {
		/* @var $querySettings \X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings */
		$querySettings = $this->objectManager->get('X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$querySettings->setRespectSysLanguage(FALSE);
		//$querySettings->setRespectSysLanguageAlternative(FALSE);
		$this->setDefaultQuerySettings($querySettings);
	}

}