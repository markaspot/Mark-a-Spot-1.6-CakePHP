<?php
/**
 * Mark-a-Spot Comments Controller
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
 * @version    1.6.0 
 */


class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript', 'Time', 'JsValidate.Validation');
	var $components = array(
			'RequestHandler', 'Transaction'
			);

	
	function beforeFilter() {
		$this->Auth->allow(array('index', 'commentsadd', 'view'));
	}



	/**
	 *
	 * call comments post from Marker's view
	 *
	 */
	function commentsadd() { 
		if (!empty($this->data)) { 
		// $this->data['Comment']['marker_id'] = $this->data['Comment']['marker_id'];
			
			// publish comments?
			if (!Configure::read('Publish.Comments')) {
				$this->data['Comment']['status'] = 0; 
			} else {
				$this->data['Comment']['status'] = 1;

			}	
			
			// Save GroupId for Admininstrative Comments, else random;
			if ($this->Auth->user('id')){
				$this->data['Comment']['group_id'] = $this->Session->read('userGroup');
				
				if ($this->Session->read('userGroup') == Configure::read('userGroup.admins')) {
					$this->data['Comment']['status'] = 1;
					$this->data['Comment']['user_id'] = $this->Auth->user('id');
				} 
			} else {
				$this->data['Comment']['group_id'] = String::uuid();
				$this->data['Comment']['user_id'] = String::uuid();
			}
			
			if ($this->MathCaptcha->validates($this->data['Comment']['security_code'])) {

				$this->Marker->Comment->create();	
				if ($this->Marker->Comment->save($this->data)) {
	
					// Save Transaction and distinguish case UserGroup
					switch ($this->data['Comment']['status']){
						case 0:
							$this->Session->setFlash(__(
								'This comment has been saved and will be soon published by authorities.',true),
									'default', array('class' => 'flash_success'));
						case 1:

							$this->Transaction->log($this->data['Comment']['marker_id']);
							$this->Session->setFlash(__('This comment has been saved.',true),
								'default', array('class' => 'flash_success'));
					}

					$this->Session->write('formdata',null);
				} else { 
					$this->Session->setFlash(__('This comment could not be saved.',true),
						'default', array('class' => 'flash_error'));
				} 
			} else {
				$this->Session->setFlash(__(
					'Sorry, you are wrong, please recalculate.',true), 'default', array(
						'class' => 'flash_error'));
				$this->Session->write('formdata', $this->data); //save form data for view
			}
		} 
			
		$this->redirect($this->referer(), null, true); 
	} 


	/**
	 *
	 * Action to publish comments by admin. (Ajax Call from "admin")
	 *
	 */
	function free($id = null) {
		$this->layout = 'ajax'; 
		
		if (!$id) {
			$this->Session->setFlash(__('This comment does not exist',true), 'default',
				array('class' => 'flash_error'));
					$this->redirect(array('action'=>'index'));
		} else {
		
			$this->Comment->id = $id;
			$isStatus = $this->Comment->read('status', $id);
			$this->set('isStatus', $isStatus['Comment']['status']);
		
			if ($isStatus['Comment']['status'] == 0) {
				if ($this->Comment->saveField('status', 1, $validate = false));
				
					$marker_id = $this->Comment->read('marker_id', $id);
					$this->Transaction->log($marker_id);

			
			} else {
			
				if ($this->Comment->saveField('status', 0, $validate = false));
				/*
				{
				$marker_id = $this->Comment->read('marker_id', $id);
				$this->Marker->Transaction->saveField('marker_id', $marker_id['Comment']['marker_id']);
				$this->Marker->Transaction->saveField('name', __('Comment blocked',true));
				
			}*/
			}	
		}
	
		if ($this->RequestHandler->isAjax()) { 
			$isStatus = $this->Comment->read('status', $id);
			$this->set('isStatus', $isStatus['Comment']['status']);
		} else {
			$this->set('isStatus', $isStatus['Comment']['status']);
			$this->Session->setFlash(__('Status changed.', true));
			$this->redirect($this->referer(), null, true); 
		}	
	}


	/**
	 *
	 * delete by admin via ajax
	 *
	 */
	function delete($id = null) {
		$this->layout = 'ajax'; 
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Comment', true));
			//$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Comment->delete($id)) {
			//$this->Session->setFlash(__('Comment deleted', true));
			$this->set('delete', 1);
		} else {
			$this->set('delete', 0);
		}
	}


	/**
	 *
	 * edit (only in scaffolding, no view by now
	 *
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid comment', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(__('The comment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.', true));
			}
		}
		
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$markers = $this->Comment->Marker->find('list');
		$this->set(compact('markers'));
	}
	
	
	/**
	 *
	 * index (only in scaffolding, no view by now
	 *
	 */
	function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}
	
	
	/**
	 *
	 * view (only in scaffolding, no view by now
	 *
	 */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}
	
	public function update() {
		if ($this->data) {

			$comment = $this->data['Comment']['comment'];	
			$this->Comment->id = $this->data['Comment']['id'];

			$this->Comment->saveField('comment', $comment);
			$this->set('comment', $comment);

		}
	}


}
?>