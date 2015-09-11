<?php

namespace X4E\X4ebase\Tests\Unit\ViewHelpers\Uri;

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
 * Test case for class \X4E\X4ebase\ViewHelpers\Uri\TypolinkViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class TypolinkViewHelperTest extends \X4E\X4ebase\Tests\Unit\Base\ViewHelperTestBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\ViewHelpers\Uri\TypolinkViewHelper */
	protected $subject;

	/**
	 * @test
	 */
	public function testInitializeArguments() {
		$this->mockSubject('registerUniversalTagAttributes', 'registerTagAttribute');
		$this->subject->expects($this->once())->method('registerUniversalTagAttributes');
		$this->subject->initializeArguments();
	}

	/**
	 * @test
	 */
	public function testRender_ValidLinkHref_ReturnsLinkHref() {
		$this->subject->_set('objectManager', $this->mockObjectManager($this->createNonEmptyLinkHref()));
		$this->assertEquals('Hello', $this->subject->render('Hello'));
	}

	/**
	 * @test
	 */
	public function testRender_InvalidLinkHref_ReturnsEmptyString() {
		$this->subject->_set('objectManager', $this->mockObjectManager($this->createEmptyLinkHref()));
		$this->assertEquals('', $this->subject->render('Hello'));
	}

	protected function createEmptyLinkHref() {
		$mock = $this->getMock(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class, array('getTypoLink_URL'));
		$mock->expects($this->any())->method('getTypoLink_URL')
			->willReturn(FALSE);
		return $mock;
	}

	public function createNonEmptyLinkHref() {
		$mock = $this->getMock(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class, array('getTypoLink_URL'));
		$mock->expects($this->any())->method('getTypoLink_URL')
			->willReturn('Hello');
		return $mock;
	}

	protected function mockObjectManager($mockedContentObjectRenderer) {
		$mock = $this->getMock(ObjectManager::class, array('get'));
		$mock->expects($this->any())->method('get')->willReturn($mockedContentObjectRenderer);
		return $mock;
	}
}