<?php

declare(strict_types=1);

namespace Xanax\Classes\Data;

use Xanax\Exception\MemoryAllocatedException;

use Xanax\Classes\Data\StringHandler;

class HTMLHandler extends StringHandler
{

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

}