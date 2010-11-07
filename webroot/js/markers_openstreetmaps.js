/**
 * Mark-a-Spot marker.js
 *
 * Main Map-Application File
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4.6  
 */


var markersArray = [];
var map;
var bounds = null;
var newAddress;
var addressRaw;
var saveUrlAddress;
var saveId; 
var categoryCond;
var allVotes;
var getMarkerId ="";
var statusCond;
var markersidebar = document.getElementById('markersidebar');
//include Cloudmade API Code here:
var geocoder = new CM.Geocoder('APICODE');


var conf = {
	masDir		:	'/',
	//masDir : '/markaspot/',
	townString : 'Köln',
	townZip : '50676',
	townStreet : 'Dom',
	townCenter : '50.82968607835879,6.8939208984375', // http://www.getlatlon.com/ << there
	Text : {
		NotCountry : 'This location is not in Germany',
		NotTown	 : 'This address is not in Berlin, Germany',
		NewAdress : 'New position: ',
		NoMarkers : 'No Markers in this Categoryegory'

	},
	Infwin:	{
		TabCommon : 'Overview',
		TabDetail :	'Details',
		TabAdmin : 'Administration',
		TabCommonSubject : 'Subject',
		TabCommonCategoryegory :	'Categoryegory',
		TabCommonStatus : 'Status',
		TabCommonRating : 'Rating',
		TabCommonDetails : 'View details',
		TabCommonNewDescr : 'Add Marker here',
		TabCommonLinkText : 'Jump to detailed page'
	},
	Sidebar: {
		h3Views : 'Views',
		h3Search : 'Search address',
		SearchLabel : 'Street',
		ViewsLabelCategory : 'Categoryegory',
		ViewsLabelStatus : 'Status',
		ViewsLabelRatings : 'Rating',
		ViewsList : 'List of Markers',
	},
	Url: {
		controllerActionAdmin : 'admin',
		controllerActionMap : 'karte',
		controllerActionAdd: 'markers/add',
		controllerActionView : 'view',
		controllerActionEdit : 'edit',
		controllerActionStartup : 'startup'
	}

};
/*
var conf = {
    masDir		:	'/',
	//masDir		:	'/markaspot/',
	townString	:	'Köln',
	townZip		:	'50676',
	townStreet	:	'Dom',
	townCenter	:	'50.9403631,6.9584923', // http://www.getlatlon.com/ << there
	Text	:	{
		NotCountry :'Dieser Punkt liegt nicht in Deutschland',
		NotTown : 'Dieser Punkt liegt nicht in Köln',
		NewAdress : 'Neue Position: ',
		NoMarkers : 'Keine Hinweise in dieser Kategorie'

	},
	Infwin:	{
		TabCommon : 'Allgemein',
		TabDetail : 'Beschreibung',
		TabAdmin : 'Administration',
		TabCommonSubject : 'Neue Position: ',
		TabCommonCategoryegory : 'Kategorie',
		TabCommonStatus : 'Status',
		TabCommonRating : 'Bewertung',
		TabCommonDetails : 'Details zu diesem Hinweis',
		TabCommonNewDescr : 'Hier einen neuen Hinweis setzen',
		TabCommonLinkText : 'zu den Details'
	},
	Sidebar: {
		h3Views : 'Anzeige',
		h3Search : 'Suche',
		SearchLabel : 'Straße und Hausnummer',
		ViewsLabelCategory : 'Kategorie',
		ViewsLabelStatus : 'Status',
		ViewsLabelRatings : 'Bewertung',
		ViewsList : 'Tabellenansicht',
		TabCommonNewDescr : 'Ein neuer Hinweis',
		TabCommonLinkText : 'zu den Details'
	},
	Url: {
		controllerActionAdmin : 'admin',
		controllerActionMap : 'karte',
		controllerActionAdd : 'add',
		controllerActionView : 'view',
		controllerActionEdit : 'edit',
		controllerActionStartup : 'startup'
	}

};

*/

$(document).ready(function () {

	/**
	 * Split URL and read MarkerID
	 *
	 */
	var urlParts = $.url.attr("path").split("/");
	var lastPart = urlParts.length -1;
	if ($.url.attr("path").indexOf(conf.Url.controllerActionView) != -1) {
		
		// view certain marker
		var getMarkerId = urlParts[lastPart];
		$('#map_wrapper_small').append('<div id="map"></div>'); 
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionAdd) != - 1 
		|| $.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionStartup) != - 1) {

		// add marker
		var getMarkerId = 9999999;
		$('#map_wrapper_add').append('<div id="map"></div>');
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionEdit) != - 1 
		|| $.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionAdmin) != - 1) {

		$('#map_wrapper_add').append('<div id="map"></div>');
		var getMarkerId = urlParts[lastPart];
		
	} else if ($.url.attr("path") == conf.masDir) {
		
		// splashpage view
		var getMarkerId = '';
		$('#map_wrapper_splash').append('<div id="map"></div>');
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionMap) != -1) {
				
		// main-application view
		var getMarkerId = '';
		$(window).resize(resizeMap);
		$('#content').addClass("app");
		$('#views').append('<h3>' + conf.Sidebar.h3Views + '</h3><div id="mapMenue"><form id="changeViews"><fieldset></fieldset></form></div>'); 
		$('#search').append('<h3>' + conf.Sidebar.h3Search + '</h3><div id="searchAdress"><form id="MarkersGeofindForm" method="post" action="'+ conf.masDir + 'markers/geofind"><fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset><div class="input text"><label for="MarkerStreet">' + conf.Sidebar.SearchLabel + '</label><br/><input name="data[Marker][street]" type="text" maxlength="256" value="" id="MarkerStreet" /> <input type="submit" class="mas-btn ui-state-default" /></div></form></div></div>'); 
	    $('#changeViews>fieldset').append('<div><label for="catColor">' + conf.Sidebar.ViewsLabelCategory + '</label><input type="checkbox" checked="checked" id="catColor"/></div>');
		$('#changeViews>fieldset').append('<div><label for="catStatus">' + conf.Sidebar.ViewsLabelStatus + '</label><input type="checkbox" id="catStatus" /></div>');
		$('#changeViews>fieldset').append('<div><label for="catRateCounts">' + conf.Sidebar.ViewsLabelRatings + '</label><input type="checkbox" id="catRateCounts"/></div>');		
		$('#changeViews>fieldset').append('<div class="tabView"><label for="toggletab">' + conf.Sidebar.ViewsList + '</label><input type="checkbox" name="toggletab" id="toggletab"/></div>');
		
		
		$('#tab').hide();
		$('#map_wrapper_xl').append('<div id="map"></div>');
		resizeMap(); 
		$('#descrslist').append('<ul id="markersidebar"></ul>'); 
			
		// View-Logic Sidebar

		 
		$('#toggletab').click(function() {
			//e.preventDefault(); 
			if($(this).attr("checked")) {
				$("#tabAll").fadeIn('slow');
			} else { 
				$("#tabAll").fadeOut('slow');
			}
		}
		);

		$('#categoryColor').click(function(){
			if($(this).attr("checked")) { 	
				readData(1,getMarkerId);
				$('#categoryStatus').attr("checked", false);
				$('#categoryRateCounts').attr("checked", false);	
			} else{
				hideMarkers();
			}
		});

		$('#categoryStatus').click(function(){
			if($(this).attr("checked")) {
				readData(2,getMarkerId);
				$('#categoryColor').attr("checked", false);
				$('#categoryRateCounts').attr("checked", false);	
			} else {
				hideMarkers();
			}
		});

		$('#categoryRateCounts').click(function(){
			if($(this).attr("checked")) { 	
				readData(3,getMarkerId);
				$('#categoryStatus').attr("checked", false);	
				$('#categoryColor').attr("checked", false);
			} else {
			hideMarkers();
			}
		});
	
		$("#sidebar").accordion({ 
			header: "h3",
			active: 0,
			autoHeight: false
		});

	} /**endif*/
	



	/**
	 *  search from splashpage?
	 *
	 */
	if ($.url.param("data[Search][q]")){
		showLocation($.url.param("data[Search][q]"));
	}


	/**Sidebar Marker-functions*/

	$('#MarkersGeofindForm').submit(function(e){
	  e.preventDefault();
      showLocation();
 	}); 
	
	$("#categorySelect>li").children().click(function(e){
		readData(1, getMarkerId, this.id,statusCond);
		return false;
	});
	$("#statusSelect>li").children().click(function(e){
		readData(1, getMarkerId, categoryCond, this.id);
		return false;
	});
	 
    $('#disctrictSelect').change(function(){
		latlon=$(this).val();
		districtlatlon = latlon.split(",");
		map.setCenter(new GLatLng(districtlatlon[0],districtlatlon[1]),14);
	});
	/**Sidebar Functions End*/
	
	/*
	 * List Markers via AJAX
	 */
	function loadPiece(href,divName) {     
	    $(divName).load(href, {}, function(){ 
	        var divPaginationLinks = divName+" #pagination a"; 
	        $(divPaginationLinks).click(function() {      
	            var thisHref = $(this).attr("href"); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	        var divSortLinks = divName+" #sortUser th a"; 
	        $(divSortLinks).click(function() {      
	            var thisHref = $(this).attr("href"); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	        var divChooseCategory = divName+" #listCategorySelect"; 
	        $(divChooseCategory).change(function() {      
	            var thisHref = $(this).val(); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	      	var divChooseStatus = divName+" #listStatusSelect"; 
	        $(divChooseStatus).change(function() {
	            var thisHref = $(this).val(); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	
	    }); 
	} 
	
	loadPiece(conf.masDir + 'markers/ajaxlist', '#markerList'); 
	loadPiece(conf.masDir + 'markers/ajaxmylist', '#markerMyList'); 
	
	function readData(getToggle,getMarkerId,categoryCond,statusCond) {
		map.closeInfoWindow();
		if (categoryCond) {
			//valide IDs der Links in Ids umwandeln
			categoryCond = categoryCond.split("_");
			categoryCond	= categoryCond[1];
		}
		if (statusCond) {
			//valide IDs der Links in Ids umwandeln
			statusCond = statusCond.split("_");
			statusCond	= statusCond[1];
		}
		if (getToggle) {
			// wenn nicht initial, sondern nach click radiobox, 
			// leeren des markerArrays	
			$("#markersidebar >*").remove();
			hideMarkers();
			delete markersArray;
			markersArray = new Array();
			points = new Array;
			markerOptions = {};
		} else {
			getToggle=1;	
		}
		
		//case add Marker
		if (getMarkerId == 9999999) {
			showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
			return;
		}
		
		//case other pages exclude login and stuff

		switch (getMarkerId) {
			case "":
				getMarkerId = "";
				break;
			case undefined:
				return false;
				break;
		}

		

		// get data via Ajax
		$.get(conf.masDir + 'markers/ratesum/', function(data){
		 	allVotes = data;
		});

		$.getJSON(conf.masDir + 'markers/geojson/'+ getMarkerId + '/category:' + categoryCond + '/status:' + statusCond, function(data){
	
    		if (!data) {
    			$("#content").append('<div id="flashMessage" class="flash_success">' + conf.Text.NoMarkers + '</div>');
   			    $('.flash_success').animate({opacity: 1.0}, 2000).fadeOut();  
    			return;
    		}
			data = data.features[0].geometry.geometries;

    		$.each(data, function(i, item){
    			var markers = i;
				var id = item.properties.id;
				//console.log(item);
				if (item.properties.attachment) {
					var imagePath = item.properties.attachment.dirname;
					var imageBasename = item.properties.attachment.basename;
					if(imageBasename) {
						var imageName = imageBasename.split('.');
					}
					var imageId = item.properties.attachment.id;
					var imageAlt = item.properties.attachment.alternative;
				}	
				var votes = item.properties.votes;
				var label_color	= "#000000";
				if (item.properties.rating <= 2) {
					var rate_color = "#cccccc";
				} 
				if (item.properties.rating >= 2) {
					var rate_color = "#cccc99";
				}
				if (item.properties.rating >= 3) {
					var rate_color = "#ffff33";
				}
				if (item.properties.rating >= 3.5) {
					var rate_color = "#ffcc33";
				}
				if (item.properties.rating >= 4) {
					var rate_color = "#ff6600";
				}
				if (item.properties.rating >= 4.5) {
					var rate_color = "#b7090a";
					var label_color = "#ffffff";
				}
				if (imageId) {
					var htmlImg = '<span class="thumb"><a title="' + conf.Infwin.TabCommonLinkText + '" href="' + conf.masDir + 'markers/view/'+ id +'"><img src="/media/filter/s/'+ imagePath + '/' + imageName[0] +'.png" alt="'+ imageAlt +'" style="width:100px; float:right; border: 1px solid #ddd; padding: 2px;"/></a></span>';
				} else { 
					var htmlImg = '';
				}
				var html1 = '<span class="infomarker"><div class="marker_subject"><h3>' + item.properties.subject + "</h3></div>";
				var html2 = htmlImg + '<h4>' +conf.Infwin.TabCommonCategoryegory + '</h4>' + '<div class="marker_kat">' + item.properties.category.name + '</div>';
				var html3 = '<h4>' + conf.Infwin.TabCommonStatus + '</h4><div class="color_' + item.properties.status.hex + '">' + item.properties.status.name +"</div>";
				var html4 = '<h4>' + conf.Infwin.TabCommonRating + '</h4><div id="rates"></div><h4>' + conf.Infwin.TabCommonDetails + '</h4><div><a class="" href="' + conf.masDir + 'markers/view/'+ id + '">' + conf.Infwin.TabCommonLinkText + '</a></span>';
				var latlon = new CM.LatLng(item.coordinates[1],item.coordinates[0]);
				points.push(latlon);
				
				
				var CloudMadeIcon = new CM.Icon();
				CloudMadeIcon.iconSize = new CM.Size(24, 37);
				CloudMadeIcon.iconAnchor = new CM.Point(30,0);
				CloudMadeIcon.shadow="http://tile.cloudmade.com/wml/0.4/images/marker-shadow.png";
				CloudMadeIcon.shadowSize = new CM.Size(42, 37);
				/**
				 * Categoryegory view
				 *
				 */

					 
				if (getToggle == 1) {					
					//var newIcon1 = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: item.properties.category.hex });
					CloudMadeIcon.image = "/img/icons/marker_cm_" + item.properties.category.hex + ".png";
					//CloudMadeIcon.image = "http://chart.apis.google.com/chart?cht=mm&chs=32x32&chco=ffffff," + item.properties.category.hex + ",000000&ext=.png";
					
					if ($.cookie('CakeCookie[admin]')){	
						var markerOptions = {draggable:true, icon:CloudMadeIcon}; 
					} else {
						var markerOptions = {draggable:false, icon:CloudMadeIcon}; 					
					}
				}

				/**
				 * Process view
				 *
				 */		
				if (getToggle == 2 || statusCond) {	
					CloudMadeIcon.image = "/img/icons/marker_cm_" + item.properties.status.hex + ".png";
					var markerOptions = {draggable:true,icon:CloudMadeIcon}; 
				}

				/**
				 * Ratings view
				 *
				 */					
				if (getToggle == 3){	

					var percent = allVotes/30*votes;
					var iconOptions = {};
					iconOptions.width = parseInt(percent/2+35);
					//alert(iconOptions.width);
					iconOptions.height = parseInt(percent/2+35);
					iconOptions.primaryColor = rate_color;
					iconOptions.label = votes;
					iconOptions.labelSize = parseInt(percent/4+20);
					iconOptions.labelColor = label_color;
					CloudMadeIcon.image = 'http://chart.apis.google.com/chart?cht=it&chs=' + iconOptions.width + "x" + iconOptions.height + '&chco=ff0000,000000ff,ffffff01&chl=5.0&chx=000000,'+ iconOptions.labelSize + '&chf=bg,s,00000000&ext=.png';
					var markerOptions = {draggable:false, icon:CloudMadeIcon}; 
					CloudMadeIcon.iconSize = new CM.Size(iconOptions.width, iconOptions.height);
					CloudMadeIcon.shadow="";
				}
							
				var marker= new CM.Marker(latlon, markerOptions);
				var fn  = markerClickFn(latlon, html1, html2, html3, html4, item.properties.descr, latlon,id);
				
				
				if ($("#markersidebar")){
					var li = document.createElement('li');
					var html = "<a id="+ id +">"+ item.properties.subject +"</a>";
					li.innerHTML = html;
					li.style.cursor = 'pointer';
					$("#markersidebar").append(li);
					$('#'+id).click(fn);
									}
				markersArray.push(marker);
				map.addOverlay(marker);
				if (!getMarkerId) {
					CM.Event.addListener(marker, "click", fn);
					CM.Event.addListener(marker, 'dragend', function(latlng) {
						latlng  = marker.getLatLng();
						markerDragFn(latlng, html1, html2, id);
					});
					
				} else {
					map.setCenter(latlon, 15);
				}
				
			}); // $.each
			
			
			var bounds = new CM.LatLngBounds(points);

		
			for (var i=0; i< points.length; i++) {
				bounds.extend(points[i]);
			}
			map.zoomToBounds(bounds);

			//map.setZoom(map.getBoundsZoomLevel(bounds));
			map.setCenter(bounds.getCenter()); 

			if(!points) {
				alert('keine Marker');
			}
		});	// AJAX 
	};
	
    var cloudmade = new CM.Tiles.CloudMade.Web({key: '165795623c424338ad9a8eb60484ef0e',styleId: '2'});
    var map = new CM.Map('map', cloudmade);
    
	
	
	/**
	 * Call view
	 *
	 */
	readData(1,getMarkerId,categoryCond,statusCond);	
	
	initLatlon = conf.townCenter.split(",");
    map.setCenter(new CM.LatLng(initLatlon[0],initLatlon[1]));
	
	map.addControl(new CM.SmallMapControl());
	map.addControl(new CM.ScaleControl());
	//map.addControl(new CM.OverviewMapControl());





	





    
    /**Copyright line-break*/
  /*
  GEvent.addListener(map, "tilesloaded", function() {
  		$('.gmnoprint').next('div').css('white-space', 'normal');
	}); 
	
*/
	
	
		
	/**
	 * all other functions following 
	 *
	 */	
	function markerClickFn(marker, html1, html2, html3, html4, descr,latlon,id) {
		return function() {
			//map.panTo(latlon); 				
			var url = conf.masDir + 'markers/maprate?id=' + id;		
			var htmlmarker = '<div class="inf"' + html1 + html2 + html3 + html4 + '</div>';
			marker = new CM.Marker(latlon);
			map.openInfoWindow(latlon, htmlmarker);
			
			$.get(url, function(data){
	 			$('#rates').append(data);
			});	
		};
	};


	
	function hideMarkers(){
		for (i = 0; i < markersArray.length; i++) {
			markersArray[i].hide();
		}
		return;
	};
	
	
	function markerDragFn(latlon, html1, html2, id) {
	
			newlatlng = latlon;
			map.panTo(newlatlng); 	
			//var url = conf.masDir + 'markers/maprate?id=' + id;	
			if ($.cookie('CakeCookie[admin]')) {
				geocoder.getLocations(newlatlng, function(response) {
					// ... process the response somehow, for example:
					if (response.features) {
						console.log(response);
				
						for (var i = 0; i < response.features.length; i++) {
							var coords = response.features[i].centroid.coordinates;
							var address = response.features[i].properties;
							var location = response.features[i].location;
							//var country = location.country;
							var country = "Deutschland";
							//var county  = location.county;
							var newAddress = address["addr:street"]+ " " + address["addr:housenumber"] + ", " + address["addr:postcode"]  + " " + address["addr:city"] + ", " + country;
						}
					
						saveUrlAddress = newlatlng.lat() + "/" + newlatlng.lng() + "/" + newAddress;
						//alert(saveUrlAddress);
						$.get(conf.masDir + 'markers/geosave/' + id + '/' + saveUrlAddress, function(data){
							$('#newPos').append(conf.Text.NewAdress + newAddress + '<br/><span style="color:green">Position wurde aktualisiert.</span></p>');
							});
						
					
						};
					});
				}
				//map.openInfoWindow(newlatlng, htmlmarker);

			

		
	};

	function markerDragFnAdd(marker, address) {
		return function() { 
			map.closeInfoWindow();
			newlatlng = latlng.toString();
			map.panTo(newlatlng);
			html = "<h4>'+ conf.Text.NewAdress +'</h4>"+ '<div id="newPos"></div>';
			geocoder.getLocations(newlatlng, saveAddress);	
		};
	};


	function saveAddress(response) {
		if (!response) {
			//alert("Status Code:" + response.Status.code);
		} else {

		
			//place = response.features;
			//console.log(response);
			//point = new CM.LatLng(place.features.centroid[1],place.Point.coordinates[0]);
			//newAddress = place.features;
			//console.log(newAddress)
			//var addressArray = place.address.split(",");
			//var townArray	 = addressArray[1].split(" ");
			//$('#MarkerStreet').val(addressArray[0]);
			//$('#MarkerZip').val(townArray[1]);
			
/*
			if (place.AddressDetails.Country.CountryNameCode != "DE") {
				alert(conf.Text.NotCountry);
				showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
				return;
			}
*/
/*
			if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName != conf.townString) {
				alert(conf.Text.NotTown);
				showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
			}
*/
			
			saveUrlAddress = newlatlng.lat() + "/" + newlatlng.lng() + "/" + newAddress;
			if ($.cookie('CakeCookie[admin]')){	
				$.get(conf.masDir + 'markers/geosave/' + saveId + '/' + saveUrlAddress, function(data){
					$('#newPos').append(conf.Text.NewAdress + newAddress + '<br/><span style="color:green">Position wurde aktualisiert.</span></p>');
				});
			};
		};
	
	};
	
	function addAddressToMap(response) {
		geoCodedZip = "";
		geoCodedStreet = "";

		geocoder.getLocations(response, function(response) {
					// ... process the response somehow, for example:
					if (response.features) {
						console.log(response);
				
						for (var i = 0; i < response.features.length; i++) {
							var coords = response.features[i].centroid.coordinates;
							var address = response.features[i].properties;
							var location = response.features[i].location;
							//var country = location.country;
							var country = "Deutschland";
							//var county  = location.county;
							var newAddress = address["addr:street"]+ " " + address["addr:housenumber"] + ", " + address["addr:postcode"]  + " " + address["addr:city"] + ", " + country;
						}
					
						saveUrlAddress = newlatlng.lat() + "/" + newlatlng.lng() + "/" + newAddress;
						//alert(saveUrlAddress);
						$.get(conf.masDir + 'markers/geosave/' + id + '/' + saveUrlAddress, function(data){
							$('#newPos').append(conf.Text.NewAdress + newAddress + '<br/><span style="color:green">Position wurde aktualisiert.</span></p>');
							});
						
					
						};
			});

		















		//map.clearOverlays();
		
		if (!response) {
			alert("Diese Adresse kann nicht gefunden werden");
		} else {
			//console.log(response);	
			point = new CM.LatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
			
			//var newAddIcon= CM.createMarkerIcon({width: 32, height: 32});
			var markerOptions = ""; 
			alert("test");
			marker = new CM.Marker(point,markerOptions);
			
			if (place.AddressDetails.Country.CountryNameCode != "DE") {
				alert(conf.Text.NotCountry);
			return;
			}
		
			if (place.address.search(conf.townString) == - 1) {
				//alert(place.address);
				alert(conf.Text.NotTown);
				showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
			}
			
			var zip = "";
			var addressArray = place.address.split(",");
			var townArray	 = addressArray[1].split(" ");
			
			// Check if Sessionbased AddAdress is not set yet
			if (townArray[1].match(/^[0-9]+$/)){
				var zip = townArray[1];
				$('#MarkerZip').val(townArray[1]);
			}
			
			if ($('#MarkerStreet').val() == "") {
				$('#MarkerStreet').val(addressArray[0]);
			}
			
			map.setZoom(15);
			map.panTo(point);
			map.addOverlay(marker);
			
			marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>' + '<div><a href="' + conf.masDir + 'markers/startup/new/'+ addressArray[0]+'/'+ zip +'">'+ conf.Infwin.TabCommonNewDescr +' </a></div>',{maxWidth:250});
			
			if (getMarkerId == 9999999){
				//map.panTo(point); 				
				marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>',{maxWidth:250});
			}
			// drag to new position
			var updateAddress = markerDragFnAdd(marker,place.address);
			GEvent.addListener(marker, 'dragend', updateAddress);
		}
		
	};
	
	
	
	function showLocation(addressRaw) {
		// alert(address);
		// map.closeInfoWindow();
		// search address from sidebar
	 
		if (!addressRaw) {
			var address = $('#MarkerStreet').val() + ", " + conf.townString;
		} else {
			var address = addressRaw + ", " + conf.townString;
		}

		$.get(conf.masDir + 'markers/ratesum/', function(data){
		 	allVotes = data;
		});
		
		alert(address);
		
		var geocoder = new CM.Geocoder('165795623c424338ad9a8eb60484ef0e');		
		geocoder.getLocations(address, function(response) {
			
			console.log(response);
			
			var southWest = new CM.LatLng(response.bounds[0][0], response.bounds[0][1]),
				northEast = new CM.LatLng(response.bounds[1][0], response.bounds[1][1]);
			
			map.zoomToBounds(new CM.LatLngBounds(southWest, northEast));
			
			for (var i = 0; i < response.features.length; i++) {
				var coords = response.features[i].centroid.coordinates,
					latlng = new CM.LatLng(coords[0], coords[1]);
				var marker = new CM.Marker(latlng, {
					title: response.features[i].properties.name
				});

				
				map.setZoom(15);
				map.panTo(latlng);
				map.addOverlay(marker);
				var zip = conf.townZip;
				
				geocoder.getLocations(latlng, function(responseRev) {
				// ... process the response somehow, for example:
						
				if (responseRev.features) {
							console.log(responseRev);
					
							for (var i = 0; i < responseRev.features.length; i++) {
								var coords = responseRev.features[i].centroid.coordinates;
								var address = responseRev.features[i].properties;
								var location = responseRev.features[i].location;
								//var country = location.country;
								var country = "Deutschland";
								//var county  = location.county;
								newAddress = address["addr:street"]+ " " + address["addr:housenumber"] + ", " + address["addr:postcode"]  + " " + address["addr:city"] + ", " + country;
								alert(newAddress);
							marker.openInfoWindow('<h4>Position</h4>' + '<div id="newPos">'+  newAddress + '</div>' + '<div><a href="' + conf.masDir + 'markers/startup/new/'+ addressRaw +'/'+ zip +'">'+ conf.Infwin.TabCommonNewDescr +' </a></div>',{maxWidth:250});
							}
						};

				});
			
			
			
			
			
			}
		});
			
	};
	
	function getAddress(newlatlng) {
		if (newlatlng != null) {
			geocoder.getLocations(newlatlng, addAddressToMap);
		}
	};
	
	function resizeMap() {
		var MasHeight = $(window).height(); 
		var MasWidth = $(window).width(); 
		$('#wrapper').css( {height: MasHeight-10, width: MasWidth-80} ); 
		$('#footer_app').css( {width: MasWidth-80} ); 
		$('#content').css( {height: MasHeight-150, width: MasWidth-380} ); 
		$('#map').css( {height: MasHeight-150, width: MasWidth-380} ); 
		$('#breadcrump > div').css( {height: MasHeight-110, width: MasWidth-330} ); 
		$('#sidebar').css( {height: MasHeight-130} ); 
	};
	
	function GetTileUrl_Mapnik(a, z) {
	    return "http://tile.openstreetmap.org/" +
	                z + "/" + a.x + "/" + a.y + ".png";
	}
	
	function GetTileUrl_TaH(a, z) {
	    return "http://tah.openstreetmap.org/Tiles/tile/" +
	                z + "/" + a.x + "/" + a.y + ".png";
	}
	
	
});