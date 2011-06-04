<div class="districts index">
<h2><?php __('Districts');?></h2>
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
	<th><?php echo $paginator->sort('city_id');?></th>
	<th><?php echo $paginator->sort('district_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('lat');?></th>
	<th><?php echo $paginator->sort('lon');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($districts as $district):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $district['District']['id']; ?>
		</td>
		<td>
			<?php echo $district['District']['city_id']; ?>
		</td>
		<td>
			<?php echo $html->link($district['Marker']['id'], array('controller' => 'markers', 'action' => 'view', $district['Marker']['id'])); ?>
		</td>
		<td>
			<?php echo $district['District']['name']; ?>
		</td>
		<td>
			<?php echo $district['District']['lat']; ?>
		</td>
		<td>
			<?php echo $district['District']['lon']; ?>
		</td>
		<td>
			<?php echo $district['District']['created']; ?>
		</td>
		<td>
			<?php echo $district['District']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $district['District']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $district['District']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $district['District']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $district['District']['id'])); ?>
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
		<li><?php echo $html->link(__('New District', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Markers', true), array('controller' => 'markers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Marker', true), array('controller' => 'markers', 'action' => 'add')); ?> </li>
	</ul>
</div>
