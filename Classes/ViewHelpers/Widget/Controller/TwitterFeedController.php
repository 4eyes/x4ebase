<?php
namespace X4E\X4ebase\ViewHelpers\Widget\Controller;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
class TwitterFeedController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController {

	protected static $consumerKey = 'wYjr3Xg9UPqZ4vHzFRc4bA';
	protected static $consumerSecret = 'mUavd8cQumLtX2yBccA4tQfJN8H6Ygrmx4ISH1UJ4';
	protected static $accessToken = '74967814-kWpCWmc65qreZr2aVLCFvaPIVYhKqPHDSf8CDeB7M';
	protected static $accessTokenSecret = 'QKmRYdRZJrbscTvEkuhsgf5pUdk5UzDTOQe7HQ22lG24T';
	
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
		$connection = new \tmhOAuth(array(
				'consumer_key'    => static::$consumerKey,
				'consumer_secret' => static::$consumerSecret,
				'token'           => static::$accessToken,
				'secret'          => static::$accessTokenSecret
			));
		
		$responseCode = $connection->request(
				'GET',
				$connection->url('1.1/' . $this->requestUrl),
				$this->requestParams
			);
		
		
		$tweets = array();
		if ($responseCode == 200) {
			$tweets = json_decode($connection->response['response'], TRUE);
			
			//\TYPO3\CMS\Core\Utility\DebugUtility::debug($tweets, 'twitter response');
			//TODO cache tweets!!!
		} else {
			//\TYPO3\CMS\Core\Utility\DebugUtility::debug($responseCode, 'twitter response');
		}
		
		// Reduce set to X elements
		array_splice($tweets, intval($this->configuration['maxItems']));
		
		$this->view->assign('contentArguments', array(
			$this->widgetConfiguration['as'] => $tweets
		));
		$this->view->assign('configuration', $this->configuration);
		return;
		
		
		
		/* @var $storage \OAuth\Common\Storage\Memory */
		$storage = $this->objectManager->create('OAuth\Common\Storage\Memory');

		/* @var $credentials \OAuth\Common\Consumer\Credentials */
		$credentials = $this->objectManager->create(
				'OAuth\Common\Consumer\Credentials',
				static::$consumerKey,
				static::$consumerSecret,
				'' // url not needed (?)
			);
		
		/* @var $serviceFactory \OAuth\ServiceFactory */
		$serviceFactory = $this->objectManager->create('OAuth\ServiceFactory');
		
		/* @var $twitterService \OAuth\OAuth1\Service\Twitter */
		$twitterService = $serviceFactory->createService('Twitter', $credentials, $storage);
		
		/* @var $token \OAuth\OAuth1\Token\Twitter\StdOAuth1Token */
		$token = $twitterService->getEmptyAccessToken();
		$token->setAccessToken(static::$accessToken);
		$token->setRequestTokenSecret(static::$accessTokenSecret);
		
		$twitterService->getStorage()->storeAccessToken('Twitter', $token);
		
		// Request Twitter timeline.
		$params = array(
				'screen_name'     => 'FlySWISS',
				'include_rts'     => 'false',
				'exclude_replies' => 'false'
			);
		
		// Send a request now that we have access token
		$result = json_decode(
				$twitterService->request(
						'statuses/user_timeline.json',
						'GET',
						array(),
						$params
					)
			);

		return 'result: <pre>' . print_r($result, true) . '</pre>';
	}
	
	protected function initializeTestAction(){
		
	}
	
	public function testAction(){
		//$this->view->setTemplatePathAndFilename();
		
		
		/* @var $view \TYPO3\CMS\Fluid\View\StandaloneView */
		$view = $this->objectManager->create('TYPO3\CMS\Fluid\View\StandaloneView');
		$resourcePath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('x4eairmail', 'Resources/Private/Backend/');
		$view->setLayoutRootPath($resourcePath . 'Layouts/');
		$view->setTemplatePathAndFilename($resourcePath . 'Templates/Issue/SingleFalRecord.html');
		$view->assign('file', NULL);
		$view->assign('fileStorageTableName', 'derp');
		
		$output = trim($view->render());
		
		header('Content-Type: application/json');
		
		return json_encode(
				array(
					'view' => $output,
					'fileStorageTableName' => $fileStorageTableName,
					'fileId' => $fileId,
					'objectId' => $jsonArray[0],
					'namePrefix' => $jsonArray[1],
					'pageUid' => $jsonArray[2],
					'recordTableName' => $jsonArray[3],
					'recordUid' => $jsonArray[4],
					'recordSysLanguageUid' => $jsonArray[5],
					'recordFieldName' => $jsonArray[6],
					'storageTableName' => $jsonArray[7],
				)
			);
	}

}