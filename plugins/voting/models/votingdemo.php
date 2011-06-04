<?php
class Votingdemo extends AppModel {
  var $name = 'Votingdemo';
  
  var $hasMany = array(
      'Voting' => array(
          'className'   => 'Voting',
          'foreignKey'  => 'model_id',
          'conditions' => array('Voting.model' => 'Demo'),
          'dependent'   => true,
          'exclusive'   => true
      )
  );
}
?>