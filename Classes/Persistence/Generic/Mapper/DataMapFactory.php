<?php
namespace X4E\X4ebase\Persistence\Generic\Mapper;

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
 * A factory for a data map to map a single table configured in $TCA on a domain object.
 */
class DataMapFactory extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory {
	
	/**
	 * @var \TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider 
	 */
	protected $translationConfigurationProvider;
	
	/**
	 * Injects the TranslationConfigurationProvider 
	 *
	 * @todo DOENS'T WORK! TranslationConfigurationProvider needs to implement Singleton Interface
	 * @param \TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider $translationConfigurationProvider
	 * @return void
	 */
	public function injectTranslationConfigurationProvider(\TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider $translationConfigurationProvider) {
		$this->translationConfigurationProvider = $translationConfigurationProvider;
	}
	
	/**
	 * Lifecycle method
	 *
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		if (!isset($this->translationConfigurationProvider)) {
			$this->translationConfigurationProvider = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider');
		}
	}
	
	/**
	 * @param DataMap $dataMap
	 * @param string $tableName
	 * @return DataMap
	 */
	protected function addMetaDataColumnNames(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap $dataMap, $tableName) {
		$dataMap = parent::addMetaDataColumnNames($dataMap, $tableName);
		
		if (!$this->translationConfigurationProvider->isTranslationInOwnTable($tableName)) {
			$foreignTranslationTableName = $this->translationConfigurationProvider->foreignTranslationTable($tableName);
			$controlSection = $this->getControlSection($foreignTranslationTableName);
			if (isset($controlSection['languageField'])) {
				$dataMap->setLanguageIdColumnName($controlSection['languageField']);
			}
			if (isset($controlSection['transOrigPointerField'])) {
				$dataMap->setTranslationOriginColumnName($controlSection['transOrigPointerField']);
			}
		}
		
		return $dataMap;
	}

}