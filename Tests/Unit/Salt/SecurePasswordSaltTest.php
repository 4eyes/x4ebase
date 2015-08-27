<?php

namespace X4E\X4ebase\Tests\Unit\Salt;

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
 * Test case for class \X4E\X4ebase\Salt\SecurePasswordSalt
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class SecurePasswordSaltTest extends \X4E\X4ebase\Tests\Unit\Base\ModelTestBase {

	/** @var \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\Salt\SecurePasswordSalt */
	protected $subject;

	/**
	 * @test
	 */
	public function testInitialValues() {
		$this->initialValueTest('cost', 10);
		$this->initialValueTest('saltLength', 22);
	}

	/**
	 * @test
	 */
	public function testGettersSetters() {
		$this->integerGetterSetterTest('cost');
	}

	/**
	 * @test
	 */
	public function testCheckPassword() {
		$this->assertInternalType('boolean', $this->subject->checkPassword('test', password_hash('test', PASSWORD_DEFAULT)));
	}

	/**
	 * @test
	 */
	public function testGetHashedPassword() {
		$this->mockSubject();
		//array($plainPW, $salt, $expectedResult(hashed PW)
		$testCases = array(
			array('test', ''),
			array('lorem', 'ipsum'),
			array('foo', ''),
			array('bar', '')
		);
		foreach ($testCases as $testCase) {
			$this->assertTrue(password_verify($testCase[0], $this->subject->getHashedPassword($testCase[0], $testCase[1])));
		}
	}

	/**
	 * @test
	 */
	public function testIsHashUpdateNeeded() {
		$this->assertInternalType('boolean', $this->subject->isHashUpdateNeeded('test'));
	}

	public function testIsValidSalt() {
		$this->mockSubject();
		//array($salt, $expectedResult(Boolean)
		$testCases = array(
			array('a', FALSE),
			array('*abcdEFGhijKlmNoP1589452', FALSE),
			array('abcdEFGhijKlmNoP1589452', TRUE)
		);
		foreach ($testCases as $testCase) {
			$this->assertSame($testCase[1], $this->subject->isValidSalt($testCase[0]));
		}
	}

	public function testIsValidSaltedPW() {
		$this->mockSubject();
		//array($saltedPW, $expectedResult(Boolean)
		$testCases = array(
			array(password_hash('HelloWorld', PASSWORD_DEFAULT, array('cost' => 11)), FALSE),
			array(password_hash('HelloWorld', PASSWORD_DEFAULT, array('cost' => 10)), TRUE),
		);
		foreach ($testCases as $testCase) {
			$this->assertSame($testCase[1], $this->subject->isValidSaltedPW($testCase[0]));
		}
	}

	public function testConstruct() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}

	public function testIsAvailable() {
		$this->mockSubject();
		$this->assertEquals(1, $this->subject->isAvailable());
	}
}
