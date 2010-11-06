<?php
class Category extends AppModel {

	var $name = 'Category';
	var $actsAs = array('Tree');
/*

	var $validate = array(
		'hex' => array('notempty')
	);
*/

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/*
	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'category_id'
		)
	);
*/

    var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
			'conditions'   => array('User.active' => '9'),
            'dependent'    => true
        )
    ); }
?>