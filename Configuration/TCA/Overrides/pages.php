<?php
defined('TYPO3_MODE') or die();

$tempColumns = array(
    'redirect_http_status' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.redirect_http_status',
        'config' => array(
            'type' => 'select',
            'items' => array(
                array(
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_301,
                    '301'
                ),
                array(
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_302,
                    '302'
                ),
                array(
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_303,
                    '303'
                ),
                array(
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_307,
                    '307'
                )
            ),
            'default' => 307
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'shortcut', 'redirect_http_status');