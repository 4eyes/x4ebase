<?php

namespace X4e\X4ebase\Tests\Unit\Controller;

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
 * Test case for class \X4e\X4ebase\Controller\PageActionController
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class PageActionControllerTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase
{
    /** @var \X4e\X4ebase\Controller\PageActionController|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
    protected $subject;

    /**
     * @test
     */
    public function testInitializeActionFeMode()
    {
        $this->mockSubject();
        $environmentService = $this->createPartialMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, ['isEnvironmentInFrontendMode', 'isEnvironmentInBackendMode']);
        $environmentService->expects($this->once())->method('isEnvironmentInFrontendMode')->willReturn(true);
        $this->subject->_set('environmentService', $environmentService);

        $GLOBALS['TSFE'] = $this->getAccessibleMock(TypoScriptFrontendController::class, [], [], '', false);
        $GLOBALS['TSFE']->id = 0;

        $pageRepository = $this->getAccessibleMock(\X4e\X4ebase\Domain\Repository\PageRepository::class, ['findByUid'], [], '', false);
        $pageRepository->expects($this->once())->method('findByUid');

        $this->subject->_set('pageRepository', $pageRepository);

        $this->subject->initializeAction();
    }

    /**
     * @test
     */
    public function testInitializeActionBeMode()
    {
        $this->mockSubject();
        $environmentService = $this->createPartialMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class, ['isEnvironmentInFrontendMode', 'isEnvironmentInBackendMode']);
        $environmentService->expects($this->once())->method('isEnvironmentInFrontendMode')->willReturn(false);
        $environmentService->expects($this->once())->method('isEnvironmentInBackendMode')->willReturn(true);
        $this->subject->_set('environmentService', $environmentService);

        $GLOBALS['_GET']['id'] = 0;

        $pageRepository = $this->getAccessibleMock(\X4e\X4ebase\Domain\Repository\PageRepository::class, ['findByUid'], [], '', false);
        $pageRepository->expects($this->once())->method('findByUid');

        $this->subject->_set('pageRepository', $pageRepository);

        $this->subject->initializeAction();
    }

    /**
     * @test
     */
    public function testInjectPageRepository()
    {
        $this->mockSubject();
        $pageRepository = $this->getAccessibleMock(\X4e\X4ebase\Domain\Repository\PageRepository::class, [], [], '', false);
        $this->subject->injectPageRepository($pageRepository);
        $this->assertSame($pageRepository, $this->subject->_get('pageRepository'));
    }
}
