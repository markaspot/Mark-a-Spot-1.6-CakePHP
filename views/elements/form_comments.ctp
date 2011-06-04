	<h3 id="h3_comments"><?php __('Comments');?></h3>
	<div id="comments">
		<?php if (!empty($marker['Comment'])):?>
		<?php
		$i = 0;
		foreach ($marker['Comment'] as $comment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	
			if ($comment['group_id']==$uGroupAdmin) {
			
				$commentsClass ='marker_comment_admin';
			} else {
			
				$commentsClass="marker_comment";
			}
			?>
			<div class="<?php echo $commentsClass ?>">
				<p><?php echo $htmlcleaner->cleanup($comment['comment']); ?></p>
				<small class="comment_meta"><?php echo __('wrote',true).' '.$comment['name'].' '.__('on',true).' '.$datum->date_de($comment['created'],1);?></small>
			</div>
		<?php 
		endforeach; ?>
		
		<?php endif; ?>
		<div id="comments_form">
			<?php echo $form->create('Comment',array('action' => 'commentsadd'));?>
				<fieldset>
					<legend><?php __('Add Comment');?></legend>
				<?php
					echo $form->hidden('marker_id', array('value'=>$marker['Marker']['id'])); 
					echo $form->hidden('marker.status_id', array('value'=>$marker['Marker']['status_id'])); 

					if (!$session->read('Auth.User.id')) {
						echo $form->input('name', array('div' => 'text required', 'label'  => __('Nickname',true)));
						echo $form->input('email', array('div' => 'text required', 'label'  => __('email',true))); 
					} else {
						echo $form->input('name', array('label'  => __('Nickname',true), 'value'=>$currentUser['User']['nickname']));
						echo $form->input('email', array('label'  => __('email',true) , 'value'=> ''));
					}
					echo $form->input('comment', array('type' => 'textarea', 'div' => 'text required', 'label'  => __('comment', true)));
					echo $form->input('security_code', array('before'=> __('<div>To prevent spammers, please calculate:</div>',true), 'div'=>'text required', 'between'=>'<br/>', 'label'
							 => $mathCaptcha));
				?>
				
				</fieldset>

			<?php echo '<p>'.$html->tag('button', '<span>'.__('Save Comment',true).'</span>', array('type' => 'submit')).'</p>';?>
			<?php echo $form->end();?>
		</div>
	</div>
	<hr class="hidden"/>
	