<?php

namespace Xanax\Plugin;

use Xanax\Classes\ClientURL;
use Xanax\Classes\Data\StringHandler;

class FirebaseCloudMessagingV1 {

	private $ServerApiKey;
    private $RequestUrl;

	public function __construct($serverApiKey, $requestUrl) {
        $this->ServerApiKey = $serverApiKey;
		$this->RequestUrl = $requestUrl;
	}

    public function getToken($tokenUrl) {	
        $headers = array(
            sprintf("Authorization: Bearer %s", $this->ServerApiKey),
            'Content-Type: application/json'
        );

        $cURL = new ClientURL();
		$cURL->Option->setURL($tokenUrl)
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