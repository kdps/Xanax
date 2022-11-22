<?php

class SHA512
{
	public function Encrypt($string, $useBase64 = true)
	{
		$hashed = hash('sha512', $string, true);

		return $useBase64 ? base64_encode($hashed) : $hashed;
	}
}
