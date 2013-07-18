<?php

/**
 * home actions.
 */
class homeActions extends myFacebookActions
{
	/* Fb Session */
	public function executeIndex(sfWebRequest $request)
	{	
		// via apprequest

		//$friendUser = $request->getParameter('friendUser'); // not a solution for eternity ;) 
		$friendRequest = $request->getParameter('request_ids');
	   	
		if(!$friendRequest){
				$friendRequest = $this->getUser()->getAttribute('request_ids');
			if ($friendRequest != NULL)
				$this->forward('home', 'friendUser');
			}
		else 
			$this->forward ('home', 'friendUser');
		
//		if($friendUser){
//			$this->forward('dashboard', 'index', array('friendUser' => 'friendUser'));
//		}
		$fb_user = parent::checkValidUser();

		if ($fb_user)
		{
			if(!$user = UserQuery::create()->findOneByFbId($fb_user)) {
				$this->forward('home', 'newUser');
			} else {
				//print_r($user);
				$this->forward('dashboard', 'index');
			}
		}
		else
			$this->forward('home', 'newUser');
	}
	public function executeSessionDestroy()
	{
		echo session_destroy();
		return sfView::NONE;
	}
	/* Template only */
	public function executeNewUser(sfWebRequest $request)
	{	
	}
	
	public function executeCreateUser(sfWebRequest $request)
	{
		$uid = $request->getParameter('uid');
		$access_token = $request->getParameter('access_token');
		//get authenticated user id
		parent::getFacebook()->setAccessToken($access_token);
		$me = parent::getFacebook()->api('/me');
		$uid = $me['id'];
		//$user = parent::getValidFbUser();
		if(!$createUser = UserQuery::create()->findOneByFbId($uid)){
			$createUser = parent::createAppUser($uid);
		}
		if ($createUser)
		{
			$this->setMiles($uid);
			return $this->renderText(json_encode(array( 'result' => 'success', 'error' => '' )));
		}
		else
			return $this->renderText(json_encode(array( 'result' => 'fail', 'error' => "<a style='color:#363636;' href='http://www.facebook.com/editprofile.php' target='_top_blank'>No location found. Please set your location in facebook and try again.</a>" )));
//		if($createUser){
//			$this->forward('home', 'setMiles');
//		} 
//		else{
//			$this->forward('dashboard', 'index');	
//		}
	}

	public function setMiles($uid)
	{	
		$user = UserQuery::create()->findOneByFbId($uid);	
		if(!$setStartMiles = PlayerstatusQuery::create()->findOneByUserId($user->getId())) {
			$setStartMiles = new Playerstatus();
			$setStartMiles->setUserId($user->getId());
			$setStartMiles->setPoints(0);
			$setStartMiles->setFlightCount(0);
			$setStartMiles->setFlightmilesTotal(0);
			$setStartMiles->setFlightmilesWeek(0);
			$setStartMiles->setAvailableMiles(2000);
			$setStartMiles->setPlayerRank('Tourist');
			//$setStartMiles->setHomebaseFlight(3);
			$setStartMiles->save();
		}
		
		//$this->forward('dashboard', 'index');
		//return $this->renderText('initial values');
	}
	
	/**
	 * Zeigt Anwendungseinladungen um auf einen Flug zu reagieren => nur so lange Flug noch aktiv
	 */
	public function executeFriendUser(sfWebRequest $request)
	{
		//$uid = $request->getParameter('uid');
		
		$uid = parent::checkValidUser();
		
		if(!$uid){
			
			$request_ids =  $request->getParameter('request_ids');
			$this->getUser()->setAttribute('request_ids', $request_ids);
			
				$this->forward('home', 'newFriendUser');
			}	
			
		else if($uid){
			//$fbUserId = parent::getValidFbUser();
			$request_ids =  $request->getParameter('request_ids');
			if (!$request_ids)
			{
				$request_ids = $this->getUser()->getAttribute('request_ids');
				$this->getUser()->getAttributeHolder()->remove('request_ids');

			}
			$request_data = parent::getFacebook()->api('/me/apprequests/?request_ids='.$request_ids);
			
			$this->request_data = $request_data['data'];
			
			/**
			* Nur Requests anzeigen, wenn Flug noch nicht vorbei
			*/
			$activeRequests = array();
			$request_datas = $request_data['data'];
			foreach($request_datas as $key => $data) {
				$flightData = FlightQuery::create()->filterByFlightAccepted($data['id'])->findOne();
				if($flightData) {
					$flightEnd = $flightData->getFlightEnd();
					$currentTime = date('Y-m-d H:i:s');
					
					if ($currentTime <= $flightEnd){
						$activeReq = $key." aktive Einladung";
					} else {
						$activeReq = $key." zu spät";
						/**
						 * dann Request aus Fb-DB löschen
						 */
						parent::getFacebook()->api($data['id'], 'delete');
						$flightData->setFlightAccepted('past');
						$flightData->save();
					}
					array_push($activeRequests, $activeReq, $currentTime, $flightEnd);
				} else {
					array_push($activeRequests, $data['id'].' - not found');
				}
			}
			$this->flightData = $activeRequests;	
		}
	}
	
	public function executeAcceptFlight(sfWebRequest $request)
	{
		$fbId = $request->getParameter('fbId');
		$accepted = $request->getParameter('accepted');
		$request_id = $request->getParameter('request_id');

		$user = UserQuery::create()->findOneByFbId($fbId);
		$appUserId = $user->getId();
		$refreshFlightStatus = FlightQuery::create()->filterByUserId($appUserId)->filterByFlightAccepted($request_id)->orderByFlightStart('desc')->findOne();
	
		if($accepted == 'accepted') {
			$refreshFlightStatus->setFlightAccepted('accepted');
			$refreshFlightStatus->save();
			parent::getFacebook()->api($request_id, 'delete');
			/**
			 * aktuell: nicht mehr ausgelöst: no permissions (?)
			 */
			/*try{
				$feed = parent::getFacebook()->api($fbId.'/feed', 'post', array(
				    'message' => "I'm so excited you\'re coming to visit me, ".$user->getFirstname().". I\'ll be at the airport to pick you up",
				    'name' => 'ftyf',
				    'description' => 'Description',
				    'caption' => 'Caption',
				    'picture' => sfConfig::get('sf_server_url').'/images/currentLocation.gif',
				    'link' => 'http://apps.facebook.com/spielplatz/'
				));
				if($feed){
					$feed_published = true;
				} else {
					throw new Exception('friend // feed can not  be published');
				}
			} catch (Exception $e){
			 	$this->logMessage($e->getMessage()."feed can not  be published => friendrequest accept: ".$userFbId);
			}*/
			
		} else {
			$refreshFlightStatus->setFlightAccepted('denied');
			$refreshFlightStatus->save();
			parent::getFacebook()->api($request_id, 'delete');
		}
		$requests = parent::getFacebook()->api("/me/apprequests", 'get');
 		foreach($requests['data'] as $item) {
			$id = $item['id'];
		 	parent::getFacebook()->api($id, 'delete');
		}
		return $this->renderText('flight reaction');
	}
	
	public function executeNewFriendUser(sfWebRequest $request){
	}

	public function executeSendWeeklyNotification() 
	{
		$userQuery = UserQuery::create()->find();
		$currentWeek = myFunctions::getCurrentWeekFormat();
		
		foreach($userQuery as $user) {
			if($user->getWeeklyNotification() != true){
				$status = PlayerstatusQuery::create()->findOneByUserId($user->getId());
				
				$mailFrom = 'ftyf@swiss.com';
		    	//$mailTo = 'janina.imberg@isuntu.com';
		    	if($user->getEmail() != ''){
		    		$mailTo = $user->getEmail();
		    	} else {
		    		continue;
		    	}
				
		    	$mailSubject = 'Weekly Update';
		  		$mailContent = $mailContent =  $this->getPartial('global/mailTemplateWeekly', array('user' => $user, 'status' => $status, 'currentWeek' => $currentWeek));	  	 	
		  			  	 	
		  		$message = Swift_Message::newInstance()
				  ->setContentType("text/html")
				  ->setFrom($mailFrom)
				  ->setTo($mailTo)
				  ->setSubject($mailSubject)
				  ->setBody($mailContent);
				
				$return = $this->getMailer()->send($message);
				if(!$return) {
					$this->logMessage('SMTP Mail nicht verschickt', 'notice');
				}
				$user->setWeeklyNotification(1);
				$user->save();
			}	
		}
		return $this->renderText('Weekly Statistic');
	}
	
	public function executeLandingNotifications() 
	{
		//WALLPOST NACH LANDUNG
		$currentTime = date('Y-m-d H:i:s');
		$flightQuery = FlightQuery::create()
			->orderByFlightEnd('desc')
			->filterByFlightEnd($currentTime, Criteria::LESS_THAN)
			->filterByLandingNotification(NULL)
			->find();
		foreach($flightQuery as $flight) {

			if($flight->getLandingNotification() != true) {
				$user= UserQuery::create()->findOneById($flight->getUserId());
				$userFbId = $user->getFbId();
				
				if($user->getInactiveNotification() != true){
				
				$locationId = LocationQuery::create()->findOneById($flight->getTargetLocationId());
				$location = LocationQuery::create()->findOneById($flight->getTargetLocationId())->getLocationName();
		  		
				// wenn swiss dest = sonst 
				if($locationId->getSwissDestination() == true){
					$picQuery = PicturesQuery::create()->filterByDestinationId($flight->getTargetLocationId())->filterByTitle('feed_landing')->findOne();
					$pic = $picQuery->getPath();
				} else {
					$pic = "fb_feed-icon.png";
				}
				
				// Abfangen: ob post möglich
				$api_call = array(
			        'method' => 'users.hasAppPermission',
			        'uid' => $userFbId,
			        'ext_perm' => 'publish_stream'
			    );
			    $can_post = $this->getFacebook()->api($api_call);
			    
			    if($can_post){
			    	try {			    		
				    	$feed = parent::getFacebook()->api('/'.$userFbId.'/feed', 'post', array(
						    //'message' => 'On my virtual travels around the world I\'ve just arrived in '.$location.'. Have you seen that city yet?',
						    'name' => 'Fly to your Friends',
						    'description' => 'Get ready to say goodbye to cyberhugs and hello to some real human contact. Get in touch with your friends, plan your trip and fly around the world, collect miles and win a “Round the World Ticket”.',
						    'caption' => 'I‘ve just landed in '.$location.'.',
						    'picture' => sfConfig::get('sf_server_url').'uploads/locationPics/'.$pic,
						    'link' => 'http://apps.facebook.com/fly-to-your-friends/'
						));
						if($feed){
							$feed_published = true;
						} else {
							throw new Exception('feed can not  be published  => landing: '.$userFbId);
						}
			    	} catch (Exception $e){
			    		$this->logMessage($e->getMessage(), 'notice');
			    		$flight->setLandingNotification(0); 
						$flight->save();
			    		//continue;
			    	}
			        
			    } else {
			   		$this->logMessage('no permissions to publish feed: '.$userFbId, 'notice');
			   		$flight->setLandingNotification(0); 
					$flight->save();
			   		//continue;
			        //die('Permissions required!');
			    }
			    
			    //EMAIL NACH LANDUNG
				$mailFrom = 'fly-to-your-friends@swiss.com';
		    	$mailTo = $user->getEmail();
		    	
		    	$mailSubject = 'Fly to your Friends by SWISS';
		  		$mailContent =  $this->getPartial('global/mailTemplateLanding', array('user' => $user, 'location' => $location, 'flight' => $flight));	  	 	
		  		$message = Swift_Message::newInstance()
				  ->setContentType("text/html")
				  ->setFrom($mailFrom)
				  ->setTo($mailTo)
				  ->setSubject($mailSubject)
				  ->setBody($mailContent);
				
				$return = $this->getMailer()->send($message);
				if(!$return) {
					$this->logMessage('SMTP Mail nicht verschickt: '.$userFbId, 'notice');
					$flight->setLandingNotification(0); 
					$flight->save();
					continue;
				}
				
				$flight->setLandingNotification(1); 
				$flight->save();
				}
			}
		}
		return $this->renderText('Landing Notifications');			
	}
	
	public function executeMailTest(){

		$mailFrom = 'quiz@swiss.com';
    	$mailTo = 'janina.imberg@isuntu.com';
    	
    	$mailSubject = 'testmail';
  		
  		//$mailContent = $this->getPartial('global/mailTemplate');	 
  		$mailContent = "Blabla"; 	 
  		$message = Swift_Message::newInstance()
		  ->setContentType("text/html")
		  ->setFrom($mailFrom)
		  ->setTo($mailTo)
		  ->setSubject($mailSubject)
		  ->setBody($mailContent);
		
		$return = $this->getMailer()->send($message);
		if(!$return) {
			$this->logMessage('SMTP Mail nicht verschickt', 'notice');
		}
		
		return $this->renderText('everythings fine');
	}
	
	public function executeDeactivateNotification(sfWebRequest $request)
	{
		$fbId = $request->getParameter('userId');
		$deactivate = UserQuery::create()->findOneByFbId($fbId);
		$deactivate->setInactiveNotification(true);
		$deactivate->save();
		
		$this->forward('dashboard', 'index');
		//return $this->renderText('Mail Benachrichtigung abgestellt');
	}
	
}

