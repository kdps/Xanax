<?php

include './../../vendor/autoload.php';

use Xanax\Classes\Format\MultiPurposeInternetMailExtensions as MIME;

$MIME = new MIME();
echo $MIME->getType('mid');