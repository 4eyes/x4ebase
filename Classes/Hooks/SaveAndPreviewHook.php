<?php
namespace X4e\X4ebase\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Make save and preview configurable with pageTs
 * @author Michel Georgy <michel@georgy.ch>
 */
class SaveAndPreviewHook
{
    /**
     *
     * @param int $pageUid
     * @param string $backPath
     * @param array $rootLine
     * @param array $anchorSection
     * @param string $viewScript
     * @param array $additionalGetVars
     * @param bool $switchFocus
     */
    public function preProcess(&$pageUid, $backPath, $rootLine, $anchorSection, &$viewScript, &$additionalGetVars, $switchFocus)
    {
        // get configured detail view page from page ts
        $pageTs = BackendUtility::getPagesTSconfig($pageUid);

        if ($GLOBALS['_POST']['data']) {
            $table = key($GLOBALS['_POST']['data']);
        }
        if ($table && $pageTs['x4ebase.']['preview.'][$table . '.']) {
            $previewPageTs = $pageTs['x4ebase.']['preview.'][$table . '.'];

            if ($previewPageTs) {
                // set preview page uid
                if ($previewPageTs['pageUid']) {
                    $pageUid = $previewPageTs['pageUid'];
                }

                // set viewScript, default is /index.php?id=
                if ($previewPageTs['viewScript']) {
                    $viewScript = $previewPageTs['viewScript'];
                }

                // add additional get vars
                /*if($previewPageTs['additionalGetVars'] && !$previewPageTs['appendRecordId']){
                    $additionalGetVars .= $previewPageTs['additionalGetVars'];
                }*/

                // Appending of record id is done in tceMain hook! @see TceMainHook
            }
        }
    }
}
