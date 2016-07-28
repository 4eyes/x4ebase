<?php
namespace X4E\X4ebase\Hooks;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FrontendHook
 *
 * Hook to forward index.php urls to realurl pendant
 *
 * @package X4E\X4ebase\Hooks
 */
class FrontendHook {
    /**
     * Source: https://bitbucket.org/edirect24ug/forcerealurl2
     *
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     */
    function checkForRealurl($params, $pObj) {
        if ($pObj->siteScript && $pObj->config['config']['tx_realurl_enable'] && (
                substr($pObj->siteScript, 0, 9) == 'index.php' ||
                substr($pObj->siteScript, 0, 1) == '?'
            )
            && strpos($pObj->siteScript, '&noforce=1') === false // A way to skip redirect. Thanks goes to Reindl Bernd.
            && strpos($pObj->siteScript, '&jumpurl=') === false // Skip redirect if URL is for jumpurl. Thanks goes to Reindl Bernd.
            && !$pObj->isBackendUserLoggedIn() // Skip redirect if we are in BE Logged in
        ) {
            $baseURL = $pObj->config['config']['baseURL'];
            $LD = $pObj->tmpl->linkData(
                $pObj->page,
                '',
                $pObj->no_cache,
                '',
                '',
                GeneralUtility::getIndpEnv('QUERY_STRING')
            );

            if (strtolower($LD['totalURL']) != strtolower($pObj->siteScript) && strtolower($LD['totalURL']) != '/' . strtolower($pObj->siteScript)) {
                $url = rtrim($baseURL, '/') . '/' . ltrim($LD['totalURL'], '/');

                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $url);
                exit;
            }
        }
    }
}