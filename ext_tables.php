<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'X4E.' . $_EXTKEY,
		'tools',				// Make module a submodule of 'tools'
		'modelgenerator',		// Submodule key
		'',						// Position
		array(
			'ModelGenerator' => 'show',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_modelgenerator.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'pages',
	array (
		'crdate' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.tx_x4ebase_crdate',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',

            )
        ),
		'tstamp' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.tx_x4ebase_crdate',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',

            )
        ),
	),
	1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', '4eyes Base');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_x4ebase_domain_model_emaillog', 'EXT:x4ebase/Resources/Private/Language/locallang_csh_tx_x4ebase_domain_model_emaillog.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_x4ebase_domain_model_emaillog');
$TCA['tx_x4ebase_domain_model_emaillog'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog',
		'label' => 'recipient',
		'label_alt' => 'tstamp',
		'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'sender,recipient,subject,message,is_sent,error,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/EmailLog.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_x4ebase_domain_model_emaillog.gif'
	),
);