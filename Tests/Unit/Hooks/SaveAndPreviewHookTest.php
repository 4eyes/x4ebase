<?php

namespace X4e\X4ebase\Tests\Unit\Hooks;

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
 * Test case for class \X4e\X4ebase\Hooks\SaveAndPreviewHook
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class SaveAndPreviewHookTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\Hooks\SaveAndPreviewHook */
    protected $subject;

    /**
     * @test
     */
    public function testPreProcess()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );

        $this->mockSubject();
        $pageUid = 1;
        $backPath = '';
        $rootLine = [];
        $anchorSection = [];
        $viewScript = '';
        $additionalGetVars = [];
        $switchFocus = false;

        $tableData = [
            'pageUid' => 1,
            'viewScript' => 'helloWorld'
        ];

        $table = 'testTable';

        $pageTs = [
            'x4ebase.' => [
                'preview.' => [
                    $table . '.' => $tableData
                ]
            ]
        ];

        $backendUtility = $this->getAccessibleMock(\TYPO3\CMS\Backend\Utility\BackendUtility::class, ['getPageTSconfig'], [], '\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility', false);
        $backendUtility->expects($this->once())->method('getPageTSconfig')->willReturn($pageTs);

        $GLOBALS['_POST']['data'] = [$table => []];

        $this->subject->preProcess($pageUid, $backPath, $rootLine, $anchorSection, $viewScript, $additionalGetVars, $switchFocus);

        $this->assertEquals($tableData['pageUid'], $pageUid);
        $this->assertEquals($tableData['viewScript'], $viewScript);
    }
}
