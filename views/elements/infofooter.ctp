<?php
$info = $this->requestAction('/markers/infolast');
?>

<ul>
	<li><strong><?php __('Markers')?>:</strong><br/>
	<strong><?php echo $info['markerSumAllCurrent'].' ';?></strong> <?php __('within the last 30 days')?></li>
	<li><?php __('current')?> <strong><?php echo $info['markerSumOpen'].' ';?></strong> <?php __('open Markers')?></li>
	<li><strong><?php echo $info['markerSumAll'].' ';?></strong> <?php __('overall')?></li>
	<li><strong><?php echo $info['commentSum'].' ';?></strong> <?php __('Comments')?></li>
</ul>

<h3 class="hidden"><?php __('Software:') ?></h3>
<ul class="software">
	<li><!-- please keep the following attribution --><a id="mas" href="http://www.mark-a-spot.org"><span>Mark-a-Spot </span></a> Version <a href="<?php echo $software['gplAffero'];?>"><span><?php echo $software['version'];?></span></a></li>
</ul>