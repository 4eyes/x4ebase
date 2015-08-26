<?php

namespace X4E\X4ebase\Tests\Unit\XClasses\Persistence\Generic\Mapper;

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
 * Test case for class \X4E\X4ebase\XClasses\Persistence\Generic\Mapper\DataMapper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class DataMapperTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\XClasses\Persistence\Generic\Mapper\DataMapper */
	protected $subject;

	/**
	 * @test
	 */
	public function testMapSingleRow_HasIdentifierCalledWithNewValue() {
		$this->mockSubject();
		$className = 'Lorem';
		$row = array(
			'_PAGES_OVERLAY' => 1,
			'uid' => 1,
			'_PAGES_OVERLAY_UID' => 2
		);
		$expectedResult = $row['uid'] . '_' . $row['_PAGES_OVERLAY_UID'];

		$identityMap = null;
		$identityMap = $this->getMock(
			\TYPO3\CMS\Extbase\Persistence\Generic\IdentityMap::class,
			array('hasIdentifier', 'getObjectByIdentifier')
		);
		$identityMap->expects($this->once())->method('hasIdentifier')->with($expectedResult, $className)->will($this->returnValue(TRUE));
		$identityMap->expects($this->once())->method('getObjectByIdentifier')->will($this->returnValue(TRUE));

		$this->subject->_set('identityMap', $identityMap);

		$this->subject->_callRef('mapSingleRow', $className, $row);
	}

	/**
	 * @test
	 */
	public function testMapSingleRow_HasIdentifierCalledWithOldValue() {
		$this->mockSubject();
		$className = 'Lorem';
		$row = array(
			'uid' => 1
		);
		$expectedResult = $row['uid'];

		$identityMap = null;
		$identityMap = $this->getMock(
			\TYPO3\CMS\Extbase\Persistence\Generic\IdentityMap::class,
			array('hasIdentifier', 'getObjectByIdentifier'),
			array(),
			'',
			FALSE
		);
		$identityMap->expects($this->once())->method('hasIdentifier')->with($expectedResult, $className)->will($this->returnValue(TRUE));
		$identityMap->expects($this->once())->method('getObjectByIdentifier')->will($this->returnValue(TRUE));

		$this->subject->_set('identityMap', $identityMap);

		$this->subject->_callRef('mapSingleRow', $className, $row);
	}

	/**
	 * @test
	 */
	public function testThawProperties() {
		$this->mockSubject('getDataMap');

		$dataMap = $this->getMock(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap::class, array('getLanguageIdColumnName'), array(), '', FALSE);
		$dataMap->expects($this->once())->method('getLanguageIdColumnName')->will($this->returnValue(NULL));
		$this->subject->expects($this->once())->method('getDataMap')->will($this->returnValue($dataMap));
		$row = array(
			'_PAGES_OVERLAY' => 1,
			'_PAGES_OVERLAY_LANGUAGE' => 1,
			'_PAGES_OVERLAY_UID' => 1
		);

		$object = $this->getMock(\TYPO3\CMS\Belog\Domain\Model\LogEntry::class, array('_setProperty', '_getProperties'));
		$object->expects($this->once())->method('_getProperties')->will($this->returnValue(array()));
		$object->expects($this->exactly(4))->method('_setProperty');

		$this->subject->_callRef('thawProperties', $object, $row);
	}
}