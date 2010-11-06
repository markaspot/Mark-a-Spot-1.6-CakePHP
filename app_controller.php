<?php
/**
 * Mark-a-Spot AppController
 *
 * Auth
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4 beta 
 */

App::import('Sanitize');

class AppController extends Controller {
	
var $uses = array('Marker', 'Rating', 'District',
		 'Groups_user', 'User', 'Comment', 'Group');

	var $components = array('Auth', 'Cookie', 'Session','MathCaptcha');	


	public $statusCond;
	
	function beforeFilter(){
		//Read Mark-a-Spot Config app-wide
		Configure::load('mark-a-spot');

		//Override default fields used by Auth component
		$this->Auth->fields = array('username' => 'email_address', 'password'=>'password');

		//Set application wide actions which do not require authentication
		$this->Auth->allow(array(
			'startup', 'confirm', 'index', 'searches', 'searchable', 'suche', 
				'signup', 'rss', 'maprate', 'app', 'liste', 'useticket', 'newpassword', 
					'resetpassword', 'login', 'logout', 'imprint', 'faq', 'contact','get', 'vote',
						'startup', 'index', 'ratesum', 'geojson', 'view', 'ratings', 'maprate',
							'comments', 'ajaxlist', 'ajaxmylist', 'districts', 'rss', 'catlist','preview', 'infolast'
			)
		);
		$this->Auth->logoutRedirect = '/karte';
		$this->Auth->loginRedirect = "";
		$this->Auth->loginError = __('Username or password not found', true);
		$this->Auth->authError = __('You are not authorized to access this location', true);
		$this->Auth->authorize = 'controller';
		$this->Auth->userScope = array('User.active >=1');
		
		// Read groupIds from config files
		$this->Session->write('uGroup', Configure::read('userGroup'));
		$uGroupAdmin 	= Configure::read('userGroup.admins');
		$uGroupSysAdmin = Configure::read('userGroup.sysadmins');
		$uGroupUser 	= Configure::read('userGroup.users');
	
		//Read Mark-A-Spot Config app-wide
		
		$this->_setLanguage();
		
		$this->set('googleCenter', Configure::read('Google.Center'));
		$this->set('googleKey', Configure::read('Google.Key'));
		
		$this->set('software', Configure::read('mas'));
		
		$this->set('uGroupAdmin', Configure::read('userGroup.admins'));
		$this->set('uGroupSysAdmin', Configure::read('userGroup.sysadmins'));
		$this->set('uGroupUser', Configure::read('userGroup.users'));
			
		if ($this->Auth->user('id')) {
		
			// create session for user and group for rating and voting
			$this->Session->write('User.id', $this->Auth->user('id'));
			$userGroup = $this->Groups_user->field('group_id',array(
				'user_id' => $this->Auth->user('id')), 'user_id');
			
			$this->Session->write('userGroup', $userGroup);
			$this->set("userGroup", $this->Session->read('userGroup'));
			
			if ($this->Session->read('userGroup') == $uGroupAdmin || 
				$this->Session->read('userGroup') == $uGroupSysAdmin) {
					$this->Cookie->write('admin', 1, true, '+2 weeks');
			}

			// CanAccess checks if marker belongs to user
			if (in_array($this->action, array('delete', 'edit', 'preview')) 
				&& isset($this->params['pass'][0])) {
				
				if (!$this->Marker->canAccess($this->Auth->user('id'), $this->params['pass'][0]) 
					&& $userGroup != $uGroupSysAdmin && $userGroup != $uGroupAdmin) {
					$this->Session->setFlash(__('You are not allowed here!',true), 'default',array(
						'class' => 'flash_error'));
					$this->redirect(array('action' => 'index'));
				}
			}
		} else {
			$this->Cookie->delete('admin');
			$this->set("userGroup", "");
		}

		$userGroup = $this->Session->read('userGroup');
		$uGroup    = $this->Session->read('uGroup');		
		if ($userGroup == $uGroup['sysadmins'] || $userGroup ==  $uGroup['admins'] ){
			$this->statusCond = 0;
		} else {
			$this->statusCond = 1;
		}
		
		if ($this->action == "startup" && $this->params['named']) {
			$this->Session->write('addAdress.street', $this->params['named']['street']);
			$this->Session->write('addAdress.zip', $this->params['named']['zip']);
			$this->Session->write('addAdress.city', $this->params['named']['city']);

		}

		

	}
	
	/**
	 * Add Markers directly (included-registration)
	 *
	 */
	
	function _getAdminMail (){
		$adminUsers = $this->Group->find(array('Group.id'=>Configure::read('userGroup.admins')));
		//pr($adminUsers);

		foreach($adminUsers['User'] as $adminUser){
			
			$adminUserEmail[] = $adminUser['email_address'];
		}
		return $adminUserEmail;
	}
	
	/**
	 * Set Language during Runtime
	 *
	 */
	 
	function _setLanguage() {
		
		if ($this->Cookie->read('lang')) {
			$this->Session->write('Config.language', $this->Cookie->read('lang'));
			Configure::write('Config.language', $this->Cookie->read('lang'));
			$this->set('lang', $this->Cookie->read('lang'));
			
		}
		
		if (isset($this->params['language'])) {
			$this->Cookie->delete('lang');  
			$this->Session->write('Config.language', $this->params['language']);
			Configure::write('Config.language', $this->params['language']);
			$this->Cookie->write('lang', $this->params['language'], null, '20 days');
			$this->redirect('http://:'.Configure::read('Site.domain'));
		
		} else {
		
			$this->set('lang', Configure::read('Config.language'));
		}
	}

	/**
	 * after authentication, check authorization
	 *
	 */

	function beforeRender(){

		if($this->Auth->user()){
			$this->set('currentUser', $this->Auth->user());
			$controllerList = Configure::listObjects('controller');
			$permittedControllers = array();

			foreach($controllerList as $controllerItem){

				if($controllerItem <> 'App'){
					if($this->__permitted($controllerItem, 'index')){
						$permittedControllers[] = $controllerItem;
					}
				}
			}
		}
		$this->set(compact('permittedControllers'));
	}


	/**
	* isAuthorized
	* 
	* Called by Auth component for establishing whether the current authenticated 
	* user has authorization to access the current controller:action
	* 
	* @return true if authorised/false if not authorized
	* @access public
	*/
	function isAuthorized(){
		return $this->__permitted($this->name, $this->action);
	}

	/**
	* __permitted
	* 
	* Helper function returns true if the currently authenticated user has permission 
	* to access the controller:action specified by $controllerName:$actionName
	* @return 
	* @param $controllerName Object
	* @param $actionName Object
	*/
	function __permitted($controllerName,$actionName){

		$controllerName = low($controllerName);
		$actionName = low($actionName);

		if(!$this->Session->check('Permissions')){
		//...then build permissions array and cache it
			$permissions = array();
			//everyone gets permission to logout
			$permissions[]='users:logout';
			//Import the User Model so we can build up the permission cache
			App::import('Model', 'User');
			$thisUser = new User;
			//Now bring in the current users full record along with groups
			$thisGroups = $thisUser->find(array('User.id'=>$this->Auth->user('id')));
			$thisGroups = $thisGroups['Group'];

			foreach($thisGroups as $thisGroup){
				$thisPermissions = $thisUser->Group->find(array('Group.id'=>$thisGroup['id']));
				$thisPermissions = $thisPermissions['Permission'];

				foreach($thisPermissions as $thisPermission){
					$permissions[]=$thisPermission['name'];
				}
			}
		//write the permissions array to session
			$this->Session->write('Permissions',$permissions);
		} else {
			//...they have been cached already, so retrieve them
			$permissions = $this->Session->read('Permissions');
		}

		foreach($permissions as $permission){
			if($permission == '*'){
				return true;//Super Admin Bypass Found
			}
			if($permission == $controllerName.':*'){
				return true;//Controller Wide Bypass Found
			}
			if($permission == $controllerName.':'.$actionName){
				return true;//Specific permission found
			}
		}
		return false;
	}
	
	/**
	 * Builds the search index for the current model based on existing data.
	 */
	function admin_build_search_index()
	{
		$this->autoRender = false;
		
		$model =& $this->{$this->modelClass};
		
		if(!isset($model->Behaviors->Searchable)) {
			echo "<pre>Error : the {$model->alias} model is not linked with Searchable Behavior.</pre>";
			exit;
		}
		
		$data = $model->find('all');
		
		foreach($data as $row){
			$model->set($row);
			$model->Behaviors->Searchable->Search->saveIndex(
				$model->alias,
				$model->id,
				$model->buildIndex()
			);
		}
		
		echo "<pre>Search index for model {$model->alias} have been built.</pre>";
	}


	/**
	 * Delete the search index for the current model.
	 */
	function admin_delete_search_index()
	{
		$this->autoRender = false;
		
		$model =& $this->{$this->modelClass};
		
		if(!isset($model->Behaviors->Searchable))
		{
			echo "<pre>Error : the {$model->alias} model is not linked with Searchable Behavior.</pre>";
			exit;
		}
		
		$model->Behaviors->Searchable->Search->deleteAll(array(
			'model' => $model->alias
		));
		
		echo "<pre>Search index for model {$model->alias} have been deleted.</pre>";
	}


	/**
	 * Rebuilds the search index for the current model based on existing data.
	 */
	function admin_rebuild_search_index()	{
		$this->admin_delete_search_index();
		$this->admin_build_search_index();
	}
}
?>