/**
 * Mark-a-Spot marker_openstreetmaps.js
 *
 * Main Map-Application File with CLoudmade OpenStreetMaps
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.5  
 */


var markersArray = [];
var map;
var bounds = null;
var newAddress;
var address;
var zipCity;
var saveUrlAddress;
var saveId; 
var categoryCond;
var allVotes;
var getMarkerId ="";
var statusCond;
var markersidebar = $('#markersidebar');
geocoder = new google.maps.Geocoder();
var mcOptions = { gridSize: 10, maxZoom: 15};
htmlMarker = null;


$(document).ready(function () {
	var markersidebar = $('#markersidebar');
	/**
	 * Split URL and read MarkerID
	 *
	 */
	urlParts = $.url.attr("path").split("/");
	lastPart = urlParts.length -1;
	if ($.url.attr("path").indexOf(conf.Url.ControllerActionView) !== -1) {
		
		// view certain marker
		getMarkerId = urlParts[lastPart];
		$('#map_wrapper_small').append('<div id="map"></div>'); 
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.ControllerActionAdd) !== - 1 ||
		$.url.attr("path").indexOf(conf.masDir + conf.Url.ControllerActionStartup) !== - 1) {
		// add marker
		getMarkerId = 9999999;
		$('#map_wrapper_add').append('<div id="map"></div>');
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.ControllerActionEdit) !== - 1 || 
		$.url.attr("path").indexOf(conf.masDir + conf.Url.ControllerActionAdmin) !== - 1) {
			$('#map_wrapper_add').append('<div id="map"></div>');
			getMarkerId = urlParts[lastPart];
		
	} else if ($.url.attr("path") == conf.masDir) {
		
		// splashpage view
		getMarkerId = '';
		$('#map_wrapper_splash').append('<div id="map"></div>');
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.ControllerActionMap) !== -1) {
		
		// main-application view
		getMarkerId = '';
		$(window).resize(resizeMap);
		$('#content').addClass("app");
		
		$('#views').append('<h3>' + conf.Sidebar.h3Views +
			'</h3><div id="mapMenue"><form id="changeViews"><fieldset></fieldset></form></div>'); 
		$('#search').append('<h3>' + conf.Sidebar.h3Search +
			'</h3><div id="searchAdress"><form id="MarkersGeofindForm" method="post" action="' + conf.masDir +
				'markers/geofind"><fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset>' +
					'<div class="input text"><label for="MarkerStreetSearch">' + conf.Sidebar.SearchLabel + 
			'</label><br/><input name="data[Marker][street]" type="text" maxlength="256" value="" id="MarkerStreetSearch" />' +
				'<input type="submit" class="mas-btn ui-state-default" /></div></form></div></div>'); 
				
		$('#changeViews>fieldset').append('<div><label for="categoryColor">' +
			 conf.Sidebar.ViewsLabelCategory + '</label><input type="checkbox" checked="checked" id="categoryColor"/></div>');
			 
		$('#changeViews>fieldset').append('<div><label for="categoryStatus">' + conf.Sidebar.ViewsLabelStatus +
			'</label><input type="checkbox" id="categoryStatus" /></div>');

			
		$('#changeViews>fieldset').append('<div><label for="categoryRateCounts">' + conf.Sidebar.ViewsLabelRatings +
			'</label><input type="checkbox" id="categoryRateCounts"/></div>');
		
		
		$('#tab').hide();
		$('#map_wrapper_xl').append('<div id="map"></div>');
		
		resizeMap(); 
		
		$('#descrslist').append('<ul id="markersidebar"></ul>'); 



		$('#categoryColor').click(function(){
			hideMarkers();

			if($(this).attr("checked")) {
				readData(1,getMarkerId);
				$('#categoryStatus').attr("checked", false);
				$('#categoryRateCounts').attr("checked", false);
			} else{
				hideMarkers();
			}
		});

		$('#categoryStatus').click(function(){
			hideMarkers();

			if($(this).attr("checked")) {
				readData(2,getMarkerId);
				$('#categoryColor').attr("checked", false);
				$('#categoryRateCounts').attr("checked", false);
			} else {
				hideMarkers();
			}
		});

		$('#categoryRateCounts').click(function(){
			hideMarkers();

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
		geocoder.geocode('street:'+ $.url.param("data[Search][q]") + ";city:" + conf.Basic.City, 
			function(results, status) {
				addAddressToMap(results[0].geometry.location)
		});
	}

	$('#MarkerCity').blur(function() {
		geocoder.geocode($('#MarkerStreet').val() + ' ' + 
			$('#MarkerCity').val() + ' ' + $('#MarkerZip').val(), function(results, status) {
				addAddressToMap(results[0].geometry.location)
			});

	});

	/**Sidebar Marker-functions*/

	$('#MarkersGeofindForm').submit(function(e){
		e.preventDefault();
		geocoder.getLocations($("#MarkerStreetSearch").val() + ", " + conf.Basic.City, addAddressToMap);
	});
	
	$("#categorySelect>li").children().click(function(){
		hideMarkers();
		readData(1, getMarkerId, this.id,statusCond);
		return false;
	});
	$("#statusSelect>li").children().click(function(){
		hideMarkers();
		readData(2, getMarkerId, categoryCond, this.id);
		return false;
	});
	 
	$('#disctrictSelect').change(function(){
		latlon=$(this).val();
		districtlatlon = latlon.split(",");
		map.setCenter(new CM.LatLng(districtlatlon[0],districtlatlon[1]),12);
	});
	/**Sidebar Functions End*/
	
	/*
	 * List Markers via AJAX
	 */
	function loadPiece(href,divName) {

		$(divName).load(href, {}, function(){ 
			$(".asc").animate({'backgroundColor':'#f2f2f2'},1300);

			$(".desc").animate({'backgroundColor':'#f2f2f2'},1300);

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
	if ($("#tabAll")) {
		loadPiece(conf.masDir + 'markers/ajaxlist', '#markerList'); 
		loadPiece(conf.masDir + 'markers/ajaxmylist', '#markerMyList'); 
	}
	
	
	function readData(getToggle,getMarkerId,categoryCond,statusCond) {
		map.closeInfoWindow();
		if (categoryCond) {
			//valide IDs der Links in Ids umwandeln
			categoryCond = categoryCond.split("_");
			categoryCond = categoryCond[1];
		}
		if (statusCond) {
			//valide IDs der Links in Ids umwandeln
			statusCond = statusCond.split("_");
			statusCond = statusCond[1];
		}

		$("#markersidebar >*").remove();
		
		
		markersArray = null;
		markersArray = [];
		points = [];
		markerOptions = {};

		//case add Marker
		if (getMarkerId == 9999999) {
				
			geocoder.geocode({'address':$('#MarkerStreet').val() + ", " + $('#MarkerZip').val() + " " +
				$('#MarkerCity').val() + ", Deutschland"}, function(results, status) {
				addAddressToMap(results[0].geometry.location)
			});
		 
			return;
		}
		
		//case other pages exclude login and stuff

		switch (getMarkerId) {
			case "":
				getMarkerId = "";
				slash = "";
				break;
			case undefined:
				return false;
			default:
				slash = "/";
				break;
		}

		

		// get data via Ajax
		$.get(conf.masDir + 'markers/ratesum/', function(data){
			allVotes = data;
		});


		$.getJSON(conf.masDir + 'markers/geojson'+ slash + getMarkerId + '/category:' + 
			categoryCond + '/status:' + statusCond, function(data){	

				if (!data && $('#map').not(':hidden')) {
				
					$("#content").append('<div id="flashMessage" class="flash_error">' + conf.Text.NoMarkers + '</div>');
					if ($("#markersidebar")){
						var li = document.createElement('li');
						var html = "<p style=text-align:center>Zu diesem Themenfeld/ dieser Motivation keine Beiträge gefunden</p>";
						li.innerHTML = html;
						$("#markersidebar").append(li);

					}

				$('.flash_error').animate({opacity: 1.0}, 2000).fadeOut(); 
					return false;
				} else if (data !== null) {
					data = data.features[0].geometry.geometries;
				}
				
				$.each(data, function(i, item){
					var markers = i;
					var imageId;
					var mediaUrl;
					var imagePath;
					var imageName;
					var imageAlt;
					var rate_color;
					var label_color;
					var id = item.properties.id;
					if (item.properties.attachment[0]) {
						imagePath = item.properties.attachment[0].dirname;
						var imageBasename = item.properties.attachment[0].basename;
						if(imageBasename) {
							imageName = imageBasename.split('.');
						}
						imageId = item.properties.attachment[0].id;
						imageAlt = item.properties.attachment[0].alternative;
					} 
					
					if (item.properties.media_url) {
						mediaUrl = item.properties.media_url;
					}	
					var votes = item.properties.votes;
					label_color	= "#000000";
					
					if (item.properties.rating <= 2) {
						rate_color = "#cccccc";
					}
					 
					if (item.properties.rating >= 2) {
						rate_color = "#cccc99";
					}
					
					if (item.properties.rating >= 3) {
						rate_color = "#ffff33";
					}

					if (item.properties.rating >= 3.5) {
						rate_color = "#ffcc33";
					}
					
					if (item.properties.rating >= 4) {
						rate_color = "#ff6600";
					}
					
					if (item.properties.rating >= 4.5) {
						rate_color = "#b7090a";
						label_color = "#ffffff";
					}
					var htmlImg ="";
					
					if (imageId) {
						htmlImg = '<span class="thumb"><a title="' + conf.Infwin.TabCommonLinkText +
							'" href="' + conf.masDir + 'markers/view/'+ id +'"><img src="/media/filter/s/'+
								imagePath + '/' + imageName[0] +'.png" alt="'+ imageAlt +
									'" style="width:100px; float:right; border: 1px solid #ddd; padding: 2px;"/></a></span>';
					} 
					
					if (mediaUrl) { 
						htmlImg = '<span class="thumb"><a title="' + conf.Infwin.TabCommonLinkText + '" href="' + mediaUrl +'"><img src="/img/chart.png" style="width:32px; float:right; border: 1px solid #ddd; padding: 2px;"/></a></span>';
					}
					
					var html1 = '<span class="infomarker"><div class="marker_subject"><h3><a class="" href="' +
						conf.masDir + 'markers/view/'+ id + '">' + item.properties.subject + "</a></h3></div>";
					var html2 = htmlImg + '<h4>' +conf.Infwin.TabCommonCategory +
						'</h4>' + '<div class="marker_kat">' + item.properties.category.name + '</div>';
					var html3 = '<h4>' + conf.Infwin.TabCommonStatus + '</h4><div class="color_' +
						item.properties.status.hex + '">' + item.properties.status.name +"</div>";
					var html4 = '<div id="rates"></div><h4>' + conf.Infwin.TabCommonDetails +
						 '</h4><div><a class="" href="' + conf.masDir + 'markers/view/'+ id + '">' +
							conf.Infwin.TabCommonLinkText + '</a></span>';
					var latlon = new CM.LatLng(item.coordinates[1],item.coordinates[0]);
					points.push(latlon);
					
					/**
					 * Categoryegory view
					 *
					 */
					var newIcon;

					var CloudMadeIcon = new CM.Icon();
					CloudMadeIcon.iconSize = new CM.Size(32, 32);
					CloudMadeIcon.iconAnchor = new CM.Point(0,10);
					CloudMadeIcon.shadow = "/img/icons/cartosoft/marker_crts_shadow.png";
					CloudMadeIcon.shadowSize = new CM.Size(52, 35);


				if (getToggle == 1) {					
					//var newIcon1 = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: item.properties.category.hex });
					CloudMadeIcon.image = "/img/icons/cartosoft/marker_crts_" + item.properties.category.hex + ".png";
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
					CloudMadeIcon.image = "/img/icons/cartosoft/marker_crts_" + item.properties.status.hex + ".png";
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
				var fn  = markerClickFn(latlon, html1, html2, html3, html4, item.properties.description, latlon,id);
				
				
				if ($("#markersidebar")){
					var li = document.createElement('li');
					var html = "<a id="+ id +">"+ item.properties.subject +"</a>";
					li.innerHTML = html;
					li.style.cursor = 'pointer';
					$("#markersidebar").append(li);
					$('#'+id).click(fn);
									}
				// markersArray.push(marker);
				map.addOverlay(marker);
				if (!getMarkerId) {
					CM.Event.addListener(marker, "click", fn);
					CM.Event.addListener(marker, 'dragend', function(latlng) {
						latlng  = marker.getLatLng();
						markerDragFn(marker, latlng, html1, html2, id);
					});
					
				} else {
					map.setCenter(latlon, 15);
				}
				
			}); // $.each
			
			
			var bounds = new CM.LatLngBounds(points);

		
			for (var i=0; i< points.length; i++) {
				bounds.extend(points[i]);
			}
			if (points.length == 1) {
				map.setCenter(bounds.getCenter(),map.getBoundsZoomLevel(bounds)-3); 
			} else {
				map.setCenter(bounds.getCenter(),map.getBoundsZoomLevel(bounds)); 
			}
			if(!points) {
				alert('keine Marker');
			}
			//console.log(markersArray);
			markerClusterer = new CM.MarkerClusterer(map, {clusterRadius: 10});
			markerClusterer.addMarkers(markersArray);

		});
	}


	if (!$("#MarkerCity").val()) {
		$("#MarkerStreet").val(conf.Basic.Street);
		$("#MarkerCity").val(conf.Basic.City);
		$("#MarkerZip").val(conf.Basic.Zip);
	}
	
	var cloudmade = new CM.Tiles.CloudMade.Web({key: '165795623c424338ad9a8eb60484ef0e',styleId: '998'})
	var map = new CM.Map('map', cloudmade);
	var topLeft = new CM.ControlPosition(CM.TOP_LEFT, new CM.Size(10, 10));
	map.addControl(new CM.SmallMapControl(), topLeft);	 
	/**
	 * Call view
	 *
	 */
	if (!$.url.param("data[Search][q]")){
		readData(1, getMarkerId, categoryCond, statusCond);
	}
	initLatlon = conf.Basic.CityCenter.split(",");
	map.setCenter(new CM.LatLng(initLatlon[0],initLatlon[1]));
	
	
	/**Copyright line-break*/
	CM.Event.addListener(map, "tilesloaded", function() {
		$('.gmnoprint').next('div').css('white-space', 'normal');
	}); 
	
	

	function markerClickFn(marker, html1, html2, html3, html4, descr,latlon,id) {
		return function() {
			map.panTo(latlon); 
			//var url = conf.masDir + 'markers/maprate?id=' + id;
			var htmlMarker = '<div class="inf"' + html1 +
				html2 + html3 + html4 + '</div>';

			map.openInfoWindow(latlon, htmlMarker);
			
/*
			$.get(url, function(data){
				//$('#rates').append(data);
			});	
*/
		};
	}


	
	function hideMarkers(){

		if(markerClusterer !== null) {
			// not yet supported in cloudmade
			// markerClusterer.clearMarkers();
		}

		map.clearOverlays();
		return false;
	}
	
	
	function markerDragFn(marker, latlng, html1, html2, id) {
		map.panTo(latlng);
		saveId=id;
		htmlMarker = '<div class="inf"' + html1 + html2 + '</div>';
		if ($.cookie('CakeCookie[admin]')) {
			htmlMarker = '<div><h4>' + conf.Text.NewAdress +
				'</h4><div id="newPos"></div></div>';

			saveId=id;
		}

		map.openInfoWindow(latlng, htmlMarker);
		addAddressToMap(latlng);
	}
	
	function markerDragFnAdd(marker) {
		return function() { 
			map.closeInfoWindow();
			map.removeOverlay(marker);
			newlatlng = this.getLatLng();
			map.setZoom(map.getZoom()+1);
			map.panTo(newlatlng);
			html = "<h4>'+ conf.Text.NewAdress +'</h4>"+ '<div id="newPos"></div>';
			
			addAddressToMap(newlatlng);	
		};
	}



	function addAddressToMap(latlng) {
		var latlng = latlng.toString(4);
		var latlng = latlng.replace('(',"");
		var latlng = latlng.replace(')',"");
		var latlngStr = latlng.split(",",2);
		var lat = parseFloat(latlngStr[0]);
		var lng = parseFloat(latlngStr[1]);

		var latlng = new google.maps.LatLng(lat, lng);
		geocoder.geocode({'latLng': latlng},
			function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						//console.log(results[0].address_components);
						console.log(results[0].formatted_address);
						//alert(results[0].formatted_address)
						address = results[0].formatted_address.split(", ");
						zipCity = address[1].split(" ");
					} else {
						alert("No results found");
					}
				} else {
					alert("Geocoder failed due to: " + status);
				}	
				
				if (address[2] !== "Deutschland") {
					alert(conf.Text.NotCountry);
					geocoder.getLocations({'address':conf.Basic.Street +
						' ' + conf.Basic.City + ' ' + conf.Basic.Zip});
					getMarkerId = 9999999;
					readData(1,getMarkerId, null, null);
					return;
				}
				if (zipCity[1] !== conf.Basic.City) {
					alert(conf.Text.NotTown);
	
					geocoder.geocode({'address':conf.Basic.Street +
						' ' + conf.Basic.City + ' ' + conf.Basic.Zip}, 
						function(results, status) {
							addAddressToMap(results[0].geometry.location)
					});

					$('#MarkerStreet').val(conf.Basic.Street);
					$('#MarkerZip').val(conf.Basic.Zip);
					$('#MarkerCity').val(conf.Basic.City);
	
					getMarkerId = 9999999;
					readData(1,getMarkerId, null, null);
					return;
				}


				Zip = zipCity[0];
				Street = address[0]
					// LK : City = Locality.DependentLocality.DependentLocalityName
					// KF :
				City = zipCity[1]
				$('#MarkerStreet').val(Street);
				$('#MarkerZip').val(Zip);
				$('#MarkerCity').val(City);
			
				/*
						$("#MarkerStreet").val(conf.Basic.Street);
						$("#MarkerCity").val(conf.Basic.City);
						$("#MarkerZip").val(conf.Basic.Zip);
						
				*/

				// Add this marker or searched for place?

				if (saveId == null) {

					if (map.getZoom() <= 12) {
						map.setZoom(14);}
					else {
						map.setZoom(map.getZoom()+1);
					}

					
					point = new CM.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
					map.panTo(point);
					map.clearOverlays();
					
					var CloudMadeIcon = new CM.Icon();
					CloudMadeIcon.iconSize = new CM.Size(32, 32);
					CloudMadeIcon.shadow = "/img/icons/cartosoft/marker_crts_shadow.png";
					CloudMadeIcon.shadowSize = new CM.Size(52, 35);
					CloudMadeIcon.image = "/img/icons/cartosoft/marker_crts_cccccc.png";

					markerOptions = {text:"Zieh mich!", draggable:true,icon:CloudMadeIcon};
					var marker= new CM.Marker(point, markerOptions);
					map.addOverlay(marker);
					
					if ($("#mobile").length == 0){
						marker.openInfoWindow('<h4>Position</h4>' + '<div id="newPos">'+ results[0].formatted_address + '</div>' + 
							'<div><a rel="external" href="' + conf.masDir + 'markers/startup/new/street:'+ Street	+
								'/zip:'+ Zip +'/city:'+ City +'">'+ conf.Infwin.TabCommonNewDescr +
									' </a></div>',{maxWidth:250});
						}
				} 


				// did admin drag that marker?

				if (saveId) {

					saveUrlAddress = results[0].geometry.location.lat() + "/" + results[0].geometry.location.lng() + "/street:" + Street + "/zip:"+ Zip + "/city:" + City ;
					point = new CM.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
					map.panTo(point);

					if ($.cookie('CakeCookie[admin]')){	
						$.get(conf.masDir + 'markers/geosave/' + saveId + '/' + saveUrlAddress, function(data){
							$('#newPos').append('<span style="color:green">Position wurde aktualisiert.</span><br/>'+ 
								Street + ", " + Zip + " " + City + '</p>');
						});
					}
				}
	
				// do we add a new marker?
				if (getMarkerId == 9999999){
					map.panTo(point);
					marker.openInfoWindow('<h4>Position</h4>' + '<div id="newPos">'+ results[0].formatted_address + '</div>',{maxWidth:250});
				
					// drag to new position
					var updateAddress = markerDragFnAdd(marker);
					CM.Event.addListener(marker, 'dragend', updateAddress);
				}
			//return address;
			}
		);

		
	}



	CM.Event.addListener(map, 'dblclick', function(latlng) {
		addAddressToMap(latlng)
	});

/*
	CM.Event.addListener(map, 'click', function() {
		map.setZoom(map.getZoom()+1);
	});
*/


	function resizeMap() {
		var MasHeight = $(window).height(); 
		var MasWidth = $(window).width(); 
		$('#wrapper').css( {height: MasHeight-10, width: MasWidth-80} ); 
		$('#footer_app').css( {width: MasWidth-80} ); 
		$('#content').css( {height: MasHeight-280, width: MasWidth-380} ); 
		$('#map').css( {height: MasHeight-280, width: MasWidth-380} ); 
		$('#breadcrump > div').css( {height: MasHeight-110, width: MasWidth-330} ); 
		$('#sidebar').css( {height: MasHeight-260} ); 
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