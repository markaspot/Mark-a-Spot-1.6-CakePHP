<?php
/**
 * Mark-a-Spot Transaction Component
 *
 * Everything about logging markers
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
 * @version    1.5.1
 */
class TransactionComponent extends Object {

	var $name = 'Transaction';
	var $components = array('Auth');

	function startup(&$controller) {
		$this->Controller =& $controller;
		$this->Marker = ClassRegistry::init('Marker');
		$this->Transaction = ClassRegistry::init('Transaction');
	}
	

	/**
	* Save log into Transaction Table.
	* 
	* @param integer $marker_id
	*/


	function log($marker_id, $restMethod = null) {
		
		if(empty($this->Controller->data['Marker']['status_id']) || empty($this->Controller->data['Comment']['marker_id'])){
			$this->Marker->id = $marker_id;
			$status_id = $this->Marker->field('status_id');
		} else {
			$status_id = $this->data['Marker']['status_id'];
		}

		if(!$this->Auth->user('id')){
			$user_id = $this->Controller->Marker->field('user_id');
		} else {
			$user_id = $this->Auth->user('id');
		}

		$param = $this->Controller->params['controller']."/".$this->Controller->params['action'];

		switch ($param) {
		case 'markers/admin_edit':
			$transactionName = __('Marker edited by authorities',true);

		break;
		case 'markers/edit':
			$transactionName = __('Marker edited by user',true);

		break;
		case 'markers/add':
			$transactionName = __('Marker added',true);
		break;
		
		case 'markers/startup':
			$transactionName = __('Marker added',true);
		break;
		
		case 'api/add':
			$transactionName = __('Marker added by API',true);
		break;

		case 'api/edit':
			$transactionName = __('Marker edited by API',true);
		break;

		
		case 'markers/view':
			$transactionName = __('Marker viewed',true);
		break;
		
		case 'markers/geosave':
			$transactionName = __('Marker&rsquo;s position fixed or moved',true);

		break;
		case 'ratings/save':
			$transactionName = __('Marker has been rated',true);

		break;
		case 'votings/vote':
			$transactionName = __('Marker has been voted',true);

		break;
		case 'comments/commentsadd':
			$transactionName = __('Comment added',true);

		break;

		case 'twitter/admin_reply':
			$transactionName = __('Marker added via Twitter',true);

		break;

		}
		
		if ($restMethod) {
			$transactionName = __('Marker edited Mobile',true);
		}
		
		
		if (Configure::read('Logging.ip') == 1){
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = "127.0.0.4";
		}
		
		$transaction = array(
			'marker_id' => $marker_id,
			'status_id' => $status_id,
			'user_id' => $user_id,
			'ip' => $ip,
			'name' => $transactionName,
			'controller' => $this->Controller->params['controller'],
			'action' => $this->Controller->params['action']
		);
		$this->Transaction->save($transaction);
	}
}
?>