<div class="statuses index">
<h2><?php __('Statuses');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<?php echo $this->element('ajaxlist_element'); ?>

<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('lft');?></th>
	<th><?php echo $paginator->sort('rght');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('hex');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($statuses as $status):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $status['Status']['id']; ?>
		</td>
		<td>
			<?php echo $status['Status']['parent_id']; ?>
		</td>
		<td>
			<?php echo $status['Status']['lft']; ?>
		</td>
		<td>
			<?php echo $status['Status']['rght']; ?>
		</td>
		<td>
			<?php echo $status['Status']['name']; ?>
		</td>
		<td>
			<?php echo $status['Status']['hex']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $status['Status']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $status['Status']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $status['Status']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $status['Status']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Processcat', true), array('action' => 'add')); ?></li>
	</ul>
</div>
