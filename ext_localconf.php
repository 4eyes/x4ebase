<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Registering all available hashes to factory
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/saltedpasswords']['saltMethods']['X4E\\X4ebase\\Salt\\SecurePasswordSalt'] = 'X4E\\X4ebase\\Salt\\SecurePasswordSalt';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:saltedpasswords/locallang.xml'][] = 'EXT:x4ebase/Resources/Private/Language/locallang_securepassword.xlf';

// XClasses
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings'] = array(
    'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Typo3QuerySettings'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapFactory'] = array(
    'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Mapper\\DataMapFactory'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper'] = array(
    'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Mapper\\DataMapper'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbBackend'] = array(
    'className' => 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Storage\\Typo3DbBackend'
);

// We need to set the default implementation for Storage Backend & Query Settings
// the code below is NO PUBLIC API! It's just to make sure that
// Extbase works correctly in the backend if the page tree is empty or no
// template is defined.
/* @var $extbaseObjectContainer \TYPO3\CMS\Extbase\Object\Container\Container */
$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\Container\\Container');
// Singleton
$extbaseObjectContainer->registerImplementation('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QuerySettingsInterface', 'X4E\\X4ebase\\XClasses\\Persistence\\Generic\\Typo3QuerySettings');
unset($extbaseObjectContainer);
?>
