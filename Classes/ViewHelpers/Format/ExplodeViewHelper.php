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

    /**
     * Runs the given string through trimExplode of GeneralUtility Class
     *
     * @param string $value
     * @param string $delimiter
     * @param bool $removeEmptyValues
     * @param int $limit
     *
     * @return array The explorer string
     * @api
     */
    public function render($value, $delimiter = ',', $removeEmptyValues = false, $limit = 0)
    {
        $delimiter = $this->getDelimiter($delimiter);
        $value = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode($delimiter, $value, $removeEmptyValues, $limit);
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
