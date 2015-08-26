<?php

namespace X4E\X4ebase\Tests\Unit\XClasses\Persistence\Generic\Storage;

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
 * Test case for class \X4E\X4ebase\XClasses\Persistence\Generic\Storage\Typo3DbBackend
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class Typo3DbBackendTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\XClasses\Persistence\Generic\Storage\Typo3DbBackend */
	protected $subject;

	/**
	 * @test
	 */
	public function testAdditionalWhereClause_QuerySettingsInstanceOfAlternativeQuerySettingsInterface_AND_RespectSysLanguageAlternative_CallsAddAlternativeSysLanguageStatement() {
		$this->markTestIncomplete(
			'Error: Method accepts String for SQL, but method >addVisiblityConstraintStatement< expects array!'
		);

		$this->mockSubject('addVisibilityConstraintStatement', 'addSysLanguageStatement', 'addAlternativeSysLanguageStatement', 'addPageIdStatement');
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getRespectSysLanguage', 'getRespectSysLanguageAlternative', 'getRespectStoragePage', 'getStoragePageIds')
		);
		$tableName = '';
		$sql = array();

		$querySettings->expects($this->once())->method('getRespectSysLanguage')->will($this->returnValue(FALSE));
		$querySettings->expects($this->once())->method('getRespectSysLanguageAlternative')->will($this->returnValue(TRUE));
		$querySettings->expects($this->once())->method('getRespectStoragePage')->will($this->returnValue(FALSE));
		$this->subject->expects($this->never())->method('addSysLanguageStatement');
		$this->subject->expects($this->once())->method('addAlternativeSysLanguageStatement');
		$this->subject->expects($this->never())->method('addPageIdStatement');

		$this->subject->_callRef('addAdditionalWhereClause', $querySettings, $tableName, $sql);
	}

	/**
	 * @test
	 */
	public function testAdditionalWhereClause_QuerySettingsInstanceOfAlternativeQuerySettingsInterface_ANDNOT_RespectSysLanguageAlternative_NotCallsAddAlternativeSysLanguageStatement() {
		$this->mockSubject('addVisibilityConstraintStatement', 'addSysLanguageStatement', 'addAlternativeSysLanguageStatement', 'addPageIdStatement');
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getRespectSysLanguage', 'getRespectSysLanguageAlternative', 'getRespectStoragePage', 'getStoragePageIds')
		);
		$tableName = '';
		$sql = array();

		$querySettings->expects($this->once())->method('getRespectSysLanguage')->will($this->returnValue(FALSE));
		$querySettings->expects($this->once())->method('getRespectSysLanguageAlternative')->will($this->returnValue(FALSE));
		$querySettings->expects($this->once())->method('getRespectStoragePage')->will($this->returnValue(FALSE));
		$this->subject->expects($this->never())->method('addSysLanguageStatement');
		$this->subject->expects($this->never())->method('addAlternativeSysLanguageStatement');
		$this->subject->expects($this->never())->method('addPageIdStatement');

		$this->subject->_callRef('addAdditionalWhereClause', $querySettings, $tableName, $sql);
	}

	/**
	 * @test
	 */
	public function testAddSysLanguageStatement() {
		$this->mockSubject('dummy');
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getSysLanguageUid')->will($this->returnValue(1));

		$expectedResult = ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval(1);

		$this->subject->_callRef('addSysLanguageStatement', $tableName, $sql, $querySettings);
		$this->assertNotFalse(strpos($sql['additionalWhereClause'][0], $expectedResult));
	}

	/**
	 * @test
	 */
	public function testAddAlternativeSysLanguageStatement_WithSysLanguageUid() {
		$this->mockSubject('dummy');
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getSysLanguageUid')->will($this->returnValue(1));

		$expectedResult = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (-1,0) OR ('
			. $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval($querySettings->getSysLanguageUid())
			. ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '=0'
			. ')';

		$this->subject->_callRef('addAlternativeSysLanguageStatement', $tableName, $sql, $querySettings);
		$this->assertNotFalse(strpos($sql['additionalWhereClause'][0], $expectedResult));
	}

	/**
	 * @test
	 */
	public function testAddAlternativeSysLanguageStatement_WithoutSysLanguageUid() {
		$this->mockSubject('dummy');
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getSysLanguageUid')->will($this->returnValue(0));

		$expectedResult = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (-1,0)';

		$this->subject->_callRef('addAlternativeSysLanguageStatement', $tableName, $sql, $querySettings);
		$this->assertNotFalse(strpos($sql['additionalWhereClause'][0], $expectedResult));
	}

	/**
	 * @test
	 */
	public function testDoLanguageAndWorkspaceOverlay() {
		$this->mockSubject('getPageRepository');
		$tableName = 'lorem';
		$transOrigPointerField = 1;
		$newRow = FALSE;
		$querySettings = $this->getMock(
			\X4E\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->any())->method('getSysLanguageUid')->will($this->returnValue(0));

		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => $transOrigPointerField
		);

		$source = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Selector::class, array('getSelectorName'), array(), '', FALSE);
		$source->expects($this->once())->method('getSelectorName')->will($this->returnValue($tableName));
		$databaseHandle = $this->getMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, array('exec_SELECTgetSingleRow'));
		$databaseHandle->expects($this->once())->method('exec_SELECTgetSingleRow')->will($this->returnValue($newRow));
		$this->subject->_set('databaseHandle', $databaseHandle);
		$pageRepository = $this->getMock(\TYPO3\CMS\Frontend\Page\PageRepository::class, array('versionOL', 'getPageOverlay', 'getRecordOverlay'));

		$this->subject->expects($this->once())->method('getPageRepository')->will($this->returnValue($pageRepository));

		$rows = array(array('1' => 1));

		$this->assertTrue(in_array($rows[0], $this->subject->_callRef('doLanguageAndWorkspaceOverlay', $source, $rows, $querySettings)));
	}
}