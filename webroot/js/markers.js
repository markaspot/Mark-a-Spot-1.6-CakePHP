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
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.5.3  
 */


var markersArray = [];
var map;
var bounds = null;
var newAddress;
var saveUrlAddress;
var saveId; 
var categoryCond;
var allVotes;
var getMarkerId ="";
var statusCond;
var markersidebar = $('#markersidebar');
var geocoder = new GClientGeocoder();
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
		getMarkerId = true;
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
		if($.mobile){
			$('categoryColor').attr('checked', true)
		}
		$('#views').append('<h3 id="h3views">' + conf.Sidebar.h3Views +
			'</h3><div id="mapMenue"><form id="changeViews"><fieldset data-role="controlgroup" data-type="horizontal" data-role="fieldcontain"></fieldset></form></div>'); 
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
		geocoder.getLocations($.url.param("data[Search][q]") + ", " + conf.Basic.City, addAddressToMap);
	}

	$('#MarkerCity').blur(function() {
		geocoder.getLocations($('#MarkerStreet').val() + ' ' + 
			$('#MarkerCity').val() + ' ' + $('#MarkerZip').val(), addAddressToMap);
	});

	/**Sidebar Marker-functions*/

	$('#MarkersGeofindForm').submit(function(e){
		e.preventDefault();
		geocoder.getLocations($("#MarkerStreetSearch").val() + ", " + conf.Basic.City, addAddressToMap);
	});
	
	$("#categorySelect>li").children().click(function(e){
		hideMarkers();
		readData(1, getMarkerId, this.id,statusCond);
		return false;
	});
	$("#statusSelect>li").children().click(function(e){
		hideMarkers();
		readData(2, getMarkerId, categoryCond, this.id);
		return false;
	});
	 
	$('#disctrictSelect').change(function(){
		latlon=$(this).val();
		districtlatlon = latlon.split(",");
		map.setCenter(new GLatLng(districtlatlon[0],districtlatlon[1]),12);
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
	if ($("#tabAll")) {
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
		if (getMarkerId == true) {

			geocoder.getLocations($('#MarkerStreet').val() + ", " + $('#MarkerZip').val() + " " +
				$('#MarkerCity').val() + ", Deutschland", addAddressToMap);
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
					
					
					var html1 = '<span class="infomarker"><div class="marker_subject"><h3><a class="" href="' +
						conf.masDir + 'markers/view/'+ id + '">' + item.properties.subject + "</a></h3></div>";
					var html2 = htmlImg + '<h4>' +conf.Infwin.TabCommonCategory +
						'</h4>' + '<div class="marker_kat">' + item.properties.category.name + '</div>';
					var html3 = '<h4>' + conf.Infwin.TabCommonStatus + '</h4><div class="color_' +
						item.properties.status.hex + '">' + item.properties.status.name +"</div>";
					var html4 = '<div id="rates"></div>' +
						'<div><a class="button" data-role="button" href="' + conf.masDir + 'markers/view/'+ id + '">' +
							conf.Infwin.TabCommonLinkText + '</a></span>';
					var latlon = new GLatLng(item.coordinates[1],item.coordinates[0]);
					points.push(latlon);
					
					/**
					 * Categoryegory view
					 *
					 */
					var newIcon;
					if (getToggle == 1) {
					
						newIcon = MapIconMaker.createMarkerIcon({
							width: 32, height: 32, 
							primaryColor: item.properties.category.hex 
						});
						if ($.cookie('CakeCookie[admin]')) {	
							markerOptions = {draggable:true, icon:newIcon};
						} else {
							markerOptions = {draggable:false, icon:newIcon};
						}
					}
	
					/**
					 * Status view
					 *
					 */		
					if (getToggle == 2) {	

						newIcon = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: item.properties.status.hex });
						if ($.cookie('CakeCookie[admin]')) {	
							markerOptions = {draggable:true, icon:newIcon};
						} else {
							markerOptions = {draggable:false, icon:newIcon};
						} 
					}
	
					/**
					 * Ratings view
					 *
					 */					
					if (getToggle == 3){	
	
						var percent = 300/30*votes;
						var iconOptions = {};
						iconOptions.width = parseInt(percent/2+35,10);
						iconOptions.height = parseInt(percent/2+35,10);
						iconOptions.primaryColor = rate_color;
						iconOptions.label = votes;
						iconOptions.labelSize = parseInt(percent/4+20,10);
						iconOptions.labelColor = label_color;
						iconOptions.shape = "circle";
						newIcon = MapIconMaker.createFlatIcon(iconOptions);
						markerOptions = {text:"Zieh mich!", draggable:false, icon:newIcon}; 
					}
								
					var marker= new GMarker(latlon, markerOptions);
					var fn  = markerClickFn(
						markers[item], html1, html2, html3, html4, item.properties.description, latlon,id);
					var fn1 = markerDragFn(
						markers[item], html1, html2, id);
	
					
	
					
					if ($("#markersidebar")){
					
						var li = document.createElement('li');
						var html = "<a>"+ item.properties.subject +"</a>";
						li.innerHTML = html;
						li.style.cursor = 'pointer';
						$("#markersidebar").append(li);
						GEvent.addDomListener(li, "click", fn);
					}
					markersArray.push(marker);

					if (!getMarkerId) {

						GEvent.addListener(marker, "click", fn);
						GEvent.addListener(marker, 'dragend', fn1);
					} else {
						map.setCenter(latlon, 15);
					}
					
				}); 

			var bounds = new GLatLngBounds();

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
			markerClusterer = new MarkerClusterer(map, markersArray, mcOptions);
		});
	}


	if (!$("#MarkerCity").val()) {
		$("#MarkerStreet").val(conf.Basic.Street);
		$("#MarkerCity").val(conf.Basic.City);
		$("#MarkerZip").val(conf.Basic.Zip);
	}

	map = new GMap2(document.getElementById("map"));
	
	var customUI = map.getDefaultUI();
	customUI.maptypes.physical = true;
	customUI.maptypes.normal = true;
	customUI.maptypes.hybrid = true;
	customUI.maptypes.satellite = true;
	
	//map.removeControl(customUI);

	map.setUI(customUI);
	/**
	 * Call view
	 *
	 */
	if (!$.url.param("data[Search][q]")){
		readData(1, getMarkerId, categoryCond, statusCond);
	}
	initLatlon = conf.Basic.CityCenter.split(",");
	map.setCenter(new GLatLng(initLatlon[0],initLatlon[1]));
	
	
	/**Copyright line-break*/
	GEvent.addListener(map, "tilesloaded", function() {
		$('.gmnoprint').next('div').css('white-space', 'normal');
	}); 
	
	

	function markerClickFn(marker, html1, html2, html3, html4, descr,latlon,id) {
		return function() {
			map.panTo(latlon); 
			var url = conf.masDir + 'markers/maprate?id=' + id;
			var htmlMarker = [];
			htmlMarker.push(new GInfoWindowTab(conf.Infwin.TabCommon, '<div class="inf"' + html1 +
				html2 + html3 + html4 + '</div>'));

			map.openInfoWindowTabs(latlon, htmlMarker);
			
/*
			$.get(url, function(data){
				//$('#rates').append(data);
			});	
*/
		};
	}


	
	function hideMarkers(){
	
		if(markerClusterer !== null) {
			markerClusterer.clearMarkers();
		}

		map.clearOverlays();
		return;
	}
	
	
	function markerDragFn(marker, html1, html2, id) {
	
		return function() {
			newlatlng = this.getLatLng();
			map.panTo(newlatlng);
			saveId=id;
			var htmlMarker = [];
			htmlMarker.push(new GInfoWindowTab(conf.Infwin.TabCommon, '<div class="inf"' + html1 + html2 + '</div>'));
	
			if ($.cookie('CakeCookie[admin]')) {
				htmlMarker.push(new GInfoWindowTab(conf.Infwin.TabAdmin, '<div><h4>' + conf.Text.NewAdress +
					'</h4><div id="newPos"></div></div>'));

				saveId=id;
				geocoder.getLocations(newlatlng, addAddressToMap);
			}

			map.openInfoWindowTabs(newlatlng, htmlMarker, {selectedTab:1});

		};
	}
	
	function markerDragFnAdd(marker, address) {
	
		return function() { 
			map.closeInfoWindow();
			map.removeOverlay(marker);

			newlatlng = this.getLatLng();
			map.setZoom(map.getZoom()+1);
			map.panTo(newlatlng);
			html = "<h4>'+ conf.Text.NewAdress +'</h4>"+ '<div id="newPos"></div>';
			
			geocoder.getLocations(newlatlng, addAddressToMap);	
		};
	}

	function addAddressToMap(response) {

		if (!response || response.Status.code !== 200) {
			
			alert("Diese Adresse kann nicht gefunden werden");

		} else {
			place = response.Placemark[0];
			
/*
			if (place.AddressDetails.Country.CountryNameCode !== "DE") {
				//alert(conf.Text.NotCountry);
				
				geocoder.getLocations(conf.Basic.Street +
				 ' ' + conf.Basic.City + ' ' + conf.townZip, addAddressToMap);
				getMarkerId = 9999999;
				readData(1,getMarkerId, null, null);
				return;
			}
*/

			Locality = [];

			if (place.AddressDetails.Country.Locality){
				Locality = place.AddressDetails.Country.Locality;
				
			} else if (place.AddressDetails.Country.SubAdministrativeArea){
				Locality = place.AddressDetails.Country.SubAdministrativeArea.Locality;
				
			} else if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) {
				SubAdministrativeArea = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea;
				Locality = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality;

				//if (SubAdministrativeArea.SubAdministrativeAreaName !== conf.Basic.City) {
				if (Locality.LocalityName !== conf.Basic.City) {

					//alert(conf.Text.NotTown);

					geocoder.getLocations(conf.Basic.Street +
						' ' + conf.Basic.City + ' ' + conf.Basic.Zip, addAddressToMap);
					$('#MarkerStreet').val(conf.Basic.Street);
					$('#MarkerZip').val(conf.Basic.Zip);
					$('#MarkerCity').val(conf.Basic.City);

					getMarkerId = 9999999;
					readData(1,getMarkerId, null, null);
					return;
				}
			} else if (place.AddressDetails.Country.AdministrativeArea.Locality){
				Locality = place.AddressDetails.Country.AdministrativeArea.Locality;
				
			}

			if (Locality.DependentLocality) {
			
				Zip = Locality.DependentLocality.PostalCode.PostalCodeNumber;
				if (Locality.DependentLocality.Thoroughfare){
					Street = Locality.DependentLocality.Thoroughfare.ThoroughfareName;
					// LK : City = Locality.DependentLocality.DependentLocalityName
					// KF :
					City = Locality.LocalityName;
				$('#MarkerStreet').val(Street);
				$('#MarkerZip').val(Zip);
				$('#MarkerCity').val(City);
				}
			} else if (Locality.PostalCode){
			
				Zip = Locality.PostalCode.PostalCodeNumber;
				Street = "";
				City = Locality.LocalityName;
				
				if (Locality.Thoroughfare){
					Street = Locality.Thoroughfare.ThoroughfareName;
					City = Locality.LocalityName;
				}
				
				$('#MarkerStreet').val(Street);
				$('#MarkerZip').val(Zip);
				$('#MarkerCity').val(City);
			
			} else if (!Locality.PostalCode) {
				
				Zip = "";
				Street = "";
				City = Locality.LocalityName;
				
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
				$('#MarkerCity').val(City);
			
			} else {
			
			$("#MarkerStreet").val(conf.Basic.Street);
			$("#MarkerCity").val(conf.Basic.City);
			$("#MarkerZip").val(conf.Basic.Zip);
			
			}

			// Add this marker or searched for place?

			if (saveId == null) {
				
				if (map.getZoom() <= 12) {
					map.setZoom(14);}
				else {
					map.setZoom(map.getZoom()+1);
				}
				
				point = new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
				map.panTo(point);
				
				map.clearOverlays();
				
				var newAddIcon= MapIconMaker.createMarkerIcon({width: 32, height: 32});
				markerOptions = {text:"Zieh mich!", draggable:true, icon:newAddIcon};
				var marker = new GMarker(point,markerOptions);
				map.addOverlay(marker);
				if ($("#mobile").length == 0){
					marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>' + 
						'<div><a rel="external" href="' + conf.masDir + 'markers/startup/new/street:'+ Street	+
							'/zip:'+ Zip +'/city:'+ City +'">'+ conf.Infwin.TabCommonNewDescr +
								' </a></div>',{maxWidth:250});
					}
			} 

			
			// did admin drag that marker?

			if (saveId) {

				saveUrlAddress = newlatlng.lat() + "/" + newlatlng.lng() + "/street:" + Street + "/zip:"+ Zip + "/city:" + City ;
				if ($.cookie('CakeCookie[admin]')){	
					$.get(conf.masDir + 'markers/geosave/' + saveId + '/' + saveUrlAddress, function(data){
						$('#newPos').append('<span style="color:green">Position wurde aktualisiert.</span><br/>'+ 
							Street + ", " + Zip + " " + City + '</p>');
					});
				}
			}

			// do we add a new marker?
			if (getMarkerId != 9999999){
				//map.panTo(point);
				marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>',{maxWidth:250});
			
				// drag to new position
				var updateAddress = markerDragFnAdd(marker,place.address);
				GEvent.addListener(marker, 'dragend', updateAddress);
			}
			
		}
	}





	//GEvent.addListener(map,"click", getAddress);
	
	function getAddress(overlay, latlng) {
		if (latlng != null) {
			address = latlng;
			geocoder.getLocations(latlng, addAddressToMap);
		}
	}
		
	// Check for Mobile HTML5 Client
	if ($("#mobile").length > 0){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(success, error);
		} else {
		 	error('not supported');
		}
	}

	function error(msg) {
		alert(msg);
	}
	
	function success(position) {
		$("#content").append('<div id="flashMessage" class="flash_success">' + conf.Text.FoundYou + '</div>');

		var latlng = new GLatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(latlng,12);

		geocoder.getLocations(latlng, addAddressToMap);
	};

	if($.mobile){
		$('#categoryColor').attr('checked', false)
	}
	function resizeMap() {
		var MasHeight = $(window).height(); 
		var MasWidth = $(window).width(); 
	
		if(!$.mobile) {

			$('#wrapper').css( {height: MasHeight-10, width: MasWidth-80} ); 
			$('#footer_app').css( {width: MasWidth-80} ); 
			$('#content').css( {height: MasHeight-280, width: MasWidth-380} ); 
			$('#map').css( {height: MasHeight-280, width: MasWidth-380} ); 
			$('#breadcrump > div').css( {height: MasHeight-110, width: MasWidth-330} ); 
			$('#sidebar').css( {height: MasHeight-260} ); 
		} else {
			$('#map').css( {height: MasHeight, width: MasWidth} ); 
			$('#moptions').css( {top: MasHeight-120, left: MasWidth-380} ); 

		}
	};
	
	function GetTileUrl_Mapnik(a, z) {
		return "http://tile.openstreetmap.org/" +
	z + "/" + a.x + "/" + a.y + ".png";
	}
	
	function GetTileUrl_TaH(a, z) {
		return "http://tah.openstreetmap.org/Tiles/tile/" +
	z + "/" + a.x + "/" + a.y + ".png";
	}
	
	$('.message').animate({opacity: 1.0}, 8000).fadeOut();  
	$('.flash_success').animate({opacity: 1.0}, 8000).fadeOut();  
	$('.flash_error').animate({opacity: 1.0}, 8000).fadeOut();
	$('#validateMessage').hide();
	
	if ($('#validateMessage').is(':hidden'))	{
		$('#addFormMediaDiv').hide(); 
	};

});