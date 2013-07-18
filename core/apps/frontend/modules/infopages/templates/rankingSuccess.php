<?php $week = $pager->getParameter('week'); ?>
<?php include_partial('infopages/rankingTable', array('week' => $week, 'pager' => $pager, 'user' => $user, 'ranking' => $ranking, 'currentWeek' => $currentWeek, 'first' => $first)); ?>

<?php if($getStatus->getOnFlight()==false){
		include_partial('dashboard/playerStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation));
	} else {
		include_partial('dashboard/onFlightStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'startLocation' => $startLocation, 'targetLocation' => $targetLocation, 'arrival' => $arrival, 'duration' => $duration, 'distance' => $distance));
	}
?>


<?php include_partial('global/footer', array('user' => $user)); ?>