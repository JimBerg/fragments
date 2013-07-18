<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
		FB.init({
          appId   : <?php echo sfConfig::get('sf_fb_app_id') ?>,
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
	 	});

		FB.Canvas.setSize({ width: 760, height: 1000 });
	
		FB.Event.subscribe('edge.create', function(response) {
			  // do something with response.session
			  $('#becomeFriend').fadeOut();
		});

		FB.Event.subscribe('edge.remove', function(response) {
			  $('#becomeFriend').fadeIn();
		});
	};
	
	(function() {
	    var e = document.createElement('script'); e.async = true;
	    e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
	    document.getElementById('fb-root').appendChild(e);
	}());
 </script> 
