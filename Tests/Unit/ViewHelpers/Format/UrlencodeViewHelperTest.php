<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\Format;

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
use TYPO3\CMS\Extbase\Validation\Exception;

/**
 * Test case for class \X4e\X4ebase\ViewHelpers\Format\UrlencodeViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class UrlencodeViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\Format\UrlencodeViewHelper */
	protected $subject;

	/**
	 * @test
	 */
	public function testRenderFromArgument() {
		$testCases = array(
			'Lorem-IpsumçDolor Sit_amet'
		);

		foreach ($testCases as $testCase) {
			$this->assertSame(str_replace('%20', ' ', rawurlencode($testCase)), $this->subject->render(TRUE, $testCase));
		}
	}

	/**
	 * @test
	 */
	public function testRenderFromChildren() {
		$this->mockSubject('renderChildren');

		$testCases = array(
			'Lorem-IpsumçDolor Sit_amet'
		);

		for ($i = 0; $i < count($testCases); $i++) {
			$this->subject->expects($this->at($i))->method('renderChildren')
				->willReturn($testCases[$i]);
		}
		foreach ($testCases as $testCase) {
			$this->assertSame(str_replace('%20', ' ', rawurlencode($testCase)), $this->subject->render());
		}
	}

	/**
	 * @test
	 */
	public function testRenderWithInvalidValue() {
		$this->assertEquals(5, $this->subject->render(TRUE,5));
	}
}