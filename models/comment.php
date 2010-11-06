<?php
class Comment extends AppModel {

	var $name = 'Comment';
	var $validate = array(
		'name'		=> array('rule'=>array('minLength', '1'), 'required'=>true, 'message'=> 'Please enter your name'),
		'comment'	=> array('rule'=>array('minLength', '1'), 'required'=>true, 'message'=> 'Please enter a commment'),
		'email'		=> array('rule'=>'email', 'required'=>true, 'message'=> 'We need a valid e-mail address')
		);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'marker_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>