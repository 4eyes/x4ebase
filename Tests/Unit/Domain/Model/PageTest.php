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
 * Test case for class \X4E\X4ebase\Domain\Model\Page
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageTest extends \X4E\X4ebase\Tests\Unit\Base\ModelTestBase {
	public function testInitialValues() {
		$this->initialValueTest('sorting', NULL);
		$this->initialValueTest('sysLanguageUid', 0);
		$this->initialValueTest('permsUserid', NULL);
		$this->initialValueTest('permsGroupid', NULL);
		$this->initialValueTest('permsUser', NULL);
		$this->initialValueTest('permsGroup', NULL);
		$this->initialValueTest('permsEverybody', NULL);
		$this->initialValueTest('editlock', NULL);
		$this->initialValueTest('cruserId', NULL);
		$this->initialValueTest('title', NULL);
		$this->initialValueTest('doktype', NULL);
		$this->initialValueTest('tsconfig', NULL);
		$this->initialValueTest('storagePid', NULL);
		$this->initialValueTest('isSiteroot', NULL);
		$this->initialValueTest('phpTreeStop', NULL);
		$this->initialValueTest('url', NULL);
		$this->initialValueTest('urltype', NULL);
		$this->initialValueTest('shortcut', NULL);
		$this->initialValueTest('shortcutMode', NULL);
		$this->initialValueTest('noCache', NULL);
		$this->initialValueTest('feGroup', NULL);
		$this->initialValueTest('subtitle', NULL);
		$this->initialValueTest('layout', NULL);
		$this->initialValueTest('target', NULL);
		$this->initialValueTest('media', NULL);
		$this->initialValueTest('lastupdated', NULL);
		$this->initialValueTest('keywords', NULL);
		$this->initialValueTest('cacheTimeout', NULL);
		$this->initialValueTest('newuntil', NULL);
		$this->initialValueTest('description', NULL);
		$this->initialValueTest('noSearch', NULL);
		$this->initialValueTest('abstract', NULL);
		$this->initialValueTest('module', NULL);
		$this->initialValueTest('extendtosubpages', NULL);
		$this->initialValueTest('author', NULL);
		$this->initialValueTest('authorEmail', NULL);
		$this->initialValueTest('navTitle', NULL);
		$this->initialValueTest('navHide', NULL);
		$this->initialValueTest('contentFromPid', NULL);
		$this->initialValueTest('mountPid', NULL);
		$this->initialValueTest('mountPidOl', NULL);
		$this->initialValueTest('alias', NULL);
		$this->initialValueTest('l18nCfg', NULL);
		$this->initialValueTest('feLoginMode', NULL);
		$this->initialValueTest('urlScheme', NULL);
		$this->initialValueTest('backendLayout', NULL);
		$this->initialValueTest('backendLayoutNextLevel', NULL);
		$this->initialValueTest('cacheTags', NULL);
		$this->initialValueTest('crdate', NULL);
		$this->initialValueTest('tstamp', NULL);
	}

	/**
	 * @test
	 */
	public function testGettersSetters() {
		$this->integerGetterSetterTest('sorting');
		$this->integerGetterSetterTest('sysLanguageUid');
		$this->integerGetterSetterTest('permsUserid');
		$this->integerGetterSetterTest('permsGroupid');
		$this->integerGetterSetterTest('permsUser');
		$this->integerGetterSetterTest('permsGroup');
		$this->integerGetterSetterTest('permsEverybody');
		$this->integerGetterSetterTest('editlock');
		$this->integerGetterSetterTest('cruserId');
		$this->stringGetterSetterTest('title');
		$this->integerGetterSetterTest('doktype');
		$this->stringGetterSetterTest('tsconfig');
		$this->integerGetterSetterTest('storagePid');
		$this->integerGetterSetterTest('isSiteroot');
		$this->integerGetterSetterTest('phpTreeStop');
		$this->stringGetterSetterTest('url');
		$this->integerGetterSetterTest('urltype');
		$this->integerGetterSetterTest('shortcut');
		$this->integerGetterSetterTest('shortcutMode');
		$this->integerGetterSetterTest('noCache');
		$this->stringGetterSetterTest('feGroup');
		$this->stringGetterSetterTest('subtitle');
		$this->integerGetterSetterTest('layout');
		$this->stringGetterSetterTest('target');
		$this->objectStorageGetterSetterTest('media');
		$this->integerGetterSetterTest('lastupdated');
		$this->stringGetterSetterTest('keywords');
		$this->integerGetterSetterTest('cacheTimeout');
		$this->integerGetterSetterTest('newuntil');
		$this->stringGetterSetterTest('description');
		$this->integerGetterSetterTest('noSearch');
		$this->stringGetterSetterTest('abstract');
		$this->stringGetterSetterTest('module');
		$this->integerGetterSetterTest('extendtosubpages');
		$this->stringGetterSetterTest('author');
		$this->stringGetterSetterTest('authorEmail');
		$this->stringGetterSetterTest('navTitle');
		$this->integerGetterSetterTest('navHide');
		$this->integerGetterSetterTest('contentFromPid');
		$this->integerGetterSetterTest('mountPid');
		$this->integerGetterSetterTest('mountPidOl');
		$this->stringGetterSetterTest('alias');
		$this->integerGetterSetterTest('l18nCfg');
		$this->integerGetterSetterTest('feLoginMode');
		$this->integerGetterSetterTest('urlScheme');
		$this->integerGetterSetterTest('backendLayout');
		$this->integerGetterSetterTest('backendLayoutNextLevel');
		$this->stringGetterSetterTest('cacheTags');
		$this->dateTimeGetterSetterTest('crdate');
		$this->dateTimeGetterSetterTest('tstamp');
	}

	/**
	 * @test
	 */
	public function testAddingRemoving() {
		$this->objectStorageAddRemoveTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
	}

}
