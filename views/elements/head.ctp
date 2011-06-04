<?php
echo $this->Html->meta('Feed','/rss', array('inline' => false, 'type' => 'rss'));
echo $this->Html->css('styles', null, array('inline'=>false));


echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false);
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', false);
echo $this->Html->script('jquery/jquery.jeditable.min.js', false);
echo $this->Html->script('jquery/jquery.url.packed.js', false);
echo $this->Html->script('jquery/jquery.cycle.lite.1.0.min.js', false);
echo $this->Html->script('jquery/jquery.form.js', false);
echo $this->Html->script('jquery/jquery.cookie.js', false);
echo $this->Html->script('jquery/fancybox/jquery.fancybox-1.3.1.pack.js', false);
echo $this->Html->script('jquery/jquery.tipTip.min', false);

if (App::pluginPath('Configuration')) {
	echo $this->Html->script('/js/conf/index.js',false); 
}

if (App::pluginPath('Rating')) {
	echo $this->Html->script('/rating/js/rating_jquery.js',false); 
}
if (App::pluginPath('Voting')) {
	echo $this->Html->script('/voting/js/voting_jquery.js',false); 
}


/**
 *
 * OSM Cloudmade API 
 *
 */
if (Configure::read('Basic.MapApi') == "OSM") {
	echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=false&region=DE', false);
	echo $this->Html->script('http://tile.cloudmade.com/wml/latest/web-maps-lite.js', false);
	echo $this->Html->script('markers_openstreetmaps.js', false);
} else {

/**
 *
 * Google Maps API 2
 *
 */

 echo $this->Html->script('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='.$googleKey, false);
 echo $this->Html->script('mapiconmaker_packed.js', false);
 echo $this->Html->script('markers.js', false);
 echo $this->Html->script('MarkerCluster.js', false);

}

echo $this->Html->script('common.js', false);


?>