<?php
namespace X4e\X4ebase\Utility;

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
 *
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ZipUtility {

	/**
	 * create a zip archive
	 *
	 * @param string $source
	 * @param string $destination
	 * @return bool
	 * @throws \Exception
	 */
	public static function create($source, $destination){
		if (!extension_loaded('zip')) {
			throw new \Exception('Zip extension not installed');
		}
		if (!file_exists($source)) {
			throw new \Exception('Sourcefile <' . $source . '> does not exist');
		}

		$zip = new \ZipArchive();
		if (!$zip->open($destination, \ZipArchive::CREATE)) {
			throw new \Exception('Couldn\'t open or create <' . $destination . '>');
		}

		$source = str_replace('\\', '/', realpath($source));

		if (is_dir($source) === true)
		{
			$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);
			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', $file);
				// Ignore "." and ".." folder
				if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
					continue;
				$file = realpath($file);
				if (is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				else if (is_file($file) === true)
				{
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		}
		else if (is_file($source) === true)
		{
			$zip->addFromString(basename($source), file_get_contents($source));
		}

		return $zip->close();
	}

	/**
	 * Not implemented yet
	 *
	 * @throws \Exception
	 */
	public static function extract(){
		throw new \Exception('Extraction of zip not implemented yet');
	}
}