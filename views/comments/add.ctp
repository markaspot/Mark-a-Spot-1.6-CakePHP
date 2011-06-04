<div class="comments form">
<?php echo $form->create('Comment');?>
	<fieldset>
 		<legend><?php __('Add Comment');?></legend>
	<?php
		echo $form->input('marker_id');
		echo $form->input('title');
		echo $form->input('comment');
		echo $form->input('status');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Comments', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Marker', true), array('controller' => 'markers', 'action' => 'add')); ?> </li>
	</ul>
</div>
