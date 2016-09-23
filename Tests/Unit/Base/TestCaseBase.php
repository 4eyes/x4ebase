<?php

namespace X4e\X4ebase\Tests\Unit\Base;

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
 * Test class for class \X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class TestCaseBase extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface */
    protected $subject;

    public function setUp()
    {
        if (function_exists('xdebug_disable')) {
            xdebug_disable();
        }
    }

    public function tearDown()
    {
        unset($this->subject);
        if (function_exists('xdebug_enable')) {
            xdebug_enable();
        }
    }

    protected function mockSubject()
    {
        $methods = func_get_args();
        if (empty($methods)) {
            $methods = ['dummy'];
        }
        $this->subject = $this->getAccessibleSubjectInstance($methods);
    }

    /**
     * @return string
     */
    protected function getSubjectClassName()
    {
        //get class name of viewHelperTest
        $class = get_class($this);
        //trim 'test' off the viewHelperTest
        $class = substr($class, 0, -4);
        //delete 'Tests\Unit\' from namespace
        $class = str_replace('Tests\\Unit\\', '', $class);
        return $class;
    }

    /**
     * @param array $methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface
     */
    protected function getAccessibleSubjectInstance(array $methods = ['dummy'])
    {
        return $this->getAccessibleMock(
            $this->getSubjectClassName(),
            $methods,
            [],
            '',
            false
        );
    }
}
