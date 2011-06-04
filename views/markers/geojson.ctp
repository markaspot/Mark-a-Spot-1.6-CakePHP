<?php 
/**
 * Mark-a-Spot JSON FIle
 *
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
 * @version    1.3 beta 
 */
/*
 
if ($markers) {
	echo $javascript->object($markers);  
}


*/
echo $this->element('geojson', array('cache'=> null));?>
