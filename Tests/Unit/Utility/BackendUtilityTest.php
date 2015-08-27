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

/**
 * Test case for class \X4E\X4ebase\Utility\BackendUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class BackendUtilityTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\Utility\/BackendUtility */
	protected $subject;

	public function testInitTypoScript() {
		$this->mockSubject();
		$tsfeObject = $this->getMock(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class, array('getPageAndRootline', 'initTemplate', 'getConfigArray'), array(), '', FALSE);
		$tsfeObject->expects($this->once())->method('getPageAndRootline');
		$tsfeObject->expects($this->once())->method('initTemplate');
		$tsfeObject->expects($this->once())->method('getConfigArray');
		$GLOBALS['TSFE'] = $tsfeObject;
		$this->subject->_call('initTypoScript');
	}

	public function testInitTSFE() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}

	public function testExec_languageQuery() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}

	public function testGetStorageFolderPid() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}
}
