<?php
namespace X4E\X4ebase\ViewHelpers\Format;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Formats a number with custom precision, decimal point and grouped thousands.
 * @see http://www.php.net/manual/en/function.number-format.php
 *
 * @api
 */
class ExplodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Runs the given string through trimExplode of GeneralUtility Class
	 *
	 * @param string $value
	 * @param string $delimiter
	 * @return string The escaped string
	 * @api
	 */
	public function render($value, $delimiter=",") {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode($delimiter, $value);
	}
}