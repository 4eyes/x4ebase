<?php

namespace X4e\X4ebase\Tests\Unit\Session;

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
 * Test case for class \X4e\X4ebase\Session\BackendSessionStorageTest
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class BackendSessionStorageTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{

    /** @var \X4e\X4ebase\Session\BackendSessionStorage|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
    protected $subject;

    public function testGet()
    {
        $this->mockSubject('getKey', 'getBackendUser');
        $backendUser = $this->createPartialMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class, ['getSessionData']);
        $backendUser->expects($this->once())->method('getSessionData');

        $this->subject->expects($this->once())->method('getBackendUser')->willReturn($backendUser);
        $this->subject->expects($this->once())->method('getKey')->with('lorem');
        $this->subject->get('lorem');
    }

    public function testSet()
    {
        $this->mockSubject('getKey', 'getBackendUser');
        $backendUser = $this->createPartialMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class, ['setAndSaveSessionData']);
        $backendUser->expects($this->once())->method('setAndSaveSessionData')->with('lorem', 'ipsum');

        $this->subject->expects($this->once())->method('getBackendUser')->willReturn($backendUser);
        $this->subject->expects($this->once())->method('getKey')->with('lorem')->willReturn('lorem');
        $this->subject->set('lorem', 'ipsum');
    }

    public function testRemove_NotHasKey_CallsNoDbUpdate()
    {
        $this->mockSubject('has');
        $this->subject->expects($this->once())->method('has')->willReturn(false);
        $databaseConnection = $this->createPartialMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, ['exec_UPDATEquery']);
        $databaseConnection->expects($this->never())->method('exec_UPDATEquery');
        $GLOBALS['TYPO3_DB'] = $databaseConnection;

        $this->subject->remove('lorem');
    }

    public function testRemove()
    {
        $this->mockSubject('has', 'getKey', 'getBackendUser');

        $ses_data = serialize(['lorem' => 42]);
        $user = [
            'ses_data' => $ses_data,
            'ses_id' => 1,
            'writeDevLog' => false
        ];
        $session_table = 'be_sessions';
        $backendUser = $this->createMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class);
        $backendUser->user = $user;
        $backendUser->session_table = $session_table;

        $databaseConnection = $this->createPartialMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, ['exec_UPDATEquery', 'fullQuoteStr']);
        $databaseConnection->expects($this->once())->method('fullQuoteStr')->with(1, 'be_sessions')->willReturn('HelloWorld');
        $databaseConnection->expects($this->once())->method('exec_UPDATEquery')->with(
            $session_table, 'ses_id=HelloWorld', ['ses_data' => '']
        );
        $GLOBALS['TYPO3_DB'] = $databaseConnection;

        $this->subject->expects($this->once())->method('has')->willReturn(true);
        $this->subject->expects($this->any())->method('getBackendUser')->willReturn($backendUser);
        $this->subject->expects($this->once())->method('getKey')->willReturn('lorem');

        $this->subject->remove('lorem');
    }

    public function testGetBackendUser()
    {
        $this->mockSubject();
        $GLOBALS['BE_USER'] = 'LoremIpsumDolor';
        $this->assertSame('LoremIpsumDolor', $this->subject->_call('getBackendUser'));
    }
}
