function openStatusBar(content) {
	
	/**
	 * Marker für Anzahl Reihen
	 * Unterscheidung erreichbar nicht erreichbar
	 */
	if(content.markers){
		var markers = content.markers;
		var markerClass = content.markerClass.split('_', 2);		
		var airportType= markerClass[0];
		var reachable = markerClass[1];
		var isCluster = true;
		if(markers.length > 0){
			var headline = "Select a friend in: "+content.clusterName+" ";
		} else {
			var headline = "Selected destination: "+content.clusterName+" ";
		}
	} else {
		var markers = content;
		var reachable = 'reachable';
		var isCluster = false;
		var headline = "You've got "+markers.length+" friends worldwide";
	}

	var initHeight = 28;
	var margin = 2*8;
	var rowHeight = 57;
	var maxPerRow = 12;
	var countFriends = markers.length || 24; 
	var countRows = Math.ceil(countFriends/12); //max 3 Zeilen
	/*var pagerH = 57;*/
	var pagerH = 50;
	

	if(countRows <= 2) {
		var listH = rowHeight * countRows;
		var panelH = (Math.ceil(countFriends/maxPerRow)*rowHeight)+initHeight+margin;
		var listWidth = 720;
		numPages = 1;
	} else {
		var listH = rowHeight * 3;
		var panelH = (Math.ceil(36/maxPerRow)*rowHeight)+initHeight+margin + pagerH;
		numPages = Math.ceil(countFriends/36);
		var listWidth = numPages * 720;
	}
	
	if(markers.length == 0){
		var panelH = 170;
	}
	$('<div class="shadowTopPanel"/>').appendTo('#panel');
	/**
	 * if destination is available
	 */
	if(reachable == "reachable") {
		Cufon.replace($("h2.headline").text(headline), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		if($('#panel').hasClass('closed')){
			
			$('<div class="transOverlay" />').css({opacity: 0}).animate({
				opacity: 0.4
				}, 450, function() {
			}).appendTo("#mapCanvas");
			
			$('#panel').animate({
				height: panelH+"px"
				}, 350, 'fastToSlow', function(){
				    $('#panel').removeClass('closed');
				    $('#panel').addClass('open');
					
					$('#openFolder').css({'background-position': '0px 0px'});
					//$('#searchbar').fadeOut();
					/**
					 * Content laden
					 */
					if(markers.length != 0){
						$('#panelFriendList').css({height: listH+'px'}).fadeIn('fast');
						$('#friendlist').css({width: listWidth+'px'});
						getContent(content, panelH, isCluster);
					} else {
						$('#panelDestination').fadeIn('fast');
						getContentDestination(content);
					}
					/**
					 * Paging, wenn mehr als 36 Freunde
					 */
					if(countFriends > 36){
						slidePages(countFriends);
					}
			});
		} else if($('#panel').hasClass('open')) {
			closeStatusBar();
		}
	}
	$('.transOverlay').bind('click', function(){
		closeStatusBar();
	});
	
	
}

function openSearchStatusBar(content) {
	

	var markers = content;
	var reachable = 'reachable';
	var isCluster = false;
	var headline = "You've got "+markers.length+" friends worldwide";

	var initHeight = 28;
	var margin = 2*8;
	var rowHeight = 57;
	var maxPerRow = 12;
	var countFriends = markers.length || 24; 
	var countRows = Math.ceil(countFriends/12); //max 3 Zeilen
	/*var pagerH = 57;*/
	var pagerH = 50;
	

	if(countRows <= 2) {
		var listH = rowHeight * countRows;
		var panelH = (Math.ceil(countFriends/maxPerRow)*rowHeight)+initHeight+margin;
		var listWidth = 720;
		numPages = 1;
	} else {
		var listH = rowHeight * 3;
		var panelH = (Math.ceil(36/maxPerRow)*rowHeight)+initHeight+margin + pagerH;
		numPages = Math.ceil(countFriends/36);
		var listWidth = numPages * 720;
	}
	
	if(markers.length == 0){
		var panelH = 170;
	}
	
	/**
	 * if destination is available
	 */
	if(reachable == "reachable") {
		Cufon.replace($("h2.headline").text(headline), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});

		$('.transOverlay').remove();
		$('<div class="transOverlay" />').css({opacity: 0.4}).appendTo("#mapCanvas");
		//clear up all the possible infos after the last search
		$('.flightButtons').empty();
		$('#friendlistPager').empty();
		$('#friendlistPager').hide();
		$('#friendlist').empty();
		$('#panelSelectedFriend').fadeOut();
		$('#panel').removeClass('openLevel_2');
		$('#panel').removeClass('closed');
		$('#panel').addClass('open');

		$('#panel').animate({
			height: panelH+"px"
			}, 350, 'fastToSlow', function(){

				//just in case the user is typing fast and the animations overlap with each other we clear up once again
				$('.flightButtons').empty();
				$('#friendlistPager').empty();
				$('#friendlistPager').hide();
				$('#friendlist').empty();
				$('#panelSelectedFriend').fadeOut();
				$('#panel').removeClass('openLevel_2');
				$('#panel').removeClass('closed');
				$('#panel').addClass('open');
				//$('<div class="shadowTopPanel"/>').appendTo('#panel');

				$('#openFolder').css({'background-position': '0px 0px'});
				//$('#searchbar').fadeOut();
				/**
				 * Content laden
				 */
				
				if(markers.length != 0){
					$('#panelFriendList').css({height: listH+'px'}).fadeIn('fast');
					$('#friendlist').css({width: listWidth+'px'});
					getContent(content, panelH, isCluster);
				} else {
					$('#friendlist').css({width: listWidth+'px'});
                    $('<div class="noFriendsList">No friends found.</div>').appendTo('#friendlist');
					Cufon.replace($('.noFriendsList'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
				}
				/**
				 * Paging, wenn mehr als 36 Freunde
				 */
				if(countFriends > 36){
					slidePages(countFriends);
				}
		});
	}
	$('.transOverlay').bind('click', function(){
		closeStatusBar();
	});
	
	
}

function closeStatusBar(){
	element = null;
	$('#panelFriendList').fadeOut('fast');
	$('#panelDestination').fadeOut('fast');
	$('#panelHomebase').fadeOut('fast');
	$('#panelSelectedFriend').fadeOut('fast');
	$('#friendlistPager').fadeOut('fast');
	
	$('#friendlist').css({marginLeft: '0px'});
	
	if($('#panel').hasClass('openLevel_2')){
		$('#panel').removeClass('openLevel_2');
	}
	
	$('.shadowTopPanel').remove();
	$('#panel').animate({
		height: '28px'
		  }, 350, 'slowToFast', function(){
		  $('.transOverlay').animate({
				opacity: 0
			  }, 350, function() { 
				  $('.transOverlay').remove();
		  });
		  $('#panel').removeClass('open');
		  $('#panel').addClass('closed');
		  $('#openFolder').css({'background-position': '0px -28px'});
		  $('#friendlist').empty();
		  $('.flightButtons').empty();
		  
		  $('#friendlistPager').empty();
		  $('#searchbar').fadeIn();
	});
	Cufon.replace($("h2.headline").text("Select a friend or a destination"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
}

function getContent(content, h, isCluster){

	// Unterscheidung: Clusterclick oder komplette Freundesliste
	if(isCluster){
		var clusterId = content.clusterId;
		var markers = content.markers;
		var clusterCenter = content.clusterCenter;
		var clusterName = content.clusterName;
		var distance = Math.round(calculateDistance([currentLocation.position, clusterCenter]));
		var duration = calculateDuration(distance);
		var markerClass = content.markerClass.split('_', 2);
		
		var airportType= markerClass[0];
		var reachable = markerClass[1];
		var destFound = true;
		
	} else {
		var clusterId = 'no_cluster';//content.destinationId;
		var markers = content;
		var clusterName = content.destinationName;
		var clusterCenter = new google.maps.LatLng(content.lat, content.lng);
		var distance = Math.round(calculateDistance([currentLocation.position, clusterCenter]));
		var duration = calculateDuration(distance);
		
		var airportType= 'destination';
		var reachable = 'status';
		
	}
	
	/**
	 * Unterscheidung Dest // Friendcluster
	 */
	for(var page = 1; page <= numPages; page++){
		$('<ul id="friendlist_'+page+'" class="friendlistPages"/>').appendTo('#friendlist');
	
	}
	$(markers).each(function(k, element) {
		for(var page = 1; page <= numPages; page++){
			if(Math.ceil((k+1)/36) == page){
				$('<span class="loading"><li id="li_'+clusterId+'_'+k+'" style="background:url(https://graph.facebook.com/'+element.fbId+'/picture/) center center no-repeat;" /><div id="li_'+clusterId+'_'+k+'" class="'+element.friendReachable+'" /></span>').appendTo('#friendlist_'+page);
			}
		} 
                $('#li_'+clusterId+'_'+k).die('mouseover');
                $('#li_'+clusterId+'_'+k).die('mouseout');
                
		$('#li_'+clusterId+'_'+k).live('mouseover', function(){
			var x = this.parentNode.offsetLeft;
			var y = this.parentNode.offsetTop;
			var tooltip = {w: 140, h: 47};
			var container = {w: 720, h: 150};
			if(element.friendReachable == 'friendActive') {
				$("<div id='toolTipFriend' class='"+setTooltipPositionFriend(x, y, tooltip, container)+"' style='left:"+x+"px; top:"+y+"px' />").html("<div class='tT_repeat_section'>"+element.friendName+"<div id='arrow'/>").animate({
					opacity: 1
				}, 180, 'fastToSlow').appendTo('#li_'+clusterId+'_'+k);
			} else {
				$("<div id='toolTipFriend' class='"+setTooltipPositionFriend(x, y, tooltip, container)+" disabled' style='left:"+x+"px; top:"+y+"px'/>").html("<div class='tT_repeat_section'>not available<div id='arrow'/>").animate({
					opacity: 1
				}, 180, 'fastToSlow').appendTo('#li_'+clusterId+'_'+k);
			}
                        if ($('#toolTipFriend').width() < 140)
                                $('#toolTipFriend').width('140px');
		});
		
		$('#li_'+clusterId+'_'+k).live('mouseout', function(){
			$("#toolTipFriend").remove();
		});
			
		/**
		 * Click auf activeFriends: weitere Infos,
		 * auf disabled: Schublade schliessen, wenn geöffnet
		 */
		$('#li_'+clusterId+'_'+k).bind('click', function(){
			$('li').removeClass('active_li');
			
			var active_li = $(this);
			active_li.addClass('active_li');

			if(element.friendReachable == 'friendActive') {

				if(!($('#panel').hasClass('openLevel_2'))){
					$('#panel').addClass('openLevel_2');
					$('#panel').animate({
						height: h+70+'px'
						}, 360, function(){
							loadContent(element);
					});
				} else {
					loadContent(element);
				}
			} else if(element.friendReachable == 'friendDisabled') {
				$('#panelSelectedFriend').fadeOut();
				if($('#panel').hasClass('openLevel_2')) {
					$('#panel').removeClass('openLevel_2');
					$('#panel').animate({
						height: h+'px'
					});
				}
			}
		});
	});
}

function getContentDestination(content){

	var clusterId = content.clusterId;
	var markers = content.markers;
	var clusterCenter = content.clusterCenter;
	var clusterName = content.clusterName;
	var distance = Math.round(calculateDistance([currentLocation.position, clusterCenter]));
	var duration = calculateDuration(distance);
	var airportType = 'SWISS';

	//Cufon.replace($("h2.headline").text("Chosen Airport: "+clusterName), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
	Cufon.replace($('#destType').text(airportType), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('.airportName').text(clusterName), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#distance').text(distance), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#duration').text(duration), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});

	$('<a href="#" id="setAirportFlight_'+clusterId+'" class="button_left" />').html('<span class="button_right"><span class="buttonLabel">Proceed to Gate</span></span>').appendTo('.flightButtons');

	$('#setAirportFlight_'+clusterId).live('click', function(){
		setAirportFlight(clusterId, distance); 
	});
}

function loadContent(getElement){
	$('#panelSelectedFriend').css({height: '75px'}).fadeIn('fast');
	var element = getElement;
	//console.log(element);
	var flightable;
	
	if(element.destinationFound != null){
		if (element.destinationId == currentLocation.id){
			flightable = false;	
		} else {
			flightable = element.destinationFound;	
		}
	} else {
		flightable = true;
	}
	
	
	$('.flightButtons').empty();
	
	//var airportName = $('#statusBarText').text();
	if(flightable == true){
		var airportName = element.destinationName;
		var hometownName = element.location.split(',',1);
		var friendName = element.friendName.split(' ',2);
		var fbId = element.fbId;
		var position = element.position || new google.maps.LatLng(element.lat, element.lng);
		var distance = Math.round(calculateDistance([currentLocation.position, position]));
		var duration = calculateDuration(distance);

		$('#selectedFriendPic').css({background: 'url(https://graph.facebook.com/'+fbId+'/picture/) center center no-repeat'});
		
		Cufon.replace($('#friendAirportName').text(airportName), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendHome').text(hometownName[0]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#firstName').text(friendName[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#lastName').text(friendName[1]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendDistance').text(distance), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendDuration').text(duration), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});

		$('<a href="#" id="friendsetFlight_'+fbId+'" class="button_left" />').html('<span class="button_right"><span class="buttonLabel">Confirm Flight</span></span>').appendTo('.flightButtons');

		$('#friendsetFlight_'+fbId).bind('click', function(e){
			e.preventDefault();
			setFlight(element, distance); 
		});	
	} else {
		var airportName = element.destinationName;
		var hometownName = element.location.split(',',1);
		var friendName = element.friendName.split(' ',2);
		var fbId = element.fbId;
		var position = element.position || new google.maps.LatLng(element.lat, element.lng);
		var distance = Math.round(calculateDistance([currentLocation.position, position]));
		var duration = calculateDuration(distance);

		$('#selectedFriendPic').css({background: 'url(https://graph.facebook.com/'+fbId+'/picture/) center center no-repeat'});
		
		Cufon.replace($('#friendAirportName').text('not available'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendHome').text(hometownName[0]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#firstName').text(friendName[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#lastName').text(friendName[1]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendDistance').text(distance), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		Cufon.replace($('#friendDuration').text(duration), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	}
}



/**
 * Pager für Freundesauswahl
 * @todo: noch nicht kalr wo und wie Pager auszusehen hat
*/

function slidePages(countFriends){
	
	var totalPages = Math.ceil(countFriends/36);
        
	var currentPage;
	$('#friendlistPager').show();
	$('#friendlistPager').fadeIn('fast');
	
	var width = totalPages *12;
	$('#friendlistPager').show();
	$('<div id="pages" style="width:'+width+'px"/>').appendTo('#friendlistPager');
	for(var k=1; k<=totalPages; k++){
		if(k==1){
			$('<a href="#" id="page_'+k+'" onclick="slideToPage('+k+')" class="pageButton active"/>').appendTo('#pages');
		} else {
			$('<a href="#" id="page_'+k+'" onclick="slideToPage('+k+')" class="pageButton"/>').appendTo('#pages');
		}
	}
	
	$('<a href="#" id="prevPage" />').bind('click',function(){
		var currentPage = $('a.pageButton.active').attr('id');
		var currentPage = currentPage.substr(5);
		var pageOffset = (-1)*(getPageOffset(currentPage)-720);
		if(currentPage > 1){
			$('#friendlist').animate({
					marginLeft: pageOffset+'px'
				}, 360, 'slowToFast', function(){
			});
			currentPage--;
			$('#page_'+currentPage).addClass('active');
			$('a:not(#page_'+currentPage+')').removeClass('active');
		} else {
		}
	}).insertBefore('#pages');
	
	$('<a href="#" id="nextPage" />').bind('click',function(){
		var currentPage = $('a.pageButton.active').attr('id');
		var currentPage = currentPage.substr(5);
		var pageOffset = (-1)*(getPageOffset(currentPage)+720);
		if(currentPage < totalPages){
			$('#friendlist').animate({
					marginLeft: pageOffset+'px'
				}, 360, 'slowToFast', function(){
			});
			currentPage++;
			$('#page_'+currentPage).addClass('active');
			$('a:not(#page_'+currentPage+')').removeClass('active');
		} else {
		}
	}).insertAfter('#pages');
}

function getPageOffset(page){
	var pageOffset;
	if(page > 1){
		 return pageOffset = getPageOffset(page-1) + 720;
	} else {
		return pageOffset = 0;
	}
}

function slideToPage(page){
	var pageOffset = (page-1)*720;

	$('#friendlist').animate({
		marginLeft: -pageOffset+'px'
		}, 360, 'slowToFast', function(){
			$('#page_'+page).addClass('active');
			$('a:not(#page_'+page+')').removeClass('active');
	});
}

function closeStatusBarBoarding(){
	
	var confirmBox = $('#panelBoarding');
	confirmBox = $('#panelBoarding').css({display: 'block'});

	$('#panelFriendList').fadeOut('fast');
	$('#panelDestination').fadeOut('fast');
	$('#panelSelectedFriend').fadeOut('fast');
	$('#friendlistPager').fadeOut('fast');
	
	if($('#panel').hasClass('openLevel_2')){
		$('#panel').removeClass('openLevel_2');
	}
	$('#panel').css({overflow: 'hidden'});
	$('#panel').animate({
		height: '0px'
		  }, 600, 'slowToFast', function(){
		  	confirmBox.delay(500).animate({
				height: '328px'
				}, 600, 'slowToFast', function(){
				$('#panelBoarding .panelContent').fadeIn();
				$('<div class="transOverlay2" />').appendTo('#mapCanvas');
			});
		  	$('#panel').removeClass('open');
			$('#panel').addClass('closed');
			$('#friendlist').empty();
			$('.flightButtons').empty();
			$('#friendlistPager').empty();
			$('<a href="#" onclick="takeOff()" class="button_left"/>').html('<span class="button_right"><span class="buttonLabel">To Boarding</span></span>').appendTo('.flightButtons');

	});
	Cufon.replace($("h2.headline").text("Boarding"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
}

/**
 * Zwischenscreen: wenn Flug zu Freund angetreten wurde
 */
function setFlight(element, distance){
	var fbId = null;
	var targetDestination = null;

	var airportName = null;
	var hometownName = null;
	var friendName = null;
	var duration = null;
	var bonus = null;
	
	fbId = element.fbId;
	targetDestination = element.destinationId;

	airportName = element.destinationName;
	hometownName = element.location.split(',',1);
	friendName = element.friendName.split(' ',2);
	duration = calculateDuration(distance);
	bonus = getBonus(distance);
	
	Cufon.replace($('h2#infobarHead').text('Inform your friend that your coming'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #363636'});
	$('#panelBoarding #selectedFriendPic').css({background: 'url(https://graph.facebook.com/'+fbId+'/picture/) center center no-repeat'});
	

	$('#panelBoarding .firstNameArial').html(friendName[0]);
	$('#panelBoarding .bonusMilesArial').html(bonus);
	
	Cufon.replace($('#panelBoarding #friendAirportName').text(airportName), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding #friendHome').text(hometownName[0]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding .firstName').text(friendName[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding .bonusMiles').text(bonus), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding #lastName').text(friendName[1]), {fontFamily: 'CHSans_Regular', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding #friendDistance').text(distance), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#panelBoarding #friendDuration').text(duration), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	

	closeStatusBarBoarding();	
	/**
	 * NUR EINMAL AUSLÖSEN
	 */
	$.ajax({
		type: "GET",
		url: PAGE_URL+'dashboard/wallPostBoarding',
		data: "targetDestination="+targetDestination+"&fbId="+fbId,
		success: function(data) {
			//alert('ok');
		}, 
		error: function(){
		}
	});
	
	/** 
	 * Daten in DB, so dass Flug gesetzt ist
	 * bei "zurück" landet man in gewähltem Flug
	 */
	$.ajax({
		type: "GET",
		url: PAGE_URL+'dashboard/setFlight',
		data: "miles="+distance+"&targetDestination="+targetDestination+"&fbId="+fbId,
		success: function(data) {
			closeStatusBarBoarding();
	  	},	
		error: function(data) {
	  		document.location.href= PAGE_URL+"dashboard/onFlight";
	  	}
	});
	
	$("#notifyFriend").live('click', function(e){
		notifyFriend(fbId, friendName[0], bonus);
		//$("#notifyFriend").die();
		e.preventDefault();
	});
}

function takeOff(){
	$('#panelBoarding .panelContent').fadeOut();
	$('#panelBoarding').animate({
		height: '0px'
	}, 400, 'slowToFast', function(){
		document.location.href= PAGE_URL+"dashboard/onFlight";
	});
}

/**
 * Flug zu Destination
 */
function setAirportFlight(element, distance){
	var targetDestination = element;
	$.ajax({
		type: "GET",
		url: PAGE_URL+'dashboard/setFlight',
		data: "miles="+distance+"&targetDestination="+targetDestination+"&fbId=airportFlight",
		success: function(data) {
		   document.location.href= PAGE_URL+"dashboard/onFlight";
	  	},	
		error: function(data) {
	  		document.location.href= PAGE_URL+"dashboard/onFlight";
	  	}
	});
}

/**
 * Homebase anfliegen...
 * muss noch abgeklärt werden
 */
function setHomeBaseFlight(element, distance){
	var targetDestination = element;
	$.ajax({
		type: "GET",
		url: PAGE_URL+'dashboard/setHomebaseFlight',
		data: "miles="+distance,
		success: function(data) {
			   document.location.href= PAGE_URL+"dashboard/onFlight";
		  	},	
		error: function(data) {
	  		document.location.href= PAGE_URL+"dashboard/onFlight";
		}
	});
}

function openHomeBasePanel(content){
	$('#friendlist').empty();
	
	if($('#panel').hasClass('closed')){
		$('#panel').removeClass('closed');
		$('#panel').addClass('open');
		
		Cufon.replace($("h2.headline").text("Fly back to your homebase"), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #2a2a2a'});
		
		$('<div class="transOverlay" />').css({opacity: 0}).animate({
			opacity: 0.4
			}, 450, function() {
		}).appendTo("#mapCanvas");
		
		$('#panel').animate({
		height: "170px"
		}, 350, 'fastToSlow', function(){
			$('#openFolder').animate({
				backgroundPosition: '0px 0px'
			}, 100, 'swing', function(){
				$('#panelHomebase').fadeIn('fast');
				getHomeBaseContent(content);
				$('#searchbar').fadeOut();
			});
		});
	}
	$('.transOverlay').bind('click', function(){
		closeStatusBar();
	});
}

function getHomeBaseContent(content){
	
	var clusterId = content.clusterId;
	var markers = content.markers;
	var clusterCenter = content.clusterCenter;
	var clusterName = content.clusterName.split(',',1);
	var distance = Math.round(calculateDistance([currentLocation.position, clusterCenter]));
	var duration = calculateDuration(distance);
	var hometown = content.hometown.split(',',1);
	
	Cufon.replace($('#homebaseName').text(clusterName[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('.airportName').text(hometown[0]), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#distanceHb').text(distance), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
	Cufon.replace($('#durationHb').text(duration), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});

	$('<a href="#" id="setHomeBaseFlight_'+clusterId+'" class="button_left" />').html('<span class="button_right"><span class="buttonLabel">Back Home</span></span>').appendTo('.flightButtons');

	$('#setHomeBaseFlight_'+clusterId).live('click', function(){
		setHomeBaseFlight(clusterId, distance); 
	});
}

