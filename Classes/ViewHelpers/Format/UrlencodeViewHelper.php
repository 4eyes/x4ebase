<?php
namespace X4E\X4ebase\ViewHelpers\Format;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Encodes the given string according to http://www.faqs.org/rfcs/rfc3986.html 
 * (applying PHPs rawurlencode() function)
 * @see http://www.php.net/manual/function.rawurlencode.php
 * 
 * @author Christoph Dörfel <christoph@4eyes.ch>
 */
class UrlencodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
	 * can decode the text's entities.
	 *
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * Escapes special characters using PHPs urlencode() function.
	 *
	 * @param string $insertSpaces Whether to replace %20 with an actual space
	 * @param string $value string to format
	 * @return mixed
	 * @see http://www.php.net/manual/function.rawurlencode.php
	 */
	public function render($insertSpaces = TRUE, $value = NULL) {
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		if (!is_string($value)) {
			return $value;
		}
		$encodedString = rawurlencode($value);
		return str_replace('%20', ' ', $encodedString);
	}
}
