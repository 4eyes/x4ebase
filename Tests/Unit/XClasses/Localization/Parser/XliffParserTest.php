<?php

namespace X4E\X4ebase\Tests\Unit\XClasses\Localization\Parser;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Test case for class \X4E\X4ebase\XClasses\Localization\Parser\XliffParser
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class XliffParserTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	public function setUp() {

		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
	}

	public function tearDown() {

		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}

	/**
	 * @test
	 */
	public function testGetParseData() {
		$this->markTestSkipped(
			'What exactly is the purpose of this xclass? Not sure if test or class work incorrectly'
		);

		$sourcePath = dirname(__FILE__) . '/../../../../Fixtures/Unit/XClasses/Localization/Parser/XliffParserTest/locallang.xlf';
		$languageKey = 'de';
		//$charset = 'utf8';
		$expectedResult = array(
			'de' => array(
				'headerComment' => array(
					0 => array(
						'source' => 'Foo',
						'target' => 'Oof',
					)
				),
				'generator' => array(
					0 => array(
						'source' => 'Bar',
						'target' => 'Rab',
					)
				)
			)

		);

		$xliffParser = new \X4E\X4ebase\XClasses\Localization\Parser\XliffParser();
		$this->assertEquals($expectedResult, $xliffParser->getParsedData($sourcePath, $languageKey));
	}

}
