<?php
/**
 * Mark-a-Spot Users Controller
 *
 * Auth Login, Logout, Lost Passwords
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4 beta 
 */

class UsersController extends AppController {
	var $name = 'Users';
	var $uses = array('User', 'Groups_user', 'Ticket', 'Marker', 'Comment', 'Rating');
	
	var $helpers = array('Form', 'Html', 'Javascript', 'JsValidate.Validation');
	var $components = array('RequestHandler', 'Email', 'Cookie', 'Ticketmaster', 'Notification');
	
	//var $scaffold;

	
	
	/**
	 *  Login User 
	 *
	 */	
	function login() {
		if($this->Session->check('FB')) {
				$this->Session->setFlash(__(
						'You signed in successfully with your Facebook account',true), 'default', array(
							'class' => 'flash_success'));

		}
		$this->set('title_for_layout', __('Log in',true));
		$this->layout = 'default_page'; 
		
		// Remember User if Checkbox checked.
		if (!empty($this->data) && $this->data['User']['remember_me']) {
			$cookie = array();
			$cookie['username'] = $this->data['User']['username'];
			$cookie['password'] = $this->data['User']['password'];
			$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
			unset($this->data['User']['remember_me']);
		}
	}
	
	/**
	 *  Signup User apart from startup-method in markers_controller 
	 *
	 */
	function signup() {
		$this->layout = 'default_page'; 
		$this->set('title_for_layout', __('Sign up',true));
		if (!empty($this->data)) {
			if ($this->MathCaptcha->validates($this->data['User']['security_code'])) {

				if (isset($this->data['User']['passwd'])) {
						$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);
				}

				// move user into their group
				 
			 	$this->data['Group']['id'] = Configure::read('userGroup.users');
				$this->data['User']['active'] = 1;

				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__(
						'Great, you signed up successfully. Please check your Mail.',true), 'default', array(
							'class' => 'flash_success'));

					// The ID of the newly created user has been set
					// as $this->User->id.
					$this->data['Profile']['user_id'] = $this->User->id;

					// Because our User hasOne Profile, we can access
					// the Profile model through the User model:
					$this->User->Profile->save($this->data);

					// send confirmation Mail
					$recipient = $this->data['User']['email_address'];		
					$bcc[]="";
					$this->Notification->sendMessage("welcome_user", $this->Marker->id, $this->data['User']['nickname'], $recipient, $bcc);
					// authorize and redirect in 
					$this->Auth->login(); 
					$this->redirect(array('controller' => 'markers', 'action'=>'add'));	
			} else {
				$this->Session->setFlash(__('We could&rsquo;nt sign up your account!',true), 
												'default', 
												array('class' => 'flash_error'));
				//$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

				$this->data['User']['passwd'] = null;
				$this->data['User']['password'] = null;
			}
			} else {
				$this->Session->setFlash(__(
					'Sorry, you are wrong, please recalculate.',true), 'default', array(
						'class' => 'flash_error'));
				$this->data['User']['passwd'] = null;
				$this->data['User']['password'] = null;
			}
		
			
		
		}
		
		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	}
	
	
	/**
	 *  Confirm User after startup
	 *
	 */
	function confirm($id) { 
			$this->User->id = $id;
			$this->data = $this->User->read(null, $id);
						
			/**
			 * User Bann if banned already
			 *
			 */
			switch ($this->data['User']['active']) {
				case 3:
					exit;
				case 1:
					$this->Session->setFlash(__('You are already confirmed as user.',true), 
													'default',
													array('class' => 'flash_success'));
					$this->redirect(array('controller' => 'markers', 'action'=>'preview', $this->params['pass'][1]));
				break;
			}
			if ($this->data['User']['active'] == 3) {
				exit;
			} else
			 
			if ($this->User->saveField('active', 1)) {
				
				$this->Marker->id = $this->params['pass']['1'];
				$this->Marker->saveField('status_id',1);
				$this->Session->setFlash(__('You are now confirmed as user.',true),
					'default', array('class' => 'flash_success'));

				$this->Auth->login($this->data);
				
				// send confirmation Mail with Username Link
				// plus preview_link
				$bcc[]="";
				$recipient = $this->data['User']['email_address'];
				$this->Notification->sendMessage("userdata", null, $this->data['User']['nickname'], $recipient, $bcc);

				$this->redirect(array('controller' => 'markers', 
										'action'=>'preview', 
										$this->params['pass'][1]));
 
				

			} else {
				$this->Session->setFlash(__('This User does not exist',true), 
											'default', 
											array('class' => 'flash_error'));
			}
	} 

	/**
	 *  user's log out
	 *
	 */
	function logout() {

		$this->Session->destroy();
		if ($this->Session->read('goodbye')) {
			$this->Session->setFlash(__(
				'Your userdata and all markers have been deleted.', true), 
				'default', 
				array(
					'class' => 'flash_success')
				);
			} else {
			$this->Session->setFlash(__(
				'You logged out successfully', true), 
					'default', 
				array(
					'class' => 'flash_success')
			);
		}
		$this->redirect($this->Auth->logout());
	}



   	/**
   	 *  Reset Password
   	 *  based on Code from 
   	 *  http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */
	 
	function resetpassword($email=null) {
		$this->set('title_for_layout', __('Lost Password',true));
		$this->layout = 'default_page'; 
		if (!empty($this->data['User']['email'])) {
			if ($this->MathCaptcha->validates($this->data['User']['security_code'])) {
				$email = $this->data['User']['email'];
				$account=$this->User->findByEmailAddress($email);

				if (!isset($account['User']['email_address'])) {
					$this->Session->setFlash(__('We could not find your e-mail', true), 
													'default', 
													array('class' => 'flash_error'));
					$this->redirect($this->referer());
					return false;
				}


				// send  Mail with token
				
				$recipient = $email;		
				$bcc[]="";
				$this->Notification->sendMessage("resetpw", $this->Marker->id, $nickname=null, $recipient, $bcc);
					    
				// save ticket
			
				$data['Ticket']['hash']= $this->Session->read('hashyToken');
				$data['Ticket']['data'] =$email;
				$data['Ticket']['expires'] =$this->Ticketmaster->getExpirationDate();
		
				if ($this->Ticket->save($data)) {
					$this->Session->setFlash(__('Please check your mail to receive more details.',true), 
													'default', 
													array('class' => 'flash_success'));
					$this->redirect('/');
				} else {
				
					$this->Session->setFlash(__('The ticket could not be sent.',true), 
													'default', 
													array('class' => 'flash_flash_error'));
					$this->redirect('/');
	
				}
			} else {
				$this->Session->setFlash(__(
					'Sorry, you are wrong, please recalculate.',true), 'default', array(
						'class' => 'flash_error'));
				$this->data['User']['passwd'] = null;
				$this->data['User']['password'] = null;
			}
		
		}
		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

 
	}

    /**
   	 *  Check ticket hash
   	 *  based on Code from 
   	 *  http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */	
 
	function useticket($hash) {
		//purge all expired tickets
		//built into check
		$results=$this->Ticketmaster->checkTicket($hash);
		if ($results) {
			//now pull up mine IF still present
			$passTicket=$this->User->findByEmailAddress($results['Ticket']['data']);
			$this->Ticketmaster->voidTicket($hash);
			$this->Session->write('tokenreset',$passTicket['User']['id']);
			$this->Session->setFlash(__('Now enter your new password below.', true), 
											'default', 
											array('class' => 'flash_success'));
			$this->redirect('/users/newpassword/'.$passTicket['User']['id']);
		}else{
			$this->Session->setFlash(__('Your ticket is no longer available.', true), 
											'default', 
											array('class' => 'flash_error'));
			$this->redirect('/');
		}
 
	}
 
    /**
   	 *  Get new password after ticket confirmation by e-mail
   	 *  based on Code from 
   	 *  http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */
	 
	function newpassword($id = null) {

		$this->set('title_for_layout', __('Enter new Password',true));
		$this->layout = 'default_page'; 
		if (!$this->Session->check('tokenreset')) {
			$this->Session->setFlash('banned!?');
			$this->redirect('/');
		}
 
		if (empty($this->data)) {
			if ($this->Session->check('tokenreset')) 
				$id=$this->Session->read('tokenreset');
				
			if (!$id) {
				$this->Session->setFlash('Invalid id for User');
				$this->redirect('/');
			}
			$this->data = $this->User->read(null, $id);
			$this->data['User']['passwd'] =null;
			$this->data['User']['password'] =null;
		} else {				
			$this->data['User']['id'] =$id;
 			if (isset($this->data['User']['passwd']))
					$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);

			$this->User->id = $id;
			if ($this->User->saveField('password', $this->data['User']['passwdhashed'],$validate = false)) {
				//delete session token and delete used ticket from table
				$this->Session->delete('tokenreset');
				$this->Session->setFlash(__('Your password has been changed',true) , 
												'default', 
												array('class' => 'flash_success'));
				$this->redirect('/');
			} else {
				$this->Session->setFlash(__('Your password could not be changed.',true), 
												'default', 
												array('class' => 'flash_error'));
			}
		}
	}

    /**
   	 *  delete user, all his data and send him to logout
   	 *  
	 */	
	 
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('We could not find this user.',true), 
											'default', 
											array('class' => 'flash_error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id, $cascade = true)) {
			$this->Session->write('goodbye',true);
			$this->Session->setFlash(__('This User and all his data has been deleted', true), 
											'default', 
											array('class' => 'flash_success'));
			$this->redirect(array('action'=>'logout'));
		}
	
	}




    /**
   	 *  Admin Actions for User administration
   	 *  
	 */	
	function admin_index() {
	
		$this->layout = 'default_page'; 
		$this->set('title_for_layout', 'Admin Users');
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		$this->set('title_for_layout', 'View User');
		$this->layout = 'default_page';
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

}
?>