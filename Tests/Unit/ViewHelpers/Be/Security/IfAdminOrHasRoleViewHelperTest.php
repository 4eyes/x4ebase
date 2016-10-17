<?php

namespace X4e\X4ebase\Tests\Unit\ViewHelpers\Be\Security;

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
 * Test case for class \X4e\X4ebase\ViewHelpers\Be\Security\IfAdminOrHasRoleViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class IfAdminOrHasRoleViewHelperTest extends \X4e\X4ebase\Tests\Unit\Base\ViewHelperTestBase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4e\X4ebase\ViewHelpers\Be\Security\IfAdminOrHasRoleViewHelper */
    protected $subject;

    /**
     * @test
     */
    public function testRenderElseChild()
    {
        $this->mockSubject('backendUserIsAdmin', 'renderElseChild');

        $viewHelperNode = $this->getMock(\TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\ViewHelperNode::class, ['evaluateChildNodes'], [], '', false);
        $this->subject->setViewHelperNode($viewHelperNode);

        $beUser = $this->getMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class, ['isAdmin'], [], '', false);
        $beUser->expects($this->once())->method('isAdmin')->will($this->returnValue(false));
        $GLOBALS['BE_USER'] = $beUser;

        $this->subject->expects($this->once())
            ->method('renderElseChild');

        $this->subject->render('test');
    }

    /**
     * @test
     */
    public function testRenderThenChild()
    {
        $this->mockSubject('backendUserIsAdmin', 'renderThenChild', 'evaluateChildNodes');

        $viewHelperNode = $this->getMock(\TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\ViewHelperNode::class, ['evaluateChildNodes'], [], '', false);
        $this->subject->setViewHelperNode($viewHelperNode);

        $beUser = $this->getMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class, ['isAdmin'], [], '', false);
        $beUser->expects($this->once())->method('isAdmin')->will($this->returnValue(true));
        $GLOBALS['BE_USER'] = $beUser;

        $this->subject->expects($this->once())
            ->method('renderThenChild');

        $this->subject->render('test');
    }

    public function testBackendUserIsAdmin()
    {
        $this->mockSubject();
        $beUser = $this->getMock(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::class, ['isAdmin'], [], '', false);
        $beUser->expects($this->once())->method('isAdmin');

        $GLOBALS['BE_USER'] = $beUser;

        $this->subject->_call('backendUserIsAdmin');
    }
}
