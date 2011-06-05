<?php
/**
 * Mark-a-Spot Notification Controller
 *
 * Everything about publishing changes
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 * 
 * based on code by Michael Schneidt
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.4 6.
 */
 
 
 
class NotificationComponent extends Object {

	var $name = 'Notification';
	var $components = array('Email', 'Auth', 'Session');
	var $uses = 'User';

	
	function startup(&$controller) {
		$this->Controller =& $controller;
		$this->Email->replyTo = 'noreply@'.Configure::read('Site.domain');
		$this->Email->from = Configure::read('Site.admin.name').'<'.Configure::read('Site.e-mail').'>';
		$this->Email->sendAs = 'text';
		
		
	}

	/**
	 * createStatus to create status-message for 
	 * twitter, facebook
	 * 
	 */
	 
	 
	function createStatus($markerId) {

		App::import('Helper', 'Text');
		$text = new TextHelper();


		$statusId = $this->Controller->data['Marker']['status_id'];
		//$this->Controller->set('comment', $this->Controller->data['Comment'][0]['comment']);
		$this->Controller->{$this->Controller->modelClass}->Status->recursive = -1;
		$statusmail = $this->Controller->{$this->Controller->modelClass}->Status->read('Name', $statusId);

		// Preparing Bitly.Url shortening
		$sitename = Configure::read('Site.domain');
		$url = "http://".$sitename."/markers/view/".$markerId;

		if ($url !== null) {
			App::Import('Component', 'Bitly');
			$this->Bitly = new BitlyComponent();
			$url = ' '.$this->Bitly->shorten($url);
		} 

		// create tweet from message plus Status plus Url plus hashtags
		$status = Configure::read('Social.Message')." ".$text->truncate($this->Controller->data['Marker']['subject'],50, array(
			'ending' => '... ', 'exact' => false)).' Status: '.
				$statusmail['Status']['Name'].' '.$url.' #markaspot';
		
		return $status;
	
	
	}

	/**
	* Benachrichtigung über eine neue Nachricht versenden.
	* 
	* @param integer $markerId markerId
	* @param string $template elements/email
	* @param string $recipient Empfänger
	*/
	
	function sendMessage($template, $markerId, $nickname, $recipient, $bcc) {

		$sent = false;
		$status = false;
		$tweet = false;
		$this->Email->to = $recipient;
		$this->Email->bcc = $bcc;
		$this->Email->subject = Configure::read('eMail.'.$template.'.subject');
		$this->Email->template = $template;
		$sitename = Configure::read('Site.domain');

		$this->Controller->set('user', $nickname);
		$this->Controller->set('markerId', $markerId);
		$this->Controller->set('sitename', $sitename);

		$hashyToken = md5(date('mdY').rand(2000000,4999999));
		
		// write to session to use it in users_controller
		$this->Session->write('hashyToken', $hashyToken);		
		$this->Controller->set('hashyToken', $hashyToken);



		// Inform Admin about new Marker
		if ($template == "markerinfoadmin") {
			
			$this->Controller->{$this->Controller->modelClass}->Category->recursive = -1;

			$this->Controller->set('category',
				$this->Controller->{$this->Controller->modelClass}->Category->read('Name', 
					$this->Controller->data['Marker']['category_id']));
			$this->Controller->set('description', $this->Controller->data['Marker']['description']);
			$this->Controller->set('subject', $this->Controller->data['Marker']['subject']);
	
		}



		// Set Status Update
		// tweet/fb Note/e-Mail
		if ($template == "update") {

			$statusId = $this->Controller->data['Marker']['status_id'];
			$this->Controller->set('comment', $this->Controller->data['Comment'][0]['comment']);
			$this->Controller->{$this->Controller->modelClass}->Status->recursive = -1;
			$statusmail = $this->Controller->{$this->Controller->modelClass}->Status->read('Name', $statusId);
			$this->Controller->set('status',$statusmail);

			// Facebook or twitter
		
			$uid = explode('@',$recipient);
		
			if (is_numeric($uid[0])) {
				
				$userId = $this->Controller->Marker->field('user_id', array(
					'id' => $markerId)
				);
			
				// check if user is facebook-user 
				$fbUserId = $this->Controller->User->field('facebook_id',array('id' => $userId));
				
				if($fbUserId) {
					
					// not yet
				
				} else {
					/*
					// if userId is from twitter, DirectMessage to user_id
					$response = $this->tweetStatus($markerId, "dm", $uid[0]);
					*/
					// check if user is facebook-user 
					$twitterScreenname = $this->Controller->User->field('nickname',array('id' => $userId));

					$response = $this->tweetStatus($markerId, $method=null, $twitterScreenname);

				}
				
				$sent = true;

			} else {
			
				$sent = false;

			}
		}

		//$this->Controller->set('user', $this->Auth->user('nickname'));
		$this->Controller->set('email', $recipient);

		// Only query User if asked from markers_controller.php
		if ($markerId) {
			$this->Controller->set('userId', $this->Controller->{$this->Controller->modelClass}->User->id);
		}
		

		// Email senden
		if ($sent == false){ 
			if ($this->Email->send()) {
				$sent = true;
			} else {
				$sent = false;
			}
		}
		return $sent;
	}
	


	/**
	 * tweetStatus to create status-message for 
	 * twitter as DM (notify user who logged in via SSO) or
	 * twitter as status_update (notify followers)
	 */
	 
	function tweetStatus($markerId, $method = null, $twUserId = null) {#
	
		// get statusMessage
		$status = $this->createStatus($markerId);

		// Update Twitter->Status if checkbox and existing user
			
		$this->Twitter = ConnectionManager::getDataSource('twitter'); 

		if($method == "dm") {
		
			$response = $this->Twitter->direct_messages_new(array('user_id'=> $twUserId, 'text' => $status));

		} else {
			if($twUserId) {
				
				$status = '@'.$twUserId.' '.$status;
			} 
			
			$this->Twitter->statuses_update(array('status' => $status));
		}
	}
}
?>