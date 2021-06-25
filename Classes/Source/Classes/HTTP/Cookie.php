<?php

declare(strict_types=1);

namespace Xanax\Classes\HTTP;

class Cookie
{
	public function isSet($key) 
	{
		return isset( $_COOKIE[ $key ] ) ? true : false;
	}
	
	public function setRaw( $key, $value = '', $expired ) 
	{
		if ( isset($expired) ) 
		{
			setrawcookie( $key, $value, $expired );
		} 
		else 
		{
			setrawcookie( $key, $value );
		}
		
		return true;
	}
	
	public function Get($key) 
	{
		if ( $this->isSet($key) ) 
		{
			return $_COOKIE[ $key ];
		}
		
		return '';
	}
	
	public function Set( $key, $value = '', $expired = '', $useUrlEncoding = true) 
	{
		if ($useUrlEncoding) 
		{
			if (isset($expired)) 
			{
				setcookie($key, $value, $expired);
			}
			elseif(!isset($expired)) 
			{
				setcookie($key, $value);
			}
		} 
		else 
		{
			$this->setRaw($key, $value, $expired)
		}
		
		return true;
	}
	
	public static function Unset($name)
	{
		if (isset($_COOKIE[ $name ])) 
		{
			unset($_COOKIE[ $name ]);
			
			return true;
		}
		
		return false;
	}
}
