<div class="comments index">
<h2><?php __('Comments');?></h2>
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
	<th><?php echo $paginator->sort('marker_id');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('comment');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($comments as $comment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $comment['Comment']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($comment['Marker']['title'], array('controller' => 'markers', 'action' => 'view', $comment['Marker']['id'])); ?>
		</td>
		<td>
			<?php echo $comment['Comment']['title']; ?>
		</td>
		<td>
			<?php echo $comment['Comment']['comment']; ?>
		</td>
		<td>
			<?php echo $comment['Comment']['status']; ?>
		</td>
		<td>
			<?php echo $comment['Comment']['created']; ?>
		</td>
		<td>
			<?php echo $comment['Comment']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $comment['Comment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $comment['Comment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $comment['Comment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['Comment']['id'])); ?>
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
		<li><?php echo $html->link(__('New Comment', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Marker', true), array('controller' => 'markers', 'action' => 'add')); ?> </li>
	</ul>
</div>
