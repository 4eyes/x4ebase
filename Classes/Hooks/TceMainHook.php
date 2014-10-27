<?php
namespace X4E\X4ebase\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * 
 * @author Michel Georgy <michel@georgy.ch>
 */
class TceMainHook {

	/**
	 * 
	 * @param string $status
	 * @param string $table
	 * @param string $id
	 * @param array $fieldArray
	 * @param mixed $pObj
	 */
	function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $pObj) {
		if (isset($GLOBALS['_POST']['_savedokview_x'])) {
			$this->setPreviewVars($id, $table, $fieldArray);
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
	 */
	function setPreviewVars($id, $table, $fieldArray){
		if (!is_numeric($id)) {
			$id = $pObj->substNEWwithIDs[$id];
		}
			
		// get page TSconfig
		$pageTs = BackendUtility::getPagesTSconfig($GLOBALS['_POST']['popViewId']);
		if($pageTs['x4ebase.']['preview.'][$table.'.']){
			$previewPageTs = $pageTs['x4ebase.']['preview.'][$table.'.'];
		} else if($pageTs['x4ebase.']['preview.']){
			$previewPageTs = $pageTs['x4ebase.']['preview.'];
		}
		
		if ($previewPageTs['additionalGetVars']){
			$additionalGetVars = '&no_cache=1';
			// add language if record is a translation
			if($fieldArray['sys_language_uid'] > 0){
				$additionalGetVars .= '&L=' . $fieldArray['sys_language_uid'];
			}
			
			// add record id
			$additionalGetVars .= str_replace('###recordId###', $id, $previewPageTs['additionalGetVars']);
			
			// set get vars 
			$GLOBALS['_POST']['popViewId_addParams'] = $additionalGetVars;
		}
	}
}

?>