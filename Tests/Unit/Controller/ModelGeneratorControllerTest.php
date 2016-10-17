<?php

namespace X4e\X4ebase\Tests\Unit\Controller;

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
 * Test case for class \X4e\X4ebase\Controller\ModelGeneratorController
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ModelGeneratorControllerTest extends \X4e\X4ebase\Tests\Unit\Base\ControllerTestBase
{
    /** @var \X4e\X4ebase\Controller\ModelGeneratorController|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
    protected $subject;

    /**
     * @test
     */
    public function testShowAction_WithGenerator()
    {
        $this->markTestIncomplete(
            'Untestable - Use of mysql_real_escape_string'
        );

        $this->mockSubject('getSqlFieldType', 'getExtbaseClassFromFields', 'getTSMappingsFromFields');
        $this->subject->expects($this->once())->method('getSqlFieldType')->willReturn('Integer');
        $this->subject->expects($this->once())->method('getExtbaseClassFromFields');
        $this->subject->expects($this->once())->method('getTSMappingsFromFields');

        $generator = [
            'databaseTable' => 'Lorem',
            'previousDatabaseTable' => 'Ipsum',
        ];

        global $TYPO3_DB;
        $databaseConnection = $this->getMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class, ['sql_query', 'sql_fetch_row', 'sql_free_result', 'sql_fetch_assoc']);

        $databaseConnection->expects($this->exactly(2))->method('sql_free_result');
        $databaseConnection->expects($this->at(0))->method('sql_query')->willReturn(true);
        $databaseConnection->expects($this->at(1))->method('sql_query')->willReturn(false);
        $databaseConnection->expects($this->at(1))->method('sql_fetch_row')->willReturn(['Lorem']);
        $databaseConnection->expects($this->at(2))->method('sql_fetch_row')->willReturn(false);
        $databaseConnection->expects($this->at(1))->method('sql_fetch_assoc')->willReturn([
            'Field' => 'Dolor',
            'Type' => 'int',
        ]);
        $databaseConnection->expects($this->at(2))->method('sql_fetch_assoc')->willReturn(false);

        $TYPO3_DB = $databaseConnection;

        $this->viewAssignCalledTest([], [], [], [], []);

        $this->subject->showAction($generator);
    }

    public function testGetSqlFieldType()
    {
        $this->mockSubject();
        $testCases = [
            ['tinyint', 'integer'],
            ['mediumint', 'integer'],
            ['int', 'integer'],
            ['integer', 'integer'],
            ['bigint', 'integer'],
            ['decimal', 'integer'],
            ['numeric', 'integer'],
            ['dec', 'integer'],
            ['float', 'integer'],
            ['double', 'integer'],

            ['bool', 'boolean'],
            ['boolean', 'boolean'],

            ['whatever', 'string'],
        ];
        foreach ($testCases as $testCase) {
            $this->assertEquals($testCase[1], $this->subject->_callRef('getSqlFieldType', $testCase[0]));
        }
    }

    public function testGetExtbaseClassFromFields()
    {
        $this->mockSubject();

        $table = 'Lorem';
        $fieldsArray = [
            [
                'name' => 'Ipsum',
                'type' => 'int',
            ]
        ];

        $this->assertInternalType('string', $this->subject->_callRef('getExtbaseClassFromFields', $table, $fieldsArray));
    }

    public function testGetTSMappingFromFields()
    {
        $this->mockSubject();

        $table = 'Lorem';
        $fieldsArray = [
            [
                'name' => 'Ipsum',
                'type' => 'int'
            ]
        ];

        $result = "\\Lorem {\n	mapping {\n		tableName = Lorem\n		columns {\n			Ipsum.mapOnProperty = ipsum\n\n		}\n	}\n}";

        $this->assertEquals($result, $this->subject->_callRef('getTSMappingsFromFields', $table, $fieldsArray));
    }
}
