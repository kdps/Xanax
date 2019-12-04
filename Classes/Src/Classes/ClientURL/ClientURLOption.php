<?php

declare(strict_types=1);

namespace Xanax\Classes;

class ClientURLOption
{
	
	private static $session;
	
	private static $headerArrayData = array();
	
	public function __construct( $session = '' )
	{
		self::$session = $session;
	}
	
	public function setURL( string $url ) :void
	{
		curl_setopt( self::$session, CURLOPT_URL, $url);
	}
	
	public function setSSLVerifypeer( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_SSL_VERIFYPEER, $bool);
	}
	
	public function setTimeout( bool $timeout = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_TIMEOUT, $timeout);
	}
	
	public function setPostField( int $fields = 0 ) :void
	{
		curl_setopt( self::$session, CURLOPT_POSTFIELDS, $fields);
	}
	
	public function setPostFieldSize( int $size = 0 ) :void
	{
		curl_setopt( self::$session, CURLOPT_POSTFIELDSIZE, $size);
	}

	public function setFollowLocationHeader( int $size = 0 ) :void
	{
		curl_setopt( self::$session, CURLOPT_FOLLOWLOCATION, $size);
	}

	public function setFTPUseEPSV( int $size = 0 ) :void
	{
		curl_setopt( self::$session, CURLOPT_FTP_USE_EPSV, $size);
	}

	public function setFileHandler( $filePointer ) :void
	{
		curl_setopt( self::$session, CURLOPT_FILE, $filePointer);
	}

	public function setDnsUseGlobalCache( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_DNS_USE_GLOBAL_CACHE, $bool);
	}

	public function setUserAgent( $userAgent = '' ) :void
	{
		curl_setopt( self::$session, CURLOPT_USERAGENT, $userAgent);
	}
	
	public function setAcceptEncoding( $encoding = '' ) :void
	{
		curl_setopt( self::$session, CURLOPT_ENCODING, $encoding);
	}

	public function setCookieHeader( $cookieData = '' ) :void
	{
		curl_setopt( self::$session, CURLOPT_COOKIE, $cookieData);
	}

	public function useCookieSession( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_COOKIESESSION, $bool);
	}

	public function setMaximumConnectionCount( bool $maximumConnection = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_MAXCONNECTS, $maximumConnection);
	}

	public function setAutoReferer( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_AUTOREFERER, $bool);
	}

	public function setEmptyBody( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_NOBODY, $bool);
	}

	public function setConnectionTimeout( bool $timeout = true, bool $useMilliseconds = false) :void
	{
		if ($useMilliseconds) {
			$this->setConnectionTimeoutMilliseconds($timeout);
		} else {
			curl_setopt( self::$session, CURLOPT_CONNECTTIMEOUT, $timeout);
		}
	}

	public function setConnectionTimeoutMilliseconds( bool $timeout = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_CONNECTTIMEOUT_MS, $timeout);
	}

	public function setNobody( bool $bool = true ) :void
	{
		$this->setEmptyBody($bool);
	}

	public function setBinaryTransfer( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_BINARYTRANSFER, $bool);
	}

	public function setMaximumUploadSpeed( int $bytePerSeconds = 1000 ) :void
	{
		$this->setMaximumSendSpeed($bytePerSeconds);
	}
	
	public function setMaximumSendSpeed( int $bytePerSeconds = 1000 ) :void
	{
		curl_setopt( self::$session, CURLOPT_MAX_SEND_SPEED_LARGE, $bytePerSeconds);
	}
	
	public function setMaximumDownloadSpeed( int $bytePerSeconds = 1000 ) :void
	{
		$this->setMaximumReceiveSpeed($bytePerSeconds);
	}
	
	public function setMaximumReceiveSpeed( int $bytePerSeconds = 1000 ) :void
	{
		curl_setopt( self::$session, CURLOPT_MAX_RECV_SPEED_LARGE, $bytePerSeconds);
	}
	
	public function setHeader( string $key, string $value, bool $overwrite = false ) :void
	{
		$headerData = array($key, $value);
			
		if (!$overwrite) {
			array_push(self::$headerArrayData, $headerData);
			
			curl_setopt( self::$session, CURLOPT_HTTPHEADER, self::$headerArrayData);
		} else {
			curl_setopt( self::$session, CURLOPT_HTTPHEADER, $headerData);
		}
	}
	
	public function setAcceptContentType( string $applicationType ) :void
	{
		$key = "";
		
		switch($applicationType) {
			case "xml":
				$key = 'application/xml';
				break;
			case "json":
				$key = 'application/json';
				break;
			default:
				$key = $applicationType;
				break;
		}
		
		$this->setHeader(sprintf('Accept: %s', $key), sprintf('Content-Type: %s', $key));
	}
	
	public function setAcceptXmlContentType() :void
	{
		$this->setAcceptContentType('xml');
	}
	
	public function setAcceptJsonContentType() :void
	{
		$this->setAcceptContentType('json');
	}
	
	public function setHeaders( $headers = [] ) :void
	{
		curl_setopt( self::$session, CURLOPT_HTTPHEADER, $headers);
	}
	
	public function setPort( bool $port = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_PORT, $port);
	}
	
	public function setPostMethod( bool $bool = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_POST, $bool);
	}

	public function setReturnTransfer( bool $hasResponse = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_RETURNTRANSFER, $hasResponse);
	}
	
	public function setReturnHeader( bool $hasResponse = true ) :void
	{
		curl_setopt( self::$session, CURLOPT_HEADER, $hasResponse);
	}
	
}
