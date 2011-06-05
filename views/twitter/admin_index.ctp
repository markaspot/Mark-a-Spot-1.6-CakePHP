<?php 
/**
 * Mark-a-Spot Administration View for authorities
 *
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
 * @version    1.4 beta 
 */
 
 
echo $this->element('head_nomap');
$javascript->link('jquery/jquery.validation.min.js', false); 
?>

<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);

	$html->addcrumb(
		__('Admin Dashboard', true),
		array(
			'controller'=>'pages',
			'action'=>'admin_index',
			'admin' => true)
		);

	$html->addcrumb(
		__('Admin Tweets', true),
		array(
			'controller'=>'twitter',
			'action'=>'index',
			'admin' => true),
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
	<h2 id="h2_title"><?php echo __('Admin Tweets',true);?></h2>
	<hr class="hidden"/>
		<?php 
			echo $form->create(false, array(
				'enctype' => 'multipart/form-data', 'controller' => 'twitter', 'action' => 'admin_reply'))?>	


		<?php
		$i = 0;
		
		if ($response){
			foreach ($response as $result):
				$class = null;
				$i++;
				// Check if result 
				if(isset($result->ignore)){ 
					$class = 'class="tweetIgnore"';
				} else {
					$class = 'class="tweetDispatch"';
				
				}
				
			?>
			
				<div id="<?php echo $result->id_str?>" <?php echo $class?>>
					<img class="avatar" alt="<?php echo $result->user->screen_name?>" style="float:left" src="<?php echo $result->user->profile_image_url?>"/><span><?php echo $result->user->screen_name?></span><br/>
						<?php
						$linked_tweet = $text->autoLink($result->text);
						echo $linked_tweet ?>
						<small><? echo $result->created_at?></small>
					<?php
						echo '<div>';
						echo $this->Form->label( __('Import to Mark-a-Spot',true));
						echo $this->Form->checkbox('Twitter.'.$i.'.import', array('class' => 'importCheck', 'between' => ''));
						if (isset($result->geo->coordinates)) {
							echo $form->hidden('Twitter.'.$i.'.geo.lat', array(
								'value' => $result->geo->coordinates[0])); 
							echo $form->hidden('Twitter.'.$i.'.geo.lon', array(
								'value' => $result->geo->coordinates[1])); 
						} else {
							echo '<span class="tweetNoGeo">'.__('No geolocation given', true).'</span>';
							if(Configure::read('Twitter.GeoMust')){
								echo '<script type="text/javascript">$("#Twitter'.$i.'Import").attr("disabled",true);</script>';
							}
						}
						echo '</div>';
						echo '<div class="twitterAdmin">';
						echo $this->Form->input('Twitter.'.$i.'.Category', array(
							'type' => 'select', 'options' => $categories, 'empty' => __('Please choose', true)
						));
						//pr($statuses);
						echo $this->Form->input('Twitter.'.$i.'.Status', array(
							'type' => 'select', 'options' => $statuses, 'empty' => __('Please choose', true))
						);
	
						
						echo '</div>';
						

					?>
					<div><a class="showReact" href="#"><?php __('Reply before Import')?></a></div>

					<div class="tweetReact" id="<?php echo $result->id_str?>_react">
						<?php 
						
						$types = array(1 => __('More details',true), 2 => __('Detailed address',true), 3 => __('A picture?',true));
						
						echo $this->Form->input('Twitter.'.$i.'.feedback', array('options' => $types,
							'type' => 'radio', 'disabled' => false, 'div' => array(
								'class' => 'form'),
						));
							
						echo '<div>';
						echo $this->Form->label(__('Ignore Tweet',true)); 
						echo $this->Form->checkbox('Twitter.'.$i.'.ignore', array('class' => 'ignoreCheck', 'between' => ''));	
						echo '</div>';
	
						

	
						

	
						echo $form->hidden('Twitter.'.$i.'.sender_id', array(
							'value' => $result->user->id)); 
						echo $form->hidden('Twitter.'.$i.'.sender_name', array(
							'value' => $result->user->screen_name)); 
						echo $form->hidden('Twitter.'.$i.'.reply_to', array(
							'value' => $result->id_str)); 
						echo $form->hidden('Twitter.'.$i.'.text', array(
							'value' => $result->text)); 
					?>
					</div>
				</div>

			<?php endforeach; ?>
			
			<?php 
				
				echo '<p>';
				echo $html->tag('button', __('<span>Save information</span>',true), array('type' => 'submit'));
				echo '</p>';
				echo $form->end();
			?>
		
		<?php } else {?>
			<div>
		
			<?php echo __('No Tweets with Mentions or #hashtag', true); ?>
				
			</div>
			
		<?php }?>

</div>

<div id="sidebar">
			<?php echo $this->element('admin_sidebar');?>
</div>	