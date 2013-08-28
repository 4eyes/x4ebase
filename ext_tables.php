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

?>