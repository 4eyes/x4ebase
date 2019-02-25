<?php
namespace X4e\X4ebase\ViewHelpers\Format;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
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
 * A view helper for replacing values with preg_replace. Either supply an
 * array for the arguments or a single value.
 * @see http://www.php.net/manual/en/function.preg-replace.php
 */
class RegexReplaceViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments()
    {

        $this->registerArgument(
            'pattern',
            'mixed',
            'The pattern to search for. It can be either a string or an array with strings.',
            true,
            0);
        $this->registerArgument(
            'replacement',
            'mixed',
            'The string or an array with strings to replace.',
            true,
            0);
        $this->registerArgument(
            'limit',
            'mixed',
            'The maximum possible replacements for each pattern in each subject string. Defaults to -1 (no limit).',
            false,
            -1);
        $this->registerArgument(
            'subject',
            'mixed',
            'The string to format',
            false,
            null);

    }

    /**
     * Searches for matches to pattern and replaces them with replacement.
     *
     * @return string The processed value
     * @see http://www.php.net/manual/en/function.preg-replace.php
     */
    public function render()
    {
        if ($this->arguments['subject'] === null) {
            $this->arguments['subject']  = $this->renderChildren();
        }

        $out = preg_replace(
            $this->arguments['pattern'],
            $this->arguments['replacement'],
            $this->arguments['subject'],
            $this->arguments['limit']
        );
        return $out;
    }
}
