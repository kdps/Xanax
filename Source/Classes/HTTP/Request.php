<?php

declare(strict_types=1);

namespace Xanax\Classes\HTTP;

use Xanax\Enumeration\HTTPRequestMethod;

class Request 
{
	
	protected $statusCode = 200;
	
	protected $statusMesssages = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		103 => 'Early Hints',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',
		226 => 'IM Used',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => "I'm a teapot",
		421 => 'Misdirected Request',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		425 => 'Too Early',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		444 => 'Connection Closed Without Response',
		451 => 'Unavailable For Legal Reasons',
		499 => 'Client Closed Request',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended',
		511 => 'Network Authentication Required',
		599 => 'Network Connect Timeout Error',
	];

	public function getBrowserInfo() :array 
	{
		$browserInfo = [];
		if (!empty(ini_get('browscap'))) 
		{
			$browserInfo = print_r(get_browser(null, true));
		}

		return $browserInfo;
	}

	public function isHttpsProtocol() :bool 
	{
		return empty($_SERVER['HTTPS']) ? false : $this->getServerArguments('HTTPS') === 'on' ? true : false;
	}

	public function getServerArguments($argument) 
	{
		if (isset($_SERVER[$argument])) 
		{
			return $_SERVER[$argument];
		}
		
		return null;
	}
	
	public function getServerTime() 
	{
		return $this->getServerArguments('REQUEST_TIME');
	}
	
	public function getServerFloatTime() 
	{
		return $this->getServerArguments('REQUEST_TIME_FLOAT');
	}
	
	public function getScheme() 
	{
		return $this->getServerArguments('REQUEST_SCHEME');
	}
	
	public function getProtocol() :string 
	{
		return substr(strtolower($this->getServerArguments('SERVER_PROTOCOL')), 0, strpos(strtolower($this->getServerArguments('SERVER_PROTOCOL')), '/'));
	}

	/**
	 * Get Request Uniform Resource Identifier
	 *
	 * @return String
	 */
	public function getURI() 
	{
		return $this->getServerArguments('REQUEST_URI');
	}
	
	/**
	 * The physical path of the temporary IIS application pool configuration.
	 *
	 * @return String
	 */
	public function getTemporaryIISApplicationPhysicalPathOfPoolConfiguration() 
	{
		return $this->getServerArguments('APP_POOL_CONFIG');
	}
	
	/**
	 * The metabase path of the application.
	 *
	 * @return String
	 */
	public function getIISApplicationMetabasePath() 
	{
		return $this->getServerArguments('APPL_MD_PATH');
	}
	
	/**
	 * The authentication method that the server uses to validate users.
	 * It does not mean that the user was authenticated if AUTH_TYPE contains a value and the authentication scheme is not Basic or integrated Windows authentication. 
	 * The server allows authentication schemes it does not natively support because an ISAPI filter may be able to handle that particular scheme.
	 *
	 * @return String
	 */
	public function getIISAuthenticateType() 
	{
		return $this->getServerArguments('AUTH_TYPE');
	}
	
	/**
	 * The password provided by the client to authenticate using Basic Authentication.
	 *
	 * @return String
	 */
	public function getIISAuthenticatePassword() 
	{
		return $this->getServerArguments('AUTH_PASSWORD');
	}
	
	/**
	 * The name of the application pool that is running the IIS worker process handling the request.
	 *
	 * @return String
	 */
	public function getIISApplicationPoolID() 
	{
		return $this->getServerArguments('APP_POOL_ID');
	}
	
	/**
	 * The physical path of the application.
	 *
	 * @return String
	 */
	public function getIISApplicationPhysicalPath() 
	{
		return $this->getServerArguments('APPL_PHYSICAL_PATH');
	}
	
	public function getServierSoftwareName() 
	{
		return $this->getServerArguments('SERVER_SOFTWARE');
	}
	
	public function getAbsolutePathOfDocumentRoot() 
	{
		return $this->getServerArguments('DOCUMENT_ROOT');
	}
	
	public function getIISIsapiRewriteURL() 
	{
		return $this->getServerArguments('HTTP_X_REWRITE_URL');
	}
	
	public function getHTTPConnection() :string 
	{
		return $this->getServerArguments('HTTP_CONNECTION');
	}

	public function getPort() :string 
	{
		return $this->getServerArguments('SERVER_PORT');
	}

	public function getReferer() 
	{
		if ($this->hasReferer()) 
		{
			return $this->getServerArguments('HTTP_REFERER');
		}

		return null;
	}

	public function getHTTPAccept() 
	{
		return $this->getServerArguments('HTTP_ACCEPT');
	}

	public function getHTTPContentType() 
	{
		return $this->getServerArguments('HTTP_CONTENT_TYPE');
	}

	public function getServerProtocol() 
	{
		return $this->getServerArguments('SERVER_PROTOCOL');
	}

	public function getContentType() 
	{
		return $this->getServerArguments('CONTENT_TYPE');
	}

	public function getSignature() 
	{
		return $this->getServerArguments('SERVER_SIGNATURE');
	}

	public function getUserAgent() 
	{
		return $this->getServerArguments('HTTP_USER_AGENT');
	}

	public function getDocumentRoot() 
	{
		return $this->getServerArguments('DOCUMENT_ROOT');
	}

	public function getRequestMethod() 
	{
		return $this->getServerArguments('REQUEST_METHOD');
	}

	public function getAcceptEncoding() 
	{
		return $this->getServerArguments('HTTP_ACCEPT_ENCODING');
	}

	public function isXmlHttpRequest() 
	{
		return (strtolower($this->getServerArguments('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest');
	}

	public function isAjax() 
	{
		return (!empty($this->getServerArguments('HTTP_X_REQUESTED_WITH')) && $this->isXmlHttpRequest()) ? true : false;
	}

	public function getHTTPXForwardedFor() 
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		return null;
	}

	public function getHTTPClientIP() 
	{
		if (isset($_SERVER['HTTP_CLIENT_IP'])) 
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		return null;
	}

	public function getRemoteIP() 
	{
		if (isset($_SERVER['REMOTE_ADDR'])) 
		{
			return $_SERVER['REMOTE_ADDR'];
		}

		return null;
	}

	public function getAcceptLanguage() 
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) 
		{
			return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		}

		return null;
	}

	public function isHead() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::HEAD) ? true : false;
	}
	
	public function isPatch() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::PATCH) ? true : false;
	}
	
	public function isPut() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::PUT) ? true : false;
	}
	
	public function isOptions() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::OPTIONS) ? true : false;
	}

	public function isDelete() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::DELETE) ? true : false;
	}

	public function isGet() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::GET) ? true : false;
	}

	public function isPost() 
	{
		return (strtoupper($this->getRequestMethod()) === HTTPRequestMethod::POST) ? true : false;
	}

	public function getPostParamter($parameter) 
	{
		$string = null;

		if ($this->isPost()) 
		{
			$string = isset($_POST[$parameter]) ? $_POST[$parameter] : null;
		}

		return $string;
	}

	public function getGetParamter($parameter) 
	{
		$string = null;

		if ($this->isGet()) 
		{
			$string = isset($_GET[$parameter]) ? $_GET[$parameter] : null;
		}

		return $string;
	}

	public function getHost() 
	{
		$port = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
		$host = sprintf('%s%s%s', $port, $_SERVER['HTTP_HOST'], dirname($_SERVER['DOCUMENT_URI']));

		return $host;
	}

	public function isMobile() 
	{
		$useragent = strtolower($this->getUserAgent());

		$mobileRegex = '/(android|bb\d+|meego).+mobile|avantgo|pda;|htc(_|-)|bada\/|blackberry|brew|blazer|tablet|nexus|compal|teleca|minimo|lg;|wap;|elaine|eudoraweb|sonyericsson|samsung|webos\/|nintendo|nokia|fennec|hiptop|itouch|iemobile|palmos|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i';

		$mobileRegex2 = '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i';

		if (preg_match($mobileRegex, $useragent) || preg_match($mobileRegex2, substr($useragent, 0, 4))) 
		{
			return true;
		}

		return false;
	}

	public function isCrawler() 
	{
		$useragent = strtolower($this->getUserAgent());

		$crawlerRegex = "/bot|crawl|google|yahoo|slurp|spider|yeti|daum|teoma|fish|hanrss|facebook|yandex|infoseek|askjeeves|stackrambler|spyder|watchmouse|pingdom\.com|feedfetcher-google/";

		if (preg_match($crawlerRegex, $useragent)) 
		{
			return true;
		}

		return false;
	}

	public function isConnectionKeepAlive() 
	{
		$connection = strtolower($this->getHTTPConnection());

		return $connection === 'keep-alive';
	}

	public function hasReferer() 
	{
		if (isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['SCRIPT_URL'])) 
		{
			$referer = $_SERVER['HTTP_REFERER'];
			$url     = $_SERVER['SCRIPT_URL'];

			return strpos($referer, $url) === 0;
		}

		return false;
	}
	
}
