<?php

namespace Xanax/Classes;

use Xanax/Classes/Data/Identifier as Identifier;

class Data
{
	private static $data;

	public function __constructor($data)
	{
		self::$data = $data;
	}

	public function typeCasting($type)
	{
		switch($type)
		{
			case "string":
				self::data = (string)self::data;
				break;
			case "integer":
				self::data = (integer)self::data;
				break;
			case "float":
				self::data = (float)self::data;
				break;
			case "boolean":
				self::data = (boolean)self::data;
				break;
			case "array":
				self::data = (array)self::data;
				break;
		}
	}

}
