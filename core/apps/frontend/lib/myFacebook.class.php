<?php 

class myFacebook extends Facebook
{

	public function makeRequest($url, $params, $ch=null) {
		return parent::makeRequest($url, $params, $ch);
	}
	
	public function parseSignedRequest($signed_request) {
		return parent::parseSignedRequest($signed_request);
	}
	
	public function createSessionFromSignedRequest($data) {
		return parent::createSessionFromSignedRequest($data);
	}
}