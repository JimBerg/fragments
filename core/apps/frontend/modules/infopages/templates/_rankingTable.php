<span id="ranking">
<?php
$page = $pager->getPage();
$max = sfConfig::get('sf_pager_max_items'); 
$week = $pager->getParameter('week'); 

$currentWeek = substr($currentWeek,4);
if($week == 'total'){
	if($currentWeek == 1) $woche = 'week'; else $woche = "weeks";
	echo "<h2 class='headline ranking'>Total after ".$currentWeek." ".$woche."</h2>";
} else if($currentWeek > $week){
	echo "<h2 class='headline ranking'>Week ".$week.": Congratulations to the winner ".$first->getFirstname()." ".$first->getLastname()."</h2>";
} else if($currentWeek == $week){
	echo "<h2 class='headline ranking'>Week ".$week.": still flying</h2>";
}

if($currentWeek >= $week || $week == 'total'){ ?>
<table style="text-align: left;">
		<tr>
			<th class="place"><?php echo __('Place')?></th>
			<th class="passenger"><?php echo __('Passenger')?></th>
			<th class="homebase"><?php echo __('Homebase')?></th>
			<th class="visited"><?php echo __('Flights')?></th>
			<th class="last points"><?php echo __('Points')?></th>
		</tr>	
		<?php
		foreach ($pager as $k => $value){ 
		switch ($week) {
				case 'total':
		    		$weekResults = $value->getFlightmilesTotal();
		    		break;
				case 1:
					$weekResults = $value->getWeek1();
					break;
				case 2:
					$weekResults = $value->getWeek2();
					break;
				case 3:
					$weekResults = $value->getWeek3();
					break;
				case 4:
					$weekResults = $value->getWeek4();
					break;
				case 5:
					$weekResults = $value->getWeek5();
					break;
				case 6:
					$weekResults = $value->getWeek6();
					break;
				case 7:
					$weekResults = $value->getWeek7();
					break;
				case 8:
					$weekResults = $value->getWeek8();
					break;
				default:$weekResults = $value->getFlightmilesTotal();
		    		break;
		  	}
			$users = UserQuery::create()->findOneById($value->getUserId());
			$home = LocationQuery::create()->findOneById($users->getLocationId())->getLocationName();
	 	 	
			if($week != 'total'){
			$num= myFunctions::getWeekStartEnd( $week );
			$numFlights = FlightQuery::create()->
					filterByUserId($user->getId())->
					filterByFlightStart(array('min'=>$num['start'], 'max'=>$num['end']))->
					filterByFlightEnd(array('max'=>date ( 'Y-m-d H-i-s')))->
					count();
			}else{
				$numFlights = $value->getFlightCount();
			}
			//echo (($k-$max+1)+($max*$page) == $ranking);
			if ($weekResults != '') {?>
			<tr <?php if($user->getId() == $users->getId()){?> class="ranking_marked"<?php } else if((($k-$max+1)+($max*$page))%2 == 0){?> class="ranking_even" <?php } else { ?> class="ranking_odd" <?php } ?> >
				<td><?php echo ($k-$max+1)+($max*$page)?></td>
				<td><?php echo $users->getFirstname().' '.$users->getLastname();?></td>
				<td><?php echo $home;?></td>
				<td class="visited"><?php echo $numFlights;?></td>
				<td class="last points"><?php //if($weekResults != ''){ echo $weekResults; } else {echo "n.a.";} ?><?php echo $weekResults ?></td>
			</tr>
			<?php } else { 
				continue;
			}?>
		<?php } ?>
	</table>	
	<?php include_partial('infopages/pager', array('week' => $week, 'pager' => $pager, 'user' => $user, 'ranking' => $ranking));  ?>
	<?php } else { 
		echo "<h2 class='headline ranking'>No data available for week ".$week."</h2>";
	}?>
</span>