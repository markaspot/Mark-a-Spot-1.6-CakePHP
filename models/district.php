<?php
class District extends AppModel {

	var $name = 'District';
	var $validate = array(
//
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'district_id'
		)
	);

}
?>