<?php echo $this->element('head_nomap', array('cache'=> 3600));?>

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

<div id="content" class="full">
	<h2><?php __d('configurator', 'Configurations');?></h2>

	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('key');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>

			<th><?php echo $this->Paginator->sort('value');?></th>
			<th class="actions"><?php __d('configurator', 'Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($configurations as $cfg):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

			<td>
				<?php echo $this->Html->link($cfg['Configuration']['title'], array('action' => 'view', $cfg['Configuration']['id'])); ?>
			</td>
			
			<td>
				<?php echo $this->Html->link($cfg['Configuration']['key'], array('action' => 'view', $cfg['Configuration']['id'])); ?>
			</td>
			
			<td>
				<?php echo $cfg['Configuration']['description']; ?>
			</td>
			
			<td><?php echo $this->Text->truncate(htmlspecialchars($cfg['Configuration']['value']), 50); ?>&nbsp;</td>
			<td class="actions">
				<?php //echo $html->link(__('Details', true), array('action' => 'view', $user['User']['id']),array('class'=>'link_view')).' '; ?>
				<?php 

				if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
					echo $html->link(__('View', true), array(
						'action' => 'view', $cfg['Configuration']['id']),array(
							'class' => 'button small green'
							)
						).' ';

					echo $html->link(__('Edit', true), array(
						'action' => 'edit', $cfg['Configuration']['id']),array(
							'class' => 'button small orange'
							)
						).' ';

					echo $html->link(__('Delete', true), array(
						'action' => 'delete', $cfg['Configuration']['id']),array(
							'class' => 'button small red', 'title' => sprintf(__('Are you sure to delete config # %s?', true), $cfg['Configuration']['id'])
						)
					);
				} 
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<div class="actions">
		<h3 class="hidden"><?php __d('configurator', 'Actions'); ?></h3>
			<?php echo $html->link(__('Add', true), array(
				'action' => 'add'),array('class' => 'button small blue')); ?>
	</div>
	<p><?php echo $this->Paginator->counter(array('format' => __d('configurator', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __d('configurator', 'previous', true), array(), null, array('class' => 'disabled'));?>
		| <?php echo $this->Paginator->numbers(); ?> |
		<?php echo $this->Paginator->next(__d('configurator', 'next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>


