<?php
namespace X4e\X4ebase\XClasses\Localization\Parser;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alessandro Bellafronte <alessandro@4eyes.ch>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * XClass for parser for XLIFF file.
 *
 * @author Alessandro Bellafronte <alessandro@4eyes.ch>
 */
class XliffParser extends \TYPO3\CMS\Core\Localization\Parser\XliffParser
{

    /**
     * Returns parsed representation of XML file.
     *
     * This method is implemented in abstract class \TYPO3\CMS\Core\Localization\Parser\AbstractXmlParser
     *
     * @param string $sourcePath Source file path
     * @param string $languageKey Language key
     * @param string $charset File charset
     * @return array
     * @throws \TYPO3\CMS\Core\Localization\Exception\FileNotFoundException
     */
    public function getParsedData($sourcePath, $languageKey, $charset = '')
    {
        $this->sourcePath = $sourcePath;
        $this->languageKey = $languageKey;
        $this->charset = $this->getCharset($languageKey, $charset);
        if ($this->languageKey !== 'default') {
            $this->sourcePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(\TYPO3\CMS\Core\Utility\GeneralUtility::llXmlAutoFileName($this->sourcePath, $this->languageKey));
            if (!@is_file($this->sourcePath)) {
                // Global localization is not available, try split localization file
                $this->sourcePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(\TYPO3\CMS\Core\Utility\GeneralUtility::llXmlAutoFileName($sourcePath, $languageKey, true));
            }
            /**
             * Changed to provide support of locallangXmlOverride settings in LocalConfiguration
             * @author Alessandro Bellafronte <alessandro@4eyes.ch>
             * BEGIN
             */
            if (!@is_file($this->sourcePath)) {
                $this->sourcePath = $sourcePath;
            }
            /**
             * END
             */
            if (!@is_file($this->sourcePath)) {
                throw new \TYPO3\CMS\Core\Localization\Exception\FileNotFoundException('Localization file does not exist', 1306332397);
            }
        }
        $LOCAL_LANG = [];
        $LOCAL_LANG[$languageKey] = $this->parseXmlFile();
        return $LOCAL_LANG;
    }
}
