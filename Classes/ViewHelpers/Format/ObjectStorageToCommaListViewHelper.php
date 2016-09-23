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
 * Takes a collection and creates a comma list of a property of all
 * items in
 * @see http://www.php.net/manual/en/function.number-format.php
 *
 * @api
 */
class ObjectStorageToCommaListViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage
     * @param string $property
     * @return string
     */
    public function render($objectStorage, $property)
    {
        $output = [];

        foreach ($objectStorage as $res) {
            $output []= trim($res->_getProperty($property));
        }

        return implode(',', $output);
    }
}
