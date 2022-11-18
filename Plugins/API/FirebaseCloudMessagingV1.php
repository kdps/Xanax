<?php

namespace Xanax\Plugin;

use Xanax\Classes\ClientURL;
use Xanax\Classes\Data\StringHandler;

class FirebaseCloudMessagingV1 {

	private $ServerApiKey;
    private $RequestUrl;

	public function __construct() {
        $this->ServerApiKey = '949740214663';
		$this->RequestUrl = 'https://fcm.googleapis.com/v1/projects/flutterapp-b80f3/messages:send';
	}

    public function getToken() {	
        $headers = array(
            sprintf("Authorization: Bearer %s", $this->ServerApiKey),
            'Content-Type: application/json'
        );

        $url = 'https://iamcredentials.googleapis.com/v1/flutterapp-b80f3:generateAccessToken';
    
        $cURL = new ClientURL();
		$cURL->Option->setURL($url)
					 ->setPostMethod(true)
					 ->setHeaders($headers)
					 ->setPostField(json_encode(array('Content')))
					 ->setReturnTransfer(true)
					 ->setAutoReferer(true)
					 ->setReturnHeader(false)
					 ->disableCache(true);

		$result = $cURL->Execute();

        echo print_r($result);
    }

    public function send() {		
        $headers = array(
            sprintf("Authorization: Bearer %s", $this->ServerApiKey),
            'Content-Type: application/json'
        );

		$postData = array(
			"topic" => "test",
            "notification" => array(
                "title" => "test",
                "body" => "test"
            ),
            "data" => array(
                "test" => "test"
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

        echo print_r($result);
    }
}