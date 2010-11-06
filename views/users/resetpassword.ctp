<?php
/**
 * Mark-a-Spot User login
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
 * @version    0.98
 */

echo $this->element('head'); 
$javascript->link('jquery/jquery.validation.min.js', false); 
echo $validation->bind('User',array('form'=>'UserLoginForm'));	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Reset your password', true),
		array(
			'controller'=>'users',
			'action'=>'login'),
			array('escape'=>false)
	);
	echo $html->getCrumbs(' / ');
	echo '</div>';
	
		
		
	/*
	 * Welcome User with Nickname
	 *
	 */
	echo $this->element('welcome'); 
	echo '</div>';

?>
<div id="content">
	<h2 id="h2_title"><?php __('Reset your password');?></h2>

	<?php 
		echo $form->create(array('action' => 'resetpassword'));
		echo $form->input('email',array('before'=> __('<div>Enter the e-mail address you used for registration</div>',true), 'label' => __('e-mail', true), 'between'=>'<br/>', 'div'=>'text required')); 
		echo $form->input('security_code', array('before'=> __('<div>To prevent spammers, please calculate:</div>',true), 'div'=>'text required', 'between'=>'<br/>', 'label'
							 => $mathCaptcha));
		echo $html->tag('button', __('<span>Request e-mail</span>.',true), array('type' => 'submit'));
	?>
</div>
	<div id="sidebar">
		<p><?php echo __('You haven&rsquo;t been here yet and want to add a marker?',true);?></p>
		<ul>
		<?php
		echo '<li>'.$html->link(__('Add a marker directly', true), array('controller' => '/', 'action' => 'startup')).'</li>';
		echo '<li>'.$html->link(__('Lost your password?', true), array('controller' => 'users', 'action' => 'resetpassword')).'</li>';
 		?>
		</ul>
	<div id="map" style="visibility:hidden"></div>
	</div>