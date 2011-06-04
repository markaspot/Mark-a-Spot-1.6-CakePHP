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
			'admin' => true,
			'plugin' => null
			)
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
		<?php echo $this->Form->create('Configuration');?>
		<fieldset>
	 		<legend><?php __d('configurator', 'Edit Configuration'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('title');
			echo $this->Form->input('description');
	
			echo $this->Form->input('key', array(
				'error' => array(
					'isUnique' => __d('configurator', 'The key must be unique.', true),
					'rightFormat' => __d('configurator', 'The key can contain only alphanumerical characters, underscore and a dot. It cannot start or end or have more than one subsequent dot.', true),
					'reservedKeys' => __d('configurator', 'That key is reserved and cannot be used.', true)
				), 
				'disabled' => true
			));
			if (strlen($this->data['Configuration']['value'] == 1 && $this->data['Configuration']['value'] == 0 || $this->data['Configuration']['value'] == 1 )) {
					echo $form->input('value', array(
					'type' => 'checkbox', 'label' => __('enabled?',true)
					)
				);
			} else { 
				echo $this->Form->input('value');
			}
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