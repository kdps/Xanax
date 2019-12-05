<?php

include './../vendor/autoload.php';

use Xanax\Classes\ClientURL;

$cURL = new ClientURL();
$cURL->Option->setURL('localhost');
$cURL->Option->setReturnTransfer(true);

echo $cURL->Execute();
