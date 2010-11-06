<?php
/**
 * Mark-a-Spot User signup
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
echo $validation->bind(array('User'));
echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Sign up', true),
		array(
			'controller'=>'users',
			'action'=>'signup'),
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
<h2 id="h2_title"><?php __('Signup');?></h2>

<?php
	echo $form->create('User', array('action' => 'signup'));
?>

<?php
echo $form->input('nickname',array('label' => __('Nickname',true), 'between'=>'<br/>', 'class'=>'text'));
echo $form->input('email_address',array('label' => __('E-mail',true), 'between'=>'<br/>', 'class'=>'text'));
# echo $form->input('sirname',array('label' => 'Nachname', 'between'=>'<br/>', 'class'=>'text'));
# echo $form->input('prename',array('label' => 'Vorname', 'between'=>'<br/>', 'class'=>'text'));
# echo $form->input('fon',array('label' => 'Telefon für Rückfragen', 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('password' ,array('label' => __('Password',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('passwd',array('label' => __('Password repeat',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '<div id="addFormPersonals"><a class="showLink" href="#addFormPersonals">'.__('Want to tell us more about you?', true).'</a>';
	
	echo '<div id="addFormPersonalsDiv">';
	echo $form->input('Profile.sirname',array('label' => __('Sirname',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('Profile.prename',array('label' => __('Name',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('Profile.fon',array('label' => __('Phone',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '</div>';	
	echo '</div>';	
	echo $form->input('Profile.newsletter',array('div' => 'input text required', 'type' => 'checkbox', 'before' => __('<div>Newsletter?</div>',true),'label' => __('Newsletter?',true), 'between'=>'<br/>', 'class'=>'text'));

	
echo $form->input('security_code', array('before'=> __('<div>To prevent spammers, please calculate:</div>',true), 'div'=>'text required', 'between'=>'<br/>', 'label'
							 => $mathCaptcha));
		echo $html->tag('button', __('<span>Sign up</span>.',true), array('type' => 'submit'));

echo $form->end();?>

<!-- content end -->
</div>
<div id="sidebar">
		<?php //echo $this->element('navigation_sidebar');
		echo '<p>Already signed up?, '.$html->link(__('Log in', true), array('controller' => '/', 'action' => 'login')).'</p>';
		echo '<p>Ihre Daten werden nicht weitergegeben. Sie dienen lediglich der Kommunikation zwischen Ihnen und der Verwaltung. Weitere Hinweise zum Datenschutz, Verfahren und System. Anschrift und Ansprechpartner</p>';
?>

</div>	