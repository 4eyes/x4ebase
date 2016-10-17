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
 * Test case for class \X4e\X4ebase\Domain\Model\PageLanguageOverlay
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageLanguageOverlayTest extends \X4e\X4ebase\Tests\Unit\Base\ModelTestBase
{
    public function testInitialValues()
    {
        $this->initialValueTest('crdate', null);
        $this->initialValueTest('backendUser', null);
        $this->initialValueTest('sysLanguageUid', null);
        $this->initialValueTest('title', null);
        $this->initialValueTest('hidden', null);
        $this->initialValueTest('starttime', null);
        $this->initialValueTest('endtime', null);
        $this->initialValueTest('deleted', null);
        $this->initialValueTest('subtitle', null);
        $this->initialValueTest('navTitle', null);
        $this->initialValueTest('media', null);
        $this->initialValueTest('keywords', null);
        $this->initialValueTest('description', null);
        $this->initialValueTest('abstract', null);
        $this->initialValueTest('author', null);
        $this->initialValueTest('authorEmail', null);
        $this->initialValueTest('doktype', null);
        $this->initialValueTest('url', null);
        $this->initialValueTest('urltype', null);
        $this->initialValueTest('shortcut', null);
        $this->initialValueTest('shortcutMode', null);
    }

    /**
     * @test
     */
    public function testGettersSetters()
    {
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
        $this->objectStorageGetterSetterTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
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
    public function testAddingRemoving()
    {
        $this->objectStorageAddRemoveTest('media', \TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
    }
}
