<?php
namespace X4E\X4eequinella\Tests\Unit\Domain\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014
 *    Andreas Keller <andi@4eyes.ch>, 4eyes GmbH
 *    Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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
 ***************************************************************/

use X4E\X4ebase\Validation\Validator\NotTrimEmptyValidator;

/**
 * Test case for class \X4E\X4ebase\Validation\Validator\NotTrimEmptyValidator
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Alessandro Bellafronte <alessandro@4eyes.ch>
 */
class NotTrimEmptyValidatorTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 *
	 * @var \X4E\X4ebase\Validation\Validator\NotTrimEmptyValidator
	 */
	protected $validator;

	/**
	 * @var array
	 */
	protected $settings = array();

	public function setUp() {
		$this->validator = new NotTrimEmptyValidator();

		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
	}

	public function tearDown() {
		unset($this->validator);
		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}


	//////////////////////////////////////
	// Tests
	//////////////////////////////////////

	/**
	 * @test
	 */
	public function testIsValidIsString() {
		$this->markTestIncomplete(
			'This test throws errors in new Typo3 Versions due to validator->getErrors was moved to validator->result->getErrors.'
		);
//		// Test NULL value
//		$this->validator->isValid(NULL);
//		$this->assertEquals(array(), $this->validator->getErrors(), 'NULL');
//
//		// Test object value
//		$this->validator->isValid(new \stdClass());
//		$this->assertEquals(array(), $this->validator->getErrors(), 'Object');
//
//		// Test int value
//		$this->validator->isValid(123);
//		$this->assertEquals(array(), $this->validator->getErrors(), 'Integer');
	}

	/**
	 * @test
	 */
	public function testIsValidDefaultChars() {
		$this->markTestIncomplete(
			'This test throws errors in new Typo3 Versions due to validator->getErrors was moved to validator->result->getErrors.'
		);

//		// Test the default chars
//		$stringsToTest = array(
//			"Hallo Welt " => 'Hallo Welt',
//			"\tHallo" => 'tabHallo',
//			"Welt\n" => 'Weltnewline',
//			"\r Test" => 'carriagereturn Test',
//			"\0\x0B Foo" => 'vertTab Foo'
//		);
//
//		foreach($stringsToTest as $string => $title){
//			$this->validator->isValid($string);
//			$this->assertEquals(array(), $this->validator->getErrors(), $title);
//		}
	}

	/**
	 * @test
	 */
	public function testIsValidDefaultCharsHasErrors() {
		$this->markTestIncomplete(
			'This test throws errors in new Typo3 Versions due to validator->getErrors was moved to validator->result->getErrors.'
		);

//		// Test the default chars
//		$stringsToTest = array(
//			" ",
//			"\t",
//			"\n",
//			"\r",
//			"\0\x0B",
//			"\n \t",
//			"\r\n",
//			"\0\x0B\0\x0B"
//		);
//
//		foreach($stringsToTest as $string){
//			$this->setUp();
//			$this->validator->isValid($string);
//			$this->assertEquals(1, count($this->validator->getErrors()));
//			$this->tearDown();
//		}
	}

	/**
	 * @test
	 */
	public function testIsValidCustomChars() {
		$this->markTestIncomplete(
			'This test throws errors in new Typo3 Versions due to validator->getErrors was moved to validator->result->getErrors.'
		);

//		// custom chars to trim
//		$charList = "aä@bB";
//
//		// Test the default chars
//		$stringsToTest = array(
//			"aA",
//			"foob",
//			"michel@test",
//			"äs_",
//			"bBvc",
//			"@vbc@",
//			"ädfda",
//		);
//
//		foreach($stringsToTest as $string){
//			$this->setUp();
//			$this->validator->setOptions(array('charlist' => $charList));
//			$this->validator->isValid($string);
//			$this->assertEquals(array(), $this->validator->getErrors());
//			$this->tearDown();
//		}
	}

	/**
	 * @test
	 */
	public function testIsValidCustomCharsHasErrors() {
		$this->markTestIncomplete(
			'This test throws errors in new Typo3 Versions due to validator->getErrors was moved to validator->result->getErrors.'
		);

//		// custom chars to trim
//		$charList = "aä@bB";
//
//		// Test the default chars
//		$stringsToTest = array(
//			"a",
//			"b",
//			"@",
//			"ä",
//			"bB",
//			"@@",
//			"äa",
//		);
//
//		foreach($stringsToTest as $string){
//			$this->setUp();
//			$this->validator->setOptions(array('charlist' => $charList));
//			$this->validator->isValid($string);
//			$this->assertEquals(1, count($this->validator->getErrors()));
//			$this->tearDown();
//		}
	}
}

?>