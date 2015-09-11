<?php

namespace X4E\X4ebase\Tests\Unit\Controller;

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
 * Test case for class \X4E\X4ebase\Unit\Controller\TcaInfoController
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class TcaInfoControllerTest extends \X4E\X4ebase\Tests\Unit\Base\ControllerTestBase {

	protected function prepareGlobals() {
		$GLOBALS['TCA'] = array();
	}

	/**
	 * @test
	 */
	public function showActionCanBeCalled() {
		$this->mockSubject();
		$this->prepareGlobals();
		$this->subject->showAction();
	}

	/**
	 * @test
	 */
	public function testShowActionWithTableArgument() {
		$this->mockSubject();
		$this->prepareGlobals();
		$this->setArguments(array('table' => ''));

		$this->viewAssignCalledTest(array(
			array('table', $this->equalTo(NULL)),
			array('tableName', $this->equalTo('')),
			array('tables', $this->equalTo(array()))
		));

		$this->subject->showAction();
	}

	/**
	 * @test
	 */
	public function testShowActionWithoutTableArgument() {
		$this->mockSubject();
		$this->prepareGlobals();
		$this->viewAssignCalledTest(array('tables', array()));

		$this->subject->showAction();
	}

	public function testGetTableArray() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}
}
