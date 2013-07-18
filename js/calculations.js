/** 
 * Distanzberechnung zwischen zwei Punkten
 * @param: Array p, von zwei Punkten mit jeweils (lat, lng)
 * @return Float distance, Abstand in km
 */
function calculateDistance(p) {
	var p1 = p[0];
	var p2 = p[1];
   
	//Bogenmass
	function toRad(degree) {
   		return degree * (Math.PI/180);
	}

	//Haversine Funktion für Abstände auf Kugeloberfläche
	function haversine(phi) {
   		return Math.pow(Math.sin(phi/2), 2);
   	}
	
	//Erdradius in miles
	var radius = 3963.19;

	var p1_lat = toRad(p1.lat());
	var p1_lng = toRad(p1.lng());

	var p2_lat = toRad(p2.lat());
	var p2_lng = toRad(p2.lng());

	var delta_lat = p1_lat - p2_lat;
	var delta_lng = p1_lng - p2_lng;

	var distance = 2*radius * Math.asin(Math.sqrt(haversine(delta_lat)+Math.cos(p1_lat)*Math.cos(p2_lat)*haversine(delta_lng)));
	return distance.toFixed(2);
}

/** 
 * Flugdauer
 * t = (s/v) 
 * EINHEITEN beachten (normal m/s: für geschätze 600km/h => ~ 166,7 m/s)
 * @param: Float distance, Abstand in km => in m
 * @return Flugdauer in Stunden
 */
function calculateDuration(dist) {
	var v = getVelocity(dist);
	var d = ((dist*1.609*1000)/v).toFixed(0);
	var duration = formattedTime(d);
	return duration;
}

/**
 * Zeitanzeige
 */
function formattedTime(duration){
	var hours = Math.floor(duration/3600);
	var minutes = Math.floor((duration%3600)/60);
	var seconds = Math.floor((duration%3600)%60);

	if(hours <= 9){
		hours = "0"+hours;
	}
	if(minutes <= 9){
		minutes = "0"+minutes;
	}
	if(seconds <= 9){
		seconds = "0"+seconds;
	}
	var formattedTime = hours+":"+minutes+":"+seconds;
	return formattedTime;
}

/**
 * Flight: velocity
 * Distinction: Domestic, Shorthaul, Longhaul
 */
function getVelocity(dist) {
	// 248mph => 400km/h
	var v;
	// in mph
	if(dist <= 500) {
		v = 400/3.6;
	} else if(dist <= 1500){
		v = 500/3.6;
	} else {
		v = 600/3.6;
	}
	return v;
}

/**
 * Distanz zwischen zwei Punkten: verwendet bei onclick auf Cluster
 * @todo: vorrübergehend: muss noch schöner werden...
 */
function showDistance(point1, point2) {
	var points =[point1, point2];
	if(points.length<2) {
		points.push(points);
    }
	if(points.length==2) {
		var dist = calculateDistance(points);
		var duration = calculateDuration(dist);
		points=[point1];
	}
}

/**
 * Zurückgelegte Strecke
 * @todo: Rückgabe ;)
 */
/*function getPathFlown(currentSect){
	p =  [startPoint, endPoint];
	d = calculateDistance(p);

	pathFlown = (d/sections)*currentSect;
	//$('#pathFlown').text((pathFlown).toFixed(2)+" Meilen geflogen");
	
	return (pathFlown).toFixed(2);
}*/


/**
/* Ausrichtung, der Tooltips (rechts, links, oben, unten)
 */
function setTooltipPosition(x, y, tooltip, container){
	
	var tooltipWidth = parseInt(tooltip.w);
	var tooltipHeight = parseInt(tooltip.h);
	var tooltipCenterX = x;
	var tooltipCenterY = y;

	var containerWidth = parseInt(container.w);
	var containerHeight = parseInt(container.h);
	var spacingRight = 20;
	var spacingBottom = 20;
	
	var tooltipClass;
	
	// Ausrichtung unten wenn innerhalb des Bereichs => sonst oben
	if((tooltipCenterY + tooltipHeight) <= (containerHeight - spacingBottom)){
		tooltipClass = 'bottom';
	} else{
		tooltipClass = 'top';
	}
	
	// Ausrichtung rechts / links
	if((tooltipCenterX + tooltipWidth) <= (containerWidth - spacingRight)){
		tooltipClass += '_right';
	} else{
		tooltipClass += '_left';
	}
	return tooltipClass;
}

/**
/* Ausrichtung, der Tooltips (rechts, links, oben, unten)
 */
function setTooltipPositionFriend(x, y, tooltip, container){
	
	var tooltipWidth = parseInt(tooltip.w);
	var tooltipHeight = parseInt(tooltip.h);
	var tooltipCenterX = x;
	var tooltipCenterY = y;

	var containerWidth = parseInt(container.w);
	var containerHeight = parseInt(container.h);
	var spacingRight = 20; //spacing Left
	var spacingBottom = 20;
	
	var tooltipClass;
	
	//oben unten fällt weg
	tooltipClass = 'top';
	
	// Aurichtung rechts => Pfeil links
	if((tooltipCenterX - (tooltipWidth/2) >= spacingRight) && (tooltipCenterX + (tooltipWidth/2) <= (containerWidth - spacingRight))){
		tooltipClass += '_middle';
	}
	else if(tooltipCenterX + (tooltipWidth/2) > (containerWidth - spacingRight)){
		tooltipClass += '_left';
	} 
	else if (tooltipCenterX - (tooltipWidth/2) < spacingRight){
		tooltipClass += '_right';
	}
	return tooltipClass;
}



/**
 * Beschleunigungen für Fadings/Animation
 */
jQuery.extend(jQuery.easing, {
	slowToFast: function (x, t, b, c, d) {
		return Math.pow(x, 6);
	},
	fastToSlow: function (x, t, b, c, d) {
		return Math.sqrt(x);
	}
});

function getBonus(distance){
	
	//if(isFan==true){
		if(distance <= 500) {
			bonus = 300;
		} else if(distance <= 1500){
			bonus = 700;
		} else {
			bonus = 1100;
		}
	//}
	
	/*if(isFan==false){
		if(distance <= 500) {
			bonus = 300;
		} else if(distance <= 1500){
			bonus = 700;
		} else {
			bonus = 1100;
		}
	}*/
	
	
	return bonus;
}