$(document).ready(function() {

	var current_week = $('.activeRanking').text();

	initHistoryMap(current_week);
});

function displayNoHistoryWarning(parent){
	//$( "#noHistoryTemplate" ).tmpl( null ).appendTo( $('.activeRanking') );
	//Cufon.replace($( '.noHistoryMessage' ), {fontFamily: 'CHSans_Medium'});
	$( "#noHistoryTemplate" ).tmpl( null ).appendTo( $('#mapContainer') );
	$('#currentFlight').text('no data');
	
	$('#controlsPrevFlight').die();
	$('#controlsNextFlight').die();
	
	if ($('#loading-gif:visible')) {
		$('#loading-gif').hide();
		createFlipboards();
	}
}
//use this only when we load the page for the first time - if we have no other map loaded and current week has no data
function initOnlyMap(homebase){

	if (window.paper!=undefined)
		paper.clear();
	$("#flightOverlay").html('');

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
		zoom:  3,
		center: new google.maps.LatLng(homebase.lat, homebase.lng),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true
	};

	map = new google.maps.Map(document.getElementById("historyMap"), mapOptions);
	map.mapTypes.set('swissMap', swissMapType);
	map.setMapTypeId('swissMap');

	var homeBaseImage = PAGE_URL_IMAGES+'/layout_map_icons/cluster_hb_red.png';
	
	var currentLocation = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(homebase.lat, homebase.lng),
			icon: homeBaseImage,
			visible: true
		});
}
function initHistoryMap(week){
$('.weeks').removeClass('activeRanking');
$('#week_'+week).addClass('activeRanking');
//Cufon.replace($('#infobarHead').text('Week '+week), { fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a' });
Cufon.replace($('#infobarHead').text('Flight Route'), { fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a' });
$('#loading-gif').show();


$.getJSON(PAGE_URL+'getflighthistory/'+week, function(data) {
	var homebase = data.homebase;
	var markers = data.flights;
	var airports = data.airports;

	$( '.noHistoryMessage' ).remove();
	if (markers.length < 2){
		displayNoHistoryWarning( $("#flightOverlay") );
		initOnlyMap(homebase);

		return;
	}
	
	if (window.paper!=undefined)
		paper.clear();
	$("#flightOverlay").html('');


	
	overlayWidth = 760;
	overlayHeight = 388;
	paper = Raphael(document.getElementById("flightOverlay"), overlayWidth, overlayHeight);
	var flightOverlay = paper;

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
		zoom:  8,
		center: new google.maps.LatLng(0, 0),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true
	};

	map = new google.maps.Map(document.getElementById("historyMap"), mapOptions);
	map.mapTypes.set('swissMap', swissMapType);
	map.setMapTypeId('swissMap');

	var bounds = new google.maps.LatLngBounds();

	

	$(markers).each(function(k, element) {
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(element.lat, element.lng),
			destinationId: element.destinationId,
			flightNum: element.flightNum,
			date: element.date,
			user: element.user,
			lat: element.lat,
			lng: element.lng,
			friendName: element.friendName,
			friendStatus: element.friendStatus
		});
		bounds.extend(marker.position);
});
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

	var listenerHandle = null;
	pathProjection.prototype.draw = function() {
	flightOverlay.clear();

		var proj = this.getProjection();
		var markerProj = [];

		$(markers).each(function(k, element) {
			var markerPosition = new google.maps.LatLng(element.lat, element.lng);
			var markerProject = {
				markerProjection: proj.fromLatLngToContainerPixel(markerPosition),
				destinationId: element.destinationId,
				flightNum: element.flightNum,
				date: element.date,
				user: element.user,
				lat: element.lat,
				lng: element.lng,
				friendName: element.friendName,
				friendStatus: element.friendStatus,
				fbId: element.fbId
			}
			markerProj.push(markerProject);
		});
		if (listenerHandle != undefined )
			google.maps.event.removeListener(listenerHandle);
		listenerHandle = google.maps.event.addListener(map, 'idle', function() {
			drawFlightHistory(flightOverlay, proj, markerProj, airports);
		});
	};

	var overlayProjection = new pathProjection(map);
	centerViewOnCurrentFlight(map, markers, 0);
	currentFlightIndex=0;
	var nextFlight = currentFlightIndex+1;
	//$('#currentFlightNumber').text( currentFlightIndex+1 );
	$('#currentFlight').text( "Flight No. "+nextFlight);
	

	$('#controlsPrevFlight').die();
	$('#controlsPrevFlight').live('click', function() {
		if ( currentFlightIndex-1 < 0 ) return;
		
		currentFlightIndex=currentFlightIndex-1;
		var nextFlight = currentFlightIndex+1;
		//$('#currentFlightNumber').text( currentFlightIndex+1 );
		$('#currentFlight').text( "Flight No. "+nextFlight);
		centerViewOnCurrentFlight(map, markers, currentFlightIndex);
	});

	$('#controlsNextFlight').die();
	$('#controlsNextFlight').live('click', function() {
		if ( currentFlightIndex+1 >= markers.length-1 ) return;
		currentFlightIndex=currentFlightIndex+1;
		var nextFlight = currentFlightIndex+1;
		//$('#currentFlightNumber').text( currentFlightIndex+1 );
		$('#currentFlight').text( "Flight No. "+nextFlight);
		centerViewOnCurrentFlight(map, markers, currentFlightIndex);
	});

	pathProjection.prototype.onRemove = function() {
	};
});
return false;
}

function drawFlightHistory(flightOverlay, proj, markerProj, airports) {

	routeMarks = new Array();
	var radius = 3;
	var flightPathCoords = null;
	//startPoint = "M "+Math.round(markerProj[0].markerProjection.x)+" "+Math.round(markerProj[0].markerProjection.y)+"";
	var random = Math.ceil(Math.random()*25)+25;
	var planePath = new Array();
	var points=new Array();
	var calculation=0;
	for(var i=0; i<markerProj.length; i++){
		if (i!=0)
		{
		var pix1 = markerProj[i-1].markerProjection;
		var pix2 = markerProj[i].markerProjection;

		var startVisible = false;
		var endVisible = false;

		if ( (pix1.x > 0 && pix1.x < overlayWidth && pix1.y > 0 && pix1.y < overlayHeight) )
			startVisible = true;
		if ( (pix2.x > 0 && pix2.x < overlayWidth && pix2.y > 0 && pix2.y < overlayHeight) )
			endVisible = true;

		var drawPoint = "M"+Math.round(pix1.x)+" "+Math.round(pix1.y)+" ";
		drawPoint += "L"+((pix2.x))+" "+
				((pix2.y));
//		drawPoint = "M "+Math.round(pix1.x)+" "+Math.round(pix1.y)+"";
//		drawPoint +=	"Q "+((pix1.x+pix2.x)/2-random)+" "+
//				((pix1.y+pix2.y)/2-random) +" "+
//				Math.round(pix2.x)+" "+
//				Math.round(pix2.y)+"";

		var destinationImageUrl = PAGE_URL+'images/flightmap/location_white.png';
		if (currentFlightIndex+1 == i)
			destinationImageUrl = PAGE_URL+'images/flightmap/location_red.png'

		
		planePath[i] = new Array();
		//planePath[i]['path'] = flightOverlay.path(drawPoint).attr({stroke: '#cc0000', 'stroke-dasharray': '. ', 'stroke-width': '6', 'stroke-linecap': 'round'});
		planePath[i]['start'] = pix1;
		planePath[i]['end'] = pix2;


		var pathLength = Math.sqrt( Math.pow((pix1.x - pix2.x), 2) + Math.pow((pix1.y - pix2.y), 2)) //planePath[i]['path'].getTotalLength();
		var sections = Math.round(pathLength/25);
		var x_step = (pix2.x - pix1.x) / sections;
		var y_step = (pix2.y - pix1.y) / sections;

		//if (sections > 10) sections = 10;
		var pathSection = Math.round(pathLength/sections);

		var routePoints = new Array();

		var pointImagePath = PAGE_URL+'images/flightmap/location_white_sml.png';
		if (currentFlightIndex+1 == i)
			pointImagePath = PAGE_URL+'images/flightmap/location_red_sml.png'
			
		var pointNotVisible = false;
		if (startVisible)
		for(var j=1; j<sections; j++) {
//			var startTime = new Date().getTime();
			routePoints[j] = new Array();
			routePoints[j].x = planePath[i]['start'].x + j * x_step;
			routePoints[j].y = planePath[i]['start'].y + j * y_step;
			//routePoints[j] = planePath[i].getPointAtLength(j*pathSection);
//			var endTime = new Date().getTime();
//			var result = endTime-startTime;
//			calculation +=(result);
			
			//if the point is inside the screen draw it
			if ( (routePoints[j].x > 0 && routePoints[j].x < overlayWidth && routePoints[j].y > 0 && routePoints[j].y < overlayHeight) )
				{
				flightOverlay.image( pointImagePath, routePoints[j].x -6, routePoints[j].y -5, 12, 11);
			}
			else //point not visible
				{
					//we will try to draw it from the other side later
					pointNotVisible=true;
					break;
				}
		}
		else pointNotVisible=true;

		//we started at the start of the path and if we found a not visible point, try from the other end
		//of the path
		if (endVisible && pointNotVisible){

			routePoints = new Array();
			for(j=sections; j>0; j--) {
//				var startTime = new Date().getTime();
				routePoints[j] = new Array();
				routePoints[j].x = planePath[i]['start'].x + j * x_step;
				routePoints[j].y = planePath[i]['start'].y + j * y_step;

				//routePoints[j] = planePath[i].getPointAtLength(j*pathSection);
//				var endTime = new Date().getTime();
//				var result = endTime-startTime;
//				calculation +=(result);

				//if the point is inside the screen draw it
				if ( (routePoints[j].x > 0 && routePoints[j].x < overlayWidth && routePoints[j].y > 0 && routePoints[j].y < overlayHeight) )
					{
					points.push(flightOverlay.image(PAGE_URL+'images/flightmap/location_white_sml.png', routePoints[j].x -6, routePoints[j].y -5, 12, 11));
					}
				else //point not visible
					break;
			}
		}
		//draw the start and end point over any of the other points
		if (i==1 || (currentFlightIndex+1 == i))
			var startPoint = flightOverlay.image(destinationImageUrl, pix1.x-10, pix1.y-10, 21, 21);

		var endPoint = flightOverlay.image(destinationImageUrl, pix2.x-10, pix2.y-10, 21, 21);

		}
		var friendsCount = 1;
		var destinationName = '';
		var friends = [{'fb_id': 0, 'friend_name': 'Swiss staff'}];
		var swissDestination=false;
		var flightNumbers = [];
		var homebase = false;
		var airportName = 'City Airport';

		if ( airports[markerProj[i].destinationId]!=undefined ) {
			if ( airports[markerProj[i].destinationId].friends != undefined ) {
					friendsCount = airports[markerProj[i].destinationId].friends.length;
					if (friendsCount<1) friendsCount = 1;
					friends = airports[markerProj[i].destinationId].friends;
			}
			if ( airports[markerProj[i].destinationId].location_name != undefined )
				destinationName = airports[markerProj[i].destinationId].location_name;

			if ( airports[markerProj[i].destinationId].airport_name != undefined )
				airportName = airports[markerProj[i].destinationId].airport_name;
			if (!airportName) airportName = 'City Airport';
			if ( airports[markerProj[i].destinationId].swiss_destination != undefined )
				if (airports[markerProj[i].destinationId].swiss_destination)
					swissDestination = true;
				else
					swissDestination = false;
			if ( airports[markerProj[i].destinationId].flightNumbers != undefined &&
			airports[markerProj[i].destinationId].flightNumbers.length ) {
				flightNumbers = airports[markerProj[i].destinationId].flightNumbers;
			}
			if ( airports[markerProj[i].destinationId].homebase != undefined )
				if (airports[markerProj[i].destinationId].homebase)
					homebase = true;
				else
					homebase = false;
		}

		//airports[ markerProj[i].destinationId ]
		routeMarks[i] = {
				destinationId: markerProj[i].destinationId,
				destinationName: destinationName,
				swissDestination: swissDestination,
				homebase: homebase,
				airportName: airportName,
				friends: friends,
				flightNumbers: flightNumbers,
				flightNum: markerProj[i].flightNum,
				date: markerProj[i].date,
				user: markerProj[i].user,
				lat: markerProj[i].lat,
				lng: markerProj[i].lng,
				x: markerProj[i].markerProjection.x,
				y: markerProj[i].markerProjection.y,
				friendName: markerProj[i].friendName,
				friendStatus: markerProj[i].friendStatus,
				friendsCount: friendsCount
		};

	}



	var imageUrl= PAGE_URL_IMAGES+'/layout/cluster_red.png';
	var imageWidth = 25;
	var imageHeight = 34;
	
	$.each(routeMarks, function(index, value) {
		//console.log(routeMarks);
		routeMarks[index].marks = flightOverlay.image(imageUrl,
			value.x - imageWidth/2 +5,
			value.y - imageHeight,
			imageWidth,
			imageHeight);

		routeMarks[index].text = flightOverlay.text(value.x +5,
			value.y - 21,
			value.friendsCount)
			.attr({'font-size': '17px',
				'font-weight': 'bold',
				'fill': '#fff'});

		if(index >= 0) {
			$(this.marks.node).bind('mouseover', function(){
				routeMarksMouseOver(flightOverlay, routeMarks[index]);
			});
			$(this.text.node).bind('mouseover', function(){
				routeMarksMouseOver(flightOverlay, routeMarks[index]);
			});
			$(this.marks.node).bind('mouseout', function(){
				routeMarksMouseOut(flightOverlay, routeMarks[index]);
			});
			$(this.text.node).bind('mouseout', function(){
				routeMarksMouseOut(flightOverlay, routeMarks[index]);
			});

		}
	});


        var plane = new Plane(flightOverlay, markerProj[currentFlightIndex], markerProj[currentFlightIndex+1]);

	$('#loading-gif').hide();
	createFlipboards();//create the flipboards after everything on the map has been loaded
}

function routeMarksMouseOver(flightOverlay, element) {
//	if ($('#flightTooltip' + element.flightNum) != undefined )
//		{
//			$('#flightTooltip' + element.flightNum).show();
//		}
	$('.flightTooltip').remove();

	var container = flightOverlay.rect( element.x, element.y, 1, 1 )

	$( "#tooltipTemplate" ).tmpl( element ).appendTo( "#flightOverlay" );
	Cufon.replace($( '.airportName' ), {fontFamily: 'CHSans_Medium'});
	Cufon.replace($( '.airportCity' ), {fontFamily: 'CHSans_Regular'});
	Cufon.replace($( '.flightNumbers .tooltipLabel, .friends .tooltipLabel, .swissDestinationLabel, .homebaseDestinationLabel, .flightNumber' ), {fontFamily: 'CHSans_Light'});

//	if ($('.homebaseDestinationLabel') && !$('.swissDestinationLabel')) {
//		.flightTooltip
//	}

	var offset = $(container.node).offset();
	offset.left += 15;
	var tooltipWidth =  233;
	if (offset.left + tooltipWidth > overlayWidth)
	{
		//swap the left and right tooltip borders because we are displaying it from the left
		offset.left -= (tooltipWidth + 20);
		var leftBorderWidth = $('.flightTooltipLeftBorder').css('width');
		var rightBorderWidth = $('.flightTooltipRightBorder').css('width');
		$('.flightTooltipLeftBorder').css('background-image', "url('../images/flighthistory/tooltip_right_border_mirrored.png')");
		$('.flightTooltipLeftBorder').css('width', rightBorderWidth);
		$('.flightTooltipRightBorder').css('background-image', "url('../images/flighthistory/tooltip_left_border_mirrored.png')");
		$('.flightTooltipRightBorder').css('width', leftBorderWidth);

		$('.flightTooltipContent').css('margin-left', rightBorderWidth);
		$('.flightTooltipContent').css('margin-right', leftBorderWidth);
	}
	offset.top -= 75;
	$('.flightTooltip' + element.flightNum).offset( offset );
	container.remove();

}
function routeMarksMouseOut(element) {
	$('.flightTooltip').remove();
}
function centerViewOnCurrentFlight(map, markers, currentMarkerIndex)
{
	
        //zoom and center the current trip
        //if (currentMarkerIndex >= markers.length-1) return;

        var currentMarker = markers[ currentMarkerIndex ];
        var nextMarker = markers[ currentMarkerIndex + 1 ];

        currentMarker.position = new google.maps.LatLng(currentMarker.lat, currentMarker.lng);

        nextMarker.position = new google.maps.LatLng(nextMarker.lat, nextMarker.lng);


        var bounds = new google.maps.LatLngBounds().extend(currentMarker.position).extend(nextMarker.position);
        map.setZoom(16);
        
        map.fitBounds( bounds );
	//map.setZoom(map.getZoom() - 1);
        //map.panToBounds( bounds );



        //animate the plane moving (blipping lights)
        //plane.start();
        //show the friend welcoming them
        //show how many points (miles they got)

}
function Plane(paper, currentMarker, nextMarker)//, nextMarker)
{
    var startX = Math.round(currentMarker.markerProjection.x);
    var startY = Math.round(currentMarker.markerProjection.y);

    var endX = Math.round(nextMarker.markerProjection.x);
    var endY = Math.round(nextMarker.markerProjection.y);

    var currentLocationImage = PAGE_URL_IMAGES+'/layout/cluster_red.png';

    var image_width = 25;
    var image_height = 35;
    var planeImg = paper.image(currentLocationImage, startX - image_width/2 +5, startY-image_height, image_width, image_height);
    //planeImg.animateAlong(path, 2000, false);

    planeImg.animate({x: endX-image_width/2+5, y: endY-image_height}, 2000, function(){
		$(planeImg.node).bind('mouseover', function(){
				routeMarksMouseOver(paper, routeMarks[currentFlightIndex+1]);
		});
		$(planeImg.node).bind('mouseout', function(){
				routeMarksMouseOut(paper, routeMarks[currentFlightIndex+1]);
		});
    });
    
    

    var userImageWidth = 21;
    var userImageHeight = 21;
    var userProfileImage = 'http://graph.facebook.com/' + currentMarker.fbId + '/picture';
    var planeUserImg = paper.image(userProfileImage, startX - userImageWidth/2+5, startY - userImageHeight - 12, userImageWidth, userImageHeight);
    //planeUserImg.animateAlong(path, 2000, false);
    planeUserImg.animate({x: endX-userImageWidth/2+5, y: endY-userImageHeight-12}, 2000, function(){
		$(planeUserImg.node).bind('mouseover', function(){
				routeMarksMouseOver(paper, routeMarks[currentFlightIndex+1]);
		});
		$(planeUserImg.node).bind('mouseout', function(){
				routeMarksMouseOut(paper, routeMarks[currentFlightIndex+1]);
		});
    });

    planeImg.attr({opacity: 1});

    planeUserImg.attr({opacity: 1});


    //show miles towards the end of the plane animation
//    var timerId = setInterval(function(){
//            var sign = new MilesSign(paper, currentMarker, nextMarker);
//            clearInterval(timerId);
//            }, 1500);

}

function MilesSign(paper, currentMarker, nextMarker)
{
    var startX = currentMarker.markerProjection.x;
    var startY = currentMarker.markerProjection.y;

    var endX = nextMarker.markerProjection.x;
    var endY = nextMarker.markerProjection.y;

    currentMarker.position = new google.maps.LatLng(currentMarker.lat, currentMarker.lng);

    nextMarker.position = new google.maps.LatLng(nextMarker.lat, nextMarker.lng);

    var distance = calculateDistance([currentMarker.position, nextMarker.position]);

    var textForBox = paper.text( endX+50, endY+20, distance+" miles traveled");
    textForBox.attr({'font-size': "18px"});
    textForBox.attr({'font-weight': "bold"});

    var bBox = textForBox.getBBox();

    textForBox.remove();

    var milesBox = paper.rect(bBox.x-5, bBox.y-5, bBox.width+10, bBox.height+10);
    milesBox.attr({stroke:"#000"});
    milesBox.attr({fill: "#fff"});
    milesBox.attr({opacity: 0});
    milesBox.animate({opacity: 1}, 500);


    var text = paper.text( endX+50, endY+20, distance+" miles traveled");
    text.attr({'font-size': "18px"});
    text.attr({'font-weight': "bold"});
    text.attr({opacity: 0});
    text.animate({opacity: 1}, 500);
}


