<?php

namespace X4E\X4ebase\Tests\Unit\Domain\Model;

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
class ModelTestAbstractClass extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
     */
    protected $model;

    /**
     * @param String $parameterName The name of the model parameter
     * @param mixed $parameterValue The value the model parameter should be tested with
     */
    protected function genericGetterSetterTest($parameterName, $parameterValue) {
        $parameterName = GeneralUtility::underscoredToUpperCamelCase($parameterName);
        call_user_func_array(array($this->model,"set".$parameterName),array($parameterValue));
        $this->assertEquals($parameterValue,call_user_func(array($this->model,"get".$parameterName)));
    }

    /**
     * @param String $parameterName The name of the model parameter
     */
    protected function stringGetterSetterTest($parameterName) {
        $testVars = array("test","123");
        foreach($testVars as $testVar) {
            $this->genericGetterSetterTest($parameterName, $testVar);
        }
    }

    /**
     * @param String $parameterName The name of the model parameter
     */
    protected function integerGetterSetterTest($parameterName) {
        $testVars = array(5,6);
        foreach($testVars as $testVar) {
            $this->genericGetterSetterTest($parameterName, $testVar);
        }
    }

    /**
     * @param String $parameterName The name of the model parameter
     */
    protected function booleanGetterSetterTest($parameterName) {
        $testVars = array(TRUE,FALSE);
        foreach($testVars as $testVar) {
            $this->genericGetterSetterTest($parameterName,$testVar);
        }
    }

}
