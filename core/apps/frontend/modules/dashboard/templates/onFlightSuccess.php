<?php include_partial('dashboard/onFlightMap', array('user' => $user, 'startLocation' => $startLocation, 'targetLocation' => $targetLocation, 'destination' => $destination, 'isSwiss' => $isSwiss, 'getPics' => $getPics));?>
<?php include_partial('dashboard/onFlightStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'startLocation' => $startLocation, 'targetLocation' => $targetLocation, 'arrival' => $arrival, 'duration' => $duration, 'distance' => $distance));?>

<?php include_partial('landing', array('user' => $user, 'getStatus' => $getStatus)); ?>

<?php include_partial('global/footer', array('user' => $user)); ?>
