<?php

namespace Xanax\Plugin;

use Xanax\Classes\ClientURL;
use Xanax\Classes\Data\StringHandler;

class FirebaseCloudMessaging {

	private $ServerApiKey;
	private $BadgeCount = 0;
	private $Identify = 0;
	private $RegistrationIds = [];
	private $ResultData = [];
	private $RequestUrl = "";
	private $ClickAction = "";
	private $Sound = "default";
	private $DataContent = array();
	private $NotificationContent = array();
	private $Topic = '';

	public function __construct() {
		$this->RequestUrl = "https://fcm.googleapis.com/fcm/send";
	}

	public function setDataContent($dataContent) {
		if (is_array($dataContent)) {
			$this->DataContent = $dataContent;
		}
	}

	public function setNotificationContent($notificationContent) {
		if (is_array($notificationContent)) {
			$this->NotificationContent = $notificationContent;
		}
	}

	public function setTopic($topic) {
		$this->Topic = $topic;
	}

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

	public function setClickAction($clickAction) {
		$this->ClickAction = $clickAction;
	}

	public function getResults() {
		return $this->ResultData->results;
	}

	public function setBadgeCount($count) {
		$this->BadgeCount = $count;
	}

	public function send($title, $body, $message) {
		$headers = array(
			sprintf("Authorization: key=%s", $this->ServerApiKey),
			'Content-Type: application/json'
		);

		$notificationContent = array(
			"title"					=> $title,
			"body" 					=> $body,
			"sound"					=> $this->Sound,
			'message'				=> $message,
			'id'					=> $this->Identify,
			'badge' 				=> $this->BadgeCount,
		);

		$notificationContent = array_merge($notificationContent, $this->NotificationContent);

		$dataContent = array(
			"title"					=> $title,
			"body" 					=> $body,
			'click_action'			=> $this->ClickAction,
			"sound"					=> $this->Sound,
			'mode'					=> "",
			'message'				=> $message,
			'id'					=> $this->Identify,
			'badge' 				=> $this->BadgeCount,
		);

		$dataContent = array_merge($dataContent, $this->DataContent);

		$postData = array(
			//'registration_ids'		=> $this->RegistrationIds,
			'to'					=> $this->Topic,
			'notification'			 => $notificationContent,
			'data'					=> $dataContent,
			"priority"				=> "high",
			'content_available' 	=> true,
			'apns' => array(
				'payload' => array(
					'aps' => array(
						'content-available' => 1
					),
				),
			)
		);

		$cURL = new ClientURL();
		$cURL->Option->setURL($this->RequestUrl)
					 ->setPostMethod(true)
					 ->setHeaders($headers)
					 ->setReturnTransfer(true)
					 ->setPostField(json_encode($postData))
					 ->setAutoReferer(true)
					 ->setReturnHeader(false)
					 ->disableCache(true);

		$result = $cURL->Execute();

		$stringHandler = new StringHandler();
		$isJson = $stringHandler->isJson($result);

		echo print_r($result);

		if ($isJson) {
			$this->ResultData = json_decode($result);
		}
	}

}
