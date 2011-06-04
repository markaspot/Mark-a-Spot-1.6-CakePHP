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
			'plugin' => null)

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
		<h2><?php  __d('configurator', 'Configuration');?></h2>
		<dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __d('configurator', 'Key'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $configuration['Configuration']['key']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __d('configurator', 'Value'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<pre><?php echo htmlspecialchars($configuration['Configuration']['value']); ?></pre>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __d('configurator', 'Created'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $configuration['Configuration']['created']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __d('configurator', 'Modified'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $configuration['Configuration']['modified']; ?>
				&nbsp;
			</dd>
		</dl>
	</div>


	<div id="sidebar">
		<?php echo $this->element('admin_sidebar');?>
			
		<div class="actions">
			<h3><?php __d('configurator', 'Actions'); ?></h3>
			<ul>
				<li><?php echo $this->Html->link(__d('configurator', 'Edit', true), array('action' => 'edit', $configuration['Configuration']['id'])); ?> </li>
				<li><?php echo $this->Html->link(__d('configurator', 'Delete', true), array('action' => 'delete', $configuration['Configuration']['id']), null, sprintf(__d('configurator', 'Are you sure you want to delete "%s"?', true), $configuration['Configuration']['key'])); ?> </li>
				<li><?php echo $this->Html->link(__d('configurator', 'List Configurations', true), array('action' => 'index')); ?></li>
			</ul>
		</div>
	</div>	


