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

	public function setUp() {
		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
	}

	public function tearDown() {
		unset($this->subject);
		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}

	public function testCreate_ThrowsZipExtensionNotInstalledException() {
		$this->markTestIncomplete(
			'Untestable - cannot unload php extensions with phpunit'
		);
	}

	/**
	 * @test
	 */
	public function testCreate_ThrowsFileNotExistException() {
		$this->setExpectedException('Exception');
		ZipUtility::create(dirname(__FILE__) . '/HelloWorld', 'test');
	}

	/**
	 * @test
	 */
	public function testCreate_Folder() {
		$testPath = dirname(__FILE__) . '/../../Fixtures/Unit/Utility/ZipUtilityTest/';
		$testFile = 'foldertest';
		$resultFile = 'Result/foldertest.zip';
		ZipUtility::create($testPath . $testFile, $testPath . $resultFile);
		$this->assertFileExists($testPath . $resultFile);
		unlink($testPath . $resultFile);
	}

	/**
	 * @test
	 */
	public function testCreate() {
		$testPath = dirname(__FILE__) . '/../../Fixtures/Unit/Utility/ZipUtilityTest/';
		$testFile = 'test.txt';
		$resultFile = 'Result/test.zip';
		ZipUtility::create($testPath . $testFile, $testPath . $resultFile);
		$this->assertFileExists($testPath . $resultFile);
		unlink($testPath . $resultFile);
	}

	public function testCreate_InNonExistentDirectory_NotCreatesZip() {
		$testPath = dirname(__FILE__) . '/../../Fixtures/Unit/Utility/ZipUtilityTest/';
		$testFile = 'test.txt';
		$resultFile = 'noResult/test.zip';
		ZipUtility::create($testPath . $testFile, $testPath . $resultFile);
		$this->assertFileNotExists($testPath . $resultFile);
	}

	/**
	 * @test
	 */
	public function testExtract_ThrowsException() {
		$this->setExpectedException('Exception');
		ZipUtility::extract();
	}
}