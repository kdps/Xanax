<?php

namespace Xanax\Classes\String;

class Unicode 
{

	public function isValid($text) 
	{
		return preg_match("[^\w$\x{0080}-\x[FFFF]]+/u", $text);
	}
	
}
