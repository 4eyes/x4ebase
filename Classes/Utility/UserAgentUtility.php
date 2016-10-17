<?php
namespace X4e\X4ebase\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class UserAgentUtility
{
    /**
     * @var StdClass
     */
    public $ua;

    public function __construct()
    {
        $ua = null;
        require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('x4ebase') . 'Classes/Libraries/Detector/Detector.php');
        $this->ua = $ua;
    }

    public function __get($name)
    {
        if (property_exists($this->ua, $name)) {
            return $ua->{$name};
        }
        return null;
    }

    public function __toString()
    {
        return print_r($ua, true);
    }
}
