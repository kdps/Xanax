<?php

declare(strict_types=1);

namespace Xanax\Classes;

class SessionHandler
{
	public function __construct()
	{
	}

	public function isExtensionLoaded()
	{
		if (!extension_loaded('session')) {
			return false;
		}

		return true;
	}

	public function getStatus()
	{
		$status = session_status();

		return $status;
	}

	public function getSessionId()
	{
		$sessionId = session_id();

		return $sessionId;
	}

	public function hasSessionId()
	{
		if ($this->getSessionId() == '') {
			return false;
		}

		return true;
	}

	public function isOneExists()
	{
		if ($this->getStatus() == PHP_SESSION_ACTIVE) {
			return false;
		}

		return true;
	}

	public function isExists()
	{
		if ($this->getStatus() == PHP_SESSION_NONE) {
			return false;
		}

		return true;
	}

	public function isDisabled()
	{
		if ($this->getStatus() == PHP_SESSION_DISABLED) {
			return false;
		}

		return true;
	}

	public function isStated()
	{
		if (!$this->isExists() && empty($_SESSION)) {
			return false;
		}

		return true;
	}

	public function getSavePath()
	{
		return session_save_path();
	}

	public function setSavePath($path = '')
	{
		return session_save_path($path);
	}

	public function Commit()
	{
		session_commit();
	}

	public function RegenerateId($use = true)
	{
		session_regenerate_id($use);
	}

	public function useCookies()
	{
		if (ini_get('session.use_cookies')) {
			return true;
		}

		return false;
	}

	public function Destroy()
	{
		session_destroy();
	}

	public function Set($key, $value, $overwrite = true, $valid = false)
	{
		$setSessionVar = function ($key, $value) {
			$_SESSION[$key] = $value;
		};

		if (isset($_SESSION[$key])) {
			if ($overwrite === true) {
				$setSessionVar($key, $value);
			} else {
				return false;
			}
		} else {
			$setSessionVar($key, $value);
		}

		if ($valid === true && $_SESSION[$key] !== $value) {
			return false;
		}

		return true;
	}

	public function Get($key)
	{
		return $_SESSION[$key] ? $_SESSION[$key] : null;
	}

	public function Unset() :bool
	{
		return session_unset();
	}
}
