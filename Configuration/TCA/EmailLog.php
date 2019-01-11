<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_x4ebase_domain_model_emaillog'] = [
    'ctrl' => $TCA['tx_x4ebase_domain_model_emaillog']['ctrl'],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sender, recipient, bcc, subject, message, is_sent, error',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, sender, recipient, bcc, subject, message, is_sent, error,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_x4ebase_domain_model_emaillog',
                'foreign_table_where' => 'AND tx_x4ebase_domain_model_emaillog.pid=###CURRENT_PID### AND tx_x4ebase_domain_model_emaillog.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'sender' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.sender',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'recipient' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.recipient',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'bcc' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.bcc',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'subject' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'message' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.message',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
        'is_sent' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.is_sent',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'is_html' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.is_html',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'queued' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.queued',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'error' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.error',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
    ],
];
