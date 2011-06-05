<?php
class BitlyComponent extends Object {
	var $user;
	var $api_key;
 
	function __construct() {
		$this->user = BITLY_USER;
		$this->api_key = BITLY_API_KEY;
		$this->BitlyLink = ClassRegistry::init('BitlyLink');
	}
 
	function setApiInfo($user, $api_key) {
		$this->user = $user;
		$this->api_key = $api_key;
	}
 
	function shorten($long_url) {
		$cache = $this->BitlyLink->find('first', array('conditions' => array('BitlyLink.long_url' => $long_url)));
 
		if (!empty($cache['BitlyLink']['id'])) {
			return 'http://bit.ly/'.$cache['BitlyLink']['hash'];
		}
 
		$params = array();
 
		$params['login'] = $this->user;
		$params['apiKey'] = $this->api_key;
		$params['version'] = '2.0.1';
		$params['format'] = 'json';
		$params['longUrl'] = $long_url;
 
		$url = 'http://api.bit.ly/shorten?'.http_build_query($params);
 
		$ch = curl_init();
 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
		$data = curl_exec($ch);
		curl_close($ch);
 
		$data = json_decode($data, true);
 
		if ($data['errorCode'] == 0) {
			$result = array_pop(array_values($data['results']));

			$save = array('BitlyLink' => array());
			$save['BitlyLink']['long_url'] = $long_url;
			$save['BitlyLink']['hash'] = $result['hash'];
			$this->BitlyLink->create();
			$this->BitlyLink->save($save);
 
			return $result['shortUrl'];
		} else {
			return false;
		}
	}
}
?>