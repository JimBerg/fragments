<!-- Statusbar -->
<?php 
	$module = sfContext::getInstance()->getModuleName()."_".sfContext::getInstance()->getActionName();
	if($getStatus->getOnFlight()  == false){
		$flightStatus = 'green';
	} else if($getStatus->getOnFlight()  == true) {
		$flightStatus = 'red';
	} 
	
	if ($module == 'dashboard_setFlight'){
		$flightStatus = 'yellow';
	}
	
	$target = explode(',',$targetLocation->getLocationName());
	$start = explode(',',$startLocation->getLocationName());
	
	$currentTime = time();
?>
<div id="playerStatusBar">
	<div id="userInfo">
		<h4><?php echo __('You\'re in the plane:') ?></h4>
		<div class="fbProfilePic"><img src="https://graph.facebook.com/<?php echo $user->getFbId(); ?>/picture/"  width="48" height="48"/></div>
		
		<div id="currentLocationDiv" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="unmarked"></div><div class="marked letters"><?php echo substr($target[0],0,12); ?></div></div>
			<div class="right"></div>
		</div>	
		<div id="playerRank" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="unmarked"></div><div class="marked letters"><?php echo substr($start[0],0,12); ?></div></div>
			<div class="right"></div>
		</div>	
	</div>
	<div id="pointsInfo">
		<h4><?php echo __('Time:') ?></h4>	
		<div id="weekPoints" class="flipDisplay countdown_timer">
			<div class="left"></div>
			<div class="middle"><div class="unmarked"></div><div class="marked numbers"><?php echo myLocationActions::arrivalIn($arrival, $currentTime); ?></div></div>
			<div class="right"></div>
		</div>	
		<div id="totalPoints" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="unmarked"></div><div class="marked numbers"><?php echo myLocationActions::formattedTime($duration);?></div></div>
			<div class="right"></div>
		</div>	
	</div>
	<div id="milesInfo">
		<h4><?php echo __('Air Miles:') ?></h4>	
		<div id="milesAvailable" class="flipDisplay">
			<div class="left"></div>
			<div class="middle"><div class="unmarked"></div><div class="marked numbers"><?php echo $getStatus->getAvailableMiles(); ?></div></div>
			<div class="right"></div>
		</div>
		<div class="icons">
			<div id="planeSymbol"></div>
			<div id="led" class="<?php echo $flightStatus ?>"></div>
		</div>
	</div>
</div>