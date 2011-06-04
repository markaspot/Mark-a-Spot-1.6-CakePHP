<div class="districts form">
<?php echo $form->create('District');?>
	<fieldset>
 		<legend><?php __('Edit District');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('city_id');
		echo $form->input('district_id');
		echo $form->input('name');
		echo $form->input('lat');
		echo $form->input('lon');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('District.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('District.id'))); ?></li>
		<li><?php echo $html->link(__('List Districts', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Marker', true), array('controller' => 'markers', 'action' => 'add')); ?> </li>
	</ul>
</div>
