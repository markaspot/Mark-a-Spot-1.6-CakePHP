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
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
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
		$this->Email->subject = Configure::read('e-mail.'.$template.'.subject');
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
			// pr($this->Marker->Category->read('Name', 1));
			$this->Controller->set('category',
				$this->Controller->{$this->Controller->modelClass}->Category->read('Name', 
					$this->Controller->data['Marker']['category_id']));
			$this->Controller->set('descr', $this->Controller->data['Marker']['descr']);
			$this->Controller->set('subject', $this->Controller->data['Marker']['subject']);
	
		}


		// Set Processcat Comment only on Update
		if ($template == "update") {

			$statusId = $this->Controller->data['Marker']['status_id'];
			$this->Controller->set('comment', $this->Controller->data['Comment'][0]['comment']);
			$this->Controller->{$this->Controller->modelClass}->Status->recursive = -1;
			$statusmail = $this->Controller->{$this->Controller->modelClass}->Status->read('Name', $statusId);
			$this->Controller->set('status',$statusmail);			
			
/*
			// Update Twitter->Status if checkbox and existing user
			if ($this->Controller->data['Marker']['twitter'] == 1) {
				
				$this->Twitter = ConnectionManager::getDataSource('twitter'); 
				$this->Twitter->username = TWITTER_USER;
				$this->Twitter->password = TWITTER_PW;
				$response = $this->Twitter->account_verify_credentials();
				//pr($response); 

				
				
				// Preparing Bitly.Url shortening
				
				$url = "http://".$sitename."/markers/view/".$markerId;

				if ($url !== null) {
					App::Import('Component', 'Bitly');
					$this->Bitly = new BitlyComponent();
					$url = ' '.$this->Bitly->shorten($url);
				} 
				
				if ($statusId == 4) {
					$tweet = __('MessCity is cleaning up: #markaspot '.$this->Controller->data['Marker']['subject'].'. Status: ',true).$statusmail['Status']['Name'].' '.$url;	
				}
				if ($statusId == 5) {
					$tweet = __('MessCity is cleaning up: #markaspot '.$this->Controller->data['Marker']['subject'].'. Status: ',true).$statusmail['Status']['Name'].' '.$url;			
				}
				
				// send only tweets if there's something to say
				if ($tweet != false) {
					$result = $this->Twitter->statuses_update(array('status' => $tweet));
					pr($result);
					die;
				}
			}
*/
			
					
					
					
		}
		//$this->Controller->set('user', $this->Auth->user('nickname'));
		$this->Controller->set('email', $recipient);

		// Only query User if asked from markers_controller.php
		if ($markerId) {
			$this->Controller->set('userId', $this->Controller->{$this->Controller->modelClass}->User->id);
		}
		

		// Email senden
		if ($this->Email->send()) {
			$sent = true;
		} else {
			$sent = false;
		}

		return $sent;
	}
	
	function tweetStatus($markerId) {#

		App::import('Helper', 'Text');
		$text = new TextHelper();


		// Update Twitter->Status if checkbox and existing user
			
		$this->Twitter = ConnectionManager::getDataSource('twitter'); 
		//$this->Twitter->username = TWITTER_USER;
		//$this->Twitter->password = TWITTER_PW;
		$response = $this->Twitter->account_verify_credentials();
		//pr($response); 

		$statusId = $this->Controller->data['Marker']['status_id'];
		$this->Controller->set('comment', $this->Controller->data['Comment'][0]['comment']);
		$this->Controller->{$this->Controller->modelClass}->Status->recursive = -1;
		$statusmail = $this->Controller->{$this->Controller->modelClass}->Status->read('Name', $statusId);
		
		$sitename = Configure::read('Site.domain');


		// Preparing Bitly.Url shortening
		
		$url = "http://".$sitename."/markers/view/".$markerId;

		if ($url !== null) {
			App::Import('Component', 'Bitly');
			$this->Bitly = new BitlyComponent();
			$url = ' '.$this->Bitly->shorten($url);
		} 


		$tweet = __('Bürgeranliegen bearbeitet: '.$text->truncate($this->Controller->data['Marker']['subject'],50, array('ending' => '... ', 'exact' => false)).' Status: ',true).$statusmail['Status']['Name'].' '.$url.' #markaspot';	
		$this->Twitter->statuses_update(array('status' => $tweet));


		
		/*
		
		// Conditional tweets / depending on status
		
		if ($statusId == 4) {
			$tweet = __('MessCity is cleaning up: #markaspot '.$this->Controller->data['Marker']['subject'].'. Status: ',true).$statusmail['Status']['Name'].' '.$url;	
		}
		if ($statusId == 5) {
			$tweet = __('MessCity is cleaning up: #markaspot '.$this->Controller->data['Marker']['subject'].'. Status: ',true).$statusmail['Status']['Name'].' '.$url;			
		}
	
		
		// send only tweets if there's something to say
		if ($tweet != false) {
			$result = $this->Twitter->statuses_update(array('status' => $tweet));
			pr($result);
			die;
		}
		*/

	}

}
?>