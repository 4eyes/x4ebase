<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\Form;

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
 * Test case for class \X4e\X4ebase\ViewHelpers\Form\CheckboxViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class CheckboxViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\Form\CheckboxViewHelper */
    protected $subject;

    public function testInitializeArguments()
    {
        $this->mockSubject('registerUniversalTagAttributes', 'registerArgument', 'overrideArgument');
        $this->checkIfRegisterArgumentsGotCalledNTimes(11);
        $this->subject->initializeArguments();
    }

    public function testRenderHiddenFieldsForEmptyValue()
    {
        $this->mockSubject('getName');
        $this->subject->expects($this->once())->method('getName')->willReturn('test[]');
        $this->viewHelperVariableContainer = $this->getAccessibleMock(\TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer::class, ['exists', 'get', 'addOrUpdate'], [], '', false);
        $this->viewHelperVariableContainer->expects($this->once())->method('exists')->willReturn(true);
        $this->viewHelperVariableContainer->expects($this->once())->method('get')->willReturn(['hello']);
        $this->viewHelperVariableContainer->expects($this->once())->method('addOrUpdate')->with('TYPO3\CMS\Fluid\ViewHelpers\FormViewHelper', 'renderedHiddenFields', ['hello', 'test']);
        $this->subject->setArguments(['defaultHiddenValue'=>'default', 'renderHiddenField' => true]);
        $this->subject->_set('viewHelperVariableContainer', $this->viewHelperVariableContainer);

        $this->assertEquals('<input type="hidden" name="test" value="default" />', $this->subject->_call('renderHiddenFieldForEmptyValue'));
    }
}
