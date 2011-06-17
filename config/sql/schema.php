<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2011-05-20 09:05:10 : 1305885070*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 36),
		'dirname' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'basename' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'checksum' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'alternative' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'group' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $bitly_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'long_url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'long_url' => array('column' => 'long_url', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'decription' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'metadata' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'hex' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6),
		'keywords' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 256),
		'group' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $comments = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'marker_id' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'group_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'official' => array('type' => 'boolean', 'null' => false),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128),
		'email' => array('type' => 'string', 'null' => false, 'length' => 128),
		'comment' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $configurations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'key' => array('column' => 'key', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $districts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'city_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'name' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'index'),
		'lat' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'lon' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'rating' => array('column' => array('name', 'lat', 'lon'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $groups = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 40),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $groups_permissions = array(
		'group_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'permission_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $groups_users = array(
		'group_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $markers = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'gov_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'district_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'source_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'subject' => array('type' => 'string', 'null' => false, 'length' => 128),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'street' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'zip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'address_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'lat' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'lon' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'rating' => array('type' => 'float', 'null' => true, 'default' => '0.0', 'length' => '3,1'),
		'votes' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'voting_pro' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'voting_con' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'voting_abs' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'feedback' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'media_url' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'event_start' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11),
		'event_end' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'processcat_id' => array('column' => 'status_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $markers_revs = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'version_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'version_created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'gov_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'district_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'source_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'subject' => array('type' => 'string', 'null' => false, 'length' => 128),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'street' => array('type' => 'string', 'null' => false, 'length' => 128),
		'zip' => array('type' => 'string', 'null' => false, 'length' => 6),
		'city' => array('type' => 'string', 'null' => false, 'length' => 128),
		'address_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'lat' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'lon' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'rating' => array('type' => 'float', 'null' => true, 'default' => '0.0', 'length' => '3,1'),
		'votes' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'voting_pro' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'voting_con' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'voting_abs' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'feedback' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'media_url' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'version_id', 'unique' => 1), 'processcat_id' => array('column' => 'status_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
	var $permissions = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 40),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $profiles = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'newsletter' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'community' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'nickname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'prename' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 127),
		'sirname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'fon' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'model_id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'length' => 100),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'rating' => array('column' => array('model_id', 'model', 'rating', 'name'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $rest_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'class' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'controller' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'action' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'model_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'ip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'requested' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'apikey' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 64),
		'httpcode' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 3),
		'error' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'ratelimited' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'data_in' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'meta' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'data_out' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'responded' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'hex' => array('type' => 'string', 'null' => false, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $tickets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hash' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'unique'),
		'data' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'expires' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hash' => array('column' => 'hash', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $transactions = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'marker_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'status_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2),
		'controller' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'action' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'ip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $tweets = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'tw_hashtag' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'tw_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'tw_lang' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2),
		'tw_source' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'tw_text' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 160),
		'tw_created_at' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64),
		'tw_to_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'tw_to_user' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'tw_from_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'tw_from_user' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'tw_id' => array('column' => 'tw_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $users = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'email_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 127),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'nickname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'prename' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 127),
		'sirname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
		'fon' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'facebook_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $votes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'voting_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'option' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	var $votings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model_id' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 36),
		'model' => array('type' => 'string', 'null' => false),
		'name' => array('type' => 'string', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
?>