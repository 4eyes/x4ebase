<?php

namespace X4E\X4ebase\Tests\Unit\Domain\Model;

	/* * *************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2015 Philipp Seßner <philipp@4eyes.ch>, 4eyes GmbH
	 *
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
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
	 * ************************************************************* */

/**
 * Test case for class \X4E\X4ebase\Domain\Model\PageLanguageOverlay
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageLanguageOverlayTest extends \X4E\X4ebase\Tests\Unit\Base\ModelTestBase {

	public function testInitialValues() {
		$this->initialValueTest('crdate', NULL);
		$this->initialValueTest('backendUser', NULL);
		$this->initialValueTest('sysLanguageUid', NULL);
		$this->initialValueTest('title', NULL);
		$this->initialValueTest('hidden', NULL);
		$this->initialValueTest('starttime', NULL);
		$this->initialValueTest('endtime', NULL);
		$this->initialValueTest('deleted', NULL);
		$this->initialValueTest('subtitle', NULL);
		$this->initialValueTest('navTitle', NULL);
		$this->initialValueTest('media', NULL);
		$this->initialValueTest('keywords', NULL);
		$this->initialValueTest('description', NULL);
		$this->initialValueTest('abstract', NULL);
		$this->initialValueTest('author', NULL);
		$this->initialValueTest('authorEmail', NULL);
		$this->initialValueTest('doktype', NULL);
		$this->initialValueTest('url', NULL);
		$this->initialValueTest('urltype', NULL);
		$this->initialValueTest('shortcut', NULL);
		$this->initialValueTest('shortcutMode', NULL);
	}

	/**
	 * @test
	 */
	public function testGettersSetters() {
		$this->integerGetterSetterTest('crdate');
		$this->integerGetterSetterTest('backendUser');
		$this->integerGetterSetterTest('sysLanguageUid');
		$this->stringGetterSetterTest('title');
		$this->integerGetterSetterTest('hidden');
		$this->integerGetterSetterTest('starttime');
		$this->integerGetterSetterTest('endtime');
		$this->integerGetterSetterTest('deleted');
		$this->stringGetterSetterTest('subtitle');
		$this->stringGetterSetterTest('navTitle');
		$this->objectStorageGetterSetterTest('media');
		$this->stringGetterSetterTest('keywords');
		$this->stringGetterSetterTest('description');
		$this->stringGetterSetterTest('abstract');
		$this->stringGetterSetterTest('author');
		$this->stringGetterSetterTest('authorEmail');
		$this->integerGetterSetterTest('doktype');
		$this->stringGetterSetterTest('url');
		$this->integerGetterSetterTest('urltype');
		$this->integerGetterSetterTest('shortcut');
		$this->integerGetterSetterTest('shortcutMode');
	}

	/**
	 * @test
	 */
	public function testAddingRemoving() {
		$this->objectStorageAddRemoveTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
	}

}
