<?php
/**
 * Voting plugin for CakePHP 1.3
 *
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt

 * @version 1.0
 */

class VotingAppController extends AppController {
  var $uses = array('Voting.Voting');
  var $helpers = array('Voting.Voting', 'Javascript');
  var $components = array('Cookie', 'Session','RequestHandler');
  
  /**
   * @var Voting
   */
  var $Voting;
}
?>