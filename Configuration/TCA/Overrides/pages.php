<?php
defined('TYPO3_MODE') or die();

$tempColumns = [
    'redirect_http_status' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:pages.redirect_http_status',
        'config' => [
            'type' => 'select',
            'items' => [
                [
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_301,
                    '301'
                ],
                [
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_302,
                    '302'
                ],
                [
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_303,
                    '303'
                ],
                [
                    \TYPO3\CMS\Core\Utility\HttpUtility::HTTP_STATUS_307,
                    '307'
                ]
            ],
            'default' => 307
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'shortcut', 'redirect_http_status');
