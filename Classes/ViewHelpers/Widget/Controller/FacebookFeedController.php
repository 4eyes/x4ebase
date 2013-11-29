<?php
namespace X4E\X4ebase\ViewHelpers\Widget\Controller;

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
class FacebookFeedController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController {

	protected static $appId = '1427959754082308';
	protected static $appSecret = '7401eaf9d735262a4c093c84b7657ba9';
	
	/**
	 * @var array
	 */
	protected $configuration = array('maxItems' => 10);

	/**
	 * @var \string 
	 */
	protected $requestUrl = '';
	
	/**
	 * @var \array
	 */
	protected $requestParams = array();
	

	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->requestUrl = $this->widgetConfiguration['requestUrl'];
		$this->requestParams = $this->widgetConfiguration['requestParams'];
		$this->configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge_recursive_overrule($this->configuration, $this->widgetConfiguration['configuration'], TRUE);
	}

	/**
	 * @param integer $currentPage
	 * @return void
	 */
	public function indexAction($currentPage = 1) {
		$uniqueId = \X4E\X4ebase\Utility\GeneralUtility::generateUniqueString();
		$this->view->assign('uniqueId', $uniqueId);
		$this->view->assign('configuration', $this->configuration);
		$this->view->assign('contentArguments', array());
	}
	
	/**
	 * 
	 * @return \string
	 */
	public function ajaxAction(){
		$posts = $this->getFeedArray();
		$this->view->assign('posts', $posts);
		$output = trim($this->view->render());
		return $output;
	}
	
	/**
	 * Fetches tweets through an OpenAuth request
	 * 
	 * @return \array
	 */
	protected function getFeedArray(){
		$facebook = new \Facebook(array(
				'appId' => static::$appId,
				'secret' => static::$appSecret,
				'fileUpload' => false
			));
		
		$parameters = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('', $this->requestParams);
		$feed = $facebook->api('/' . $this->requestUrl . '?' . substr($parameters, 1));
		$feeds = $feed['data'] ?: array();
		
		foreach ($feeds as $k => $feed) {
			if ($feed['type'] === 'status') {
				unset($feeds[$k]);
			}
		}
		$feeds = array_values($feeds);
		array_splice($feeds, intval($this->configuration['maxItems']));
		
		return $feeds;
	}

}