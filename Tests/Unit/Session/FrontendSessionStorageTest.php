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
 * Test case for class \X4e\X4ebase\Session\FrontendSessionStorage
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class FrontendSessionStorageTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var \X4e\X4ebase\Session\FrontendSessionStorage|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
	protected $subject;

	public function testGet() {
		$this->mockSubject('getFrontendUser', 'getKey');

		$key = 'lorem';
		$type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE;

		$frontendUser = $this->getMock(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class, array('getKey'));
		$frontendUser->expects($this->once())->method('getKey')->with($type, $key);

		$this->subject->expects($this->once())->method('getFrontendUser')->willReturn($frontendUser);
		$this->subject->expects($this->once())->method('getKey')->with($key)->willReturn($key);

		$this->subject->get($key, $type);
	}

	public function testSet() {
		$this->mockSubject('getFrontendUser', 'getKey');

		$key = 'lorem';
		$data = '';
		$type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE;

		$frontendUser = $this->getMock(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class, array('setKey'));
		$frontendUser->expects($this->once())->method('setKey')->with($type, $key, $data);
		$this->subject->expects($this->once())->method('getFrontendUser')->willReturn($frontendUser);
		$this->subject->expects($this->once())->method('getKey')->with($key)->willReturn($key);

		$this->subject->set($key, $data, $type);
	}

	public function testRemove_HasKey_CallsSetWithNull() {
		$this->mockSubject('has', 'set');

		$key = 'lorem';
		$data = NULL;
		$type = \X4e\X4ebase\Session\SessionStorage::COOKIE_SESSION_STORAGE;

		$this->subject->expects($this->once())->method('has')->with($key, $type)->willReturn(TRUE);
		$this->subject->expects($this->once())->method('set')->with($key, $data, $type);

		$this->subject->remove($key, $type);
	}

	public function testRemove_NotHasKey_NotCallsSet() {
		$this->mockSubject('has', 'set');
		$this->subject->expects($this->once())->method('has')->willReturn(FALSE);
		$this->subject->expects($this->never())->method('set');

		$this->subject->remove('');
	}

	public function testGetAll() {
		$this->mockSubject('getFrontendUser');
		$frontendUser = $this->getMock(\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication::class, array('setKey'));
		$frontendUser->sesData = 'HelloWorld';
		$this->subject->expects($this->once())->method('getFrontendUser')->willReturn($frontendUser);

		$this->assertEquals('HelloWorld', $this->subject->getAll());
	}

	public function testGetFrontendUser() {
		$this->mockSubject();
		$tsfe = $this->getMock(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, array(), array(), '', FALSE);
		$tsfe->fe_user = 'test';
		$GLOBALS['TSFE'] = $tsfe;
		$this->assertSame('test', $this->subject->_call('getFrontendUser'));
	}

}