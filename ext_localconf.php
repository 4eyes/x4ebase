<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Registering all available hashes to factory
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/saltedpasswords']['saltMethods']['X4E\\X4ebase\\Salt\\BlowfishSalt'] = 'X4E\\X4ebase\\Salt\\BlowfishSalt';
?>
