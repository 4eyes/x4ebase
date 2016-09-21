<?php
namespace X4e\X4ebase\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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

use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Class RenderPreProcessHook
 *
 * Class to optimize inline javascripts
 *
 * @package X4e\X4ebase\Hooks
 */
class RenderPreProcessHook {
    /**
     * Exclude files generated by pageRenderer from concatenation
     * We do not want the per page added inline JS to be merged
     *
     * Source: https://github.com/fnagel/fe_performance/blob/master/Classes/Hook/RenderPreProcessHook.php
     *
     * @param array                             $params
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     *
     * @see TYPO3\CMS\Core\Page\PageRenderer render-preProcess hook
     */
    public function process(array $params, PageRenderer $pageRenderer) {
        if (count($params['jsFiles'])) {
            foreach ($params['jsFiles'] as $name => $properties) {
                // Match file pattern for old (6.2-7.4) and new file structure (>= 7.5)
                if (preg_match('/typo3temp\/(javascript_|Assets\/)[\d|a-z]+\.js/i', $name)) {
                    $params['jsFiles'][$name]['excludeFromConcatenation'] = 1;
                    $params['jsFiles'][$name]['section'] = 2;
                }
            }
        }
    }
}