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
class TcaInfoController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action show
     *
     * @global \TYPO3\CMS\Core\Database\DatabaseConnection $TYPO3_DB
     *
     * @param array $generator Extbase Model Generator
     *
     * @return void
     */
    public function showAction()
    {
        if ($this->request->hasArgument('table')) {
            $table = $this->request->getArgument('table');
            $this->view->assign('table', $GLOBALS['TCA'][$table]);
            $this->view->assign('tableName', $table);
        }

        $this->view->assign('tables', $this->getTableArray());
    }

    /**
     * Generates an array of tables
     *
     *
     * @return array
     */
    protected function getTableArray()
    {
        $tables = [];
        $tca = $GLOBALS['TCA'];

        foreach ($tca as $name => $info) {
            if (\TYPO3\CMS\Core\Utility\GeneralUtility::inList($GLOBALS['BE_USER']->groupData['tables_select'], $name) || $GLOBALS['BE_USER']->user['admin'] == 1) {
                $label = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($info['ctrl']['title'], 'x4ebase');
                $label .= ' (' . $name . ')';

                $tables[$name] = $label;
            }
        }

        return $tables;
    }
}
