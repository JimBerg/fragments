/**
 * Googlemap für "on flight"
 * mit Routenpunkten
 */

$(document).ready(function() {
	/**
	 * Daten für Map holen
	 */

	$.getJSON(PAGE_URL+'dashboard/getFlightData', function(data) {
		/**
		 * Flugtyp, Startmarker & Endmarker
		 */
		//currentTime = Math.round((new Date().getTime())/1000);
		
		currentTime = data.currentTime;
		flight = {
			start: data.flightStart,
			end: data.flightEnd,
			duration: data.duration,
			type: data.flightType,
			friendId: data.friendId,
			friendName: data.friendName,
			userName: data.userName
		};
		
		startLocation = {
			name: data.startName,
			lat: data.startLat,
			lng: data.startLng
		};
		
		targetLocation = {
			id: data.targetId,
			name: data.targetName,
			lat: data.targetLat,
			lng: data.targetLng
		};

		/**
		 * Map laden => Initialwerte => danach "fitbounds"
		 */	
		startPoint = new google.maps.LatLng(startLocation.lat, startLocation.lng);
		endPoint = new google.maps.LatLng(targetLocation.lat, targetLocation.lng);
		
		var swissMapType = new google.maps.ImageMapType({ 
	     getTileUrl: function(coord, zoom) { 
	     return PAGE_URL_IMAGES+'/testmap/'+zoom + "/" + coord.x + "/" + (Math.pow(2,zoom)-coord.y-1) +".png"; 
	     }, 
	       tileSize: new google.maps.Size(256, 256),
	       isPng: true,
	         minZoom: 2,
	      	 maxZoom: 6,
	      	 name: 'SwissMap'
	     });
		
		var mapOptions = {
			zoom:  6,
		    center: new google.maps.LatLng(0, 0),
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
		    disableDefaultUI: true
		};

		map = new google.maps.Map(document.getElementById("onFlightMap"), mapOptions);
		map.mapTypes.set('swissMap', swissMapType);
		map.setMapTypeId('swissMap');
	
		var startMarker = new google.maps.Marker({
			position: startPoint
		});

		var endMarker = new google.maps.Marker({
			position: endPoint
		});

		// Zoom und Grenzen anpassen, so dass alles hübsch sichtbar ist
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(startPoint);
		bounds.extend(endPoint);
		map.fitBounds(bounds);
	
		
		/**
		 * Projection für Overlay erzeugen
		 */
		function pathProjection(map) {
			this.setMap(map); 
		};
		
		pathProjection.prototype = new google.maps.OverlayView();

		pathProjection.prototype.onAdd = function() {
		};

		pathProjection.prototype.draw = function() {
			proj = this.getProjection();
			startP = proj.fromLatLngToDivPixel(startPoint);
			endP = proj.fromLatLngToDivPixel(endPoint);
			drawFlightPath(proj, startP, endP);
		};
		
		pathProjection.prototype.onRemove = function() {
		};
		var overlayProjection = new pathProjection(map);
	
		flightStep = window.setInterval("nextRoutePoint()", 10500);
		

		/**
		 * check time & landing => redirect immediatly
		 */
		if(currentTime >= flight.end) {
			showStatusMessage();
			if(flightStep !== 'undefined'){
				window.clearInterval(flightStep);
			}
		}
		
		
	});
	
	$('#weatherButton').bind('click', function(){
		if($('#flightpanel').hasClass('closed') || ($('#infoButton').hasClass('active') && $('#flightpanel').hasClass('open'))){
			$('#weatherButton').css({'background-position': '0px -38px'});
			$('#weatherButton').addClass('active');
			getWeatherInfo(startLocation.name, targetLocation.name);
		} else {
			$('#weatherButton').removeClass('active');
			closeInfoBar();
		}
	});
	
	$('#weatherButton').bind('mouseover', function(){
		if(!$('#weatherButton').hasClass('active')){
			$('#weatherButton').animate({
				backgroundPosition: '0px -38px'
			}, 120, 'slowToFast', function(){});
		}
	});
	
	$('#weatherButton').bind('mouseout', function(){
		if(!$('#weatherButton').hasClass('active')){
			$('#weatherButton').animate({
				backgroundPosition: '0px 0px'
			}, 120, 'slowToFast', function(){});
		}
	});

	$('#infoButton').bind('mouseover', function(){
		if(!$('#infoButton').hasClass('active')){
			$('#infoButton').animate({
				backgroundPosition: '0px -38px'
			}, 120, 'slowToFast', function(){});
		}
	});
	
	$('#infoButton').bind('mouseout', function(){
		if(!$('#infoButton').hasClass('active')){
			$('#infoButton').animate({
				backgroundPosition: '0px 0px'
			}, 120, 'slowToFast', function(){});
		}
	});
	
	$('#infoButton').bind('click', function(){
		if($('#flightpanel').hasClass('closed')  || ($('#weatherButton').hasClass('active') && $('#flightpanel').hasClass('open'))){
			$('#infoButton').addClass('active');
			$('#infoButton').css({'background-position': '0px -38px'});
			getDestinationInfo(targetLocation.id);
		} else {
			$('#infoButton').removeClass('active');
			closeInfoBar();
		}
	});
	
	$('#routeButton').bind('mouseover', function(){
		if(!$('#routeButton').hasClass('active')){
			$('#routeButton').animate({
				backgroundPosition: '0px -38px'
			}, 120, 'slowToFast', function(){});
		}
	});
	
	$('#routeButton').bind('mouseout', function(){
		if(!$('#routeButton').hasClass('active')){
			$('#routeButton').animate({
				backgroundPosition: '0px 0px'
			}, 120, 'slowToFast', function(){});
		}
	});
	
	$('#routeButton').bind('click', function(){
		if($('#flightpanel').hasClass('open')){
			closeInfoBar();
		}
	});
	
	$('#moreInfo').bind('click', function(){
		moreInfo();
	});
	
	$('#morePictures').bind('click', function(){
		morePics();
	});
	
	$("#infoPicsContent").easySlider();

});





/**
 * timeFlown == Abgleich mit aktueller Zeit => wie lange ist man bereits geflogen
 * refreshInterval == Zeitintervall, mit der die Seite refreshed wird
 * currentInterval == auf welchem Abschnitt man sich befindet (ganzzahlig)
 * 
 * t(teil) = (t(ges) / s(ges)) * s(teil) == Dauer, die für einen Abschnitt gebraucht wird
 */
var timeFlown = null;
var refreshInterval = null;
var currentInterval = 0;

var sections = null; // alle 25px

var pathLength = null; //in px
var pathSection = null;

var routeMarks = new Array();
var routeShadow = new Array();

var pathOverlay;
var flightPath;
var random = Math.ceil(Math.random()*25)+25;


/**
 * Animation Overlay erzeugen
 */
function drawFlightPath(proj, pix1, pix2){
	pathOverlay = Raphael(document.getElementById("pathOverlay"), 740, 386);
	flightPath = pathOverlay.path("M"+pix1.x+" "+pix1.y+" Q"+((pix1.x+pix2.x)/2-random)+" "+((pix1.y+pix2.y)/2-random)+" "+(pix2.x)+" "+(pix2.y)+" ");
	flightPath.attr({stroke: 'none'});
	
	pathLength = flightPath.getTotalLength();
	sections = Math.round(pathLength/25);
	pathSection = Math.round(pathLength/sections);
	
	/*var plane = pathOverlay.path("M515,462.797c0,8.896,0,17.783,0,26.679c-63.625-21.672-126.306-44.298-189.695-66.196c2.48,70.686-1.871,138.281-12.849,197.101c18.7,14.902,41.836,25.361,60.272,40.509c0,6.097,0,12.186,0,18.282c-0.327,0-0.663,0-0.99,0c-21.936-7.051-45.07-12.885-67.184-19.764c-4.279,3.853-0.722,17.574-6.419,18.283c-6.334,0.79-3.726-13.667-6.915-18.283c-22.499,6.651-45.543,12.758-67.679,19.764c-0.331,0-0.658,0-0.99,0c0-6.097,0-12.186,0-18.282c18.537-14.884,40.972-25.879,60.268-40.009c-10.809-58.982-15.384-126.37-12.844-197.105c-62.662,20.495-126.192,44.394-189.695,65.701c0-8.896,0-17.782,0-26.679c2.513-9.141,12.385-13.185,20.254-17.782c25.366-14.83,96.824-55.411,105.715-62.245c-1.054-3.726-1.268-8.283-1.977-12.349c0.232-2.371-4.166-0.118-3.457-2.967c-1.481-11.326-2.312-25.615,0.495-36.061c8.41-0.909,18.01-1.577,25.688,0.495c1.604,10.918,1.177,25.029,0,36.061c-0.586,2.545-5.448,0.809-3.953,5.435c11.972-5.762,45.943-27.17,45.943-27.17s-1.095-80.636,0.986-104.729c1.89-21.858,8.242-45.193,16.302-63.23c2.412-5.398,7.051-15.175,11.858-14.821c4.443,0.327,8.536,10.118,10.867,15.316c8.578,19.1,14.357,40.205,16.302,63.23c2.917,34.575,0.99,104.729,0.99,104.729s44.09,27.015,45.943,26.179c1.018-3.331-2.854-2.885-3.953-5.434c-1.681-3.853-0.99-12.104-0.99-18.278c0-6.824-0.019-13.489,1.48-17.783c8.369-0.99,17.983-1.495,25.688,0.495c1.927,11.25,1.563,24.584,0,36.061c-5.579,1.5-3.753,10.409-5.434,15.807c31.067,17.506,64.353,37.91,96.329,56.315C494.982,445.614,512.338,452.302,515,462.797z");
	plane.attr({stroke: 'none', fill: 'red'});
	plane.scale(0.1);
	plane.animateAlong(flightPath, 9000, true);*/
	
	var startPoint = pathOverlay.image(PAGE_URL+'images/flightmap/location_white.png', pix1.x, pix1.y, 21, 21);
	var endPoint = pathOverlay.image(PAGE_URL+'images/flightmap/location_white.png', pix2.x, pix2.y, 21, 21);

	var deltaX = pix2.x - pix1.x;
	var deltaY = ((-1)*pix2.y) - ((-1)*pix1.y);

	// Start nördlich oder südlich => -1 wegen Koordinatensystem
	// Ursprungsbild => zeigt nach oben, Rotation = 0
	if(deltaY < 0){
		//Flug nach Süden Ost
		if(deltaX > 0){
			var direct = "southeast";
		} else {
			var direct = "southwest";
		}
	} else {
		// Flug nach Norden Ost
		if(deltaX > 0){
			var direct = "northeast";
		} else {
			var direct = "northwest";
		}
	}

	
	/**
	 * einzelne Wegpunkte zeichnen
	 */ 
	var routePoints = new Array();
	var routeDots = new Array();
	var m = new Array();
	var alpha = new Array();
	var currentInterval = getCurrentInterval();

	for(var i=0; i<sections; i++) {
		routePoints[i] = flightPath.getPointAtLength(i*pathSection);
		routeMarks[i] = pathOverlay.image(PAGE_URL+'images/layout/plane.png', routePoints[i].x, routePoints[i].y, 29, 29);
		routeShadow[i] = pathOverlay.image(PAGE_URL+'images/layout/plane_shadow.png', routePoints[i].x, routePoints[i].y, 38, 43);
		if(i > 0){
			routeDots[i] = pathOverlay.image(PAGE_URL+'images/flightmap/location_white.png', routePoints[i].x, routePoints[i].y, 12, 11);
			routeDots[i].toBack();
		}
		if(i != currentInterval){
			routeMarks[i].hide();
			routeShadow[i].hide();
		} else {
			routeMarks[i].show();
			routeShadow[i].show();
			$(routeMarks[i].node).bind('mouseover', createTooltip);
			$(routeMarks[i].node).bind('mouseout', removeTooltip);
		}
	}
	
	for(var i=1; i<sections; i++){
		m[i] = (routePoints[i].x - routePoints[i-1].x)/(routePoints[i].y - routePoints[i-1].y);
		alpha[i] = 180-(Math.atan(m[i])*(180/Math.PI));
		
		if(direct == "southwest" && alpha[i] < 180){
			alpha[i] = 180+alpha[i];
		}
		
		if(direct == "southeast" && alpha[i] > 270){
			alpha[i] = alpha[i]-180;
		}
		
		if(direct == "northwest" && alpha[i] < 180){
			alpha[i] = 180+alpha[i];
		}
		
		if(direct == "northeast" && (alpha[i] > 90)){
			alpha[i] = alpha[i]-180;
		}
		routeMarks[i].rotate(alpha[i]);
		routeShadow[i].rotate(alpha[i]);

		routeMarks[i].translate(-10, -10);	
		routeShadow[i].translate(-15, -10);
		routeMarks[i].toFront();
		routeShadow[i].toBack();

		//console.log(direct+" "+alpha[i]);
	}
	routeMarks[0].rotate(alpha[1]);
	routeShadow[0].rotate(alpha[1]);
	routeMarks[0].toFront();
	routeShadow[0].toBack();

	
	

	/**
	 * Friendreaction anzeigen, falls Freund angeflogen wird
	 */
	if((flight.type!="airportFlight") && (flight.type!="homebaseFlight")) {
		var tooltip = {w: 55, h: 65};
		var container = {w: 738, h: 388};

		var offset = {
			left:  pix2.x,
			top:  pix2.y
		};
		
		position = setTooltipPosition(offset.left, offset.top, tooltip, container);
		$('<div id="friendPicFlight" class="'+position+'"/>').css({top: pix2.y+'px', left: pix2.x+'px'}).html('<span class="profile" style="background: url(https://graph.facebook.com/'+flight.friendId+'/picture/) center center no-repeat" />').appendTo('#onFlightMap');

		var flightReaction = ["Hi "+flight.userName+". I don't know yet if I\'ll find the time to come to the airport to say hi..."];
		var icon = "location_icon_grey.png";
		$('#friendPicFlight').live('mouseover', function(){
			$.getJSON(PAGE_URL+'dashboard/friendReaction', function(data) {
				if(data.flightReaction == 'accepted'){
					flightReaction = "Hi "+flight.userName+". Great! I\'m already looking forward to meet you at the airport!";
					icon = "location_icon_green.png";
				} else if(data.flightReaction == 'denied'){
					flightReaction = "Hi "+flight.userName+". Unfortunately I don\'t have the time to come to the airport to say hi. Sorry!";
					icon = "location_icon_red.png";
				} else {
					flightReaction = "Hi "+flight.userName+". I don't know yet if I\'ll find the time to come to the airport to say hi...";
					icon = "location_icon_grey.png";
				}
			});
			$('<div id="tooltipReaction" class="'+position+'"/>').html("<p class='head'><strong>"+flight.friendName+"</strong><br/>"+targetLocation.name+"</p><hr /><p class='text'>"+flightReaction+"</p><div class='tooltipBottom' /><div class='statusIcon' style='background:url("+PAGE_URL+"images/layout/"+icon+")' />").appendTo('#friendPicFlight');
			$('#tooltipReaction').addClass(position);	
		});
		
		$('#friendPicFlight').live('mouseout', function(){
			$('#tooltipReaction').remove();
		});
	} else{
		var tooltip = {w: 35, h: 120};
		var container = {w: 740, h: 390};

		var offset = {
			left:  pix2.x,
			top:  pix2.y
		};
		position = setTooltipPosition(offset.left, offset.top, tooltip, container);
		$('<div id="friendPicFlight" class="'+position+'"/>').css({top: pix2.y+'px', left: pix2.x+'px'}).html('<span class="profile" style="background: url(../images/layout/swiss_logo_flight.png) -2px center no-repeat" />').appendTo('#onFlightMap');
	}
	createFlipboards();//create the flipboards after everything on the map has been loaded
	$('#loading-gif').hide();
}

/**
 * Berechnet aktuellen Streckenabschnitt
 */
function getCurrentInterval(){
	flightDuration = flight.duration;
	flightStart = flight.start;
	flightEnd = flight.end;
	
	timeFlown = Math.round((new Date().getTime())/1000); //aktueller timestamp => in unixformat
	/*$.getJSON(PAGE_URL+'dashboard/getServerTime', function(data) {
		timeFlown = data;
		refreshInterval = Math.round((flightDuration/pathLength)*pathSection); 
		return currentInterval = Math.floor((timeFlown-flightStart)/refreshInterval); // => auf welchem Streckenabschnitt wir uns befinden = welcher Punkt aktiv ist
	});*/
	refreshInterval = Math.round((flightDuration/pathLength)*pathSection); 
	return currentInterval = Math.floor((timeFlown-flightStart)/refreshInterval); // => auf welchem Streckenabschnitt wir uns befinden = welcher Punkt aktiv ist

}

/**
 * Markiert nächsten Routenpunkt aktiv
 * Weiterleitung zu Friendmap, wenn letztes Intervall
 */
function nextRoutePoint() {
	
	lastInterval = currentInterval;
	var currentInterval = getCurrentInterval();
	//console.log(currentInterval)
	//aktuelle Zeit und Zeit der Landung
	//currentTimeJS = Math.round((new Date().getTime())/1000); //nicht js seitig holen
	//console.log(currentTime+" "+currentTimeJS);
 	flightEnd = flight.end;

 	//wenn das letzte erreicht ist dann wieder zurück zur Friendmap // serverseitig
 	if(currentInterval >= sections) {
		$.getJSON(PAGE_URL+'dashboard/getServerTime', function(data) {
			var currentTime = data;
			if(currentTime >= flightEnd){
		 		showStatusMessage();
		 		window.clearInterval(flightStep);
			} else {
				//console.log("somethings wrong with your time...");
			}
		});	
 	}

	//wenn neues Interval => DB Request ob Freund die Einladung angenommen
 	if(lastInterval != currentInterval){
 		//routeMarks[0].hide();
		//routeShadow[0].hide();

 		if((currentInterval >= 1) && (currentInterval < sections)){
 			
 			routeMarks[currentInterval].show();
 			routeShadow[currentInterval].show();
 			
 			routeMarks[currentInterval-1].hide();
 			routeShadow[currentInterval-1].hide();
 			
 			$(routeMarks[currentInterval].node).bind('mouseover', createTooltip);
 			$(routeMarks[currentInterval].node).bind('mouseout', removeTooltip);
	 		//console.log(currentInterval-1+" "+currentInterval);
 		}
 	}
}

/**
 * Berechnet Zeit, die man bereits im Flugzeug ist
 * @todo mal schauen ob in wie wir das brauchen
 */
function getCurrentFlightTime() {
	currentTime = new Date(timeFlown).getTime(); //aktueller Zeitpunkt unix in sek
	flightTime = currentTime-flightStart; //vergangene Flugdauer seit Start
	
	return timeOnFlight = formattedTime(flightTime);
}

/**
 * Statusrückmeldung nach Landung
 * @todo: fbRequest an friend löschen
 */
function showStatusMessage(){
	
	if($('#flightpanel').hasClass('open')){
		closeInfoBar();
	}
	
	/**
	 * Anzeige Statusmeldung nach Landung
	 */
	$.getJSON(PAGE_URL+'dashboard/getStatusUpdate?landed=landed', function(data) {
		panelLanding = $('#panelLanding').css({display: 'block'});
		//console.log(data);
		stopFlipboardTimer = true;

		var reactionText;
		var headline;
		var reactionImage;
		
		var target = data.targetLocation.split(",",1);
		target = data.targetLocation.split(" ",1);
		var friend = data.friendId.split(" ",1);
		
		if(data.reaction == 'accepted') {
			reactionImage = PAGE_URL+'images/layout/image_arrived-01.png';

			headline = "You've just landed in "+target[0]+"! Now it's time for your reward.";
			reactionText = "<h5 class='subheadline'>"+friend[0]+" says: Welcome to "+target[0]+"!</h5>"+
						 "Your friend has come to say hi at the airport. Thanks to " +
						 "their appearance, you receive an extra "+data.flightPoints+" bonus miles.";
		} else if (data.friendId == 'Swiss Destination'){
			reactionImage = PAGE_URL+'images/layout/image_arrived-01.png';
			headline = "You've just landed in "+target[0]+"! Now it's time for your reward.";
			reactionText = "<h5 class='subheadline'>Welcome to your SWISS Destination</h5>"+
					 "You receive "+data.pointsReward+" points for this flight";
		} else {
			reactionImage = PAGE_URL+'images/layout/image_arrived-02.png';
			headline = "You've just landed in "+target[0]+"! Now it's time for your reward.";
			reactionText = "<h5 class='subheadline'>Welcome to "+target[0]+", but, er, hm... "+friend[0]+" is nowhere to be found!</h5>" +
					"Your friend is so sorry for not being able to come and meet you at the airport. Unfortunately you didn’t get any bonus miles.";
		}
		
		if(data.fan == false){
			$('<hr />').insertBefore('#becomeSwissFan');
			$('#becomeSwissFan').html("<p>If you're a fan of the SWISS Facebook page,<br/> you'll get more points for your future travels.</p>");
			$('<div class="fanButton"><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.facebook.com/flyswiss" show_faces="false" layout="button_count" width="100" height="120"></fb:like></div>').appendTo('#becomeSwissFan');
		}
		
		Cufon.replace($('h2.headline').text('You made it!'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		
		if (data.friendId == 'Swiss Destination'){
			$('#panelImageLanding').css({backgroundImage: 'url('+reactionImage+')'});
			Cufon.replace($('#landingReaction').text(headline), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			$('#landingText').html(reactionText);

			$('#panelLanding #selectedFriendPic').css({background: 'url('+PAGE_URL+'/images/layout/swiss_logo.gif) center center no-repeat'});
			
			Cufon.replace($('#panelLanding #flightTo').text(data.targetLocation+' ('+data.flightType+'):'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #flightToPoints').text("+"+data.flightPoints), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #welcomingYou').text("Bonus miles"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #welcomingYouPoints').text("not available"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #rewardMiles').text("+"+data.milesReward), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #rewardPoints').text("+"+data.pointsReward), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		} else {
			$('#panelImageLanding').css({backgroundImage: 'url('+reactionImage+')'});
			Cufon.replace($('#landingReaction').text(headline), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			$('#landingText').html(reactionText);

			$('#panelLanding #selectedFriendPic').css({background: 'url(https://graph.facebook.com/'+data.fbId+'/picture/) center center no-repeat'});
			
			Cufon.replace($('#panelLanding #flightTo').text(data.targetLocation+' ('+data.flightType+'):'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #flightToPoints').text("+"+data.flightPoints), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #welcomingYou').text(data.friendId+" welcoming you:"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #welcomingYouPoints').text("+"+data.bonus), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #rewardMiles').text("+"+data.milesReward), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			Cufon.replace($('#panelLanding #rewardPoints').text("+"+data.pointsReward), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		}
		
		$('<a href="#" onclick="landing()" class="button_left"/>').html('<span class="button_right"><span class="buttonLabel">Next</span></span>').appendTo('.flightButtons');
	
		$('<div class="transOverlay2" />').animate({
			opacity: 0.4
			}, 250, function() {
				$('#flightpanel').css({display:'none'});
		}).appendTo("#onFlightMap");
		
		panelLanding.animate({
			height: "328px"
			}, 350, 'fastToSlow', function() {
				$('#panelLanding .panelContent').fadeIn();
		});
	});
}

/**
 * Weiterleitung zu Friendmap nach Landung
 */
function landing(){
	document.location.href = PAGE_URL+"/dashboard";
}

function getWeatherInfo(startLocation, targetLocation){
	$('#routeButton').removeClass('active');
	$('#routeButton').css({'background-position': '0px 0px'});
	
	if($('#flightpanel').hasClass('closed')){

		//var startLoc = startLocation.replace(',',' ');
		//startLoc = startLocation.split(' ', 1);
		//var targetLoc = targetLocation.replace(',',' ');
		//targetLoc = targetLocation.split(' ', 1);
		
		var startLoc = startLocation.split(',',1);
		var targetLoc = targetLocation.split(',',1);
		
		
		//Cufon.replace($('#startLocationWeather').text(startLoc[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		//Cufon.replace($('#targetLocationWeather').text(targetLoc[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});

		$('<div class="transOverlay" />').css({opacity: 0}).animate({
			opacity: 0.4
			}, 450, function() {
		}).appendTo("#onFlightMap");
		
		$('#flightpanel').animate({
			height: "185px"
			}, 350, 'fastToSlow', function(){
		    $('#flightpanel').removeClass('closed');
		    $('#flightpanel').addClass('open');
		   
		    $('#weatherPanel').fadeIn('slow');
			 Cufon.replace($('#infobarHead').text('Weather Channel'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
			  
		    weatherStart = $.getJSON(PAGE_URL+'dashboard/getWeatherInfo', {'locationName': startLoc[0]}, function(data) {
		    	var humidity = data.humidity[0];
		    	humidity = humidity.split(' ', 2);
		  
				$('#weatherIcon.start').css({'backgroundImage': 'url('+PAGE_URL+'images/weather/'+data.icon+'.gif)'});
				Cufon.replace($('#weatherConditions.start').text(data.conditions[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				Cufon.replace($('#weatherTemperature.start').text(data.temperature[0]+"°C"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				Cufon.replace($('#weatherHumidity.start').text(humidity[1]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			});
		    weatherTarget = $.getJSON(PAGE_URL+'dashboard/getWeatherInfo', {'locationName': targetLoc[0]}, function(data) {
		    	var humidity = data.humidity[0];
		    	humidity = humidity.split(' ', 2);
				
				$('#weatherIcon.target').css({'backgroundImage': 'url('+PAGE_URL+'images/weather/'+data.icon+'.gif)'});
				Cufon.replace($('#weatherConditions.target').text(data.conditions[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				Cufon.replace($('#weatherTemperature.target').text(data.temperature[0]+"°C"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				Cufon.replace($('#weatherHumidity.target').text(humidity[1]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
			});
		});
	}
	
	if($('#infoButton').hasClass('active') && $('#flightpanel').hasClass('open')){
		$('#infoPanel').fadeOut('slow', function(){ 
			$('#infoButton').removeClass('active');
			$('#infoButton').css({'background-position': '0px 0px'});
		    $('#weatherButton').addClass('active');
		    	
		    $('#flightpanel').animate({
				height: "185px"
				}, 200, 'fastToSlow', function(){
					$('#weatherPanel').fadeIn('slow');
					 
			    Cufon.replace($('#infobarHead').text('Weather Channel'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
					    
			    weatherStart = $.getJSON(PAGE_URL+'dashboard/getWeatherInfo?locationName='+startLocation, function(data) {
			    	var humidity = data.humidity[0];
			    	humidity = humidity.split(' ', 2);
			    	
			    	$('#weatherIcon.start').css({'backgroundImage': 'url('+PAGE_URL+'images/weather/'+data.icon+'.gif)'});
					Cufon.replace($('#weatherConditions.start').text(data.conditions[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
					Cufon.replace($('#weatherTemperature.start').text(data.temperature[0]+"°C"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
					Cufon.replace($('#weatherHumidity.start').text(humidity[1]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				});
			    
			    weatherTarget = $.getJSON(PAGE_URL+'dashboard/getWeatherInfo?locationName='+targetLocation, function(data) {
			    	var humidity = data.humidity[0];
			    	humidity = humidity.split(' ', 2);
			    	
			    	$('#weatherIcon.target').css({'backgroundImage': 'url('+PAGE_URL+'images/weather/'+data.icon+'.gif)'});
					Cufon.replace($('#weatherConditions.target').text(data.conditions[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
					Cufon.replace($('#weatherTemperature.target').text(data.temperature[0]+"°C"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
					Cufon.replace($('#weatherHumidity.target').text(humidity[1]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				});   
			});
		});
	}
	
	$('.transOverlay').bind('click', function(){
		closeInfoBar();
	});
}


function getDestinationInfo(targetLocation){

	$('#routeButton').removeClass('active');
	$('#routeButton').css({'background-position': '0px 0px'});
	
	if($('#flightpanel').hasClass('closed')){
		$('<div class="transOverlay" />').css({opacity: 0}).animate({
			opacity: 0.4
			}, 450, function() {
		}).appendTo("#onFlightMap");
		
		$('#flightpanel').animate({
			height: "280px"
			}, 350, 'fastToSlow', function(){
		    $('#flightpanel').removeClass('closed');
		    $('#flightpanel').addClass('open');
		    $('#infoPanel').fadeIn('slow');
		    Cufon.replace($('#infobarHead').text('SWISS Tourist Info'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		});
	} 
	
	if($('#weatherButton').hasClass('active') && $('#flightpanel').hasClass('open')){
		$('#flightpanel').animate({
			height: "280px"
			}, 200, 'fastToSlow', function(){
			$('#weatherButton').removeClass('active');
			$('#weatherButton').css({'background-position': '0px 0px'});
		    $('#infoButton').addClass('active');
		    $('#weatherPanel').fadeOut('slow', function(){
		    	$('#infoPanel').fadeIn('slow');
		    });
		    Cufon.replace($('#infobarHead').text('SWISS Tourist Info'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		}); 
	}
	
	$('.transOverlay').bind('click', function(){
		closeInfoBar();
	});
}

function closeInfoBar(){
	$('#weatherPanel').fadeOut('fast');
	$('#infoPanel').fadeOut('fast');
	$('#routeButton').addClass('active');
	$('#routeButton').css({'background-position': '0px -38px'});
	
	$('#infoButton').removeClass('active');
	$('#weatherButton').removeClass('active');
	$('#infoButton').css({'background-position': '0px 0px'});
	$('#weatherButton').css({'background-position': '0px 0px'});
	
	$('#flightpanel').animate({
		height: '38px'
		  }, 350, 'slowToFast', function(){
		  $('.transOverlay').animate({
				opacity: 0
			  }, 350, function() { 
				  $('.transOverlay').remove();
		  });
		  $('#flightpanel').removeClass('open');
		  $('#flightpanel').addClass('closed');
		  Cufon.replace($('#infobarHead').text('Welcome aboard'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
	});
}

function getPathFlown(currentSect){
	p =  [startPoint, endPoint];
	d = calculateDistance(p);
	
	pathFlown = (d/sections)*currentSect;
	return (pathFlown).toFixed(2);
}

function moreInfo(){
	if($('.infoPanelContent').hasClass('closed')){
		$('.infoPanelContent').animate({
			left:'-360px'
		},260, 'fastToSlow', function() {
			$('.infoPanelContent').addClass('open');
			$('.infoPanelContent').removeClass('closed');
		});

		$('#infoText').animate({
			marginLeft:'180px'
		},260, 'fastToSlow', function() {
			$('#moreInfo').css({backgroundPosition: '0px -90px'});
		});
		
		$('#infoPics').animate({
			//marginLeft: '360px'
			marginLeft: '0px'
		},510, 'fastToSlow', function() {
			$('#infoText').addClass('active');
			$('#moreInfo').css({backgroundPosition: '0px -90px'});
			$('#morePictures').css({backgroundPosition: '0px -30px'});
			//Cufon.replace($('#moreInfo').text('back'), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
		});
		
	} else {
		if($('#infoPics').hasClass('active')){
			$('#infoPics').animate({
				//marginLeft: '360px'
				marginLeft: '0px'
			},260, 'fastToSlow', function() {
				$('#infoPics').removeClass('active');
				$('#infoText').addClass('active');	
			});
			$('#infoText').animate({
				marginLeft:'180px'
			},260, 'fastToSlow', function() {
				$('#moreInfo').css({backgroundPosition: '0px -90px'});
				$('#morePictures').css({backgroundPosition: '0px -30px'});
			});
		} else {
			
			$('#infoText').animate({
				marginLeft: '500px'
			},260, 'fastToSlow', function(){
				$('#moreInfo').css({backgroundPosition: '0px 0px'});
				$('#morePictures').css({backgroundPosition: '0px -30px'});
			});
			
			$('.infoPanelContent').animate({
				 left:'0px'
			},260, 'fastToSlow', function() {
				$('.infoPanelContent').removeClass('open');
				$('.infoPanelContent').addClass('closed');
			});

			$('#infoPics').animate({
				marginLeft: '0px'
			},130, 'fastToSlow', function() {
				$('#infoText').removeClass('active');
				$('#moreInfo').css({backgroundPosition: '0px 0px'});
				$('#morePictures').css({backgroundPosition: '0px -30px'});
			});
		}
	}
}

function morePics(){
	if($('.infoPanelContent').hasClass('closed')){
		$('.infoPanelContent').animate({
			left:'-360px'
		},260, 'fastToSlow', function() {
			$('.infoPanelContent').addClass('open');
			$('.infoPanelContent').removeClass('closed');
		});

		$('#infoPics').animate({
			marginLeft: '-360px'
		},260, 'fastToSlow', function() {
			$('#infoPics').addClass('active');
			$('#moreInfo').css({backgroundPosition: '0px 0px'});
			$('#morePictures').css({backgroundPosition: '0px -90px'});
		});
	} else {
		if($('#infoText').hasClass('active')){
			$('#infoPics').animate({
				marginLeft: '-360px'
			},260, 'fastToSlow', function() {
				$('#infoText').removeClass('active');
				$('#infoPics').addClass('active');
			});
			$('#infoText').animate({
				marginLeft: '500px'
			},260, 'fastToSlow', function(){
				$('#moreInfo').css({backgroundPosition: '0px 0px'});
				$('#morePictures').css({backgroundPosition: '0px -90px'});
			});
		} else {
			$('.infoPanelContent').animate({
				left:'0px'
			},260, 'fastToSlow', function() {
				$('.infoPanelContent').removeClass('open');
				$('.infoPanelContent').addClass('closed');
			});
			
			$('#infoPics').animate({
				marginLeft: '0px'
			},260, 'fastToSlow', function() {
				$('#infoPics').removeClass('active');
				$('#moreInfo').css({backgroundPosition: '0px 0px'});
				$('#morePictures').css({backgroundPosition: '0px -30px'});
			});
		}
	}
}

function createTooltip(){
	currentInterval = getCurrentInterval();
	var point = this;
	
	var tooltip = {w: 166, h: 67};
	var container = {w: 740, h: 390};
	
	var offset = {
		left: Math.round(point.x.baseVal.value),
		top: Math.round(point.y.baseVal.value)
	}

	var position = setTooltipPosition(offset.left, offset.top, tooltip, container);	
	var locationName = ['no data available'];
	
	convertLatLng = proj.fromDivPixelToLatLng(new google.maps.Point(offset.left, offset.top));
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'latLng': convertLatLng}, function(results, status) {
    	if (status == google.maps.GeocoderStatus.OK) {
        	if (results[0]) {
    			for (var i=0; i< results[0].address_components.length; i++){
		    	   if(results[0].address_components[i].types[0] == 'locality') {
		    		   locationName = results[0].address_components[i].long_name;
		    	   }
    		    }
        		//locationName = results[0].formatted_address;
        	} else {
        		locationName = 'no data available';
        	}
    	} else {
    		locationName = 'no data available';
    	}
	$('#tooltipCluster').remove();
	var top = offset.top-2;
	var left = offset.left + 15;
	airportDiv = $('<div id="tooltipCluster" style="top:'+top+'px; left:'+left+'px"/>').html("<p class='airportName'>"+locationName+"</p><hr/><p class='miles'>miles flown: "+getPathFlown(currentInterval)+"</p><div class='tooltipBottom' />");
	airportDiv.addClass(position).appendTo('#onFlightMap');
	});
	
	$(this.node).bind('mouseout', function(){
		if($(airportDiv)!== 'undefined'){
			airportDiv.remove();
		}
	});

	return false;
}

function removeTooltip(){
	if($(airportDiv)!== 'undefined' && $(airportDiv)!== null){
		airportDiv.remove();
	}
}
