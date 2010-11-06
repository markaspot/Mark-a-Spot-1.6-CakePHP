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

	echo $this->element('head'); 

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
			'action' => 'app',
			'admin' => null),
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


<div id="content">
	<h2 id="h2_title"><?php __('Admin Dashboard')?></h2>
	<hr class="hidden"/>
	<div id="details">
	
	<h3>Logs</h3>
	<ul>
	<?php pr($transactions);
	
	foreach ($transactions as $transaction) {
		$counter = 0;
		echo '<li class="" title="'.__('View Marker',true).'">'.$html->link($transaction['Transaction']['name'], array(
			'plugin' => null, 'controller' => 'markers', 'action' => 'view', 'admin' => false, $transaction['Transaction']['marker_id'])).'<br/><small>.';
			echo __('last edited on', true);
			echo $datum->date_de($transaction['Transaction']['modified']).'</small></li>';
	
	}
	
	?>

	</ul>
	
	
 <?php
 echo $ajax->link('Ajax link', '/ajax_test/post_test', array(
        'update' => 'ajax_reply'
  ));
 ?>


<?php
echo $ajax->form('test', 'post', array('model' => 'markers', 'url' => '/markers/geojson', 'update' => 'ajax_reply'));
echo $form->input('Test.value', array('id' => 'test_observe'));
echo $form->end('Submit');
 ?>


<div id="ajax_editor">Test text...</div>
<?php
echo $ajax->editor('ajax_editor', '/markers/edit', array(
        'cancel' => 'Cancel',
        'submit' => 'OK',
        'onblur' => 'submit',
        'tooltip' => 'Click to edit',
        'callback' => "function(value, settings){ alert(value); }",
)); ?>


<div id="ajax_reply"></div>
<?php
echo $ajax->observeField('test_observe', array(
        'url' => '/ajax_test/post_test',
        'update' => 'ajax_reply'
));
?>
	
	
	<h3>Anlagen</h3>
	<?php //pr($attachments);
		echo "<div>";
			
			$counter = 0;
			
			foreach ($attachments as $attachment) {
				$counter++;
				if (strstr($attachment['Attachment']['dirname'], 'img')) {
					echo '<div class="thumb">';
					echo '<a class="fancybox imageThumbView" href="/media/filter/xl/'.$attachment['Attachment']['dirname']."/".substr($attachment['Attachment']['basename'],0,strlen($attachment['Attachment']['basename'])-3).'png"><img src ="/media/filter/s/'.$attachment['Attachment']['dirname']."/".substr($attachment['Attachment']['basename'],0,strlen($attachment['Attachment']['basename'])-3).'png"/></a></div>';
				} else {
					echo '<div>'.__('No picture available',true).'</div>';
				}
			}
			
		echo "</div>";?>
	</div>
</div>

<div id="sidebar">
			<?php echo $this->element('sidebar');?>
</div>	
