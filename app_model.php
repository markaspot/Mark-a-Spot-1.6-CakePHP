<?php
/**
 * Mark-a-Spot AppModel
 *
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.5.1 
 */


class AppModel extends Model {
	
	var $cleanData = false;

 	function beforeSave() {
		if (!empty($this->data) && $this->cleanData === true) {
			App::import('Sanitize');
			$this->data = Sanitize::clean($this->data,array('encode' => false));
		}
		
	return true;
	}
	function invalidate($field, $value = true) {
		return parent::invalidate($field, __d('default', $value, true));
	}

	
}

?>