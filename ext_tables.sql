#
# Table structure for table 'sys_file_metadata'
#
CREATE TABLE sys_file_metadata (
  tx_swconnect_url text,
);

#
# Table structure for table 'tx_dpnswconnect_shop'
#
CREATE TABLE tx_dpnswconnect_shop (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,

	deleted tinyint(4) DEFAULT '0' NOT NULL,

	shopware_id int(11) NOT NULL,
	title tinytext,
	is_default tinyint(4) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid)
);

#
# Table structure for table 'tx_dpnswconnect_article'
#
CREATE TABLE tx_dpnswconnect_article (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,

	deleted tinyint(4) DEFAULT '0' NOT NULL,

	shopware_id int(11) NOT NULL,
	name tinytext,
	article_number tinytext,

	PRIMARY KEY (uid)
);
