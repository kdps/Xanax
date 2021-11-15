<?php

include './../../vendor/autoload.php';

use Xanax\Classes\Image\Handler as ImageHandler;

$fixImage = "./Resources/Images/up.jpg";

$imageHandler = new ImageHandler();
$type = $imageHandler->getType($fixImage);
$imageInstance = $imageHandler->getInstance($fixImage);
$imageInstance = $imageHandler->Resize($imageInstance, 100, 100);
$imageHandler->Draw($imageInstance, $type);