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
use X4E\X4ebase\Utility\ZipUtility;

/**
 * Test case for class \X4E\X4ebase\Utility\ZipUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ZipUtilityTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	protected $testPath;
	protected $testFile;
	protected $resultFile;

	public function setUp() {
		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
		$this->testPath = dirname(__FILE__) . '/../../Fixtures/Unit/Utility/ZipUtilityTest/';
		$this->testFile = 'test.txt';
		$this->resultFile = 'test.zip';
	}

	public function tearDown() {
		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}

	/**
	 * @test
	 */
	public function testCreateThrowsFileNotExistException() {
		$this->setExpectedException('Exception');
		ZipUtility::create(dirname(__FILE__) . '/HelloWorld', 'test');
	}

	/**
	 * @test
	 */
	public function testCreate() {
		ZipUtility::create($this->testPath . $this->testFile, $this->testPath . $this->resultFile);
		$this->assertFileExists($this->testPath . $this->resultFile);
		unlink($this->testPath . $this->resultFile);
	}

	/**
	 * @test
	 */
	public function testExtractThrowsException() {
		$this->setExpectedException('Exception');
		ZipUtility::extract();
	}
}