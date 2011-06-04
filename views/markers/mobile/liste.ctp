<?php 
/**
 * Mark-a-Spot Startup form (Signup and Add)
 *
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
echo $this->element('head_mobile');

?>
	<div data-role="page" data-back-btn-text="Start">

	<div data-role="header" data-theme="b">
		<h1><?php __('List view') ?></h1>
	</div><!-- /header -->

	<div data-role="content">
		
		<ul data-role="listview">
		
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
								<p><?php echo $marker['User']['nickname']; ?>, gemeldet: <?php echo $datum->date_de($marker['Marker']['created'],1);?></p></li>
							
							
		<?php endforeach; ?>
		</ul>

		
<!--
					<div id="pagination">
						<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
						 | 	<?php echo $paginator->numbers();?>
						<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
					</div>
-->



	</div><!-- /content -->

</div><!-- /page -->

