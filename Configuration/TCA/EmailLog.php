<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_x4ebase_domain_model_emaillog'] = array(
	'ctrl' => $TCA['tx_x4ebase_domain_model_emaillog']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sender, recipient, subject, message, is_sent, error',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, sender, recipient, subject, message, is_sent, error,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_x4ebase_domain_model_emaillog',
				'foreign_table_where' => 'AND tx_x4ebase_domain_model_emaillog.pid=###CURRENT_PID### AND tx_x4ebase_domain_model_emaillog.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'sender' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.sender',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'recipient' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.recipient',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'subject' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.subject',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'message' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.message',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'is_sent' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.is_sent',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'is_html' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.is_html',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'queued' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.queued',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'error' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:x4ebase/Resources/Private/Language/locallang_db.xlf:tx_x4ebase_domain_model_emaillog.error',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
	),
);