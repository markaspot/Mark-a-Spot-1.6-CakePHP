<?php
class Voting extends Model {
  var $name = 'Voting';

  var $actsAs = array('Containable');
  
  var $recursive = -1;
  
  var $validate = array(
      'model_id' => array(
          'rule' => 'notEmpty',
          'required' => true
      ),
      'model' => array(
          'rule' => 'notEmpty',
          'required' => true
      ),
      'name' => array(
          'rule' => 'alphaNumeric',
          'required' => false
      )
  );

  var $hasMany = array(
      'Vote' => array(
          'className'   => 'Vote',
          'dependent'   => true,
          'exclusive'   => true
  ));
  
  /**
   * Finds the result of a voting.
   * 
   * @param $id Voting id
   */
  function findResult($id) {
    $result = array();
    $options = Configure::read('Voting.options');

    $voting = $this->find('first', array('conditions' => array(
                                            'Voting.id' => $id),
                                         'contain' => array(),
                                         'fields' => array('id')));
    $optionVotes = $this->Vote->find('all', array('conditions' => array(
                                                      'voting_id' => $id),
                                                  'group' => 'Vote.option',
                                                  'fields' => array(
                                                      'Vote.option',
                                                      'COUNT(Vote.option) AS votes')));

    // add option votes
    foreach ($optionVotes as $votes) {
      if (!empty($options)) {
        $result[$options[$votes['Vote']['option']]['wildcard']] = $votes[0]['votes'];
      } else {
        $result[$votes['Vote']['option']] = $votes[0]['votes'];
      }
    }

    // add 0 value for options that are not voted yet
    if (!empty($options)) {
      foreach ($options as $option) {
        if (!array_key_exists($option['wildcard'], $result)) {
          $result[$option['wildcard']] = 0;
        }
      }
    }

    return $result;    
  }
  
  /**
   * Finds the vote of a user.
   * 
   * @param $id Voting id
   * @param $userId User id
   * @return Array of vote record
   */
  function findVote($id, $userId) {
    $vote = $this->Vote->find('first', array(
                'conditions' => array(
                    'voting_id' => $id,
                    'user_id' => $userId)));
    
    return $vote;
  }
  
  /**
   * Saves a vote to an option of a voting.
   * 
   * @param $model Model name
   * @param $id Model id
   * @param $name Voting name
   * @param $userId User id
   * @param $nr Option number
   * 
   * @return 'true' if saved, 'false' otherwise
   */
  function saveVote($model, $id, $name, $userId, $nr) {
    $saved = false;
    $data = array();
    $vote = array();
    
    // get voting from db
    $voting = $this->find('first', array(
                  'conditions' => array(
                      'model_id' => $id, 
                      'model' => $model,
                      'name' => $name)));
    
    // save voting
    if (empty($voting)) {
      $data = $this->create();
      $data['Voting']['model_id'] = $id;
      $data['Voting']['model'] = $model;
      $data['Voting']['name'] = $name;
      $voting = $this->save($data);
    } else {
      $this->id = $voting['Voting']['id'];
    }
    
    // save vote
    if (!empty($voting)) {
      $data = $this->Vote->create();
      $data['Vote']['voting_id'] = $this->id;
      $data['Vote']['user_id'] = $userId;
      $data['Vote']['option'] = $nr;
      
      $vote = $this->Vote->save($data);
      
      $saved = !empty($vote);
    }
    
    return $saved;
  }
}
?>