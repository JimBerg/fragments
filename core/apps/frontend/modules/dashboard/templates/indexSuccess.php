<!-- MAP -->
<div class="shadowTop"></div>
<?php include_partial('friendsMap', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); ?>

<!-- STATUSBAR -->
<?php include_partial('playerStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); ?>
<?php include_partial('boarding', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); ?>
<?php include_partial('global/footer', array('user' => $user)); ?>