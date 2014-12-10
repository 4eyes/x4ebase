<?php
namespace X4E\X4ebase\Session;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *           Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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
class NullSessionStorage implements \X4E\X4ebase\Session\SessionStorageInterface {

	public function get($key, $type = '') {
		
	}

	public function getObject($key, $type = '') {
		
	}

	public function getUser() {
		
	}

	public function has($key, $type = '') {
		
	}

	public function isSerializable($data) {
		
	}

	public function remove($key, $type = '') {
		
	}

	public function set($key, $data, $type = '') {
		
	}

	public function storeObject($object, $key = NULL, $type = '') {
		
	}

}