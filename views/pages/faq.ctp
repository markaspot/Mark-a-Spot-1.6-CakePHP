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
			'id'=>$this->params['pass'][0]),
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


<div id="content">
	<h2 id="h2_title">FAQ</h2>
	<hr class="hidden"/>
	<div id="details">	</div>
</div>

<div id="sidebar">
</div>	

