<?php

declare(strict_types=1);

namespace Xanax\Classes\HTTP;

class Session 
{
	
	public function __construct() 
	{
	}

	/**
	 * Start session
	 *
	 * @return void
	 */
	public function Start($options = []) 
	{
		if ($this->isExtensionLoaded()) 
		{
			session_start ($options);
		}
	}
	
	/**
	 * Check that php session extension is exsits
	 *
	 * @return boolean
	 */
	public function isExtensionLoaded() 
	{
		if (!extension_loaded('session')) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Get session status code
	 *
	 * @return String
	 */
	public function getStatus() 
	{
		$status = session_status();

		return $status;
	}

	/**
	 * Get a current session identify
	 *
	 * @return String
	 */
	public function getId() 
	{
		$sessionId = session_id();

		return $sessionId;
	}

	public function setCacheLimiter(string $value) 
	{
		session_cache_limiter($value);
	}

	public function getCacheLimiter() 
	{
		return session_cache_limiter();
	}

	public function setCacheExpire(int $value) 
	{
		return session_cache_expire($value);
	}

	public function Abort() 
	{
		return session_abort();
	}

	/**
	 * Check that session id is exists
	 *
	 * @return boolean
	 */
	public function hasId() 
	{
		if ($this->getId() == '') 
		{
			return false;
		}

		return true;
	}

	public function isOneExists() 
	{
		if ($this->getStatus() == PHP_SESSION_ACTIVE) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Check that session is exists
	 *
	 * @return boolean
	 */
	public function isExists() :bool {
		if ($this->getStatus() == PHP_SESSION_NONE) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Check that session is disabled
	 *
	 * @return boolean
	 */
	public function isDisabled() :bool 
	{
		if ($this->getStatus() == PHP_SESSION_DISABLED) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Check that session is started
	 *
	 * @return void
	 */
	public function isStated() 
	{
		if (!$this->isExists() && empty($_SESSION)) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Get a save path of session
	 *
	 * @return void
	 */
	public function getSavePath() 
	{
		return session_save_path();
	}

	/**
	 * Change save path of session
	 *
	 * @param String $path
	 *
	 * @return void
	 */
	public function setSavePath($path = '') 
	{
		return session_save_path($path);
	}

	public function Reset()
	{
		return session_reset();
	}

	public function getCookieParams()
	{
		return session_get_cookie_params();
	}

	public function garbageCollect()
	{
		return session_gc();
	}

	public function createId(string $prefix)
	{
		return session_create_id($prefix);
	}

	public function Commit() 
	{
		session_commit();
	}

	public function regenerateId($use = true) 
	{
		session_regenerate_id($use);
	}

	/**
	 * Change session availability
	 *
	 * @return boolean
	 */
	public function useCookies() 
	{
		if (ini_get('session.use_cookies')) 
		{
			return true;
		}

		return false;
	}

	/**
	 * Destory session
	 *
	 * @return void
	 */
	public function Destroy() 
	{
		$_SESSION = [];
		session_destroy();
	}

	/**
	 * Set session item
	 *
	 * @param String  $key
	 * @param String  $value
	 * @param Boolean $overwrite
	 * @param Boolean $valid
	 *
	 * @return Boolean
	 */
	public function Set($key, $value, $overwrite = true, $valid = false) :bool 
	{
		$setSessionVar = function ($key, $value) 
		{
			$_SESSION[$key] = $value;
		};

		if (isset($_SESSION[$key])) 
		{
			if ($overwrite === true) 
			{
				$setSessionVar($key, $value);
			} 
			else 
			{
				return false;
			}
		} 
		else 
		{
			$setSessionVar($key, $value);
		}

		if ($valid === true && $_SESSION[$key] !== $value) 
		{
			return false;
		}

		return true;
	}

	/**
	 * Get session item
	 *
	 * @return void
	 */
	public function Get($key) 
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * Unset all session items
	 *
	 * @return boolean
	 */
	public function Unset() :bool 
	{
		return session_unset();
	}
	
}
