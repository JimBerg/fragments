<!-- Statusbar -->
<?php 
	$module = sfContext::getInstance()->getModuleName()."_".sfContext::getInstance()->getActionName();
	if($getStatus->getOnFlight()  == false){
		$flightStatus = 'green';
	} else if($getStatus->getOnFlight()  == true) {
		$flightStatus = 'red';
	} 
	
	$currentLocation = explode(',',$currentLocation);

?>
<div id="playerStatusBar">
	<div id="userInfo">
		<h4><?php echo __('Your Status:') ?></h4>
		<div class="fbProfilePic"><img src="https://graph.facebook.com/<?php echo $user->getFbId(); ?>/picture/" width="48" height="48"/></div>
		
		<div id="currentLocationDiv" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="_unmarked"></div><div class="marked letters"><?php echo substr($currentLocation[0], 0, 12); ?></div></div>
			<div class="right"></div>
		</div>	
		<div id="playerRank" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="_unmarked"></div><div class="marked letters"><?php echo $getStatus->getPlayerRank(); ?></div></div>
			<div class="right"></div>
		</div>	
	</div>

	<div id="pointsInfo">
		<h4><?php echo __('Your Points:') ?></h4>	
		<div id="weekPoints" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="_unmarked"></div>
			<?php 
			$currentWeek = myFunctions::getCurrentWeek();
			$week = substr($currentWeek, 4);
			switch ($week) {
			case 1:
				$weekResults = $getStatus->getWeek1();
				break;
			case 2:
				$weekResults = $getStatus->getWeek2();
				break;
			case 3:
				$weekResults = $getStatus->getWeek3();
				break;
			case 4:
				$weekResults = $getStatus->getWeek4();
				break;
			case 5:
				$weekResults = $getStatus->getWeek5();
				break;
			case 6:
				$weekResults = $getStatus->getWeek6();
				break;
			case 7:
				$weekResults = $getStatus->getWeek7();
				break;
			case 8:
				$weekResults = $getStatus->getWeek8();
				break;
			default:$weekResults = '0';
	    		break;
	  		}
	  		
	  		if($weekResults == NULL){
	  			$weekResults = '0';
	  		}
			?>
			<div class="marked numbers"><?php echo $weekResults; ?></div>
			</div>
			<div class="right"></div>
		</div>	
		<div id="totalPoints" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="_unmarked"></div><div class="marked numbers"><?php echo $getStatus->getFlightMilesTotal(); ?></div></div>
			<div class="right"></div>
		</div>	
	</div>
	<div id="milesInfo">
		<h4><?php echo __('Air Miles:') ?></h4>	
		<div id="milesAvailable" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="_unmarked"></div><div class="marked numbers"><?php echo $getStatus->getAvailableMiles(); ?></div></div>
			<div class="right"></div>
		</div>
		<div class="icons">
			<div id="planeSymbol"></div>
			<div id="led" class="<?php echo $flightStatus ?>"></div>
		</div>
	</div>
</div>


