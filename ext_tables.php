<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
$extConf = unserialize($_EXTCONF);

if (TYPO3_MODE === 'BE') {

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'X4e.' . $_EXTKEY,
        'tools',                // Make module a submodule of 'tools'
        'modelgenerator',        // Submodule key
        '',                        // Position
        [
            'ModelGenerator' => 'show',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module-x4e.svg',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_modelgenerator.xlf',
        ]
    );

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'X4e.' . $_EXTKEY,
        'web',                // Make module a submodule of 'web'
        'tcainfo',        // Submodule key
        '',                        // Position
        [
            'TcaInfo' => 'show',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module-x4e.svg',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tcainfo.xlf',
        ]
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
     [
        'crdate' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.tx_x4ebase_crdate',
            'config' =>  [
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',

            ]
        ],
        'tstamp' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.tx_x4ebase_crdate',
            'config' =>  [
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',

            ]
        ]
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Main', '4eyes Base');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/FilterAjax', '4eyes Base - Ajax Filters');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_x4ebase_domain_model_emaillog', 'EXT:x4ebase/Resources/Private/Language/locallang_csh_tx_x4ebase_domain_model_emaillog.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_x4ebase_domain_model_emaillog');
$TCA['tx_x4ebase_domain_model_emaillog'] = [

];

/**
 * Include custom backend skin depending on current ApplicationContext (Can be enabled/Disabled in Extension Manager)
 * [begin]
 */
if (TYPO3_MODE === 'BE' && is_array($extConf) && $extConf['contextSkin.']['be.']['enable']) {
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

    if (preg_match('/Development/i', $contextString)) {
        $context = 'Development';
    } elseif (preg_match('/Staging/i', $contextString)) {
        $context = 'Staging';
    } elseif (preg_match('/Live/i', $contextString)) {
        $context = 'Live';
    }

    $TBE_STYLES['skins']['x4ebase'] =  [
        'name' => 'x4ebase',
        'stylesheetDirectories' =>  [
            'structure' => 'EXT:x4ebase/Resources/Public/Backend/Css/Skin/' . $context . '/'
        ]
    ];
}
/**
 * Include custom backend skin depending on current ApplicationContext (Can be enabled/Disabled in Extension Manager)
 * [end]
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'ContentExceptionTest',
    'Content exception test'
);
