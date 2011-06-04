<?php
class Transaction extends AppModel {

	var $name = 'Transaction';
	
	var $actsAs = array('Containable');

	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'marker_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'Transaction.created DESC' // for Logfile Descendent
		)
	);

	/**
	 * get all Views of a specific marker
	 *
	 */
	 
	function getViews($id) {
	
		$views= $this->find('count', array(
			'conditions' => array(
				'marker_id' => $id,
				)
			)
		);
		return $views;
	}
	
	/**
	 * get history of a specific marker, without view actions
	 *
	 */
	 
	function getHistory($id) {
	
		$history= $this->find('all', array(
			'fields' => array(
				'Transaction.id', 'Transaction.Name', 'Transaction.created', 'Transaction.ip', 'Transaction.status_id'
				),
			'conditions' => array(
				'marker_id' => $id,
				'NOT' => array('action' => array('view', 'edit')),
				)
			)
		);
		return $history;
	}
	
	function getAdminHistory() {
	
		$adminHistory= $this->find('all', array(
			'fields' => array(
				'Transaction.marker_id', 'Transaction.id', 'Transaction.Name', 'Transaction.created',
					 'Transaction.ip', 'Transaction.status_id', 'Marker.subject'
				),
			'conditions' => array(
				//'marker_id' => $id,
				'NOT' => array('action' => array('view', 'edit')),
				),
			'order' =>  array('Marker.created DESC','Marker.id')
			//'group' => 'marker_id'
			
			)
		);
	return $adminHistory;
	}
}
?>