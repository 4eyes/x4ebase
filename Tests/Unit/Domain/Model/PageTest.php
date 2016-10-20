<?php

namespace X4e\X4ebase\Tests\Unit\Domain\Model;

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
 * Test case for class \X4e\X4ebase\Domain\Model\Page
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageTest extends \X4e\X4ebase\Tests\Unit\Base\ModelTestBase
{
    public function testInitialValues()
    {
        $this->initialValueTest('sorting', null);
        $this->initialValueTest('sysLanguageUid', 0);
        $this->initialValueTest('permsUserid', null);
        $this->initialValueTest('permsGroupid', null);
        $this->initialValueTest('permsUser', null);
        $this->initialValueTest('permsGroup', null);
        $this->initialValueTest('permsEverybody', null);
        $this->initialValueTest('editlock', null);
        $this->initialValueTest('cruserId', null);
        $this->initialValueTest('title', null);
        $this->initialValueTest('doktype', null);
        $this->initialValueTest('tsconfig', null);
        $this->initialValueTest('storagePid', null);
        $this->initialValueTest('isSiteroot', null);
        $this->initialValueTest('phpTreeStop', null);
        $this->initialValueTest('url', null);
        $this->initialValueTest('urltype', null);
        $this->initialValueTest('shortcut', null);
        $this->initialValueTest('shortcutMode', null);
        $this->initialValueTest('noCache', null);
        $this->initialValueTest('feGroup', null);
        $this->initialValueTest('subtitle', null);
        $this->initialValueTest('layout', null);
        $this->initialValueTest('target', null);
        $this->initialValueTest('media', null);
        $this->initialValueTest('lastupdated', null);
        $this->initialValueTest('keywords', null);
        $this->initialValueTest('cacheTimeout', null);
        $this->initialValueTest('newuntil', null);
        $this->initialValueTest('description', null);
        $this->initialValueTest('noSearch', null);
        $this->initialValueTest('abstract', null);
        $this->initialValueTest('module', null);
        $this->initialValueTest('extendtosubpages', null);
        $this->initialValueTest('author', null);
        $this->initialValueTest('authorEmail', null);
        $this->initialValueTest('navTitle', null);
        $this->initialValueTest('navHide', null);
        $this->initialValueTest('contentFromPid', null);
        $this->initialValueTest('mountPid', null);
        $this->initialValueTest('mountPidOl', null);
        $this->initialValueTest('alias', null);
        $this->initialValueTest('l18nCfg', null);
        $this->initialValueTest('feLoginMode', null);
        $this->initialValueTest('urlScheme', null);
        $this->initialValueTest('backendLayout', null);
        $this->initialValueTest('backendLayoutNextLevel', null);
        $this->initialValueTest('cacheTags', null);
        $this->initialValueTest('crdate', null);
        $this->initialValueTest('tstamp', null);
    }

    /**
     * @test
     */
    public function testGettersSetters()
    {
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
        $this->objectStorageGetterSetterTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
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
    public function testAddingRemoving()
    {
        $this->objectStorageAddRemoveTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
    }
}
