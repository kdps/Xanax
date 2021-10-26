<?php

include './../vendor/autoload.php';

use Xanax\Classes\MIME;

$MIME = new MIME();
echo $MIME->getType('mid');