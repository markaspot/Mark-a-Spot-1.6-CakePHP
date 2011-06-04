#App sql generated on: 2011-05-20 10:01:35 : 1305885695

DROP TABLE IF EXISTS `attachments`;
DROP TABLE IF EXISTS `bitly_links`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `configurations`;
DROP TABLE IF EXISTS `districts`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `groups_permissions`;
DROP TABLE IF EXISTS `groups_users`;
DROP TABLE IF EXISTS `markers`;
DROP TABLE IF EXISTS `markers_revs`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `ratings`;
DROP TABLE IF EXISTS `rest_logs`;
DROP TABLE IF EXISTS `search_index`;
DROP TABLE IF EXISTS `statuses`;
DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `tweets`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `votes`;
DROP TABLE IF EXISTS `votings`;


CREATE TABLE `attachments` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`model` varchar(255) NOT NULL,
	`foreign_key` varchar(36) DEFAULT '0' NOT NULL,
	`dirname` varchar(255) DEFAULT NULL,
	`basename` varchar(255) NOT NULL,
	`checksum` varchar(255) NOT NULL,
	`alternative` varchar(50) DEFAULT NULL,
	`group` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `bitly_links` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`long_url` varchar(255) NOT NULL,
	`hash` varchar(255) NOT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `long_url` (`long_url`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `categories` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) NOT NULL,
	`lft` int(10) NOT NULL,
	`rght` int(10) NOT NULL,
	`name` varchar(255) NOT NULL,
	`hex` varchar(6) NOT NULL,
	`user_id` varchar(36) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `comments` (
	`id` varchar(36) NOT NULL,
	`marker_id` varchar(36) DEFAULT '0' NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`group_id` varchar(36) NOT NULL,
	`name` varchar(128) DEFAULT NULL,
	`email` varchar(128) NOT NULL,
	`comment` text DEFAULT NULL,
	`status` int(10) DEFAULT 0 NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `configurations` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`key` varchar(255) DEFAULT NULL,
	`title` varchar(128) NOT NULL,
	`description` varchar(1024) NOT NULL,
	`value` text DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `key` (`key`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `districts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`city_id` varchar(36) NOT NULL,
	`name` varchar(100) NOT NULL,
	`lat` float(10,6) DEFAULT '0.000000' NOT NULL,
	`lon` float(10,6) DEFAULT '0.000000' NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	KEY `rating` (`name`, `lat`, `lon`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `groups` (
	`id` varchar(36) NOT NULL,
	`name` varchar(40) NOT NULL,
	`created` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	`modified` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `groups_permissions` (
	`group_id` varchar(36) NOT NULL,
	`permission_id` varchar(36) NOT NULL	)	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `groups_users` (
	`group_id` varchar(36) NOT NULL,
	`user_id` varchar(36) NOT NULL	)	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `markers` (
	`id` varchar(36) NOT NULL,
	`gov_id` int(11) DEFAULT 0 NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`status_id` int(11) DEFAULT 0 NOT NULL,
	`district_id` int(11) DEFAULT NULL,
	`source_id` varchar(36) NOT NULL,
	`subject` varchar(128) NOT NULL,
	`descr` text NOT NULL,
	`category_id` int(11) DEFAULT 0 NOT NULL,
	`street` varchar(128) NOT NULL,
	`zip` varchar(6) NOT NULL,
	`city` varchar(128) NOT NULL,
	`lat` float(10,6) DEFAULT '0.000000' NOT NULL,
	`lon` float(10,6) DEFAULT '0.000000' NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`rating` float(3,1) DEFAULT '0.0',
	`votes` int(11) DEFAULT 1,
	`voting_pro` int(11) DEFAULT 0,
	`voting_con` int(11) DEFAULT 0,
	`voting_abs` int(11) DEFAULT 0,
	`feedback` int(4) NOT NULL,
	`media_url` varchar(255) NOT NULL,
	`event_start` varchar(11) DEFAULT NULL,
	`event_end` varchar(11) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `processcat_id` (`status_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `markers_revs` (
	`id` varchar(36) NOT NULL,
	`version_id` int(11) NOT NULL AUTO_INCREMENT,
	`version_created` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	`gov_id` int(11) DEFAULT 0 NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`status_id` int(11) DEFAULT 0 NOT NULL,
	`district_id` int(11) DEFAULT NULL,
	`source_id` varchar(36) NOT NULL,
	`subject` varchar(128) NOT NULL,
	`descr` text NOT NULL,
	`category_id` int(11) DEFAULT 0 NOT NULL,
	`street` varchar(128) NOT NULL,
	`zip` varchar(6) NOT NULL,
	`city` varchar(128) NOT NULL,
	`lat` float(10,6) DEFAULT '0.000000' NOT NULL,
	`lon` float(10,6) DEFAULT '0.000000' NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`rating` float(3,1) DEFAULT '0.0',
	`votes` int(11) DEFAULT 0,
	`voting_pro` int(11) DEFAULT 0,
	`voting_con` int(11) DEFAULT 0,
	`voting_abs` int(11) DEFAULT 0,
	`feedback` int(4) NOT NULL,
	`media_url` varchar(255) NOT NULL,	PRIMARY KEY  (`version_id`),
	KEY `processcat_id` (`status_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `permissions` (
	`id` varchar(36) NOT NULL,
	`name` varchar(40) NOT NULL,
	`created` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	`modified` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `profiles` (
	`id` varchar(36) NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`published` int(4) DEFAULT 0 NOT NULL,
	`newsletter` int(4) DEFAULT 0 NOT NULL,
	`community` int(4) DEFAULT 0 NOT NULL,
	`nickname` varchar(128) NOT NULL,
	`prename` varchar(127) NOT NULL,
	`sirname` varchar(128) NOT NULL,
	`fon` varchar(20) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `ratings` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` varchar(36) NOT NULL,
	`model_id` varchar(36) NOT NULL,
	`model` varchar(100) NOT NULL,
	`rating` int(2) DEFAULT 0 NOT NULL,
	`name` varchar(100) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `rating` (`model_id`, `model`, `rating`, `name`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `rest_logs` (
	`id` int(20) NOT NULL AUTO_INCREMENT,
	`class` varchar(40) NOT NULL,
	`username` varchar(40) NOT NULL,
	`controller` varchar(40) NOT NULL,
	`action` varchar(40) NOT NULL,
	`model_id` varchar(40) NOT NULL,
	`ip` varchar(16) NOT NULL,
	`requested` datetime NOT NULL,
	`apikey` varchar(64) NOT NULL,
	`httpcode` int(3) NOT NULL,
	`error` varchar(255) NOT NULL,
	`ratelimited` tinyint(1) NOT NULL,
	`data_in` text NOT NULL,
	`meta` text NOT NULL,
	`data_out` text NOT NULL,
	`responded` datetime NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `search_index` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`model` varchar(100) DEFAULT NULL,
	`model_id` varchar(36) DEFAULT NULL,
	`data` text DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `association_key` (`model`, `model_id`),
	KEY `data` (`data`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `statuses` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`hex` varchar(6) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `tickets` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`hash` varchar(255) DEFAULT NULL,
	`data` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`expires` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `hash` (`hash`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `transactions` (
	`id` varchar(36) NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`name` varchar(255) DEFAULT NULL,
	`marker_id` varchar(36) NOT NULL,
	`status_id` varchar(2) NOT NULL,
	`controller` varchar(16) NOT NULL,
	`action` varchar(16) NOT NULL,
	`ip` varchar(16) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `tweets` (
	`id` varchar(36) NOT NULL,
	`tw_hashtag` varchar(32) DEFAULT NULL,
	`tw_id` int(20) DEFAULT NULL,
	`tw_lang` varchar(2) DEFAULT NULL,
	`tw_source` varchar(255) DEFAULT NULL,
	`tw_text` varchar(160) DEFAULT NULL,
	`tw_created_at` varchar(64) DEFAULT NULL,
	`tw_to_user_id` int(20) DEFAULT NULL,
	`tw_to_user` varchar(32) DEFAULT NULL,
	`tw_from_user_id` int(20) DEFAULT NULL,
	`tw_from_user` varchar(32) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `tw_id` (`tw_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users` (
	`id` varchar(36) NOT NULL,
	`email_address` varchar(127) NOT NULL,
	`password` varchar(40) NOT NULL,
	`active` int(4) DEFAULT 0 NOT NULL,
	`nickname` varchar(128) NOT NULL,
	`prename` varchar(127) NOT NULL,
	`sirname` varchar(128) NOT NULL,
	`fon` varchar(20) NOT NULL,
	`facebook_id` varchar(16) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `votes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`voting_id` int(11) DEFAULT 0 NOT NULL,
	`user_id` varchar(36) NOT NULL,
	`option` int(11) DEFAULT 0 NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `votings` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model_id` varchar(36) DEFAULT '0' NOT NULL,
	`model` varchar(255) NOT NULL,
	`name` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

