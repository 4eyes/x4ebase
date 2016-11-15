<?php
namespace X4e\X4ebase\XClasses\DataHandling;

/*
     * This file is part of the TYPO3 CMS project.
     *
     * It is free software; you can redistribute it and/or modify it under
     * the terms of the GNU General Public License, either version 2
     * of the License, or any later version.
     *
     * For the full copyright and license information, please read the
     * LICENSE.txt file that was distributed with this source code.
     *
     * The TYPO3 project - inspiring people to share!
     */

/**
 * The main data handler class which takes care of correctly updating and inserting records.
 * This class was formerly known as TCEmain.
 *
 * This is the TYPO3 Core Engine class for manipulation of the database
 * This class is used by eg. the tce_db.php script which provides an the interface for POST forms to this class.
 *
 * Dependencies:
 * - $GLOBALS['TCA'] must exist
 * - $GLOBALS['LANG'] must exist
 *
 * tce_db.php for further comments and SYNTAX! Also see document 'TYPO3 Core API' for details.
 */
class DataHandler extends \TYPO3\CMS\Core\DataHandling\DataHandler
{

    /**
     * List of changed old record ids to new records ids
     *
     * @var array
     */
    public $mmHistoryRecords = [];
}
