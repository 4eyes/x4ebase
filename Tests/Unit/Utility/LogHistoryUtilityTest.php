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

/**
 * Test case for class \X4e\X4ebase\Utility\BackendUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class LogHistoryUtilityTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\Utility\LogHistoryUtility */
	protected $subject;

	public function testWriteHistoryEntry() {
		$this->markTestIncomplete(
			"Untestable - Static method calls"
		);
	}

	public function testWriteLog() {
		$this->markTestIncomplete(
			"Untestable - Static method calls"
		);
	}

	public function testFillMmHisotryRecords() {
		$this->mockSubject();
		global $TCA;

		$TCA['lorem']['columns']['ipsum']['config'] = array(
			'MM' => 'dolor'
		);

		$dataHandler = new LogHistoryUtilityTestClass();
		$tablename = "lorem";
		$fieldArray = array(
			"ipsum" => "dolor"
		);
		$recUid = 42;

		$currentRecord = array(
			array(
			'uid_foreign' => 6
			),
			array(
				'uid_foreign' => 9
			),
			FALSE
		);

		$databaseConnection = $this->getMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, array("exec_SELECTquery", "sql_fetch_assoc"), array(), "", FALSE);
		$databaseConnection->expects($this->once())->method("exec_SELECTquery")->with('uid_foreign', 'dolor', 'uid_local=42', '', 'sorting');
		$databaseConnection->expects($this->at(1))->method("sql_fetch_assoc")->willReturn($currentRecord[0]);
		$databaseConnection->expects($this->at(2))->method("sql_fetch_assoc")->willReturn($currentRecord[1]);
		$databaseConnection->expects($this->at(3))->method("sql_fetch_assoc")->willReturn($currentRecord[2]);

		$GLOBALS['TYPO3_DB'] = $databaseConnection;

		$this->subject->fillMmHistoryRecords($dataHandler, $tablename, $fieldArray, $recUid);

		$mmHistoryRecords = array(
			'lorem:42' => array(
				'oldRecord' => array(
					'ipsum' => '6,9'
				)
			)
		);

		$this->assertEquals($mmHistoryRecords, $dataHandler->mmHistoryRecords);
	}
}

class LogHistoryUtilityTestClass {

	public $mmHistoryRecords = array();
}