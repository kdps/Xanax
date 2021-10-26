<?php

include './../../vendor/autoload.php';

use Xanax\Classes\Image\Handler as ImageHandler;

$fixImage = "./Resources/Images/left.jpg";

$imageHandler = new ImageHandler();
$type = $imageHandler->getType($fixImage);
$imageInstance = $imageHandler->getInstance($fixImage);
$imageInstance = $imageHandler->fixOrientation($fixImage, $imageInstance);
$imageHandler->Draw($imageInstance, $type);