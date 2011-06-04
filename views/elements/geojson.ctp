<?php
if ($markers) {

	foreach ($markers as $feature):
		$feature['type'] = 'Point';
		$feature['coordinates'][0] = floatval($feature['Marker']['lon']);
		$feature['coordinates'][1] = floatval($feature['Marker']['lat']);
		$feature['properties']['id'] = $feature['Marker']['id'];
		$feature['properties']['subject'] = $feature['Marker']['subject'];
		$feature['properties']['description'] = $feature['Marker']['description'];		
		$feature['properties']['votes'] = $feature['Marker']['votes'];
		$feature['properties']['rating'] = $feature['Marker']['rating'];
		$feature['properties']['category']['hex'] = $feature['Category']['Hex'];
		$feature['properties']['category']['name'] = $feature['Category']['Name'];
		$feature['properties']['status']['hex'] = $feature['Status']['Hex'];
		$feature['properties']['status']['name'] = $feature['Status']['Name'];
		$feature['properties']['attachment'] = $feature['Attachment'];
		$feature['properties']['media_url'] = $feature['Marker']['media_url'];

		unset($feature['Attachment']);
		unset($feature['Marker']);
		unset($feature['category']);
		unset($feature['Status']);


		$features[] = $feature;
	endforeach;
		$feature['type'] = "Feature";

		$allfeatures['type'] = "FeatureCollection";
		$allfeatures['features'][0]['geometry']['type'] = "GeometryCollection";
		$allfeatures['features'][0]['geometry']['geometries'] = $features;
		$allfeatures['features'][0]['type'] = "Features";
		$allfeatures['features'][0]['Properties'] = "";

	/*
	$options = array( 
		'block' => false, 'prefix' => '', 'postfix' => '', 
		'stringKeys' => array('features'), 'quoteKeys' => false, 'q' => '"' 
	);
	*/ 
	$javascript->useNative = false; 
	
	echo $javascript->object($allfeatures, array('quoteKeys' => false));  

}?>