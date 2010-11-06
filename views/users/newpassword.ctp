<?php
/**
 * Mark-a-Spot New password if called with ticket
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
echo $validation->bind('User');	
echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Enter a new password', true),
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
	<h2 id="h2_title"><?php __('Choose a new password');?></h2>

	<div class="required"> 
		<strong><?php __('User')?>: </Strong><?php echo $this->data['User']['nickname'] ;?>
	</div>
	<?php 
		echo $form->create('User', array('action' => 'newpassword'));
		echo $form->input('password' ,array('label' => __('Passwort', true), 'between'=>'<br/>', 'class'=>'text'));
		echo $form->input('passwd',array('label' => __('Password repeat', true), 'between'=>'<br/>', 'class'=>'text'));
		echo $form->hidden('id');	
		echo $html->tag('button', __('<span>Save new password</span>', true), array('type' => 'submit'));	?>

</div>
<div id="sidebar">
	<?php echo $html->link(__('Add a marker', true), array('controller' => 'markers', 'action' => 'startup'));?>
	<div id="map" style="visibility:hidden"></div>
</div>