<div class="gameInfo">
	<div id="container">
		<div id="slider">
		<?php for($i=1; $i<=9; $i++) {?>
			<span id="slide<?php echo $i?>" class="slide"></span>
		<?php }?>
		</div>
	</div>	
	
	
	<div id="infoPager">
		<a href="#" onclick="prevPage()" id="prev" class=""></a>	
		
		<div class="numbers">
		<?php for($i=1; $i<=9; $i++) {
			if($i == 1){
				$active = 'activeInfo';
			} else {
				$active = '';
			} ?>
			<a href="#" id="page<?php echo $i?>" onclick="toPage(<?php echo $i?>)" class="<?php echo $active?>"><?php echo $i?></a>
		<?php }?>
		</div>
		
		<a href="#" onclick="nextPage()" id="next" class="visible"></a>
	</div>
</div>	
<?php if($getStatus->getOnFlight() == false){ 
	include_partial('dashboard/playerStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); 
	} else {
	include_partial('dashboard/onFlightStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'startLocation' => $startLocation, 'targetLocation' => $targetLocation, 'arrival' => $arrival, 'duration' => $duration, 'distance' => $distance));
	}?>
<?php include_partial('global/footer', array('user' => $user)); ?>		

<script type="text/javascript">
	function toPage(page){
		
		var move = (-1)*(page-1)*702; 
		var slider = document.getElementById('slider');

		if(page == 1){
			$('#prev').removeClass('visible');
		} else {
			$('#prev').addClass('visible');
		}
		
		if(page == 9){
			$('#next').removeClass('visible');
		} else {
			$('#next').addClass('visible');
		}
		
		
		$(slider).animate({
			marginLeft: move+'px'
			}, 500, function(){
				$('#page'+page).addClass('activeInfo');
				$('a:not(#page'+page+')').removeClass('activeInfo');
		});
	}

	function nextPage(){
		var page = $('#infoPager .activeInfo').attr('id');
		page = page.split('page',2);
		page = parseInt(page[1]);
		
		var move = (-1)*(page)*702; 
		var slider = document.getElementById('slider');

		if(page == 8){
			$('#next').removeClass('visible');
		} else {
			$('#next').addClass('visible');
		}

		$('#prev').addClass('visible');

		
		$(slider).animate({
			marginLeft: move+'px'
			}, 500, function(){
				page = page + 1;
				$('#page'+page).addClass('activeInfo');
				$('a:not(#page'+page+')').removeClass('activeInfo');
		});
	}

	function prevPage(){
		var page = $('#infoPager .activeInfo').attr('id');
		page = page.split('page',2);
		page = parseInt(page[1]);
		
		var move = (-1)*(page-2)*702; 
		var slider = document.getElementById('slider');

		if(page == 2){
			$('#prev').removeClass('visible');
		} else {
			$('#prev').addClass('visible');
		}
		$('#next').addClass('visible');

		$(slider).animate({
			marginLeft: move+'px'
			}, 500, function(){
				page = page - 1;
				$('#page'+page).addClass('activeInfo');
				$('a:not(#page'+page+')').removeClass('activeInfo');
		});
	}
	
</script>

