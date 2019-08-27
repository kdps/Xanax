<?php
	echo 00 == 0e324234 ? "true" : "false";
	echo 00 == (string)0e324234 ? "true" : "false";
	echo (string)00 == (string)0e324234 ? "true" : "false";
?>
