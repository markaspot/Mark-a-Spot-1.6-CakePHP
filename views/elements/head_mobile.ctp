<?php


echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false);
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', false);
echo $this->Html->script('jquery/jquery.url.packed.js', false);

echo $this->Html->script('jquery/jquery.form.js', false);
echo $this->Html->script('jquery/jquery.cookie.js', false);
echo $this->Html->script('jquery/fancybox/jquery.fancybox-1.3.1.pack.js', false);
if (App::pluginPath('Rating')) {
	echo $this->Html->script('/rating/js/rating_jquery.js',false); 
}
if (App::pluginPath('Voting')) {
	echo $this->Html->script('/voting/js/voting_jquery.js',false); 
}
echo $this->Html->script('http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.js', false);

$scriptBlock = '
$(document).bind("mobileinit", function(){
	$.extend(  $.mobile , {
	//ajaxFormsEnabled : false
	loadingMessage : "lädt"
	});
});';

echo $this->Html->scriptBlock($scriptBlock, $options = array());

/**
 *
 * Google Maps API 2
 *
 */
if ($this->params['controller'] == "markers" && $this->params['action'] != "view" && $this->params['action'] != "index" && $this->params['controller'] !=  "users"  ) {
	 //pr($this->params);
	 echo $this->Html->script('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='.$googleKey, false);
	 echo $this->Html->script('mapiconmaker_packed.js', false);
	 echo $this->Html->script('markers.js', false);
	 echo $this->Html->script('MarkerCluster.js', false);

}

/**
 *
 * OSM Cloudmade API 
 *
 */

//echo $this->Html->script('http://tile.cloudmade.com/wml/latest/web-maps-lite.js', false);
// echo $this->Html->script('markers_openstreetmaps.js', false);

/**
 *
 * Google Maps API 3
 *
 */
 
//echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=false', false);
//echo $this->Html->script('gmap-wms.js', false);
//echo $this->Html->script('markers_3.js', false);


/**
 *
 * Openlayers API 
 *
 */
 
//echo $this->Html->script('http://www.openstreetmap.org/openlayers/OpenStreetMap.js',false);
//echo $this->Html->script('markersOpenLayers.js', false);




/*
$lang = $this->element(Configure::read('Config.language')).'js';
$javascript->link($lang, false);
*/

echo $this->Html->meta('Feed','/rss', array('inline' => false, 'type' => 'rss'));
echo $this->Html->css('http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.css', null, array('inline'=>false));
echo $this->Html->css('mobile', null, array('inline'=>false));
?>
