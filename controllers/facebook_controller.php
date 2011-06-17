<?php 
/**
 * Mark-a-Spot TwitterController
 *
 * 
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.4 .6
 */
 

App::import('ConnectionManager','Vendor', 'oauth', array(
	'file' => 'OAuth'.DS.'oauth_consumer.php')
	);


class FacebookController extends AppController { 
	var $name = 'Facebook';
	var $useTable = false;
	
	var $uses = array('Marker');
	
	var $helpers = array(
		'Form', 'Rss', 'Html', 'Javascript', 'Time', 'Text', 'Xml', 'Datum', 
			'JsValidate.Validation', 'Session',
			'Media.Media' => array(
				'versions' => array('s', 'xl')
			)
		);

	var $components = array('Facebook.facebook', 'RequestHandler', 
		'Geocoder', 'Notification','Cookie','TwitterService', 'Transaction');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('connect','callback','index'));
	}
	
	function index() {
	
		App::import('Lib', 'Facebook.FB');
 		//PHP 5.3
		FB::api('/me'); //graph system call to /me
 
		//PHP < 5.3
		$FacebookApi = new FB();
		
	
	}
}