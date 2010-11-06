<?php
class Transaction extends AppModel {

	var $name = 'Transaction';

	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'marker_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Transaction.created DESC' // for Logfile Descendent
		)
	);

}
?>