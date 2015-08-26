<?php

namespace X4E\X4ebase\Tests\Unit\Utility;

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
use X4E\X4ebase\Utility\EmailUtility;

/**
 * Test case for class \X4E\X4ebase\Utility\EmailUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class EmailUtilityTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|EmailUtility */
	protected $subject;

	public function testLogEmail_SendsEmail_AND_LogsEmail() {
		$this->mockSubject('logEmail');

		$request = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Request::class, array(), array(), '', FALSE);

		$emailView = $this->getMock(\TYPO3\CMS\Fluid\View\StandaloneView::class, array('render', 'assignMultiple', 'getRequest'), array(), '', FALSE);
		$emailView->expects($this->once())->method('render')->will($this->returnValue('Hello'));
		$emailView->expects($this->once())->method('getRequest')->will($this->returnValue($request));
		$message = $this->getMock(\TYPO3\CMS\Core\Mail\MailMessage::class, array('send', 'isSent', 'setTo', 'setFrom', 'setReplyTo', 'setSubject', 'attach', 'setBody'), array(), '', FALSE);
		$message->expects($this->once())->method('send');
		$message->expects($this->once())->method('isSent')->will($this->returnValue(TRUE));
		$message->expects($this->once())->method('setTo')->will($this->returnValue($message));
		$message->expects($this->once())->method('setFrom')->will($this->returnValue($message));
		$message->expects($this->once())->method('setReplyTo')->will($this->returnValue($message));
		$message->expects($this->once())->method('setSubject')->will($this->returnValue($message));
		$message->expects($this->once())->method('attach')->will($this->returnValue($message));
		$message->expects($this->once())->method('setBody')->will($this->returnValue($message));

		$objectManager = $this->getMock(
			ObjectManager::class, array('get'), array(), '', FALSE
		);
		$objectManager->expects($this->at(0))->method('get')->will($this->returnValue($emailView));
		$objectManager->expects($this->at(1))->method('get')->will($this->returnValue($message));

		$subject = $this->subject;

		$this->subject->_setStatic('objectManager', $objectManager);

		/*****************************************************
		 * WOULD THROW EXCEPTION WHEN CALLING self::logEmail *
		 *****************************************************/
		$this->markTestIncomplete('Untestable thanks to static method call.');

		$this->subject->sendTemplateEmail(array('test@example.org'), array(''), '', '', '', '', '', array(), 'x4ebase', 'Email', true, array(1));
	}

	/**
	 * @test
	 */
	public function testLogEmail_PersistsEmailLog() {
		$this->mockSubject();
		$emailLogRepository = $this->getMock(\X4E\X4ebase\Domain\Repository\EmailLogRepository::class, array('add'), array(), '', FALSE);
		$emailLog = $this->getMock(\X4E\X4ebase\Domain\Model\EmailLog::class, array('dummy'));

		$objectManager = $this->getMock(
			ObjectManager::class, array('get'), array(), '', FALSE
		);
		$objectManager->expects($this->at(0))->method('get')
			->with('X4E\\X4ebase\\Domain\\Repository\\EmailLogRepository')
			->will($this->returnValue($emailLogRepository));

		$objectManager->expects($this->at(1))->method('get')
			->with('X4E\\X4ebase\\Domain\\Model\\EmailLog')
			->will($this->returnValue($emailLog));

		$persistenceManager = $this->getMock(PersistenceManager::class, array('persistAll'), array(), '', FALSE);
		$persistenceManager->expects($this->once())->method('persistAll');

		//$this->setExpectedException('TYPO3\\CMS\\Extbase\\Persistence\\Exception');

		$this->subject->_setStatic('objectManager', $objectManager);
		$this->subject->_setStatic('persistenceManager', $persistenceManager);

		$this->subject->logEmail(array('test@example.org'), array(''), '', '', TRUE);
	}

	/**
	 * @test
	 */
	public function testLogEmail_ThrowsException() {
		$this->mockSubject();

		$objectManager = $this->getMock(
			ObjectManager::class, array('get'), array(), '', FALSE
		);
		$objectManager->expects($this->at(0))->method('get')
			->with('X4E\\X4ebase\\Domain\\Repository\\EmailLogRepository')
			->will($this->returnValue(FALSE));

		$persistenceManager = $this->getMock(PersistenceManager::class, array('persistAll'), array(), '', FALSE);

		$this->setExpectedException('TYPO3\\CMS\\Extbase\\Persistence\\Exception');

		$this->subject->_setStatic('objectManager', $objectManager);
		$this->subject->_setStatic('persistenceManager', $persistenceManager);

		$this->subject->logEmail(array('test@example.org'), array(''), '', '', TRUE);
	}

	/**
	 * @test
	 */
	public function testGetObjectManagerInstance_ReturnsObjectManager() {
		$this->mockSubject();
		$objectManager = $this->getMock(
			ObjectManager::class, array('get'), array(), '', FALSE
		);
		$this->subject->_setStatic('objectManager', $objectManager);

		$this->assertSame($objectManager, $this->subject->_call('getObjectManagerInstance'));
	}

	public function testGetObjectManagerInstance_CreatesObjectManager() {
		$this->markTestIncomplete(
			'Untestable (static method call)'
		);
	}

	/**
	 * @test
	 */
	public function testGetPersistenceManagerInstance_ReturnsPersistenceManager() {
		$this->mockSubject();
		$persistenceManager = $this->getMock(PersistenceManager::class, array(), array(), '', FALSE);
		$this->subject->_setStatic('persistenceManager', $persistenceManager);

		$this->assertSame($persistenceManager, $this->subject->_call('getPersistenceManagerInstance'));
	}

	/**
	 * @test
	 */
	public function testGetPersistenceManagerInstance_CreatesPersistenceManager() {
		$this->mockSubject();
		$persistenceManager = $this->getMock(PersistenceManager::class, array(), array(), '', FALSE);
		$objectManager = $this->getMock(
			ObjectManager::class, array('get'), array(), '', FALSE
		);
		$objectManager->expects($this->once())->method('get')
			->will($this->returnValue($persistenceManager));
		$this->subject->_setStatic('objectManager', $objectManager);
		$this->subject->_setStatic('persistenceManager', FALSE);

		$this->assertEquals($persistenceManager, $this->subject->_call('getPersistenceManagerInstance'));
	}
}