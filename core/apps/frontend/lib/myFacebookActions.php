<?php

/** 
 * 
 * Facebook Authentifizierung, Sessioncheck, Permission Check
 * @author jimberg
 * @var Object facebook, ..., 
 * @method ....
 * 
 */

class myFacebookActions extends sfActions 
{
	/** 
	* Facebook-Schnittstelle, neues FB-Objekt instanzieren falls nicht vorhanden 
 	* Konstanten: String FB-API Key, String FB-Secret-Key (aus SF-Settings)
 	* @return Object $facebook, Facebook Objekt
	*/
 	protected function getFacebook()
  	{
  		if(!$this->facebook) {
		  	$this->facebook = new myFacebook(array(
		  		'appId'  => sfConfig::get('sf_fb_app_id'),
		  		'secret' => sfConfig::get('sf_fb_secret'),
		  		'cookie' => true,
			));
  		}
		return $this->facebook;
  	}
  	
	public function checkValidUser(){
  		$signedRequest = self::getFacebook()->getSignedRequest();
		$user = $this->getFacebook()->getUser();
		
		if($signedRequest || $user) {
			//return $signedRequest;
	  		$user = $this->getFacebook()->getUser();
			if ($user) { //prüfen auf Gültigkeit
				try {
					$validUser = $this->getFacebook()->api('/me');
				} catch (FacebookApiException $e) {
					$this->logMessage($e->getMessage()." registration - no valid user");
					return false;
				}
				return $validUser['id'];
			}
			else //keine gültige user session
				//$this->logMessage("registration - no valid session");
				return false;
				
		} else {
			//neuer benutzer
			return false;
			
		}
  	}
  	
	public function getValidFbUser() 
  	{
		$loginUrlBase = $this->getFacebook()->getLoginUrl(array(
			'redirect_uri' =>sfConfig::get('sf_fb_url'),
			'scope' => 'publish_stream, email, friends_location, user_location'
		));
		
		$user = $this->getFacebook()->getUser();
		if ($user) {
			try {
				$user = $this->getFacebook()->api('/me');
			} catch (FacebookApiException $e) {
				die("<script type='text/javascript'>top.location.href = '".$loginUrlBase."';</script>");
			}
		} else {
			die("<script type='text/javascript'>top.location.href = '".$loginUrlBase."';</script>");
		}
		return $user['id'];
  	}
  	
	protected function createAppUser($userId)
	{
	 	//Facebook User gemäss UID holen
	 	//$userId = $user['id'];
		$fbUserResponse = $this->getFacebook()->api($userId);
		
		 //Usereintrage erzeugen - Freundesliste zu User zuordnen
		if(isset($fbUserResponse['id'])) {
		if($fbUserResponse['location']['name'] != NULL) {
		//Freundeslocations holen
		$friends = $this->getFriends();
		
		if(($friends != NULL) && ($friends != '')){
			$friendslocations = $this->getFriendsLocation($friends);
			//Geocodierungsanfragen senden mit allen Locations
			myLocationActions::checkGeocodes($friendslocations);
		}
		
		//$isFan = $this->checkIfIsFan($fbUserResponse['id']);
		$userlocation = LocationQuery::create()->findOneByLocationName($fbUserResponse['location']['name']);
		//neuen User
		$user = new User();
		$user->setFbId($fbUserResponse['id']);
		//$user->setAccessToken($fbUserResponse['offline_access']);
		$user->setFirstname($fbUserResponse['first_name']);
		$user->setLastname($fbUserResponse['last_name']);
		$user->setEmail($fbUserResponse['email']);
		$user->setIsFan(0);
		$user->setInactiveNotification(0);
		$user->setLocationId($userlocation->getId());
		$user->save();
		
		//neue Freundesliste
		$friendlist = new Friendlist();
		$friendlist->setUserId($user->getId());
		$friendlist->save();
		
		//Freunde anlegen
		if($friends != NULL){
			$this->createFriends($friends, $friendlist->getId());
		}
		}
		else {
			$user = NULL;
		}
	   }
	   return $this->user = $user;	
    }

   protected function checkIfIsFan($userId)
   {
	/**
	* @todo: swiss page => ist pageID
	*/
	   //$pageId = sfConfig::get('sf_fb_app_id');
	   //$pageId = '215354111826169';
	   $pageId = '16565655722';
		   $result = $this->getFacebook()->api(array(
			"method" => "fql.query",
			"query" => "SELECT uid FROM page_fan WHERE uid=$userId AND page_id=$pageId"
		));

		if(count($result)) {
			$isFan = true;
	   	} else {
	   		$isFan = false;
	   	}
   		return $isFan;
   }
  
   public function getFriends()
   {
   		$friends = $this->getFacebook()->api(array(
			'method' => 'fql.query',
			'query' => 'SELECT uid, name, current_location FROM user WHERE current_location AND (uid = me() OR uid IN (SELECT uid2 FROM friend WHERE uid1 = me()))')
		);
   		return $friends;
   }

   protected function getFriendsLocation($friends)
   {
	   $friendsLocations = array();
		   foreach ($friends as $key => $friend) {
		   $location = $friend['current_location']['name'];
			   if(isset($location)) {
			   array_push($friendsLocations, $location);
		   }
	   }
	   return $friendsLocations;
   }

   protected function createFriends($friends,$friendlistId)
   {
   		foreach ($friends as $key => $value) {
		if(!$friend = FriendQuery::create()->findOneByFbId($value['uid'])) {
			if ($locationId = LocationQuery::create()->findOneByLocationName($value['current_location']['name']))
			{
				$friend = new Friend();
				$friend->setFbId($value['uid']);
				$friend->setName($value['name']);
				$friend->setLocationId($locationId->getId());
				$friend->save();
			}
			} else {
				$friend = FriendQuery::create()->findOneByFbId($value['uid']);
			}
			if ($friend)
			{
				$flist_rel = new Friendrelation();
				$flist_rel->setFriendId($friend->getId());
				$flist_rel->setFriendlistId($friendlistId);
				$flist_rel->save();
			}
		}
   }
}
