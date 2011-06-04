<?php
class DemoController extends VotingAppController {
  var $uses = array('Voting.Voting', 'Marker');
  
  /**
   * Demo page.
   */
  function index() {
    $this->layout = 'demo';

    /*
$votingdemo = $this->Votingdemo->find('first');
    
    // create demo model data
    if (empty($votingdemo)) {
      $votingdemo = $this->Votingdemo->create();
      
      $votingdemo['Votingdemo']['id'] = String::uuid();
      $votingdemo['Votingdemo']['user_id'] = String::uuid();
      $votingdemo = $this->Votingdemo->save($votingdemo);
    }
    
    $this->set('votingdemo', $votingdemo);
*/
  }
  
  /**
   * Demo login.
   */
  function login() {
    if (!$this->Session->check('User.id') && !$this->Cookie->read('User.id')) {
      App::import('Core', 'String');
      $uuid = String::uuid();
      
      $this->Session->write('User.id', $uuid);
      $this->Cookie->write('User.id', $uuid);
      
      $this->Cookie->delete('Rating.guest_id');
      $this->Session->delete('Rating.guest_id');

      $this->Cookie->delete('Voting.guest_id');
      $this->Session->delete('Voting.guest_id');
    } else if ($this->Cookie->read('User.id')) {
      $this->Session->write('User.id', $this->Cookie->read('User.id'));
    }
    
    $this->redirect('/voting/demo');
    $this->autoRender = false;
  }
  
  /**
   * Demo logout.
   */
  function logout() {
    $this->Cookie->delete('User.id');
    $this->Session->delete('User.id');
    
    $this->redirect('voting/demo');
    $this->autoRender = false;
  }
}
?>