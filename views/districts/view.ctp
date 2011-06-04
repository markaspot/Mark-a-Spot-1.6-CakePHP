<div class="districts view">
<h2><?php  __('District');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<?php echo $this->element('ajaxlist_element'); ?>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['city_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Marker'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($district['Marker']['id'], array('controller' => 'markers', 'action' => 'view', $district['Marker']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['lat']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lon'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['lon']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $district['District']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit District', true), array('action' => 'edit', $district['District']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete District', true), array('action' => 'delete', $district['District']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $district['District']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Districts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New District', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Marker', true), array('controller' => 'markers', 'action' => 'add')); ?> </li>
	</ul>
</div>
