<?php

namespace X4e\X4ebase\Tests\Unit\Utility;

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
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use X4e\X4ebase\Utility\EmailUtility;

/**
 * Test case for class \X4e\X4ebase\Utility\EmailUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class EmailUtilityTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|EmailUtility */
    protected $subject;

    public function testLogEmail_SendsEmail_AND_LogsEmail()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );
        $this->mockSubject('logEmail');

        $request = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Mvc\Request::class, [], [], '', false);

        $emailView = $this->getAccessibleMock(\TYPO3\CMS\Fluid\View\StandaloneView::class, ['render', 'assignMultiple', 'getRequest'], [], '', false);
        $emailView->expects($this->once())->method('render')->willReturn('Hello');
        $emailView->expects($this->once())->method('getRequest')->willReturn($request);
        $message = $this->getAccessibleMock(\TYPO3\CMS\Core\Mail\MailMessage::class, ['send', 'isSent', 'setTo', 'setFrom', 'setReplyTo', 'setSubject', 'attach', 'setBody'], [], '', false);
        $message->expects($this->once())->method('send');
        $message->expects($this->once())->method('isSent')->willReturn(true);
        $message->expects($this->once())->method('setTo')->willReturn($message);
        $message->expects($this->once())->method('setFrom')->willReturn($message);
        $message->expects($this->once())->method('setReplyTo')->willReturn($message);
        $message->expects($this->once())->method('setSubject')->willReturn($message);
        $message->expects($this->once())->method('attach')->willReturn($message);
        $message->expects($this->once())->method('setBody')->willReturn($message);

        $objectManager = $this->getAccessibleMock(
            ObjectManager::class, ['get'], [], '', false
        );
        $objectManager->expects($this->at(0))->method('get')->willReturn($emailView);
        $objectManager->expects($this->at(1))->method('get')->willReturn($message);

        $subject = $this->subject;

        $this->subject->_setStatic('objectManager', $objectManager);

        $this->subject->sendTemplateEmail(['test@example.org'], [''], '', '', '', '', '', [], 'x4ebase', 'Email', true, [1]);
    }

    /**
     * @test
     */
    public function testLogEmail_PersistsEmailLog()
    {
        $this->mockSubject();
        $emailLogRepository = $this->getAccessibleMock(\X4e\X4ebase\Domain\Repository\EmailLogRepository::class, ['add'], [], '', false);
        $emailLog = $this->createPartialMock(\X4e\X4ebase\Domain\Model\EmailLog::class, ['dummy']);

        $objectManager = $this->getAccessibleMock(
            ObjectManager::class, ['get'], [], '', false
        );
        $objectManager->expects($this->at(0))->method('get')
            ->with('X4e\\X4ebase\\Domain\\Repository\\EmailLogRepository')
            ->willReturn($emailLogRepository);

        $objectManager->expects($this->at(1))->method('get')
            ->with('X4e\\X4ebase\\Domain\\Model\\EmailLog')
            ->willReturn($emailLog);

        $persistenceManager = $this->getAccessibleMock(PersistenceManager::class, ['persistAll'], [], '', false);
        $persistenceManager->expects($this->once())->method('persistAll');

        //$this->setExpectedException('TYPO3\\CMS\\Extbase\\Persistence\\Exception');

        $this->subject->_setStatic('objectManager', $objectManager);
        $this->subject->_setStatic('persistenceManager', $persistenceManager);

        $this->subject->logEmail(['test@example.org'], [''], '', '', true, ['test@example.org'], 0, false, true);
    }

    /**
     * @test
     */
    public function testLogEmail_ThrowsException()
    {
        $this->mockSubject();

        $objectManager = $this->getAccessibleMock(
            ObjectManager::class, ['get'], [], '', false
        );
        $objectManager->expects($this->at(0))->method('get')
            ->with('X4e\\X4ebase\\Domain\\Repository\\EmailLogRepository')
            ->willReturn(false);

        $persistenceManager = $this->getAccessibleMock(PersistenceManager::class, ['persistAll'], [], '', false);

        $this->expectException(\TYPO3\CMS\Extbase\Persistence\Exception::class);

        $this->subject->_setStatic('objectManager', $objectManager);
        $this->subject->_setStatic('persistenceManager', $persistenceManager);

        $this->subject->logEmail(['test@example.org'], [''], '', '', true, ['test@example.org'], 0, false, true);
    }

    /**
     * @test
     */
    public function testGetObjectManagerInstance_ReturnsObjectManager()
    {
        $this->mockSubject();
        $objectManager = $this->getAccessibleMock(
            ObjectManager::class, ['get'], [], '', false
        );
        $this->subject->_setStatic('objectManager', $objectManager);

        $this->assertSame($objectManager, $this->subject->_call('getObjectManagerInstance'));
    }

    public function testGetObjectManagerInstance_CreatesObjectManager()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );
    }

    /**
     * @test
     */
    public function testGetPersistenceManagerInstance_ReturnsPersistenceManager()
    {
        $this->mockSubject();
        $persistenceManager = $this->getAccessibleMock(PersistenceManager::class, [], [], '', false);
        $this->subject->_setStatic('persistenceManager', $persistenceManager);

        $this->assertSame($persistenceManager, $this->subject->_call('getPersistenceManagerInstance'));
    }

    /**
     * @test
     */
    public function testGetPersistenceManagerInstance_CreatesPersistenceManager()
    {
        $this->mockSubject();
        $persistenceManager = $this->getAccessibleMock(PersistenceManager::class, [], [], '', false);
        $objectManager = $this->getAccessibleMock(
            ObjectManager::class, ['get'], [], '', false
        );
        $objectManager->expects($this->once())->method('get')
            ->willReturn($persistenceManager);
        $this->subject->_setStatic('objectManager', $objectManager);
        $this->subject->_setStatic('persistenceManager', false);

        $this->assertEquals($persistenceManager, $this->subject->_call('getPersistenceManagerInstance'));
    }
}
