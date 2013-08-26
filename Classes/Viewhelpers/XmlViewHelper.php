<?php
namespace X4E\X4ebase\ViewHelpers;
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Christoph Dörfel <christoph@4eyes.ch>
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
***************************************************************/

/**
 * Xml ViewHelper
 *
 * Xml format a string
 *
 * @author Christoph Dörfel <christoph@4eyes.ch>
 * @package Scorm
 * @subpackage ViewHelpers
 */
class XmlViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * Render method
	 *
	 * @param mixed $content String or variable convertible to string which should be formatted
	 * @return mixed
	 */
	public function render($content=NULL) {
		if (!$content) {
			return $this->_formatXmlString($this->renderChildren());
		}
		return $this->_formatXmlString($content);
	}

	protected function _formatXmlString($xml) {
		$sxe = new \SimpleXMLElement(trim($xml), LIBXML_NONET);
		$dom = new \DOMDocument('1.0');
		$dom->preserveWhiteSpace = FALSE;
		$dom->formatOutput = TRUE;
		$dom->loadXML($sxe->asXML());
		return $dom->saveXML();
	}
}

?>