<?php

namespace X4E\X4ebase\Tests\Unit\Utility;

	/* * *************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2013 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
 * Test case for class \X4E\X4ebase\Utility\NamingUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Jonas Witmer <jonas@4eyes.ch>
 * @author Markus Stauffiger <markus@4eyes.ch>
 */
class NamingUtilityTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \X4E\X4ebase\Utility\NamingUtility
	 */
	protected $nameUtility;
	protected $configurationManager;

	protected $configArray = array();

	public function setUp() {
		$this->nameUtility = new \X4E\X4ebase\Utility\NamingUtility();

		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
	}

	public function tearDown() {
		unset($this->nameUtility);
		unset($this->configurationManager);
		unset($this->configArray);
		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}

	protected function initCM() {
		$configurationManagerMock = $this->getMock(
			'TYPO3\CMS\Extbase\Configuration\ConfigurationManager', array('getConfiguration'), array(), '', FALSE
		);

		$configurationManagerMock
			->expects($this->any())
			->method('getConfiguration')
			->withAnyParameters()
			->will($this->returnValue($this->configArray));

		$this->nameUtility->injectConfigurationManager($configurationManagerMock);
	}

	public function testTranslateModelClassNameToTableNameRegular() {
		$this->configArray['persistence']['classes']['X4E\X4ebase\Utility\NamingUtility']['mapping']['tableName'] = 'test_table_name';
		$this->initCM();
		$tableName = $this->nameUtility->translateModelClassNameToTableName('X4E\X4ebase\Utility\NamingUtility');
		$this->assertEquals($this->configArray['persistence']['classes']['X4E\X4ebase\Utility\NamingUtility']['mapping']['tableName'], $tableName);
	}

	public function testTranslateModelClassNameToTableNameNoConfig() {
		$this->configArray['persistence']['classes']['X4E\X4ebase\Utility\NamingUtilityNoMapping']['somethingelse']['tableName'] = NULL;
		$this->initCM();
		$tableName = $this->nameUtility->translateModelClassNameToTableName('X4E\X4ebase\Utility\NotNamingUtility');
		$this->assertEquals('tx_x4ebase_utility_notnamingutility', $tableName);
	}

	public function testTranslateModelClassNameToTableNameNoMapping() {
		$this->initCM();
		$tableName = $this->nameUtility->translateModelClassNameToTableName('X4E\X4ebase\Utility\NamingUtilityNoMapping');
		$this->assertEquals('tx_x4ebase_utility_namingutilitynomapping', $tableName);
	}

	public function testTranslateModelClassNameToTableEmptyMapping() {
		$this->configArray['persistence']['classes']['X4E\X4ebase\Utility\NamingUtilityEmptyMapping']['mapping']['tableName'] = '';
		$this->initCM();
		$tableName = $this->nameUtility->translateModelClassNameToTableName('X4E\X4ebase\Utility\NamingUtilityEmptyMapping');
		$this->assertEquals('tx_x4ebase_utility_namingutilityemptymapping', $tableName);
	}

	public function testTranslateModelClassNameToTableNullMapping() {
		$this->configArray['persistence']['classes']['X4E\X4ebase\Utility\NamingUtilityNullMapping']['mapping']['tableName'] = NULL;
		$this->initCM();
		$tableName = $this->nameUtility->translateModelClassNameToTableName('X4E\X4ebase\Utility\NamingUtilityNullMapping');
		$this->assertEquals('tx_x4ebase_utility_namingutilitynullmapping', $tableName);
	}

	/**
	 * @test
	 */
	public function testResolveTableNameRegularExtension() {
		$tableName = $this->callInaccessibleMethod($this->nameUtility, "resolveTableName", 'X4E\X4ebase\Utility\NamingUtility');
		$this->assertEquals('tx_x4ebase_utility_namingutility', $tableName);
	}

	/**
	 * @test
	 */
	public function testResolveTableNameTypo3Extension() {
		$tableName = $this->callInaccessibleMethod($this->nameUtility, "resolveTableName", 'TYPO3\CMS\Abc\Def\GClass');
		$this->assertEquals('tx_abc_def_gclass', $tableName);
	}

	/**
	 * @test
	 */
	public function testResolveTableNoSlash() {
		$tableName = $this->callInaccessibleMethod($this->nameUtility, "resolveTableName", 'JonasWasHere');
		$this->assertEquals('jonaswashere', $tableName);
	}
}
