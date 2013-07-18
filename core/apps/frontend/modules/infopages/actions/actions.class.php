<?php

/**
 * infopages actions.
 *
 * @package   
 * @subpackage infopages
 * @author     Your name here
 */
class infopagesActions extends myFacebookActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$fbUserId =  parent::getValidFbUser();
		$user = UserQuery::create()->findOneByFbId($fbUserId);
		$getStatus = PlayerstatusQuery::create()->findOneByUserId($user->getId());

		if($getStatus->getOnFlight() == true){
			$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
			$startLocationId = $latestFlight->getStartLocationId();
			$targetLocationId = $latestFlight->getTargetLocationId();
	
			
			$this->arrival = $latestFlight->getFlightEnd();
			$this->duration = $latestFlight->getFlightDuration();
			$this->startLocation =  LocationQuery::create()->findOneById($startLocationId);
			$this->targetLocation = LocationQuery::create()->findOneById($targetLocationId);
				
			$start = array($this->startLocation->getLat(), $this->startLocation->getLng());
			$end = array($this->targetLocation->getLat(), $this->targetLocation->getLng());
			$this->distance = myLocationActions::calculateDistance($start, $end);
		}
		$this->user = $user;
		$this->getStatus = $getStatus;
	}
	
	public function executeRanking(sfWebRequest $request){

		$this->fbUserId =  parent::getValidFbUser();
		$user =  UserQuery::create()->findOneByFbId($this->fbUserId);

		$this->getResponse()->setSlot('selected_week', $request->getParameter('week'));
		
		$week = $request->getParameter('week');
		if(!$week){
			$week = 'total';
		}
		$currentWeek = myFunctions::getCurrentWeek();

	  	switch ($week) {
		case 'total':
    		$findUser = PlayerStatusQuery::create()->orderByFlightmilesTotal('desc')->filterByUserId($user->getId())->findOne();
		    $ranking = PlayerStatusQuery::create()->filterByFlightmilesTotal($findUser->getFlightmilesTotal(), Criteria:: GREATER_EQUAL)->count();
		    $firstId = PlayerStatusQuery::create()->orderByFlightmilesTotal('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::FLIGHTMILES_TOTAL);
		    $c->add(PlayerstatusPeer::FLIGHTMILES_TOTAL, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::FLIGHTMILES_TOTAL, 0, Criteria::NOT_EQUAL);
    		break;
		case 1:
		    $findUser = PlayerStatusQuery::create()->orderByWeek1('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek1('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
			
			if($findUser->getWeek1() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek1($findUser->getWeek1(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK1);
		     $c->add(PlayerstatusPeer::WEEK1, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK1, 0, Criteria::NOT_EQUAL);
		    break;
		case 2:
		    $findUser = PlayerStatusQuery::create()->orderByWeek2('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek2('desc')->findOne()->getUserId();
		     $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
			if($findUser->getWeek2() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek2($findUser->getWeek2(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK2);
		      $c->add(PlayerstatusPeer::WEEK2, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK2, 0, Criteria::NOT_EQUAL);
		    break;
		case 3:
		    $findUser = PlayerStatusQuery::create()->orderByWeek3('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek3('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
			if($findUser->getWeek3() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek3($findUser->getWeek3(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK3);
		      $c->add(PlayerstatusPeer::WEEK3, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK3, 0, Criteria::NOT_EQUAL);
		    break;
		case 4:
		    $findUser = PlayerStatusQuery::create()->orderByWeek4('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek4('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
			if($findUser->getWeek4() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek4($findUser->getWeek4(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK4);
		      $c->add(PlayerstatusPeer::WEEK4, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK4, 0, Criteria::NOT_EQUAL);
		    break;
		case 5:
		    $findUser = PlayerStatusQuery::create()->orderByWeek5('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek5('desc')->findOne()->getUserId();
 			$first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
		    if($findUser->getWeek5() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek5($findUser->getWeek5(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK5);
		    $c->add(PlayerstatusPeer::WEEK5, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK5, 0, Criteria::NOT_EQUAL);
		    break;
		case 6:
		    $findUser = PlayerStatusQuery::create()->orderByWeek6('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek6('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
		    if($findUser->getWeek6() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek6($findUser->getWeek6(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK6);
		    $c->add(PlayerstatusPeer::WEEK6, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK6, 0, Criteria::NOT_EQUAL);
		    break;
		case 7:
		    $findUser = PlayerStatusQuery::create()->orderByWeek7('desc')->filterByUserId($user->getId())->findOne();
		    $firstId = PlayerStatusQuery::create()->orderByWeek7('desc')->findOne()->getUserId();
		    $first = UserQuery::create()->findOneById($firstId);
		    $this->first = $first;
		    if($findUser->getWeek7() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek7($findUser->getWeek7(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK7);
		    $c->add(PlayerstatusPeer::WEEK7, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK7, 0, Criteria::NOT_EQUAL);
		    break;
		case 8:
		    $findUser = PlayerStatusQuery::create()->orderByWeek8('desc')->filterByUserId($user->getId())->findOne();
		    if($findUser->getWeek8() != NULL){
				$ranking = PlayerStatusQuery::create()->filterByWeek8($findUser->getWeek8(), Criteria:: GREATER_EQUAL)->count();
			} else {
				$ranking = 0;
			}
			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::WEEK8);
		    $c->add(PlayerstatusPeer::WEEK8, null, Criteria::NOT_EQUAL);
		    $c->add(PlayerstatusPeer::WEEK8, 0, Criteria::NOT_EQUAL);
		    break;
		default:
			$findUser = PlayerStatusQuery::create()->orderByFlightmilesTotal('desc')->filterByUserId($user->getId())->findOne();
		    $ranking = PlayerStatusQuery::create()->filterByFlightmilesTotal($findUser->getFlightmilesTotal(), Criteria:: GREATER_EQUAL)->count();

			$c = new Criteria();
		    $c->addDescendingOrderByColumn(PlayerstatusPeer::FLIGHTMILES_TOTAL);
    		break;    
		}
	
	    $max= sfConfig::get('sf_pager_max_items');
		
	    if($ranking != 0){
			if($ranking%$max != 0){
				$userPage = (int)($ranking/$max)+1;
			} else {
				$userPage = (int)($ranking/$max);
			}
			$this->userPage = $userPage;
	    } else {
	    	$this->userPage = 1;
	    }
	    
	    $pager = new sfPropelPager('Playerstatus', $max);
	    $pager->setCriteria($c);
	    $pager->setPage($this->getRequestParameter('page', $userPage));
	  	$pager->setParameter('week', $week);
	    $pager->init();
	    $this->pager = $pager;
		
	    $homeId = LocationQuery::create()->findOneById($user->getLocationId())->getId();
		if($findUser->getFlightCount() > 0) {
		 	$flightQuery = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		 	$currentLocation = $flightQuery->getTargetLocationId();
		 } else {
		 	$currentLocation = $homeId;
		 }
		$this->currentLocation = LocationQuery::create()->findOneById($currentLocation)->getLocationName();
		$this->homebase = LocationQuery::create()->findOneById($user->getLocationId())->getLocationName();
		$this->getStatus = $findUser;
		$this->user = $user;		
		$this->currentWeek = $currentWeek;	
		$this->ranking = $ranking;
	

		if($findUser->getOnFlight() == true){
			$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
			$startLocationId = $latestFlight->getStartLocationId();
			$targetLocationId = $latestFlight->getTargetLocationId();
	
			
			$this->arrival = $latestFlight->getFlightEnd();
			$this->duration = $latestFlight->getFlightDuration();
			$this->startLocation =  LocationQuery::create()->findOneById($startLocationId);
			$this->targetLocation = LocationQuery::create()->findOneById($targetLocationId);
				
			$start = array($this->startLocation->getLat(), $this->startLocation->getLng());
			$end = array($this->targetLocation->getLat(), $this->targetLocation->getLng());
			$this->distance = myLocationActions::calculateDistance($start, $end);
		}
		//$this->user = $user;
		//$this->getStatus = $getStatus;
	    
	}	
	
	public function executeGameinfo(sfWebRequest $request)
	{
		$this->fbUserId =  parent::getValidFbUser();
		$user =  UserQuery::create()->findOneByFbId($this->fbUserId);
		$findUser = PlayerStatusQuery::create()->filterByUserId($user->getId())->findOne();
	 	$homeId = LocationQuery::create()->findOneById($user->getLocationId())->getId();
		if($findUser->getFlightCount() > 0) {
		 	$flightQuery = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
		 	$currentLocation = $flightQuery->getTargetLocationId();
		 } else {
		 	$currentLocation = $homeId;
		 }
		$this->currentLocation = LocationQuery::create()->findOneById($currentLocation)->getLocationName();
		$this->homebase = LocationQuery::create()->findOneById($user->getLocationId())->getLocationName();
		$this->getStatus = $findUser;
		$this->user = $user;
		
		if($findUser->getOnFlight() == true){
			$latestFlight = FlightQuery::create()->filterByUserId($user->getId())->orderByFlightStart('desc')->findOne();
			$startLocationId = $latestFlight->getStartLocationId();
			$targetLocationId = $latestFlight->getTargetLocationId();
	
			
			$this->arrival = $latestFlight->getFlightEnd();
			$this->duration = $latestFlight->getFlightDuration();
			$this->startLocation =  LocationQuery::create()->findOneById($startLocationId);
			$this->targetLocation = LocationQuery::create()->findOneById($targetLocationId);
				
			$start = array($this->startLocation->getLat(), $this->startLocation->getLng());
			$end = array($this->targetLocation->getLat(), $this->targetLocation->getLng());
			$this->distance = myLocationActions::calculateDistance($start, $end);
		}
	}
	
	public function executeDestinations(sfWebRequest $request)
	{
	}
	
	
	/**
	 * Nur für Übersichtskarte
	 */
	public function executeMarkers(){
		$q = LocationQuery::create()->filterBySwissDestination(1)->find();
		
		$markers = array();
		foreach ($q as $query){
			$marker = new stdClass();
			$marker->location = $query->getLocationName();
			$marker->lat = $query->getLat();
			$marker->lng = $query->getLng();
			
			array_push($markers, $marker);
		}
		
		echo json_encode($markers);
	}
	
	public function executeForeign(){
		/*$q = LocationQuery::create()->filterByForeignDestination(1)->find();
		
		$markers = array();
		foreach ($q as $query){
			$marker = new stdClass();
			$marker->location = $query->getLocationName();
			$marker->lat = $query->getLat();
			$marker->lng = $query->getLng();
			
			array_push($markers, $marker);
		}
		
		echo json_encode($markers);*/
	}
}
