<?php

/**
 * home actions.
 *
 * @package    
 * @subpackage home
 * @author     Your name here
 */
class dashboardActions extends myFacebookActions
{
	/**
	 * Daten für Home/Index - Userstatus und UserId werden geholt
	 */
	public function executeIndex(sfWebRequest $request)
	{

		//if ($this->getUser()->getAttribute('request_ids') ){// && !$request->getParameter('friendUser')){
		//	$this->forward('home', 'index');
		//}
		
		$this->fbUserId =  parent::getValidFbUser();
		$getUser =  UserQuery::create()->findOneByFbId($this->fbUserId);
		if (!$getUser) 
			$this->forward('home', 'index');
		/**
		 * Check ob User Fan der Swiss Seite, bei jedem Aufruf
		 */		
		//if($getUser->getIsFan() == false) {
			$isFan = parent::checkIfIsFan($this->fbUserId);
			$getUser->setIsFan($isFan);
			$getUser->save();
		//}
				
		$homeId = LocationQuery::create()->findOneById($getUser->getLocationId())->getNearestDestination();
		/**
		 * abfragen, was die aktuelle Location ist, entweder Home, wenn noch kein Flug getätigt
		 * oder die letzte Location unter Targetlocation
		 */
		 $getStatus = PlayerstatusQuery::create()->findOneByUserId($getUser->getId());
		 if($getStatus->getFlightCount() > 0) {
		 	$flightQuery = FlightQuery::create()->filterByUserId($getUser->getId())->orderByFlightStart('desc')->findOne();
		 	$currentLocation = $flightQuery->getTargetLocationId();
		 } else {
		 	$currentLocation = $homeId;
		 }
		 
		$landed = $request->getParameter('landed');

		if($landed == 'landed'){
			//check if we really landed
			if ($getStatus->getOnFlight() && strtotime($flightQuery->getFlightEnd()) < time() ) {
				$getStatus->setOnFlight(false);
				$getStatus->save();
			}
		}
				 
		if($getStatus->getOnFlight() == true){
			$this->forward('dashboard', 'onFlight');
		}  else {
			$this->currentLocation = LocationQuery::create()->findOneById($currentLocation)->getLocationName();
			$this->homebase = LocationQuery::create()->findOneById($getUser->getLocationId())->getLocationName();
			$this->user = $getUser;
			$this->getStatus = $getStatus;
		}
	}

	/**
	 * Userdaten des aktuellen Users holen: 
	 * wenn noch kein Flug dann die Homelocation, sonst die aktuelle Location (= startLocation) 
	 * Map -> Mittelpunkt, Homelocation bzw. Startlocation setzen
	 */
	public function executeGetUserData(sfWebRequest $request)
	{		
		$this->fbUserId =  parent::getValidFbUser();
				
		$getUser =  UserQuery::create()->findOneByFbId($this->fbUserId);
		$playerStatus = PlayerstatusQuery::create()->findOneByUserId($getUser->getId());
		
		if($playerStatus->getFlightCount() > 0){
			$flight = FlightQuery::create()->filterByUserId($getUser->getId())->orderByFlightStart('desc')->findOne();
			$userLocationId = $flight->getTargetLocationId();
		} else {
			$userLocationId = $getUser->getLocationId();
		}
		$location = LocationQuery::create()->findOneById($userLocationId);
		$locationName = $location->getLocationName();
		$lat = $location->getLat();
		$lng = $location->getLng();
		$destination = $location->getNearestDestination();

		$user = new stdClass();
		$user->name = $getUser->getFirstname()." ".$getUser->getLastname();
		$user->id = $destination;
		$user->isFan = $getUser->getIsFan();
		//$user->location = $location->getId();
		$user->location = $locationName;
		$user->lat = $lat;
		$user->lng = $lng;
		$user->fbId = $getUser->getFbId();
		
		return $this->renderText(json_encode($user));
	}

	/**
	 *  Daten für Marker holen und in Klassen einteilen
	 */
	public function executeLoadMap(sfWebRequest $request)
	{
		// User holen
		$this->fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($this->fbUserId);
		
		$playerStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
		
		//prüfen an welchem Ort sich User gerade befindet -> bei Marker Klassifizierung ausgliedern
		if($playerStatus->getFlightCount() > 0) {
			$flight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
			$userLocationId = $flight->getTargetLocationId();
		} else {
			$userLocationId = $user->getLocationId();
		}

		$hometownName = LocationQuery::create()->findOneById($user->getLocationId())->getLocationName();
		//Kontostand prüfen // aktuellen Ort prüfen um auszuwerten welche Freunde/Locations erreichbar sind
		$nearest = LocationQuery::create()->findOneById($user->getLocationId())->getNearestDestination(); 
		$userHome = LocationQuery::create()->findOneById($nearest); 

		if(!$userHome->getSwissDestination()){
			$airportType = 'homebase_foreign';
		} else {
			$airportType = 'homebase_swiss';
		}
		$userLocation = LocationQuery::create()->findOneById($userLocationId);
		$point1 = array($userLocation->getLat(), $userLocation->getLng());
		
		//erreichbare und nicht erreichbare Flughäfen (Swiss und Fremd)
		$swissDestinations = myLocationActions::getSwissDestinations($point1, $playerStatus, $user->getId());
		$foreignDestinations = myLocationActions::getForeignDestinations($point1, $playerStatus, $user->getId());
		
		//zugehörige Freundesliste suchen
		$getFriendlistId = FriendlistQuery::create()->findOneByUserId($user->getId())->getId();
		$getFriendRelation = FriendRelationQuery::create()->filterByFriendlistId($getFriendlistId)->limit(1000)->find();
	
		$homebase = new stdClass();
		$homebase->id = $userHome->getId();
	   	$homebase->location = $userHome->getLocationName();
	   	$homebase->hometown = $hometownName;
	   	$homebase->lat = $userHome->getLat();
	   	$homebase->lng = $userHome->getLng();
	   	$homebase->availableMiles = $availableMiles;
	   	$homebase->airportType = $airportType;

	   	$friends = array();
	   	
		foreach($getFriendRelation as $getFriend) {
	   		$friendQuery = FriendQuery::create()->filterById($getFriend->getFriendId())->findOne();
	   		
	   		//eigenen User ausgliedern
	   		if($friendQuery->getFbId() == $this->fbUserId){
	   			continue;
	   		}
       
	   		//friends located in the homebase should not be included
			if ( $friendQuery->getLocationId() == $user->getLocationId() ) {
				continue;
			}
	   		//Friendlocations
	   		$locationId = LocationQuery::create()->findOneById($friendQuery->getLocationId());
	   		
	   		
	   		
	   		$friendLat = $locationId->getLat();
	   		$friendLng = $locationId->getLng();
	   		
	   		$point2 = array($friendLat, $friendLng);
	   		
	   		$friendDist = myLocationActions::checkDistance($point1, $point2, $playerStatus->getAvailableMiles());
	   		
	   		if($friendDist == false){
	   			$reachableStatus = "friendDisabled";
	   		} else {
	   		/**
	   		 * 1. Friendcheck: ist Freund verfügbar
	   		 * KRITERIUM 1: Freund darf insgesamt nur 3 mal angeflogen werden
	   		 */
	   		$countVisit = FlightQuery::create()->filterByUserId($user->getId())->filterByFriendId($friendQuery->getId())->count();
	   		if($countVisit >= 3) {
	   			$reachableStatus = "friendDisabled";
	   		} else {
		   		/**
		   		 * KRITERIUM 2: Wenn 1 false, erst auf 2tes Kriterium prüfen: letzter Besuch des Freundes muss > 7 Tage sein
		   		 */
		   		$calcLastWeek = strtotime(date('Y-m-d H:i:s'))-(60*60*24*7); //letzte Woche
		   		$lastWeek = date('Y-m-d H:i:s', $calcLastWeek);
		   		$lastVisit = FlightQuery::create()->filterByUserId($user->getId())->filterByFriendId($friendQuery->getId())->orderByFlightStart('desc')->filterByFlightStart($lastWeek, Criteria::GREATER_THAN)->findOne();
		   		
		   		if($lastVisit){
		   			$reachableStatus = "friendDisabled";
		   		} else {
		   			$reachableStatus = "friendActive";
		   		}
	   		}
	   		
	   			if($friendQuery->getLocationId() == $userLocationId){
	   				$reachableStatus = "friendDisabled";
	   			}
	   		}
	   		
	   		//i really don't know what i was trying to do here??
	   		/*$destinationFound = false;
	   		for($i = 0; $i < sizeof($swissDestinations[0]); $i++) {
	   			if($locationId->getNearestDestination() == $swissDestinations[0][$i]->destination ||
	   			$locationId->getNearestDestination() == $foreignDestinations[0][$i]->destination ){
	   				$destinationFound = true;
	   				$reachableStatus = "friendDisabled";
	   				break;
	   			} else {
	   				continue;
	   			}
	   		}*/
	   		
	   		$friend = new stdClass();
   			$friend->destinationId = $locationId->getNearestDestination();
   			//$friend->destinationFound = $destinationFound;
   			$query = LocationQuery::create()->findOneById($locationId->getNearestDestination());
   			if($query != NULL){
   				$friend->destinationName = $query->getLocationName();
   			} else {
   				$friend->destinationName = "leer";
   			}
   			$friend->location = $locationId->getLocationName();
   			$friend->lat = $locationId->getLat();
   			$friend->lng = $locationId->getLng();
   			$friend->friendName = $friendQuery->getName();
   			$friend->fbId = $friendQuery->getFbId();
   			$friend->friendReachable= $reachableStatus;
			array_push($friends, $friend);
		}

		$markerClass = new stdClass();
		$markerClass->friends = $friends;
		$markerClass->homebase = $homebase;
		$markerClass->swissDestinations = $swissDestinations[0];
		$markerClass->foreignDestinations = $foreignDestinations[0];
		$markerClass->notReachableSwissDestinations = $swissDestinations[1];
		$markerClass->notReachableForeignDestinations = $foreignDestinations[1];
		
		return $this->renderText(json_encode($markerClass));
	}
	
	public function executeSetFlight(sfWebRequest $request)
	{	
		// übergebene Parameter	
		$isAjax = $this->getRequest()->isXmlHttpRequest();
		if(!$isAjax){
			die('so nich');
		} else
			{
			//$miles = $request->getParameter('miles');
			$destinationId = $request->getParameter('targetDestination');
			$friendId = $request->getParameter('fbId');
			
			// User holen
			$fbUserId =  parent::getValidFbUser();
			$user = UserQuery::create()->findOneByFbId($fbUserId);
			
			// Prüfen ob Flug aktiv (zB. zwei Browserfesnter offen...)
			$setStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
			
		
			if($setStatus->getOnFlight() == false){

				// Userstatus aktualiseren => aktuelle Position bestimmen
				if($setStatus->getFlightCount() == 0) {
					$currentLocationId = $user->getLocationId();
					$currentLocation = LocationQuery::create()->findOneById( $currentLocationId );
				} else {

					$currentLocationId = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne()->getTargetLocationId();
					$currentLocation = LocationQuery::create()->findOneById( $currentLocationId );
				}

				$targetLocation = LocationQuery::create()->findOneById( $destinationId );

				$point1 = array($currentLocation->getLat(), $currentLocation->getLng());
				$point2 = array($targetLocation->getLat(), $targetLocation->getLng());

				$miles = myLocationActions::calculateDistance($point1, $point2);
				$hasEnoughMiles = myLocationActions::checkDistance($point1, $point2, $setStatus->getAvailableMiles());

				if (!$hasEnoughMiles) //if somehow user doesnt have enough miles to complete flight
					$this->forward('dashboard', 'index');


				// Punkte & Meilen
				$duration = myLocationActions::calcDuration($miles);
				$milePoints = myFunctions::setFlightType($miles, $user->getIsFan());
				$flightType = myFunctions::getFlightType($miles); //points sind jetzt flugtyp
				$friendBonus = 0;
				
				// friendId auslesen oder auf airport setzen
				if($friendId != 'airportFlight') {
					$friend = FriendQuery::create()->findOneByFbId($friendId);
					if ( $friend->getLocationId() == $destinationId )
						$this->forward('dashboard', 'index');
					$friendBonus = $milePoints;
				}
			
				//  NEUEN Flug anlegen -> pro User mehrere Flüge (wegen History!)
				$setFlight = new Flight();
				$setFlight->setUserId($user->getId());
				if($friendId != 'airportFlight'){
					$setFlight->setFriendId($friend->getId());
				} else {
					$setFlight->setFriendId(NULL);
					$setFlight->setFlightType('airportFlight');
				}
				$setFlight->setStartLocationId($currentLocationId);
				$setFlight->setTargetLocationId($destinationId); //wir fliegen zu destinations nicht zu Freunden
				$setFlight->setFlightStart(date('Y-m-d H:i:s'));
				$setFlight->setFlightEnd(date('Y-m-d H:i:s', (strtotime($setFlight->getFlightStart()) + $duration)));
				$setFlight->setFlightDuration($duration);
				$setFlight->save();

				/**
				 * Playerstatus UPDATEN -> auf dem Flug -> Punkte und Meilen berechnen - pro User
				 * neue Puntke erst nach Landung verfügbar, wegen Friendbonus usw.
				 */
				$setStatus->setOnFlight(true);
				$setStatus->setBonus($friendBonus);
				$setStatus->setFlightPoints($milePoints);
				$setStatus->setAvailableMiles(($setStatus->getAvailableMiles()) - ($miles));
				$setStatus->setFlightCount(($setStatus->getFlightCount()) + 1);
				$setStatus->setPoints($flightType);
				$setStatus->save();

				return $this->renderText('set flight');
			} else {
				$this->forward('dashboard', 'onFlight');
			}
		}
	}
	
	/**
	 * Homebaseflight
	 */
	public function executeSetHomebaseFlight(sfWebRequest $request) {
	
		$isAjax = $this->getRequest()->isXmlHttpRequest();
		if(!$isAjax){
			die('so nich');
		} else {
			$miles = $request->getParameter('miles');
			// User holen
			$fbUserId =  parent::getValidFbUser();
			$user = UserQuery::create()->findOneByFbId($fbUserId);
			
			// Userstatus aktualiseren
			$setStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
			if($setStatus->getFlightCount() == 0) {
				$currentLocation = $user->getLocationId();
			} else {
				$currentLocation = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne()->getTargetLocationId();
			}
			
			$duration = myLocationActions::calcDuration($miles);
			$flightType = myFunctions::getFlightType($miles); //points sind jetzt flugtyp
			
			//if($setStatus->getHomebaseFlight() > 0){
			$setStatus->setOnFlight(true);
			$setStatus->setBonus(0);
			$setStatus->setFlightPoints(0);
			$setStatus->setAvailableMiles(2000);
			$setStatus->setPoints($flightType);
			$setStatus->setFlightCount(($setStatus->getFlightCount()) + 1);
			//$setStatus->setHomebaseFlight(($setStatus->getHomebaseFlight()) - 1);
			$setStatus->save();
			//} else { }
			
			//  NEUEN Flug anlegen -> pro User mehrere Flüge (wegen History!)
			$setFlight = new Flight();
			$setFlight->setUserId($user->getId());
			$setFlight->setFriendId(NULL);
			$setFlight->setFlightType('homebaseFlight');
			$setFlight->setStartLocationId($currentLocation);
			$setFlight->setTargetLocationId($user->getLocationId());
			$setFlight->setFlightStart(date('Y-m-d H:i:s'));
			$setFlight->setFlightEnd(date('Y-m-d H:i:s', (strtotime($setFlight->getFlightStart()) + $duration)));
			$setFlight->setFlightDuration($duration);
			$setFlight->save();
		}
			
		return $this->renderText('homebase flight');
	}
	
	
	public function executeOnFlight(sfWebRequest $request)
	{		
		$fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($fbUserId);
		$getStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
		
		if($getStatus->getOnFlight() == false){
			$this->forward('dashboard', 'index');
		} else {
			/**
			 * User kehrt nach Inaktivität zurück
			 */
			/*if($user->getInactiveNotification() == true) {
				$user->setInactiveNotification(0);
				$user->save();
			}*/
			
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
	
	public function executeGetFlightData(sfWebRequest $request)
	{	
		$currentTime = time();	
		$fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($fbUserId);
		
		$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		$startLocationId = $latestFlight->getStartLocationId();
		$targetLocationId = $latestFlight->getTargetLocationId();
		
		$startLocation =  LocationQuery::create()->findOneById($startLocationId);
		$targetLocation = LocationQuery::create()->findOneById($targetLocationId);

		$flight = new stdClass();
		$flight->currentTime = $currentTime;
		$flight->userName = $user->getFirstname();
		$flight->flightStart = strtotime($latestFlight->getFlightStart());
		$flight->flightEnd = strtotime($latestFlight->getFlightEnd());
		$flight->duration = $latestFlight->getFlightDuration();
		$flight->flightType = $latestFlight->getFlightType(); 
		if(($latestFlight->getFlightType() != 'airportFlight') && ($latestFlight->getFlightType() != 'homebaseFlight')){
			$friend = FriendQuery::create()->findOneById($latestFlight->getFriendId());
			$flight->friendId = $friend->getFbId();
			$flight->friendName = $friend->getName();
		} else {
			$flight->friendId  = 'airportFlight';
		}
		$flight->startId = $startLocation->getId();
		$flight->startName = $startLocation->getLocationName();
		$flight->startLat = $startLocation->getLat();
		$flight->startLng = $startLocation->getLng();
		$flight->targetId = $targetLocation->getId();
		$flight->targetName = $targetLocation->getLocationName();
		$flight->targetLat = $targetLocation->getLat();
		$flight->targetLng = $targetLocation->getLng();
		
		return $this->renderText(json_encode($flight));
		
	}	
	
	public function executeFriendReaction(sfWebRequest $request)
	{		
		$fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($fbUserId);
	
		$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		$flightAccepted = $latestFlight->getFlightAccepted();
		$playerStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
		
		if($flightAccepted == 'accepted') {
			$flightReaction = "accepted";
			$playerStatus->save();
		} else if($flightAccepted == 'denied') {
			$flightReaction = "denied";
			$playerStatus->setBonus('0');
			$playerStatus->save();
		} else {
			$flightReaction = "pending";
		}
		
		$reaction = new stdClass();
		$reaction->flightReaction= $flightReaction;
		return $this->renderText(json_encode($reaction));
	}
	
	public function executeGetDestinationInfo(sfWebRequest $request)
	{		
		$destinationId = $request->getParameter('locationName');
		$isSwiss = LocationQuery::create()->filterById($destinationId)->filterBySwissDestination('1', Criteria::EQUAL)->findOne();
		//$getInfo = DestinationQuery::create()->findOneByLocationId($destinationId);
		
		if($isSwiss){
			$getInfo = DestinationQuery::create()->findOneByLocationId($destinationId);
			$getPics = PicturesQuery::create()->filterByDestinationId($destinationId)->find();
			$touristData = new stdClass();
			$touristData->locationName = $getInfo->getLocationName();
			$touristData->region = $getInfo->getRegion();
			$touristData->geolocation = $getInfo->getGeolocation();
			$touristData->area = $getInfo->getArea();
			$touristData->elevation = $getInfo->getElevation();
			$touristData->population = $getInfo->getPopulation();
			$touristData->density = $getInfo->getPopulationDensity();
			$touristData->timezone = $getInfo->getTimezone();
			$touristData->infotext = $getInfo->getInfotext();
			$touristData->pictures = $getPics;
		} else {
			$getInfo = LocationQuery::create()->findOneById($destinationId);
			$touristData = new stdClass();
			$touristData->locationName = 'keine Swiss Destination';
			$touristData->region ='in keinem Land';
		}
		return $this->renderText(json_encode($touristData));
	}

	public function executeSearch(sfWebRequest $request)
	{
		$fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($fbUserId);
			
		$search =  $request->getParameter('searchInput');
		
		$getFriendlistId = FriendlistQuery::create()->findOneByUserId($user->getId())->getId();
		
		$searchResults = array();
		$searchQuery = FriendQuery::create()->useFriendRelationQuery()->filterByFriendlistId($getFriendlistId)->endUse()->filterByName('%'.$search.'%', Criteria::LIKE)->find();
		if(sizeof($searchQuery) == 0){
			$friend = new stdClass();
   			$friend->friendName = 'no result';
			array_push($searchResults, $friend);
			return $this->renderText(json_encode($searchResults));
		} else {
			foreach($searchQuery as $result){
				$friend = new stdClass();
	   			$friend->clusterId = $result->getLocationId();

	   			/*$friend->destinationFound = $destinationFound;
	   			$friend->destinationName = LocationQuery::create()->findOneById($searchQuery ->getNearestDestination())->getLocationName();
	   			$friend->location = $locationId->getLocationName();
	   			$friend->lat = $locationId->getLat();
	   			$friend->lng = $locationId->getLng();*/
	   			$friend->friendName = $result->getName();
	   			$friend->fbId = $result->getFbId();

				/**
				 * 1. Friendcheck: ist Freund verfügbar
				 * KRITERIUM 1: Freund darf insgesamt nur 3 mal angeflogen werden
				 */
				$countVisit = FlightQuery::create()->filterByUserId($user->getId())->filterByFriendId($friendQuery->getId())->count();
				if($countVisit >= 3) {
					$reachableStatus = "friendDisabled";
				} else {
					/**
					 * KRITERIUM 2: Wenn 1 false, erst auf 2tes Kriterium prüfen: letzter Besuch des Freundes muss > 7 Tage sein
					 */
					$calcLastWeek = strtotime(date('Y-m-d H:i:s'))-(60*60*24*7); //letzte Woche
					$lastWeek = date('Y-m-d H:i:s', $calcLastWeek);
					$lastVisit = FlightQuery::create()->filterByUserId($user->getId())->filterByFriendId($friendQuery->getId())->orderByFlightStart('desc')->filterByFlightStart($lastWeek, Criteria::GREATER_THAN)->findOne();

					if($lastVisit){
						$reachableStatus = "friendDisabled";
					} else {
						$reachableStatus = "friendActive";
					}
				}

	   			$friend->friendReachable= $reachableStatus;
				array_push($searchResults, $friend);
			}
			return $this->renderText(json_encode($searchResults));
		}
	}
	
	/**
	 * Rückmeldung an User nach Landung über Punkteverteilung etc.
	 */
	public function executeGetStatusUpdate(sfWebRequest $request)
	{
		/*
		 * flightmilesTotal entsprechen Punkte
		 */
		$this->fbUserId =  parent::getValidFbUser();
		$user =  UserQuery::create()->findOneByFbId($this->fbUserId);
		$playerStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());
		$flight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		$targetLocation = LocationQuery::create()->findOneById($flight->getTargetLocationId())->getLocationName();
		
		$milePoints = $playerStatus->getFlightPoints();
		$flightType = $playerStatus->getPoints();
		$currentWeek = myFunctions::getCurrentWeek();

		$landed = $request->getParameter('landed');
		//check if we really landed
		if($landed == 'landed' && $playerStatus->getOnFlight() && strtotime($flight->getFlightEnd()) < time()){

			$playerStatus->setOnFlight(false);
			if($flight->getFlightAccepted() == 'accepted'){
				$bonus = $playerStatus->getBonus();
				$playerStatus->setAvailableMiles(($playerStatus->getAvailableMiles()) + $milePoints + ($playerStatus->getBonus()));
				$playerStatus->setFlightMilesTotal((($playerStatus->getFlightMilesTotal()) + $milePoints + ($playerStatus->getBonus()))*10);
				switch ($currentWeek) {
					case week1:
						$playerStatus->setWeek1($playerStatus->getWeek1() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week2:
						$playerStatus->setWeek2($playerStatus->getWeek2() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week3:
						$playerStatus->setWeek3($playerStatus->getWeek3() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week4:
						$playerStatus->setWeek4($playerStatus->getWeek4() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week5:
						$playerStatus->setWeek5($playerStatus->getWeek5() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week6:
						$playerStatus->setWeek6($playerStatus->getWeek6() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week7:
						$playerStatus->setWeek7($playerStatus->getWeek7() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					case week8:
						$playerStatus->setWeek8($playerStatus->getWeek8() + ($milePoints + $playerStatus->getBonus())*10);
						break;
					default:
						break;
				}
			} else {
				$bonus = 0;
				$playerStatus->setAvailableMiles(($playerStatus->getAvailableMiles()) + $milePoints);
				$playerStatus->setFlightMilesTotal($playerStatus->getFlightMilesTotal() + $milePoints*10);
				switch ($currentWeek) {
					case week1:
						$playerStatus->setWeek1($playerStatus->getWeek1() + $milePoints*10);
						break;
					case week2:
						$playerStatus->setWeek2($playerStatus->getWeek2() + $milePoints*10);
						break;
					case week3:
						$playerStatus->setWeek3($playerStatus->getWeek3() + $milePoints*10);
						break;
					case week4:
						$playerStatus->setWeek4($playerStatus->getWeek4() + $milePoints*10);
						break;
					case week5:
						$playerStatus->setWeek5($playerStatus->getWeek5() + $milePoints*10);
						break;
					case week6:
						$playerStatus->setWeek6($playerStatus->getWeek6() + $milePoints*10);
						break;
					case week7:
						$playerStatus->setWeek7($playerStatus->getWeek7() + $milePoints*10);
						break;
					case week8:
						$playerStatus->setWeek8($playerStatus->getWeek8() + $milePoints*10);
						break;
					default:
						break;
				}
			}
		}

		//$bla =$playerStatus->getFlightMilesTotal();
		$rank = myFunctions::setRank($playerStatus->getFlightMilesTotal());
		$playerStatus->setPlayerRank($rank);
		$playerStatus->setBonus('0');
		$playerStatus->save();
		
		if($flight->getFriendId() == NULL) {
			$friendId = "Swiss Destination";
			$fbId = "Swiss";
		} else {
			$friend = FriendQuery::create()->findOneById($flight->getFriendId());
			$friendId = $friend->getName();
			$fbId = $friend->getFbId();
		}
		
		$landing = new stdClass();
		$landing->fan = $user->getIsFan();
		$landing->friendId = $friendId;
		
		$landing->fbId = $fbId;
		$landing->targetLocation = $targetLocation;
		$landing->flightType = $flightType;
		$landing->reaction = $flight->getFlightAccepted();
		
		$landing->flightPoints = $milePoints; //Punkte für den Flug
		$landing->bonus = $bonus; //Freundbonus
		$landing->milesReward = $milePoints + $bonus;
		$landing->pointsReward = ($milePoints + $bonus)*10;
		$landing->rank = $rank;
		$landing->bla = $bla;
	
		return $this->renderText(json_encode($landing));
	}

	/**
	 * Wetterdaten
	 */
	public function executeGetWeatherInfo(sfWebRequest $request)
	{
		$getLocationName = $request->getParameter('locationName');
		$locationName = str_replace(" ", "+", $getLocationName);
		$str  = array('Accept-Language: '.$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.google.com/ig/api?weather='.$locationName.'&hl=en');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $str);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$weather = simplexml_load_string(utf8_encode(curl_exec($ch)));
		curl_close($ch);
		
		$cond = $weather->weather->current_conditions->condition['data'];
		$icon = strtolower(str_replace(' ', '_', $cond));
		$weatherData = new stdClass();
		//$weatherData->icon = $weather->weather->current_conditions->icon['data'];
		$weatherData->icon = $icon;
		$weatherData->conditions = $weather->weather->current_conditions->condition['data'];
		$weatherData->temperature = $weather->weather->current_conditions->temp_c['data'];
		$weatherData->humidity = $weather->weather->current_conditions->humidity['data'];
	
		return $this->renderText(json_encode($weatherData));
	}

	/**
	 * Wall Post nach Landung auslösen
	 */
  	/*public function executeWallPostLanding(sfWebRequest $request) {
   		
  		$api_call = array(
	        'method' => 'users.hasAppPermission',
	        'uid' => parent::getValidFbUser(),
	        'ext_perm' => 'publish_stream'
	    );
	    $can_post = $this->getFacebook()->api($api_call);
	    if($can_post){
	        $this->getFacebook()->api('/'.parent::getValidFbUser().'/feed', 'post', array(
			    'message' => 'Ich bin gelandet - und lebe noch - juhu',
			    'name' => 'ftyf',
			    'description' => 'Erst fliegen, dann landen.',
			    'caption' => 'Dat is n tolles Spiel',
			    'picture' => sfConfig::get('sf_server_url').'images/plane.gif',
			    'link' => 'http://apps.facebook.com/fly-to-friends/'
			));
	    } else {
	        die('Permissions required!');
	    }
	    
	    return $this->renderText('wallpost landing');
  	}*/
  	
	public function executeWallPostBoarding(sfWebRequest $request) 
	{
	
		$targetLocation = $request->getParameter('targetDestination');
		$friendFbId = $request->getParameter('fbId');
		
		if($friendFbId != 'swiss'){
			$friendName = FriendQuery::create()->filterByFbId($friendFbId)->findOne()->getName();
		} else {
			$friendName = "Swiss";
		}
		
		$api_call = array(
	        'method' => 'users.hasAppPermission',
	        'uid' => parent::getValidFbUser(),
	        'ext_perm' => 'publish_stream'
	    );
	    
	    $can_post = parent::getFacebook()->api($api_call); //returns true
	    $targetLocation = LocationQuery::create()->filterById($targetLocation)->findOne()->getLocationName();
	    if($can_post){
	        parent::getFacebook()->api('/'.parent::getValidFbUser().'/feed', 'post', array(
			    //'message' => "I'm so excited! I'm about to fly to ".$targetLocation.". ",
			    'name' => 'Fly to your Friends',
			    'description' => 'How about you, don’t you want to visit any of your own friends? Fly virtually around the world and collect miles and points. Maybe you get to win the “Round the World Ticket” yourself and get to visit your Facebook friend for real.',
			    'caption' => 'I‘m on my way to '.$targetLocation.'.',
				'picture' => sfConfig::get('sf_server_url').'images/layout/fb_feed-icon.png',
				'link' => 'http://apps.facebook.com/fly-to-your-friends/'
			));
	    } else {
	        die('Permissions required!');
	    }
		return $this->renderText('Wall Post Boarding');			
	}
  	
  	public function executeSetRequest(sfWebRequest $request) {
  		$reqId = $request->getParameter('reqId');
  		$friendFbId = $request->getParameter('friendId');
  		$friendId = FriendQuery::create()->filterByFbId($friendFbId)->findOne()->getId();
  		
  		$this->fbUserId =  parent::getValidFbUser();
		$user =  UserQuery::create()->findOneByFbId($this->fbUserId);
		
		$flightQuery = FlightQuery::create()->filterByUserId($user->getId())->filterByFriendId($friendId)->orderByFlightStart('desc')->findOne();
		$flightQuery->setFlightAccepted($reqId);
		$flightQuery->save();
		
		return $this->renderText('set apprequest');
  	}
	
	public function executeTestYahooGeocoding(sfWebRequest $request)
	{
		print_r(myLocationActions::getGeocodes( 'Sofia, Bulgaria' ) );
	}
	
	public function executeGetServerTime(sfWebRequest $request)
	{
		return $this->renderText(json_encode(strtotime(date('Y-m-d H:i:s'))));
	}

}

