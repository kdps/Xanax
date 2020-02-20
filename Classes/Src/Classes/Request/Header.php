<?php

declare(strict_types=1);

namespace Xanax\Classes;

class Header
{
	public function Response($data)
	{
		header($data);
	}
	
	public function responseWithArray($pair: Array)
	{
		array_walk($pair, create_function('&$i,$k','$i=" $k=$i;";'));
		
		$responseData = implode($pair, "");
		
		$this->Response($responseData);
	}
	
	public function responseWithKey($key, $value)
	{
		$responseData = "$key : $value";
		
		$this->Response($responseData);
	}
	
	public function responseContentType($value)
	{
		$this->responseWithKey('Content-Type', $value);
	}
	
	public function responseContentTransferEncoding($value)
	{
		$this->responseWithKey('Content-Transfer-Encoding', $value);
	}
	
	public function responseContentDisposition($value)
	{
		$this->responseWithKey('Content-Disposition', $value);
	}
	
	public function responseXXSSProtection($value)
	{
		$this->responseWithKey('X-XSS-Protection', $value);
	}
	
	public function responseXContentTypeOption($value)
	{
		$this->responseWithKey('X-Content-Type-Options', $value);
	}
	
	public function responseP3P()
	{
		$this->responseWithKey('P3P', 'CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	}
	
	public function responseConnection($value)
	{
		$this->responseWithKey('Connection', $value);
	}
	
	public function responseContentEncoding($value)
	{
		$this->responseWithKey('Content-Encoding', $value);
	}
	
	public function responseContentLength($value)
	{
		$this->responseWithKey('Content-Length', $value);
	}
	
	public function responseRedirectLocation($value)
	{
		$this->responseWithKey('Location', $value);
	}
	
	public function responseStatus($responseCode = '200', $responseMessage = 'OK', $protocol = 'HTTP', $protocolVersion = '1.0')
	{
		$responseData = sprintf("%s/%s %s %s", $protocol, $protocolVersion, $responseCode, $responseMessage);
		
		$this->Response($responseData);
	}
	
	public function responseStatusByCode($code)
	{
		$responseMessage = $this->getStatusMessageByCode($code);
		
		//TODO throw
		
		$this->responseStatus($code, $responseMessage);
	}
	
	public static function fileAttachment($fileName)
	{
		header("Content-Disposition: attachment; filename=$fileName");
	}

	public function getStatusMessageByCode($code)
	{
		$stateMessage = '';
		
		switch($code) {
			case "200":
				$stateMessage = 'OK';
				break;
			case "201":
				$stateMessage = 'Created';
				break;
			case "202":
				$stateMessage = 'Accepted';
				break;
			case "204":
				$stateMessage = 'No Content';
				break;
			case "300":
				$stateMessage = 'Multiple Choices';
				break;
			case "301":
				$stateMessage = 'Moved Permanently';
				break;
			case "302":
				$stateMessage = 'Moved Temporarily';
				break;
			case "304":
				$stateMessage = 'Not Modified';
				break;
			case "400":
				$stateMessage = 'Bad Request';
				break;
			case "401":
				$stateMessage = 'Unauthorized';
				break;
			case "403":
				$stateMessage = 'Forbidden';
				break;
			case "404":
				$stateMessage = 'Not Found';
				break;
			case "500":
				$stateMessage = 'Internal Server Error';
				break;
			case "501":
				$stateMessage = 'Not Implemented';
				break;
			case "502":
				$stateMessage = 'Bad Gateway';
				break;
			case "503":
				$stateMessage = 'Service Unavailable';
				break;
			default:
				break;
		}
		
		return $stateMessage;
	}
	
	public function responseXSSBlock(){
		$this->XXSSProtection('mode=block');
	}
	
	public function responseNoSniff(){
		$this->XContentTypeOption('nosniff');
	}
	
}
