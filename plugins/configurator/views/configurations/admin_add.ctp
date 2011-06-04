<?php echo $this->element('head', array('cache'=> 3600));?>

<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);

	$html->addcrumb(
		__('Admin Dashboard', true),
		array(
			'controller'=>'pages',
			'action'=>'admin_index',
			'admin' => true)
		);

	$html->addcrumb(
		__('Configuration', true),
		array(
		'admin' => true,
		'plugin' => 'configurator',
		'controller' => 'configurations',
		'action' => 'admin_add')
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
	
		<h2 id="h2_title"><?php __('Add Configuration Property');?></h2>

		<?php echo $this->Form->create('Configuration');?>
			<fieldset>
		 		<legend><?php __d('configurator', 'Add Configuration'); ?></legend>
			<?php
				echo $this->Form->input('key', array(
					'error' => array(
						'isUnique' => __d('configurator', 'The key must be unique.', true),
						'rightFormat' => __d('configurator', 'The key can contain only alphanumerical characters, underscore and a dot. It cannot start or end or have more than one subsequent dot.', true),
						'reservedKeys' => __d('configurator', 'That key is reserved and cannot be used.', true)
					)
				));
				echo $this->Form->input('value');
				echo $this->Form->input('title');
				echo $this->Form->input('description');

			?>
			</fieldset>
		<?php
			echo '<p>';
			echo $html->tag('button', __('<span>Save information</span>',true), array('type' => 'submit'));
			echo '</p>';
			echo $form->end();
		?>

	</div>
	<div id="sidebar">
			<?php echo $this->element('admin_sidebar');?>
	</div>	