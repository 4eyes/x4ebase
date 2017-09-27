<?php

namespace X4e\X4ebase\Tests\Unit\View\Interceptor;

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
use TYPO3\CMS\Extbase\Object\ObjectManager;
use X4e\X4ebase\View\Interceptor\ReplaceTabs;

/**
 * Test case for class \X4e\X4ebase\View\Interceptor\ReplaceTabs
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ReplaceTabsTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|ReplaceTabs */
    protected $replaceTabs;
    protected $objectManager;

    public function setUp()
    {
        if (function_exists('xdebug_disable')) {
            xdebug_disable();
        }
        $this->replaceTabs = $this->getAccessibleMock(
            ReplaceTabs::class,
            ['dummy'],
            [],
            '',
            false
        );
        $this->objectManager = $this->getAccessibleMock(
            ObjectManager::class,
            ['get'],
            [],
            '',
            false
        );
    }

    public function tearDown()
    {
        unset($this->objectManager);
        unset($this->replaceTabs);
        if (function_exists('xdebug_enable')) {
            xdebug_enable();
        }
    }

    /**
     * @test
     */
    public function testInjectObjectManager()
    {
        $this->replaceTabs->injectObjectManager($this->objectManager);
        $this->assertSame($this->objectManager, $this->replaceTabs->_get('objectManager'));
    }

    /**
     * @test
     */
    public function testProcess()
    {
        $textNode = new \TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\TextNode('test');
        $parsingState = new \TYPO3Fluid\Fluid\Core\Parser\ParsingState();
        $this->replaceTabs->_set('objectManager', $this->objectManager);
        $this->replaceTabs->_get('objectManager')
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->isInstanceOf('\\TYPO3\\CMS\\Fluid\\Core\\Parser\\SyntaxTree\\NodeInterface'));
        $this->replaceTabs->process($textNode, 1, $parsingState);
    }

    /**
     * @test
     */
    public function testGetInterceptionPoints()
    {
        $this->assertSame([3], $this->replaceTabs->getInterceptionPoints());
    }
}
