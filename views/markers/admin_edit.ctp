<?php 
/**
 * Mark-a-Spot Administration view for authorities
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
 * @version    1.4.1 beta 
 */
 
 
echo $this->element('head');
echo $javascript->link('jquery/jquery.validation.min.js', false); 
echo $validation->bind('Marker');
//echo $javascript->link('jquery/tiny_mce/jquery.tinymce.js', false);

?>

<?php		
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
			'action'=>'app',
			'admin' => null),
			array('escape'=>false)
	);
	$html->addcrumb(
		__('Administrate marker', true),
		array(
		'admin' => true,
		'controller' => 'markers',
		'action' => 'admin_edit',
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


	<div id="content">
		<h2 id="h2_title"><?php __('Administration of markers');?></h2>
		<?php if ($session->read('Auth.User.id')) {	?>

			<div class="actions"><h4 class="hidden"><?php __('Actions');?></h4>
				<?php 
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {	
						echo ' '.$html->link(__('View', true), array('action' => 'view', $marker['Marker']['id'], 'admin' => null),array('class'=>'link_view')); }
					 else if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo ' '.$html->link(__('View', true), array('action' => 'view', $marker['Marker']['id'], 'admin' => null),array('class'=>'link_view'));
					 }
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || $userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo ' '.$html->link(__('delete', true), array('action' => 'delete', $marker['Marker']['id'], 'admin' => null),array('class'=>'link_delete'), sprintf(__('Are you sure to delete Marker # %s?', true), $marker['Marker']['id']));
					} 
					?>
			</div>
		<?php } ?>

		<?php echo $form->create('Markers', array('enctype' => 'multipart/form-data', 'action' => 'admin_edit'))?>	
		<fieldset>
	 		<legend><?php __('Enter Information');?></legend>
				<?php
				echo $form->input('Marker.id', array(
					"type" => "hidden","value" => $this->params['pass'][0]));
				
				echo $form->input('Marker.subject', array(
					'maxlength'=>'128', 'label' => __('Subject',true)));
					
				echo $form->input('Marker.street', array(
					'label' => __('Address',true)));
				
				echo $form->input('Marker.zip', array(
					'maxlength'=>'5', 'label' => __('Zip',true)));
				echo $form->input('Marker.city', array(
					'div' => 'input text required', 'disabled' => 'disabled', 'label' => __('City',true)));
				echo $form->input('Marker.descr', array(
					'label' => __('Description',true)));
					
				echo $this->element('attachments', array(
					'plugin' => 'media', 'model' => 'Marker'));
				
				echo $form->input('Marker.category_id',array(
					'label' => __('Category',true), 'empty' => __('Please choose', true)));
				
				echo $form->input('Marker.status_id',array(
					'label' => __('Status of Administration',true), 'disabled' => false));
				
				echo $form->hidden('Comment.0.name', array(
					'value'=>$currentUser['User']['nickname'])); 
				
				echo $form->input('Marker.notify', array(
					'type' => 'checkbox', 'label' => __('Notify User',true)
					)
				);
				echo $form->input('Marker.twitter', array(
						'type' => 'checkbox', 'label' => __('Update @Twitter',true)
						)
				);
				/*
				echo $form->input('twitterMessage',array(
					'type'=>'textarea','escape'=>false, 'label' =>  __('Twitter ', true);
				*/
				// Users may choose kind of Feedback wanted here
				$types = array(1 => __('Voting',true), 2 => __('Rating',true), 3 => __('Both',true));
				echo $this->Form->input('Marker.feedback', array('options' => $types,
					'type' => 'radio', 'div' => array(
						'class' => 'form'),
					'between' => __('You may choose which kind of feedback is appropriate')));


				echo $form->hidden('Comment.0.email', array('value'=>$currentUser['User']['email_address'])); 
				echo $form->input('Marker.admincomment', array('type' => 'textarea', 'label' => __('Comment',true), 'value'=>''));
				// Set Comment Status 1
				echo $form->input('Comment.0.status', array('type' => 'hidden', 'value'=>'1'));?>
			</fieldset>
			

			<?php 
				
				echo '<p>';
				echo $html->tag('button', __('<span>Save information</span>',true), array('type' => 'submit'));
				echo '</p>';
				echo $form->end();
			?>
		
		
		<h3 id="h3_comments"><?php __('Comments');?></h3>
		
		<?php if (!empty($comments)):?>
			<?php
				$i = 0;
				foreach ($comments as $comment):
				   $class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		
				
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

				
				?><div class="comment_admin"><a class="comment_publish" id="publish_<?php echo $comment['Comment']['id']; ?>"href="#"><?php echo $linktext?></a> <a class="comment_delete" id="delete_<?php echo $comment['Comment']['id']; ?>" href="#"><?php echo 'delete';?></a></div>
					<p class="<?php echo $commentAdminClass; ?>"><?php echo $comment['Comment']['comment'];?></p>
					<small class="comment_meta">schrieb <?php echo $comment['Comment']['name'];?> am <?php echo $datum->date_de($comment['Comment']['created'],1);?></small>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	
				
				
	</div>
	<div id="sidebar">
		<h3 id="h3_map"><?php __('Map view');?></h3>
		<p><?php echo __('Please drag the Marker to a desired position or just edit street and zip details',true);?></p>
	
		<div id="map_wrapper_add"><noscript><div><img alt="<?php __('static map');?>" src="http://maps.google.com/staticmap?center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=16&amp;size=320x300&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blue%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false" /></div></noscript></div>


	<hr class="hidden"/>
	<h3><?php __('Photos');?></h3>
	<div id="media">
		<?php
	
	echo "<div>";
			
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
			
		echo "</div>";
		?>
	</div>
	<?php
	
	/**
	 *
	 * Undo for User-Login
	 *
	 */

	if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {
		echo '<h3>'.__('Back to last version',true).'</h3>';
		echo '<div id="undo">';
		echo '<p>Vorherige Version: '.$undo_rev['Marker']['version_created']. ' ' .
			$html->link(__('undo',true), array('action'=>'undo',$marker['Marker']['id'])).'</p>';
		echo '</div>';
	} 
	
	
	/**
	 *
	 * Versioning for Admin-Access
	 *
	 */
	 

/*
	if ($userGroup == $uGroupSysAdmin) {
		echo '<h3>'.__('Version history',true).'</h3>';
		echo '<div id="history"><ul>'; 
		$nr_of_revs = sizeof($history); 
		foreach ($history as $k => $rev) { 
	    	echo '<li>'.($nr_of_revs-$k).' '.$datum->date_de($rev['Marker']['version_created'],2).' '. 
	       	$html->link('roll back', array('action'=>'makeCurrent',$marker['Marker']['id'],$rev['Marker']['version_id'])).'</li>'; 
		}  
		echo '</ul>';
		echo '</div>';
	}
*/
	?>
	</div>	
