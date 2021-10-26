<?php

include("./../vendor/autoload.php");

use Xanax\Classes\Tokenizer as Tokenizer;

$tokenizer = new Tokenizer();

$tokenizer->generateToken(file_get_contents("script.txt"));
