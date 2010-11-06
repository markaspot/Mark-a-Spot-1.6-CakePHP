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
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4.6
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


	function log($marker_id) {

		if(empty($this->Controller->data['Marker']['status_id']) || empty($this->Controller->data['Comment']['marker_id'])){
			$this->Controller->modelClassModel->id = $marker_id;
			$status_id = $this->Controller->Marker->field('status_id');
		} else {
			$status_id = $this->Controller->data['Marker']['status_id'];
		}
		
		if(!$this->Auth->user('id')){
			$user_id = String::uuid();
;
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

		}
		$transaction = array(
			'marker_id' => $marker_id,
			'status_id' => $status_id,
			'user_id' => $user_id,
			'ip' => "127.0.0.1", //$_SERVER['REMOTE_ADDR'],
			'name' => $transactionName,
			'controller' => $this->Controller->params['controller'],
			'action' => $this->Controller->params['action']
		);
		$this->Marker->Transaction->save($transaction);
	}
}
?>