<?php
namespace X4e\X4ebase\ViewHelpers;

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

class RelativeDateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Helps render a date relative to another
     *
     * @param mixed $date Either a DateTime object or a string that is accepted by the DateTime constructor
     * @param string $as The name of the info array
     * @param mixed $referenceDate Either a DateTime object or a string that is accepted by the DateTime constructor
     * @return string
     * @api
     */
    public function render($date, $as, $referenceDate = null)
    {
        $infoArray = \X4e\X4ebase\Utility\DateTimeUtility::relativeDate($date, $referenceDate);
        $infoArray['type'] = $infoArray[0];
        $infoArray['absoluteType'] = abs($infoArray[0]);
        $infoArray['value'] = $infoArray[1];
        $infoArray['difference'] = $infoArray[2];
        $this->templateVariableContainer->add($as, $infoArray);
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove($as);
        return $output;
    }
}
