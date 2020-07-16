<?php
namespace X4e\X4ebase\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class GroupByFirstLetterViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize all arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {

        $this->registerArgument(
            'element',
            'mixed',
            'Either a ObjectStorage object or an array',
            true);
        $this->registerArgument(
            'property',
            'string',
            'The $element\'s property to group by',
            true);
        $this->registerArgument(
            'sorting',
            'bool',
            'The $element\'s option to sort records',
            false,
            false);
    }

    /**
     * Groups an ObjectStorage or an Array by the first Letter of a given property
     *
     * @return array
     *
     * @throws \Exception if given params are not supported
     * @api
     */
    public function render()
    {
        $groupedArray = [];

        foreach ($this->arguments['element'] as $item) {
            if (is_object($item)) {
                $getter = 'get' . ucfirst($this->arguments['property']);
                if ($item instanceof LazyLoadingProxy) {
                    /** LazyLoadingProxy $item */
                    $item = $item->_loadRealInstance();
                }
                if (method_exists($item, $getter)) {
                    $string = $item->$getter();
                } else {
                    throw new \Exception('The given property does not exist.');
                }
            } elseif (is_array($this->arguments['property'])) {
                if (isset($item[$this->arguments['property']])) {
                    $string = $item[$this->arguments['property']];
                } else {
                    throw new \Exception('The given property does not exist.');
                }
            } else {
                throw new \Exception('Unsupported element type.');
            }

            $letter = strtoupper(substr($string, 0, 1));
            $groupedArray[$letter][] = $item;
        }

        if ($this->arguments['sorting']) {
            ksort($groupedArray);
        }

        return $groupedArray;
    }
}
