<?php

declare(strict_types=1);

namespace Xanax\Classes;

use Xanax\Classes\ClientURLOption as ClientURLOption;
use Xanax\Classes\ClientURLLastTransferInformation as ClientURLLastTransferInformation;

class ClientURL
{
	
	private static $session;
	
	public function getSession()
	{
		if (self::$session == null) {
			self::$session = curl_init();
		}
		
		return self::$session;
	}
	
	public function __construct( $url = '' )
	{
		self::$session = $this->getSession();
		
		$this->Option = new ClientURLOption(self::$session);
		$this->Information = new ClientURLLastTransferInformation(self::$session);
	}
	
	public function Close()
	{
		curl_close( self::$session );
	}
	
	public function Execute()
	{
		return curl_exec(self::$session);
	}
	
}
