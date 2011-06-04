<h1>CakePHP voting plugin v1.0 DEMO</h1>
<?php
  echo $this->element('voting', array(
          'plugin' => 'voting',
          'model' => 'Marker',
          'id' => '4c39716f-1334-46a8-bdb3-788150431cad',
          'config' => array(
              'plugin_voting' => array(
                  'Voting.showOptionResults' => false,
                  'Voting.showOptionTitles' => true)),
          'name' => 'votingdemo1',
          'title' => __('Do you like this plugin?', true)));
?>
<br/>
<?php
  echo $this->element('voting', array(
          'plugin' => 'voting',
          'model' => 'Marker',
          'id' => '4c39716f-1334-46a8-bdb3-788150431cad',
          'config' => array(
              'plugin_voting' => array(
                  'Voting.showOptionResults' => true,
                  'Voting.showOptionTitles' => true,
                  'Voting.showResult' => false)),
          'name' => 'votingdemo2',
          'title' => __('Do you really like this plugin?', true)));
?>
<h4>
<?php
  if ($session->read(Configure::read('Voting.sessionUserId'))) {
    echo 'Your are logged in. ('.$session->read(Configure::read('Voting.sessionUserId')).')';
  } else {
    echo 'Your are guest. ('.$session->read('Voting.guest_id').')';
  }
?>
</h4>
<?php
  if ($session->read(Configure::read('Voting.sessionUserId'))) {
    echo $form->create('', array('action' => 'logout', 
                                 'type' => 'link'));
    echo $form->submit('Logout');
    echo $form->end();
  } else {
    echo $form->create('', array('action' => 'login', 
                                 'type' => 'link'));
    echo $form->submit('Login');
    echo $form->end();
  }
?>