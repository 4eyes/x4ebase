<?php
namespace X4e\X4ebase\XClasses\Controller;

use TYPO3\CMS\Core\Utility\HttpUtility;

class TypoScriptFrontendController extends \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController {

    /**
     * Builds a typolink to the current page, appends the type paremeter if required
     * and redirects the user to the generated URL using a Location header.
     *
     * @return void
     */
    protected function redirectToCurrentPage() {
        $redirectHttpCode = ($this->originalShortcutPage['redirect_http_status']) ? $this->originalShortcutPage['redirect_http_status'] : 0;
        if($this->originalShortcutPage['redirect_http_status'] === 0){
            parent::redirectToCurrentPage();
        }

        $this->calculateLinkVars();
        // instantiate tslib_content to generate the correct target URL
        /** @var $cObj \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer */
        $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $parameter = $this->page['uid'];
        $type = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('type');
        if ($type) {
            $parameter .= ',' . $type;
        }
        $redirectUrl = $cObj->typoLink_URL(array('parameter' => $parameter));

        switch ((int)$redirectHttpCode) {
            case 301:
                $statusCode = HttpUtility::HTTP_STATUS_301;
                break;
            case 302:
                $statusCode = HttpUtility::HTTP_STATUS_302;
                break;
            case 303:
                $statusCode = HttpUtility::HTTP_STATUS_303;
                break;
            case 307:
            default:
                $statusCode = HttpUtility::HTTP_STATUS_307;
                break;
        }

        // Prevent redirection loop
        if (!empty($redirectUrl)) {
            // redirect and exit
            \TYPO3\CMS\Core\Utility\HttpUtility::redirect($redirectUrl, $statusCode);
        }
    }
}