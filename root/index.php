<?php

include './../vendor/autoload.php';

use Xanax\Classes\Data\HTMLObject;

$test = new HTMLObject("test");
echo $test->unhtmlSpecialChars();