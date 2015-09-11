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

	protected $removeEmptyNodes = FALSE;
	protected $ignoreWhitespace = TRUE;
	protected $preserveAttributes = TRUE;

	/**
	 * Render method
	 *
	 * @param mixed $content String or variable convertible to string which should be formatted
	 * @param boolean $removeEmptyNodes Set to TRUE if empty xml nodes should be completely removed from the output
	 * @param boolean $ignoreWhitespace Set to FALSE if nodes with only whitespace should not be considered empty
	 * @param boolean $preserveAttributes Set to FALSE if empty xml nodes with attributes should also be removed
	 * @return mixed
	 */
	public function render($content = NULL, $removeEmptyNodes = FALSE, $ignoreWhitespace = TRUE, $preserveAttributes = TRUE) {
		$this->removeEmptyNodes = $removeEmptyNodes;
		$this->ignoreWhitespace = $ignoreWhitespace;
		$this->preserveAttributes = $preserveAttributes;
		if (!$content) {
			$content = $this->renderChildren();
		}
		return $this->formatXmlString($content);
	}

	/**
	 *
	 * @param string $xml
	 * @param boolean $removeEmptyNodes
	 * @param boolean $ignoreWhitespace
	 * @param boolean $preserveAttributes
	 * @return string
	 */
	protected function formatXmlString($xml) {
		$sxe = $this->createNewObject(\SimpleXMLElement::class, trim($xml), LIBXML_NONET);
		if ($this->removeEmptyNodes) {
			$this->removeEmptyNodes($sxe);
		}
		$dom = $this->createNewObject(\DOMDocument::class, '1.0');
		$dom->preserveWhiteSpace = FALSE;
		$dom->formatOutput = TRUE;
		$dom->loadXML($sxe->asXML());
		return $dom->saveXML();
	}

	/**
	 *
	 * @param \SimpleXMLElement $sxe
	 */
	protected function removeEmptyNodes(\SimpleXMLElement $sxe){
		$expression = '//*[' . ($this->ignoreWhitespace ? 'not(*) and not(normalize-space())' : 'not(text())') . ($this->preserveAttributes ? ' and not(@*)' : '') . ']';
		while (!!($nodes = $sxe->xpath($expression))) {
			/* @var $node \SimpleXMLElement */
			foreach($nodes as $node) {
				unset($node[0]);
			}
		}
	}

	protected function createNewObject($className) {
		$arguments = func_get_args();
		$r = new \ReflectionClass(array_shift($arguments));
		return $r->newInstanceArgs($arguments);
	}
}