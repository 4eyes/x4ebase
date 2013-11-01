<?php
namespace X4E\X4ebase\Validation\Validator;

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
class NotTrimEmptyValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to Result.
	 *
	 * @param mixed $value The value that should be validated
	 * @return void
	 */
	public function isValid($value) {
		if (is_string($value)) {
			$valid = FALSE;
			
			$charlist = $this->options['charlist'] ?: " \t\n\r\0\x0B";
			$mode = $this->options['mode'] ?: 'both';
			switch ($mode) {
				case 'left':
				case 'ltrim':
					$valid = !($value === NULL || ltrim($value, $charlist) === '');
					break;
				case 'right':
				case 'rtrim':
					$valid = !($value === NULL || rtrim($value, $charlist) === '');
					break;
				default:
					$valid = !($value === NULL || trim($value, $charlist) === '');
					break;
			}
			
			if (!$valid) {
					// Why "437350901"? 4eyes + 0 + (Custom Error Range 900) + Error 2
					// @todo Make a list of error codes and validators
				$this->addError('The given subject was empty after trim.', 437350902);
			}
		}
	}

}

?>