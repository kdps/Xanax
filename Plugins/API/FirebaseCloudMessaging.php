<?php

include './../../../vendor/autoload.php';

use Xanax\Classes\ClientURL;

class FirebaseCloudMessaging {

	public function sendMessage($registrationIds, $data, $title, $body) {
		$fields = array(
			'registration_ids'  => $registrationIds,
			'data'              => $data,
			'content_available' => true,
			'priority'          => 'high',
			'notification'      => array(
				"title" => $title, 
				"body" => $body, 
				"sound" => "default"
			)
		);

		$headers = array(
			'Authorization: key=',
			'Content-Type: application/json'
		);

		$ch = curl_init();

		$cURL = new ClientURL();
		$cURL->Option->setURL('https://fcm.googleapis.com/fcm/send');
		
		/*curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		curl_close($c);*/

		return $result;
	}

	public function sendToChannel($token, $title, $body, $channelIdentify, $clickAction) {
		$postData = array(
			'to' => $token,
			'notification' => array(
				'title' => $title,
				'body' => $body,
				'android_channel_id' => $channelId,
				'click_action' => $clickAction
			)
		);

		$headers = array(
			'Authorization: key=',
			'Content-Type: application/json'
		);

		$cURL = new ClientURL();
		$cURL->Option->setURL('https://fcm.googleapis.com/fcm/send');
		
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
		$result = curl_exec($ch);
		curl_close($c);*/

		return $result;
	}

}
