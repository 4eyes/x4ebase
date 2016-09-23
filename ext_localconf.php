<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
$extConf = unserialize($_EXTCONF);

//==============================================================================
// region XClasses
//==============================================================================
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class] = [
    'className' => \X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class] = [
    'className' => \X4e\X4ebase\XClasses\Persistence\Generic\Mapper\DataMapper::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbBackend::class] = [
    'className' => \X4e\X4ebase\XClasses\Persistence\Generic\Storage\Typo3DbBackend::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Localization\Parser\XliffParser::class] = [
    'className' => \X4e\X4ebase\XClasses\Localization\Parser\XliffParser::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class] = [
    'className' => \X4e\X4ebase\XClasses\Controller\TypoScriptFrontendController::class
];

/**
 * xclasses to allow cli-configuration of an extension, see https://jira.4eyes.ch/browse/IMPROVE-409
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \X4e\X4ebase\Controller\ExtensionCommandController::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Extensionmanager\Controller\ConfigurationController::class] = [
    'className' => \X4e\X4ebase\XClasses\Controller\ConfigurationController::class
];
// endregion

//==============================================================================
// region Hooks
//==============================================================================
if ($extConf['javascriptOptimization']) {
    // do not merge per page added inline JS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$_EXTKEY] = \X4e\X4ebase\Hooks\RenderPreProcessHook::class . '->process';
}
if ($extConf['forceRealurl']) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['isOutputting'][$_EXTKEY] = \X4e\X4ebase\Hooks\FrontendHook::class . '->checkForRealurl';

    // Additional Hook to process check before indexing
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][$_EXTKEY] = \X4e\X4ebase\Hooks\FrontendHook::class . '->checkForRealurl';
}

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \X4e\X4ebase\Controller\EmailQueueCommandController::class;
}
// endregion

//==============================================================================
// region Signals / Slots
//==============================================================================
if (!$extConf['fileTimestamp.']['disable_fe'] || !$extConf['fileTimestamp.']['disable_be']) {
    /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Core\Resource\ResourceStorage::class,
        TYPO3\CMS\Core\Resource\ResourceStorage::SIGNAL_PreGeneratePublicUrl,
        \X4e\X4ebase\Signal\PublicFileUri::class,
        'preGeneratePublicUrl'
    );
}
// endregion

// We need to set the default implementation for Storage Backend & Query Settings
// the code below is NO PUBLIC API! It's just to make sure that
// Extbase works correctly in the backend if the page tree is empty or no
// template is defined.
/* @var $extbaseObjectContainer \TYPO3\CMS\Extbase\Object\Container\Container */
$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class);
// Singleton
$extbaseObjectContainer->registerImplementation(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class, \X4e\X4ebase\XClasses\Persistence\Generic\Typo3QuerySettings::class);
unset($extbaseObjectContainer);

// region contextSkin
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

    if (preg_match('/Development/i', $contextString)) {
        $context = 'Development';
        $color = '#2b9947';
    } elseif (preg_match('/Staging/i', $contextString)) {
        $context = 'Staging';
        $color = '#d16312';
    } elseif (preg_match('/Live/i', $contextString)) {
        $context = 'Live';
        $color = '#992e2b';
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
#This line is included dynamically in EXT:x4ebase/ext_tables.php
[applicationContext = Production/Live]
[else]
page.1 = TEXT
page.1 {
	value = <div id="x4ebase-context-bar" style="font-family: Arial, sans-serif; font-size: 16px; line-height: 2; background-color: ' . $color . '; padding: 10px; color: white;"><span style="font-weight: bold;">Context:</span> <span style="font-style: italic;">' . $contextString . '</span></div>
	insertData = 1
}
[global]
	');
}
/**
 * Include colored bar in frontend rendering depending on current ApplicationContext (Can be enabled/Disabled in Extension Manager)
 * [END]
 */
// endregion

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'X4e.' . $_EXTKEY,
    'ContentExceptionTest',
    [
        'ContentExceptionTest' => 'content, exception'
    ],
    // non-cacheable actions
    [
        'ContentExceptionTest' => 'content, exception'
    ]
);
