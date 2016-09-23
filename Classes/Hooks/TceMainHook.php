<?php
namespace X4e\X4ebase\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 *
 * @author Michel Georgy <michel@georgy.ch>
 */
class TceMainHook
{

    /**
     *
     * @param string $status
     * @param string $table
     * @param string $id
     * @param array $fieldArray
     * @param mixed $pObj
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $pObj)
    {
        if (isset($GLOBALS['_POST']['_savedokview_x'])) {
            $this->setPreviewVars($id, $table, $fieldArray, $pObj);
        }
    }

    /**
     * Make save and preview configurable with pageTs
     * Set preview vars
     *
     * requires saveAndPreview hook!
     * @see SaveAndPreviewHook
     *
     * @param string $id
     * @param string $table
     * @param array $fieldArray
     * @param mixed $pObj
     */
    public function setPreviewVars($id, $table, $fieldArray, $pObj)
    {
        if (!is_numeric($id)) {
            $id = $pObj->substNEWwithIDs[$id];
        }
        $record = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $table, 'uid=' . $id);
        if ($record) {
            // get page TSconfig
            $pageTs = BackendUtility::getPagesTSconfig($GLOBALS['_POST']['popViewId']);
            if ($pageTs['x4ebase.']['preview.'][$table . '.']) {
                $previewPageTs = $pageTs['x4ebase.']['preview.'][$table . '.'];

                $additionalGetVars = '&no_cache=1';
                // add language if record is a translation
                if ($record['sys_language_uid'] > 0) {
                    //$id = $record['l10n_parent'];
                    $additionalGetVars .= '&L=' . $record['sys_language_uid'];
                }

                if ($previewPageTs['additionalGetVars']) {
                    // add record id
                    $additionalGetVars .= str_replace('###recordId###', $id, $previewPageTs['additionalGetVars']);
                }
                // set get vars
                $GLOBALS['_POST']['popViewId_addParams'] = $additionalGetVars;
            }
        }
    }
}
