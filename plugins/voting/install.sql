# required #
CREATE TABLE `votings` (
  `id` int(11) NOT NULL auto_increment,
  `model_id` int(11) NOT NULL default '0',
  `model` varchar(255) NOT NULL default '',
  `name` varchar(255) default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

# required #
CREATE TABLE `votes` (
  `id` int(11) NOT NULL auto_increment,
  `voting_id` int(11) NOT NULL default '0',
  `user_id` char(36) NOT NULL default '',
  `option` int(11) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

# optional #
CREATE TABLE `votingdemos` (
  `id` varchar(36) NOT NULL default '',
  `user_id` varchar(100) NOT NULL default '',
  `foo` int(11) NOT NULL default '0',
  `bar` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;