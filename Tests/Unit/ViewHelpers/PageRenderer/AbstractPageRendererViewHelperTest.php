<?php

namespace X4E\X4ebase\Tests\Unit\ViewHelpers\PageRenderer;

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
use \TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Test case for class \X4E\X4ebase\ViewHelpers\PageRenderer\AbstractPageRendererViewHelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class AbstractPageRendererViewHelperTest extends \X4E\X4ebase\Tests\Unit\Base\ViewHelperTestBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\X4E\X4ebase\ViewHelpers\PageRenderer\AbstractPageRendererViewHelper */
	protected $subject;

	public function testInjectPageRenderer() {
		$this->subject = $this->getAccessibleMockForAbstractClass(\X4E\X4ebase\ViewHelpers\PageRenderer\AbstractPageRendererViewHelper::class);
		$pageRenderer = new \TYPO3\CMS\Core\Page\PageRenderer();
		$this->subject->injectPageRenderer($pageRenderer);
		$this->assertEquals($pageRenderer, $this->subject->_get('pageRenderer'));
	}

	public function testInjectConfigurationManager() {
		$this->subject = $this->getAccessibleMockForAbstractClass(\X4E\X4ebase\ViewHelpers\PageRenderer\AbstractPageRendererViewHelper::class);
		$configurationManager = new \TYPO3\CMS\Extbase\Configuration\ConfigurationManager();
		$this->subject->injectConfigurationManager($configurationManager);
		$this->assertEquals($configurationManager, $this->subject->_get('configurationManager'));
	}

	public function testIsCached() {
		$this->mockSubject();

		$contentObject = $this->getMock(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class, array('getUserObjectType'), array(), '', FALSE);
		$contentObject->expects($this->atLeastOnce())->method('getUserObjectType')->willReturn(1);

		$configurationManager = $this->getMock(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class, array('getContentObject'),array(), '', FALSE);
		$configurationManager->expects($this->atLeastOnce())->method('getContentObject')->willReturn($contentObject);

		$this->subject->_set('configurationManager', $configurationManager);

		$this->subject->_call('isCached');
	}
}