<?php

include './../../../vendor/autoload.php';

use Xanax\Plugin;

class FirebaseCloudMessaging {

	private $ServerApiKey;
	private $BadgeCount = 0;
	private $Identify = 0;
	private $RegistrationIds = [];
	private $ResultData = [];
	
	public function setServerApiKey($key) {
		$this->ServerApiKey = $key;
	}
	
	public function addRegistrationId($identifier) {
		$this->RegistrationIds [] = $identifier;
	}
	
	public function getMulticastId() {
		return array_key_exists("multicast_id", $this->ResultData) ? $this->ResultData['multicast_id'] : -1;
	}
	
	public function isSuccess() {
		return array_key_exists("success", $this->ResultData) ? $this->ResultData['success'] === 1 : 0;
	}
	
	public function getResults() {
		return array_key_exists("results", $this->ResultData) ? $this->ResultData['results'] : [];
	}
	
	public function send($title, $body, $message) {
		$headers = array(
			sprintf("Authorization: key=%s", $this->ServerApiKey),
			'Content-Type: application/json'
		);
		
		$notificationContent = array(
			"title"				=> $title,
			"body" 				=> $body,
			"sound"				=> "default",
			'message'			=> $message,
			'id'				=> $this->Identify,
			'badge' 			=> $this->BadgeCount, 
		);

		$dataContent = array(
			"title"				=> $title,
			"body" 				=> $body,
			'click_action'		=> "",
			"sound"				=> "default",
			'mode'				=> "",
			'message'			=> $message,
			'id'				=> $this->Identify,
			'badge' 			=> $this->BadgeCount, 
		);

		$postData = array(
			'registration_ids'	=> $this->RegistrationIds,
			'notification'		=> $notificationContent,
			'data'				=> $dataContent,
			"priority"			=> "high",
			'content_available' => true,
			'apns' => array(
				'payload' => array(
					'aps' => array(
						'content-available' => 1
					),
				),
			)
		);

		$cURL = new ClientURL();
		$cURL->Option->setURL('https://fcm.googleapis.com/fcm/send')
					 ->setPostMethod(true)
					 ->setHeaders($headers)
					 ->setReturnTransfer(true)
					 ->setPostField(json_encode($postData))
					 ->setAutoReferer(true)
					 ->setReturnHeader(false)
					 ->disableCache(true);
					 
		$result = $cURL->Execute();
		
		$this->ResultData = json_decode($result);
	}
	
}
