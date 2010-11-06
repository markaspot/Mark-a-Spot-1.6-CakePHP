<?php
/*
* Twitter Oauth Datasource
* Version 0.1
* Created: 12/12/2009
* Creator: Michael "MiDri" Riddle
*	
* Special Thanks to Daniel Hofstetter & Alexandru Ciobanu for their work on orginal oauth_consumer component and twitter datasource.
*	
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*/


App::import('Core',array('Xml','HttpSocket'));
App::import('Vendor','oauth', array('file' => 'OAuth'.DS.'OAuth.php'));
class TwitterOauthSource extends DataSource {
	public $oauth_key = '';
	public $oauth_secret = '';
	public $description = 'Twitter API now with 100% more OAuth!';
	public $httpSocket = null;
	/* Public Methods */
	function __construct($config) {
		parent::__construct($config);
		$this->httpSocket =& new HttpSocket();
		$this->config = $config;
		if(!isset($this->config['oauth_key'])) {
			$this->config['oauth_key'] = '';
		}
		if(!isset($this->config['oauth_secret'])) {
			$this->config['oauth_secret'] = '';
		}
	}
	function setOAuthCredentials($key,$secret) {
		$this->config['oauth_key'] = $key;
		$this->config['oauth_secret'] = $secret;
	}
	/* Twitter API Wrappers */
		/* Search API */
	function search($params=array()) {
		$url = 'http://search.twitter.com/search.json';
		return $this->__query($url,$params,'get');
	}
	function trends($params=array()) {
		$url = 'http://search.twitter.com/trends.json';
		return $this->__query($url,$params,'get');
	}
	function trends_current($params=array()) {
		$url = 'http://search.twitter.com/trends/current.json';
		return $this->__query($url,$params,'get');
	}
	function trends_daily($params=array()) {
		$url = 'http://search.twitter.com/trends/daily.json';
		return $this->__query($url,$params,'get');
	}
	function trends_weekly($params=array()) {
		$url = 'http://search.twitter.com/trends/weekly.json';
		return $this->__query($url,$params,'get');
	}
		/* REST API */
			/* Timeline Wrappers */
	function statuses_public_timeline($params=array()) {
		$url = 'http://twitter.com/statuses/public_timeline.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_home_timeline($params=array()) {
		$url = 'http://twitter.com/statuses/home_timeline.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_friends_timeline($params=array()) {
		$url = 'http://twitter.com/statuses/friends_timeline.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_user_timeline($params=array()) {
		$url = 'http://twitter.com/statuses/user_timeline.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_mentions($params=array()) {
		$url = 'http://twitter.com/statuses/mentions.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_retweeted_by_me($params=array()) {
		$url = 'http://twitter.com/statuses/retweeted_by_me.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_retweeted_to_me($params=array()) {
		$url = 'http://twitter.com/statuses/retweeted_to_me.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_retweeted_of_me($params=array()) {
		$url = 'http://twitter.com/statuses/retweeted_of_me.json';
		return $this->__query($url,$params,'get');
	}
			/* Status Wrappers */
	function statuses_show($params=array()) {
		$url = 'http://twitter.com/statuses/show.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_update($params=array()) {
		$url = 'http://twitter.com/statuses/update.json';
		return $this->__query($url,$params,'post');
	}
	function statuses_destroy($params=array()) {
		$url = 'http://twitter.com/statuses/destroy.json';
		return $this->__query($url,$params,'post');
	}
	function statuses_retweet($params=array()) {
		$url = 'http://twitter.com/statuses/retweet.json';
		return $this->__query($url,$params,'post');
	}
	function statuses_retweets($params=array()) {
		$url = 'http://twitter.com/statuses/retweets.json';
		return $this->__query($url,$params,'get');
	}
			/* User */
	function users_show($params=array()) {
		$url = 'http://twitter.com/users/show.json';
		return $this->__query($url,$params,'get');
	}
	function users_search($params=array()) {
		$url = 'http://twitter.com/users/search.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_friends($params=array()) {
		$url = 'http://twitter.com/statuses/friends.json';
		return $this->__query($url,$params,'get');
	}
	function statuses_followers($params=array()) {
		$url = 'http://twitter.com/statuses/followers.json';
		return $this->__query($url,$params,'get');
	}
			/* Direct Message */
	function direct_messages($params=array()) {
		$url = 'http://twitter.com/direct_messages.json';
		return $this->__query($url,$params,'get');
	}
	function direct_messages_sent($params=array()) {
		$url = 'http://twitter.com/direct_messages/sent.json';
		return $this->__query($url,$params,'get');
	}
	function direct_messages_new($params=array()) {
		$url = 'http://twitter.com/direct_messages/new.json';
		return $this->__query($url,$params,'post');
	}
	function direct_messages_destroy($params=array()) {
		$url = 'http://twitter.com/direct_messages/destroy.json';
		return $this->__query($url,$params,'post');
	}
			/* Friendship */
	function friendships_create($params=array()) {
		$url = 'http://twitter.com/friendships/create.json';
		return $this->__query($url,$params,'post');
	}
	function friendships_destroy($params=array()) {
		$url = 'http://twitter.com/friendships/destroy.json';
		return $this->__query($url,$params,'post');
	}
	function friendships_show($params=array()) {
		$url = 'http://twitter.com/friendships/show.json';
		return $this->__query($url,$params,'get');
	}
			/* Social Graph */
	function friends_ids($params=array()) {
		$url = 'http://twitter.com/friends.json';
		return $this->__query($url,$params,'get');
	}
	function followers_ids($params=array()) {
		$url = 'http://twitter.com/followers.json';
		return $this->__query($url,$params,'get');
	}
			/* Account */
	function account_verify_credentials($params=array()) {
		$url = 'http://twitter.com/account/verify_credentials.json';
		return $this->__query($url,$params,'get');
	}
	function account_rate_limit_status($params=array()) {
		$url = 'http://twitter.com/account/rate_limit_status.json';
		return $this->__query($url,$params,'get');
	}
	function account_update_delivery_device($params=array()) {
		$url = 'http://twitter.com/account/update_delivery_device.json';
		return $this->__query($url,$params,'post');
	}
	function account_update_profile_colors($params=array()) {
		$url = 'http://twitter.com/account/update_profile_colors.json';
		return $this->__query($url,$params,'post');
	}
	function account_update_profile_image($params=array()) {
		$url = 'http://twitter.com/account/update_profile_image.json';
		return $this->__query($url,$params,'post');
	}
	function account_update_profile_background_image($params=array()) {
		$url = 'http://twitter.com/account/update_profile_background_image.json';
		return $this->__query($url,$params,'post');
	}
	function account_update_profile($params=array()) {
		$url = 'http://twitter.com/account/update_profile.json';
		return $this->__query($url,$params,'post');
	}
			/* Favorite */
	function favorites($params=array()) {
		$url = 'http://twitter.com/favorites.json';
		return $this->__query($url,$params,'get');
	}
	function favorites_create($params=array()) {
		$url = 'http://twitter.com/favorites/create.json';
		return $this->__query($url,$params,'post');
	}
	function favorites_destroy($params=array()) {
		$url = 'http://twitter.com/favorites/destroy.json';
		return $this->__query($url,$params,'post');
	}
			/* Notification */
	function notifications_follow($params=array()) {
		$url = 'http://twitter.com/notifications/follow.json';
		return $this->__query($url,$params,'post');
	}
	function notifications_leave($params=array()) {
		$url = 'http://twitter.com/notifications/leave.json';
		return $this->__query($url,$params,'post');
	}
			/* Block */
	function blocks_create($params=array()) {
		$url = 'http://twitter.com/blocks/create.json';
		return $this->__query($url,$params,'post');
	}
	function blocks_destroy($params=array()) {
		$url = 'http://twitter.com/blocks/destroy.json';
		return $this->__query($url,$params,'post');
	}
	function blocks_exists($params=array()) {
		$url = 'http://twitter.com/blocks/exists.json';
		return $this->__query($url,$params,'get');
	}
	function blocks_blocking($params=array()) {
		$url = 'http://twitter.com/blocks/blocking.json';
		return $this->__query($url,$params,'get');
	}
	function blocks_blocking_ids($params=array()) {
		$url = 'http://twitter.com/blocks/blocking/ids.json';
		return $this->__query($url,$params,'get');
	}
			/* Spam Reporting */
	function report_spam($params=array()) {
		$url = 'http://twitter.com/report_spam.json';
		return $this->__query($url,$params,'post');
	}
			/* Oauth */
	function oauth_request_token($params=array()) {
		$url = 'http://twitter.com/oauth/request_token';
		$request = $this->__createRequest('post',$url,null,$params);
		$return = $this->__postRequest($url,$request->to_postdata());
		parse_str($return,$output);
		return $output;
	}
	function oauth_authorize($params=array()) {
		$url = 'http://twitter.com/oauth/authorize';
		return $this->__query($url,$params,'get');
	}
	function oauth_authenticate($params=array()) {
		$url = 'http://twitter.com/oauth/authenticate';
		return $this->__query($url,$params,'get');
	}
	function oauth_access_token($params=array()) {
		$url = 'http://twitter.com/oauth/access_token';
		$request = $this->__createRequest('post',$url,new OAuthToken($params['oauth_token'],$params['oauth_secret']),$params);
		unset($params['oauth_token']);
		unset($params['oauth_secret']);
		$return = $this->__postRequest($url,$request->to_postdata());
		parse_str($return,$output);
		return $output;
	}
	/* Internal methods */
	private function __query($url,$params,$httpMethod='get') {
		$accessToken = new OAuthToken($this->config['oauth_key'],$this->config['oauth_secret']);
		$request = $this->__createRequest($httpMethod,$url,$accessToken,$params);
		
		if($request->get_normalized_http_method() == 'POST') {
			$response = $this->__postRequest($url,$request->to_postdata());
		}
		else {
			$response = $this->__getRequest($request->to_url());
		}
		return json_decode($response);
	}
	private function __createRequest($httpMethod,$url,$token,array $params) {
		$consumer = $this->__createConsumer('twitter');
		$request = OAuthRequest::from_consumer_and_token($consumer,$token,$httpMethod,$url,$params);
		$request->sign_request(new OauthSignatureMethod_HMAC_SHA1(),$consumer,$token);
		return $request;
	}
	private function __createConsumer($consumerName) {
		$consumerFolderPath = COMPONENTS.DS.'oauth_consumers'.DS;
		App::import('File', 'abstractConsumer', array('file' => $consumerFolderPath.'abstract_consumer.php'));
		$fileName = Inflector::underscore($consumerName) . '_consumer.php';
		$className = $consumerName . 'Consumer';
		if (App::import('File', $fileName, array('file' => $consumerFolderPath.$fileName))) {
			$consumerClass = new $className();
			return $consumerClass->getConsumer();
		} else {
			throw new InvalidArgumentException('Consumer ' . $fileName . ' not found!');
		}
	}
	
	private function __getRequest($url) {
		return $this->httpSocket->get($url);
	}
	
	private function __postRequest($url,$data) {
		return $this->httpSocket->post($url,$data);
	}
}
?>