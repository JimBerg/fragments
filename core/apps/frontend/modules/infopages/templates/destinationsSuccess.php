<script type="text/javascript">
$(document).ready(function() {

	$.getJSON('http://fly-to-your-friends.ch.m10w0311.sui-inter.net/infopages/markers', function(data) {
		var mapDiv = document.getElementById('destMap');
		var mapOptions = {
			minZoom:2,
			maxZoom:10,
		 	zoom: 5,
		    center: new google.maps.LatLng(50, 8),
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		 };


		$.getJSON('http://fly-to-your-friends.ch.m10w0311.sui-inter.net/infopages/foreign', function(data) {
			$(data).each(function(k,marker) {
				markerImage = 'http://fly-to-your-friends.ch.m10w0311.sui-inter.net/images/blue.png'
				destination = new google.maps.Marker({
					position: new google.maps.LatLng(marker.lat, marker.lng),
					icon: markerImage,
					title: marker.location,
					map: map
				});
			});
		});
		
		map = new google.maps.Map(mapDiv, mapOptions);
		$(data).each(function(k,marker) {
			destination = new google.maps.Marker({
				position: new google.maps.LatLng(marker.lat, marker.lng),
				title: marker.location,
				map: map
			});
		});
	});
});
</script>
<div id="destMap" style="width:1500px; height:1000px;"></div>