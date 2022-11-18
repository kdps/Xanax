<?php

include './../../vendor/autoload.php';

use Xanax\Classes\ClientURL;

$cURL = new ClientURL();
$cURL->Option->setURL('http://www.computerusermanual.com/')
			 ->setReturnTransfer(true);

$html = $cURL->Execute();

echo $html;



$cURL = new ClientURL();
$cURL->Option->setURL('http://localhost:8090/api')
             ->setPostMethod(true)
             ->setContentTypeJson()
             ->setAcceptXml()
             ->setPostField(json_encode(array(
                'username' => 'youngjin.kwak@nam.info',
                'password' => '1111'
               )))
			 ->setReturnTransfer(true);

$html = $cURL->Execute();
$headers = $cURL->getHeaderOptions();

echo $html;
echo print_r($headers);