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

/**
 * Base class for controller test cases.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class ControllerTestBase extends \X4E\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|\TYPO3\CMS\Extbase\Mvc\Controller\ActionController */
	protected $subject = NULL;

	protected $view;
	protected $request;
	protected $settings;
	protected $environmentService;

	public function setUp() {
		parent::setUp();
		$this->view = $this->getMock(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class);
		$this->subject = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Request::class);
		$this->request = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Request::class);
		$this->settings = array('magicNumber' => 10);
		$this->environmentService = $this->getMock(\TYPO3\CMS\Extbase\Service\EnvironmentService::class);
	}

	/**
	 *
	 */
	protected function mockSubject() {
		call_user_func_array('parent::' . __FUNCTION__, func_get_args());
		$this->subject->_set('view', $this->view);
		$this->subject->_set('request', $this->request);
		$this->subject->_set('settings', $this->settings);
		$this->subject->_set('environmentService', $this->environmentService);
	}

	/**
	 * With this helper function 'request' arguments can be set with ease
	 *
	 * @param array $arguments The arguments of the request
	 */
	protected function setArguments($arguments) {
		$this->request = $this->getAccessibleMock(\TYPO3\CMS\Extbase\Mvc\Request::class, array('dummy'), array(), '', FALSE);
		$this->request->_set('arguments', $arguments);
		$this->subject->_set('request', $this->request);
	}

	/**
	 * This method tests if $view->assign was called. By making $assignments an array of arrays, $view->assign can be
	 * testet with multiple calls. Each array inside the top array holds the assignmentName, assignmentValue pair which
	 * forms the arguments for $view-assign
	 *
	 * @param array $assignments Can be a simple array($assignmentName, $assignmentValue) or an array of arrays:
	 * array(
	 *  array($assignmentName, $assignmentValue),       //1st call of $view->assign($assignmentName,$assignmentValue)
	 *  array($assignmentName, $assignmentValue),       //2nd call of $view->assign($assignmentName,$assignmentValue)
	 *  ...                                             //nth call of $view->assign($assignmentName,$assignmentValue)
	 * )
	 */
	protected function viewAssignCalledTest($assignments) {
		if (is_string($assignments[0])) {
			$assignments = array($assignments);
		}
		$methodObject = $this->subject
			->_get('view')
			->expects($this->exactly(count($assignments)))
			->method('assign');
		call_user_func_array(array($methodObject, 'withConsecutive'), $assignments);
	}

	/**
	 * This method tests if $view->assignMultiple is called with $assignments
	 *
	 * @param array $assignments The argument the assignMultiple() will be called with
	 */
	protected function viewAssignMultipleCalledTest($assignments) {
		$this->subject
			->_get('view')
			->expects($this->once())
			->method('assignMultiple')
			->with($assignments);
	}

	/**
	 * @param String $repository The name of the controller property holding the repository
	 * @param String $method The name of the method of the repository that will be called
	 * @param array $argumentsArray An array holding all arguments the method will be called with
	 */
	protected function repositoryMethodCalledTest($repository, $method, $argumentsArray) {
		$this->subject
			->_get($repository)
			->expects($this->once())
			->method($method)
			->withConsecutive($argumentsArray);
	}

	protected function repositoryMethodReturnsTest($repository, $method, $argumentsArray, $expectedReturnValue) {
		$this->subject
			->_get($repository)
			->expects($this->once())
			->method($method)
			->withConsecutive($argumentsArray)
			->will($this->returnValue($expectedReturnValue));
	}
}
