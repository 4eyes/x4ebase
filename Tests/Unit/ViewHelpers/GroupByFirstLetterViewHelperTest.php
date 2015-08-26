<?php

namespace X4E\X4ebase\Tests\Unit\ViewHelpers;

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
use \TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Test case for class \X4E\X4ebase\ViewHelpers\GroupByFirstLetterViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class GroupByFirstLetterViewHelperTest extends \X4E\X4ebase\Tests\Unit\Base\ViewHelperTestBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\ViewHelpers\GroupByFirstLetterViewHelper */
	protected $subject;

	/**
	 * @test
	 */
	public function testRender_WithIncompatibleType_ThrowsException() {
		$this->setExpectedException('\\Exception', 'Unsupported element type.');
		$this->subject->render(array(''), '');
	}

	public function testRender_WithArray_NotIssetProperty_ThrowsException() {
		$this->setExpectedException('\\Exception', 'The given property does not exist.');
		$this->subject->render(array(array('test' => 'one')), 'lorem');
	}

	public function testRender_WithArray_ReturnsGroupedArray() {
		$testCase = array(
			array('test' => 'lorem'),
			array('test' => 'ipsum'),
			array('test' => 'lorem'),
		);
		$expectedResult = array(
			'L' => array(array('test' => 'lorem'), array('test' => 'lorem')),
			'I' => array(array('test' => 'ipsum'))
		);
		$this->assertEquals($expectedResult, $this->subject->render($testCase, 'test'));
	}

	public function testRender_WithObject_NotIssetProperty_ThrowsException() {
		$this->markTestSkipped(
			'Error in ViewHelper: Getters do not throw Exceptions'
		);

		$this->setExpectedException('\\Exception', 'The given property does not exist.');
		$this->subject->render(new testClass(), 'lorem');
	}

	public function testRender_WithObject_ReturnsGroupedArray() {
		$expectedResult = array(
			'L' => array(new InnerTestClass('lorem'), new InnerTestClass('lorem')),
			'I' => array(new InnerTestClass('ipsum'))
		);
		$this->assertEquals($expectedResult, $this->subject->render(new testClass(), 'test'));
	}

}

class testClass {
	public $obj1;
	public $obj2;
	public $obj3;

	function __construct() {
		$this->obj1 = new innerTestClass('lorem');
		$this->obj2 = new innerTestClass('ipsum');
		$this->obj3 = new innerTestClass('lorem');
	}
}

class innerTestClass {
	protected $test;

	function __construct($test) {
		$this->test = $test;
	}

	public function getTest() {
		return $this->test;
	}
}