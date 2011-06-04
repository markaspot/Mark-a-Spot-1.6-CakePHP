<?php
/**
 * Mark-a-Spot Index.Page Intro-File
 *
 * Welcome Message 
 * extending breadcumb
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
 * @version    1.5 beta 
 */
 
 	echo '<hr class="hidden"/>';
	if ($session->read('Auth.User.id')) {
		echo '<div id="welcome">';
		__('You are logged in as ');
		echo ($currentUser['User']['nickname']).', ';
		//Change logout text ('logout' by default)
		if ($session->read('FB')){
			echo $facebook->logout(array('redirect' => '/logout', 'label' => __('Facebook logout',true))).'</div>';
		} else {	
			echo $html->link(__('log out', true), array('controller'  => 'users', 'action' => 'logout')).'</div>';
		}
	} else {
		echo '<div id="welcome">';
		__('Welcome visitor, ');
		echo $html->link(__('please log in', true), array('controller'  => 'users', 'action' => 'login'));
		
/*
		$locale = $session->read('Config.language');
		switch ($locale) {
			case 'deu':
				echo ' <span>'.$html->link('[english]', array('language'=>'eng')).'</span>';
				break;
			case 'eng':
				echo ' <span>'.$html->link('[deutsch]', array('language'=>'deu')).'</span>';
				break;
			default:
				echo ' <span>'.$html->link('[english]', array('language'=>'eng')).'</span>';
		}
		
*/
		
		echo '</div>';
	}
?>