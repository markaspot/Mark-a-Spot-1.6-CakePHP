<?php
		echo '<ul class="footerMenu">';
			echo '<li>'.$html->link(__('View markers in map', true), array('controller' => 'karte')).'</li>';
			echo '<li>'.$html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'liste')).'</li>';
			if ($session->read('Auth.User.id') && $userGroup != $uGroupAdmin) {
				echo '<li>'.$html->link(__('Your markers', true), array('controller' => 'markers', 'action' => 'liste', 'mine' => true)).'</li>';
				echo '<li>'.$html->link(__('Add another marker', true), array('controller' => 'markers', 'action' => 'add')).'</li>';
			} else {
				echo '<li>'.$html->link(__('Add a marker', true), array('controller' => 'markers', 'action' => 'startup')).'</li>';
			}
			//echo '</li>';
		
		if (!$session->read('Auth.User.id')) {
			echo '<li class="nav_signup">'.$html->link(__('Log in', true), array(
				'plugin' => null, 'controller' => 'users', 'action' => 'login')).'</li>';
			//echo '<li class="nav_signin">'.$html->link(__('Registrieren', true), array('controller' => '/users', 'action' => 'signup')).'</li>';
		}	
		else {
			if ($session->read('FB')){
				echo '<li class="nav_signout">'.$facebook->logout(array('redirect' => '/logout', 'label' => __('Facebook logout',true))).'</li>';
			} else {
				echo '<li class="nav_signout">'.$html->link(__('Log out', true), array(
					'plugin' => null, 'controller' => 'users', 'action' => 'logout', 'admin' => false)).'</li>';
			}
		}

		echo '</ul>';
?>