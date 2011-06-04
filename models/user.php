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
				'message' => 'Please enter a valid e-mail address'
			),
			'checkUnique' => array(
				'rule' => array('checkUnique', 'email_address'),
				'message' => 'This e-mail-address is already registered'
				)
			),
		'password'=>array(
			'notempty' => array(
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Password needs 6 chars'
			 )
			),
		'passwd'=>array(
			'notempty' =>array(
				'rule' => 'checkPasswords',
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Passwords are case-sensitive (Password is not the same as Password repeat)'
				)
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
				'message' => 'This nickname ist already registered'
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