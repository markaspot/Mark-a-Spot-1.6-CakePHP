<?php 
class GeocoderComponent extends Object
{
	// URL Variable Seperator
	var $uvs		= ', ';

	// You Google Map API Key here -- This is the default API Key registered for www.webmechano.com
	var $apiKey		= "";
	
	var $controller	= true;

    function startup(&$controller)
    {
    	$this->controller = &$controller;
    }

	function getLatLng($addy, $api_key = null) {
		
		if (is_array($addy)) {
			// First of all make the address
			if (!empty($addressArr['zip'])) {
				$address	= $addy['street'].$uvs.$addy['loc'].$uvs.$addy['zip'];
			}
			else{
				$address	= $addy['street'].$uvs.$addy['loc'];
			}
		}else{
			$address	= $addy;
		}
		// Default Api Key registered for webmechano. It's highly recommended that you use the one for stylished
		if ($api_key == null) {
			$api_key		= $this->apiKey;
		}
		$url		= "http://maps.google.com/maps/geo?output=xml&key=$api_key&q=";

		// Here make the result array to return
		// If the address is correct, it will return 200 in the CODE field so $result['code'] should be equal to 200
		$result		= array('lat'=>'', 'lng'=>'', 'code'=>'');

		// Make the Temporary URL for CURL to execute
		$tempURL	= $url.urlencode($address);

		// Create the cURL Object here
		$crl	= curl_init();
		curl_setopt($crl, CURLOPT_HEADER, 0);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		
		// Here we ask google to give us the lats n longs in XML format
		curl_setopt($crl, CURLOPT_URL, $tempURL);
		$gXML		= curl_exec($crl);	// Here we get the google result in XML

		// Using SimpleXML (Built-in XML parser in PHP5) to parse google result
		$goo		= simplexml_load_string(utf8_encode($gXML)); // VERY IMPORTANT ! - ACHTUNG ! - this line is for documents that are UTF-8 encoded
		// If the layout and views are not UTF-8 encoded you can use the line below - 
		// comment the above line and un-comment the line below
		// $goo		= simplexml_load_string($gXML);

		$result['code']	= $goo->Response->Status->code;
		if ($result['code'] != 200) {
			$result['lat']		= 'error';
			$result['lng']		= 'error';
			//$result['address']	='error';
			return $result;
		}
		else{
			$coords				= $goo->Response->Placemark->Point->coordinates;
			list($lng, $lat)	= split(',', $coords);
			$result['lat']		= $lat;
			$result['lng']		= $lng;
			//$result['address']	= $gooAddress;
			return $result;
		}
	}// end function / action : getLatLng	
}
?>