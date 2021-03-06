<?php

namespace X4e\X4ebase\Tests\Unit\XClasses\Persistence\Generic\Storage;

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
 * Test case for class \X4e\X4ebase\XClasses\Persistence\Generic\Storage\Typo3DbBackend
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class Typo3DbBackendTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\XClasses\Persistence\Generic\Storage\Typo3DbBackend */
	protected $subject;

	/**
	 * @test
	 */
	public function testAddAdditionalWhereClause_QuerySettingsInstanceOfAlternativeQuerySettingsInterface_AND_RespectSysLanguageAlternative_CallsAddAlternativeSysLanguageStatement() {
		$this->mockSubject('addVisibilityConstraintStatement', 'addSysLanguageStatement', 'addAlternativeSysLanguageStatement', 'addPageIdStatement');
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getRespectSysLanguage', 'getRespectSysLanguageAlternative', 'getRespectStoragePage', 'getStoragePageIds')
		);
		$tableName = '';
		$sql = array();

		$querySettings->expects($this->once())->method('getRespectSysLanguage')->willReturn(FALSE);
		$querySettings->expects($this->once())->method('getRespectSysLanguageAlternative')->willReturn(TRUE);
		$querySettings->expects($this->once())->method('getRespectStoragePage')->willReturn(FALSE);
		$this->subject->expects($this->never())->method('addSysLanguageStatement');
		$this->subject->expects($this->once())->method('addAlternativeSysLanguageStatement');
		$this->subject->expects($this->never())->method('addPageIdStatement');

		$this->subject->_callRef('addAdditionalWhereClause', $querySettings, $tableName, $sql);
	}

	/**
	 * @test
	 */
	public function testAddAdditionalWhereClause_QuerySettingsInstanceOfAlternativeQuerySettingsInterface_ANDNOT_RespectSysLanguageAlternative_NotCallsAddAlternativeSysLanguageStatement() {
		$this->mockSubject('addVisibilityConstraintStatement', 'addSysLanguageStatement', 'addAlternativeSysLanguageStatement', 'addPageIdStatement');
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getRespectSysLanguage', 'getRespectSysLanguageAlternative', 'getRespectStoragePage', 'getStoragePageIds')
		);
		$tableName = '';
		$sql = array();

		$querySettings->expects($this->once())->method('getRespectSysLanguage')->willReturn(FALSE);
		$querySettings->expects($this->once())->method('getRespectSysLanguageAlternative')->willReturn(FALSE);
		$querySettings->expects($this->once())->method('getRespectStoragePage')->willReturn(FALSE);
		$this->subject->expects($this->never())->method('addSysLanguageStatement');
		$this->subject->expects($this->never())->method('addAlternativeSysLanguageStatement');
		$this->subject->expects($this->never())->method('addPageIdStatement');

		$this->subject->_callRef('addAdditionalWhereClause', $querySettings, $tableName, $sql);
	}

	/**
	 * @test
	 */
	public function testAddSysLanguageStatement() {
		$this->mockSubject();
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getLanguageUid')->willReturn(1);

		$expectedResult = ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval(1);

		$this->subject->_callRef('addSysLanguageStatement', $tableName, $sql, $querySettings);
		$this->assertNotFalse(strpos($sql['additionalWhereClause'][0], $expectedResult));
	}

	/**
	 * @test
	 */
	public function testAddAlternativeSysLanguageStatement_WithSysLanguageUid() {
		$this->mockSubject();
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getLanguageUid')->willReturn(1);

		$expectedResult = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (-1,0) OR ('
			. $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . intval($querySettings->getLanguageUid())
			. ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '=0'
			. ')';

		$this->subject->_callRef('addAlternativeSysLanguageStatement', $tableName, $sql, $querySettings);
		$this->assertNotFalse(strpos($sql['additionalWhereClause'][0], $expectedResult));
	}

	/**
	 * @test
	 */
	public function testAddAlternativeSysLanguageStatement_WithoutSysLanguageUid() {
		$this->mockSubject();
		$tableName = 'lorem';
		$sql = array();
		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => '1',
		);
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getLanguageUid')
		);
		$querySettings->expects($this->atLeastOnce())->method('getLanguageUid')->willReturn(0);

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
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->any())->method('getSysLanguageUid')->willReturn(0);

		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => $transOrigPointerField
		);

		$source = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Selector::class, array('getSelectorName'), array(), '', FALSE);
		$source->expects($this->once())->method('getSelectorName')->willReturn($tableName);
		$databaseHandle = $this->getMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, array('exec_SELECTgetSingleRow'));
		$databaseHandle->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn($newRow);
		$this->subject->_set('databaseHandle', $databaseHandle);
		$pageRepository = $this->getMock(\TYPO3\CMS\Frontend\Page\PageRepository::class, array('versionOL', 'getPageOverlay', 'getRecordOverlay'));

		$this->subject->expects($this->once())->method('getPageRepository')->willReturn($pageRepository);

		$rows = array(array('1' => 1));

		$this->assertTrue(in_array($rows[0], $this->subject->_callRef('doLanguageAndWorkspaceOverlay', $source, $rows, $querySettings)));
	}

	/**
	 * @test
	 */
	public function testDoLanguageAndWorkspaceOverlay_WithNewRow() {
		$this->mockSubject('getPageRepository');
		$tableName = 'lorem';
		$transOrigPointerField = 1;
		$newRow = array(
			'_ORIG_uid' => 1,
			'language' => 5
		);
		$querySettings = $this->getMock(
			\X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class,
			array('getSysLanguageUid')
		);
		$querySettings->expects($this->any())->method('getSysLanguageUid')->willReturn(0);

		$GLOBALS['TCA'][$tableName]['ctrl'] = array(
			'languageField' => 'language',
			'transOrigPointerField' => $transOrigPointerField
		);

		$source = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Selector::class, array('getSelectorName'), array(), '', FALSE);
		$source->expects($this->once())->method('getSelectorName')->willReturn($tableName);
		$databaseHandle = $this->getMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, array('exec_SELECTgetSingleRow'));
		$databaseHandle->expects($this->once())->method('exec_SELECTgetSingleRow')->willReturn($newRow);
		$this->subject->_set('databaseHandle', $databaseHandle);
		$pageRepository = $this->getMock(\TYPO3\CMS\Frontend\Page\PageRepository::class, array('versionOL', 'getPageOverlay', 'getRecordOverlay'));
		$pageRepository->versioningPreview = TRUE;

		$this->subject->expects($this->once())->method('getPageRepository')->willReturn($pageRepository);

		$rows = array(array('1' => 1));
		$overlayedRows = array(array(
			'_ORIG_uid' => 1,
			'language' => 5,
			'uid' => 1
		));

		$this->assertEquals($overlayedRows, $this->subject->_callRef('doLanguageAndWorkspaceOverlay', $source, $rows, $querySettings));
	}
}