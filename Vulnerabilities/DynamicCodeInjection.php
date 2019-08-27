<?php
$_GET['func'] = "system";
$_GET['argument'] = "uname";

$func = $_GET['func'];
$argument = $_GET['argument'];
$func($argument);
?>
