<?php
namespace X4E\X4ebase\Ajax;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 ***************************************************************/

/**
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EidDispatcher {

	/**
	 *
	 * @var string
	 */
	protected $vendor;

	/**
	 *
	 * @var string
	 */
	protected $extensionName;

	/**
	 *
	 * @var string
	 */
	protected $pluginName;

	/**
	 *
	 * @var string
	 */
	protected $controller;

	/**
	 *
	 * @var string
	 */
	protected $action;

	/**
	 *
	 * @var boolean
	 */
	protected $forceVendor = TRUE;

	/**
	 *
	 * @var boolean
	 */
	protected $forceExtensionName = TRUE;

	/**
	 *
	 * @var boolean
	 */
	protected $forcePluginName = FALSE;

	/**
	 *
	 * @var boolean
	 */
	protected $forceController = FALSE;

	/**
	 *
	 * @var boolean
	 */
	protected $forceAction = FALSE;

	/**
	 *
	 * @var string
	 */
	protected $requestFormat = 'html';

	/**
	 *
	 * @param string $vendor
	 * @param string $extensionName
	 * @param string $pluginName
	 */
	public function __construct($vendor = NULL, $extensionName = NULL, $pluginName = NULL, $controller = NULL, $action = NULL) {
		$this->vendor = $vendor;
		$this->extensionName = $extensionName;
		$this->pluginName = $pluginName;
		$this->controller = $controller;
		$this->action = $action;
	}

	public function getVendor() {
		return $this->vendor;
	}

	public function setVendor($vendor) {
		$this->vendor = $vendor;
		return $this;
	}

	public function getExtensionName() {
		return $this->extensionName;
	}

	public function setExtensionName($extensionName) {
		$this->extensionName = $extensionName;
		return $this;
	}

	public function getPluginName() {
		return $this->pluginName;
	}

	public function setPluginName($pluginName) {
		$this->pluginName = $pluginName;
		return $this;
	}

	public function getController() {
		return $this->controller;
	}

	public function setController($controller) {
		$this->controller = $controller;
		return $this;
	}

	public function getAction() {
		return $this->action;
	}

	public function setAction($action) {
		$this->action = $action;
		return $this;
	}

	public function getForceVendor() {
		return $this->forceVendor;
	}

	public function setForceVendor($forceVendor) {
		$this->forceVendor = $forceVendor;
		return $this;
	}

	public function getForceExtensionName() {
		return $this->forceExtensionName;
	}

	public function setForceExtensionName($forceExtensionName) {
		$this->forceExtensionName = $forceExtensionName;
		return $this;
	}

	public function getForcePluginName() {
		return $this->forcePluginName;
	}

	public function setForcePluginName($forcePluginName) {
		$this->forcePluginName = $forcePluginName;
		return $this;
	}

	public function getForceController() {
		return $this->forceController;
	}

	public function setForceController($forceController) {
		$this->forceController = $forceController;
		return $this;
	}

	public function getForceAction() {
		return $this->forceAction;
	}

	public function setForceAction($forceAction) {
		$this->forceAction = $forceAction;
		return $this;
	}

	public function getRequestFormat() {
		return $this->requestFormat;
	}

	public function setRequestFormat($requestFormat) {
		$this->requestFormat = $requestFormat;
		return $this;
	}

	/**
	 *
	 * @return \TYPO3\CMS\Extbase\Mvc\ResponseInterface
	 */
	public function bootstrapAndDispatch() {
		/**
		 * Gets the Ajax Call Parameters
		 */
		$ajax = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('request');

		/**
		 * Set Vendor and Extension Name
		 *
		 * Vendor like the Vendor Name in your namespace
		 * ExtensionName in upperCamelCase
		 */
		if (empty($ajax['vendor']) || $this->getForceVendor()) {
			$ajax['vendor'] = $this->getVendor();
		}
		if (empty($ajax['extensionName']) || $this->getForceExtensionName()) {
			$ajax['extensionName'] = $this->getExtensionName();
		}
		if (empty($ajax['pluginName']) || $this->getForcePluginName()) {
			$ajax['pluginName'] = $this->getPluginName();
		}
		if (empty($ajax['controller']) || $this->getForceController()) {
			$ajax['controller'] = $this->getController();
		}
		if (empty($ajax['action']) || $this->getForceAction()) {
			$ajax['action'] = $this->getAction();
		}

		/**
		 * @var $GLOBALS['TSFE'] \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
		 */
		$GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], 0, 0);
		\TYPO3\CMS\Frontend\Utility\EidUtility::initLanguage();

		// Get FE User Information
		$GLOBALS['TSFE']->initFEuser();
		// Important: no Cache for Ajax stuff
		$GLOBALS['TSFE']->set_no_cache();

		//$GLOBALS['TSFE']->checkAlternativCoreMethods();
		$GLOBALS['TSFE']->checkAlternativeIdMethods();
		$GLOBALS['TSFE']->determineId();
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->getConfigArray();
		if (version_compare(TYPO3_version, '6.2.0', '>=')) {
			\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->loadCachedTca();
		} else {
			\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->loadConfigurationAndInitialize();
		}

		$GLOBALS['TSFE']->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
		$GLOBALS['TSFE']->settingLanguage();
		$GLOBALS['TSFE']->settingLocale();

		/**
		 * Initialize Database
		 */
		//\TYPO3\CMS\Frontend\Utility\EidUtility::connectDB();

		/**
		 * @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager
		 */
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');


		/**
		 * Initialize Extbase bootstap
		 */
		$bootstrapConf = array(
			'extensionName' => $ajax['extensionName'],
			'pluginName' => $ajax['pluginName']
		);

		$bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
		$bootstrap->initialize($bootstrapConf);
		$bootstrap->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_cObj');

		/**
		 * Build the request
		 */
		$request = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Request');
		$request->setFormat($this->getRequestFormat());

		$request->setControllerVendorName($ajax['vendor']);
		$request->setcontrollerExtensionName($ajax['extensionName']);
		$request->setPluginName($ajax['pluginName']);
		$request->setControllerName($ajax['controller']);
		$request->setControllerActionName($ajax['action']);
		$request->setArguments($ajax['arguments'] ?: array());

		$response = $objectManager->get('TYPO3\CMS\Extbase\Mvc\ResponseInterface');

		$dispatcher = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Dispatcher');

		$dispatcher->dispatch($request, $response);

//		echo $response->getContent();
		return $response;
	}

}
