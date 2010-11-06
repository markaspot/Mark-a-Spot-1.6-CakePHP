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
 * @version    1.3 beta 
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
			?>
				<li><div class="color_<?php echo $marker['Status']['hex'] ?>">
					<?php echo $html->link($text->truncate($marker['Marker']['subject'],60, array('ending' => '... ', 'exact' => false)), array('action' => 'view', $marker['Marker']['id']), array('escape'=>false)); ?>
					<p class="status">Status: <?php echo $marker['Status']['name'] ?></p><p class="transactions"><?php __('This happened:') ?> <?php echo __($marker['Transaction'][0]['name'],true);?></p></div><small class="meta"><?php echo $marker['User']['nickname']; ?><?php __(', on '); echo $datum->date_de($marker['Marker']['modified'],1);?></small>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
    <?php //echo '<div id="debug">'.$this->element('sql_dump').'</div>'; ?> 
