<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\PageRenderer;

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
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Test case for class \X4e\X4ebase\ViewHelpers\PageRenderer\AddJsFileViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AddJsFileViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\PageRenderer\AddJsFileViewHelper */
    protected $subject;

    /**
     * @test
     */
    public function testInitializeArguments()
    {
        $this->initializeArgumentsTest(6);
    }

    /**
     * @test
     */
    public function testRender()
    {
        $this->mockSubject('isCached');
        $this->subject->expects($this->at(0))->method('isCached')->willReturn(false);
        $this->subject->expects($this->at(1))->method('isCached')->willReturn(true);

        $file = 'test';

        $pageRenderer = $this->getMock(PageRenderer::class, ['addJsFile'], [], '', false);
        $pageRenderer->expects($this->once())->method('addJsFile');
        $this->subject->_set('pageRenderer', $pageRenderer);

        //Avoid TSFE-Action
        $this->subject->setArguments(['external' => true]);
        for ($i = 0; $i < 2; $i++) {
            $this->subject->render($file);
        }
    }
}
