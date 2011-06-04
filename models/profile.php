<?php
	
class Profile extends AppModel {  
	var $name = 'Profile';
	var $belongsTo = 'User'; 
	
	var $validate=array(
		'fon' => array(  
			'required' => false,
			'allowEmpty' => true,   
			'rule' => array('custom', '/^[0-9]{4,25}$/i'), 
			'message' => 'Please enter a valid Phone Number (min. 4 Ziffern)'   
			 ),
		'prename' => array (
			'notempty' => array( 
				'rule' => array('between', 3, 20),
				'allowEmpty' => true,
				'message' => 'minimum 3, maximum 20 chars)'
				),
			)
		);

/*
		var $validate=array(
		'agree' => array(
			'rule' => array('comparison', '!=', 0),
			'required' => true,
			'message' => 'You must agree to the terms of use',
		'on' => 'create')
		)
*/
	}
?>