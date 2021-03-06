<?php
namespace X4e\X4ebase\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
 *           Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
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
 *
 */
class GeneralUtility {
	
	protected static $uniqueId = 5378456;
	
	public static function generateUniqueId(){
		return ++static::$uniqueId;
	}
	
	public static function generateUniqueString(){
		if (extension_loaded('gmp') && function_exists('gmp_init') && function_exists('gmp_strval')) {
			return gmp_strval(gmp_init(static::generateUniqueId(), 10), 62);
		} else {
			return base_convert(static::generateUniqueId(), 10, 36);
		}
	}
	
	/**
	 *
	 * @param \object $object
	 * @param string $property
	 * @return string
	 */
	public static function generateUidListForProperty($object, $property){
		return implode(',',self::generateUidArrayForProperty($object, $property));
	}
	/**
	 *
	 * @param \object $object
	 * @param string $property
	 * @return string
	 */
	public static function generateUidArrayForProperty($object, $property){
		$uidArr = array();
		if($object){
			$method = 'get' . ucfirst($property);
			if(method_exists($object, $method)){
				$objects = call_user_func(array($object, $method));
				if(is_object($objects) && $objects->count()){
					foreach($objects as $obj){
						$uidArr [] = $obj->getUid();
					}
				} else if(is_array($objects) && count($objects)){
					foreach($objects as $obj){
						$uidArr [] = $obj['uid'];
					}
				}
			} else {
				throw new \RuntimeException('Method ' . $method . ' does not exist in given object', 1379414199);
			}
		}
		return $uidArr;
	}

	/**
	 * Returns the extConf of the extension matching the given extKey
	 *
	 * @param string $extKey
	 * @return array
	 */
	public static function getExtConf($extKey){
		return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
	}
}