/**
 
* Modified Clusterer -> auf unsere Bedürfnisse angepasst, 
 * so dass auch wirklich nur Destination im Mittelpunkt und clickbar
 * map, marker array zugehörig zu einem Cluster, zusätzliche Optionen
 * 
 * also Kindklasse von OverlayView muss MyCluster folgende Fkt implentieren:
 * .onAdd(), .draw(), .remove()
 */
function MyCluster(map, clusterMarker){
	this.extend(MyCluster, google.maps.OverlayView);
	
	this.map_ = map;
	this.cluster_ = clusterMarker;
	this.div_ = null; 
	
	this.setMap(map);
}

/**
 * übernommen von MarkerClusterer -> zum Check ob google.maps geladen 
 */
MyCluster.prototype.extend = function(obj1, obj2) {
  return (function(object) {
    for (var property in object.prototype) {
      this.prototype[property] = object.prototype[property];
    }
    return this;
  }).apply(obj1, [obj2]);
};


MyCluster.prototype.onAdd = function() {
	var cluster = this.cluster_;
	var id = this.cluster_.clusterId;
	var markers = this.cluster_.markers;
	var clusterCenter = this.cluster_.clusterCenter;
	var clusterName = this.cluster_.clusterName;
	var markerClass = this.cluster_.markerClass;
	var markerType = markerClass.split('_',1);
	
	if(markerClass == "current_current"){
		fbId = cluster.fbId;
	}

	var div = $('<div class="'+markerClass+'"/>');
	this.div_ = div;
	
	var airportName = this.cluster_.clusterName.split(',', 1);
	if(airportName.toString().length >19){
		airportName = airportName.toString().substring(0, 19)+"...";
	}
	
	/**
	 * Clickevent => für einzelne Cluster => Inhalte in Schublade zeigen, abhängig von Parameter
	 * cluster Objekt 
	 */
	this.div_.appendTo(this.getPanes().floatPane);
	if(markerType[0] != 'homebase') {
		this.div_.bind('click', function(){
			openStatusBar(cluster, false);
		});
	} else {
		this.div_.bind('click', function(){
			openHomeBasePanel(cluster);
		});
	}
	
	var airportDiv = null;
	$(this.div_).bind('mouseover', function(){
		var p = [currentLocation.position, clusterCenter];
		var d = Math.round(calculateDistance(p));

		var tooltip = {w: 166, h: 67};
		var container = {w: 740, h: 390};
		
		var offset = $(div).offset();
		var position = setTooltipPosition(offset.left, offset.top, tooltip, container);
		
		var hr='<hr />';
		if ( $.browser.msie ) {
		  if ( parseInt($.browser.version, 10) == 7 )
			  hr = '';
		}
		
		if(markerClass == 'homebase_homebase' ) {
			airportDiv = $('<div id="tooltipCluster" style="top:'+offset.top+'px; left:'+offset.left+'px"/>').html("<p class='airportName'>"+airportName+"</p>"+hr+"<p class='miles'>Your homebase</p><div class='tooltipBottom' />");
		} else if(markerClass == 'current_current' ) {
			airportDiv = $('<div id="tooltipCluster" style="top:'+offset.top+'px; left:'+offset.left+'px"/>').html("<p class='airportName'>"+airportName+"</p>"+hr+"<p class='miles'>Your current position</p><div class='tooltipBottom' />");
		} else{
			airportDiv = $('<div id="tooltipCluster" style="top:'+offset.top+'px; left:'+offset.left+'px"/>').html("<p class='airportName'>"+airportName+"</p>"+hr+"<p class='miles'>"+d+" Miles</p><div class='tooltipBottom' />");
		}
		airportDiv.addClass(position).appendTo('#mapCanvas');
	});
	
	$(this.div_).bind('mouseout', function(){
		if(airportDiv != null){
			airportDiv.remove();
			airportDiv = null;
		}
	});
	
	google.maps.event.addListener(this.map_, 'idle', function(){ 
		if(airportDiv != null){
			airportDiv.remove();
			airportDiv = null;
		}
	});
	
}

MyCluster.prototype.draw = function() {	
	var overlayProjection = this.getProjection();
	var center = overlayProjection.fromLatLngToDivPixel(this.cluster_.clusterCenter);
	var markers = this.cluster_.markers;
	var count = markers.length;
	var div = this.div_;
	var airportType = this.cluster_.markerClass.split('_',1);

	/**
	 * Clusteranzeige: Anzahl der Freunde vor Ort oder "+" 
	 * muss gegen Bild getauscht werden
	 */
	if((count == 0) && (airportType == 'swissDest')){
		$(div).addClass('plus');
		$(div).css({top: center.y + 'px', left: center.x + 'px', cursor: 'pointer'}).html('<span></span>');
	} else if(count != 0 && (airportType == 'swissDest' || airportType == 'foreignDest')){
		if(count<=99){
			$(div).css({top: center.y + 'px', left: center.x + 'px', cursor: 'pointer'}).html('<span>'+count+'</span>');
		} else {
			$(div).css({top: center.y + 'px', left: center.x + 'px', cursor: 'pointer', 'font-size': '12px'}).html('<span>'+count+'</span>');
		}
	} else if(airportType == 'homebase'){
		$(div).css({top: center.y + 'px', left: center.x + 'px', cursor: 'pointer'});
	} else if(airportType == 'current'){
		$(div).css({top: center.y + 'px', left: center.x + 'px', cursor: 'pointer'}).html('<img src="https://graph.facebook.com/'+fbId+'/picture/" width="22" height="22" style="margin:2px 0 0 0"/>');
	} else {
		$(div).remove();
	}
	
}

MyCluster.prototype.remove = function() {
}
