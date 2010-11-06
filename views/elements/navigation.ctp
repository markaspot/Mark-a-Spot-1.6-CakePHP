<?php
		echo '<ul class="sf-menu">';
			echo '<li class="nav_map" title="'.__('All Content in a Map,Filter in Categories or view Ratings',true).'">'.$html->link(__('Map', true), array(
			'plugin' => null, 'controller' => 'karte', 'admin' => false)).'</li>';
			echo '<li class="nav_list" title="'.__('View all Markers in List view',true).'">'.$html->link(__('List Markers', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'liste', 'admin' => false, 'mine' => false)).'</li>';
		if ($session->read('Auth.User.id') && $userGroup != $uGroupAdmin) {
			echo '<li class="nav_list" title="'.__('View Markers in List view',true).'">'.$html->link(__('Your markers', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'liste', 'admin' => false, 'mine' => true)).'</li>';
			echo '<li class="nav_list" title="'.__('Add a Marker',true).'">'.$html->link(__('Add another marker', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'add', 'admin' => false)).'</li>';
		}
		 else if (!$session->read('Auth.User.id')){
			echo '<li class="nav_add" title="'.__('Participate by clicking on the map and add some content',true).'">'.$html->link(__('Add a marker', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'startup', 'admin' => false)).'</li>';
		}

		/*
		if ($userGroup == $uGroupSysAdmin) {	
				echo '<li>'.$html->link(__('Categories', true), array(
					'controller' => 'categories', 'action' => 'index', 'admin' => true)).'</li>';
				echo '<li>'.$html->link(__('User', true), array(
					'controller' => 'users', 'action' => 'index', 'admin' => true)).'</li>'
		}
		*/
		if (!$session->read('Auth.User.id')) {
/*
		echo $ajax->link( 'View Post', array( 'controller' => 'hello', 'action' => 'world', 1 ), array(
		 'update' => 'post', 'title' => 'your nice title for this link' ));
*/

			echo '<li class="nav_signup" title="'.__('Already signed up or have a Twitter or Facebook Account?',true).'">'.$html->link(__('Log in', true), array(
				'plugin' => null, 'controller' => 'users', 'action' => 'login'), array(
					'title' =>'')
					
				);
			//echo ' <fb:login-button></fb:login-button>';

			//echo ' <a class="tw_button tw_button_medium" href="/twitter/connect">
			//	<span class="tw_button_text">Twitter-Login</span></a>';
			//echo '<li class="nav_signin">'.$html->link(__('Registrieren', true), array('controller' => '/users', 'action' => 'signup')).'</li>';
			echo '</li>';

		} else {
		
			if ($session->read('Twitter')){
		
				echo '<li class="nav_signout">'.$html->link(__('Log out', true), array(
					'plugin' => null, 'controller' => 'users', 'action' => 'logout', 'admin' => false)).'</li>';
			} elseif ($session->read('FB')){
		
				echo '<li class="fb_signout">'.$facebook->logout(array(
					'redirect' => '/logout', 'label' => __('Facebook logout',true))).'</li>';
			} else {
		
				echo '<li class="nav_signout">'.$html->link(__('Log out', true), array(
					'plugin' => null, 'controller' => 'users', 'action' => 'logout', 'admin' => false)).'</li>';
			}
		}
/*
		if($session->read('FB')) {
			echo $facebook->logout(array('redirect' => '/logout', 'label' => 'Sign Out'));
		}
*/
		
		echo '</ul>';

?>
