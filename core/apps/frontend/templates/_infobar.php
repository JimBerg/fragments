<?php
	$module = sfContext::getInstance()->getModuleName()."_".sfContext::getInstance()->getActionName(); 
	
	$headline = 'Select a friend or a destination';
	if($module == 'dashboard_index'){
		$headline = 'Select a friend or a destination';
	} 
	if($module == 'infopages_ranking'){
		$headline = 'Ranking';
	}
	if($module == 'infopages_gameinfo'){
		$headline = 'How does it work';
	}
	if($module == 'dashboard_onFlight'){
		$headline = 'Welcome aboard';
	}
	if($module == 'flighthistory_index'){ 
		if (!$selected_week){
			$selected_week = 1;
		}
		$headline = 'Flight Route';
	}
?>

<div id="infobar" class="infobar">
		<h2 id="infobarHead" class="headline"><?php echo $headline?></h2>
		<div id="additional"></div>
		<?php 
		if($module == 'dashboard_index'){ ?>
			<div id="searchbar">
				<form>
					<input name="searchBox" type="text" id="friendSearch" value="Search a friend"><div id="searchRight"></div></input>
				</form>
			</div>
		<?php } 
		if($module == 'infopages_ranking'){ ?>
		<span class="weekLabel">Week:</span>
		<div id="rankingSliderContainer">
		<div id="rankingSliderContainerBknd">
			<ul id="nav">
		        <?php 	
		        $current = myFunctions::getCurrentWeek();
		     	$current = substr($current, 4);
		        if (!$selected_week){
		  			$selected_week = 'total';
		        }
		        
				for($week=1; $week<=9; $week++){ 
					if ($selected_week == $week ) $active = 'activeRanking'; else $active = '';
					if($week > $current) $disabled = "disabled"; else $disabled = '';
					if($week == 9){
						if($selected_week == 'total') $active = 'activeRanking'; else $active = '';
						echo "<li><a class='weeks ".$active."' id='total' href='".url_for('ranking', array('week' => 'total'))."'><span>total</span></a></li>";
					} else {
						echo "<li><a class='weeks ".$active." ".$disabled."' href='".url_for('ranking', array('week' => $week))."'><span>".$week."</span></a></li>";
					}
				}
				?>
	   		</ul>
	   		</div>
	    </div>
		<?php } if($module == 'flighthistory_index'){ ?>
		<span class="weekLabel" style="right:225px;">Week:</span>
		<div id="rankingSliderContainer">
			<ul id="nav">
		 		<?php
		 		$current = myFunctions::getCurrentWeek();
		     	$current = substr($current, 4);
		     	$num = 8;
		        if (!$selected_week){
		  			$selected_week = 1;
		        }
		        for($week=1; $week<=$num; $week++){
					if ($selected_week == $week) $active = 'activeRanking'; else $active = '';
					if($week > $current) $disabled = "disabled"; else $disabled = '';
					echo "<li><a id='week_$week' class='weeks ".$active." ".$disabled."'  href='#_' onclick='initHistoryMap($week)'><span>".$week."</span></a></li>";
				}?>
	   		</ul>
		</div>
		<?php } ?>
</div>
