<?php
class ConfigurationsController extends ConfiguratorAppController {

	var $name = 'Configurations';
	var $uses = array('Configurator.Configuration');
	var $components = array('Session');
	var $helpers = array('Text','Javascript');

	/*
			Standard baked admin methods below
	*/

	function admin_index() {
	
		$this->layout = 'default_page';
		$this->set('title_for_layout', __('Administration',true));

		$this->Configuration->recursive = 0;
		$this->set('configurations', $this->paginate());
	}

	function admin_view($key = null) {
	
		$this->layout = 'default_page';
		$this->set('title_for_layout', __('Administration',true));

		if (!$key) {
			$this->Session->setFlash(__d('configurator', 'Invalid configuration.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('configuration', $this->Configuration->read(null, $key));
	}

	function admin_add() {
	
		$this->layout = 'default_page';
		$this->set('title_for_layout', __('Administration',true));

		if (!empty($this->data)) {
			$this->Configuration->create();
			if ($this->Configuration->save($this->data)) {
				$this->Session->setFlash(__d('configurator', 'The configuration has been saved.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('configurator', 'The configuration could not be saved.', true).' '.__d('configurator', 'Please, try again.', true));
			}
		}
	}

	function admin_edit($key = null) {
		$this->layout = 'default_page';
		$this->set('title_for_layout', __('Administration',true));

		if (!$key && empty($this->data)) {
			$this->Session->setFlash(__d('configurator', 'Invalid configuration.', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Configuration->save($this->data)) {
				$this->Session->setFlash(__d('configurator', 'The configuration has been saved.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('configurator', 'The configuration could not be saved.', true).' '.__d('configurator', 'Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Configuration->read(null, $key);
		}
	}

	function admin_delete($key = null) {
	
		if (!$key) {
			$this->Session->setFlash(__d('configurator', 'Invalid configuration.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Configuration->delete($key)) {
			$this->Session->setFlash(__d('configurator', 'Configuration deleted.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('configurator', 'Configuration was not deleted.', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function index($key = null) {

		$this->layout = 'ajax'; 
		$this->Configuration->recursive = -1;

		$configurations = $this->Configuration->find('all', array('fields' => array(
			'Configuration.value', 'Configuration.key')));
		$this->set('js', Configure::read('js'));

		/*
foreach($configurations as $conf){

			//create the Config-Array
			if(stristr($conf['Configuration']['key'], 'js')) {
				$config[$conf['Configuration']['key']] = $conf['Configuration']['value'];
			} 
		}

		$this->set('configurations', $config);
*/

	}
}

