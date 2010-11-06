-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 31. Oktober 2010 um 13:39
-- Server Version: 5.1.44
-- PHP-Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `mas_dev`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `dirname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `basename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alternative` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `attachments`
--

INSERT INTO `attachments` VALUES(1, 'Marker', '4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 'transfer/4cc12eee-aa24-4649-a3cd-f028510ab7ac/img', 'realname_wildermuell.jpg', '667dcbd982b723c5ab997831a1c071e4', 'CC flickr Realname', 'attachment', '2010-10-22 06:27:58', '2010-10-31 11:49:58');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bitly_links`
--

CREATE TABLE `bitly_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `long_url` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `long_url` (`long_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `bitly_links`
--

INSERT INTO `bitly_links` VALUES(1, 'http://maslocal/markers/view/4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 'cHTWF4', '2010-10-22 06:37:18', '2010-10-22 06:37:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `hex` varchar(6) CHARACTER SET utf8 NOT NULL,
  `user_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` VALUES(1, 0, 3, 4, 'Umweltverschmutzung', '6fb003', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(28, 0, 11, 12, 'Vandalismus', 'ccddaa', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(34, 0, 13, 14, 'Sonstiges', 'AA5225', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(29, 0, 9, 10, 'Tiere und Ungeziefer', 'ff00bb', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(24, 0, 5, 6, 'Verkehrsgefährdung', '287fbd', '4c5aaa5c-c878-4f94-8085-039b510ab7ac');
INSERT INTO `categories` VALUES(30, 0, 1, 2, 'Lärm', '235f9b', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(32, 0, 7, 8, 'Barriere', '660000', '4ae49e52-68d8-4d9f-927e-217d510ab7ac');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `marker_id` varchar(36) NOT NULL DEFAULT '0',
  `user_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` int(10) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` VALUES('4cc13080-6230-4e0a-9b65-f028510ab7ac', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', '4cc13080-5a84-4ff4-b46d-f028510ab7ac', '4cc13080-4bac-45b8-8e66-f028510ab7ac', 'Holger Kreis', 'holger@markaspot.org', 'Still waiting for this content to be published', 1, '2010-10-22 06:34:40', '2010-10-22 06:34:40');
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `districts`
--

CREATE TABLE `districts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lat` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `lon` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rating` (`name`,`lat`,`lon`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Daten für Tabelle `districts`
--

INSERT INTO `districts` VALUES(1, '', 'Ehrenfeld', 50.900000, 6.890000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `districts` VALUES(2, '', 'Porz', 50.889999, 7.050000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups`
--

INSERT INTO `groups` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', 'System Developers', '2009-09-24 18:49:23', '2010-01-16 11:32:49');
INSERT INTO `groups` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', 'Admins', '2009-09-26 16:44:37', '2010-01-17 06:07:35');
INSERT INTO `groups` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', 'Users', '2009-09-26 16:57:13', '2010-01-16 14:15:08');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_permissions`
--

CREATE TABLE `groups_permissions` (
  `group_id` char(36) NOT NULL DEFAULT '',
  `permission_id` char(36) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups_permissions`
--

INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae5291b-cde0-4e35-9e95-95f0510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b38c515-8254-4d2d-814c-759950431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae5311d-3e10-4485-9408-98b4510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae528c8-4dc8-46f7-bdc5-9348510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe2fe9-9c78-4276-b08d-4bbc510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe2fdb-2560-4412-aaef-4af9510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe291f-d190-4c88-9693-e88e510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae5291b-cde0-4e35-9e95-95f0510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae528c8-4dc8-46f7-bdc5-9348510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe28eb-38a4-46de-bc64-fcd3510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abba2fb-c6fc-4007-ae78-437b510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4abe2fdb-2560-4412-aaef-4af9510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae5311d-3e10-4485-9408-98b4510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b52af74-4684-45d8-b95e-379850431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b38c515-8254-4d2d-814c-759950431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b3f4da3-e6d0-41df-9091-594750431ca3');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b3f4da3-e6d0-41df-9091-594750431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b744907-b488-4d3e-8da3-599b50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b744907-b488-4d3e-8da3-599b50431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b8a6e76-f874-422b-a9ef-122c50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b8a6e76-f874-422b-a9ef-122c50431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b8a8c4b-8b84-4f66-8483-453a50431ca3');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b8a8c4b-8b84-4f66-8483-453a50431ca3');
INSERT INTO `groups_permissions` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4cb356b1-3174-4d6b-b072-9301510ab7ac');
INSERT INTO `groups_permissions` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4cb356b1-3174-4d6b-b072-9301510ab7ac');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_users`
--

CREATE TABLE `groups_users` (
  `group_id` char(36) NOT NULL DEFAULT '',
  `user_id` char(36) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups_users`
--

INSERT INTO `groups_users` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae49e52-68d8-4d9f-927e-217d510ab7ac');
INSERT INTO `groups_users` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markers`
--

CREATE TABLE `markers` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `gov_id` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `district_id` int(11) DEFAULT NULL,
  `source_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `street` varchar(128) CHARACTER SET utf8 NOT NULL,
  `zip` varchar(6) CHARACTER SET utf8 NOT NULL,
  `city` varchar(128) CHARACTER SET utf8 NOT NULL,
  `lat` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `lon` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `rating` decimal(3,1) unsigned DEFAULT '0.0',
  `votes` int(11) unsigned DEFAULT '1',
  `voting_pro` int(11) unsigned DEFAULT '0',
  `voting_con` int(11) unsigned DEFAULT '0',
  `voting_abs` int(11) unsigned DEFAULT '0',
  `feedback` tinyint(4) NOT NULL,
  `media_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_start` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_end` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `processcat_id` (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `markers`
--

INSERT INTO `markers` VALUES('4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Pothole', 'Deep and filled with water', 1, 'Tel-Aviv-Straße', '50676', 'Köln', 50.928141, 6.955719, '2010-10-22 06:19:38', '2010-10-31 12:37:53', 3.0, 1, 2, 0, 0, 3, '', NULL, NULL);
INSERT INTO `markers` VALUES('4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Waste ready for garbage collection', 'Waiting for months', 1, 'Pfarrer-Moll-Straße 52', '51105', 'Köln', 50.929710, 6.995373, '2010-10-22 06:21:47', '2010-10-31 12:37:49', 3.0, 2, 1, 1, 0, 3, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markers_revs`
--

CREATE TABLE `markers_revs` (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gov_id` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `district_id` int(11) DEFAULT NULL,
  `source_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `descr` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `street` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `zip` varchar(6) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `city` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `lat` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `lon` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `rating` decimal(3,1) unsigned DEFAULT '0.0',
  `votes` int(11) unsigned DEFAULT '0',
  `voting_pro` int(11) unsigned DEFAULT '0',
  `voting_con` int(11) unsigned DEFAULT '0',
  `voting_abs` int(11) unsigned DEFAULT '0',
  `feedback` tinyint(4) NOT NULL,
  `media_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version_id`),
  KEY `processcat_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Daten für Tabelle `markers_revs`
--

INSERT INTO `markers_revs` VALUES('4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 102, '2010-10-31 12:37:49', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Waste ready for garbage collection', 'Waiting for months', 1, 'Theoderichstraße 2', '51105', 'Köln', 50.929710, 6.996170, '2010-10-22 06:21:47', '2010-10-31 12:37:49', 3.0, 2, 1, 1, 0, 3, '');
INSERT INTO `markers_revs` VALUES('4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 103, '2010-10-31 12:37:49', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Waste ready for garbage collection', 'Waiting for months', 1, 'Theoderichstraße 2', '51105', 'Köln', 50.929710, 6.995373, '2010-10-22 06:21:47', '2010-10-31 12:37:49', 3.0, 2, 1, 1, 0, 3, '');
INSERT INTO `markers_revs` VALUES('4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 104, '2010-10-31 12:37:49', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Waste ready for garbage collection', 'Waiting for months', 1, 'Pfarrer-Moll-Straße 52', '51105', 'Köln', 50.929710, 6.995373, '2010-10-22 06:21:47', '2010-10-31 12:37:49', 3.0, 2, 1, 1, 0, 3, '');
INSERT INTO `markers_revs` VALUES('4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 106, '2010-10-31 12:37:53', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Pothole', 'Deep and filled with water', 1, 'Im Dau 10', '50678', 'Köln', 50.928141, 6.955719, '2010-10-22 06:19:38', '2010-10-31 12:37:53', 3.0, 1, 2, 0, 0, 3, '');
INSERT INTO `markers_revs` VALUES('4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 107, '2010-10-31 12:37:53', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Pothole', 'Deep and filled with water', 1, 'Im Dau 10', '50676', 'Köln', 50.928141, 6.955719, '2010-10-22 06:19:38', '2010-10-31 12:37:53', 3.0, 1, 2, 0, 0, 3, '');
INSERT INTO `markers_revs` VALUES('4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 108, '2010-10-31 12:37:53', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 3, NULL, '', 'Pothole', 'Deep and filled with water', 1, 'Tel-Aviv-Straße', '50676', 'Köln', 50.928141, 6.955719, '2010-10-22 06:19:38', '2010-10-31 12:37:53', 3.0, 1, 2, 0, 0, 3, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions`
--

CREATE TABLE `permissions` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `permissions`
--

INSERT INTO `permissions` VALUES('4abba2fb-c6fc-4007-ae78-437b510ab7ac', '*', '2009-09-24 18:48:59', '2009-09-24 18:48:59');
INSERT INTO `permissions` VALUES('4abe28eb-38a4-46de-bc64-fcd3510ab7ac', 'permissons:*', '2009-09-26 16:44:59', '2010-02-28 14:22:53');
INSERT INTO `permissions` VALUES('4abe291f-d190-4c88-9693-e88e510ab7ac', 'groups:*', '2009-09-26 16:45:51', '2010-02-28 14:22:58');
INSERT INTO `permissions` VALUES('4abe2fdb-2560-4412-aaef-4af9510ab7ac', 'users:edit', '2009-09-26 17:14:35', '2009-10-26 06:14:20');
INSERT INTO `permissions` VALUES('4abe2fe9-9c78-4276-b08d-4bbc510ab7ac', 'users:add', '2009-09-26 17:14:49', '2009-09-26 17:14:49');
INSERT INTO `permissions` VALUES('4ae528c8-4dc8-46f7-bdc5-9348510ab7ac', 'markers:admin', '2009-10-26 05:42:48', '2009-11-06 15:31:48');
INSERT INTO `permissions` VALUES('4ae528f7-590c-4f76-ab45-8f33510ab7ac', 'markers:edit', '2009-10-26 05:43:35', '2009-10-31 18:26:34');
INSERT INTO `permissions` VALUES('4ae5291b-cde0-4e35-9e95-95f0510ab7ac', 'markers:add', '2009-10-26 05:44:11', '2010-02-19 05:55:33');
INSERT INTO `permissions` VALUES('4ae529b4-3968-4460-9f0f-95d1510ab7ac', 'markers:delete', '2009-10-26 05:46:44', '2009-10-26 05:46:44');
INSERT INTO `permissions` VALUES('4aec21e0-312c-4909-82b7-9b40510ab7ac', 'markers:ajaxlist', '2009-10-31 12:39:12', '2010-01-26 16:03:11');
INSERT INTO `permissions` VALUES('4ae5311d-3e10-4485-9408-98b4510ab7ac', 'users:index', '2009-10-26 06:18:21', '2010-02-28 14:23:11');
INSERT INTO `permissions` VALUES('4afef661-aa5c-4206-b6d7-c6e5510ab7ac', 'markers:ajaxmylist', '2009-11-14 19:26:41', '2010-01-26 16:02:47');
INSERT INTO `permissions` VALUES('4b52af74-4684-45d8-b95e-379850431ca3', '*:*', '2010-01-17 07:34:28', '2010-01-17 07:34:28');
INSERT INTO `permissions` VALUES('4b38c515-8254-4d2d-814c-759950431ca3', 'markers:geosave', '2009-12-28 15:47:49', '2009-12-28 15:47:49');
INSERT INTO `permissions` VALUES('4b3f0b99-4b70-48f0-8d14-6d3350431ca3', 'markers:undo', '2010-01-02 10:02:17', '2010-01-02 18:09:50');
INSERT INTO `permissions` VALUES('4b3f4da3-e6d0-41df-9091-594750431ca3', 'markers:makeCurrent', '2010-01-02 14:44:03', '2010-01-02 14:44:03');
INSERT INTO `permissions` VALUES('4b5c158b-d88c-4bca-8f64-6e1e50431ca3', 'users:delete', '2010-01-24 10:40:27', '2010-01-24 10:40:27');
INSERT INTO `permissions` VALUES('4b744907-b488-4d3e-8da3-599b50431ca3', 'comments:free', '2010-02-11 19:14:31', '2010-02-11 19:14:31');
INSERT INTO `permissions` VALUES('4b7d12ac-ae98-48ca-8c97-07a750431ca3', 'markers:preview', '2010-02-18 11:13:00', '2010-02-18 11:13:00');
INSERT INTO `permissions` VALUES('4b8a6e76-f874-422b-a9ef-122c50431ca3', 'markers:mylist', '2010-02-28 14:24:06', '2010-02-28 14:24:06');
INSERT INTO `permissions` VALUES('4b8a8c4b-8b84-4f66-8483-453a50431ca3', 'comments:delete', '2010-02-28 16:31:23', '2010-02-28 16:31:23');
INSERT INTO `permissions` VALUES('4cb356b1-3174-4d6b-b072-9301510ab7ac', 'admin:*', '2010-10-11 18:25:53', '2010-10-11 18:25:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profiles`
--

CREATE TABLE `profiles` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `newsletter` tinyint(4) NOT NULL DEFAULT '0',
  `community` tinyint(4) NOT NULL DEFAULT '0',
  `nickname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `prename` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `sirname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `profiles`
--

INSERT INTO `profiles` VALUES('4caac05a-4b58-4c8b-b744-0311510ab7ac', '4c77339f-c508-4f03-9b0b-4470510ab7ac', 0, 0, 0, '', 'Holja', 'Kreis', '1222323', '2010-10-05 06:06:18', '2010-10-05 06:06:18');
INSERT INTO `profiles` VALUES('4caf2d49-9f40-47a9-a79f-583e510ab7ac', '4caf2d49-4a20-42d2-a40d-583e510ab7ac', 0, 0, 0, '', 'aadsasdd', '23424', '', '2010-10-08 14:40:09', '2010-10-08 14:40:09');
INSERT INTO `profiles` VALUES('4cc08222-67c4-4c4e-9a85-deed510ab7ac', '4cc08221-8ed0-4b5f-84dd-deed510ab7ac', 0, 0, 0, '', '', '', '', '2010-10-21 18:10:42', '2010-10-21 18:10:42');
INSERT INTO `profiles` VALUES('4cb48302-d26c-40fd-bd9c-d369510ab7ac', '4cb48302-2440-427e-9a6b-d369510ab7ac', 0, 0, 0, '', '', '', '', '2010-10-12 15:47:14', '2010-10-12 15:47:14');
INSERT INTO `profiles` VALUES('4cb52278-7dcc-4ff1-bad0-b412510ab7ac', '4cb52278-0e4c-4b44-b669-b412510ab7ac', 0, 0, 0, '', '', '', '', '2010-10-13 03:07:36', '2010-10-13 03:07:36');
INSERT INTO `profiles` VALUES('4cb52316-6f08-486e-8419-ec6b510ab7ac', '4cb52316-c994-43cb-b7b2-ec6b510ab7ac', 0, 0, 0, '', '', '', '', '2010-10-13 03:10:14', '2010-10-13 03:10:14');
INSERT INTO `profiles` VALUES('4cbbbdfc-8384-4912-9fe0-0d8a510ab7ac', '4c76bf98-2d0c-4c56-8e28-46ca510ab7ac', 0, 0, 0, '', '', '', '', '2010-10-18 03:24:44', '2010-10-18 03:24:44');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(36) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `model_id` varchar(36) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `model` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `rating` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rating` (`model_id`,`model`,`rating`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `ratings`
--

INSERT INTO `ratings` VALUES(1, '4cc8f707-6078-42ec-b55e-4cdd510ab7ac', '4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 'Marker', 2, 'default', '2010-10-31 10:50:59', '2010-10-31 10:50:59');
INSERT INTO `ratings` VALUES(2, '4cc8f707-6078-42ec-b55e-4cdd510ab7ac', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 'Marker', 3, 'default', '2010-10-31 10:59:23', '2010-10-31 10:59:23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rest_logs`
--

CREATE TABLE `rest_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `model_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `requested` datetime NOT NULL,
  `apikey` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `httpcode` smallint(3) unsigned NOT NULL,
  `error` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ratelimited` tinyint(1) unsigned NOT NULL,
  `data_in` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data_out` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `responded` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `rest_logs`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `search_index`
--

CREATE TABLE `search_index` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `model` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` longtext COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_key` (`model`,`model_id`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Daten für Tabelle `search_index`
--

INSERT INTO `search_index` VALUES(1, 'Marker', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 'Pothole Im Dau 10 50678 Deep and filled with water', '2010-10-22 06:19:38', '2010-10-31 08:40:34');
INSERT INTO `search_index` VALUES(2, 'Marker', '4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 'Waste ready for garbage collection Theoderichstraße 2 51105 Waiting for months', '2010-10-22 06:21:47', '2010-10-31 11:49:58');
INSERT INTO `search_index` VALUES(3, 'Comment', '4cc13080-6230-4e0a-9b65-f028510ab7ac', 'Holger Kreis', '2010-10-22 06:34:40', '2010-10-22 06:34:40');
INSERT INTO `search_index` VALUES(4, 'Comment', '4cc131ce-4850-464b-bf6a-f029510ab7ac', 'SysAdmin', '2010-10-22 06:40:14', '2010-10-22 06:40:14');
INSERT INTO `search_index` VALUES(5, 'Comment', '4ccd1a14-48b0-467d-b5b6-0314510ab7ac', 'SysAdmin', '2010-10-31 07:26:12', '2010-10-31 07:26:12');
INSERT INTO `search_index` VALUES(6, 'Comment', '4ccd1b5a-638c-4219-8ff9-0314510ab7ac', 'dasdas', '2010-10-31 07:31:38', '2010-10-31 07:31:38');
INSERT INTO `search_index` VALUES(7, 'Comment', '4ccd1b84-1454-4554-8757-03f8510ab7ac', 'dasdas', '2010-10-31 07:32:20', '2010-10-31 07:32:20');
INSERT INTO `search_index` VALUES(8, 'Comment', '4ccd2403-2f18-45f8-97e9-0328510ab7ac', 'dasdas', '2010-10-31 08:08:35', '2010-10-31 08:08:35');
INSERT INTO `search_index` VALUES(9, 'Comment', '4ccd247f-36dc-437e-9fb2-03f2510ab7ac', 'dasdas', '2010-10-31 08:10:39', '2010-10-31 08:10:39');
INSERT INTO `search_index` VALUES(10, 'Comment', '4ccd2548-7a28-43bc-8b63-0423510ab7ac', 'dasdas', '2010-10-31 08:14:00', '2010-10-31 08:14:00');
INSERT INTO `search_index` VALUES(11, 'Comment', '4ccd3c60-2238-4a6b-a305-0653510ab7ac', 'SysAdmin', '2010-10-31 09:52:32', '2010-10-31 09:52:32');
INSERT INTO `search_index` VALUES(12, 'Comment', '4ccd3e40-4a1c-4b2f-b756-0423510ab7ac', 'SysAdmin', '2010-10-31 10:00:32', '2010-10-31 10:00:32');
INSERT INTO `search_index` VALUES(13, 'Comment', '4ccd3e44-53c4-4d9f-9693-0423510ab7ac', 'SysAdmin', '2010-10-31 10:00:36', '2010-10-31 10:00:36');
INSERT INTO `search_index` VALUES(14, 'Comment', '4ccd3e78-b430-4f45-b8eb-03f2510ab7ac', 'SysAdmin', '2010-10-31 10:01:28', '2010-10-31 10:01:28');
INSERT INTO `search_index` VALUES(15, 'Comment', '4ccd3e96-fb38-4a7e-a63f-02c0510ab7ac', 'SysAdmin', '2010-10-31 10:01:58', '2010-10-31 10:01:58');
INSERT INTO `search_index` VALUES(16, 'Comment', '4ccd3e98-3f20-4bab-b520-02c0510ab7ac', 'SysAdmin', '2010-10-31 10:02:00', '2010-10-31 10:02:00');
INSERT INTO `search_index` VALUES(17, 'Comment', '4ccd3ec1-6898-4b44-8797-0839510ab7ac', 'SysAdmin', '2010-10-31 10:02:41', '2010-10-31 10:02:41');
INSERT INTO `search_index` VALUES(18, 'Comment', '4ccd3ecf-8874-4178-88a4-0839510ab7ac', 'SysAdmin', '2010-10-31 10:02:55', '2010-10-31 10:02:55');
INSERT INTO `search_index` VALUES(19, 'Comment', '4ccd3ef1-9d7c-4fe4-8222-066d510ab7ac', 'SysAdmin', '2010-10-31 10:03:29', '2010-10-31 10:03:29');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `statuses`
--

CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `hex` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `statuses`
--

INSERT INTO `statuses` VALUES(1, 'unbearbeitet', 'e90e0f');
INSERT INTO `statuses` VALUES(2, 'angenommen', 'ffcc00');
INSERT INTO `statuses` VALUES(3, 'in Bearbeitung', 'ffcc00');
INSERT INTO `statuses` VALUES(4, 'abschließend bearbeitet', '8fe83b');
INSERT INTO `statuses` VALUES(5, 'weitergeleitet', '8fe83b');
INSERT INTO `statuses` VALUES(6, 'archived', 'cccccc');
INSERT INTO `statuses` VALUES(0, 'gesperrt', 'dddddd');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tickets`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE `transactions` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `marker_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` VALUES('4ccd631d-a534-4c5d-b9f2-041e510ab7ac', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Hinweis-Position korrigiert', '4cc12d7b-35bc-423c-ad03-efaa510ab7ac', '3', 'markers', 'geosave', '127.0.0.1', '2010-10-31 12:37:49', '2010-10-31 12:37:49');
INSERT INTO `transactions` VALUES('4ccd6321-c0b4-47b3-a600-041e510ab7ac', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Hinweis-Position korrigiert', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', '3', 'markers', 'geosave', '127.0.0.1', '2010-10-31 12:37:53', '2010-10-31 12:37:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `nickname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `prename` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `sirname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` VALUES('4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'sysadmin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 9, 'SysAdmin', '', '', '', '', '2009-10-25 18:35:50', '2010-08-15 16:03:35');
INSERT INTO `users` VALUES('4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'admin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 9, 'Admin', '', '', '', '', '2009-10-25 19:52:02', '2010-08-17 18:25:21');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voting_id` int(11) NOT NULL DEFAULT '0',
  `user_id` char(36) NOT NULL DEFAULT '',
  `option` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `votes`
--

INSERT INTO `votes` VALUES(1, 1, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 0, '2010-10-31 11:00:13', '2010-10-31 11:00:13');
INSERT INTO `votes` VALUES(2, 2, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 1, '2010-10-31 11:00:36', '2010-10-31 11:00:36');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `votings`
--

CREATE TABLE `votings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` varchar(36) NOT NULL DEFAULT '0',
  `model` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `votings`
--

INSERT INTO `votings` VALUES(1, '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', 'Marker', 'default', '2010-10-31 11:00:13', '2010-10-31 11:00:13');
INSERT INTO `votings` VALUES(2, '4cc12d7b-35bc-423c-ad03-efaa510ab7ac', 'Marker', 'default', '2010-10-31 11:00:36', '2010-10-31 11:00:36');
