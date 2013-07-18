<?php

/**
 * flighthistory actions.
 *
 * @package    flighthistory
 * @subpackage flighthistory
 * @author     Your name here
 */
class flighthistoryActions extends myFacebookActions
{
  public function executeIndex(sfWebRequest $request)
  {
  	$fbUserId =  parent::getValidFbUser();
  	$user = UserQuery::create()->findOneByFbId($fbUserId);
  	
  	$homeId = LocationQuery::create()->findOneById($user->getLocationId())->getId();
	 $getStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
	 if($getStatus->getFlightCount() > 0) {
	 	$flightQuery = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
	 	$currentLocation = $flightQuery->getTargetLocationId();
	 } else {
	 	$currentLocation = $homeId;
	 }

	 $this->getResponse()->setSlot('selected_week', $request->getParameter('week'));
	 
	$this->currentLocation = LocationQuery::create()->findOneById($currentLocation)->getLocationName();
	$this->homebase = LocationQuery::create()->findOneById($user->getLocationId())->getLocationName();
	$this->user = $user;
	$this->getStatus = $getStatus;
	
		//onflight data for statusbar
	if($getStatus->getOnFlight() == false){
		$this->onFlight=false;
	} else {
		$this->onFlight=true;
		$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		$startLocationId = $latestFlight->getStartLocationId();
		$targetLocationId = $latestFlight->getTargetLocationId();

		$isSwiss = LocationQuery::create()->filterById($targetLocationId)->filterBySwissDestination('1', Criteria::EQUAL)->findOne();
		if($isSwiss){
			$destination = DestinationQuery::create()->findOneByLocationId($targetLocationId);
		} else {
			$destination = LocationQuery::create()->findOneById($targetLocationId);
		}

		$this->arrival = $latestFlight->getFlightEnd();
		$this->duration = $latestFlight->getFlightDuration();
		$this->startLocation =  LocationQuery::create()->findOneById($startLocationId);
		$this->targetLocation = LocationQuery::create()->findOneById($targetLocationId);

		$start = array($this->startLocation->getLat(), $this->startLocation->getLng());
		$end = array($this->targetLocation->getLat(), $this->targetLocation->getLng());
		$this->distance = myLocationActions::calculateDistance($start, $end);

		$this->getPics = PicturesQuery::create()->filterByDestinationId($targetLocationId)->filterByTitle('feed_landing', Criteria::NOT_EQUAL)->find();

		$this->user = $user;
		$this->getStatus = $getStatus;

		$this->destination = $destination;
		$this->isSwiss = $isSwiss;
	}
  }
  
  public function executeGetFlightHistory(sfWebRequest $request)
  {
	$week = $request->getParameter('week');
	
	if (!$week)
		$week = substr( myFunctions::getCurrentWeek(), 4 );
	$week = myFunctions::getWeekStartEnd( $week );
	
  	$fbUserId =  parent::getValidFbUser();
  	$user = UserQuery::create()->findOneByFbId($fbUserId);
  	$getHistory = FlightQuery::create()->
		filterByUserId($user->getId())->
		filterByFlightStart(array('min'=>$week['start'], 'max'=>$week['end']))->
		filterByFlightEnd(array('max'=>date ( 'Y-m-d H-i-s')))->
		orderByFlightStart('asc')->
		leftJoin('Flight.Friend')->
		find();

	$homebase = LocationQuery::create()->findOneById($user->getLocationId());
  	$homebase = array( 'lat' => $homebase->getLat(),
		'lng' => $homebase->getLng() );
	$flights = array();
  	$airports = array();
  	foreach ($getHistory as $key => $userHistory){
		$location = LocationQuery::create()->findOneById($userHistory->getStartLocationId());
		
		$flight = new stdClass();
	  	$flight->destinationId = $userHistory->getStartLocationId();
	  	$flight->flightNum = $key+1;
	  	$flight->date = $userHistory->getFlightStart();
	  	$flight->user = $user->getFirstname()." ".$user->getLastname();
		$flight->fbId = $user->getFbId();
	  	$flight->lat = $location->getLat();
	  	$flight->lng = $location->getLng(); 	
	  	$flight->friendName = $userHistory->getFriendId();
	  	$flight->friendStatus = $userHistory->getFlightAccepted();
	  	
	  	 $end_airport = $userHistory->getLocationRelatedByTargetLocationId();

		//if this airport in not in the array yet, add it
		if (!isset($airports[$end_airport->getId()]))
		{
			$airports[$end_airport->getId()] = new stdClass();

			    //$destination_data = DestinationQuery::create()->findOneById( $end_airport->getId() );

			    $airports[$end_airport->getId()]->id = $end_airport->getId();
			    $airports[$end_airport->getId()]->location_name = $end_airport->getLocationName();
			    $airports[$end_airport->getId()]->swiss_destination = $end_airport->getSwissDestination();
			    $airports[$end_airport->getId()]->foreign_destination = $end_airport->getForeignDestination();
			    $airports[$end_airport->getId()]->lat = $end_airport->getLat();
			    $airports[$end_airport->getId()]->lng = $end_airport->getLng();
			    $airports[$end_airport->getId()]->friends = array();
			    $airports[$end_airport->getId()]->flightNumbers = array();

			    $destination_data = DestinationQuery::create()->findOneById( $end_airport->getId() );
			if ($destination_data){
					$airports[$end_airport->getId()]->airport_name = $destination_data->getAirportName();
			}
			    else{
				$airports[$end_airport->getId()]->airport_name = '';
			    }
				if ( $end_airport->getId() == $user->getLocationId() ){
					$airports[ $end_airport->getId() ]->homebase = true;
				}
			    else{
				$airports[ $end_airport->getId() ]->homebase = false;
			    }
		}
		 //now we add the friend who welcomed us to this airport
		$friend = $userHistory->getFriend();
		//$friend = false;
		if ($friend) {
			$friendFbId = $friend->getFbId();
			$friendName = $friend->getName();
			$flightAccepted = $userHistory->getFlightAccepted();
		} else {
			$friendFbId = 0;
			$friendName = 'Swiss staff';
			$flightAccepted = 'accepted';
		}
		if (!$flightAccepted)
			$flightAccepted = '';

		array_push($airports[$end_airport->getId()]->friends, array('fb_id' => $friendFbId,
			'friend_name' => $friendName,
			'friend_status' => $userHistory->getFlightAccepted() ));

		//each airport should know which flights were for it
		array_push($airports[$end_airport->getId()]->flightNumbers, $flight->flightNum );

		array_push($flights, $flight);
	}
	//add the first airport (if not already in the list)
	if ($getHistory && count($getHistory)>0)
	{
		$userHistory = $getHistory[0];
		$start_airport = $userHistory->getLocationRelatedByStartLocationId();
		
		if (!isset($airports[$start_airport->getId()]))
		{
			$airports[$start_airport->getId()] = new stdClass();

			    //$destination_data = DestinationQuery::create()->findOneById( $end_airport->getId() );

			    $airports[$start_airport->getId()]->id = $start_airport->getId();
			    $airports[$start_airport->getId()]->location_name = $start_airport->getLocationName();
			    $airports[$start_airport->getId()]->swiss_destination = $start_airport->getSwissDestination();
			    $airports[$start_airport->getId()]->foreign_destination = $start_airport->getForeignDestination();
			    $airports[$start_airport->getId()]->lat = $start_airport->getLat();
			    $airports[$start_airport->getId()]->lng = $start_airport->getLng();
			    $airports[$start_airport->getId()]->friends = array();
			    $airports[$start_airport->getId()]->flightNumbers = array();

			    $destination_data = DestinationQuery::create()->findOneById( $start_airport->getId() );
			if ($destination_data){
					$airports[$start_airport->getId()]->airport_name = $destination_data->getAirportName();
			}
			    else{
				$airports[$start_airport->getId()]->airport_name = '';
			    }
				if ( $start_airport->getId() == $user->getLocationId() ){
					$airports[ $start_airport->getId() ]->homebase = true;
				}
			    else{
				$airports[ $start_airport->getId() ]->homebase = false;
			    }
		}
	}

	//add the last flight
	if ($getHistory && count($getHistory)>0)
	{
		$userHistory = $getHistory[ count($getHistory) - 1 ];
		$location = LocationQuery::create()->findOneById($userHistory->getTargetLocationId());

		$flight = new stdClass();
		$flight->destinationId = $userHistory->getTargetLocationId();
		$flight->flightNum = $key+1;
		$flight->date = $userHistory->getFlightStart();
		$flight->user = $user->getFirstname()." ".$user->getLastname();
		$flight->fbId = $user->getFbId();
		$flight->lat = $location->getLat();
		$flight->lng = $location->getLng();
		$flight->friendName = $userHistory->getFriendId();
		$flight->friendStatus = $userHistory->getFlightAccepted();

		array_push($flights, $flight);
	}
  	
  	
  	return $this->renderText(json_encode(array('flights' => $flights, 'airports' => $airports, 'homebase' => $homebase )));
  }
}
