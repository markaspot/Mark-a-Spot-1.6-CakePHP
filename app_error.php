<?php
/**
 * Mark-a-Spot ErrorHandler
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
 * @version    1.4.6 
 */


 
  class AppError extends ErrorHandler {
    function error404($params) {  
		//header('HTTP/1.0 404 Not Found');
		//$this->controller->redirect(array('controller'=>'pages', 'action'=>'error-404'));
    }
  }
 
?>