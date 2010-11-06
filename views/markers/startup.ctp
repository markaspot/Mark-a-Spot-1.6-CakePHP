<?php 
/**
 * Mark-a-Spot Startup form (Signup and Add)
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
echo $this->element('head');
echo $javascript->link('jquery/jquery.validation.min.js', false); 
echo $validation->bind(array('Marker', 'User','Profile'),array('messageId' => 'validateMessage'));
//echo $javascript->link('jquery/tiny_mce/jquery.tinymce.js', false);

?>
<div id="validateMessage"><p></p></div>
<h1 class="hidden"><?php __('Add a marker');?></h1>
<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Map', true),
		array(
			'controller'=>'markers',
			'action'=>'app'),
			array('escape'=>false)
	);
	$html->addcrumb(
		__('Add a Marker', true),
		array(
		'controller'=>'markers',
		'action'=>'startup'),
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
		<h2 id="h2_title"><?php __('Add a Marker');?></h2>

		<p><?php echo __('Enter details of the problem. Please note that all fields marked with "*" are mandatory.');?></p>
		<?php echo $form->create('Markers', array('enctype' => 'multipart/form-data', 'url' => array('controller'  => 'markers', 'action'  => 'startup')) );?>
			<fieldset>
				 <legend><?php __('Enter marker details');?></legend>
				 	<?php echo $this->element('form_startup'); ?>
			</fieldset>
			<?php echo '<p>'.$html->tag('button', '<span>'.__('Save information',true).'</span>', array('type' => 'submit')).'</p>';?>
			<?php echo $form->end();?>

	</div>
	<div id="sidebar">
		<h3><?php __('Where does it happen? Localize!')?></h3>
		<p><?php echo __('Please drag the Marker to the desired position or just enter street and zip details');?></p>
		<div id="map_wrapper_add"></div>
	</div>

