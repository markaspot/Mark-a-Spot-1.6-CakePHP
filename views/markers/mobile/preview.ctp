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
	

	<div data-role="page" data-theme="b" data-back-btn-text="Zurück" >

		<div data-role="header">
			<a data-role="button" data-icon="arrow-l" rel="external" href="/">Start</a><h1><?php echo $marker['Marker']['subject']?></h1>
		</div><!-- /header -->
	
		<div data-role="content">
		<p><?php if (!$session->read('FB') && !$session->read('Twitter')) {
					echo __('This is the preview of your marker. If this is your first contribution on this platform, please check your mail to confirm your membership.', true);
				}
			?></p>
			<a title="in Karte anzeigen" href="http://maps.google.com/maps?ll=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=16&amp;size=120x120&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;key=<?php echo $googleKey?>&amp;sensor=true"><img alt="<?php __('static map');?>" style="float:right; margin-left: 5px" src="http://maps.google.com/staticmap?center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=16&amp;size=120x120&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blue%7C&amp;key=<?php echo $googleKey?>&amp;sensor=true" /></a><h2><?php echo $marker['Marker']['subject']?></h2>
			<div>
			<dl class="color_<?php echo $marker['Category']['hex'];?>">
				<dt class="marker_adress"><?php __('added: '); ?></dt>
				<dd class="marker_adress_text">
					<?php echo $datum->date_de($marker['Marker']['created'],2) ?>
				</dd>

				<dt class="marker_status"><?php __('Status'); ?></dt>
				<dd class="status_<?php echo $marker['Status']['hex'];?>">
					<span><?php echo $marker['Status']['name']; ?></span>
				</dd>
			</dl>
			</div>
			<div data-role="collapsible-set" class="ui-body">
				<div data-role="collapsible" data-collapsed="true">
					
	
					<h3><?php __('Details')?></h3>
					<dl class="color_<?php echo $marker['Category']['hex'];?>">
						<dt class="marker_kat"><?php __('Category'); ?></dt>
						<dd class="<?php echo $marker['Category']['hex']; ?>">
							<?php echo $marker['Category']['name']; ?>
						</dd>
						<dt class="marker_status"><?php __('Status'); ?></dt>
						<dd class="status_<?php echo $marker['Status']['hex'];?>">
							<span><?php echo $marker['Status']['name']; ?></span>
						</dd>
						<?php if ($marker['Marker']['description']){?>
						<dt class="marker_descr"><?php __('Description'); ?></dt>
						<dd class="marker_descr_text">
							<?php echo $htmlcleaner->cleanup($marker['Marker']['description']); ?>
						</dd>
						<?php } ?>
					
						<dt class="marker_adress"><?php __('Address'); ?></dt>
						<dd class="marker_adress_text">
							<?php echo $marker['Marker']['street']; ?><br/>
							<?php echo $marker['Marker']['zip']; ?> <?php echo $marker['Marker']['city']; ?>
						</dd>
					</dl>
				</div>
	
				<?php if (!empty($marker['Marker']['feedback'])):;?>
				<? if ($marker['Marker']['feedback'] == 2 || $marker['Marker']['feedback'] == 3) {?>
					<div class="ratings" data-role="collapsible" data-collapsed="true">
					<h3><?php __('Rating');?></h3>
						<h4><?php __('Please rate this Marker');?></h4>
							<fieldset data-role="controlgroup" data-type="horizontal" data-role="fieldcontain">
	
							<?php  echo $this->element('rating', array(
										'plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])
									); ?>
							</fieldset>
					</div>
					<?php }?>
				<? if ($marker['Marker']['feedback'] == 1 || $marker['Marker']['feedback'] == 3) {?>
				<div id="votings" data-role="collapsible" data-collapsed="true">
					<h3><?php __('Voting');?></h3>
						<h4><?php __('Do you agree with this?');?></h4>
								<?php
									echo $this->element('voting', array(
										'plugin' => 'voting', 'model' => 'Marker', 'id' => $marker['Marker']['id'])
									); ?>
						</div>
					<?php }?>
				<?php endif; ?>
	
	
	
				<?php if (isset($marker['Attachment'][0])) {?>
				<div data-role="collapsible" data-collapsed="true">
					<h3><?php __('Photos');?></h3>
					
					<div>
					<?php
						$counter=0;
						foreach ($marker['Attachment'] as $attachment) {
							$counter++;
							if (strstr($attachment['dirname'], 'img')) {
								echo '<div class="thumb">';
								echo '<a class="lightbox imageThumbView" href="/media/filter/xl/'.$attachment['dirname']."/".substr($attachment['basename'],0,strlen($attachment['basename'])-3).'png"><img src ="/media/filter/m/'.$attachment['dirname']."/".substr($attachment['basename'],0,strlen($attachment['basename'])-3).'png"/></a></div>';
							} else {
								echo '<div>'.__('No picture available',true).'</div>';
							}
						}
			
					?>
					</div>
				</div>
				<?php } ?>
				
				<div data-role="collapsible" data-collapsed="true">
					<h3><?php __('Log');?></h3>
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
						 <hr/>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			
		<!--
	<?php if ($session->read('Auth.User.id')) {	?>
	
			<div data-role="controlgroup" data-type="horizontal" >
			<?php 
			// gehoert der Marker diesem User?
			if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {	
				echo ' '.$html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class' => 'button small', 'data-role' => 'button', 'data-icon' => 'grid')); }
			 else if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
				echo ' '.$html->link(__('administrate', true), array('action' => 'admin_edit', $marker['Marker']['id'], 'admin' => true),array('class' => 'button small', 'data-role' => 'button', 'data-icon' => 'grid'));
			 }
			// gehoert der Marker diesem User?
			if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || $userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
				echo ' '.$html->link(__('Delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class' => 'button small', 'data-role' => 'button', 'data-icon' => 'delete'), sprintf(__('Are you sure to delete marker # %s?', true), $marker['Marker']['id']));
			}
			?>
			</div>
			<?php }	?>
-->
		</div><!-- /content -->
	</div><!-- /page -->

