<?php

include './../vendor/autoload.php';

use Xanax\Classes\ClientURL;

$cURL = new ClientURL();
$cURL->Option->setURL("http://www.ilbe.com");
$cURL->Option->setReturnTransfer(true);
echo $cURL->Execute();