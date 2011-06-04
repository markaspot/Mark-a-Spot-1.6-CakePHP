<?php
/**
 * Mark-a-Spot Details View
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
$javascript->link('jquery/jquery.validation.min.js', false); 
echo $validation->bind('Comment',array('form'  => '#CommentCommentsaddForm'));
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Map', true),
		array(
			'controller'=>'markers',
			'action'=>'app'),
			array('escape'=>false)
	);
	$html->addcrumb(
		__('View details', true),
		array(
			'controller'=>'markers',
			'action'=>'view',
			$this->params['pass'][0])
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
	
<?php	
/*
	echo 'Previous version was made by '.$users[$undo_rev['Marker']['user_id']].' at '.$time->nice($undo_rev['Marker']['version_created']); 
echo $html->link('Undo', array('action'=>'undo',$marker['Marker']['id'])); 
echo '<h4>Versionshistorie</h4><ul>'; 
$nr_of_revs = sizeof($history); 
foreach ($history as $k => $rev) { 
    echo '<li>'.($nr_of_revs-$k).' '.$rev['Marker']['version_created'].' '. 
       $html->link('make current', array('action'=>'makeCurrent',$marker['Marker']['id'],$rev['Marker']['version_id'])); 
}  
echo '</ul>';
*/
?>


<div id="content" title="<?php echo $marker['Marker']['id'];?>">
	<h2 id="h2_title"><?php echo $marker['Marker']['subject'];?></h2>

	<hr class="hidden"/>
	<div id="details">
		<h3 id="h3_detail"><?php __('Details');?></h3>
		<?php if ($session->read('Auth.User.id')): ?>

			<div class="actions"><h4 class="hidden"><?php __('Actions');?></h4>

					<?php 
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')):	
						echo ' '.$html->link(__('edit', true), array(
							'action' => 'edit', $marker['Marker']['id'], 'admin' => null),array('class' => 'button small orange')
							); 
					elseif ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin):
						echo $html->link(__('administrate', true), array(
							'action' => 'admin_edit', $marker['Marker']['id'], 'admin' => true),array(
								'class' => 'button small orange')
							).' ';
					endif;
					
					// check if marker belongs to user
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || 
						$userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) :
						
						echo ' '.$html->link(__('Delete', true), array(
							'action' => 'delete', $marker['Marker']['id'], 'admin' => null),array(
								'class' => 'button small red'), sprintf(__('Are you sure to delete Marker # %s?', true), $marker['Marker']['id'])
						);
					endif;
					?>

			</div>
		<?php endif; ?>
		
			<dl class="color_<?php echo $marker['Status']['hex'];?>">
				<dt class="marker_kat"><?php __('Category'); ?></dt>
				<dd class="<?php echo $marker['Category']['hex']; ?>">
					<?php echo $marker['Category']['name']; ?>
				</dd>
				<dt class="marker_status"><?php __('Status'); ?></dt>
				<dd class="status_<?php echo $marker['Status']['hex'];?>">
					<span><?php echo $marker['Status']['name']; ?></span>
				</dd>
			
				<?php if ($marker['Marker']['description']):?>
				
				<dt class="marker_descr"><?php __('Description'); ?></dt>
				<dd class="marker_descr_text">
					<?php echo $htmlcleaner->cleanup($marker['Marker']['description']); ?>
				</dd>
				<?php endif; ?>
				
				<?php if ($marker['Marker']['lat'] != "0.000000"):?>

				<dt class="marker_adress"><?php __('Address'); ?></dt>
				<dd class="marker_adress_text">
					<?php echo $marker['Marker']['street']; ?><br/>
					<?php echo $marker['Marker']['zip']; ?> <?php echo $marker['Marker']['city']; ?>
				</dd>
				<?php endif; ?>
			</dl>
	</div>
	<div id="descr_meta">
		<small><strong><?php 
			//pr($showMail);
			if (Configure::Read('Publish.EMail') && ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin)) {
				echo '<a href="mailto:'.$marker['User']['email_address'].'">'.$marker['User']['nickname'].'</a>'; 
			}
			else{
				echo $marker['User']['nickname']; 
			}
		?></strong> <?php __('added: '); ?> <?php echo $datum->date_de($marker['Marker']['created'], 1) ?> | <?php __('last edited on'); ?>	<?php echo $datum->date_de($marker['Marker']['modified'],1) ?> | <?php echo __('Views:', true)." <strong>".$views."</strong>";?> | <?php echo __('Comments:', true)." <strong>".$commentSum."</strong>";?> 
</small>
	</div>
	
	
	
		<?php if (!empty($marker['Marker']['feedback'])):;?>
			<? if ($marker['Marker']['feedback'] == 2 || $marker['Marker']['feedback'] == 3) {?>
				<div id="ratings">
					<h3><?php __('Rating');?></h3>
					<h4><?php __('Please rate this Marker');?></h4>
	
					<?php  echo $this->element('rating', array(
								'plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])
							); ?>
				</div>
			<?php }?>
			<? if ($marker['Marker']['feedback'] == 1 || $marker['Marker']['feedback'] == 3) {?>
				<div id="votings">
					<h3><?php __('Voting');?></h3>
					<h4><?php __('Do you agree with this?');?></h4>
						<?php
							echo $this->element('voting', array(
								'plugin' => 'voting', 'model' => 'Marker', 'id' => $marker['Marker']['id'])
							); ?>
				</div>
			<?php }?>
	<?php endif; ?>


	<hr class="hidden"/>
	<?php
	/*
	 * comments view and form
	 *
	 */
	echo $this->element('form_comments'); 
	
	?>
</div>

<div id="sidebar">
	<div>
		<!--  Raw HTML content: [begin] -->
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style">
			<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4a51f46c045b889e" class="addthis_button_compact">Bookmark</a>
			<span class="addthis_separator">|</span>
			<a class="addthis_button_facebook"></a>
			<a class="addthis_button_myspace"></a>
			<a class="addthis_button_google"></a>
			<a class="addthis_button_twitter"></a>
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a51f46c045b889e"></script>
		<!-- AddThis Button END -->
	</div>
<?php	if ($marker['Marker']['lat'] != "0.000000"):?>
	<h3 id="h3_map"><?php __('Map view');?></h3>
	<div id="maps">
		<div id="map_wrapper_small">
			<noscript><div><img alt="<?php __('static map');?>" src="http://maps.google.com/staticmap?center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=16&amp;size=320x300&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blue%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false" /></div>
			</noscript>
		</div>
	</div>

	<?php endif;?>

	<hr class="hidden"/>
	<?php if (isset($marker['Attachment'])):?>
	<h3><?php __('Photos');?></h3>
	<div id="media">
		<div>
		<?php
			$counter=0;
			foreach ($marker['Attachment'] as $attachment) {
				$counter++;
				if ($attachment['dirname'] == "img") {
					echo '<div class="thumbBig">';
					echo '<a class="lightbox imageThumbView" href="/media/filter/xl/'.$attachment['dirname']."/".substr($attachment['basename'],0,strlen($attachment['basename'])-3).'png"><img src ="/media/filter/m/'.$attachment['dirname']."/".substr($attachment['basename'],0,strlen($attachment['basename'])-3).'png"/></a></div>';
				} elseif ($attachment['dirname'] == "doc"){
					echo '<div class="doc"><a href="/media/transfer/doc/'.$attachment['basename'].'">'.$attachment['basename'].'</a></div>';
				} else {
					echo '<div>'.__('No Attachment available',true).'</div>';
				}
			}

		?>
		</div>
	</div>
	<?php endif; ?>
	
	<div><h3><?php __('Log');?></h3>
	<?php
	
		foreach ($statuses as $status) {
			// provide color and name and bind it to Status ID which is saved in Transaction 
			$thisColors[$status['Status']['id']] = array($status['Status']['hex'],$status['Status']['name']);
		}
		

		foreach ($history as $transaction):?>
		<div class="log">
			<?php 
				// now call the status name;
				$thisStatus = $transaction['Transaction']['status_id'];
			?>
			<p title="<?php echo $thisColors[$thisStatus['Status']][1];?>" class="color_<?php echo $thisColors[$thisStatus['Status']][0];?>">
				<?php echo $transaction['Transaction']['Name'];	?>
			</p>
			 <small class="comment_meta"><span title="<?php //echo "IP ".$transaction['Transaction']['ip'];?>"><?php echo $datum->date_de($transaction['Transaction']['created'],1);?></span></small>
		</div>
		<?php endforeach; ?>
	</div>

</div>	
