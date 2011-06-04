<?php
class VotingsController extends VotingAppController {

 	var $uses = array('Marker');
	var $components = array('Transaction');


  /**
   * Renders the content for the voting element.
   *
   * @param string $model Model name
   * @param integer $id Model id
   * @param string $name Voting name
   * @param string $config Config file
   */
   
  function view($model, $id, $name = 'default', $config = 'plugin_voting') {
    $this->layout = null;
	 if ($this->RequestHandler->isMobile()) {
 
    	  Configure::write('Rating.mobile', true);
  	}

    $userId = 0;
    $result = array();
    $vote = array();
    
    $modelInstance = ClassRegistry::init($model);
    $settings = Configure::read($model.'_'.$name.'_'.$id);
    
    // save overload settings in session (for ajax requests)
    if (!empty($settings)) {
      $this->Session->write($model.'_'.$name.'_'.$id, $settings);
    }
    
    // load the config file
    $this->__loadConfig($config, $this->Session->read($model.'_'.$name.'_'.$id));
    
    // setup guest access
    if (Configure::read('Voting.guest') 
        && !$this->Session->check(Configure::read('Voting.sessionUserId'))) {
      $this->__setupGuest();
    }
    
    // check if user_id exists in session
    if (Configure::read('Voting.showHelp') 
        && !Configure::read('Voting.guest') 
        && (!$this->Session->check(Configure::read('Voting.sessionUserId')) 
            || !$this->Session->read(Configure::read('Voting.sessionUserId')) > 0)) {
      echo '<p>Warning: No valid user id was found at "'.Configure::read('Voting.sessionUserId').'" in the session.</p>';
    }
    
    // check if model_id exists
    $modelInstance->id = $id;
    
    if (Configure::read('Voting.showHelp') && !$modelInstance->exists(true)) {
      echo '<p>Error: The model_id "'.$id.'" of "'.$model.'" does not exist.</p>';
    }

    // choose between user_id and guest_id
    if (!$this->Session->read(Configure::read('Voting.sessionUserId')) 
        && (Configure::read('Voting.guest') && $this->Session->read('Voting.guest_id'))) {
      $userId = $this->Session->read('Voting.guest_id');
    } else {
      $userId = $this->Session->read(Configure::read('Voting.sessionUserId'));
    }
    
    // get the voting
    $voting = $this->Voting->find('first', array(
                  'conditions' => array(
                      'model_id' => $id,
                      'model' => $model,
                      'name' => $name)));
    
    // get the voting user vote
    $vote = $this->Voting->findVote($voting['Voting']['id'], $userId);

    // get the voting result
    
    
    //if (!empty($vote)) {
      $result = $this->Voting->findResult($voting['Voting']['id']);
    //}
    
    
    
    $this->set('model', $model);
    $this->set('id', $id);
    $this->set('name', $name);
    $this->set('config', $config);
    $this->set('vote', $vote);
    $this->set('result', $result);
    
    $this->render('view');
  }
  
  /**
   * Saves the user voting.
   * 
   * @param string $model Model name
   * @param integer $id Model id
   * @param string $name Voting name
   * @param string $config Config file
   * @param integer $nr Option number
   * @param boolean $fallback Fallback flag
   */
  function vote($model, $id, $name, $config, $nr, $fallback = false) {
    $this->layout = null;
    $saved = false;
    $voting = array();
    $vote = array();
    $referer = Controller::referer();
    
    if ($fallback == 'false') {
      $fallback = false;
    }
    
    // load the config file
    $this->__loadConfig($config, Configure::read($model.'_'.$name.'_'.$id));
    
    // check if model id exists
    $modelInstance = ClassRegistry::init($model);
    $modelInstance->id = $id;
    
   
    
    if (!$modelInstance->exists()) {
      if (!$fallback) {
        $this->view($model, $id, $name, $config);
      } else {
        $this->redirect($referer);
      }
      
      return;
    }
    
    // choose between user and guest id
    if (!$this->Session->read(Configure::read('Voting.sessionUserId')) 
        && (Configure::read('Voting.guest') && $this->Session->read('Voting.guest_id'))) {
      $userId = $this->Session->read('Voting.guest_id');
    } else {
      $userId = $this->Session->read(Configure::read('Voting.sessionUserId'));
    }
    
    // get the voting
    $voting = $this->Voting->find('first', array(
                  'conditions' => array(
                      'model_id' => $id,
                      'model' => $model,
                      'name' => $name)));
    
    // get the user vote
    if (!empty($voting)) {
      $vote = $this->Voting->findVote($voting['Voting']['id'], $userId);
    }
    
    // save voting
    if (empty($vote)) {
      $saved = $this->Voting->saveVote($model, $id, $name, $userId, $nr); 
      
       // Writing Result to marker table
       // if saveToModel
       if (Configure::read('Voting.saveToModel')){
	       
	       switch ($nr) {
	       	case 0:
				$countField = $modelInstance->field(Configure::read('Voting.modelProField'));
	    		$modelInstance->saveField(Configure::read('Voting.modelProField'), $countField+1);    		
	    		break;
	    	case 1:
				$countField = $modelInstance->field(Configure::read('Voting.modelConField'));
	    		$modelInstance->saveField(Configure::read('Voting.modelConField'), $countField+1);    		
	      		break;
	  		case 2:
				$countField = $modelInstance->field(Configure::read('Voting.modelAbsField'));
	    		$modelInstance->saveField(Configure::read('Voting.modelAbsField'), $countField+1);    		
	      		break;
	  	    	
			}
		}
		$this->Transaction->log($id);


    }
    
    // set flash message
    if ($saved && Configure::read('Voting.flash')) {
      $this->Session->setFlash(Configure::read('Voting.flashMessage'), 
                               'default', 
                               array('class' => 'voting-flash'),
                               $model.'_flash_'.$name.'_'.$id);
    }
    
    // show view again (updated)
    if (!$fallback) {
      $this->view($model, $id, $name, $config);
    } else {
      $this->redirect($referer);
    }
    
    $this->autoRender = false;
  }
  
  /**
   * Loads a config file.
   * 
   * @param $file Config file name
   * @param $settings Overload settings
   */
  function __loadConfig($file, $settings) {
    // load config from app config folder
    if (Configure::load($file) === false) {
      // load config from plugin config folder
      if (Configure::load('voting.'.$file) === false) {
        echo '<p>Error: The '.$file.'.php could not be found in your app/config or app/plugins/voting/config folder. Please create it from the default voting/config/plugin_voting.php.</p>';
      }
    }
    
    // overload settings
    if (!empty($settings)) {
      foreach ($settings as $key => $setting) {
        Configure::write($key, $setting);
      }
    }
  }
  
  /**
   * Setup the guest id in session and cookie.
   */
  function __setupGuest() {
    if (!$this->Session->check('Voting.guest_id') 
        && !$this->Cookie->read('Voting.guest_id')) {
      App::import('Core', 'String');
      $uuid = String::uuid();

      $this->Session->write('Voting.guest_id', $uuid);
      $this->Cookie->write('Voting.guest_id', $uuid, false, Configure::read('Voting.guestDuration'));
    } else if (Configure::read('Voting.guest') 
               && $this->Cookie->read('Voting.guest_id')) {
      $this->Session->write('Voting.guest_id', $this->Cookie->read('Voting.guest_id'));
    }
  }
}
?>