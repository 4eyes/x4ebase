<?php

namespace X4E\X4ebase\Tests\Unit\Base;

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
 * Base class for all Model test classes
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ModelTestBase extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var \TYPO3\CMS\Extbase\DomainObject\AbstractEntity|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface */
	protected $subject;

	public function setUp() {
		parent::setUp();
		$this->mockSubject();
	}

	/**
	 * Generic function to set $parameterName to $parameterValue
	 *
	 * @param $parameterName
	 * @param $parameterValue
	 */
	protected function genericSetter($parameterName, $parameterValue) {
		$parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
		call_user_func_array(array($this->subject, 'set' . $parameterName), array($parameterValue));
	}

	/**
	 * Generic function to get $parameterName
	 *
	 * @param $parameterName
	 * @return mixed
	 */
	protected function genericGetter($parameterName) {
		$parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
		return call_user_func(array($this->subject, 'get' . $parameterName));
	}

	/**
	 * Generic function to test if adding $testValue to $parameterName works
	 *
	 * @param $parameterName
	 * @param $testValue
	 */
	protected function genericAddTest($parameterName, $testValue) {
		$parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
		call_user_func_array(array($this->subject, 'add' . $parameterName), array($testValue));
		$this->assertTrue(
			$this->genericGetter($parameterName)->contains($testValue)
		);
	}

	/**
	 * Generic function to test if removing $testValue from $parameterName works
	 *
	 * @param $parameterName
	 * @param $testValue
	 */
	protected function genericRemoveTest($parameterName, $testValue) {
		$parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
		call_user_func_array(array($this->subject, 'remove' . $parameterName), array($testValue));
		$this->assertFalse(
			$this->genericGetter($parameterName)->contains($testValue)
		);
	}

	/**
	 * @param String $parameterName The name of the model parameter
	 * @param mixed $parameterValue The value the model parameter should be tested with
	 */
	protected function genericGetterSetterTest($parameterName, $parameterValue) {
		$this->genericSetter($parameterName, $parameterValue);
		$this->assertSame($parameterValue, $this->genericGetter($parameterName));
	}

	/**
	 * @param String $parameterName The name of the model parameter
	 * @param mixed $parameterValue The value the model parameter should be tested with
	 */
	protected function isTest($parameterName) {
		$parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
		$this->genericSetter($parameterName, TRUE);
		$this->assertTrue($this->subject->{'is' . $parameterName}());
	}

	/**
	 * Generic function that prepares the $parameterName and tests for adding and removing
	 * $testObject to/from it
	 *
	 * @param $parameterName
	 * @param $testObject
	 */
	protected function genericAddRemoveTest($parameterName, $testObject) {
		$this->genericAddTest($parameterName, $testObject);
		$this->genericRemoveTest($parameterName, $testObject);
	}

	/**
	 * @param String $parameterName The name of the model parameter
	 */
	protected function stringGetterSetterTest($parameterName) {
		$testVars = array('test', '123');
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}

	/**
	 * @param String $parameterName The name of the model parameter
	 */
	protected function integerGetterSetterTest($parameterName) {
		$testVars = array(5, 6);
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}

	/**
	 * @param String $parameterName The name of the model parameter
	 */
	protected function booleanGetterSetterTest($parameterName) {
		$testVars = array(TRUE);
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}

	protected function dateTimeGetterSetterTest($parameterName) {
		$testVars = array(new \DateTime());
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}

	protected function objectStorageGetterSetterTest($parameterName) {
		$testVars = array(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage);
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}

	protected function objectStorageAddRemoveTest($parameterName, $typeOfModel) {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
		$this->genericSetter($parameterName, $storage);
		$newItems = array(new $typeOfModel);
		foreach ($newItems as $newItem) {
			$this->genericAddRemoveTest($parameterName, $newItem);
		}
	}

	protected function initialValueTest($parameterName, $expectedInitialValue) {
		$this->assertSame($expectedInitialValue, $this->genericGetter($parameterName));
	}

	protected function arrayGetterSetterTest($parameterName) {
		$testVars = array(
			array(1, 2, 3),
			array(3, 4, 5),
			array('a', 'b', 'c')
		);
		foreach ($testVars as $testVar) {
			$this->genericGetterSetterTest($parameterName, $testVar);
		}
	}
}
