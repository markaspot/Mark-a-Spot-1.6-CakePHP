<?php 
/**
 * Mark-a-Spot Index Template
 *
 * Index View Splashpage
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


echo $this->element('head_nomap'); 

echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Logged in via Twitter', true),
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

<?php		
	/*
	 * Breadcrumb
	 *
	 */
?>
	<div id="content">
		<h2><?php __('Twitter API Credentials') ?></h2>

		<div><?php echo __('<p>Thank you. You are now logged in with your twitter Account and your Nickname is:</p>',true);?></div>
		<div class="twitterScreenname"><?php echo $this->Session->read('Twitter.screen_name');?></div>
		<div><?php echo __('<p>If you find your way back to this plattform just log in by clicking on the Twitter Connect Link again:</p>',true);?></div>

		<?php //pr($twitter)?>
	</div>