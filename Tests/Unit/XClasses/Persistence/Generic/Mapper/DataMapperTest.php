<?php

namespace X4e\X4ebase\Tests\Unit\XClasses\Persistence\Generic\Mapper;

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
 * Test case for class \X4e\X4ebase\XClasses\Persistence\Generic\Mapper\DataMapper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class DataMapperTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\XClasses\Persistence\Generic\Mapper\DataMapper */
	protected $subject;

	/**
	 * @test
	 */
    public function testMapSingleRow_HasIdentifierCalledWithNewValue()
    {
		$this->mockSubject();
		$className = 'Lorem';
        $row = [
			'_PAGES_OVERLAY' => 1,
			'uid' => 1,
			'_PAGES_OVERLAY_UID' => 2
        ];
		$expectedResult = $row['uid'] . '_' . $row['_PAGES_OVERLAY_UID'];

		$persistenceSession = $this->createPartialMock(
            \TYPO3\CMS\Extbase\Persistence\Generic\Session::class,
			['hasIdentifier', 'getObjectByIdentifier']
		);
        $persistenceSession->expects($this->once())->method('hasIdentifier')->with($expectedResult, $className)->willReturn(TRUE);
        $persistenceSession->expects($this->once())->method('getObjectByIdentifier')->willReturn(TRUE);

		$this->subject->_set('persistenceSession', $persistenceSession);

		$this->subject->_callRef('mapSingleRow', $className, $row);
	}

	/**
	 * @test
	 */
    public function testMapSingleRow_HasIdentifierCalledWithOldValue()
    {
		$this->mockSubject();
		$className = 'Lorem';
        $row = [
			'uid' => 1
        ];
		$expectedResult = $row['uid'];

        $persistenceSession = $this->getAccessibleMock(
            \TYPO3\CMS\Extbase\Persistence\Generic\Session::class,
			['hasIdentifier', 'getObjectByIdentifier'],
			[],
			'',
            false
		);
        $persistenceSession->expects($this->once())->method('hasIdentifier')->with($expectedResult, $className)->willReturn(TRUE);
        $persistenceSession->expects($this->once())->method('getObjectByIdentifier')->willReturn(TRUE);

		$this->subject->_set('persistenceSession', $persistenceSession);

		$this->subject->_callRef('mapSingleRow', $className, $row);
	}

	/**
	 * @test
	 */
    public function testThawProperties()
    {
		$this->mockSubject('getDataMap');

        $reflectionService = $this->createPartialMock(
            \TYPO3\CMS\Extbase\Reflection\ReflectionService::class,
            [
                'getClassSchema'
            ]
        );
        $this->subject->_set('reflectionService', $reflectionService);

		$dataMap = $this->getAccessibleMock(
		    \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap::class,
            [
                'getLanguageIdColumnName'
            ],
            [],
            '',
            false
        );
		$dataMap->expects($this->once())->method('getLanguageIdColumnName')->willReturn(NULL);
		$this->subject->expects($this->once())->method('getDataMap')->willReturn($dataMap);
        $row = [
			'_PAGES_OVERLAY' => 1,
			'_PAGES_OVERLAY_LANGUAGE' => 1,
			'_PAGES_OVERLAY_UID' => 1
        ];

		$object = $this->createPartialMock(
		    \TYPO3\CMS\Belog\Domain\Model\LogEntry::class,
            [
                '_setProperty',
                '_getProperties'
            ]
        );
		$object->expects($this->once())->method('_getProperties')->willReturn(array());
		$object->expects($this->exactly(5))->method('_setProperty');

		$this->subject->_callRef('thawProperties', $object, $row);
	}
}