<?php
namespace X4E\X4ebase\Persistence\Generic\Mapper;

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
 * A mapper to map database tables configured in $TCA on domain objects.
 */
class DataMapper extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper {
	
	/**
	 * Maps a single row on an object of the given class
	 *
	 * @param string $className The name of the target class
	 * @param array $row A single array with field_name => value pairs
	 * @return object An object of the given class
	 */
	protected function mapSingleRow($className, array $row) {
		$identifier = (!empty($row['_PAGES_OVERLAY']) ? $row['uid'] . '_' . $row['_PAGES_OVERLAY_UID'] : $row['uid'] );
		if ($this->identityMap->hasIdentifier($identifier, $className)) {
			$object = $this->identityMap->getObjectByIdentifier($identifier, $className);
		} else {
			$object = $this->createEmptyObject($className);
			$this->identityMap->registerObject($object, $identifier);
			$this->thawProperties($object, $row);
			$object->_memorizeCleanState();
			$this->persistenceSession->registerReconstitutedEntity($object);
		}
		return $object;
	}
	
}

?>