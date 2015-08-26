<?php

namespace X4E\X4ebase\Tests\Unit\Base;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Base class for all repository test classes.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ViewHelperTestBase extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var \TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer */
	protected $viewHelperVariableContainer;
	/** @var \TYPO3\CMS\Fluid\Core\ViewHelper\TemplateVariableContainer */
	protected $templateVariableContainer;
	/** @var \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder */
	protected $uriBuilder;
	/** @var \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext */
	protected $controllerContext;
	/** @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder */
	protected $tagBuilder;
	/** @var \TYPO3\CMS\Fluid\Core\ViewHelper\Arguments */
	protected $arguments;
	/** @var \TYPO3\CMS\Extbase\Mvc\Web\Request */
	protected $request;
	/** @var \TYPO3\CMS\Fluid\Core\Rendering\RenderingContext */
	protected $renderingContext;
	/** @var \TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfigurationService */
	protected $mvcPropertyMapperConfigurationService;

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|AbstractViewHelper */
	protected $subject;

	public function setUp() {
		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
		$this->setUpDependencies();
		$this->mockSubject('registerArguments');
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->subject);

		if (function_exists('xdebug_enable')) {
			xdebug_enable();
		}
	}

	protected function setUpDependencies() {
		$this->viewHelperVariableContainer = $this->getMock(\TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer::class);
		$this->templateVariableContainer = $this->getMock(\TYPO3\CMS\Fluid\Core\ViewHelper\TemplateVariableContainer::class);
		$this->uriBuilder = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
		$this->uriBuilder->expects($this->any())->method('reset')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setArguments')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setSection')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setFormat')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setCreateAbsoluteUri')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setAddQueryString')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setArgumentsToBeExcludedFromQueryString')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setLinkAccessRestrictedPages')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setTargetPageUid')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setTargetPageType')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setNoCache')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setUseCacheHash')->will($this->returnValue($this->uriBuilder));
		$this->uriBuilder->expects($this->any())->method('setAddQueryStringMethod')->will($this->returnValue($this->uriBuilder));
		$this->request = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Web\Request::class);
		$this->controllerContext = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext::class, array(), array(), '', FALSE);
		$this->controllerContext->expects($this->any())->method('getUriBuilder')->will($this->returnValue($this->uriBuilder));
		$this->controllerContext->expects($this->any())->method('getRequest')->will($this->returnValue($this->request));
		$this->tagBuilder = $this->getMock(\TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder::class);
		$this->arguments = array();
		$this->renderingContext = $this->getAccessibleMock(\TYPO3\CMS\Fluid\Core\Rendering\RenderingContext::class, array('dummy'));
		$this->renderingContext->injectTemplateVariableContainer($this->templateVariableContainer);
		$this->renderingContext->_set('viewHelperVariableContainer', $this->viewHelperVariableContainer);
		$this->renderingContext->setControllerContext($this->controllerContext);
		$this->mvcPropertyMapperConfigurationService = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfigurationService::class, array('dummy'));
	}

	/**
	 * @param \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper $viewHelper
	 * @return void
	 */
	protected function injectDependenciesIntoViewHelper(\TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper $viewHelper) {
		$viewHelper->setRenderingContext($this->renderingContext);
		$viewHelper->setArguments($this->arguments);
		if ($viewHelper instanceof \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper) {
			$viewHelper->_set('tag', $this->tagBuilder);
		}
	}

	protected function mockSubject() {
		call_user_func_array('parent::' . __FUNCTION__, func_get_args());
		$this->injectDependenciesIntoViewHelper($this->subject);
	}

	protected function initializeArgumentsTest($n) {
		$this->mockSubject('registerArgument');
		$this->checkIfInitializeArgumentsGotCalledNTimes($n);
		$this->subject->initializeArguments();
	}

	protected function checkIfInitializeArgumentsGotCalledNTimes($n) {
		$this->subject
			->expects($this->exactly($n))
			->method('registerArgument');
	}

	protected function checkIfRegisterTagAttributeGotCalledNTimes($n) {
		$this->subject
			->expects($this->exactly($n))
			->method('registerTagAttribute');
	}

}