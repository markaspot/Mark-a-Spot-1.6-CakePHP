<?php
class Category extends AppModel {

	var $name = 'Category';
	var $actsAs = array('Tree');


	var $belongsTo = array(
		'User' => array(
			'className'    => 'User',
			'conditions'   => array('User.active' => '9'),
		'dependent'    => true
		)
	); 
}
?>