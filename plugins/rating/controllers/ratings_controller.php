<?php
/**
 * Controller for the AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.4
 */
class RatingsController extends RatingAppController {
  /**
   * Renders the content for the rating element.
   *
   * @param string $model Name of the model
   * @param integer $id Id of the model
   * @param string $options JSON/BASE64 encoded options
   */
   
 var $uses = array('Marker');
 var $components = array('Transaction');


   
  function beforeFilter() {
   $this->Auth->allow(array('save', 'view'));

  }

   
   
  function view($model = '', $id = 0, $options = '') {
    $this->layout = null;

	if ($this->RequestHandler->isMobile()) {

		Configure::write('Rating.mobile', true);
	}
    
    $userRating = null;
    $avgRating = null;
    $votes = null;
    $modelInstance = ClassRegistry::init($model);
    $optionsData = json_decode(base64_decode($options), true);
    
    $name = $optionsData['name'];
    $config = $optionsData['config'];    
    
    // load the config file
    $this->__loadConfig($config);
    
    // setup guest access
    if (Configure::read('Rating.guest') 
        && !$this->Session->check(Configure::read('Rating.sessionUserId'))) {
      $this->__setupGuest();
    }
    
    // check if user id exists in session
    if (Configure::read('Rating.showHelp') 
        && !Configure::read('Rating.guest') 
        && (!$this->Session->check(Configure::read('Rating.sessionUserId')) 
            || !$this->Session->read(Configure::read('Rating.sessionUserId')) > 0)) {
      echo '<p>Warning: No valid user id was found at "'.Configure::read('Rating.sessionUserId').'" in the session.</p>';
    }
    
    // check if model id exists
    $modelInstance->id = $id;
    
    if (Configure::read('Rating.showHelp') && !$modelInstance->exists(true)) {
      echo '<p>Error: The model_id "'.$id.'" of "'.$model.'" does not exist.</p>';
    }

    // choose between user id and guest id
    if (!$this->Session->read(Configure::read('Rating.sessionUserId')) 
        && (Configure::read('Rating.guest') && $this->Session->read('Rating.guest_id'))) {
      $userId = $this->Session->read('Rating.guest_id');
    } else {
      $userId = $this->Session->read(Configure::read('Rating.sessionUserId'));
    }

    if (!empty($userId)) {
      $userRating = $this->Rating->field('rating',
                                         array('model' => $model, 
                                               'model_id' => $id, 
                                               'user_id' => $userId,
                                               'name' => $name));
    }

    if (empty($userRating)) {
      $userRating = 0;
    }
    
    // retrieve rating values from model or calculate them
    if (Configure::read('Rating.saveToModel')) {
      if (Configure::read('Rating.showHelp') 
          && !$modelInstance->hasField(Configure::read('Rating.modelAverageField'))) {
        echo '<p>Error: The average field "'.Configure::read('Rating.modelAverageField').'" in the model "'.$model.'" does not exist.</p>';
      }
      
      if (Configure::read('Rating.showHelp') 
          && !$modelInstance->hasField(Configure::read('Rating.modelVotesField'))) {
        echo '<p>Error: The votes field "'.Configure::read('Rating.modelVotesField').'" in the model "'.$model.'" does not exist.</p>';
      }
      
      $values = $modelInstance->find(array($modelInstance->name.".".$modelInstance->primaryKey => $id),
                                     array(Configure::read('Rating.modelAverageField'), 
                                           Configure::read('Rating.modelVotesField')),
                                     null,
                                     -1);
      
      $avgRating = $values[$modelInstance->name][Configure::read('Rating.modelAverageField')];
      $votes = $values[$modelInstance->name][Configure::read('Rating.modelVotesField')];
    } else {
      $values = $this->Rating->find(array('model' => $model,
                                          'model_id' => $id,
                                          'name' => $name),
                                    array('AVG(Rating.rating)', 'COUNT(*)'));
      
      $avgRating = round($values[0]['AVG(`Rating`.`rating`)'], 1);
      $votes = $values[0]['COUNT(*)'];
    }
    
    if (empty($votes)) {
      $votes = 0;
    }
    
    if ($avgRating && !strpos($avgRating, '.')) {
      $avgRating = $avgRating.'.0';
    } else if (!$avgRating) {
      $avgRating = '0.0';
    }

    $this->set('id', $id);
    $this->set('model', $model);
    $this->set('config', $config);
    $this->set('options', $optionsData);
    $this->set('data', array('%VOTES%' => $votes.' '.__('Vote(s)', true), 
                             '%RATING%' => $userRating, 
                             '%AVG%' => $avgRating,
                             '%MAX%' => Configure::read('Rating.maxRating')));
    $this->render('view');
  }
  
  /**
   * Saves the user selected rating value. Depending on the plugin 
   * configuration, it also updates or deletes the rating.
   *
   * @param string $model Name of the model
   * @param integer $id Id of the model
   * @param integer $value User rating value
   */
  function save($model = '', $id = 0, $value = 0) {
    $this->layout = null;
    $saved = false;
    $fallback = false;
    $referer = Controller::referer();
    
    $name = $this->params['url']['name'];
    $config = $this->params['url']['config'];
    
    // load the config file
    $this->__loadConfig($config);
    
    // data from fallback form
    if (isset($this->params['url']['fallback']) 
        && $this->params['url']['fallback']) {
      $fallback = true;
      
      $model = $this->params['url']['model'];
      $id = $this->params['url']['rating'];
      $value = $this->params['url']['value'];
    }

    // check if model id exists
    $modelInstance = ClassRegistry::init($model);
    $modelInstance->id = $id;
    
    if (!$modelInstance->exists(true)) {
      if (!$fallback) {
        $this->view($model, $id, base64_encode(json_encode(array('name' => $name, 'config' => $config))));
      } else {
        $this->redirect($referer);
      }
      
      return;
    }
    
    // choose between user and guest id
    if (Configure::read('Rating.guest') && $this->Session->read('Rating.guest_id')) {
      $userId = $this->Session->read('Rating.guest_id');
    } else {
      $userId = $this->Session->read(Configure::read('Rating.sessionUserId'));
    }
    
    // check if a rating already exists 
    $userRating = $this->Rating->find(array('model' => $model, 
                                            'model_id' => $id, 
                                            'user_id' => $userId,
                                            'name' => $name));
    
    // save, update or delete rating
    if (!empty($userRating) && Configure::read('Rating.allowChange')) {
      $this->Rating->id = $userRating['Rating']['id'];
      
      if ($userRating['Rating']['rating'] == $value && Configure::read('Rating.allowDelete')) {
        $this->Rating->delete($userRating['Rating']['id']);
        $saved = true;
      } else {
        $saved = $this->Rating->saveField('rating', $value);
		$this->Transaction->log($id);
		//$this->$model->id = $id;
		//$this->$model->saveField('transaction_id', $this->Transaction->id);	
      }
    } else if (empty($userRating) && $userId) {
      $this->data['Rating']['rating'] = $value;
      $this->data['Rating']['model'] = $model;
      $this->data['Rating']['model_id'] = $id;
      $this->data['Rating']['user_id'] = $userId;
      $this->data['Rating']['name'] = $name;
      
      $this->Rating->create();
      $saved = $this->Rating->save($this->data);
      
      $this->Transaction->log($id);
    }
    
       
    // set flash message
    if ($saved && Configure::read('Rating.flash')) {
      $this->Session->setFlash(Configure::read('Rating.flashMessage'), 
                               'default', 
                               array('class' => 'rating-flash'),
                               'rating');
    }    
    
    // save rating values to model
    if ($saved && Configure::read('Rating.saveToModel')) {
      // check if fields exist in model
      if (!$modelInstance->hasField(Configure::read('Rating.modelAverageField')) 
          && !$modelInstance->hasField(Configure::read('Rating.modelVotesField'))) {
        if (!$fallback) {
          $this->view($model, $id, base64_encode(json_encode(array('name' => $name, 'config' => $config))));
        } else {
          $this->redirect($referer);
        }
        
        return;
      }
      
      // retrieve actual rating values 
      $values = $this->Rating->find(array('model' => $model,
                                          'model_id' => $id,
                                          'name' => $name),
                                    array('AVG(Rating.rating)', 'COUNT(*)'));

      $avgRating = round($values[0]['AVG(`Rating`.`rating`)'], 1);
      $votes = $values[0]['COUNT(*)'];
      
      if ($avgRating && !strpos($avgRating, '.')) {
        $avgRating = $avgRating.'.0';
      } else if (!$avgRating) {
        $avgRating = '0.0';
      }

      if (empty($votes)) {
        $votes = '0';
      }
      
      $modelInstance->id = $id;
      
      // save rating values
      if ($modelInstance->exists()) {
        $modelInstance->saveField(Configure::read('Rating.modelAverageField'), $avgRating);
        $modelInstance->saveField(Configure::read('Rating.modelVotesField'), $votes);
      }
    }
    
    // show view again
    if (!$fallback) {
      $this->view($model, $id, base64_encode(json_encode(array('name' => $name, 'config' => $config))));
    } else {
      if ($saved && Configure::read('Rating.fallbackFlash')) {
        $this->flash(Configure::read('Rating.flashMessage'), Controller::referer());
        $this->Session->setFlash(null);
      } else {
        $this->redirect($referer);
      }
    }
    
    $this->autoRender = false;
  }
  
  /**
   * Loads a config file.
   * 
   * @param $file Name of the config file
   */
  function __loadConfig($file) {
    // still support config values of v2.3 elements
    if (count(explode('.', $file)) > 0) {
      $file = str_replace('.', '_', $file);
    }
    
    // load config from app config folder
    if (Configure::load($file) === false) {
      // load config from plugin config folder
      if (Configure::load('rating.'.$file) === false) {
        echo '<p>Error: The '.$file.'.php could not be found in your app/config or app/plugins/rating/config folder. Please create it from the default rating/config/plugin_rating.php.</p>';
      }
    }
  }
  
  /**
   * Setup the guest id in session and cookie.
   */
  function __setupGuest() {
    if (!$this->Session->check('Rating.guest_id') 
        && !$this->Cookie->read('Rating.guest_id')) {
      App::import('Core', 'String');
      $uuid = String::uuid();

      $this->Session->write('Rating.guest_id', $uuid);
      $this->Cookie->write('Rating.guest_id', $uuid, false, Configure::read('Rating.guestDuration'));
    } else if (Configure::read('Rating.guest') 
               && $this->Cookie->read('Rating.guest_id')) {
      $this->Session->write('Rating.guest_id', $this->Cookie->read('Rating.guest_id'));
    }
  }
}
?>