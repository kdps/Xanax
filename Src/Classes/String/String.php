<?php

use Xanax\Classes\OperationSystem

class String {
	
	public static function getRandomString( $length = 1 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = "";
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		return $randomString;
	}
	
	public static function escapeSlash( $string ) {
		return stripslashes($string);
	}
	
	public static function isNumber( $string ) {
		return is_numeric($string);
	}
	
	public static function removeUtf8Bom( $string ) {
		$source = preg_replace('/^\xEF\xBB\xBF/', '', $string);
		
		return $source;
	}
	
	public function getMD5String ( $string, $length = 32 ) {
		return $string == '' ? '' : substr( md5($string), -$length );
	}
	
	public function getMd5Uniqid( $length = 20 ) {
		$id = md5(uniqid(mt_rand(), true));
		$id = substr($id, -$length);
		
		return $id;
	}
	
	public function stripTags( $string, $tags = '' ) {
		if ($tags === '') {
			return strip_tags($string);
		}
		
		$tags = str_replace(',', '><', $tags);
		$tags = "<$tags>";
		return strip_tags($string, $tags);
	}
	
	public function replaceToHtmlSource ( $match ) {
		list($target, $name, $attr) = $match;
		$name = strToLower($name);
		$value = end($match);

		if (strpos($value, '<') !== false) {
			return $target;
		}
		
		if (preg_match('/script|style|link|html|body|frame/', $name)) {
			return $target;
		}
		
		if ($attr !== '') {
			if (preg_match('/ on|about:|script:|@import|behaviou?r|binding|boundary|cookie|eval|expression|include-source|xmlhttp/i', $attr)) {
				return $target;
			}
			
			$attr = str_replace('*/', '*/  ', $attr);
			$attr = str_replace('&quot;', '"', $attr);
			$attr = preg_replace('/ {2,}/', ' ', $attr);
			$attr = str_replace('=" ', '="', $attr);
			$attr = str_replace(' "', '"', $attr);
			$attr = preg_replace('/^ [a-z]+/ie', "strToLower('$0');", $attr);
		}
		
		return "<$name$attr>$value</$name>";
	}
	
	public function brToNl( string $string ) {
		return str_replace('<br />', "\r\n", $string);
	}
	
	public function nlToBr( string $string ) {
		return preg_replace('/\r\n?|\n/', '<br />', $string);
	}
	
	public function nTrim( string $string ) {
		return str_replace("\x00", '', $string);
	}
	
	public function intergerToBytes( string $string ) {
		$length = strlen( $string );
		$result = "";
		for($i=$length-1; $i>=0; $i--) {
			$result .= chr(floor($string / pow(256, $i)));
		}
		
		return $result;
	}
	
	public function hexToBinary( string $string ) {
		$result = "";
		for($i=0; $i<strlen($string); $i += 2) {
			$result .= chr(hexdec(substr($string, $i, 2)));
		}
		
		return $result;
	}
	
	public static function removeDot( string $string ) {
		return preg_replace("#(.*)-(.*)-(.*).(\d)-(.*)#", "$1-$2-$3$4-$5", $string);
	}
	
	public function toUpper ( string $string ) {
		return strtoupper($string);
	}
	
	public static function removeNullBytes( string $string ) {
		$clean = str_replace("\x00", '', $string); 
		$clean = str_replace("\0", '', $string); 
		$clean = str_replace(chr(0), '', $string);
		
		return $clean;
	}
	
	public function isJSON ( $string ) {
		return is_string( $string ) && is_array( json_decode( $string, true ) ) && ( json_last_error() == JSON_ERROR_NONE ) ? true : false;
	}
	
	public function toLower( string $string ) {
		return strtolower( $string );
	}
	
	public function getRandomHex( int $length = 32 ) {
		$output = $this->getRandomBytes( $length );
		
		return bin2hex($output);
	}
	 
	
	public function getRandomBytes( int $length = 32 ) {
		$bytes = min(32, $length);
		
		$isWindows = $operationSystem->isWindows();
		
		if(function_exists('random_bytes')) {
			try {
				$output = random_bytes($bytes);
			} catch (\Exception $e) {
				$output = false;
			}
		}
		
		if ($output === false) {
			if (function_exists('mcrypt_create_iv') && !$isWindows) {
				$output = mcrypt_create_iv($length, \MCRYPT_DEV_URANDOM);
			} else if (function_exists('openssl_random_pseudo_bytes') && !$isWindows) {
				$output = openssl_random_pseudo_bytes($length);
			} else if(function_exists('mcrypt_create_iv') && $isWindows) {
				$output = mcrypt_create_iv($bytes, \MCRYPT_RAND);
			}
		}
		
		return $output;
	}
}