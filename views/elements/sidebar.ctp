<?
echo '<ul>';
			echo '<li>'.$html->link(__('Markers', true), array(
			'plugin' => null, 'controller' => 'markers', 'action' => 'liste','admin' => false)).'</li>';
			echo '<li>'.$html->link(__('Users', true), array(
				'plugin' => null, 'controller' => 'users', 'action' => 'index', 'admin' => true)).'</li>';
		if ($session->read('Auth.User.id') && $userGroup != $uGroupAdmin) {
			echo '<li>'.$html->link(__('Your markers', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'liste', 'admin' => false, 'mine' => true)).'</li>';
			echo '<li>'.$html->link(__('Add another marker', true), array(
				'plugin' => null, 'controller' => 'markers', 'action' => 'add', 'admin' => false)).'</li>';
		}
		 else if (!$session->read('Auth.User.id')){
			echo '<li>'.$html->link(__('Add a marker', true), array(
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
/*
		if($session->read('FB')) {
			echo $facebook->logout(array('redirect' => '/logout', 'label' => 'Sign Out'));
		}
*/
		
echo '</ul>';
