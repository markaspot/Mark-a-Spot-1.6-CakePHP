<?php
$info = $this->requestAction('/markers/infolast');
?>

<ul>
	<li><?php echo $info['markerSum'].' '.$html->link(__('Markers', true),array('controller' => 'markers', 'action' => 'view',$info['markerLast']['Marker']['id']),array('title'=>__('Jump to latest marker', true)));?></li>
	<li><?php echo $info['commentSum'].' '.$html->link(__('Comments', true),array('controller' => 'markers', 'action' => 'view', $info['commentLast']['Comment']['marker_id']), array('title' =>__('Jump to latest comment', true)));?></li>
	<li><?php echo $info['ratingSum'].' '.$html->link(__('Ratings', true),array('controller' => 'markers', 'action' => 'view', $info['ratingLast']['Rating']['model_id']),array('title'=>__('Jump to latest rated marker', true)));?></li>
</ul>
<h3 class="hidden"><?php __('Software:') ?></h3>
<ul class="software">
	<li><!-- please keep the following attribution --><a id="mas" href="http://www.mark-a-spot.org"><span>Mark-a-Spot </span></a> Version <a href="<?php echo $software['gplAffero'];?>"><span><?php echo $software['version'];?></span></a></li>
</ul>