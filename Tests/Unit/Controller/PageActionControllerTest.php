<?php

namespace X4E\X4ebase\Tests\Unit\Controller;

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
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Test case for class \X4E\X4ebase\Unit\Controller\PageActionController
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageActionControllerTest extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {
	/** @var \X4E\X4ebase\Controller\PageActionController|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
	protected $subject;

	/**
	 * @test
	 */
	public function testInitializeActionFeMode() {
		$this->mockSubject();
		$environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, array("isEnvironmentInFrontendMode", "isEnvironmentInBackendMode"));
		$environmentService->expects($this->once())->method("isEnvironmentInFrontendMode")->will($this->returnValue(TRUE));
		$this->subject->_set("environmentService", $environmentService);

		$GLOBALS["TSFE"] = $this->getMock(TypoScriptFrontendController::class, array(), array(), "", FALSE);
		$GLOBALS['TSFE']->id = 0;

		$pageRepository = $this->getMock(\X4E\X4ebase\Domain\Repository\PageRepository::class, array("findByUid"), array(), "", FALSE);
		$pageRepository->expects($this->once())->method("findByUid");

		$this->subject->_set("pageRepository", $pageRepository);

		$this->subject->initializeAction();
	}

	/**
	 * @test
	 */
	public function testInitializeActionBeMode() {
		$this->mockSubject();
		$environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, array("isEnvironmentInFrontendMode", "isEnvironmentInBackendMode"));
		$environmentService->expects($this->once())->method("isEnvironmentInFrontendMode")->will($this->returnValue(FALSE));
		$environmentService->expects($this->once())->method("isEnvironmentInBackendMode")->will($this->returnValue(TRUE));
		$this->subject->_set("environmentService", $environmentService);

		$GLOBALS['_GET']['id'] = 0;

		$pageRepository = $this->getMock(\X4E\X4ebase\Domain\Repository\PageRepository::class, array("findByUid"), array(), "", FALSE);
		$pageRepository->expects($this->once())->method("findByUid");

		$this->subject->_set("pageRepository", $pageRepository);

		$this->subject->initializeAction();
	}

	/**
	 * @test
	 */
	public function testInjectPageRepository() {
		$this->mockSubject();
		$pageRepository = $this->getMock(\X4E\X4ebase\Domain\Repository\PageRepository::class, array(), array(), "", FALSE);
		$this->subject->injectPageRepository($pageRepository);
		$this->assertSame($pageRepository, $this->subject->_get("pageRepository"));
	}
}
