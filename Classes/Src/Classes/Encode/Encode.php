<?php

declare(strict_types=1);

namespace Xanax\Classes;

class Encode
{
	public function Detect($string)
	{
		$encoding = mb_detect_encoding($string, mb_list_encodings(), true);

		return $encoding;
	}
}
