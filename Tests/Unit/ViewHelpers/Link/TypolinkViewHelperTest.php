<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\Link;

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

/**
 * Test case for class \X4e\X4ebase\ViewHelpers\Link\TypolinkViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class TypolinkViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\Link\TypolinkViewHelper */
    protected $subject;

    public function testInitializeArguments()
    {
        $this->initializeArgumentsTest(0, 4, true);
    }

    protected function createEmptyLinkHref()
    {
        $mock = $this->createPartialMock(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class, ['getTypoLink_URL']);
        $mock->expects($this->any())->method('getTypoLink_URL')
            ->willReturn(false);
        return $mock;
    }

    public function createNonEmptyLinkHref()
    {
        $mock = $this->createPartialMock(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class, ['getTypoLink_URL']);
        $mock->expects($this->any())->method('getTypoLink_URL')
            ->willReturn('Hello');
        return $mock;
    }

    protected function mockObjectManager($mockedContentObjectRenderer)
    {
        $mock = $this->createPartialMock(ObjectManager::class, ['get']);
        $mock->expects($this->any())->method('get')->willReturn($mockedContentObjectRenderer);
        return $mock;
    }

    public function testRender()
    {
        //invalid $parameter and $keepContent FALSE
        $this->mockSubject('renderChildren');
        $this->subject->expects($this->any())->method('renderChildren')
            ->willReturn('Hello');
        $this->subject->_set('objectManager', $this->mockObjectManager($this->createEmptyLinkHref()));
        $this->assertEquals('', $this->subject->render('Hello'));

        //invalid $parameter and $keepContent TRUE
        $this->assertEquals('Hello', $this->subject->render('Hello', true));

        //valid $parameter
        $this->subject->_set('objectManager', $this->mockObjectManager($this->createNonEmptyLinkHref()));

        //returns null, because $this->subject->tag is mocked
        $this->assertEquals(null, $this->subject->render('Hello'));
    }
}
