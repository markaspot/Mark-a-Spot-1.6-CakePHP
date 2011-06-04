<?php 
/**
 * Mark-a-Spot Index Template
 *
 * Index View Splashpage
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
 * @version    1.6 beta 
 */


echo $this->element('head', array('cache'=> 3600));?>


<?php		
	/*
	 * Breadcrumb
	 *
	 */

	echo '<div id="breadcrumb"><div>';
	echo $html->addcrumb(
		__('Home',true),
			'/',
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
	<div id="content">
		<h2><?php __('Welcome to mas-city.com/markaspot') ?></h2>


		<!-- p class="intro"><?php __('Managing Concerns of Public Space') ?></p -->
			<hr class="hidden"/>
		<div id="linksIndex">
			<?php echo $this->element('intro_deu');?>

			<div id="bubble">

				<h3>Machen Sie mit!</h3>
				<?php 	if ($session->read('Auth.User.id')) {
									$action = "add";
								} else {
									$action = "startup";
								}
				?>
				<ul id="nav">
					<li class="MasOverviewAdd">
						<?php echo $html->link('Beteiligen Sie sich ...', array('controller' => 'markers', 'action' => $action),array('class'=>'add')); ?>
					</li>
				</ul>
			</div>
			<div id="bubblePeak">
				<?php echo $this->element('search');?>
			</div>
			<br style="clear:left">
			<?php if($attachments):?>

			<div id="media">
				<h3><?php __('Reports with fotos');?></h3>
				<div>


				<?php

				$i = 0;

				foreach($markersPublished as $markerPublished){

					foreach($attachments as $attachment){

						$i++;
						if($attachment['Attachment']['foreign_key'] == $markerPublished['Marker']['id'] && $attachment['Attachment']['dirname'] == "img") {
							echo '<div class="thumb">';
									echo '<a class="lightbox imageThumbView" href="/media/filter/xl/'.$attachment['Attachment']['dirname']."/".substr($attachment['Attachment']['basename'],0,strlen($attachment['Attachment']['basename'])-3).'png">';
									
									echo '<img src ="/media/filter/s/'.$attachment['Attachment']['dirname']."/".substr($attachment['Attachment']['basename'],0,strlen($attachment['Attachment']['basename'])-3).'png"/></a>
									<div>
										<div class="clear"></div>';
									echo $html->link(__('View details',true), array('action' => 'view', $attachment['Attachment']['foreign_key']), array('escape'=>false)).'</div>
								</div>';
						} 

					if ($i >= 9) {
						break;
					}
					
					}


				}
				
				?>



				</div>
			</div>
			<?php endif;?>
			
		</div>	
		<hr class="hidden"/>
		<div id="listIndex">
			<div id="map_wrapper_splash">
			<?php echo $html->link('', array('controller' => 'markers', 'action' => 'app'), array('title' => __('Click to watch the map',true), 'id' => 'start', 'escape' => false)); ?></div>
			<noscript><p><?php 
				echo $html->link($html->image('http://maps.google.com/staticmap?center='.$googleCenter.'&amp;zoom=10&amp;size=320x200&amp;maptype=mobile\&amp;markers='.$googleCenter.',bluea%7C&amp;key='.$googleKey.'&amp;sensor=false'), array('controller' => 'markers', 'action' => 'app'), array('escape' => false)); ?> 
			</p></noscript>
			<div class="clear"></div>
			<h3><?php __('Recent changes') ?></h3>
			<ul class="marker_splash">
			<?php
			$i = 0;
			foreach ($markers as $marker):
			$i++;

			?>
				<li><div class="color_<?php echo $marker['Status']['hex'] ?>">
					<?php echo $html->link($text->truncate($marker['Marker']['subject'],60, array('ending' => '... ', 'exact' => false)), array('action' => 'view', $marker['Marker']['id']), array('escape'=>false)); ?>
					<p class="status">Status: <?php echo $marker['Status']['name'] ?></p><p class="transactions"><?php __('This happened:') ?> <?php if (isset($marker['Transaction'][0]['name'])) { echo __($marker['Transaction'][0]['name'],true);}?></p></div><small class="meta"><?php echo $marker['User']['nickname']; ?><?php __(', on '); echo $datum->date_de($marker['Marker']['modified'],1);?></small>
				</li>
			<?php 
					if ($i >= 3) {
						//echo '<div class="thumb_empty">'.__('No picture available',true).'</div>';
						break;
					}
			?>	
			<?php endforeach; ?>
			</ul>

		</div>
	</div>