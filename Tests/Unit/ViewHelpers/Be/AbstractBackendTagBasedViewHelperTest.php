<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\Be;

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

use TYPO3\CMS\Core\Tests\AccessibleObjectInterface;
use X4e\X4ebase\ViewHelpers\Be\AbstractBackendTagBasedViewHelper;

/**
 * Test case for class \X4e\X4ebase\ViewHelpers\Be\AbstractBackendTagBasedViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AbstractBackendTagBasedViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|AccessibleObjectInterface|AbstractBackendTagBasedViewHelper */
    protected $subject;

    public function testGetDocInstanceDocExists()
    {
        $this->subject = $this->getAccessibleMockForAbstractClass(
            $this->getSubjectClassName(),
            ['createDocInstance']
        );

        $this->viewHelperVariableContainer = $this->getMock(
            \TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer::class,
            ['exists', 'get']
        );
        $this->viewHelperVariableContainer->expects($this->once())->method('exists')->willReturn(true);
        $this->viewHelperVariableContainer->expects($this->once())->method('get');

        $this->subject->_set('viewHelperVariableContainer', $this->viewHelperVariableContainer);

        $this->subject->getDocInstance();
    }

    public function testGetDocInstanceDocDoesNotExistCallsCreateDocInstance()
    {
        $doc = $this->getMock(\TYPO3\CMS\Backend\Template\DocumentTemplate::class, [], [], '', false);

        $this->subject = $this->getMockBuilder($this->getSubjectClassName())
            ->setMethods(['createDocInstance'])
            ->getMockForAbstractClass();

        $this->subject = $this->getAccessibleMockForAbstractClass(
            $this->getSubjectClassName()
        );
        $this->markTestIncomplete(
            'methods of abstract classes cannot be mocked for accessible mocks'
        );
        //$this->subject->expects($this->once())->method('createDocInstance')->willReturn($doc);

        $this->viewHelperVariableContainer = $this->getMock(
            \TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer::class,
            ['exists', 'add']
        );
        $this->viewHelperVariableContainer->expects($this->once())->method('exists')->willReturn(false);
        $this->viewHelperVariableContainer->expects($this->once())->method('add');

        $this->subject->_set('viewHelperVariableContainer', $this->viewHelperVariableContainer);

        $this->subject->getDocInstance();
    }

    public function testCreateDocInstance()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );
    }
}
