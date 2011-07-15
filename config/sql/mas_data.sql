--
-- Host: localhost
-- Erstellungszeit: 20. Mai 2011 um 12:37
-- Server Version: 5.1.44
-- PHP-Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



#INSERT INTO `categories` VALUES(1, 0, 3, 4, 'Cans left out 24/7', 'Garbage or recycling cans that have been left out for more than 24 hours after collection. Violators will be cited.', 0, 'realtime', '6fb003', 'lorem, ipsum, dolor', 'street', '');
#INSERT INTO `categories` VALUES(2, 0, 1, 2, 'Street light broken', '', 0, 'realtime', 'ccddaa', 'street, light, safety, darkness', 'street', '');
--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` VALUES(1, 0, 7, 8, 'Umweltverschmutzung', '', 0, '', '6fb003', '', '', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(28, 0, 13, 14, 'Vandalismus', '', 0, '',  'ccddaa',  '', '', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(34, 0, 15, 16, 'Sonstiges', '', 0, '',   'AA5225', '', '', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(29, 0, 11, 12, 'Tiere und Ungeziefer', '', 0, '',   'ff00bb', '', '', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(24, 0, 3, 6, 'Verkehrsgefährdung', '', 0, '',   '287fbd', '', '',  '4c5aaa5c-c878-4f94-8085-039b510ab7ac');
INSERT INTO `categories` VALUES(30, 0, 1, 2, 'Lärm', '', 0, '',   '235f9b', '', '',  '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `categories` VALUES(32, 0, 9, 10, 'Barriere',  '', 0, '',  '660000', '', '', '4ae49e52-68d8-4d9f-927e-217d510ab7ac');


--
-- Daten für Tabelle `configurations`
--

INSERT INTO `configurations` VALUES(1, 'Site.name', 'Name of the Site (used in E-Mails)', 'Could be "fixmystreet london". Key is used in E-Mails', 'placeceholderDB www.markaspot.de', '2011-05-11 13:37:47', '2011-05-11 13:37:47');
INSERT INTO `configurations` VALUES(2, 'Publish.Markers', 'Publish Markers directly after posting', 'Markers will be hidden as "New unpublished Marker"', '0', '2011-05-11 13:40:01', '2011-05-11 13:40:21');
INSERT INTO `configurations` VALUES(3, 'Publish.Comments', 'Publish Comments directly after posting', 'Comments will need moderation and will only be visible for administrators', '0', '2011-05-11 13:41:25', '2011-05-18 16:18:49');
INSERT INTO `configurations` VALUES(4, 'Publish.EMail', 'Show user''s e-mail adresses in Views', '', '0', '2011-05-11 13:50:39', '2011-05-21 05:48:25');
INSERT INTO `configurations` VALUES(5, 'Publish.Feedback', 'Standard Feedback Action', '1:Range Rating, 2: Voting, 0:Keine', '1', '2011-05-11 13:51:25', '2011-05-21 05:47:28');
INSERT INTO `configurations` VALUES(6, 'Social.Twitter', 'Twitter Login available', 'People may log in via Twitter', '1', '2011-05-11 13:52:32', '2011-05-12 09:31:51');
INSERT INTO `configurations` VALUES(7, 'Social.FB', 'Facebook Login available', 'People may log in via Facebook API', '1', '2011-05-11 13:52:47', '2011-05-12 09:28:09');
INSERT INTO `configurations` VALUES(8, 'Social.Message', 'Twitter Message String', 'Tweet string for Update-Twitter messages', 'Bürgeranliegen bearbeitet', '2011-05-11 13:52:58', '2011-05-12 09:31:23');
INSERT INTO `configurations` VALUES(9, 'js.Basic.City', 'Label: City (Javascript)', 'Where is the starting point for new markers', 'Brühl', '2011-05-18 16:19:55', '2011-05-19 03:36:07');
INSERT INTO `configurations` VALUES(10, 'js.Basic.Zip', 'Label: zip (Javascript)', 'Where is the starting point for new markers', '50321', '2011-05-19 03:34:47', '2011-05-19 03:36:36');
INSERT INTO `configurations` VALUES(11, 'js.Basic.Street', 'Label: street (Javascript)', 'Where is the starting point for new markers', 'Clemens-August-Straße', '2011-05-19 11:49:29', '2011-05-19 11:50:10');
INSERT INTO `configurations` VALUES(12, 'js.Basic.CityCenter', 'Label: Lat-Lon Center', 'Where is the starting point for new markers. You may take a look at http://www.latlon.com for investigating', '50.9403631,6.9584923', '2011-05-20 07:26:31', '2011-05-21 05:41:32');
INSERT INTO `configurations` VALUES(13, 'js.Text.NotCountry', 'Label: message: This point is not in xy', '', 'Dieser Punkt liegt nicht in Deutschland', '2011-05-20 07:27:30', '2011-05-20 07:27:30');
INSERT INTO `configurations` VALUES(14, 'js.Text.NotCity', 'Label: This point is not located in Mas-City', '', 'Dieser Punkt liegt nicht in Brühl', '2011-05-20 07:28:08', '2011-05-20 07:28:08');
INSERT INTO `configurations` VALUES(15, 'js.Text.NewAdress', 'Label: New Position', '', 'Neue Position', '2011-05-20 07:28:28', '2011-05-20 07:28:28');
INSERT INTO `configurations` VALUES(16, 'js.Text.NoMarkers', 'Label: "No Markers in this category"', '', 'Keine Beiträge in dieser Kategorie', '2011-05-20 07:28:57', '2011-05-20 07:28:57');
INSERT INTO `configurations` VALUES(17, 'js.Infwin.TabCommon', 'Label: "Common"', '', 'Allgemein', '2011-05-20 07:29:51', '2011-05-20 07:29:51');
INSERT INTO `configurations` VALUES(18, 'js.Infwin.TabDetail', 'Label: "Description"', '', 'Beschreibung', '2011-05-20 07:30:28', '2011-05-20 07:30:28');
INSERT INTO `configurations` VALUES(19, 'js.Infwin.TabAdmin', 'Label: "Administration"', '', 'Administration', '2011-05-20 07:30:54', '2011-05-20 07:30:54');
INSERT INTO `configurations` VALUES(20, 'js.Infwin.TabCommonSubject', 'Label: "title"', '', 'Worum geht''s', '2011-05-20 07:31:28', '2011-05-20 07:31:28');
INSERT INTO `configurations` VALUES(21, 'js.Infwin.TabCommonCategory', 'Label: "Category"', '', 'Kategorie', '2011-05-20 07:32:08', '2011-05-20 07:32:08');
INSERT INTO `configurations` VALUES(22, 'js.Infwin.TabCommonStatus', 'Label: "Status"', '', 'Status', '2011-05-20 07:32:31', '2011-05-20 07:32:31');
INSERT INTO `configurations` VALUES(23, 'js.Infwin.TabCommonRating', 'Label: "Rating"', '', 'Bewertung', '2011-05-20 07:32:46', '2011-05-20 07:32:46');
INSERT INTO `configurations` VALUES(24, 'js.Infwin.TabCommonDetails', 'Label: "Details"', '', 'Details zu diesem Beitrag', '2011-05-20 07:33:06', '2011-05-20 07:33:06');
INSERT INTO `configurations` VALUES(25, 'js.Infwin.TabCommonNewDescr', 'Label: "Add new Marker here"', '', 'Hier neuen Beitrag schreiben', '2011-05-20 07:33:35', '2011-05-20 07:33:35');
INSERT INTO `configurations` VALUES(26, 'js.Infwin.TabCommonLinkText', 'Label: "Click for details"', '', 'Zu den Details', '2011-05-20 07:33:55', '2011-05-20 07:33:55');
INSERT INTO `configurations` VALUES(27, 'js.Sidebar.h3Views', 'Label: "Display"', 'h3-header in Map view ', 'Anzeige', '2011-05-20 07:34:47', '2011-05-20 07:34:47');
INSERT INTO `configurations` VALUES(28, 'js.Sidebar.h3Search', 'Label: "Search"', 'h3-header in Map view ', 'Suche', '2011-05-20 07:35:00', '2011-05-20 07:35:00');
INSERT INTO `configurations` VALUES(29, 'js.Sidebar.ViewsLabelCategory', 'Map Sidebar (Choose View)', 'Category Checkbox in Map view ', 'Category','2011-05-20 07:35:28', '2011-05-20 07:35:28');
INSERT INTO `configurations` VALUES(30, 'js.Sidebar.ViewsLabelStatus', 'Map Sidebar (Choose View)', 'Status Checkbox in Map view ', 'Status', '2011-05-20 07:35:52', '2011-05-20 07:35:52');
INSERT INTO `configurations` VALUES(31, 'js.Sidebar.ViewsLabelRatings', 'Map Sidebar (Choose View)', 'Rating Checkbox in Map view ', 'Bewertung', '2011-05-20 07:36:16', '2011-05-20 07:36:16');
INSERT INTO `configurations` VALUES(32, 'js.Sidebar.ViewsList', '', '', 'Tabellenansicht', '2011-05-20 07:36:47', '2011-05-20 07:36:47');
INSERT INTO `configurations` VALUES(33, 'js.Url.ControllerActionAdmin', 'Action of AdminRouting', '', 'admin', '2011-05-20 07:37:28', '2011-05-20 07:37:28');
INSERT INTO `configurations` VALUES(34, 'js.Url.ControllerActionMap', 'Action for Map-View', '', 'karte', '2011-05-20 07:37:51', '2011-05-20 07:37:51');
INSERT INTO `configurations` VALUES(35, 'js.Url.ControllerActionAdd', 'Action for adding markers', '', 'add', '2011-05-20 07:38:05', '2011-05-20 07:38:05');
INSERT INTO `configurations` VALUES(36, 'js.Url.ControllerActionStartup', 'Action for adding markers (startup)', '', 'startup', '2011-05-20 07:38:21', '2011-05-20 07:38:21');
INSERT INTO `configurations` VALUES(37, 'js.Url.ControllerActionView', 'Action for view marker', '', 'view', '2011-05-20 07:38:36', '2011-05-20 07:38:36');
INSERT INTO `configurations` VALUES(38, 'js.Url.ControllerActionEdit', 'Action for edit marker', '', 'edit', '2011-05-20 07:38:49', '2011-05-20 07:38:49');
INSERT INTO `configurations` VALUES(39, 'js.masDir', 'Installed MaS in a subdirectory?', 'if true, value would be "subdirectory/"', '/', '2011-05-20 08:32:16', '2011-05-20 08:32:16');
INSERT INTO `configurations` VALUES(40, 'js.Text.FoundYou', '', '', 'gotcha', '2011-05-20 08:36:10', '2011-05-20 08:36:10');
INSERT INTO `configurations` VALUES(41, 'js.Sidebar.SearchLabel', 'Search for Place', '', 'Nach Ort suchen', '2011-05-20 09:23:58', '2011-05-20 09:23:58');
INSERT INTO `configurations` VALUES(42, 'js.Common.searchLabelContent', '', 'deprecated', 'in Hinweisen suchen', '2011-05-20 09:24:27', '2011-05-20 09:24:27');
INSERT INTO `configurations` VALUES(43, 'js.Common.searchSubmitValueLoc', 'Search Place', 'deprecated', 'Ort suchen', '2011-05-20 09:25:10', '2011-05-20 09:25:10');
INSERT INTO `configurations` VALUES(44, 'js.Common.searchSubmitValueMarker', 'Search Marker', 'deprecated', 'Hinweis suchen', '2011-05-20 09:25:34', '2011-05-20 09:25:34');
INSERT INTO `configurations` VALUES(45, 'js.Common.searchQValueMarker', '', 'deprecated', 'Schlagloch', '2011-05-20 09:26:00', '2011-05-20 09:26:00');
INSERT INTO `configurations` VALUES(46, 'js.Common.searchQValueLoc', 'Value of Input-Field (Search place)', 'Choose a typical Streetname in approriate town', 'Glockengasse', '2011-05-20 09:26:23', '2011-05-20 09:26:23');
INSERT INTO `configurations` VALUES(47, 'js.Common.searchMap', 'Map View Url', '', 'karte', '2011-05-20 09:26:51', '2011-05-20 09:26:51');
INSERT INTO `configurations` VALUES(48, 'js.Common.searchSearch', '', 'deprecated', 'search', '2011-05-20 09:27:11', '2011-05-20 09:27:11');
INSERT INTO `configurations` VALUES(49, 'js.Common.commentPublish', 'Button-label publish comment', 'Marker-Administration', 'veröffentlichen', '2011-05-20 09:27:50', '2011-05-20 09:27:50');
INSERT INTO `configurations` VALUES(50, 'js.Common.commentHide', 'Button-label hide comment', 'Marker-Administration', 'verstecken', '2011-05-20 09:30:35', '2011-05-20 09:30:35');
INSERT INTO `configurations` VALUES(51, 'js.Common.commentDelete', 'Button-label delete comment', 'Marker-Administration', 'Löschen', '2011-05-20 09:34:05', '2011-05-20 09:34:05');
INSERT INTO `configurations` VALUES(52, 'js.test.test', 'TestWert', 'Wir testen den Aufbau der Konfiguration', '3', '2011-05-20 17:31:38', '2011-05-20 17:31:38');
INSERT INTO `configurations` VALUES(53, 'Logging.ip', 'Logging IP-Addresses', 'Log IPs in every Transcaction', '0', '2011-05-20 18:49:29', '2011-05-20 18:59:08');
INSERT INTO `configurations` VALUES(54, 'Site.domain', 'Website Domain', 'without http, prefix und suffix ', 'maslocal', '2011-05-21 05:23:11', '2011-05-21 05:23:11');
INSERT INTO `configurations` VALUES(55, 'Site.admin.name', 'Admin-name', 'E-Mail (Sender name)', 'Mas-City Administration', '2011-05-21 05:25:14', '2011-05-21 05:25:14');
INSERT INTO `configurations` VALUES(56, 'eMail.welcome_user.subject', 'E-Mail Subject Welcome Mail', '', 'Willkommen beim Bürgeranliegen MaS-City', '2011-05-21 05:33:04', '2011-05-21 05:33:04');
INSERT INTO `configurations` VALUES(57, 'eMail.markeradd.subject', 'Subject Confirm Mail', 'Bestätigungsmail Eingang eines Beitrages', 'Vielen Dank für Ihren Beitrag', '2011-05-21 05:36:17', '2011-05-21 05:36:17');
INSERT INTO `configurations` VALUES(58, 'eMail.update.subject', 'Subject Update Mail', 'Update an User', 'Ihr Hinweis wurde bearbeitet', '2011-05-21 05:38:01', '2011-05-21 05:38:01');
INSERT INTO `configurations` VALUES(59, 'eMail.userdata.subject', 'Bestätigungsmail Benutzer', '', 'Sie wurden als Benutzer bestätigt', '2011-05-21 05:39:23', '2011-05-21 05:39:23');
INSERT INTO `configurations` VALUES(60, 'eMail.resetpw.subject', 'Passwort Reminder', '', 'Passwort Reset at Mark-a-Spot / Mas-city', '2011-05-21 05:40:09', '2011-05-21 05:40:09');
INSERT INTO `configurations` VALUES(61, 'eMail.markerinfoadmin.subject', 'Admin Info Mail Subject', '', 'A new Marker at Mark-a-Spot', '2011-05-21 05:41:03', '2011-05-21 05:41:03');
INSERT INTO `configurations` VALUES(62, 'Twitter.Setup', 'Twitter Setup durchführen', 'Setting up Mark-a-Spot, enable this Option to generate Oauth Key und Secret for filling the values in database.php \r\n\r\nthen call http://domain/twitter/connect and connect with Twitter.com', '0', '2011-05-21 05:56:03', '2011-05-21 06:23:30');
INSERT INTO `configurations` VALUES(63, 'Twitter.consumer_key', 'Twitter ConsumerKey', 'Prefilled to use your Site with Mark-a-Spot as TwitterConsumer (Contend will be pusblished at your TwitterAccount with application "Mark-a-Spot")', '5rNDMVOta4N6Plrt2irHg', '2011-05-21 06:21:03', '2011-05-21 06:21:03');
INSERT INTO `configurations` VALUES(64, 'Twitter.consumer_secret', 'Twitter ConsumerSecret', 'Secret to Key', '8E7EoKlaFU3HmiQD8rks0rhaOPYSvlqEice7twB8o', '2011-05-21 06:21:51', '2011-05-21 06:21:51');
INSERT INTO `configurations` VALUES(65, 'Twitter.Screenname', 'Twitter Screenname', 'The account where Updates will be published (must be set up, by calling /twitter/connect', '@devmrkspt', '2011-05-21 06:26:05', '2011-05-21 06:26:05');
INSERT INTO `configurations` VALUES(66, 'Twitter.StatusInitial', 'Twitter Import, initialer Status (statusID) ', 'Status importierter Tweets', '1', '2011-05-21 06:28:34', '2011-05-21 06:31:23');
INSERT INTO `configurations` VALUES(67, 'Twitter.GeoMust', 'Twitter Crowdsourcing GeoEnabled tweets only', 'send automated feedback to accounts without geolocation enabled', '1', '2011-05-21 06:39:10', '2011-05-21 06:39:10');
INSERT INTO `configurations` VALUES(68, 'Twitter.HashGet', 'Twitter Crowdsourcing #hashtag', 'Hashtag to filter within replies (keep empty space if none)', '#fixcity', '2011-05-21 06:42:19', '2011-05-21 06:42:19');
INSERT INTO `configurations` VALUES(69, 'Google.Key', 'Google Maps API Key', '', 'ABQIAAAAzAaa1p0iGUs-Hzx9dW_8KhSyK2h9HThA62ooliu6FXYsW0gKHRTEr3iGzJtpOT1TuKbR8N9MOYMPsA', '2011-05-21 06:51:32', '2011-05-21 06:51:32');
INSERT INTO `configurations` VALUES(70, 'Google.Center', 'Google Center', 'Initial Center LatLon', '50.9403631,6.9584923', '2011-05-21 06:52:23', '2011-05-21 06:52:40');
INSERT INTO `configurations` VALUES(71, 'Gov.town', 'Town', 'This Mark-a-Spot installation starts in:', 'Brühl', '2011-05-21 06:56:51', '2011-05-21 06:56:51');
INSERT INTO `configurations` VALUES(72, 'mas.version', 'Mark-a-Spot Version', 'Don''t change this one', '1.6.0', '2011-05-21 06:58:10', '2011-05-21 06:58:10');
INSERT INTO `configurations` VALUES(73, 'mas.gplAffero', '', '', 'https://github.com/markaspot/mark-a-spot', '2011-05-21 06:58:34', '2011-05-21 06:58:34');
INSERT INTO `configurations` VALUES(74, 'userGroup.admins', 'Admin - UserGroup ', '', '4abe28d5-bab4-4ea0-a696-e930510ab7ac', '2011-05-21 06:59:58', '2011-05-21 06:59:58');
INSERT INTO `configurations` VALUES(75, 'userGroup.sysadmins', 'SysAdmin - UserGroup ', '', '4abba313-d3e8-45be-b5f5-48bb510ab7ac', '2011-05-21 07:00:43', '2011-05-21 07:00:43');
INSERT INTO `configurations` VALUES(76, 'userGroup.users', 'Users - UserGroup ', '', '4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '2011-05-21 07:01:28', '2011-05-21 07:01:28');
INSERT INTO `configurations` VALUES(77, 'Config.language', 'Default-language', 'this needs an appropriate po file in it''s directory', 'deu', '2011-05-21 07:03:25', '2011-05-21 07:03:49');
INSERT INTO `configurations` VALUES(78, 'Facebook.appId', '', '', '138994342805468', '2011-05-21 07:07:44', '2011-05-21 07:07:44');
INSERT INTO `configurations` VALUES(79, 'Facebook.apiKey', '', '', 'a9a02b5036100304e27705b299665b36', '2011-05-21 07:08:15', '2011-05-21 07:08:15');
INSERT INTO `configurations` VALUES(80, 'Facebook.secret', '', '', 'c7b59ca804efef4a6da26cc4e4c8cced', '2011-05-21 07:08:41', '2011-05-21 07:08:41');
INSERT INTO `configurations` VALUES(81, 'Facebook.cookie', '', '', 'true', '2011-05-21 07:09:07', '2011-05-21 07:09:07');
INSERT INTO `configurations` VALUES(82, 'Gov.Zip', 'Valid zip-range', 'Markers'' addresses have to be in that range, comma-separated list', '50321, 50322, 50333', '2011-05-23 19:21:38', '2011-05-23 19:21:43');
INSERT INTO `configurations` VALUES(83, 'Basic.MapApi', 'OSM for OpenStreetMap', 'anything else for GoogleMaps', 'OSM', NULL, NULL);
INSERT INTO `configurations` VALUES(84, 'Site.theme', 'Theme Name', 'files have to be placed in "themed"-directory', '', '2011-05-11 13:37:47', '2011-05-11 13:37:47');
INSERT INTO `configurations` VALUES(85, 'eMail.welcome.subject', 'E-Mail Subject Welcome Mail', '', 'Willkommen beim Bürgeranliegen MaS-City', '2011-05-21 05:33:04', '2011-05-21 05:33:04');
INSERT INTO `configurations` VALUES(86, 'Site.e-mail', 'E-Mail Sender Address', '', 'info@mas-city.com', '2011-05-21 05:33:04', '2011-05-21 05:33:04');
--
-- Daten für Tabelle `districts`
--

INSERT INTO `districts` VALUES(1, '', 'Ehrenfeld', 50.900000, 6.890000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `districts` VALUES(2, '', 'Porz', 50.889999, 7.050000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Daten für Tabelle `groups`
--

INSERT INTO `groups` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', 'System Developers', '2009-09-24 18:49:23', '2010-01-16 11:32:49');
INSERT INTO `groups` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', 'Admins', '2009-09-26 16:44:37', '2010-01-17 06:07:35');
INSERT INTO `groups` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', 'Users', '2009-09-26 16:57:13', '2010-01-16 14:15:08');

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

--
-- Daten für Tabelle `groups_users`
--

INSERT INTO `groups_users` VALUES('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae49e52-68d8-4d9f-927e-217d510ab7ac');
INSERT INTO `groups_users` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ccd99c5-3814-4480-a62f-0215510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cce6ecc-5dd8-4507-9cf1-0665510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cd199a0-7f4c-4737-8773-14ab510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cdfa892-f4bc-4032-b9ff-28d9510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ced7b76-8d90-473e-96e6-910b510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ced7f2e-14c4-4f9d-b2f7-910b510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cee0fb9-72f0-43c6-8059-9755510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cee2b98-c36c-49e8-a0f2-9865510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cee3beb-44e0-416f-bd75-981a510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cee3f83-d7f8-4f08-a5ca-9911510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cf27d4c-5608-48af-8bd1-baf3510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4cf2b53f-2d4c-47f2-af20-bcd7510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d280fde-ac6c-42a8-ab9b-0308510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d25a826-ba7c-4db6-b046-931d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d208765-8d88-4b6c-ab2d-6412510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d1c5e9a-3a1c-4654-ac13-1656510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cee83-90c4-48ed-abe5-61bc510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4ceffb-4f28-41e6-a2a8-61e7510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf33c-8fec-4a03-89b9-61f8510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf605-7544-43a4-8113-6242510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf66e-bbcc-4dcd-bf67-6286510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf778-d084-4df9-9b68-6176510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf79c-f8b4-4202-8491-6287510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf864-1f08-4325-b3a4-623d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cf8b0-e5d4-4fe4-a36a-6219510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cfa5c-3c60-498d-98e1-62ba510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4cfac0-5d14-4e64-99ff-62f3510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4d0621-4e8c-4910-83dd-632e510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4d0e2b-28e0-441b-a41a-62ec510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4d1914-779c-48d6-9716-623d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4e8546-3fdc-4bdf-a31d-7080510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4ee42b-35cc-451e-9fb2-70c1510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4ee54f-0c18-45e7-8388-704a510ab7ac');
INSERT INTO `groups_users` VALUES('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4d4eebf7-4230-4a9d-a33e-7112510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4f7fe7-7300-4e3a-85f3-703d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4f833e-26c0-440a-8e9c-79dd510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4fdcf6-57cc-40d8-814a-7112510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d4ff40b-7264-4842-b8a1-7f68510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500abc-616c-4394-9a8c-7112510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500d40-c730-48a6-a91b-704a510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500e92-32f8-4db8-ad64-8130510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500ed9-aaf8-4221-9467-8164510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500f02-3bc8-4d01-9a00-703d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d500f3c-4a88-4767-92fe-7112510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d581acf-9f8c-4742-8798-9f60510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d5fdd4d-cbe0-4a10-b52c-061d510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d5fe08a-9120-4251-baa6-061c510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d64cb1d-23d0-45d7-bea0-10f3510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d6a59fb-fcf0-4f39-97cf-5349510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d7da6b5-d630-4c67-a3dd-2447510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d7da7fd-08fc-4911-b10f-237a510ab7ac');
INSERT INTO `groups_users` VALUES('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4d7da873-6438-4c2c-8d5a-2443510ab7ac');

--
-- Daten für Tabelle `markers`
--


INSERT INTO `markers` VALUES('4dda2202-76e0-47b8-8fe9-1616e3dcc723', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 2, NULL, '', 'Wilder Müll', '', 1, 'Zum Rodderbruch 9', '50321', 'Brühl', 0, 50.825863, 6.888385, '2011-05-23 08:59:46', '2011-05-23 09:52:33', 0.0, 1, 0, 0, 0, 2, '', NULL, NULL);
INSERT INTO `markers` VALUES('4dd913b7-1370-4176-b01e-05afe3dcc723', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 1, NULL, '', 'Fehlende Baustellensicherung Ubahn', 'An der Ubahn-Haltstelle "Markt" sind die Bauzäune nicht gesichert.', 24, 'Markt', '50321', 'Brühl', 0, 50.828594, 6.904675, '2011-05-22 13:46:31', '2011-05-23 08:58:41', 0.0, 1, 0, 0, 0, 1, '', NULL, NULL);
INSERT INTO `markers` VALUES('4dda24d0-e874-4d73-9e2d-186fe3dcc723', 0, '4cce6ecc-5dd8-4507-9cf1-0665510ab7ac', 1, NULL, '', 'Baustellenlärm vermindern!', 'Bitte sorgen Sie dafür, dass Sonntags nicht gearbeitet wird.', 30, 'Am Römerkanal 24', '50321', 'Brühl', 0, 50.819229, 6.891490, '2011-05-23 09:11:44', '2011-05-23 10:04:45', 0.0, 1, 0, 0, 0, 2, 0, NULL, NULL);
INSERT INTO `markers` VALUES('4dda1202-76e0-47b8-8fe9-1616e3dcc723', 0, '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 1, NULL, '', 'Garbage Collection', '', 2, 'Zum Rodderbruch 9', '50321', 'Brühl', 0, 50.825863, 6.888385, '2011-06-09 20:52:39', '2011-06-09 20:52:39', 0.0, 1, 0, 0, 0, 0, '', NULL, NULL);


--
-- Daten für Tabelle `permissions`
--

INSERT INTO `permissions` VALUES('4abba2fb-c6fc-4007-ae78-437b510ab7ac', '*', '2009-09-24 18:48:59', '2009-09-24 18:48:59');
INSERT INTO `permissions` VALUES('4abe28eb-38a4-46de-bc64-fcd3510ab7ac', 'permissons:*', '2009-09-26 16:44:59', '2010-02-28 14:22:53');
INSERT INTO `permissions` VALUES('4abe291f-d190-4c88-9693-e88e510ab7ac', 'groups:*', '2009-09-26 16:45:51', '2010-02-28 14:22:58');
INSERT INTO `permissions` VALUES('4abe2fdb-2560-4412-aaef-4af9510ab7ac', 'users:edit', '2009-09-26 17:14:35', '2009-10-26 06:14:20');
INSERT INTO `permissions` VALUES('4abe2fe9-9c78-4276-b08d-4bbc510ab7ac', 'users:add', '2009-09-26 17:14:49', '2009-09-26 17:14:49');
INSERT INTO `permissions` VALUES('4ae528c8-4dc8-46f7-bdc5-9348510ab7ac', 'markers:admin_edit', '2009-10-26 05:42:48', '2009-11-06 15:31:48');
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


--
-- Daten für Tabelle `statuses`
--

INSERT INTO `statuses` VALUES(1, 'open', 'cc0000');
INSERT INTO `statuses` VALUES(2, 'open', 'ff6600');
INSERT INTO `statuses` VALUES(3, 'closed', '8fe83b');
INSERT INTO `statuses` VALUES(4, 'abschließend bearbeitet', 'cccccc');
INSERT INTO `statuses` VALUES(0, 'blocked', 'dddddd');

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` VALUES('4deb606b-580c-4a4c-92fc-110a43b3f55a', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', '4abe28d5-bab4-4ea0-a696-e930510ab7ac', 0, 'Administration', 'sysadmin@markaspot.org', 'Die Abfallwirtschaftsbetriebe wurden mit der Beseitigung beauftragt.', 1, '2011-06-05 10:54:35', '2011-06-05 10:54:35');


--
-- Daten für Tabelle `users`
--

INSERT INTO `users` VALUES('4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'sysadmin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 9, 'SysAdmin', '', '', '', '', '2009-10-25 18:35:50', '2010-08-15 16:03:35');
INSERT INTO `users` VALUES('4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'admin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 9, 'Admin', '', '', '', '', '2009-10-25 19:52:02', '2010-12-18 05:02:28');
INSERT INTO `users` VALUES('4cce6ecc-5dd8-4507-9cf1-0665510ab7ac', 'testuser@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 1, 'Testuser', '', '', '', '', '2010-11-01 07:39:56', '2010-11-01 07:39:56');



--
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` VALUES('4dda21c1-ac28-48d1-b688-059be3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag durch Benutzer bearbeitet', '4dd913b7-1370-4176-b01e-05afe3dcc723', '1', 'markers', 'edit', '127.0.0.4', '2011-05-23 08:58:41', '2011-05-23 08:58:41');
INSERT INTO `transactions` VALUES('4dd90e92-8f34-4915-aa8f-0563e3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag angesehen', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', '3', 'markers', 'view', '127.0.0.4', '2011-05-22 13:24:34', '2011-05-22 13:24:34');
INSERT INTO `transactions` VALUES('4dda2156-cdd8-4040-ba90-1615e3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag angesehen', '4dd913b7-1370-4176-b01e-05afe3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 08:56:54', '2011-05-23 08:56:54');
INSERT INTO `transactions` VALUES('4dd913b8-42a4-4586-8ca6-05afe3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Anliegen hinzugefügt', '4dd913b7-1370-4176-b01e-05afe3dcc723', '1', 'markers', 'add', '127.0.0.4', '2011-05-22 13:46:32', '2011-05-22 13:46:32');
INSERT INTO `transactions` VALUES('4dda213a-4524-492e-8d7a-059be3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag angesehen', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', '3', 'markers', 'view', '127.0.0.4', '2011-05-23 08:56:26', '2011-05-23 08:56:26');
INSERT INTO `transactions` VALUES('4dda2142-5c7c-47c4-9cb2-1615e3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag angesehen', '4cc12cfa-4838-4d8d-8e7c-efa8510ab7ac', '3', 'markers', 'view', '127.0.0.4', '2011-05-23 08:56:34', '2011-05-23 08:56:34');
INSERT INTO `transactions` VALUES('4dda2203-5d94-47ff-8c37-1616e3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Anliegen hinzugefügt', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '1', 'markers', 'add', '127.0.0.4', '2011-05-23 08:59:47', '2011-05-23 08:59:47');
INSERT INTO `transactions` VALUES('4dda22d0-5bcc-438c-ac80-1616e3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 09:03:12', '2011-05-23 09:03:12');
INSERT INTO `transactions` VALUES('4dda2308-3ec8-454f-9eb3-186ae3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 09:04:08', '2011-05-23 09:04:08');
INSERT INTO `transactions` VALUES('4dda2398-5cf4-4408-8d43-1616e3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 09:06:32', '2011-05-23 09:06:32');
INSERT INTO `transactions` VALUES('4dda23ce-fb04-4640-9587-1865e3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Anliegen von Verwaltung bearbeitet', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '2', 'markers', 'admin_edit', '127.0.0.4', '2011-05-23 09:07:26', '2011-05-23 09:07:26');
INSERT INTO `transactions` VALUES('4dda24d2-7240-4f04-b6d2-186fe3dcc723', '4cce6ecc-5dd8-4507-9cf1-0665510ab7ac', 'Anliegen hinzugefügt', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'add', '127.0.0.4', '2011-05-23 09:11:46', '2011-05-23 09:11:46');
INSERT INTO `transactions` VALUES('4dda24f1-8438-4112-a74e-186fe3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 09:12:17', '2011-05-23 09:12:17');
INSERT INTO `transactions` VALUES('4dda24fb-9d78-469f-8d4c-186fe3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 09:12:27', '2011-05-23 09:12:27');
INSERT INTO `transactions` VALUES('4dda2e58-88f0-4475-a50b-186ae3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '3', 'markers', 'view', '127.0.0.4', '2011-05-23 09:52:24', '2011-05-23 09:52:24');
INSERT INTO `transactions` VALUES('4dda2e61-7954-45ec-8f03-186ae3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Anliegen-Position korrigiert', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '2', 'markers', 'geosave', '127.0.0.4', '2011-05-23 09:52:33', '2011-05-23 09:52:33');
INSERT INTO `transactions` VALUES('4dda3070-9e54-406b-9a2a-1865e3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', '2', 'markers', 'view', '127.0.0.4', '2011-05-23 10:01:20', '2011-05-23 10:01:20');
INSERT INTO `transactions` VALUES('4dda307d-688c-4c95-9972-1865e3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Beitrag angesehen', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '3', 'markers', 'view', '127.0.0.4', '2011-05-23 10:01:33', '2011-05-23 10:01:33');
INSERT INTO `transactions` VALUES('4dda313d-6e14-4182-9542-186ce3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Anliegen von Verwaltung bearbeitet', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'admin_edit', '127.0.0.4', '2011-05-23 10:04:45', '2011-05-23 10:04:45');
INSERT INTO `transactions` VALUES('4dda30f3-429c-4490-a3f5-186ce3dcc723', '4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'Anliegen von Verwaltung bearbeitet', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'admin_edit', '127.0.0.4', '2011-05-23 10:03:31', '2011-05-23 10:03:31');
INSERT INTO `transactions` VALUES('4dda311d-3724-414a-ae93-186ce3dcc723', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'Beitrag angesehen', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', '1', 'markers', 'view', '127.0.0.4', '2011-05-23 10:04:13', '2011-05-23 10:04:13');



--
-- Daten für Tabelle `attachments`
--

INSERT INTO `attachments` VALUES(1, 'Marker', '4dda2202-76e0-47b8-8fe9-1616e3dcc723', 'img', '4de13041494d2.jpg', '667dcbd982b723c5ab997831a1c071e4', 'realname CC Flickr', 'attachment', '2011-05-28 17:26:25', '2011-05-28 17:26:25');
INSERT INTO `attachments` VALUES(2, 'Marker', '4dda24d0-e874-4d73-9e2d-186fe3dcc723', 'img', '4de130b000e90.jpg', '9d7df6827d5e3bdebcec87d1078e5d02', '', 'attachment', '2011-05-28 17:28:16', '2011-05-28 17:28:16');

