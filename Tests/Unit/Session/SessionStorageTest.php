<?php

namespace X4E\X4ebase\Tests\Unit\Session;

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

/**
 * Test case for class \X4E\X4ebase\Session\SessionStorage
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class SessionStorageTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var \X4E\X4ebase\Session\SessionStorage|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
	protected $subject;

	public function testInjectObjectManager() {
		$this->mockSubject("initializeConcreteSessionStorage");
		$objectManager = $this->getMock(ObjectManager::class, array(), array(), "", FALSE);
		$this->subject->expects($this->once())->method("initializeConcreteSessionStorage");
		$this->subject->injectObjectManager($objectManager);
		$this->assertSame($objectManager, $this->subject->_get("objectManager"));
	}

	public function testInitializeConcreteSessionStorage_InFeMode() {
		$this->mockSubject();
		$environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, array("isEnvironmentInFrontendMode"), array(), "", FALSE);
		$environmentService->expects($this->once())->method("isEnvironmentInFrontendMode")->willReturn(TRUE);

		$objectManager = $this->getMock(ObjectManager::class, array("get"), array(), "", FALSE);
		$objectManager->expects($this->at(0))->method("get")->with('TYPO3\CMS\Extbase\Service\EnvironmentService')->willReturn($environmentService);
		$objectManager->expects($this->at(1))->method("get")->with('X4E\X4ebase\Session\FrontendSessionStorage');

		$this->subject->_set("objectManager", $objectManager);

		$this->subject->_call("initializeConcreteSessionStorage");
	}

	public function testInitializeConcreteSessionStorage_InBeMode() {
		$this->mockSubject();
		$environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, array("isEnvironmentInFrontendMode", "isEnvironmentInBackendMode"), array(), "", FALSE);
		$environmentService->expects($this->once())->method("isEnvironmentInFrontendMode")->willReturn(FALSE);
		$environmentService->expects($this->once())->method("isEnvironmentInBackendMode")->willReturn(TRUE);

		$objectManager = $this->getMock(ObjectManager::class, array("get"), array(), "", FALSE);
		$objectManager->expects($this->at(0))->method("get")->with('TYPO3\CMS\Extbase\Service\EnvironmentService')->willReturn($environmentService);
		$objectManager->expects($this->at(1))->method("get")->with('X4E\X4ebase\Session\BackendSessionStorage');

		$this->subject->_set("objectManager", $objectManager);

		$this->subject->_call("initializeConcreteSessionStorage");
	}

	public function testInitializeConcreteSessionStorage_InUndefinedMode() {
		$this->mockSubject();
		$environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, array("isEnvironmentInFrontendMode", "isEnvironmentInBackendMode"), array(), "", FALSE);
		$environmentService->expects($this->once())->method("isEnvironmentInFrontendMode")->willReturn(FALSE);
		$environmentService->expects($this->once())->method("isEnvironmentInBackendMode")->willReturn(FALSE);

		$objectManager = $this->getMock(ObjectManager::class, array("get"), array(), "", FALSE);
		$objectManager->expects($this->at(0))->method("get")->with('TYPO3\CMS\Extbase\Service\EnvironmentService')->willReturn($environmentService);
		$objectManager->expects($this->at(1))->method("get")->with('X4E\X4ebase\Session\NullSessionStorage');

		$this->subject->_set("objectManager", $objectManager);

		$this->subject->_call("initializeConcreteSessionStorage");
	}

	public function testGet() {
		$this->mockSubject();
		$concreteSessionStorage = $this->getMock(\X4E\X4ebase\Session\BackendSessionStorage::class, array("get"));
		$concreteSessionStorage->expects($this->once())->method("get")->with("lorem", "ipsum");
		$this->subject->_set("concreteSessionStorage", $concreteSessionStorage);

		$this->subject->get("lorem", "ipsum");
	}

	public function testSet() {
		$this->mockSubject();
		$concreteSessionStorage = $this->getMock(\X4E\X4ebase\Session\BackendSessionStorage::class, array("set"));
		$concreteSessionStorage->expects($this->once())->method("set")->with("lorem", "ipsum", "dolor");
		$this->subject->_set("concreteSessionStorage", $concreteSessionStorage);

		$this->subject->set("lorem", "ipsum", "dolor");
	}

	public function testHas() {
		$this->mockSubject();
		$concreteSessionStorage = $this->getMock(\X4E\X4ebase\Session\BackendSessionStorage::class, array("has"));
		$concreteSessionStorage->expects($this->once())->method("has")->with("lorem", "ipsum");
		$this->subject->_set("concreteSessionStorage", $concreteSessionStorage);

		$this->subject->has("lorem", "ipsum");
	}

	public function testRemove() {
		$this->mockSubject();
		$concreteSessionStorage = $this->getMock(\X4E\X4ebase\Session\BackendSessionStorage::class, array("remove"));
		$concreteSessionStorage->expects($this->once())->method("remove")->with("lorem", "ipsum");
		$this->subject->_set("concreteSessionStorage", $concreteSessionStorage);

		$this->subject->remove("lorem", "ipsum");
	}

	public function testgetConcreteSessionStorage() {
		$this->mockSubject();
		$concreteSessionStorage = $this->getMock(\X4E\X4ebase\Session\BackendSessionStorage::class);
		$this->subject->_set("concreteSessionStorage", $concreteSessionStorage);

		$this->assertSame($concreteSessionStorage, $this->subject->getConcreteSessionStorage());
	}
}