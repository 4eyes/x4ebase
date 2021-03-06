#
# Table structure for table 'pages'
#
CREATE TABLE pages (
  redirect_http_status int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'be_users'
#
CREATE TABLE be_users (
  password varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  password varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_x4ebase_domain_model_emaillog'
#
CREATE TABLE tx_x4ebase_domain_model_emaillog (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	sender varchar(255) DEFAULT '' NOT NULL,
	recipient varchar(255) DEFAULT '' NOT NULL,
	subject varchar(255) DEFAULT '' NOT NULL,
	replyTo varchar(255) DEFAULT '' NOT NULL,
	message text NOT NULL,
	is_sent tinyint(1) unsigned DEFAULT '0' NOT NULL,
	is_html tinyint(1) unsigned DEFAULT '0' NOT NULL,
	queued tinyint(1) unsigned DEFAULT '0' NOT NULL,
	error text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);