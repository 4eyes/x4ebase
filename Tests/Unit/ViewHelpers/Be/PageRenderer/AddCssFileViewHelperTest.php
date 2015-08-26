<?php

namespace X4E\X4ebase\Tests\Unit\ViewHelpers\Be\PageRenderer;

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
use TYPO3\CMS\Backend\Template\DocumentTemplate;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Test case for class \X4E\X4ebase\ViewHelpers\Be\PageRenderer\AddCssFileViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AddCssFileViewHelperTest extends \X4E\X4ebase\Tests\Unit\Base\ViewHelperTestBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\ViewHelpers\Be\PageRenderer\AddCssFileViewHelper */
	protected $subject;

	/**
	 * @test
	 */
	public function testInitializeArguments() {
		$this->initializeArgumentsTest(8);
	}

	/**
	 * @test
	 */
	public function testRender() {
		$this->mockSubject('getDocInstance');
		$file = "test";

		$doc = $this->getMock(DocumentTemplate::class, array('getPageRenderer'), array(), '', FALSE);
		$pageRenderer = $this->getMock(PageRenderer::class, array('addCssFile'), array(), '', FALSE);
		$this->subject
			->expects($this->once())
			->method('getDocInstance')
			->will($this->returnValue($doc));
		$doc->expects($this->once())
			->method('getPageRenderer')
			->will($this->returnValue($pageRenderer));
		$pageRenderer->expects($this->once())
			->method('addCssFile');

		$this->subject->render($file);
	}

	public function testRender_withArgument() {
		$this->mockSubject('getDocInstance');
		$file = "test";

		$this->subject->setArguments(array("external" => TRUE));

		$doc = $this->getMock(DocumentTemplate::class, array('getPageRenderer'), array(), '', FALSE);
		$pageRenderer = $this->getMock(PageRenderer::class, array('addCssFile'), array(), '', FALSE);
		$this->subject
			->expects($this->once())
			->method('getDocInstance')
			->will($this->returnValue($doc));
		$doc->expects($this->once())
			->method('getPageRenderer')
			->will($this->returnValue($pageRenderer));
		$pageRenderer->expects($this->once())
			->method('addCssFile');

		$this->subject->render($file);
	}
}