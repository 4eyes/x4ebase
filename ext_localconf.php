<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
$extConf = unserialize($_EXTCONF);

//==============================================================================
//   Password Hashing Methods
//==============================================================================
// password_hash implementation for PHP < 5.5
require_once $extPath . 'Resources/Private/Libraries/password_hash.php';
// Registering all available hashes to factory
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/saltedpasswords']['saltMethods']['X4E\\X4ebase\\Salt\\SecurePasswordSalt'] = 'X4E\\X4ebase\\Salt\\SecurePasswordSalt';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:saltedpasswords/locallang.xml'][] = 'EXT:x4ebase/Resources/Private/Language/locallang_securepassword.xlf';

//==============================================================================
//   XClasses
//==============================================================================
if(version_compare(TYPO3_branch, '6.2', '<=')) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings'] = array(
		'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Typo3QuerySettings'
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper'] = array(
		'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Mapper\\DataMapper'
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbBackend'] = array(
		'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Storage\\Typo3DbBackend'
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Localization\\Parser\\XliffParser'] = array(
		'className' => 'X4E\\X4ebase\\XClasses\\Localization\\Parser\\XliffParser'
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController'] = array(
		'className' => 'X4E\\X4ebase\\XClasses\\Controller\\TypoScriptFrontendController'
	);
}

//==============================================================================
//   Hooks
//==============================================================================
// This hook enables save and preview functionality for articles
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['viewOnClickClass'][$_EXTKEY] = 'EXT:x4ebase/Classes/Hooks/SaveAndPreviewHook.php:&X4E\X4ebase\Hooks\SaveAndPreviewHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][$_EXTKEY] = 'EXT:x4ebase/Classes/Hooks/TceMainHook.php:&X4E\X4ebase\Hooks\TceMainHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'EXT:x4ebase/Classes/Hooks/TceMainHook.php:&X4E\X4ebase\Hooks\TceMainHook';


// We need to set the default implementation for Storage Backend & Query Settings
// the code below is NO PUBLIC API! It's just to make sure that
// Extbase works correctly in the backend if the page tree is empty or no
// template is defined.
/* @var $extbaseObjectContainer \TYPO3\CMS\Extbase\Object\Container\Container */
$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\Container\\Container');
// Singleton
$extbaseObjectContainer->registerImplementation('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QuerySettingsInterface', 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Typo3QuerySettings');
unset($extbaseObjectContainer);



/**
 * Include colored bar in frontend rendering depending on current ApplicationContext (Can be enabled/Disabled in Extension Manager)
 * [begin]
 */
if (TYPO3_MODE === 'FE' && is_array($extConf) && $extConf['contextSkin.']['fe.']['enable']) {
	$applicationContext = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext();
	if ($_SERVER['argc'] > 0) {
		// find --context=Production from the command line
		foreach ($_SERVER['argv'] as $argumentValue) {
			if (substr($argumentValue, 0, 10)  === '--context=') {
				$contextString = substr($argumentValue, 10);
				break;
			}
		}
	}
	if (empty($contextString)) {
		$contextString = $applicationContext->__toString();
	}

	if (preg_match("/Development/i", $contextString)) {
		$context = 'Development';
		$color = '#2b9947';
	}
	else if (preg_match("/Staging/i", $contextString)){
		$context = 'Staging';
		$color = '#d16312';
	}
	else if (preg_match("/Live/i", $contextString)) {
		$context = 'Live';
		$color = '#992e2b';
	}

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
#This line is included dynamically in EXT:x4ebase/ext_tables.php
[applicationContext = Production/Live]
[else]
page.1 = TEXT
page.1 {
	value = <div id="x4ebase-context-bar" style="font-family: Arial, sans-serif; font-size: 16px; line-height: 2; background-color: ' . $color . '; padding: 10px; color: white;"><span style="font-weight: bold;">Context:</span> <span style="font-style: italic;">'. $contextString . '</span></div>
	insertData = 1
}
[global]
	');
}
/**
 * Include colored bar in frontend rendering depending on current ApplicationContext (Can be enabled/Disabled in Extension Manager)
 * [END]
 */