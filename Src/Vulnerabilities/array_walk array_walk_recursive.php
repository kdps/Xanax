<?php
$_GET['arg1'] = "phpinfo()";
$_GET['arg2'] = "assert";
$_GET['func'] = "call_user_func";

$some = array($_GET['arg1'] => $)GET['arg2']);
$func = $_GET['func'];
array_walk($some, $func);
?>
