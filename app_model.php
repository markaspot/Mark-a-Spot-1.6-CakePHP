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
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4.6 
 */

 

class AppModel extends Model {
	
	//var $actsAs = array('Containable');
	//var $recursive = -1;

 	var $cleanData = false;

 	function beforeSave() {
		if (!empty($this->data) && $this->cleanData === true) {
			App::import('Sanitize');
			$this->data = Sanitize::clean($this->data,array('encode' => false));
		}
		
	return true;
	}
	
}

?>