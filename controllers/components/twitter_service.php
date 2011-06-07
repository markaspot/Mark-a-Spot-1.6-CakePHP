<?php
/**
 * Mark-a-Spot Twitter Component
 *
 * Everything about the 1.5 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.5.1
 */
App::import('Core',array('HttpSocket'));

class TwitterServiceComponent extends Object {

	var $name = 'TwitterService';

	var $components = array('Auth');
	var $helpers = array(
		'Media.Media' => array(
			'versions' => array(
			's', 'xl'
			)
		)
	);

	function startup(&$controller) {
		$this->Controller =& $controller;
		$this->User = ClassRegistry::init('User');
		$this->Twitter = ClassRegistry::init('Twitter');
		$this->Marker = ClassRegistry::init('Marker');
		$this->Media = ClassRegistry::init('Media.Attachment');
	}

	
	/**
	* reply instead of importing
	*
	*/
	
	function replyTweet($tweet, $option) {

		$status  = '@'.$tweet['sender_name'].' '.__('Twitter Reply More Information: ',true);

		switch ($option) {
			case 1:
				$status .= __('Twitter Details needed',true);
			break;
			
			case 2:
				$status .= __('Twitter Address needed',true);
			break;
		
			case 3:
				$status .= __('Twitter Picture available?',true);
			break;
			
			case 4:
				// define complete new Status
				// Preparing Bitly.Url shortening
				$markerId = $this->Marker->id;
				$sitename = Configure::read('Site.domain');
				$url = "http://".$sitename."/markers/view/".$markerId;
		
				if ($url !== null) {
					App::Import('Component', 'Bitly');
					$this->Bitly = new BitlyComponent();
					$url = ' '.$this->Bitly->shorten($url);
				} 

				$status = '@'.$tweet['sender_name'].' '.$url.' '.__('Twitter Success Thanks! Your ID:  ', true)." #".substr($markerId, 0, 8);
		}
		$this->Twitter = ConnectionManager::getDataSource('twitter'); 
		$this->Twitter->account_verify_credentials();
		$response = $this->Twitter->statuses_update(array('status' => $status));
		
		if ($response){
			return "Reply sent";
		};

	}

	/**
	 * handle
	 * 
	 * 
	 */

	function handleTweets($tweets) {

		$flash = "";
		$allFlash = "";

		foreach ($tweets['Twitter'] as $tweet) {
	
			switch ($tweet['feedback']) {
				
				// flip through radiobuttons
				case 1:
					$flash = $this->replyTweet($tweet, 1);
				break;

				case 2:
					$flash = $this->replyTweet($tweet, 2);
				break;
	
				case 3:
					$flash = $this->replyTweet($tweet, 3);
				break;
				
				// Import this tweet
				
				case null:

					$flash = "";
					//$flash = $tweet['sender_name']." ".__('ignored',true);
				break;
			}
			
			if($tweet['import']){
				$flash = $this->importTweet($tweet);
			}	
			
			if($tweet['ignore']){
				$flash = $this->ignoreTweet($tweet);
			}	
			
		 // generate FlashMessage
		 if ($flash){
			 $allFlash .= "<br/>".$flash;
			 }
		}
		
		
		$this->Controller->Session->setFlash($allFlash , 'default', array(
			'class' => 'flash_success'));
		$this->Controller->redirect($this->Controller->referer(), null, true);	
	}

	/**
	 * Register Twitter User
	 * 
	 * 
	 */

	function registerUser($id, $name) {
		
		//$this->Session->write('Twitter', $response);

		$this->data['User']['email_address'] = $id."@markaspot.org";
		$this->data['User']['password'] = $this->Auth->password($name);
		$this->data['User']['passwd'] = $name;
		$this->data['User']['nickname'] = $name;

		if (isset($this->data['User']['passwd'])) {
			$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);
		}

		// set User non-active and Group for Users
		// move user into their group


		$this->data['Group']['id'] = Configure::read('userGroup.users');
		$this->data['User']['active'] = 1;
		//Save all UserData
	
	
	
		/**
		 * User Sign Up with Twitter Credentials
		 *
		 * 
		*/ 
		
		if ($this->User->checkUnique($this->data['User']['email_address'], 'email_address')) {
			
			// Sign Up User only if email is not registered yet
			
			$this->User->create($this->data);
			
			if ($this->User->save()) {
				return $this->User->id;
			}
			

		} else {
		
			// howto login user without password
			// 1. Find the User who owns this email_adress (user_id@markaspot.org)
			//

			$earlyBird = $this->User->find('first',array(
				'conditions' => array(
					'User.email_address' => $id."@markaspot.org"),
					'contain' => false, 
					'fields' => array ('id')
					)
				);

			// Now we have the ID and are able to update instead of insert
			$this->data['User']['id'] = $earlyBird['User']['id'];
			return $earlyBird['User']['id'];
		}


	}

	/**
	* Check if Tweet has been added before
	*
	*/
	
	function importTweetCheck($id) {
		// Verify that tweet is not already saved
		$isAdded = $this->Marker->field('source_id', array('Marker.source_id' => $id));
		return $isAdded;
	}

	/**
	* Check if Tweet has been ignored
	*
	*/
	
	function ignoreTweetCheck($id) {
		// Verify that tweet is not already on Ignore
		$this->Blacklist = ClassRegistry::init('Tweet');

		$isIgnored = $this->Blacklist->field('tw_id', array('tw_id' => $id));
		return $isIgnored;
	}

	
	/**
	* Call tweets as replies
	*
	*/
	
	function ignoreTweet($tweet) {
		
		// Verify that tweet is not already saved
		$this->Blacklist = ClassRegistry::init('Tweet');

		$save['Tweet']['tw_id'] = $tweet['reply_to'];
		$save['Tweet']['tw_text'] = $tweet['text'];
		if ($this->Blacklist->save($save)){
			return "Tweet ignored";
		}

		
	}
	/**
	* Call tweets as replies
	*
	*/
	
	function importTweet($tweet) {
		if (isset($tweet['geo'])){
				
			$this->data['Marker']['lat'] = $tweet['geo']['lat'];
			$this->data['Marker']['lon'] = $tweet['geo']['lon'];
			$latlng = $tweet['geo']['lat'].",".$tweet['geo']['lon'];
			$address = $this->getAddress($latlng);
			$this->data['Marker']['street'] = $address[0];
			$this->data['Marker']['zip'] = $address['local'][0];
			$this->data['Marker']['city'] = $address['local'][1];


		} else {

			$geo = explode(",", Configure::read('Google.Center'));
			$this->data['Marker']['lat'] = $geo[0];
			$this->data['Marker']['lon'] = $geo[1];
		}
	
			
		$user_id = $this->registerUser($tweet['sender_id'], $tweet['sender_name']);
		$this->data['Marker']['user_id'] = $user_id;
		
		// Split Tweet into single words 
		$parts = explode(" ", $tweet['text']);

		// create a report

		App::import('Helper', 'Text');
		$text = new TextHelper();
		$report = $text->truncate($tweet['text'],60, array(
			'ending' => '... ', 'exact' => false));
		



		// Strip @twittername from tweet to have clean issues
		$myTwittername = strstr($parts[0],'@');

		$this->data['Marker']['description'] = __("Twitter-Report",true)." #".$tweet['reply_to']." Text:\n".$tweet['text'];
		$this->data['Marker']['subject'] = substr($report, strlen($myTwittername));

				
		// get this from config file later;
		if($tweet['Status'] != ""){
			$this->data['Marker']['status_id'] = $tweet['Status'];
		} else {
			$this->data['Marker']['status_id'] = Configure::read('Twitter.StatusInitial');
		}
		
		if($tweet['Category'] != null){
			$this->data['Marker']['category_id'] = $tweet['Category'];
		} else {
			$this->data['Marker']['category_id'] = 34;
		}
		
		
		$this->data['Attachment'][0]['model'] = "Marker";
		$this->data['Attachment'][0]['group'] = "attachment";
		//$this->data['Attachment'][0]['title'] = "url";
		
		$this->data['Attachment'][0]['file'] =	$this->mediaExpand($parts);

		$this->data['Marker']['source_id'] = $tweet['reply_to'];
		
		// Verify that tweet is not already saved
		$isAdded = $this->importTweetCheck($tweet['reply_to']);

		if (!$isAdded && $this->Marker->saveAll($this->data, array('validate' => false))) {
			
			//let the script delay for distinguishable uids 
			$start = microtime(true); 
			for ($i = 0; $i <= 5.5; $i ++) { 
				@time_sleep_until($start + $i); 
			} 

			
			$this->Controller->Transaction->log($this->Marker->id);

			$flash = sprintf(__(
				'The Marker ID# %s has been saved. The user will be notified.',true),
					substr($this->Marker->id, 0, 8));
			$this->replyTweet($tweet, 4);

			return $flash;
			
			
		} else {
		
			// if is already added
			$flash = "This marker could not be saved";
			return $flash;
		}

				
	} 
	
	function mediaExpand($parts) { 
		$mediaServices = array('twitgoo.com' ,'yfrog.com' ,
			'mobypicture.com' ,'posterous.com'  ,'www.smugmug.com' ,'ow.ly' ,'twitpic.com' , 'flic.kr' ,'plixi.com' ,'t.co');


		// Now strip any urls who look like mediaSercvice
		foreach($parts as $part){
			foreach($mediaServices as $mediaService){
				if(stristr($part, $mediaService)) {
					$this->data['Marker']['media_url'] = $part;
					$shortUrl = $part;

					} 
			}
		}

		// Testcases:
		
		// works $shortUrl = "http://twitpic.com/3lj3nc";
		// works $shortUrl = "http://twitgoo.com/15chl54";
		// works $shortUrl = "http://yfrog. Com/fxgv60";
		// works:  $shortUrl = "http://tinypic.com/34ytcwn.jpg";

		// http://www.flickr.com/services/api/misc.urls.html
		// $shortUrl = "http://flic.kr/p/4jkyoS";
		
		
		// http://plixi.zendesk.com/entries/350225-objects
		// $shortUrl = "http://plixi.com/p/66311709";
		
		// Now split Url and Check which service is connected to tweet
		
		if (isset($shortUrl)) {
			$url = parse_url($shortUrl);
		} else {
			return false;
		}
			
		switch ($url['host']) {
		
			case "twitpic.com" :
				$shortUrl = $url['path'];
				$mediaUrl = $this->getTwitPicUrl(urlencode($shortUrl));
			break;
			
			case "yfrog.com":
				$mediaUrl = $this->getYfrogUrl(urlencode($shortUrl));
			break;	
			
			case "twitgoo.com":
				$mediaUrl = 'http://i52.twitgoo.com'.$url['path'].'.jpg';
			break;
			
			case "tinypic.com":
				$mediaUrl = 'http://tinypic.com'.$url['path'].'.jpg';
			break;
			
			case "plixi.com":
				$mediaUrl = $this->getPlixiUrl($shortUrl);
			break;
			
 			default:
				if ($this->identifyShortUrl($shortUrl)) {
					$mediaUrl = $this->expand($shortUrl);
					if (stristr($mediaUrl, "flickr")) {
						$this->log('Flickr Original not supported');
					}
				} else {
					$this->log('ShortUrl commited can not be rebuilt');
				}
		}
		
		return $mediaUrl;

	}
	
	
	/**
	 *
	 * Get ThumbsUrl from different Services
	 *
	 */
	
	function getYfrogUrl($url){
		$url = 'http://www.yfrog.com/api/oembed?url='.$url;
		$this->httpSocket =& new HttpSocket();
		$yfrog = json_decode($this->httpSocket->get($url));
		$thumbUrl = $yfrog->url;
		return $thumbUrl;
	}

	function getPlixiUrl($url){
		$apiUrl = 'http://api.plixi.com/api/tpapi.svc/imagefromurl';
		$this->httpSocket =& new HttpSocket();
		$response = $this->httpSocket->get($apiUrl, 'url='.$url);
		
		$result = $this->httpSocket->response;
		
		$thumbUrl = $result['header']['Location'];
		return $thumbUrl;
	}

	function getTwitPicUrl($shortUrl){		
		$apiUrl = 'http://twitpic.com/show/thumb';
		$this->httpSocket =& new HttpSocket();
		$response = $this->httpSocket->get($apiUrl.$shortUrl);
		$result = $this->httpSocket->response;
		$thumbUrl = $result['header']['Location'];
		
		return $thumbUrl;
	}




	/**
	 * 	Is this shortUrl part of the longurl.org Service?
	 *
	 */

	function identifyShortUrl($shortUrl){
		$url = 'http://api.longurl.org/v2/services?format=json&user-agent=Mark-a-Spot';
		
		$this->httpSocket =& new HttpSocket();
		$services = $this->httpSocket->get($url);
		
		$domain = parse_url($shortUrl);

		if(strstr($services, $domain['host'])) {
			return true;
		} else {
			return false;
		}
	
	}
	
	/**
	 * 	Is this shortUrl part of the longurl.org Service?
	 *
	 */
	function expand($url){
		$url = 'http://api.longurl.org/v2/expand?format=json&url='.$url.'&user-agent=Mark-a-Spot';
		$this->httpSocket =& new HttpSocket();
		$expandedUrl = json_decode($this->httpSocket->get($url));
		$expandedUrl = get_object_vars($expandedUrl);

		return $expandedUrl['long-url'];

	}
	
	function getAddress($latlng){
		$url = 'http://maps.google.com/maps/api/geocode/json?latlng='.$latlng.'&sensor=false';
		
		$this->httpSocket =& new HttpSocket();
		$result = json_decode($this->httpSocket->get($url));
		
		$address = explode(', ', $result->results[0]->formatted_address);
		$address['local'] = explode(" ",$address[1]);

		return($address);
	}

}