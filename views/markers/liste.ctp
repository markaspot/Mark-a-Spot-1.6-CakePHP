<?php
/**
 * Mark-a-Spot List.Action
 *
 * Show accessible list with markers and pagination
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
 * @version    1.3 beta 
 */
 
echo $this->element('head');
?>
<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
			__('Home',true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
			__('Map',true),
		array(
		'controller'=>'markers',
		'action'=>'app'),
		array('escape'=>false)
	);
	$html->addcrumb(
			__('List',true),
		array(
		'controller'=>'markers',
		'action'=>'liste'),
		array('escape'=>false)
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
		<?php if(isset($this->params['named']['mine'])) {?>
		<h2 style=""><?php __('Your Markers');?></h2>
		<?php } else { ?>
		<h2 style=""><?php __('All Markers ');?></h2>
		<?php }?>
		<div id="tabAll">
			<?php if(isset($this->params['named']['mine'])) {?>
				<div id="markerMyList" class="ui-widget-content ui-state-default"></div> 
			<?php } else { ?>
				<div id="markerList" class="ui-widget-content ui-state-default"></div> 
			<?php }?>
		</div>
			<noscript>
			<div class="markers index">
				<div id="listNoscript">
					<?php
					echo $paginator->counter(array(
					'format' => __('Page %page% of %pages% | %current% Markers of %count%', true)
					));
					?>
					<h3><?php __('Sort markers');?></h3>
					<ul id="sortUser">
						<li><?php echo $paginator->sort(__('Subject',true), 'Marker.subject');?></li>
						<li><?php echo $paginator->sort(__('Category',true), 'Category.name');?></li>
						<li><?php echo $paginator->sort(__('District',true), 'Marker.city');?></li>
						<li><?php echo $paginator->sort(__('Status',true), 'Status.name');?></li>
						<li><?php echo $paginator->sort(__('Rating',true), 'Marker.rating');?></li>
						<li><?php echo $paginator->sort(__('Modified',true), 'Marker.modified');?></li>
					</ul>
					
					<ul class="marker_static">
					<?php
					$i = 0;
					foreach ($markers as $marker):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
							<li><img alt="<?php __('static map');?>" src="http://maps.google.com/staticmap?center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=14&amp;size=150x150&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blue%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false" />
							<h3><?php echo $html->link($marker['Marker']['subject'], array(
								'action' => 'view', $marker['Marker']['id'])); ?></h3>
								<span><small><?php echo $marker['User']['nickname']; ?>, gemeldet: <?php echo $datum->date_de($marker['Marker']['created'],1);?></small></span>
							<ul>
								<li class="image_static"></li>
								<li class="category_<?php echo $marker['Category']['hex']; ?>"><?php __('Category:');?> <?php echo $marker['Category']['name']; ?></li>
								<li class="district_static"><a href="#" onclick="map.setCenter(<?php echo $marker['District']['lat']; ?>,<?php echo $marker['District']['lon']; ?>)"><?php echo $marker['District']['name']; ?></a></li>
								<li class="color_<?php echo $marker['Status']['hex']; ?>"><?php __('Status:');?> <?php echo $marker['Status']['name']; ?></li>
							</ul>
						</li>
						<li><h4><?php __('Address')?>:</h4><?php echo $marker['Marker']['street']; ?><br/><?php echo $marker['Marker']['zip']; ?> <?php echo $marker['Marker']['city']; ?></li>
	
						<li class="actions static">
								<?php echo $html->link(__('Details', true), array('action' => 'view', $marker['Marker']['id']),array('class' => 'button small')); ?>
								<?php 
								// gehoert der Marker diesem User?
								if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) 	
									echo $html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class' => 'button small')); ?>
								<?php 
								// gehoert der Marker diesem User?
								if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) 	
									echo $html->link(__('Delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class' => 'button small'), sprintf(__('Are you sure to delete Marker # %s?', true), $marker['Marker']['id'])); 
								?><br style="clear:both"/><hr/></li>
					<?php endforeach; ?>
					</ul>
					<div id="pagination">
						<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
						 | 	<?php echo $paginator->numbers();?>
						<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
					</div>
			</div>
		</div>
		</noscript>

	</div>
	
	<!-- content end -->

	<noscript>

	<div id="sidebar" class="app">
		<div id="views"></div>
		<!---
		<h3><?php __('Choose district');?></h3>
		<div id="district">
		<form id="districtSelectForm" method="post" action="/hiernochauftabelle">
			<div>
			<?php
				echo '<select id="disctrictSelect">';
				foreach ($districts as $district):
					echo '<option class="district" value="'.$district['District']['lat'].', '.$district['District']['lon'].'">'.$district['District']['name'].'</option>';
				endforeach; 
				echo '</select>';
			?>
			</div>
		</form>
		</div>
		-->
		
		<h3><?php __('Choose category');?></h3>
		<div id="category">	
		<?php
			
		echo '<ul id="categorySelect">';
				foreach ($categories as $categoryId):
					foreach ($categoryId as $id => $categoryValue):
						$categoryElements = explode(';',$categoryValue);
		 				echo '<li class="category_'.$categoryElements[1].'">'.$html->link($categoryElements[0], array('controller'  => '/markers', 'action' => 'liste', 'category' => $id), array('id'=>'categoryId_'.$id));
			 			echo '</li>';
					endforeach; 
				endforeach; 
			echo '</ul>';

		?>
		</div>
			
		<h3><?php __('Choose status');?></h3>	
		<div id="status">
		<?php
			echo '<ul id="statusSelect">';
			foreach ($statuses as $status):
			 	echo '<li class="status_'.$status['Status']['hex'].'">'.$html->link($status['Status']['name'], array('controller'  => '/markers', 'action' => 'liste', 'status' =>$status['Status']['id']), array('id'=>'statusId_'.$status['Status']['id'])).'</li>';
			endforeach; 
			echo '</ul>';
		?>
		</div>
	</div>

	</noscript>
	<div id="map" style="display:none"></div>

<!-- Sidebar ende-->
