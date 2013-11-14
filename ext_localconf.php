<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Registering all available hashes to factory
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/saltedpasswords']['saltMethods']['X4E\\X4ebase\\Salt\\SecurePasswordSalt'] = 'X4E\\X4ebase\\Salt\\SecurePasswordSalt';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:saltedpasswords/locallang.xml'][] = 'EXT:x4ebase/Resources/Private/Language/locallang_securepassword.xlf';

// XClasses
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMapper'] = array(
    'className' => 'X4E\\X4ebase\\Persistence\\Generic\\Mapper\\DataMapper'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbBackend'] = array(
    'className' => 'X4E\\X4ebase\\Persistence\\Generic\\Storage\\Typo3DbBackend'
);
?>
