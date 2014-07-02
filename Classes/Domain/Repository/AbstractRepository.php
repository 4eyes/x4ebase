<?php
namespace X4E\X4ebase\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *  (c) 2013 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @var \TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider
	 */
	protected $translateTools;
	
	/**
	 * @var array 
	 */
	protected $cachedLanguageIconTitles = array();
	
	/**
	 * Returns the translated record of a given record
	 *
	 * @param \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $record
	 * @param integer $sysLanguageUid
	 * @param boolean $forceLanguageUid
	 * @return mixed
	 */
	public function getTranslation($record, $sysLanguageUid){
		$languageIconTitles = $this->getSystemLanguages($record->getPid());
		
		if (isset($languageIconTitles[$sysLanguageUid])) {
			$query = $this->createQuery();
			$query->getQuerySettings()->setRespectSysLanguage(FALSE);
			$query->getQuerySettings()->setRespectSysLanguageAlternative(TRUE);
			$query->getQuerySettings()->setSysLanguageUid($sysLanguageUid);
			$result = $query->matching(
					$query->equals('uid', $record->getUid())
				)->execute()->getFirst();
			
			return $result;
			
			/* @var $dataMapFactory \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory */
			$dataMapFactory = $this->objectManager->create('TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory');
			/* @var $dataMap \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap */
			$dataMap = $dataMapFactory->buildDataMap(get_class($record));
			$translationOriginColumnName = $dataMap->getTranslationOriginColumnName();
			if (!empty($translationOriginColumnName)){
				$query = $this->createQuery();
				$query->getQuerySettings()->setSysLanguageUid($sysLanguageUid);
				return $query->matching(
						$query->equals($translationOriginColumnName, $record->getUid())
					)->execute();
			}
		}
		return FALSE;
	}
	
	/**
	 * Gets an instance of TranslationConfigurationProvider
	 *
	 * @return \TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider
	 */
	protected function getTranslateTools() {
		if (!isset($this->translateTools)) {
			$this->translateTools = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Configuration\\TranslationConfigurationProvider');
		}
		return $this->translateTools;
	}
	
	/**
	 * Gets an array with available languages for a given page
	 * 
	 * @param int $pageId
	 * @return array
	 */
	protected function getSystemLanguages($pageId = 0) {
		if (!isset($this->cachedLanguageIconTitles[$pageId])) {
			$this->cachedLanguageIconTitles[$pageId] = $this->getTranslateTools()->getSystemLanguages($pageId);
		}
		return $this->cachedLanguageIconTitles[$pageId];
	}
}