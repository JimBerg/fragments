<?php 
/** 
 * 
 * Geocode API requests...
 * @author jimberg
 * @var 
 * @method ....
 * 
 */

class myLocationActions
{

	/** 
	 * Prüft ob friendlocation bereits in DB vorhanden
	 */

	public static function checkGeocodes($locations)
	{
		$geoRequest = array();
		$setDestination = array();
		foreach($locations as $location){
			if(!$friendlocation = LocationQuery::create()->orderByLocationName('desc')->findOneByLocationName($location)) {

			$geoCodes = self::getGoogleGeocodes($location);
			//$geoCodes = self::getGoogleGeocodes($location);
//			if (!$geoCodes) continue; //didn't find friend location
				$geoCodes = explode(",",$geoCodes);
	    		$lat = $geoCodes[2];
		    	$lng = $geoCodes[3];
//			$country = explode(",",$location);*/
		    	
		    	//$country = $geoCodes['country'];
		    	//$lat = $geoCodes['lat'];
		    	//$lng = $geoCodes['lng'];
		    	
				//neuer Eintrag in DB
		    	$friendlocation = new Location();
		    	$friendlocation->setLocationname($location);
//		    	//if(isset($country[1])) {
//		    		//$friendlocation->setCountry($country);
//				//}
		    	$friendlocation->setLat($lat);
		    	$friendlocation->setLng($lng);
		    	//$friendlocation->setCountry($country);
                //$friendlocation->setSwissDestination(1);
		    	//$friendlocation->setForeignDestination(1);
		    	$friendlocation->save();
		    	
		    	array_push($setDestination, $friendlocation);
			}
		}
		foreach ($setDestination as $location){
			//nearest
		    $nearest = self::nearestDestination($location);
		}
	}
	
	/** 
	 * Geocoding Request an google-api
	 * limitiert auf 2500
	 */
	protected static function getGoogleGeocodes($location){
		$url = "http://maps.google.com/maps/geo?q=".urlencode($location)."&output=csv";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public static function getGeocodes($location)
	{
		if (1) //for now we will use only the yahoo geocoding
		{//yahoo geocoding
			$data = self::getYahooGeocodes($location, 'WCPeUe44');
			if (!$data) return false;
			if (!isset($data['ResultSet'])) return false;
			if ($data['ResultSet']['Error']) return false;
			if (!isset($data['ResultSet']['Result'])) return false;
			if (!isset($data['ResultSet']['Result'][0])) return false;

			$lat = $data['ResultSet']['Result'][0]['latitude'];
			$lng = $data['ResultSet']['Result'][0]['longitude'];
			$country = $data['ResultSet']['Result'][0]['level0'];
		}
		else
		{ //google geocoding
		$data = getGoogleGeocodes($location);

		$code = json_decode($data);
		$country = $code->Placemark[0]->AddressDetails->Country->CountryName;
		$lat = $code->Placemark[0]->Point->coordinates[1];
		$lng = $code->Placemark[0]->Point->coordinates[0];
		}
		
		return array('country'=>$country,
			'lat'=>$lat,
			'lng'=>$lng);
	}
	
	/** 
	 * Geocoding Request an  yahoo-api
	 * limitiert auf 50000
	 * WOO HOO - the new yahoo api provides up to 50000 requests per day
	 */
	public static function getYahooGeocodes($location, $app_id=NULL){
		//http://where.yahooapis.com/geocode?q=1600+Pennsylvania+Avenue,+Washington,+DC&appid=[yourappidhere]
		$api_gateway = "http://where.yahooapis.com/geocode";
		//for
		$app_str = ( $app_id )? "appid=" . $app_id : "appid=wwDzWD32";
		$location_str = "location=" . urlencode($location);
		$flags_str = "flags=PG";
	
		$request = $api_gateway . "?" . $app_str . "&" . $location_str . "&" . $flags_str;
	
		$response = @file_get_contents($request);
                
		if($response){
			$result = unserialize(file_get_contents($request));
		} else {
			$result = FALSE;
		}
		return $result;
	}
	
	public static function haversine($phi){
		return pow(sin($phi/2), 2);
   	}
        
	public static function calculateDistance($start, $end) 
	{
		//Haversine Funktion für Abstände auf Kugeloberfläche
		// Erdradius in miles
        $radius = 3963.19;
   		
        // im Bogenmass
   	    $start_lat =deg2rad($start[0]);
   		$start_lng =deg2rad($start[1]);
   		
   		$end_lat =deg2rad($end[0]);
   		$end_lng =deg2rad($end[1]);
	
   		$delta_lat = $end_lat - $start_lat;
 		$delta_lng = $end_lng - $start_lng;

 		return $distance = 2*$radius * asin(sqrt(self::haversine($delta_lat)+cos($start_lat)*cos($end_lat)*self::haversine($delta_lng)));
	}
	
	/** 
	 * @param array mit lat,lng Werten, verfügbare Meilenzahl
	 */
	public static function checkDistance($startLocation, $endLocation, $availableMiles)
	{
		$distance = self::calculateDistance($startLocation, $endLocation); 
		if(($distance <= $availableMiles) && ($distance > 15)){
			$reachable = true;
		} else {
			$reachable = false;
		}
		return $reachable;
	}
	
	public static function nearestDestination($location) {
		$start = array($location->getLat(),$location->getLng());
		$destinations = LocationQuery::create()->add(LocationPeer::SWISS_DESTINATION, '1', Criteria::EQUAL)->addOr(LocationPeer::FOREIGN_DESTINATION, '1', Criteria::EQUAL)->find();
		$nearestDest = array();
		
		foreach($destinations as $destination){
			$end = array($destination->getLat(),$destination->getLng());
			$distance = self::calculateDistance($start, $end);
			array_push($nearestDest, array('distance' => $distance, 'id' => $destination->getId()));
		}
		asort($nearestDest);
		$nearest = array_shift($nearestDest);
		$setDestination = LocationQuery::create()->findOneById($location->getId());
		$setDestination->setNearestDestination($nearest['id']);
		$setDestination->save();
	}
	
	/**
	 * alle Swissdestinations auslesen -> diese sind Mittelpunkt für die Cluster
	 * ausserdem Distanz prüfen
	 */
	public static function getSwissDestinations($currentLatLng, $playerStatus, $userId)
	{	
		$getDestinations = LocationQuery::create()->filterBySwissDestination('1')->find();
		$availableMiles = $playerStatus->getAvailableMiles();
			
		$reachableSwiss = array();
		$notReachableSwiss = array();
		
		foreach ($getDestinations as $value) {
			
			
			/**
			 * Kriterium: Location im Gesamten max. 5 mal angeflogen
			 */
			$maxFlight = FlightQuery::create()->filterByUserId($userId)->filterByTargetLocationId($value->getId())->count();
			if($maxFlight > 4) {
				$check = false;
			} else {
				$point2 =  array($value->getLat(), $value->getLng());
		   		$check = myLocationActions::checkDistance($currentLatLng, $point2, $availableMiles);
		   		
				$latestFlight = FlightQuery::create()->filterByUserId($userId)->orderByFlightStart('desc')->limit(2)->find();
				foreach($latestFlight as $flight){
					if($value->getId() == $flight->getTargetLocationId()){
						$check = false;
					}
				}
			}	

	   		if($check == true) {
	   			$swissDest = new stdClass();
	   			$swissDest->destination = $value->getId();
	   			$swissDest->location = $value->getLocationName();
	   			$swissDest->lat = $value->getLat();
	   			$swissDest->lng = $value->getLng();
	   			$swissDest->airportType= 'swissDest';
	   			$swissDest->reachable= 'reachable';
				array_push($reachableSwiss, $swissDest);
	   		} else {
	   			$swissDest = new stdClass();
	   			$swissDest->destination = $value->getId();
	   			$swissDest->location = $value->getLocationName();
	   			$swissDest->lat = $value->getLat();
	   			$swissDest->lng = $value->getLng();
	   			$swissDest->airportType= 'swissDest';
	   			$swissDest->reachable= 'notReachable';
				array_push($notReachableSwiss, $swissDest);
	   		}
		}
	   		
		$swissDestinations = array($reachableSwiss, $notReachableSwiss);
		return $swissDestinations;
	}	
	
	/**
	 * alle Foreigndestinations auslesen und Distanz zu aktuellem Ort prüfen
	 */
	public static function getForeignDestinations($currentLatLng, $playerStatus, $userId)
	{	
		$getDestinations = LocationQuery::create()->filterByForeignDestination('1')->find();
		$availableMiles = $playerStatus->getAvailableMiles();
			   		
		$reachableForeign = array();
		$notReachableForeign = array();
		
		foreach ($getDestinations as $value) {
			$point2 =  array($value->getLat(), $value->getLng());
	   		$check = myLocationActions::checkDistance($currentLatLng, $point2, $availableMiles);
			
	   		if($check == true) {
	   			$foreignDest = new stdClass();
	   			$foreignDest->destination = $value->getId();
	   			$foreignDest->location = $value->getLocationName();
	   			$foreignDest->lat = $value->getLat();
	   			$foreignDest->lng = $value->getLng();
	   			$foreignDest->airportType= 'foreignDest';
	   			$foreignDest->reachable= 'reachable';
				array_push($reachableForeign, $foreignDest);
	   		} else {
	   			$foreignDest = new stdClass();
	   			$foreignDest->destination = $value->getId();
	   			$foreignDest->location = $value->getLocationName();
	   			$foreignDest->lat = $value->getLat();
	   			$foreignDest->lng = $value->getLng();
	   			$foreignDest->airportType= 'foreignDest';
	   			$foreignDest->reachable= 'notReachable';
				array_push($notReachableForeign, $foreignDest);
	   		}
		}
		$foreignDestinations = array($reachableForeign, $notReachableForeign);
		return $foreignDestinations;
	}	
	
	public static function calcDuration($miles) {
		//Dauer berechnen: Langstrecken 600km/h || Kurzstrecken 400km/h || Mittelstrecken 500km/h
		//in miles
		if($miles <= 500) {
			$v = 248;
		} else if($miles <= 1500) {
			$v = 310;
		} else {
			$v = 372;
		}
		return $duration = (($miles)/$v)*3600; //in Sekunden
	}
	
	public static function formattedTime($duration) {
		$h = floor($duration/3600); 
		$duration -= $h * 3600; 
		$m = floor($duration/60); 
		$duration -= $m * 60; 
		return sprintf("%02d:%02d:%02d", $h, $m, $duration); 
	}
	
	public static function arrivalIn($arrival, $current) {
		$arrivalSec = strtotime($arrival);
		$duration = $arrivalSec - $current;
		
		$h = floor($duration/3600); 
		$duration -= $h * 3600; 
		$m = floor($duration/60); 
		$duration -= $m * 60; 
		return sprintf("%02d:%02d:%02d", $h, $m, $duration); 
	}
	
	public static function readLocationFile(){

	//$handle = fopen ("http://fly-to-your-friends.ch.m10w0311.sui-inter.net/media/csv/CZ.csv","r");   
	while ( ($data = fgetcsv ($handle, 1000, "	")) !== FALSE ) { 

		if(!$friendlocation = LocationQuery::create()->findOneByLocationName($data[1])) {
		        $friendlocation = new Location();
		    	/*$friendlocation->setLocationName($data[5]);
		    	$friendlocation->setLat(floatval($data[3]));
		    	$friendlocation->setLng(floatval($data[2]));
		    	//$friendlocation->setForeignDestination(1);*/
		        
		        $friendlocation->setLocationName($data[1]);
		    	$friendlocation->setLat(floatval($data[4]));
		    	$friendlocation->setLng(floatval($data[5]));
		    	//$friendlocation->setForeignDestination(1);
		    	//$friendlocation->save();
		    	//$nearest = self::nearestDestination($friendlocation);
		}
	}
	fclose ($handle);
	}

	
	public static function flughafenSetzen(){
	
		$setDestination = array();
		$locations = LocationQuery::create()->filterByNearestDestination(NULL)->limit(10000)->find();
		//$locations = LocationQuery::create()->filterByNearestDestination(NULL)->filterByLat(array('min'=>45.0, 'max'=>55.0))->filterByLng(array('min'=>5.0, 'max'=>10.0))->limit(1000)->find();
		
		foreach($locations as $result){
			 $nearest = self::nearestDestination($result);
			 //$result->setNearestDestination(10);
			 //$result->save();
		}
	}
	
	public static function readDestinations(){
		$getDestinations = LocationQuery::create()->filterBySwissDestination('1')->find();
		foreach($getDestinations as $value) {
		if(!$dest = DestinationQuery::create()->filterByLocationName($value->getLocationName())->findOne()) {
				$dest = new Destination();
				$dest->setLocationId($value->getId());
				$dest->setLocationName($value->getLocationName());
				//$dest->save();
			}
		}
	
	}
	
	
	public static function resetLocations(){
		$getDestinations = LocationQuery::create()->filterByLat('0')->filterByLng('0')->find();
		
		foreach($getDestinations as $value) {
			$location =$value->getLocationName();
			$data = self::getYahooGeocodes( $location, 'WCPeUe44');
			/*if (!$data) return false;
			if (!isset($data['ResultSet'])) return false;
			if ($data['ResultSet']['Error']) return false;
			if (!isset($data['ResultSet']['Result'])) return false;
			if (!isset($data['ResultSet']['Result'][0])) return false;*/

			$lat = $data['ResultSet']['Result'][0]['latitude'];
			$lng = $data['ResultSet']['Result'][0]['longitude'];

	    	$value->setLat($lat);
	    	$value->setLng($lng);
	    	$value->save();

	    	$nearest = self::nearestDestination($value);
		    
		}
		
		
	
	}

}