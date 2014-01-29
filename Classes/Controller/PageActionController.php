<?php
namespace X4E\X4ebase\Controller;

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
 *
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PageActionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * @var \TYPO3\CMS\Extbase\Service\EnvironmentService
	 * @inject
	 */
	protected $environmentService;
	
	/**
	 * pageRepository
	 *
	 * @var \X4E\X4ebase\Domain\Repository\PageRepository
	 */
	protected $pageRepository;

	/**
	 * Page
	 * 
	 * @var \X4E\X4ebase\Domain\Model\Page
	 */
	protected $page = NULL;
	
	
	/**
	 * injectPageRepository
	 *
	 * @param \X4E\X4ebase\Domain\Repository\PageRepository $pageRepository
	 * @return void
	 */
	public function injectPageRepository(\X4E\X4ebase\Domain\Repository\PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}
	
	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	public function initializeAction() {
		parent::initializeAction();
		if ($this->environmentService->isEnvironmentInFrontendMode()) {
			$pageId = $GLOBALS['TSFE']->id;
		} elseif ($this->environmentService->isEnvironmentInBackendMode()) {
			$pageId = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');
		}
		if (isset($pageId)) {
			$this->page = $this->pageRepository->findByUid($pageId);
		}
	}
	
}