<?php

namespace X4e\X4ebase\Tests\Unit\Utility;

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

use X4e\X4ebase\Utility\GeneralUtility;

/**
 * Test case for class \X4e\X4ebase\Utility\GeneralUtilityTest
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class GeneralUtilityTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    public function setUp()
    {
        if (function_exists('xdebug_disable')) {
            xdebug_disable();
        }
    }

    public function tearDown()
    {
        if (function_exists('xdebug_enable')) {
            xdebug_enable();
        }
    }

    /**
     * @test
     */
    public function testGenerateUniqueIdReturnsInteger()
    {
        $this->assertInternalType('integer', GeneralUtility::generateUniqueId());
    }

    /**
     * @test
     */
    public function testGenerateUniqueStringReturnsString()
    {
        $this->assertInternalType('string', GeneralUtility::generateUniqueString());
    }

    /**
     * @test
     */
    public function testGenerateUidArrayForPropertyWithWrongObjectReturnsEmptyArray()
    {
        $this->assertSame([], GeneralUtility::generateUidArrayForProperty(false, 'test'));
    }

    /**
     * @test
     */
    public function testGenerateUidArrayForPropertyWithWrongPropertyThrowsException()
    {
        $this->setExpectedException('\\RuntimeException');
        GeneralUtility::generateUidArrayForProperty(new \stdClass(), 'test');
    }

    /**
     * @test
     */
    public function testGenerateUidArrayForPropertyWithObjectReturnsArray()
    {
        $this->assertSame([1, 5], GeneralUtility::generateUidArrayForProperty(new TestClass(1), 'objects'));
    }

    /**
     * @test
     */
    public function testGenerateUidArrayForPropertyWithArrayReturnsArray()
    {
        $this->assertSame([1, 5], GeneralUtility::generateUidArrayForProperty(new TestClass(1), 'array'));
    }

    /**
     * @test
     */
    public function testGenerateUidListForPropertyReturnsString()
    {
        $this->assertInternalType('string', GeneralUtility::generateUidListForProperty('', ''));
    }

    public function testGetExtConfReturnsArrayOrNull()
    {
        $this->assertSame(false, GeneralUtility::getExtConf('testExt'));

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['testExt'] = serialize(['uid' => 1]);

        $this->assertSame(['uid' => 1], GeneralUtility::getExtConf('testExt'));
    }
}

class testClass
{
    public $obj1;
    public $obj2;

    public function __construct()
    {
        $this->obj1 = new testSubClass(1);
        $this->obj2 = new testSubClass(5);
    }

    public function getObjects()
    {
        return new testClass(2);
    }

    public function getArray()
    {
        return [
            ['uid' => 1],
            ['uid' => 5],
        ];
    }

    public function count()
    {
        return true;
    }
}

class testSubClass
{
    protected $uid;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    public function getUid()
    {
        return $this->uid;
    }
}
