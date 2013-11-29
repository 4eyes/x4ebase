<?php
namespace X4E\X4ebase\ViewHelpers\Widget;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
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
 * @package x4ebase
 */
class FacebookFeedViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper {
	
	/**
	 * If set to TRUE, it is an AJAX widget.
	 *
	 * @var boolean
	 */
	protected $ajaxWidget = TRUE;
	
	/**
	 * @var \X4E\X4ebase\ViewHelpers\Widget\Controller\FacebookFeedController
	 */
	protected $controller;

	/**
	 * @param \X4E\X4ebase\ViewHelpers\Widget\Controller\FacebookFeedController $controller
	 * @return void
	 */
	public function injectController(\X4E\X4ebase\ViewHelpers\Widget\Controller\FacebookFeedController $controller) {
		$this->controller = $controller;
	}

	/**
	 * @param string $as The name of the objects variable
	 * @param string $requestUrl
	 * @param array $requestParams
	 * @param array $configuration
	 * @return string
	 */
	public function render($as, $requestUrl, array $requestParams = array(), array $configuration = array('maxItems' => 10)) {
		return $this->initiateSubRequest();
	}
}