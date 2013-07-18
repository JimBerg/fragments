/**
 * Googlemap wird geladen
 * Eigene Kartenoverlays, Marker, Infowindow definiert
 * @todo... alles in der getJSON-Abfrage... mir scheint als wäre das nicht so schön ;)
 * @todo... aber wie mach ich "getMarker" global verfügbar ;)
 */

$(document).ready(function() {
	

	/**
	 * Daten für Map holen
	 */
	
	$.getJSON(PAGE_URL+'dashboard/getUserData', function(data) {
		/**
		 * Startmarker = Homelocation bzw. aktuelle Position des aktuellen Users holen
		 */
		getMarker = {
			userName: data.name,
			id:data.id,
			location: data.location,
			lng: data.lng,
			lat: data.lat,
			fbId: data.fbId,
			isFan: data.isFan
		};
		
		var swissMapType = new google.maps.ImageMapType({ 
			getTileUrl: function(coord, zoom) {
	        return getHorizontallyRepeatingTileUrl(coord, zoom, function(coord, zoom) {
	        	return PAGE_URL_IMAGES+'/testmap/'+zoom + "/" + coord.x + "/" + (Math.pow(2,zoom)-coord.y-1) +".png"; 
	        });
	      }, 
	       tileSize: new google.maps.Size(256, 256),
	       isPng: true,
	         minZoom: 2,
	      	 maxZoom: 6,
	      	 name: 'SwissMap'
	     });
		// Normalizes the tile URL so that tiles repeat across the x axis (horizontally) like the
	    // standard Google map tiles.
	    function getHorizontallyRepeatingTileUrl(coord, zoom, urlfunc) {
	      var y = coord.y;
	      var x = coord.x;
	 
	      // tile range in one direction range is dependent on zoom level
	      // 0 = 1 tile, 1 = 2 tiles, 2 = 4 tiles, 3 = 8 tiles, etc
	      var tileRange = 1 << zoom;
	 
	      // don't repeat across y-axis (vertically)
	      if (y < 0 || y >= tileRange) {
	        return null;
	      }
	 
	      // repeat across x-axis
	      if (x < 0 || x >= tileRange) {
	        x = (x % tileRange + tileRange) % tileRange;
	      }
	 
	      return urlfunc({x:x,y:y}, zoom)
	    }
	     
		/**
		 * Kartenoptionen festsetzen: Standardzoom, Standardkarte, 
		 * Mittelpunkt (entspricht hier der Homelocation des akt. Users) usw.
		 */
		var mapDiv = document.getElementById('mapCanvas');
		var mapOptions = {
			minZoom:2,
			maxZoom:6,
		 	zoom: 4,
		    center: new google.maps.LatLng(getMarker.lat, getMarker.lng),
	        //disableDefaultUI: true, 
		    mapTypeControl: false
		    /*mapTypeControlOptions: {
		        mapTypeIds: ['swissMap']
		    }*/
		 };
		
		/**
		 * Karte inititalisieren
		 */
		swissMap = new google.maps.Map(mapDiv, mapOptions);
		swissMap.mapTypes.set('swissMap', swissMapType);
		swissMap.setMapTypeId('swissMap');
		
		/**
		 * Currentlocation setzen, die direkt angezeigt wird
		 */
		currentLocation = new google.maps.Marker({
			position: new google.maps.LatLng(getMarker.lat, getMarker.lng),
			id: getMarker.id,
			title: getMarker.userName,
			locationName: getMarker.location
		});

		$("#panToHomebase").click(function() { 
			swissMap.panTo(currentLocation.position);
		});

		$.getJSON(PAGE_URL+'dashboard/loadMap', function(data) { 

			// Daten holen und einsortieren
			var homebase = data.homebase;
			var friends = data.friends;
			
			var swissDestinations = data.swissDestinations;
			var foreignDestinations = data.foreignDestinations;

			var notReachableSwissDestinations = data.notReachableSwissDestinations;
			var notReachableForeignDestinations = data.notReachableForeignDestinations;
			
			/**
			 * Homebase => HIER WEG
			 */
			homebaseMarker = new google.maps.Marker({
				position: new google.maps.LatLng(homebase.lat, homebase.lng),
				locationName: homebase.location,
				zIndex: 11
			});

			/**
			 * Cluster erzeugen
			 */
			$(swissDestinations).each(function(k,swissMarker) {
				if(swissMarker.destination != currentLocation.id) {
					clusterReachable = {
						clusterId: swissMarker.destination,
						clusterName: swissMarker.location,
						clusterCenter: new google.maps.LatLng(swissMarker.lat, swissMarker.lng), 
						markers: getMarkers(friends, swissMarker.destination),
						markerClass: swissMarker.airportType+"_"+swissMarker.reachable
					};
					var createCluster = new MyCluster(swissMap, clusterReachable);
				}
			});
			
			$(foreignDestinations).each(function(k,foreignMarker) {
				if(foreignMarker.destination != currentLocation.id) {
					clusterForeignReachable = {
						clusterId: foreignMarker.destination,
						clusterName: foreignMarker.location,
						clusterCenter: new google.maps.LatLng(foreignMarker.lat, foreignMarker.lng), 
						markers: getMarkers(friends, foreignMarker.destination),
						markerClass: foreignMarker.airportType+"_"+foreignMarker.reachable
					};
					var createForeignCluster = new MyCluster(swissMap, clusterForeignReachable);
				}
			});
			
			$(notReachableSwissDestinations).each(function(k,notReachableSwissMarker) {
				if(notReachableSwissMarker.destination != currentLocation.id) {
					clusterNotReachable = {
						clusterId: notReachableSwissMarker.destination,
						clusterName: notReachableSwissMarker.location,
						clusterCenter: new google.maps.LatLng(notReachableSwissMarker.lat, notReachableSwissMarker.lng), 
						markers: getMarkers(friends, notReachableSwissMarker.destination),
						markerClass: notReachableSwissMarker.airportType+"_"+notReachableSwissMarker.reachable
					};
					var createNotReachableCluster = new MyCluster(swissMap, clusterNotReachable);
				}
			});
			
			$(notReachableForeignDestinations).each(function(k,notReachableForeignMarker) {
				if(notReachableForeignMarker.destination != currentLocation.id) {
					clusterForeignNotReachable = {
						clusterId: notReachableForeignMarker.destination,
						clusterName: notReachableForeignMarker.location,
						clusterCenter: new google.maps.LatLng(notReachableForeignMarker.lat, notReachableForeignMarker.lng), 
						markers: getMarkers(friends, notReachableForeignMarker.destination),
						markerClass: notReachableForeignMarker.airportType+"_"+notReachableForeignMarker.reachable
					};
					var createNotReachableForeignCluster = new MyCluster(swissMap, clusterForeignNotReachable);
				}
			});
			
			clusterHome = {
				clusterId: homebaseMarker.id,
				clusterName: homebaseMarker.locationName,
				clusterCenter: homebaseMarker.position, 
				hometown: homebase.hometown,
				markers: [],
				markerClass: homebase.airportType
			};
			var createClusterHome = new MyCluster(swissMap, clusterHome);
			
			clusterCurrent = {
				clusterId: currentLocation.id,
				clusterName: currentLocation.locationName,
				clusterCenter: currentLocation.position, 
				fbId: getMarker.fbId, 
				markers: [],
				markerClass: "current_current"
			};
			var createClusterCurrent = new MyCluster(swissMap, clusterCurrent);
				
			
			/**
			 * Friendmarker zuweisen
			 */
			function getMarkers(markerCollection, id){
				var clusterMarker = new Array();
				var markers = markerCollection;
				for(var i=0; i<markers.length; i++) {
					if(markers[i].destinationId == id) {
						var marker = {
			                 position: new google.maps.LatLng(markers[i].lat, markers[i].lng),
			                 destinationId: markers[i].destinationId,
			                 destinationName: markers[i].destinationName,
			                 friendName: markers[i].friendName,
			                 fbId: markers[i].fbId,
			                 location: markers[i].location,
			                 friendReachable: markers[i].friendReachable
						}
						clusterMarker.push(marker);
					}
				}
				return clusterMarker;	
			}
			$("#openFolder").bind('click', function() { 
				/*var friends_isfan = {
					friends: friends,
					isFan:getMarker.isFan
				}*/
				openStatusBar(friends);
			});
			$("#friendSearch").keyup(function() {
				var searchInput = $(this).val();
				if(searchInput.length == 0) {
				}
				var reduced_friends = new Array();
				var regex = new RegExp(searchInput, 'i');
				for (var i=0; i < friends.length; i++) {
					if (friends[i].friendName.search( regex ) != -1 ) {
						//reduced_friends.splice(i, 1);
						reduced_friends.push(friends[i]);
					}
				}
				openSearchStatusBar(reduced_friends);
				return false;
			});
			$('#loading-gif').hide();
			createFlipboards();//create the flipboards after everything on the map has been loaded
		});
	});
	
	$("#mapLegend2").bind('click', function() { 
		if($("#mapLegend2").hasClass('closed')) {
			$('#mapLegend2').removeClass('closed');
			$('#mapLegend2').animate({width: "145px"}, 200, 'fastToSlow', function() {})
				.delay(350)
				.animate({height: "145px"}, 300, 'slowToFast', function() {
					$('#mapLegend2 .label').css({'background-position': '0px -24px'});
					$('#mapLegend2').addClass('open');
					$('ul.legend').fadeIn();
			});
		} else if($("#mapLegend2").hasClass('open')) {
			$('#mapLegend2').removeClass('open'); 
			$('ul.legend').fadeOut('fast');
			$('#mapLegend2').animate({height: "24px"}, 300, 'slowToFast', function() {})
				.delay(350) 
				.animate({
					width: "91px"
				}, 80, 'slowToFast', function() {
					$('#mapLegend2 .label').css({'background-position': '0px 0px'});
					$('#mapLegend2').addClass('closed');
			});
		}
	}); 
	
	$("#friendSearch").focus(function(){
		$('#searchbar input#friendSearch').animate({
			width: "170px"
		}, 260, 'fastToSlow', function() {
			if ( $('input#friendSearch').val() == 'Search a friend')
				$('input#friendSearch').val('');
			//$('input#friendSearch').select();
		});
	});

});	

function openSearchPanel(){
	$('#friendlist').empty();
	
	if($('#panel').hasClass('closed')){
		$('#panel').removeClass('closed');
		$('#panel').addClass('open');
		
		$('#panelFriendList').css({display: 'block'});
		Cufon.replace($("h2.headline").text("Search Results"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		
		$('<div class="transOverlay" />').css({opacity: 0}).animate({
			opacity: 0.4
			}, 450, function() {
		}).appendTo("#mapCanvas");
		
		$('#panel').animate({
		height: "100px"
		}, 350, 'fastToSlow', function(){
			$('#openFolder').animate({
				backgroundPosition: '0px 0px'
			}, 100, 'swing', function(){});
		});
	}
	$('.transOverlay').bind('click', function(){
		closeStatusBar();
	});
}
