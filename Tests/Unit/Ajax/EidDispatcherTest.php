<?php

namespace X4e\X4ebase\Tests\Unit\Ajax;

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
 * Test case for class \X4e\X4ebase\Ajax\EidDispatcher
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class EidDispatcherTest extends \X4e\X4ebase\Tests\Unit\Base\ModelTestBase
{

    /** @var \X4e\X4ebase\Ajax\EidDispatcher|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface */
    protected $subject;

    /**
     * @test
     */
    public function testInitialValues()
    {
        $this->initialValueTest('vendor', null);
        $this->initialValueTest('extensionName', null);
        $this->initialValueTest('pluginName', null);
        $this->initialValueTest('controller', null);
        $this->initialValueTest('action', null);
        $this->initialValueTest('forceVendor', true);
        $this->initialValueTest('forceExtensionName', true);
        $this->initialValueTest('forcePluginName', false);
        $this->initialValueTest('forceController', false);
        $this->initialValueTest('forceAction', false);
        $this->initialValueTest('requestFormat', 'html');
    }

    /**
     * @test
     */
    public function testGettersSetters()
    {
        $this->stringGetterSetterTest('vendor');
        $this->stringGetterSetterTest('extensionName');
        $this->stringGetterSetterTest('pluginName');
        $this->stringGetterSetterTest('controller');
        $this->stringGetterSetterTest('action');
        $this->booleanGetterSetterTest('forceVendor');
        $this->booleanGetterSetterTest('forceExtensionName');
        $this->booleanGetterSetterTest('forcePluginName');
        $this->booleanGetterSetterTest('forceController');
        $this->booleanGetterSetterTest('forceAction');
        $this->stringGetterSetterTest('requestFormat');
    }

    public function testBootstrapAndDispatch()
    {
        $this->markTestIncomplete(
            'Untestable - Static method calls'
        );
    }

    public function testConstruct()
    {
        $this->mockSubject();
        $vendor = 'Lorem';
        $extensionName = 'Ipsum';
        $pluginName = 'Dolor';
        $controller = 'Sit';
        $action = 'Amet';

        $this->subject->__construct($vendor, $extensionName, $pluginName, $controller, $action);

        $this->assertEquals($vendor, $this->subject->_get('vendor'));
        $this->assertEquals($extensionName, $this->subject->_get('extensionName'));
        $this->assertEquals($pluginName, $this->subject->_get('pluginName'));
        $this->assertEquals($controller, $this->subject->_get('controller'));
        $this->assertEquals($action, $this->subject->_get('action'));
    }
}
