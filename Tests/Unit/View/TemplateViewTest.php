<?php

namespace X4E\X4ebase\Tests\Unit\View;

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
 * Test case for class \X4E\X4ebase\View\TemplateView
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class TemplateViewTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/**
	 * @test
	 */
	public function testBuildParserConfiguration() {
		$this->mockSubject();
		$parserConfiguration = $this->getMock(\TYPO3\CMS\Fluid\Core\Parser\Configuration::class, array('addInterceptor'));
		$parserConfiguration->expects($this->once())->method('addInterceptor')->with(new \X4E\X4ebase\View\Interceptor\ReplaceTabs());

		$objectManager = $this->getMock(\TYPO3\CMS\Extbase\Object\ObjectManager::class, array('get'), array(), '', FALSE);
		$objectManager->expects($this->at(0))->method('get')->willReturn($parserConfiguration);
		$objectManager->expects($this->at(1))->method('get')->willReturn(new \X4E\X4ebase\View\Interceptor\ReplaceTabs());

		$request = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Request::class, array('getFormat'));
		$request->expects($this->once())->method('getFormat')->willReturn('json');

		$controllerContext = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext::class, array('getRequest'));
		$controllerContext->expects($this->once())->method('getRequest')->willReturn($request);

		$this->subject->_set('objectManager', $objectManager);
		$this->subject->_set('controllerContext', $controllerContext);

		$this->subject->_call('buildParserConfiguration');
	}
}