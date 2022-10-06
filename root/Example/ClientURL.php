<?php

include './../../vendor/autoload.php';

use Xanax\Classes\ClientURL;

$cURL = new ClientURL();
$cURL->Option->setURL('http://www.computerusermanual.com/')
			 ->setReturnTransfer(true);

$html = $cURL->Execute();

echo $html;
