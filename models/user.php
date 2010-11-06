<?php
	class User extends AppModel {
	var $displayField = 'email_address';
	var $name = 'User';
	
	var $hasAndBelongsToMany = array(
		'Group' => array(
			'className' => 'Group',
			'joinTable' => 'groups_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'group_id',
			'unique' => true
		)
	);
	
	var $hasMany = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
	);
	
	var $hasOne = array(
		'Profile' => array(
			'className'    => 'Profile',
			 //'conditions'   => array('Profile.published' => '1'),
			'dependent'    => true
		)
	);
	
	

	var $validate=array(
		'email_address' => array(
			'notempty' => array( 
				'rule' => 'email',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Wir benötigen eine gültige E-Mail-Adresse'
			),
			'checkUnique' => array(
				'rule' => array('checkUnique', 'email_address'),
				'message' => 'Diese E-Mail-Adresse ist bereits registriert'
				)
			),
		'password'=>array(
			'notempty' => array(
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Bitte ein Passwort mit mindestens 6 Zeichen eingeben'
			 )
			),
		'passwd'=>array(
			'notempty' =>array(
				'rule' => 'checkPasswords',
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Die Passwörter sind nicht identisch'
				)			  
			),
		'fon' => array(  
			'required' => false,
			'allowEmpty' => true,   
			'rule' => array('custom', '/^[0-9]{4,25}$/i'), 
			'message' => 'Hier sind nur Zahlen erlaubt (min. 4 Ziffern)'   
			 ),
		'nickname' => array (
			'notempty' => array( 
				'rule' => array('between', 3, 20),
	    		'required' => true,
	    		'allowEmpty' => false,
	    		'message' => 'Bitte ein Pseudonym wählen (minimum 3, maximum 20 Buchstaben/Ziffern)'
	    	),
			'checkUnique' => array(
				'rule' => array('checkUnique', 'nickname'),
				'required' => true,
				'message' => 'Dieser Name ist bereits vergeben'
				)
			)
		);

	function checkUnique($data,$fieldName){
		$valid = false;
		if (isset($fieldName)&&($this->hasField($fieldName))){
				$valid = $this->isUnique(array($fieldName=>$data));
		}
		return $valid;
	}
	
	function checkPasswords($data) {
		if ($data['password'] == $this->data['User']['passwdhashed']) 
			return true;
		return false;
	}

}
?>