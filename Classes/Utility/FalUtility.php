<?php
namespace X4e\X4ebase\Utility;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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
 * A static class with utility functions handling fal tasks
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FalUtility
{

    /**
     * Handles a File upload from an extbase/fluid form
     *
     * @param string $fileKey The file key. The name of the upload field
     * @param string $fieldName The field name in the model.
     * @param string $pluginName The plugin name.
     * @param int $foreignUid The uid to create a reference to the foreign table
     * @param int $foreignPid The pid for the reference to foreign table
     * @param string $foreignTable The db table name of the foreign table.
     * @param string $folderName The name of the folder where the file should be saved.
     * @param string $conflictMode cancel: use existing file; replace: replace existing file; changeName: get a unique name for current file
     * @return bool
     */
    public static function handleFileUpload($fileKey, $fieldName, $pluginName, $foreignUid, $foreignPid, $foreignTable, $folderName = null, $conflictMode = 'cancel')
    {
        $status = false;

        if (array_key_exists($fileKey, $_FILES[$pluginName]['name'])) {
            if ($_FILES[$pluginName]['error'][$fileKey] == 0) {
                // get storage and folder for uploaded file
                $storage = self::getStorage();
                $folder = self::getFolderObject($storage, $folderName);

                //this conversion is necessary as addUploadedFile function incorrectly accesses file info array
                $fileInfo = [
                    'tmp_name' => $_FILES[$pluginName]['tmp_name'][$fileKey],
                    'name' => $_FILES[$pluginName]['name'][$fileKey]
                ];

                // move the uploaded file
                $fileObject = self::addUploadedFile($storage, $fileInfo, $folder, $conflictMode);

                if ($fileObject) {
                    // File is saved, now add the reference to the domain object
                    $status = self::addFileReference(
                        $fileObject->getUid(),
                        $foreignUid,
                        $foreignTable,
                        $fieldName,
                        $foreignPid
                    );
                }
            }
        }
        return $status;
    }

    /**
     * Retrieves the storage from storagerepository
     * If called without uid, the default storage will be selected
     *
     * @param int $uid
     * @return \TYPO3\CMS\Core\Resource\ResourceStorage
     */
    public static function getStorage($uid = 1)
    {
        $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
        return $storageRepository->findByUid($uid);
    }

    /**
     * get folder object from storage with given foldername
     * creates the folders if they don't exist yet
     *
     * @param \TYPO3\CMS\Core\Resource\ResourceStorage $storage
     * @param string $folderName
     * @return \TYPO3\CMS\Core\Resource\Folder
     */
    public static function getFolderObject($storage, $folderName = null)
    {
        // get folder
        $folder = $storage->getDefaultFolder();
        if ($folderName !== null) {
            $folderParts = explode('/', $folderName);
            foreach ($folderParts as $folderPart) {
                if (!$folder->hasFolder($folderPart)) {
                    $folder = $folder->createFolder($folderPart);
                } else {
                    $folder = $folder->getSubfolder($folderPart);
                }
            }
        }

        return $folder;
    }

    /**
     * adds the uploaded file to given folder
     *
     * @param \TYPO3\CMS\Core\Resource\ResourceStorage $storage
     * @param array $fileInfo
     * @param \TYPO3\CMS\Core\Resource\Folder $folder
     * @param string $conflictMode cancel: use existing file; replace: replace existing file; changeName: get a unique name for current file
     * @return string
     */
    public static function addUploadedFile($storage, $fileInfo, $folder, $conflictMode = 'cancel')
    {
        // add file to storage
        try {
            if ($folder->hasFile($fileInfo['name']) && $conflictMode == 'cancel') {
                $fileObject = $storage->getFile($folder->getIdentifier() . $fileInfo['name']);
            } else {
                $fileObject = $storage->addUploadedFile($fileInfo, $folder, null, $conflictMode);
            }
        } catch (\TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException $e) {
            $fileObject = null;
        }
        return $fileObject;
    }

    /**
     * Creates a file reference in sys_file_ref and updates the refcount in the foreign table
     *
     * @param int $uidLocal
     * @param int $uidForeign
     * @param string $tableNames
     * @param string $fieldName
     * @param int $pid
     * @param string $tableLocal
     * @param int $sortingForeign
     * @return int Uid of the new file reference
     */
    public static function addFileReference($uidLocal, $uidForeign, $tableNames, $fieldName, $pid, $tableLocal = 'sys_file', $sortingForeign = 0)
    {
        /**
         * Apparently there is no better way to do this right now.
         * This has to be changed as soon as an extbase way is documented
         * Check http://wiki.typo3.org/File_Abstraction_Layer#Usage_in_Extbase_.28in_progress.29
         * http://forum.typo3.org/index.php/t/196218/
         */

        // Insert Reference to file
        $fileReferenceFields =  [
            'uid_local' => $uidLocal,
            'uid_foreign' => $uidForeign,
            'tablenames' => $tableNames,
            'fieldname' => $fieldName,
            'pid' => $pid,
            'table_local' => $tableLocal,
            'crdate' => $GLOBALS['EXEC_TIME'],
            'tstamp' => $GLOBALS['EXEC_TIME'],
            'sorting_foreign' => (int)$sortingForeign
        ];

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $connection = $connectionPool->getConnectionForTable('sys_file_reference');
        $connection->insert(
            'sys_file_reference',
            $fileReferenceFields
        );

        $sysFileReferenceUid = $connection->lastInsertId('sys_file_reference');

        // Update ref count on object
        $connection = $connectionPool->getConnectionForTable($tableNames);
        $record = $connection->select(
            [$fieldName],
            $tableNames,
            ['uid' => $uidForeign],
            [],
            [],
            1
        )->fetch();

        $fileRef = intval($record[$fieldName]);
        $fileRef++;

        $connection = $connectionPool->getConnectionForTable($tableNames);
        $connection->update(
            $tableNames,
            [$fieldName => $fileRef],
            ['uid' => $uidForeign]
        );

        return $sysFileReferenceUid;
    }

    public static function removeFileReference($uid)
    {
        // Update ref count on object
        // get fileref row
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $connection = $connectionPool->getConnectionForTable('sys_file_reference');
        $fileRef = $connection->select(
            ['*'],
            'sys_file_reference',
            ['uid' => $uid],
            [],
            [],
            1
        )->fetch();

        // get count on foreign table
        $connection = $connectionPool->getConnectionForTable($fileRef['tablenames']);
        $foreignField = $connection->select(
            [$fileRef['fieldname']],
            $fileRef['tablenames'],
            ['uid' => $fileRef['uid_foreign']],
            [],
            [],
            1
        )->fetch();

        // decrement count
        $foreignFieldCount = intval($foreignField[$fileRef['fieldname']]);
        $foreignFieldCount--;

        // update ref count
        $connection = $connectionPool->getConnectionForTable($fileRef['tablenames']);
        $connection->update(
            $fileRef['tablenames'],
            [$fileRef['fieldname'] => $foreignFieldCount],
            ['uid' => $fileRef['uid_foreign']]
        );

        // delete file reference
        $connection = $connectionPool->getConnectionForTable('sys_file_reference');
        $connection->delete(
            'sys_file_reference',
            ['uid' => $uid]
        );
    }
}
