<?php

namespace X4E\X4ebase\Tests\Unit\Template;

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
 * Test case for class \X4E\X4ebase\Template\FilterTemplate
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class FilterTemplateTest extends \X4E\X4ebase\Tests\Unit\Base\ModelTestBase {

	/** @var  \X4E\X4ebase\Template\FilterTemplate|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface */
	protected $subject;

	/**
	 * @test
	 */
	public function testInitialValues() {
		$this->initialValueTest("filterArray", array());
		$this->initialValueTest("searchStrings", array());
		$this->initialValueTest("searchableParameters", array());
		$this->initialValueTest("filterMethods", array());
	}

	/**
	 * @test
	 */
	public function testGettersSetters() {
		$this->arrayGetterSetterTest("filterArray");
		$this->arrayGetterSetterTest("searchStrings");
		$this->arrayGetterSetterTest("searchableParameters");
		$this->arrayGetterSetterTest("filterMethods");
	}

	/**
	 * @test
	 */
	public function testAddSearchableParameterAddsParameterOnlyOnce() {
		$this->subject->setSearchableParameters(array());
		$testCases = array(
			array("lorem", array("lorem")),
			array("ipsum", array("lorem", "ipsum")),
			array("dolor", array("lorem", "ipsum", "dolor")),
			array("lorem", array("lorem", "ipsum", "dolor")),
		);
		foreach ($testCases as $testCase) {
			$this->subject->addSearchableParameter($testCase[0]);
			$this->assertSame($testCase[1], $this->subject->getSearchableParameters());
		}
	}

	/**
	 * @test
	 */
	public function testAddMultipleSearchableParametersCallsAddSearchableParameterNTimes() {
		$this->mockSubject("addSearchableParameter");
		$testCases = array(
			array(array("lorem"), 1),
			array(array("lorem", "ipsum"), 2),
			array(array("lorem", "ipsum", "dolor"), 3),
			array(array("lorem", "ipsum", "dolor", "sit"), 4)
		);

		foreach ($testCases as $testCase) {
			$i = 0;
			foreach ($testCase[0] as $testParameter) {
				$this->subject
					->expects($this->at($i))
					->method("addSearchableParameter")
					->with($testParameter);
				$i++;
			}
			$this->subject->addMultipleSearchableParameters($testCase[0]);
		}
	}

	/**
	 * @test
	 */
	public function testRemoveSearchableParameter() {
		$initialState = array("lorem", "ipsum", "dolor", "sit", "amet");
		//array($parameter, $result)
		$testCases = array(
			array("ipsum", array("lorem", "dolor", "sit", "amet")),
			array("lorem", array("ipsum", "dolor", "sit", "amet")),
		);
		foreach ($testCases as $testCase) {
			$this->subject->setSearchableParameters($initialState);
			$this->subject->removeSearchableParameter($testCase[0]);
			$this->assertSame($testCase[1], $this->subject->getSearchableParameters());
		}
	}

	/**
	 * @test
	 */
	public function testAddFilterToFilterArray() {
		$this->subject->setFilterArray(array());
		//array(filterKey, filterValue, expectedResult)
		$testCases = array(
			array("lorem", "a", array("lorem" => "a")),
			array("ipsum", "a", array("lorem" => "a", "ipsum" => "a")),
			array("dolor", "b", array("lorem" => "a", "ipsum" => "a", "dolor" => "b")),
			array("lorem", "b", array("lorem" => "b", "ipsum" => "a", "dolor" => "b")),
		);
		foreach ($testCases as $testCase) {
			$this->subject->addFilterToFilterArray($testCase[0], $testCase[1]);
			$this->assertSame($testCase[2], $this->subject->getFilterArray());
		}
	}

	/**
	 * @test
	 */
	public function testRemoveFilterFromFilterArray() {
		$initialState = array("lorem" => "a", "ipsum" => "a", "dolor" => "b", "sit" => "b", "amet" => "c");
		$testCases = array(
			array("lorem", array("ipsum" => "a", "dolor" => "b", "sit" => "b", "amet" => "c")),
			array("dolor", array("lorem" => "a", "ipsum" => "a", "sit" => "b", "amet" => "c")),
		);
		foreach ($testCases as $testCase) {
			$this->subject->setFilterArray($initialState);
			$this->subject->removeFilterFromFilterArray($testCase[0]);
			$this->assertSame($testCase[1], $this->subject->getFilterArray());
		}
	}

	/**
	 * @test
	 */
	public function testSetSearchStringsFromSpaceSeparatedList() {
		$testCases = array(
			array("Lorem", array("Lorem")),
			array("Lorem! Ipsum", array("Lorem!", "Ipsum")),
			array("Lorem ! Ipsum", array("Lorem", "!", "Ipsum"))
		);
		foreach ($testCases as $testCase) {
			$this->subject->setSearchStringsFromSpaceSeparatedList($testCase[0]);
			$this->assertSame($testCase[1], $this->subject->getSearchStrings());
		}
	}

	/**
	 * @test
	 */
	public function testGetFilterMethodForParameter() {
		$initialState = array("lorem" => "a", "ipsum" => "a", "dolor" => "b", "sit" => "b", "amet" => "c");
		$testCases = array(
			array("lorem", "a"),
			array("amet", "c"),
			array("sit", "b")
		);
		foreach ($testCases as $testCase) {
			$this->subject->setFilterMethods($initialState);
			$this->assertSame($testCase[1], $this->subject->getFilterMethodForParameter($testCase[0]));
		}
	}

}
