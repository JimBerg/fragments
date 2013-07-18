function acceptFlight(fbId, key, request_id) {
	$.ajax({
		type: "GET",
		url: PAGE_URL+'home/acceptFlight',
		data: "fbId="+fbId+"&accepted=accepted&request_id="+request_id,
		success: function(data) {
			//alert("Besuch erwünscht");
			//alert("fbId="+fbId+"&accepted=accepted&request_id="+request_id+" "+data);
			//$('#request_'+key).remove();
			$('#box_'+key).remove();
			$('#btn_'+key).remove();
			if(key == 0){
				$('#startButton').css({display: 'block'});
			}
	  	},	
		error: function(data) {
		   //alert("Fehler");
	  	}
	});
}

function denyFlight(fbId, key, request_id) {
	$.ajax({
		type: "GET",
		url: PAGE_URL+'home/acceptFlight',
		data: "fbId="+fbId+"&accepted=denied&request_id="+request_id,
		success: function(data) {
			//alert("Besuch abgelehnt");
			//$('#request_'+key).remove();
			$('#box_'+key).remove();
			$('#btn_'+key).remove();
			if(key == 0){
				$('#startButton').css({display: 'block'});
			}
	  	},	
		error: function(data) {
		   //alert("Fehler");
	  	}
	});
}

function removeBox(boxId){
	$('#box_'+boxId).animate({
		opacity: 0
	}, 300, 'swing', function(){
		$('#box_'+boxId).remove();
		$('#btn_'+boxId).remove();
	});
}