<?php

namespace X4e\X4ebase\Tests\Unit\Utility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Philipp Seßner <philipp@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * ************************************************************* */
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use X4e\X4ebase\Utility\FalUtility;

/**
 * Test case for class \X4e\X4ebase\Utility\FalUtility
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Seßner <philipp@4eyes.ch>
 */
class FalUtilityTest extends \X4e\X4ebase\Tests\Unit\Base\TestCaseBase {

	/** @var  \PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface|FalUtility */
	protected $subject;

	public function testHandyFileUpload() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}

	public function testGetStorage() {
		$this->markTestIncomplete(
			'Untestable - Static method calls'
		);
	}

	public function testGetFolderObject_WithFolderName_CallsCreateFolderIfSubfolderNotExists_ELSE_CallsGetSubfolder() {
		$this->mockSubject();

		$subSubFolder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFolder', 'createFolder', 'getSubfolder'), array(), '', FALSE);

		$subFolder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFolder', 'createFolder', 'getSubfolder'), array(), '', FALSE);
		$subFolder->expects($this->once())->method('hasFolder')->willReturn(FALSE);
		$subFolder->expects($this->once())->method('createFolder')->willReturn($subSubFolder);

		$folder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFolder', 'createFolder', 'getSubfolder'), array(), '', FALSE);
		$folder->expects($this->once())->method('hasFolder')->willReturn(TRUE);
		$folder->expects($this->once())->method('getSubfolder')->willReturn($subFolder);

		$storage = $this->getMock(\TYPO3\CMS\Core\Resource\ResourceStorage::class, array('getDefaultFolder'), array(), '', FALSE);
		$storage->expects($this->once())->method('getDefaultFolder')->willReturn($folder);

		$folderName = 'lorem/ipsum';

		$this->assertSame($subSubFolder, $this->subject->getFolderObject($storage, $folderName));
	}

	public function testGetFolderObject_WithoutFolderName() {
		$this->mockSubject();

		$folder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array(), array(), '', FALSE);

		$storage = $this->getMock(\TYPO3\CMS\Core\Resource\ResourceStorage::class, array('getDefaultFolder'), array(), '', FALSE);
		$storage->expects($this->once())->method('getDefaultFolder')->willReturn($folder);

		$this->assertSame($folder, $this->subject->getFolderObject($storage));
	}

	public function testAddUploadedFile_ConflictModeCancel() {
		$this->mockSubject();

		$fileObject = $this->getMock(\TYPO3\CMS\Core\Resource\FileReference::class, array(), array(), '', FALSE);

		$storage = $this->getMock(\TYPO3\CMS\Core\Resource\ResourceStorage::class, array('getFile', 'addUploadedFile'), array(), '', FALSE);
		$storage->expects($this->once())->method('getFile')->willReturn($fileObject);
		$folder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFile', 'getIdentifier'), array(), '', FALSE);
		$folder->expects($this->once())->method('hasFile')->willReturn(TRUE);
		$folder->expects($this->once())->method('getIdentifier');

		$fileInfo = array(
			'name' => 'lorem'
		);

		$this->assertSame($fileObject, $this->subject->addUploadedFile($storage, $fileInfo, $folder));
	}

	public function testAddUploadedFile_NoConflict() {
		$this->mockSubject();

		$fileObject = $this->getMock(\TYPO3\CMS\Core\Resource\FileReference::class, array(), array(), '', FALSE);

		$storage = $this->getMock(\TYPO3\CMS\Core\Resource\ResourceStorage::class, array('addUploadedFile'), array(), '', FALSE);
		$storage->expects($this->once())->method('addUploadedFile')->willReturn($fileObject);
		$folder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFile', 'getIdentifier'), array(), '', FALSE);
		$folder->expects($this->once())->method('hasFile')->willReturn(FALSE);

		$fileInfo = array(
			'name' => 'lorem'
		);

		$this->assertSame($fileObject, $this->subject->addUploadedFile($storage, $fileInfo, $folder));
	}

	public function testAddUploadedFile_HandlesException() {
		$this->mockSubject();

		$storage = $this->getMock(\TYPO3\CMS\Core\Resource\ResourceStorage::class, array('addUploadedFile'), array(), '', FALSE);
		$storage->expects($this->once())->method('addUploadedFile')->will($this->throwException(new \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException));
		$folder = $this->getMock(\TYPO3\CMS\Core\Resource\Folder::class, array('hasFile', 'getIdentifier'), array(), '', FALSE);
		$folder->expects($this->once())->method('hasFile')->willReturn(FALSE);

		$fileInfo = array(
			'name' => 'lorem'
		);

		$this->assertEquals(NULL, $this->subject->addUploadedFile($storage, $fileInfo, $folder));
	}

	public function testAddFileReference() {
		$this->mockSubject();

		$uidLocal = 1;
		$uidForeign = 2;
		$tableNames = 'lorem';
		$fieldName = 'ipsum';
		$pid = 3;
		$tableLocal = 'sys_file';

		$databaseConnection = $this->getMock(
			\TYPO3\CMS\Core\Database\DatabaseConnection::class,
			array(
				'exec_INSERTquery',
				'exec_SELECTgetSingleRow',
				'exec_UPDATEquery',
				'exec_DELETEquery'
			),
			array(), '', FALSE
		);
		$databaseConnection->expects($this->once())->method('exec_INSERTquery');
		$databaseConnection->expects($this->once())->method('exec_SELECTgetSingleRow');
		$databaseConnection->expects($this->once())->method('exec_UPDATEquery');
		$GLOBALS['TYPO3_DB'] = $databaseConnection;

		$this->subject->addFileReference($uidLocal, $uidForeign, $tableNames, $fieldName, $pid, $tableLocal);
	}

	public function testRemoveFileReference() {
		$this->mockSubject();

		$uid = 1;

		$databaseConnection = $this->getMock(
			\TYPO3\CMS\Core\Database\DatabaseConnection::class,
			array(
				'exec_INSERTquery',
				'exec_SELECTgetSingleRow',
				'exec_UPDATEquery',
				'exec_DELETEquery'
			),
			array(), '', FALSE
		);
		$databaseConnection->expects($this->exactly(2))->method('exec_SELECTgetSingleRow');
		$databaseConnection->expects($this->once())->method('exec_UPDATEquery');
		$databaseConnection->expects($this->once())->method('exec_DELETEquery');
		$GLOBALS['TYPO3_DB'] = $databaseConnection;

		$this->subject->removeFileReference($uid);
	}
}