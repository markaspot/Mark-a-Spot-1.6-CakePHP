<?php 
/**
 * Mark-a-Spot AppController
 *
 * Index View Splashpage
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

echo $this->element('head');?>


<?php		
	/*
	 * Breadcrumb
	 *
	 */

	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
			__('Home',true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
			__('Map',true),
		array(
		'plugin'=>'',
		'controller'=>'markers',
		'action'=>'app'),
		array('escape'=>false)
	);
	$html->addcrumb(
		__('Results',true),
		array(
		'plugin'=>'search',
		'controller'=>'searches',
		'action'=>'index'),
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


<div id="content" class="page form">
	<div class="markers index">
	<h2><?php __('Search results') ?></h2>

			
<?php 
echo $form->create('Search', array('url' => array(
	'plugin' => 'search', 
	'controller' => 'searches',
	'action' => 'index'
)));

echo $form->input('q', array('label' => __('Search',true)));

echo $form->end();?>

			


	<h3><?php __('Your results for "') ?> <?php echo $q.'"'; ?></h3>

	<div id="paginator-counter">
   		<p>
		<?php
		echo $paginator->counter(array(
		'format' => __('Page %page% of %pages% | %current% Markers of %count%', true)
		));
		?>
		</p>
	</div>
		<ul class="marker_search">	
		<?php foreach($data as $row):
	    $model_name = key($row);
	
	    switch($model_name)
	    {
	        case 'Marker':
	            $link = $html->link($row['Marker']['subject'], array(
	            	'plugin' => null,
	                'controller' => 'markers',
	                'action' => 'view',
	                $row['Marker']['id']
	            ));
	            $description = $row['Marker']['descr'];
	            break;
	
	        case 'Comment':
	        	$commentLink = $text->truncate($row['Comment']['comment'], 45, '...',    false);
	            $link = $html->link($commentLink, array(
	            	'plugin' => null,
	                'controller' => 'markers',
	                'action' => 'view',
	                $row['Comment']['marker_id']
	            ));
	            $description = $row['Comment']['comment'];
	            break;
	    } ?>
	        <li><div><h4><?php echo $link; ?></h4>
	        <p><?php echo $text->truncate($description,    45,    '...',    false);?></p></div></li>        
	<?php endforeach; ?> 
	</ul>
	<div id="pagination">
				<?php 
				
				/*
	     * added this for making pagination work
	    */
	    $paginator->options(array('url' => $this->passedArgs));
				
				
				echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
			 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>

	</div>
</div>
<!-- content end -->


<!-- Sidebar ende-->
