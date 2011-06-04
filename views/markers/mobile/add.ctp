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
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.3 beta 
 */
echo $this->element('head_mobile');
echo $this->Html->script('jquery/jquery.validation.min.js', false); 
echo $validation->bind(array('Marker'));

?>
	
<div data-role="page" data-theme="b" data-back-btn-text="Start" >
	<div data-role="header">
		<h1><?php __('Add a marker') ?></h1>
	</div><!-- /header -->

	<div data-role="content" id="mobile">	
		<div id="map_wrapper_add"></div>
	
		<?php echo $form->create('Markers', array(
			'enctype' => 'multipart/form-data', 'url' => array(
				'controller'  => 'markers', 'action'  => 'add')
				)
			);
		?>

		<?php 
		if ($session->check('Message.flash')) {
			echo $session->flash();  
		}
		if ($session->check('Message.auth')) {
			echo $session->flash('auth');  
		}
		
		?>

		<div data-role="fieldcontain">

		<?php
			echo $form->input('Marker.street', array(
				'label' => __('Address',true))
				);


			echo $form->input('Marker.zip', array(
				'p' => 'input text required', 'maxlength'=>'5', 
				'label' => __('Zip',true))
				);
			// City Input can be disabled or not (it's not submitted, if disabled)


			echo $form->input('Marker.city', array('type' => 'hidden',
				'p' => 'input text required', 'readonly' => true, 
				'label' => __('City',true)));
		?>
		</div>

		<div data-role="fieldcontain">

		<?php
			echo $form->input('Marker.subject', array(
				'maxlength'=>'128', 
				'label' => __('Subject',true)));
		?>
		</div>
		
		<div data-role="fieldcontain">

		<?php
			echo $form->input('Marker.description', array('p' => 'input text', 'label' => __('Describe the situation',true)));

		?>
		</div>
		
		<?php
			if (!strstr($_SERVER['HTTP_USER_AGENT'],"iP")):?>
		<div data-role="fieldcontain">
		<?php
			echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
		?>
		</div>
		<?php endif; ?>
		<div data-role="fieldcontain">

		<?php

			echo $form->input('Marker.category_id',array('p' => 'input text required', 'before' => __('<div>Please take a look at the categories</div>',true), 'label' => __('Category',true), 'empty' => __('Please choose',true)));
			//echo $form->input('Marker.status_id',array('label' => __('Status',true), 'disabled' => true));
		?>
		</div>
		
		
		<?php 
		// End form
		echo '<p>'.$html->tag('button', '<span>'.__('Save information',true).'</span>', array(
			'type' => 'submit', 'data-icon' => 'check')).'</p>';?>
	<?php echo $form->end();?>

	</div><!-- /content -->
</div><!-- /page -->

