<?php

namespace X4e\X4ebase\ViewHelpers\Format;

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
class ExplodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    public function initializeArguments()
    {

        $this->registerArgument(
            'value',
            'string',
            'String to explode',
            true,
            0);
        $this->registerArgument(
            'delimiter',
            'string',
            'Char or string to split the string into pieces',
            false,
            0);
        $this->registerArgument(
            'removeEmptyValues',
            'bool',
            'If true empty items will be removed',
            false,
            false);
        $this->registerArgument(
            'limit',
            'int',
            'The limit',
            false,
            0);

    }

    /**
     * Runs the given string through trimExplode of GeneralUtility Class
     *
     * @return array The explorer string
     * @api
     */
    public function render()
    {
        $delimiter = $this->getDelimiter($this->arguments['delimiter']);
        $value = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(
            $delimiter,
            $this->arguments['value'],
            $this->arguments['removeEmptyValues'],
            $this->arguments['limit']
        );
        return $value;
    }

    /**
     * @param $glue
     *
     * @return mixed
     */
    protected function getDelimiter($glue)
    {
        list($type, $value) = explode(':', $glue);
        switch ($type) {
            case 'constant':
                $delimiter = constant($value);
                break;
            default:
                $delimiter = $type;
                break;
        }

        return $delimiter;
    }
}
