<?php
/**
 * Mark-a-Spot Pages View
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

	echo $this->element('head_nomap'); 

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
echo $html->link('Undo', array('action'=>'undo',$attachments['Marker']['id'])); 
echo '<h4>Versionshistorie</h4><ul>'; 
$nr_of_revs = sizeof($history); 
foreach ($history as $k => $rev) { 
    echo '<li>'.($nr_of_revs-$k).' '.$rev['Marker']['version_created'].' '. 
       $html->link('make current', array('action'=>'makeCurrent',$attachments['Marker']['id'],$rev['Marker']['version_id'])); 
}  
echo '</ul>';
*/
?>


<div id="content" class="admin">
	<h2 id="h2_title"><?php __('Admin Dashboard')?></h2>
	<hr class="hidden"/>

	<div id="listIndex">

		<h3><?php __('Recent changes') ?></h3>

		<ul class="marker_splash">
		<?php
		$i = 0;
		foreach ($markers as $marker):
		?>
			<li class="admin"><div class=""><?php 
					echo ' '.$html->link(__('administrate', true), array('controller' => 'markers', 'action' => 'admin_edit', $marker['Marker']['id'], 'admin' => true),array('class' => 'button small orange'));
					 
					echo ' '.$html->link(__('Delete', true), array('admin' => false, 'controller' => 'markers', 'action' => 'delete', $marker['Marker']['id']),array('class' => 'button small red'), sprintf(__('Are you sure to delete marker # %s?', true), $marker['Marker']['id']));
					
					?></div>
			</li>

			<li><div class="color_<?php echo $marker['Status']['hex'] ?>">
				<?php echo $html->link($text->truncate($marker['Marker']['subject'],60, array('ending' => '... ', 'exact' => false)), array('controller' => 'markers', 'action' => 'view', 'admin' => false, $marker['Marker']['id']), array('escape'=>false)); ?>
				<p class="status">Status: <?php echo $marker['Status']['name'] ?></p><p class="transactions"><?php __('This happened:') ?> <?php echo __($marker['Transaction'][0]['name'],true);?></p></div><small class="meta"><?php echo $marker['User']['nickname']; ?><?php __(', on '); echo $datum->date_de($marker['Marker']['modified'],1);?></small></li>
				<?php endforeach; ?>
		</ul>

	</div>
	<hr class="hidden"/>

	<h3><?php __('Log');?></h3><!-- -->

	<div id="log" style="overflow:auto">
	<?php
	
		foreach ($statuses as $status) {
			// provide color and name and bind it to Status ID which is saved in Transaction 
			$thisColors[$status['Status']['id']] = array($status['Status']['hex'],$status['Status']['name']);
		}
		foreach ($history as $transaction):?>
		
		<div class="logItem">
			<?php 
				// now call the status name;
				$thisStatus = $transaction['Transaction']['status_id'];
			?>
			<div id="transaction_<?php echo $transaction['Transaction']['id']; ?>" title="<?php echo $transaction['Transaction']['id']; ?>">
				
				<p title="<?php echo $thisColors[$thisStatus['Status']][1];?>" class="color_<?php echo $thisColors[$thisStatus['Status']][0];?>">

				<?php echo $html->link($text->truncate($transaction['Marker']['subject'],60, array('ending' => '... ', 'exact' => false)), array('controller' => 'markers', 'action' => 'view', 'admin' => null, $transaction['Transaction']['marker_id']), array('escape'=>false)); ?><br/>
				<?php echo $transaction['Transaction']['Name'];	?>
				</p>

			 <small class="comment_meta"><span title="<?php //echo "IP ".$transaction['Transaction']['ip'];?>"><?php echo $datum->date_de($transaction['Transaction']['created'], 2);?></span></small>
			</div>

		</div>
		<?php endforeach; ?>
	</div>
<br style="clear:all"/>	
</div>

<div id="sidebar">
			<?php echo $this->element('admin_sidebar');?>
</div>	

<div id="sidebar2">
				<h3><?php __('Reports with fotos');?></h3>
				<div>
				<?php
					if (!empty($attachments)) {
						for ($i = 0; $i <= 2; $i++) {
							if (!empty($attachments[$i]) && strstr($attachments[$i]['Attachment']['dirname'], 'img')) {
								echo '<div class="thumb">';
									echo '<a class="lightbox imageThumbView" href="/media/filter/xl/'.$attachments[$i]['Attachment']['dirname']."/".substr($attachments[$i]['Attachment']['basename'],0,strlen($attachments[$i]['Attachment']['basename'])-3).'png">';
									
									echo '<img src ="/media/filter/s/'.$attachments[$i]['Attachment']['dirname']."/".substr($attachments[$i]['Attachment']['basename'],0,strlen($attachments[$i]['Attachment']['basename'])-3).'png"/></a>
									<div><div class="clear"></div>';
									echo $html->link(__('View details',true), array('controller' => 'markers', 'action' => 'view', 'admin' => false, $attachments[$i]['Attachment']['foreign_key']), array('class' => 'button small', 'escape'=>false)).'</div></div>';
							} 
						} 
					} else  {
						echo '<div class="thumb_empty">'.__('No picture available',true).'</div>';
					}
					
				?>
				</div>
</div>	

<div id="sidebar3">
		<h3><?php __('Comments')?></h3>
		<?php if (!empty($comments)):?>
		<?php
			$i = 0;
			foreach ($comments as $comment):
				if ($comment['Comment']['group_id'] == $uGroupAdmin) {
					$commentsClass ='marker_comment_admin';
				} else {
					$commentsClass="marker_comment";
				}
				?>
				<div id="comment_<?php echo $comment['Comment']['id']; ?>" title="<?php echo $comment['Comment']['id']; ?>" class="<?php echo $commentsClass ?>">
				<?php 
				switch ($comment['Comment']['status']) {
				  case "1":
				    $linktext = __('block',true);
				    $commentAdminClass = "c_published";
			        break;

				  case "0":
				    $linktext = __('publish',true);
				    $commentAdminClass = "c_hidden";
			        break;

				 }

				
				?><div class="comment_admin"><a class="button small green comment_publish" id="publish_<?php echo $comment['Comment']['id']; ?>"href="#"><?php echo $linktext?></a> <a class="button small red comment_delete" id="delete_<?php echo $comment['Comment']['id']; ?>" href="#"><?php echo __('Delete', true);?></a></div>
					<p class="comment" id="<?php echo $comment['Comment']['id'];?>"><?php echo $htmlcleaner->cleanup($comment['Comment']['comment']);?></p>
					<small class="comment_meta">schrieb <?php echo $comment['Comment']['name'];?> am <?php echo $datum->date_de($comment['Comment']['created'],1);?></small>
				</div>
		<?php endforeach; ?>
		<?php endif; ?>
</div>	