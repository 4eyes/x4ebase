<?php
namespace X4e\X4ebase\XClasses\Persistence\Generic\Mapper;

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
class DataMapper extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper
{

    /**
     * Maps a single row on an object of the given class
     *
     * @param string $className The name of the target class
     * @param array $row A single array with field_name => value pairs
     * @return object An object of the given class
     */
    protected function mapSingleRow($className, array $row)
    {
        // 4eyes start -->
        $identifier = (!empty($row['_PAGES_OVERLAY']) ? $row['uid'] . '_' . $row['_PAGES_OVERLAY_UID'] : $row['uid']);
        if ($this->identityMap->hasIdentifier($identifier, $className)) {
            // 4eyes end <--
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

    /**
     * Sets the given properties on the object.
     *
     * @param \TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object The object to set properties on
     * @param array $row
     * @return void
     */
    protected function thawProperties(\TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object, array $row)
    {
        $className = get_class($object);
        $dataMap = $this->getDataMap($className);
        $object->_setProperty('uid', intval($row['uid']));
        $object->_setProperty('pid', intval($row['pid']));
        $object->_setProperty('_localizedUid', intval($row['uid']));
        if ($dataMap->getLanguageIdColumnName() !== null) {
            $object->_setProperty('_languageUid', intval($row[$dataMap->getLanguageIdColumnName()]));
            if (isset($row['_LOCALIZED_UID'])) {
                $object->_setProperty('_localizedUid', intval($row['_LOCALIZED_UID']));
            }
        /* NEW @ 4eyes -- start */
        } elseif (!empty($row['_PAGES_OVERLAY']) && isset($row['_PAGES_OVERLAY_LANGUAGE'])) {
            $object->_setProperty('_languageUid', intval($row['_PAGES_OVERLAY_LANGUAGE']));
            if (isset($row['_PAGES_OVERLAY_UID'])) {
                //$object->_setProperty('_localizedUid', intval($row['_PAGES_OVERLAY_UID']));
            }
        }
        /* NEW @ 4eyes -- end */
        $properties = $object->_getProperties();
        foreach ($properties as $propertyName => $propertyValue) {
            if (!$dataMap->isPersistableProperty($propertyName)) {
                continue;
            }
            $columnMap = $dataMap->getColumnMap($propertyName);
            $columnName = $columnMap->getColumnName();
            $propertyData = $this->reflectionService->getClassSchema($className)->getProperty($propertyName);
            $propertyValue = null;
            if ($row[$columnName] !== null) {
                switch ($propertyData['type']) {
                    case 'integer':
                        $propertyValue = (integer) $row[$columnName];
                        break;
                    case 'float':
                        $propertyValue = (double) $row[$columnName];
                        break;
                    case 'boolean':
                        $propertyValue = (boolean) $row[$columnName];
                        break;
                    case 'string':
                        $propertyValue = (string) $row[$columnName];
                        break;
                    case 'array':
                        // $propertyValue = $this->mapArray($row[$columnName]); // Not supported, yet!
                        break;
                    case 'SplObjectStorage':
                    case 'Tx_Extbase_Persistence_ObjectStorage':
                    case 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage':
                        $propertyValue = $this->mapResultToPropertyValue($object, $propertyName, $this->fetchRelated($object, $propertyName, $row[$columnName]));
                        break;
                    default:
                        if ($propertyData['type'] === 'DateTime' || in_array('DateTime', class_parents($propertyData['type']))) {
                            $propertyValue = $this->mapDateTime($row[$columnName], $columnMap->getDateTimeStorageFormat());
                        } else {
                            $propertyValue = $this->mapResultToPropertyValue($object, $propertyName, $this->fetchRelated($object, $propertyName, $row[$columnName]));
                        }
                        break;
                }
            }
            if ($propertyValue !== null) {
                $object->_setProperty($propertyName, $propertyValue);
            }
        }
    }
}
