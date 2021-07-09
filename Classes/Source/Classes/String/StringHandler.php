<?php

declare(strict_types=1);

namespace Xanax\Classes\String;

use Xanax\Exception\MemoryAllocatedException;

class StringHandler
{
	/**
	 * Check that contains string.
	 *
	 * @param string $text
	 * @param string $search
	 *
	 * @return bool
	 */
	public function isContains($text, $search)
	{
		$findedIndex = strpos($text, $search);

		return $findedIndex > -1;
	}

	public function indexBehindOf($text, $start, $searchString, $behindString)
	{
		$aheadIndex = strpos($text, $behindString);

		$findedIndex = strpos($text, $searchString);

		return ($findedIndex < $aheadIndex) ? -1 : $findedIndex;
	}

	public function indexHeadOf($text, $start, $searchString, $behindString)
	{
		$aheadIndex = strpos($text, $behindString);

		$findedIndex = strpos($text, $searchString);

		return ($findedIndex > $aheadIndex) ? -1 : $findedIndex;
	}

	public function removeByteOrderMark($text, $encoding = 'utf-8')
	{
		$byteOrderMark = "EFBBBF";
		$result = "";

		switch($encoding)
		{
			case "utf-8":
				$byteOrderMark = "EFBBBF";
				break;
			case "utf-16 big endian":
				$byteOrderMark = "FEFF";
				break;
			case "utf-16 little endian":
				$byteOrderMark = "FFFE";
				break;
			case "utf-32 big endian":
				$byteOrderMark = "0000FEFF";
				break;
			case "utf-32 little endian":
				$byteOrderMark = "FFFE0000";
				break;
			default:
				break;
		}

		$hexString = $this->Substring($this->binaryToHex($text), 0, 6);

		if ($hexString === $byteOrderMark)
		{
			$find = pack('H*', $byteOrderMark);
			$result = preg_replace("/^$find/", '', $text);
		}

		return $result;
	}

	public function integerToBytes($integer)
	{
		$integer = $integer;
		$length = length($integer);

		for ($i = $length - 1; $i >= 0; $i--)
		{
			$result .= chr(floor($integer / pow(256, $i)));
		}

		return $result;
	}

	public static function toUpper($text)
	{
		return strtoupper($text);
	}

	public static function toLower($text)
	{
		return strtolower($text);
	}

	public function unhtmlSpecialChars($string)
	{
		$entity = array('&quot;', '&#039;', '&#39;', '&lt;', '&gt;', '&amp;');
		$symbol = array('"', "'", "'", '<', '>', '&');
		return str_replace($entity, $symbol, $string);
	}

	public function entityToTag($string, $names)
	{
		$attr = ' ([a-z]+)=&quot;([\w!#$%()*+,\-.\/:;=?@~\[\] ]|&amp|&#039|&#39)+&quot;';
		$name_list = explode(',', $names);
		foreach ($name_list as $name)
		{
			$string = preg_replace_callback("{&lt;($name)(($attr)*)&gt;(.*?)&lt;/$name&gt;}is", array('Utility', 'replace'), $string);
		}

		return $string;
	}

	public function stripTags($string, $tags='')
	{
		if ($tags === '')
		{
			return strip_tags($string);
		}

		$tags = str_replace(',', '><', $tags);
		$tags = "<$tags>";

		return strip_tags($string, $tags);
	}


	public static function getUrlParameter($args)
	{
		$parameter = null;
		$rewriteParams = new stdClass;
		$func_num = func_num_args();
		$func_get = func_get_args();

		if ($func_get[0] == NULL)
		{
			$i=1;

			while ($i<$func_num)
			{
				if ($parameter)
				{
					if (isset($func_get[$i+1]))
					{
						$parameter .= '&'.$func_get[$i].'='.$func_get[$i+1];
					}
				}
				else
				{
					$parameter .= '?';
					$parameter .= $func_get[$i].'='.$func_get[$i+1];
				}

				$i = $i+2;
			}
		}
		else
		{
			$i=0;
			$get_tmp = $_GET;

			while ($i < $func_num)
			{
				if ($func_get[$i+1]=='')
				{
					unset($get_tmp[$func_get[$i]]);
				}
				else if (isset($func_get[$i+1]))
				{
					$get_tmp[$func_get[$i]] = $func_get[$i+1];
				}

				$i = $i+2;
			}

			foreach ($get_tmp as $key=>$val)
			{
				if ($parameter)
				{
					$parameter .= '&'.$key.'='.$val;
				}
				else
				{
					$parameter .= '?';
					$parameter .= $key.'='.$val;
				}
			}
		}

		$parameter = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'].$parameter : $parameter;

		return $return_url;
	}

	public function nlTrim($input)
	{
		$input = preg_replace('/[\r\n]/', '', $input);
		$input = preg_replace('/\t+/', ' ', $input);
		return $input;
	}

	public function nlslim($input, $max = 2)
	{
		$input = mb_ereg_replace('[\t 　]+(?=[\r\n])', '', $input);
		$replace = str_repeat('$1', $max);
		++$max;
		$regexp = '/(\r\n?|\n) {' . $max . ',}/';
		$input = preg_replace($regexp, $replace, $input);
		$input = str_replace("\t", '    ', $input);
		return $input;
	}

	public function nlToBr($string)
	{
		return preg_replace('/\r\n?|\n/', '<br />', $string);
	}

	public function brToNl($string)
	{
		return str_replace('<br />', "\r\n", $string);
	}

	public static function removeNullByte($input)
	{
		$clean = str_replace("\x00", '', $input);
		$clean = str_replace("\0", '', $input);
		$clean = str_replace(chr(0), '', $input);

		return $clean;
	}

	public static function removeDot($text)
	{
		return preg_replace("#(.*)-(.*)-(.*).(\d)-(.*)#", "$1-$2-$3$4-$5", $text);
	}

	public function Substring($binaryText, $start, $length)
	{
		return substr($binaryText, $start, $length);
	}

	public function binaryToHex($binaryText)
	{
		return bin2hex($binaryText);
	}

	public function getMaxAllocationSize(string $string) :int
	{
		$memory_limit = ini_get('memory_limit');

		if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches))
		{
			if ($matches[2] == 'M')
			{
				$memory_limit = $matches[1] * 1024 * 1024;
			}
			else if ($matches[2] == 'K')
			{
				$memory_limit = $matches[1] * 1024;
			}
		}

		$maxAllocationSize = $memory_limit - 2097184;

		return (int)($maxAllocationSize / strlen($string));
	}

	public function Repeat(string $string, int $multiplier)
	{
		if ($this->getMaxAllocationSize($string) > $multiplier)
		{
			// Memory allocated error
			throw new MemoryAllocatedException("Memory Allocated");
		}

		return str_repeat($string, $multiplier);
	}

	public static function isJson($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	public function filterVariable(mixed $string, $type)
	{
		switch ($type)
		{
			case (preg_match('/^MaxLength\((.*\))$/', $type, $matches) ? true : false):
				if (strlen($string) > $matches[1])
				{
					$string = false;
				}

				break;
			case (preg_match('/^Bracket\((.*\))$/', $type, $matches) ? true : false):
				if (isset($matches[1]))
				{
					$regex = $matches[1];
					if (preg_match('/^[A-Za-z0-9]+$/i', $regex, $matches))
					{
						$string = $matches[1];
						$regex = '/^<' . $string . '>([\s\S]*?)<\/' . $string . '>$/i';
					}

					if ($regex && preg_match($regex, $string, $matches))
					{
						if (isset($matches[1]))
						{
							$string = $matches[1];
						}
						else
						{
							$string = false;
						}
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'StringNumber':
				if (preg_match('/^[A-Za-z0-9]+$/i', $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'PhoneNumber':
				if (preg_match('/^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/g', $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'URL':
				if (preg_match("/^(http\:\/\/)*[.a-zA-Z0-9-]+\.[a-zA-Z]+$/g", $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'Email':
				if (preg_match("/^[^@]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/g", $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'URLParameter':
				if (preg_match('/([^=&?]+)=([^&#]*)/g', $string, $matches))
				{
					if (count($matches) === 1)
					{
						if (isset($matches[1]))
						{
							$string = $matches[1];
						}
						else
						{
							$string = false;
						}
					}
					else if (count($matches) > 1)
					{
						$string = $matches;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'Label':
				if (preg_match("/\[([a-zA-Z0-9\s_-]+)\]/i", $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'FunctionName':
				if (preg_match_all("/(\[?[a-zA-Z0-9\s_-]+\]?)/", $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'Deny':
				$string = false;

				break;
			case 'DoubleQuotation':
				if (preg_match('/^"(.*)"$/', $key, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'SinigleQuotation':
				if (preg_match('/^\'(.*)\'$/', $string, $matches))
				{
					if (isset($matches[1]))
					{
						$string = $matches[1];
					}
					else
					{
						$string = false;
					}
				}
				else
				{
					$string = false;
				}

				break;
			case 'WithOutHTML':
				$string = strip_tags($string);
				break;
			case 'JSON':
				if ( !$this->isJson( $string )
			    	{
					$string = false;
				}

				break;
			case 'Numbers':
				if (!is_numeric($string) || !is_int($string))
			    	{
					if (preg_match('/^(\d[\d\.]+)$/', $key, $matches))
					{
						if (isset($matches[1]))
						{
							$string = $matches[1];
						}
						else
						{
							$string = false;
						}
					}
					else
					{
						$string = false;
					}
				}

				break;
			case 'Number':
				if (!is_numeric($string) || !is_int($string))
			    	{
					if (preg_match('/^(\d+)$/', $string, $matches))
					{
						if (isset($matches[1]))
						{
							$string = $matches[1];
						}
						else
						{
							$string = false;
						}
					}
					else
					{
						$string = false;
					}
				}

				break;
			case 'String':
				if (!is_string($string))
			    	{
					$string = false;
				}

				break;
			case 'Integer':
				$string = intval($string);

				break;
			case 'Float':
				$string = intval($string);
				$string = (float)sprintf('% u', $string);
				if ($string < 0)
		    		{
					$string = false;
				}

				break;
			case 'Boolean':
				$string = ($string === true) ? true : (($string === false) ? false : false);

				break;
			default:
				break;
		}

		return $string;
	}

	public function getRandomString($length = 1)
    	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';

		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	public function escapeSlash($string)
	{
		return stripslashes($string);
	}

	public function isNumber($string)
	{
		return is_numeric($string);
	}

	public function removeUtf8Bom($string)
	{
		$source = preg_replace('/^\xEF\xBB\xBF/', '', $string);

		return $source;
	}

	public function getMD5String($string, $length = 32)
    	{
		return $string == '' ? '' : substr(md5($string), -$length);
	}

	public function getMd5Uniqid($length = 20)
    	{
		$id = md5(uniqid(mt_rand(), true));
		$id = substr($id, -$length);

		return $id;
	}

	public function stripTags($string, $tags = '')
    	{
		if ($tags === '')
		{
			return strip_tags($string);
		}

		$tags = str_replace(',', '><', $tags);
		$tags = "<$tags>";

		return strip_tags($string, $tags);
	}

	public function replaceToHtmlSource($match)
    	{
		list($target, $name, $attr) = $match;
		$name = strToLower($name);
		$value = end($match);

		if (strpos($value, '<') !== false)
		{
			return $target;
		}

		if (preg_match('/script|style|link|html|body|frame/', $name))
		{
			return $target;
		}

		if ($attr !== '')
		{
			if (preg_match('/ on|about:|script:|@import|behaviou?r|binding|boundary|cookie|eval|expression|include-source|xmlhttp/i', $attr))
			{
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

	public function brToNl(string $string)
    	{
		return str_replace('<br />', "\r\n", $string);
	}

	public function nlToBr(string $string)
    	{
		return preg_replace('/\r\n?|\n/', '<br />', $string);
	}

	public function nTrim(string $string)
    	{
		return str_replace("\x00", '', $string);
	}

	public function intergerToBytes(string $string)
    	{
		$length = strlen($string);
		$result = '';

		for ($i = $length - 1; $i >= 0; $i--)
		{
			$result .= chr(floor($string / pow(256, $i)));
		}

		return $result;
	}

	public function hexToBinary(string $string)
    	{
		$length = strlen($string);
		$result = '';

		for ($i = 0; $i < $length; $i += 2)
		{
			$result .= chr(hexdec(substr($string, $i, 2)));
		}

		return $result;
	}

	public function removeDot(string $string)
    	{
		return preg_replace("#(.*)-(.*)-(.*).(\d)-(.*)#", '$1-$2-$3$4-$5', $string);
	}

	public function toUpper(string $string)
    	{
		return strtoupper($string);
	}

	public function removeNullBytes(string $string)
    	{
		$clean = str_replace("\x00", '', $string);
		$clean = str_replace("\0", '', $string);
		$clean = str_replace(chr(0), '', $string);

		return $clean;
	}

	public function toLower(string $string)
	{
		return strtolower($string);
	}

	public function getRandomHex(int $length = 32)
	{
		$output = $this->getRandomBytes($length);

		return bin2hex($output);
	}

	public function getRandomBytes(int $length = 32)
	{
		$bytes = min(32, $length);

		$isWindows = $operationSystem->isWindows();

		if (function_exists('random_bytes'))
		{
			try
			{
				$output = random_bytes($bytes);
			}
			catch (\Exception $e)
			{
				$output = false;
			}
		}

		if ($output === false)
		{
			if (function_exists('mcrypt_create_iv') && !$isWindows)
			{
				$output = mcrypt_create_iv($length, \MCRYPT_DEV_URANDOM);
			}
			else if (function_exists('openssl_random_pseudo_bytes') && !$isWindows)
			{
				$output = openssl_random_pseudo_bytes($length);
			}
			else if (function_exists('mcrypt_create_iv') && $isWindows)
			{
				$output = mcrypt_create_iv($bytes, \MCRYPT_RAND);
			}
		}

		return $output;
	}

}
