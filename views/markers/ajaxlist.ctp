<?php
/**
 * Mark-a-Spot Ajaxlist Action
 *
 * Show table with markers and ajax pagination
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.6
 */
?>
<script type="text/javascript">
$(document).ready(function() {
  	$('a.button').wrapInner(document.createElement("span"));
  	$('a.add').wrapInner(document.createElement("span"));
  	$('a.view').wrapInner(document.createElement("span"));

  	$('a.button').wrapInner(document.createElement("span"));
  	$('a.button').wrapInner(document.createElement("span"));
  	$('a.link_rss').wrapInner(document.createElement("span"));
  	$('a.link_password').wrapInner(document.createElement("span"));

	
	$("a.lightbox").fancybox();
	
	$('td>a.button.red').click(function(event) {
	
		if (confirm($(this).attr("title"))){
			var prev = $(this).parent().parent();
			$.ajax({
				type: 'get',
				url: '<?php echo Configure::read('js.masDir');?>markers/delete/'+ prev.attr('id'),
				beforeSend: function() {
				},
				success: function() {
					prev.animate({'backgroundColor':'#fb6c6c'}, 300);
					prev.fadeOut(600,function() {
						prev.remove();
					});
				}
			});
			event.preventDefault();

		} else {

			return false;
		}
	});
	$('#adminWhat').text("<?php __('hide');?>");
	$('#toggle').toggle(
		function() {
			$('.administrate').slideUp('fast');
			$('#toggle').addClass('active');
			$('#adminWhat').text("<?php __('show');?>");

		},
		function() {
			$('.administrate').slideDown('fast');
			$('#toggle').removeClass('active');
			$('#adminWhat').text("<?php __('hide');?>");

		}
		
	);

});
</script>

<div id="tabList">
	<form id="tabFilter">
		<fieldset id="tabCategory"><legend><?php __('Filter List');?></legend>
		<label for="listCategorySelect"><?php __('Choose category');?></label>	
		<?php
			echo '<select id="listCategorySelect">';
			echo '<option value="'.$html->url(array(
					'controller'  => '/markers', 'action' => $this->params['action'], 'category' =>$category['Category']['id'])).'">'.__('Choose category',true).'</option>';

			foreach ($categories as $id => $value):
			
			if ($id == $getIdCategory) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option class="category_'.$id.'"'.$selected.' value="'.$html->url(array('controller'  => '/markers', 'action' => $this->params['action'], 'category' =>$id)).'">'.$value.'</option>';
			endforeach; 
			echo '</select>';
		?>
		</fieldset>
			
		<fieldset id="tabStatus">
		<label for="listStatusSelect"><?php __('Choose status');?></label>	
		
		<?php
			echo '<select id="listStatusSelect">';
			echo '<option>'.__('Choose status',true).'</option>';

			foreach ($statuses as $status):
			if ($status['Status']['id'] == $getIdStatus) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option class="status_'.$status['Status']['hex'].'"'.$selected.' value="'.$html->url(array('controller'  => '/markers', 'action' => $this->params['action'], 'status' =>$status['Status']['id']), array('id'=>'statusCond_'.$status['Status']['id'])).'">'.$status['Status']['name'].'</option>';
			endforeach; 
			echo '</select>';
		?>
		</fieldset>
	</form>
<?php
	echo $paginator->counter(array(
	'format' => __('Page %page% of %pages% | %current% Markers of %count%', true)
	));
	?>
	<?php // Admin Links 
	if ($session->check('Auth.User.id')) {	?>
		<div id="adminLink"><div><?php __('Links');?> <span id="adminWhat"></span></div> <a id="toggle" href="#tabFilter"><span><?php __('edit');?></span></a></div>
	<?php } ?>

	<table cellpadding="0" cellspacing="0">
	<tr id="sortUser">
		<th><?php echo $paginator->sort(__('Subject',true), 'Marker.subject');?></th>
		<th><?php echo $paginator->sort(__('Choose Category',true), 'Category.name');?></th>
		<th><?php echo $paginator->sort(__('Status',true), 'Status.name');?></th>
		<th><?php echo $paginator->sort(__('Rating',true), 'Marker.rating');?></th>
		<th><?php echo $paginator->sort(__('Votes',true), 'Marker.votes');?></th>
		<th><?php echo $paginator->sort(__('Voting Yes',true), 'Marker.voting_pro');?></th>
		<th><?php echo $paginator->sort(__('Voting No',true), 'Marker.voting_con');?></th>
		<th><?php echo $paginator->sort(__('Voting Abs',true), 'Marker.voting_Abs');?></th>
		<th class="date"><?php echo $paginator->sort(__('Modified',true), 'Marker.modified');?></th>
	<?php
		if ($session->check('Auth.User.id')) {	?>

		<th class="marker_actions"><?php echo __('Actions',true)?></th>
	<?php } ?>
	</tr>
	<?php
	$i = 0;
	
	if (!$markers) {
		?>
		<tr><td colspan="10"><?php __('No Markers found')?></td></tr>
		<?php
	} else {
	foreach ($markers as $marker):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>
		<tr id="<?php echo $marker['Marker']['id']?>" class="marker">
			<td class="subject">
				<?php echo $html->link($marker['Marker']['subject'], array('action' => 'view', $marker['Marker']['id'])); ?><br/><span><?php echo $marker['User']['nickname']; ?></span><br/>
				<?php
				if ($marker['Marker']['lat'] != "0.000000") {
				?>
				<span class="address"><span class="street"><?php echo $marker['Marker']['street']?></span> <span class="zip"><?php echo $marker['Marker']['zip'];?></span> <span class="city"><?php echo $marker['Marker']['city'];?></span></span>
				<a class="lightbox map" href="http://maps.google.com/staticmap?.jpg&amp;center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=14&amp;size=330x330&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false"><span><?php __('Show in Map')?><span></a>
				<?php } else {?>
				<span class="address"><?php __('No adress given')?></span>
				<?php } ?>
			</td>
			<td>
				<?php echo $marker['Category']['name']; ?>
			</td>
			<td class="color_<?php echo $marker['Status']['hex']; ?>">
				<?php echo $marker['Status']['name']; ?>
			</td>
			<td class="rating">
				<?php //echo $marker['Marker']['rating']?>
				<?php  echo $marker['Marker']['rating']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>
			<td class="votes">
				<?php //echo $marker['Marker']['rating']?>
				<?php  echo $marker['Marker']['votes']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>
			<td class="votings">
				<?php //echo $marker['Marker']['rating']?>
				<?php  echo $marker['Marker']['voting_pro']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>
			<td class="votings">
				<?php //echo $marker['Marker']['rating']?>
				<?php  echo $marker['Marker']['voting_con']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>
			<td class="votings">
				<?php //echo $marker['Marker']['rating']?>
				<?php  echo $marker['Marker']['voting_abs']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>

			<td class="date">
				<?php echo $datum->date_de($marker['Marker']['modified'],1);?> </td>
			<?php if ($session->check('Auth.User.id')) {	?>
			<td class="marker_actions">
				<?php echo $html->link(__('Details', true), array('action' => 'view', $marker['Marker']['id']),array('class' => 'button small green')).' '; ?>
				<?php 
				// gehoert der Marker diesem User?
				if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {	
					echo $html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class' => 'button small orange')).' '; }
				 else if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
					echo $html->link(__('administrate', true), array('action' => 'admin_edit', $marker['Marker']['id'], 'admin' => true),array('class' => 'button small orange')).' ';
				 }
				// gehoert der Marker diesem User? 
				if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || $userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
					echo $html->link(__('Delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class' => 'button small red', 'title' => sprintf(__('Are you sure to delete marker # %s?', true), $marker['Marker']['id'])));
				} 
				?>
			</td>
		<?php } ?>
		</tr>


	<?php endforeach;
	} ?>
	</table>
	<div id="pagination">
			<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
		 | 	<?php echo $paginator->numbers();?>
			<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
