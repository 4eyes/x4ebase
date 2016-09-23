<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\PageRenderer;

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
 * Test case for class \X4e\X4ebase\ViewHelpers\PageRenderer\BackendLayoutViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class BackendLayoutViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\PageRenderer\BackendLayoutViewHelper */
    protected $subject;

    /**
     * @test
     */
    public function testInitializeArguments()
    {
        $this->initializeArgumentsTest(1);
    }

    /**
     * @test
     */
    public function testRender_NoPage_ReturnsFalse()
    {
        global $TYPO3_DB;
        $TYPO3_DB = $this->getMock(
            \TYPO3\CMS\Core\Database\DatabaseConnection::class,
            ['exec_SELECTgetSingleRow']
        );
        $TYPO3_DB->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn(false);

        $this->subject->setArguments(['pageUid' => 1]);
        $this->assertEquals(false, $this->subject->render());
    }

    /**
     * @test
     */
    public function testRender_PageBackendLayoutGTZ_ReturnsBackendLayout()
    {
        global $TYPO3_DB;
        $TYPO3_DB = $this->getMock(
            \TYPO3\CMS\Core\Database\DatabaseConnection::class,
            ['exec_SELECTgetSingleRow']
        );
        $page = [
            'backend_layout' => 1
        ];
        $TYPO3_DB->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn($page);

        $this->subject->setArguments(['pageUid' => 1]);
        $this->assertEquals(1, $this->subject->render());
    }

    /**
     * @test
     */
    public function testRender_PageBackendLayoutFalse_BackendLayoutNextlevelGTZ_ReturnsBackendLayout()
    {
        global $TYPO3_DB;
        global $TSFE;
        $TYPO3_DB = $this->getMock(
            \TYPO3\CMS\Core\Database\DatabaseConnection::class,
            ['exec_SELECTgetSingleRow']
        );
        $page = [
            'backend_layout' => false
        ];
        $TYPO3_DB->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn($page);

        $TSFE = new TSFE_object();
        $TSFE->sys_page = $this->getMock(
            \TYPO3\CMS\Frontend\Page\PageRepository::class,
            ['getRootLine']
        );
        $rootline = [
            [
                'backend_layout_next_level' => 1,
                'uid' => 0
            ]
        ];
        $TSFE->sys_page->expects($this->once())->method('getRootLine')->willReturn($rootline);

        $this->subject->setArguments(['pageUid' => 1]);
        $this->assertEquals(1, $this->subject->render());
    }

    /**
     * @test
     */
    public function testRender_PageBackendLayoutFalse_BackendLayoutNextlevelGTZ_SamePage_ReturnsFalse()
    {
        global $TYPO3_DB;
        global $TSFE;
        $TYPO3_DB = $this->getMock(
            \TYPO3\CMS\Core\Database\DatabaseConnection::class,
            ['exec_SELECTgetSingleRow']
        );
        $page = [
            'backend_layout' => false
        ];
        $TYPO3_DB->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn($page);

        $TSFE = new TSFE_object();
        $TSFE->sys_page = $this->getMock(
            \TYPO3\CMS\Frontend\Page\PageRepository::class,
            ['getRootLine']
        );
        $rootline = [
            [
                'backend_layout_next_level' => 1,
                'uid' => 1
            ]
        ];
        $TSFE->sys_page->expects($this->once())->method('getRootLine')->willReturn($rootline);

        $this->subject->setArguments(['pageUid' => 1]);
        $this->assertEquals(false, $this->subject->render());
    }
}

class TSFE_object
{
    public $sys_page = null;
}
