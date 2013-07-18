function checkBasicPerms(){
	return FB.login(function(response) {
		if (response.session) {
			var uid = response.session.uid;
			document.location.href = PAGE_URL+'home/friendUser?uid='+uid;
		}
	});
}



function checkPerms(){
	$('#startResults').empty();
	$('#stuffBox').animate({top: '422px'}, 200, 'swing', function(){
		$('#startResults').html('<p><img src="../images/ajax-loader.gif" alt="Loading"/> getting permissions</p>');
	});
	return FB.login(function(response) {
		if (response.session) {
			if (response.perms) {
			// user is logged in and granted some permissions. => es müssen alle Bedingungen akzeptiert sein
				if(response.perms.search(/publish_stream/) != -1
						&& response.perms.search(/email/) != -1 && response.perms.search(/friends_location/) != -1
						&& response.perms.search(/user_location/) != -1) {
					try {
						var uid = response.session.uid;
						var access_token = response.session.access_token;
						$('#startResults').fadeOut('slow', 'slowToFast', function(){
										$('#startResults').empty();
										$('#startResults').html('<p><img src="../images/ajax-loader.gif" alt="Loading"/> searching for friends</p>');
										$('#startResults').fadeIn('slow');
										$('#readyToFly').css({cursor: 'default'});
										$('#readyToFly').unbind('click', function(){return false;});
										$('#readyToFly').removeAttr('onclick');
										$('#startButton').css({background: 'none'});
										collectFriends(uid, access_token);
						});
					}
					catch(err) {
						handleErrorAndRefreshRegistration(1);
					}
				} else {
				  	handleErrorAndRefreshRegistration(1);
				}
			} else {
			  		handleErrorAndRefreshRegistration(1);
			}
		} else {
	  		handleErrorAndRefreshRegistration(1);
		}
	}, {perms:'publish_stream, email, friends_location, user_location'});
}


function handleErrorAndRefreshRegistration(param){
	$('#startResults').html('<p>we need your permission</p>');
};

function collectFriends(uid, access_token){
	
//	$('#startResults').empty();
//	$('#startResults').html('<p><img src="../images/ajax-loader.gif" alt="Loading"/>  searching for friends</p>');

	$.getJSON(PAGE_URL+'home/createUser', {'uid': uid, 'access_token': access_token} , function(data) {
		if (data.result == 'success'){
			$('#startResults').fadeOut('slow', 'slowToFast', function(){
				$('#startResults').empty();
				$('#startResults').html('<p><img src="../images/ajax-loader.gif" alt="Loading"/>  setting start miles</p>');
				$('#startResults').fadeIn('slow');

				window.setTimeout(function(){
					$('#startResults').fadeOut('slow', 'slowToFast', function(){
						$('#startResults').empty();
						$('#startResults').html('<p> You are all set.</p>');
						$('#startResults').fadeIn('slow');
						window.setTimeout(function(){
							top.location.href = FB_URL + 'dashboard/index';
						}, 500);

					});
				}, 500)
			});
		}
		else {
			$('#startResults').empty();
			$('#startResults').html('<p>' + data.error + '</p>');
		}

	}).error(function(data) {
			$('#startResults').empty();
			$('#startResults').html('<p>An error occured. Please refresh this page and try again.</p>');

		});
}

/**
 * Apprequest: Freundes-Anwendungseinladung 
 * Rückmeldung: Benachrichtigungsscreen
 */
function notifyFriend(friendId, friendName, bonus){
	FB.ui({
		method: 'apprequests', 
		to: friendId, 
		data: 'friendRequest',
		message: 'Hi '+friendName+', I’ve entered the “Fly to your Friends” competition from SWISS, and now I’m flying virtually around the world. The main prize is a real “Round the World” ticket. Could you help me with it? Just follow this welcome link.'
	},
	function(response) {
	if (response == null){
	}
    if (response && response.request_ids) {
    	$.ajax({
    		type: "GET",
    		url: PAGE_URL+'dashboard/setRequest',
    		data: "reqId="+response.request_ids+"&friendId="+friendId,
    		success: function() {
    			Cufon.replace($("#notifyResponse h3").text(''+friendName+' knows you\'re coming!'), {fontFamily: 'CHSans_Light', 'textShadow': '0px 1px 0 #fff'});
		    	$("#notifyResponse p").html('<strong>You said hi to your friend '+friendName+'</strong><br /><br />Now it\'s up to your friend, if he/she will say hi<br />and meet you at the airport. <br /><br />If so your points will be doubled!</p>');
		    	$('#notifyFriend').remove();
    	  	},	
    		error: function() {
    	    }
    	});
    } 
   });
}

/**
 * Pinnwandeintrag => auf eigener Pinnwand als Dialog // falls benötigt
 */
function postToWall(){
	FB.ui({
	     method: 'feed',
	     name: 'Was n hübsches Bild',
	     link: 'http://apps.facebook.com/jimsspielplatz/',
	     picture: 'http://fly-to-your-friends.ch.m10w0311.sui-inter.net/uploads/locationThumbs/amsterdam.png',
	     caption: 'Ein Location-Test',
	     description: 'Eine Benachrichtigung',
	     message: 'Ich fliege jetzt nach xyz - zu meinem Freund abc - und zusammen lernen wir das Alphabet'
	   },
	   function(response) {
	     if (response && response.post_id) {
	       alert('Post was published.');
	     } else {
	       alert('Post was not published.');
	     }
	   }
	);
}
