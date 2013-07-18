<?php

class testingActions extends myFacebookActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->fbUserId =  parent::getValidFbUser();
		$friends = $this->getFriends();
		$friendslocations = $this->getFriendsLocation($friends);
		//print_r($friendslocations);
		foreach($friendslocations as $location){

			$geoCodes = myLocationActions::getGeocodes($location);
		    	
		    	$country = $geoCodes['country'];
		    	$lat = $geoCodes['lat'];
		    	$lng = $geoCodes['lng'];
			echo 'FB location:'.$location.' | Yahoo country:'.$country.' lat:'.$lat.' lng:'.$lng.'<br>';
		}
	}
}
