<?php 
class myFunctions
{
	public static function setFlightType($miles, $isFan)
	{
		/**
		 * Unterscheidung: Strecke & ob User Fan oder nicht
		 */
		if($isFan){
			if($miles <= 500) {
				$milePoints = 600;
			} else if($miles <= 1500){
				$milePoints = 1200;
			} else {
				$milePoints = 1800;
			}
		} else {
			if($miles <= 500) {
				$milePoints = 300;
			} else if($miles <= 1500){
				$milePoints = 700;
			} else {
				$milePoints = 1100;
			}
		}
		return $milePoints;
	}
	
	public static function setRank($points) 
	{
		if($points < 300000){
			$rank = 'Tourist';
		} 
		else if ($points < 600000){
			$rank = 'Traveler';
		}
		else if ($points < 900000){
			$rank = 'Passenger';
		}
		else if ($points < 1200000){ 
			$rank = 'Economist';
		}
		else if ($points < 1500000){
			$rank = 'Business';
		}
		else if ($points < 1800000){
			$rank = 'First Class';
		}
		else if ($points < 2100000){
			$rank = 'Premium Member';
		}
		else if ($points < 2400000){
			$rank = 'VIP Guest';
		}
		else if ($points < 2700000){
			$rank = 'Copilot';
		}
		else if ($points < 3000000){
			$rank = 'Flightmaster';
		} else {
			$rank = 'Flightmaster';
		}
		return $rank;
	}
	
	public static function getCurrentWeek() 
	{
		$today = strtotime(date("Y-m-d 00:00:00"));
		$startDate = strtotime('2011-06-06 00:00:00');
		$weekInSec = 60*60*24*7;
		
		for($i=1; $i<=8; $i++){
			if($today < ($startDate+($weekInSec*$i))){
				return $week = 'week'.$i;
			}
		}
	}

	public static function getWeekStartEnd($week)
	{
		
		$startDate = strtotime('2011-06-06 00:00:00');
		$weekInSec = 60*60*24*7;

		for($i=1; $i<=8; $i++){
			if($week == $i){
				return array(
					'start' => date ( 'Y-m-d H-i-s' , $startDate+($weekInSec*($i-1)) ),
					'end' => date ( 'Y-m-d H-i-s' , $startDate+($weekInSec*$i) ));
			}
		}
	}
	
	public static function getCurrentWeekFormat() 
	{
		
		$startDate = strtotime('2011-06-06 00:00:00');
		$weekInSec = 60*60*24*7;

		for($i=1; $i<=8; $i++){
			if($today < ($startDate+($weekInSec*$i))){
				if ($i==1){
					return $week = 'first';
				}
				else if ($i==2){
					return $week = 'second';
				}
				else if ($i==3){
					return $week = 'third';
				}
				else {
					return $week = $i.'th';
				}
			}
		}
	}
	


	public static function getFlightType($miles) 
	{
		if($miles <= 500) {
			$type = 'short';
		} else if($miles <= 1500){
			$type = 'medium';
		} else {
			$type = 'long';
		}
		return $type;
	}
	
	public static function getFbMetaString(array $fb_meta) {
		$fb_meta_string = '';
		foreach($fb_meta as $property => $content) {
			$fb_meta_string .= '<meta property="'.$property.'" content="'.$content.'"/>
			';
		}
		
		return $fb_meta_string;
	}
	
}