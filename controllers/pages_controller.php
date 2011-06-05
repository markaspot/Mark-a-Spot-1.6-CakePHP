<?php
/* SVN FILE: $Id$ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';


	var $helpers = array(
		'Session','Form', 'Rss', 'Html', 'Javascript', 'Time', 
			'Text', 'Xml', 'Datum', 'JsValidate.Validation', 'Htmlcleaner',
				'Media.Media' => array(
					'versions' => array(
					's', 'xl'
				)
			),
		'Csv','Cache'
		);
		
	var $paginate = array( 
		'limit' => 10,
		'contain' => array(
			'Category', 'Status', 'User'),
		'order' => array(
			'Marker.modified' => 'desc')
		);
	var $components = array(
		'Geocoder', 'Cookie', 'Notification', 'Transaction');



/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('Marker', 'Attachment','User');
	
	function beforeFilter() { 
		parent::beforeFilter(); 
		$this->Auth->allow('*'); 
	}
	
	
	 
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function admin_index() {
		// In app_controller we defined this var as "this is an admin"
		
		// Check for admin-access
		if (!$this->Cookie->read('admin')) {
			$this->cakeError('error404');
		} else {
			if (!$this->Session->read('adminDash')) {
				$this->Session->setFlash(sprintf(__('Logged into Admin.',true),
						substr($this->Marker->id, 0, 8)), 'default',array('class' => 'flash_success_modal'));
				$this->Session->write('adminDash', 1);
			}
		}
		$this->layout = 'default_page';
		$this->set('title_for_layout', __('Administration',true));
		
	
		
		$this->set('markers', Sanitize::clean($this->Marker->publish($this->Marker->find('all', array(
			'contain' => array('Category', 'Status', 'User', 'Transaction'),
			'fields' => array('Marker.id', 'Marker.subject', 'Marker.status_id', 'Marker.description', 'Marker.lat', 'Marker.lon', 'Marker.status_id', 'Marker.modified', 'Category.name',
					'Status.id', 'Status.name', 'Category.Hex', 'Status.hex', 'User.nickname'),
			'conditions' => array(
				'Marker.status_id >=' => $this->statusCond),
			//'limit' => '3',
			'order' => 'Marker.modified DESC')))
			)
		);
		
		$attachments = $this->Marker->Attachment->find('all',array(
			'fields' => array (
				'id', 'dirname', 'foreign_key','basename'),
			'order' => 'created DESC',)
			);
		$this->set('attachments', $attachments);
		
		$comments = $this->Marker->Comment->find('all');
		$this->set('comments',$comments);
		
		$statuses = $this->Marker->Status->find('all');
		$this->set('statuses',$statuses);
		
		// call history without views
		$this->set('history', $this->Marker->Transaction->getAdminHistory());

		
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		// check for mobile devices
		if ($this->RequestHandler->isMobile()) {
		// if device is mobile, change layout to mobile
			$this->layout = 'mobile';
		// and if a mobile view file has been created for the action, serve it instead of the default view file
			$mobileViewFile = VIEWS . strtolower($this->params['controller']) . '/mobile/' . $this->params['action'] . '.ctp';
			if (file_exists($mobileViewFile)) {
				$mobileView = strtolower($this->params['controller']) . '/mobile/';
				$this->viewPath = $mobileView;
			}
		} else {
			$this->layout = 'default_page'; 
			$this->set('title_for_layout', __('Add Marker',true));
		}
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
}

?>