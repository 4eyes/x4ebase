<?php
namespace X4e\X4ebase\Controller;

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
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ModelGeneratorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * The response which will be returned by this action controller
     *
     * @var \TYPO3\CMS\Extbase\Mvc\Web\Response
     */
    protected $response;

    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction()
    {
    }

    /**
     * action show
     *
     * @global \TYPO3\CMS\Core\Database\DatabaseConnection $TYPO3_DB
     *
     * @param array $generator Extbase Model Generator
     *
     * @return void
     */
    public function showAction(array $generator = null)
    {
        global $TYPO3_DB;

        if ($generator === null) {
            $generator = [];
        }

        $databaseTables = [];
        if (($res = $TYPO3_DB->sql_query('SHOW TABLES')) !== false) {
            while (($row = $TYPO3_DB->sql_fetch_row($res)) !== false) {
                $databaseTables[] = $row[0];
            }
            $TYPO3_DB->sql_free_result($res);
            natcasesort($databaseTables);
            $databaseTables = array_combine($databaseTables, $databaseTables);
        }

        $initDatabaseTableFields = !(isset($generator['databaseTable']) && isset($generator['previousDatabaseTable']) && $generator['databaseTable'] === $generator['previousDatabaseTable']);

        $databaseTableFields = [];
        $databaseTableFieldOptions = [];
        if (isset($generator['databaseTable']) && in_array($generator['databaseTable'], $databaseTables)) {
            if (($res = $TYPO3_DB->sql_query('SHOW COLUMNS FROM `' . $generator['databaseTable'] . '`')) !== false) {
                while (($row = $TYPO3_DB->sql_fetch_assoc($res)) !== false) {
                    $databaseTableFields[$row['Field']] =  ['name' => $row['Field'], 'type' => $this->getSqlFieldType($row['Type'])];
                    $databaseTableFieldOptions[$row['Field']] = $row['Field'];
                }
                $TYPO3_DB->sql_free_result($res);
            }
        }

        if (isset($generator['databaseTable'])) {
            if ($initDatabaseTableFields) {
                $excludeFields = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', 'uid, pid, tstamp, crdate, cruser_id, deleted, hidden, sorting, starttime, endtime, t3ver_oid, t3ver_id, t3ver_wsid, t3ver_label, t3ver_state, t3ver_stage, t3ver_count, t3ver_tstamp, t3ver_move_id, t3_origuid, sys_language_uid, l10n_parent, l10n_diffsource');
                $generator['databaseTableFields'] = array_values(array_diff_key($databaseTableFieldOptions, array_flip($excludeFields)));
            }
            $databaseTableFields = array_intersect_key($databaseTableFields, array_flip($generator['databaseTableFields']));
            $generator['previousDatabaseTable'] = $generator['databaseTable'];
        }

        $extbaseClass = (isset($generator['databaseTable']) ? $this->getExtbaseClassFromFields($generator['databaseTable'], $databaseTableFields) : '');
        $TSMappings = (isset($generator['databaseTable']) ? $this->getTSMappingsFromFields($generator['databaseTable'], $databaseTableFields) : '');

        $this->view->assign('generator', $generator);
        $this->view->assign('databaseTables', $databaseTables);
        $this->view->assign('databaseTableFields', $databaseTableFieldOptions);
        $this->view->assign('extbaseClass', $extbaseClass);
        $this->view->assign('TSMappings', $TSMappings);
    }

    protected function getSqlFieldType($sqlType)
    {
        $switchType = strtolower(preg_replace('/^(\w+).*/', '$1', $sqlType));
        $type = null;
        switch ($switchType) {
            case 'tinyint':
            case 'mediumint':
            case 'int':
            case 'integer':
            case 'bigint':
            case 'decimal':
            case 'numeric':
            case 'dec':
            case 'float':
            case 'double':
                $type = 'integer';
                break;
            case 'bool':
            case 'boolean':
                $type = 'boolean';
                break;
            default:
                $type = 'string';
                break;
        }
        return $type;
    }

    protected function getExtbaseClassFromFields($table, $fieldsArray)
    {
        $definitions = '';
        $methods = '';

        $camelcaseTableName = ucfirst(preg_replace_callback('/_([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, strtolower($table)));

        foreach ($fieldsArray as $fieldArray) {
            $camelcaseField = preg_replace_callback('/_([a-z])/', function ($matches) {
                return strtoupper($matches[1]);
            }, strtolower($fieldArray['name']));
            $definitions .=
'
	/**
	 * ' . $camelcaseField . '
	 *
	 * @var ' . $fieldArray['type'] . '
	 */
	protected $' . $camelcaseField . ';
';
            $methods .=
'
	/**
	 * Returns the ' . $camelcaseField . '
	 *
	 * @return ' . $fieldArray['type'] . ' $' . $camelcaseField . '
	 */
	public function get' . ucfirst($camelcaseField) . '() {
		return $this->' . $camelcaseField . ';
	}

	/**
	 * Sets the ' . $camelcaseField . '
	 *
	 * @param ' . $fieldArray['type'] . ' $' . $camelcaseField . '
	 * @return void
	 */
	public function set' . ucfirst($camelcaseField) . '($' . $camelcaseField . ') {
		$this->' . $camelcaseField . ' = $' . $camelcaseField . ';
	}
';
        }

        $extbaseClass = 'class ' . $camelcaseTableName . ' extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
	' . $definitions . '
	/**
	 * __construct
	 *
	 * @return ' . $camelcaseTableName . '
	 */
	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		//$this->xyz = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}
	' . $methods . '
}';
        return $extbaseClass;
    }

    protected function getTSMappingsFromFields($table, $fieldsArray)
    {
        $mappings = '';

        $camelcaseTableName = ucfirst(preg_replace_callback('/_([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, strtolower($table)));

        foreach ($fieldsArray as $fieldArray) {
            $camelcaseField = preg_replace_callback('/_([a-z])/', function ($matches) {
                return strtoupper($matches[1]);
            }, strtolower($fieldArray['name']));
            $mappings .= '			' . $fieldArray['name'] . '.mapOnProperty = ' . $camelcaseField . "\n";
        }

        $TSMappings =
'\\' . $camelcaseTableName . ' {
	mapping {
		tableName = ' . $table . '
		columns {
' . $mappings . '
		}
	}
}';
        return $TSMappings;
    }
}
