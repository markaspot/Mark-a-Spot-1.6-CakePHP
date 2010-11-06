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
		'Session','Form', 'Rss', 'Html', 'Javascript', 'Ajax','Time', 
			'Text', 'Xml', 'Datum', 'JsValidate.Validation', // 'Recaptcha',
				'Media.Media' => array(
					'versions' => array(
					's', 'xl'
				)
			),
		'Csv','Cache'
		);
/*

	var $components = array(
		'RequestHandler', 'Geocoder', 'Cookie', 'Notification'
		)
*/
/**
 * Default helper
 *
 * @var array
 * @access public
 */



/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('Attachment','Transaction');
	
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
		$this->layout = 'default_page';
		
		// In app_controller we defined this var as "this is an admin"
		// Check for admin-access
		if ($this->statusCond != 0) {
			$this->redirect('/karte');
		}
		
		$transactions = $this->Transaction->find('all', array(
			'fields' => array('marker_id', 'id', 'name', 'modified')));
		$this->set('transactions', $transactions);
		
		$attachments = $this->Attachment->find('all');
		$this->set('attachments', $attachments);
		
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$this->layout = 'default_page';
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