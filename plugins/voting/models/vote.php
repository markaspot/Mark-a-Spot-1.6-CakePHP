<?php
class Vote extends Model {
  var $name = 'Vote';
  
  var $validate = array(
      'voting_id' => array(
          'rule' => 'numeric',
          'required' => true
      ),
      'user_id' => array(
          'rule' => 'notEmpty',
          'required' => true
      )
  );
  
  var $belongsTo = array(
      'Voting' => array(
          'className'  => 'Voting'
      )
  );
}
?>