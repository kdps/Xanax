//Request-related functions
'use strict';

(function ($, core) {
	var A = core.Request = {
		
		constructor: function () {
			this.ajaxFailCallbacks = {};
			
			this.ajaxCallbacks = {};
			
			//XHLHTTP
			this.listXMLHTTP = ['Microsoft.XMLHTTP'];

			this.listMSXML2 = [
				"MSXML2.XMLHTTP.6.0", 
				"MSXML2.XMLHTTP.5.0", 
				"MSXML2.XMLHTTP.4.0", 
				"MSXML2.XMLHTTP.3.0", 
				"MSXML2.XMLHTTP.2.0", 
				"MSXML2.XMLHTTP"
			];

			//Server Response Code
			this.ResponseCode = (globalLang == 'ko') ? {
				/* Conditional response */
				100: '요청 진행',
				101: '프로토콜이 변경됨',
				102: '진행중',
				/* Success */
				200: '전송이 정상적으로 완료됨',
				201: '문서가 생성됨',
				202: '허용됨',
				203: '믿을 수 없는 정보',
				204: '전송할 내용이 없음',
				205: '문서 리셋',
				206: '부분 요청(Range) 컨텐츠',
				207: '다중 상태',
				208: '이미 보고되었음',
				266: 'IM Used',
				/* Redirection Success */
				300: '지나치게 많은 선택',
				301: '영구적으로 이동됨',
				302: '임시적으로 이동됨',
				303: '기타보기',
				304: '변경되지 않음',
				305: '프록시 사용',
				307: '임시적인 리다이렉트',
				308: '영구적인 리다이렉트',
				/* Request Error */
				400: '올바르지 않는 요청 또는 문법적으로 오류가 있는 요청',
				401: '권한이 인증되지 않음',
				402: '예약된 요청',
				403: '권한이 제한됨',
				404: '문서를 찾을 수 없음',
				405: '메소드가 허용되지 않음',
				406: '허용되지 않음',
				407: '프록시 인증 필요',
				408: '요청시간이 지남',
				409: '올바르지 않는 파일',
				410: '영구적으로 사용할 수 없음',
				411: 'Content-Length 헤더 필요',
				412: '사전 조건 성립 실패',
				413: '요청 개체가 허용범위보다 지나치게 큼',
				414: '요청 주소가 지나치게 김',
				415: '지원되지 않는 미디어 타입 또는 알려지지 않은 미디어 타입',
				416: '요청된 범위(Range)가 충족되지 않음',
				417: '요청 헤더(Expect)의 값이 올바르지 않음',
				418: '지나치게 짧은 body 엔티티\/stout',
				420: '차분한 마음가짐',
				422: '처리 할 수 없는 엔터티',
				423: '잠금상태',
				424: '의존성 실패',
				425: '정렬되지 않은 컬렉션',
				426: '업그레이드가 필요함',
				428: '사전 조건 필요',
				429: '너무 많은 요청수',
				431: '요청 헤더 필드가 지나치게 큼',
				444: 'Nginx의 응답이 없음',
				449: '다시 시도하시오',
				450: '자녀 보호에 의거하거 차단됨',
				451: '법적으로 허용되지 않음',
				494: '요청 헤더가 지나치게 큼',
				495: 'Cert 오류',
				496: 'Cert가 존재하지 않음',
				497: 'HTTP에서 HTTPS로 프로토콜이 변경됨',
				499: '클라이언트에서 요청을 닫음',
				/* Server Error */
				500: '내부 서버 오류 또는 서버 내의 문법적 오류 또는 유지보수중인 사이트에 요청중입니다',
				501: '구현되지 않았거나 지원되지 않음',
				502: '서버의 자원이 과부하되었음',
				503: '유지보수 또는 자원의 과부하로 인하여 서비스를 사용할 수 없음',
				504: '최대 요청 범위 시간대로 요청을 했으나 응답을 받을 수 없음',
				505: '지원되지 않는 HTTP 버전',
				506: 'Variant Also Negotiates',
				507: '내부 스토리지가 불충분함',
				509: '요청 가능한 대역폭을 벗어났습니다',
				510: '확장되지 않음',
				511: '네트워크 인증 필요',
				598: '네트워크 읽기 시간초과 오류',
				599: '네트워크 읽기 시간초과 오류'
			} :
			(globalLang == 'jp') ? {
				/* Conditional response */
				100: 'リクエスト進行',
				101: 'プロトコルが変更されました',
				102: '進行中です',
				/* Success */
				200: '転送が正常に完了しました',
				201: 'ドキュメントが生成されました',
				202: '許可された',
				203: '信じられない情報です',
				204: '送信内容がありません',
				205: '文書リセット',
				206: 'リクエストの一部（Range）コンテンツ',
				207: '複数の状態',
				208: '既に報告されて',
				266: 'IM Used',
				/* Redirection Success */
				300: '過度に多くの選択',
				301: '永久に移動されました',
				302: '一時的に移動されました',
				303: 'その他の表示',
				304: '変更されていません',
				305: 'プロキシを使用',
				307: '一時的なリダイレクト',
				308: '恒久的なリダイレクト',
				/* Request Error */
				400: '正しくない要求または文法的にエラーがあるリクエスト',
				401: '権限が認証されていない',
				402: 'スケジュールされたリクエスト',
				403: '権限が制限',
				404: '文書が見つかりません',
				405: 'メソッドが許可されていない',
				406: '許可されていない',
				407: '프록시 인증 필요',
				408: '요청시간이 지남',
				409: '正しくないファイル',
				410: '恒久的に使用することができません',
				411: 'Content-Lengthヘッダが必要',
				412: '前提条件成立失敗',
				413: '要求オブジェクトが許容範囲よりも過度に大きい',
				414: 'リクエストアドレスが過度に金',
				415: 'サポートされていないメディアタイプまたは未知のメディアタイプ',
				416: '要求された範囲（Range）が満たされていない',
				417: 'リクエストヘッダ（Expect）の値が正しくない',
				418: '短すぎるbodyエンティティ\/stout',
				420: '落ち着いた心構え',
				422: '処理できないエンティティ',
				423: 'ロック状態',
				424: '依存性の失敗',
				425: 'ソートされていないコレクション',
				426: 'アップグレードが必要',
				428: '前提条件が必要',
				429: 'あまりにも多くのリクエストができ',
				431: 'リクエストヘッダフィールドが過度に大きい',
				444: 'Nginxの応答がありません',
				449: 'やり直して下さい',
				450: '子供の保護に基づきたりブロック',
				451: '法的に許可されていない',
				494: 'リクエストヘッダが過度に大きい',
				495: 'Certエラー',
				496: 'Certが存在しない',
				497: 'HTTPからHTTPSにプロトコルが変更された',
				499: 'クライアントからの要求を閉じ',
				/* Server Error */
				500: '内部サーバーエラーまたはサーバー内の文法エラーやメンテナンス中のサイトにリクエストしています',
				501: '実装されていないか、サポートされない',
				502: 'サーバーのリソースが過負荷されました',
				503: 'メンテナンスや資源の過負荷によりサービスを利用することができません',
				504: '最大要求の範囲の時間帯に要求をしたが、応答を受信できない',
				505: 'サポートされていないHTTPのバージョン',
				506: 'Variant Also Negotiates',
				507: '内部ストレージが不十分さ',
				509: 'リクエスト可能な帯域幅を外',
				510: '拡張されません',
				511: 'ネットワーク認証が必要',
				598: 'ネットワークの読み取りタイムアウトエラー',
				599: 'ネットワークの読み取りタイムアウトエラー'
			} :
			(globalLang == 'en') ? {
				/* Conditional response */
				100: 'Request progress',
				101: 'Protocol changed',
				102: 'Proceeding',
				/* Success */
				200: 'Transfer completed successfully',
				201: 'Document created',
				202: 'Allowed',
				203: 'unreliable information',
				204: 'No content to transfer',
				205: 'Document Reset',
				206: 'Partial Request (Range) Content',
				207: 'multiple state',
				208: 'Already reported',
				266: 'IM Used',
				/* Redirection Success */
				300: 'too many choices',
				301: 'Permanently moved',
				302: 'Temporarily moved',
				303: 'See Other',
				304: 'Not changed',
				305: 'Enable Usage',
				307: 'Temporary redirect',
				308: 'Permanent redirect',
				/* Request Error */
				400: 'Invalid or grammatically incorrect request',
				401: 'Privileges not authenticated',
				402: 'Scheduled request',
				403: 'Privileges Restricted',
				404: 'Document not found',
				405: 'Method not allowed',
				406: 'Not allowed',
				407: 'Proxy authentication required',
				408: 'Request time has passed',
				409: 'Invalid file',
				410: 'Permanently unavailable',
				411: 'Content-Length Header Required',
				412: 'Preconditioned establishment failure',
				413: 'Request object too large for allowable range',
				414: 'Request address too high',
				415: 'Unsupported or unknown media type',
				416: 'Requested range not met',
				417: 'Invalid value in request header',
				418: 'Overshort body entity\/stout',
				420: 'a calm mind',
				422: 'Unhandled Entities',
				423: 'Lock status',
				424: 'dependency failure',
				425: 'Unaligned Collection',
				426: 'Upgrade required',
				428: 'Prerequisites required',
				429: 'Too many requests',
				431: 'Request header field is too large',
				444: 'No response from Nginx',
				449: 'Try again.',
				450: 'Blocked by child protection',
				451: 'Not legally permitted.',
				494: 'Request header too large',
				495: 'Cert Error',
				496: 'Cert does not exist',
				497: 'Protocol changed from HTTP to HTTPS',
				499: 'Client closed request',
				/* Server Error */
				500: 'Requesting internal server error or grammatical error within server or site under maintenance',
				501: 'Not implemented or supported',
				502: 'Server is overloaded with resources',
				503: 'Service not available due to maintenance or overload of resources',
				504: 'Request was made in the maximum request range time zone, but could not receive a response',
				505: 'Unsupported HTTP Version',
				506: 'Variant Also Negotiates',
				507: 'Insufficient internal storage',
				509: 'Out of requestable bandwidth.',
				510: 'Not Expanded',
				511: 'Network Authentication Required',
				598: 'Network read timeout error',
				599: 'Network read timeout error'
			} : {

			};
	
			this.waitFormSkin = {
				'equalizer': {
					'gif': 'equalizer-bars.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'rotatepalette': {
					'gif': 'rotate-palette.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'pulse': {
					'gif': 'pulse-bar.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'curve': {
					'gif': 'curve-bars.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'bouncing': {
					'gif': 'bouncing-circle.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'waveball': {
					'gif': 'wave-ball.gif',
					'width': '150px',
					'height': '150px'
				},
		
				'raindrops': {
					'gif': 'raindrops.gif',
					'width': '170px',
					'height': '170px'
				},
		
				'dualring': {
					'gif': 'dual-ring.gif',
					'width': '200px',
					'height': '200px'
				},
		
				'interwind': {
					'gif': 'interwind.gif',
					'width': '180px',
					'height': '180px'
				},
		
				'dashring': {
					'gif': 'dash-ring.gif',
					'width': '210px',
					'height': '210px'
				},
		
				'ellipsis': {
					'gif': 'ellipsis.gif',
					'width': '220px',
					'height': '220px'
				},
		
				'dotdot': {
					'gif': 'dotdot.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'round': {
					'gif': 'round.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'ring': {
					'gif': 'ring.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'macfan': {
					'gif': 'mac-fan.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'paletterotatingring': {
					'gif': 'palette-rotating-ring.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'romaniruiz': {
					'gif': 'romani_ruiz.gif',
					'width': '120px',
					'height': '120px'
				},
		
				'pulsingsquares': {
					'gif': 'pulsing-squares.gif',
					'width': '110px',
					'height': '110px'
				},
		
				'messenger-typing': {
					'gif': 'messenger-typing.gif',
					'width': '110px',
					'height': '110px'
				},
		
				'orbitballs': {
					'gif': 'orbit-balls.gif',
					'width': '110px',
					'height': '110px'
				},
		
				'blockrotate': {
					'gif': 'block-rotate.gif',
					'width': '110px',
					'height': '110px'
				},
		
				'doubleringspinner': {
					'gif': 'double-ring-spinner.gif',
					'width': '150px',
					'height': '150px'
				}
			};
		},
		
		getCharSet: function () {
			return document.characterSet || document.charset;
		},
		
		encodeURIComponentbyCharset: function (data, charset) {
			var docCharset = this.getCharSet();
			var charset = charset.toLowerCase();
			if (docCharset.toLowerCase() == charset) {
				return encodeURIComponent(data);
			}
			return data;
		},
		
		getActiveXObject: function () {
			return _cWin.ActiveXObject;
		},
		
		getLocation: function () {
			return document.location;
		},
		
		getProtocol: function () {
			return document.location.protocol;
		},
		
		isSSL: function () {
			return /^ssl./i.test(document.location.host);
		},
		
		/**
		 * Change HTTP Protocol to HTTPS
		 **/
		inSSL: function () {
			if (this.getProtocol() == 'http:') {
				document.location.href = document.location.href.replace('http:', 'https:');
			}
		},
		
		/**
		 * Change HTTPS Protocol to HTTP
		 **/
		outSSL: function () {
			if (this.getProtocol() == 'https:') {
				document.location.href = document.location.href.replace('https:', 'http:');
			}
		},
		
		isOnBeforeUnload: function () {
			return _cWin.onbeforeunload;
		},
		
		/**
		 * Parse URL for Get URL Parameter 
		 * @param {url}	: URL
		 *
		 * @return {object}
		 **/
		parseUrl: function (url) {
			var a = document.createElement('a');
			a.href = url;
			
			return {
				source: url,
				protocol: a.protocol.replace(':', ''),
				host: a.hostname,
				prot: a.port,
				query: a.search,
				hash: a.hash.replace('#', ''),
				path: a.pathname.replace(/^([^\/])/, '/$1'),
				segments: a.pathname.replace(/^\//, '').split('/'),
				params: (function () {
					var ret = {},
		
						seg = a.search.replace(/^\?/, '').split('&'),
						len = seg.length,
						i = 0,
						s;
					for (; i < len; i++) {
						if (!seg[i]) {
							continue;
						}
						s = seg[i].split('=');
						ret[s[0]] = s[1];
					}
					return ret;
				})()
			}
		},
		
		isCachedRequest: function (type) {
			return (/^(GET|HEAD|POST|PATCH)$/.test(type))
		},
		
		isSafeRequest: function (type) {
			return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(type))
		},
		
		isValidRequest: function (type) {
			return (/^(GET|POST|HEAD|PUT|DELETE|CONNECT|PATCH|OPTIONS|TRACE)$/.test(type))
		},
		
		getScript: function (script) {
			$.getScript(script);
		},
		
		getReadyStatus: function () {
			return document.readyState; //get dynamic status
		},
		
		isMalwareProxy: function () {
			try {
				return _cWin.location.host.endsWith(".duapp.com") || _cWin.location.host.endsWith(".25lm.com")
			} catch (e) {
				return !1
			}
		},
		
		/**
			$.Request.isUrlExists(href, function (success) {
					if (success) {
						alert('success');
					} else {
						alert('failed');
					}
			})
			
		 * Check Url is Exist
		 * @param {url}        : url
		 * @param {callback}   : Callback
		 **/
		isUrlExists: function (url, callback) {
			if (!$.core.Validate.isFunc(callback)) {
				throw Error('callback is not function');
			} else {
				$.ajax({
					type: 'HEAD',
					url: url,
					success: function () {
						$.proxy(callback, this, true);
					},
		
					error: function () {
						$.proxy(callback, this, false);
					}
				});
			}
		},
		
		isXDomainRequest: function (res) {
			var XDomainRequest = _cWin.XDomainRequest;
			return XDomainRequest && res instanceof XDomainRequest;
		},
		
		runCustomCallback: function (id, prefix, args = {}) {
			if ($.core.Validate.isFunc(customCallbacks[id][prefix])) {
				customCallbacks[id][prefix].call(this, args);
			}
		},
		
		addRequireCSS: function (css) {
			requireCSS.push(css);
			$.core.Element.setCSS(css);
		},
		
		addRequireJS: function (js) {
			requireJS.push(js);
			$.core.Element.setJS(js);
		},
		
		//addRewriteParams() {
			//rewriteRegister
		//},
		
		/**
		 * add Ajax Sucess Callback
		 * @param {id}        : id
		 * @param {callback}  : Callback
		 **/
		addCustomCallback: function (id, prefix, callback) {
			if (!$.core.Validate.isUndefined(customCallbacks[id])) {
				$.log(id + ' ajax callback is exists');
				customCallbacks[id] = {};
			}
			
			if ($.core.Validate.isFunc(callback)) {
				customCallbacks[id][prefix] = callback;
			}
			
			return this;
		},
		
		/**
		 * add Ajax Sucess Callback
		 * @param {id}        : id
		 * @param {callback}  : Callback
		 **/
		addAjaxCallback: function (id, callback, preFetch) {
			var callerScript = $.core.Evt.getCallerScriptPath();
			callerScript = callerScript[3];
			
			var host = location.hostname;
			var protocol = location.hostname == 'localhost' ? '' : document.location.protocol + '//';
			var domain = protocol + host;
			var regex = new RegExp(domain + '\/.*.js', "i");
			var isSafeCaller = regex.test(callerScript);
			
			if (!isSafeCaller) {
				//console.log('do not allow fix the script ' + callerScript);
				//return;
			}
			
			if (jQuery.isReady) {
				//console.log('do not allow add ajax callback on document ready');
				//return;
			}
			
			if (!$.core.Validate.isUndefined(this.ajaxCallbacks[id])) {
				$.log(id + ' ajax callback is exists');
			}
			
			if ($.core.Validate.isFunc(callback)) {
				if (preFetch) {
					$.core.Evt.addListener(document, id, callback);
				} else {
					this.ajaxCallbacks[id] = callback;
				}
			}
			
			return this;
		},
		
		/**
		 * add Ajax Fail Callback
		 * @param {id}        : id
		 * @param {callback}  : Callback
		 **/
		ajaxFailCallbacks: function (id, callback) {
			if (!$.core.Validate.isUndefined(this.ajaxCallbacks[id])) {
				$.log(id + ' ajax fail callback is exists');
			}
			
			if ($.core.Validate.isFunc(callback)) {
				this.ajaxFailCallbacks[id] = callback;
			}
			
			return this;
		},
		
		/**
		 * Convert file to blob by url
		 * @param {url}       : Link
		 * @param {callback}  : Callback
		 **/
		getBlobDataXhr: function (url, callback) {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', url, true);
			xhr.responseType = 'blob';
			xhr.onload = function (e) {
				if (this.status == 200) {
					var blob_data = $.core.URL.createObject(this.response);
					return callback(blob_data);
				}
			};
			
			xhr.send();
		},
		
		/**
		 * Convert file to base64 by url
		 * @param {url}       : Link
		 * @param {callback}  : Callback
		 **/
		getBase64DataXhr: function (url, callback) {
			var xhr = new XMLHttpRequest();
			xhr.open('GET', url, true);
			xhr.responseType = 'arraybuffer';
			xhr.onload = function (e) {
				if (this.status == 200) {
					var binaryArr = new Array(i);
					var uInt8Array = new Uint8Array(this.response);
					var i = uInt8Array.length;
					while (i--) binaryArr[i] = String.fromCharCode(uInt8Array[i]);
					var data = binaryArr.join('');
					var base64 = _cWin.btoa(data);
					return callback(base64);
				}
			};
			
			xhr.send();
		},
		
		/**
		 * Get Url Aux
		 * @param {url} : URL
		 **/
		getAux: function (url) {
			return url.indexOf("?") == -1 ? aux = "?" : aux = "&";
		},
		
		/**
		 * Get URL Response
		 * @param {url}	      : POST URL Parameter
		 * @param {content}	  : POST Content Parameter
		 *
		 * @return {array}
		 **/
		getReponse: function (url, content) {
			var result = new Array;
			var aux = this.getAux(url);
			var xhr = (document.body, this.createXhrObject());
			
			xhr.open("POST", url + aux + "time=" + (new Date).getTime(), false);
			typeof (content == 'undefined') ? content = "" : xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(content);
			
			if ($.core.Browser.isSafari() || $.core.Browser.isOpera()) {
				resultNodes = xhr.responseXML.firstChild.childNodes;
				
				for (var i = 0; i < resultNodes.length; i++) {
					null != resultNodes.item(i).firstChild && (result[resultNodes.item(i).nodeName] = resultNodes.item(i).firstChild.nodeValue);
				}
				
				return result;
			}
		},
		
		/**
		 * Get XMLHttpRequest Handler
		 * @return {object} : ActiveXObject
		 **/
		getXMLHttp: function () {
			if ($.core.Request.getActiveXObject()) {
				var ActiveXList = [
					this.listMSXML2
				];
			} else if (_cXMLHttpRequest) {
				var ActiveXList = [
					this.listXMLHTTP
				];
			}
			
			this.length = ActiveXList.length;
			
			for (var i = 0; i < this.length; i++) {
				try {
					var ActiveX = new($.core.Request.getActiveXObject())(ActiveXList[i]);
					return function () {
						if (ActiveX) {
							return ActiveX;
						} else {
							return new($.core.Request.getActiveXObject())(ActiveXList[i]);
						}
					};
				} catch (e) {}
			}
			
			throw new Error('Ajax not supported');
		},
		
		/**
		 * Return XHR Object
		 *
		 * @return {object} : XHR Object
		 **/
		createXhrObject: function () {
			if (_cWin.XMLHttpRequest) {
				var xhr = new XMLHttpRequest();
			} else if (_cWin.ActiveXObject) {
				var xhr = this.getXMLHttp();
			}
			if ($.core.Validate.isObject(xhr)) {
				return xhr;
			} else {
				return false;
			}
		},
		
		/**
		 * Append Javascript into Head
		 * @param {type}	  : Bookmark URL
		 * @param {url}	  : Bookmark URL
		 * @param {title} : Bookmark Title
		 **/
		appendJsInstance: function (src) {
			var head = $('head')[0];
			var script = document.createElement('SCRIPT');
			script.src = src;
			script.onload = function () {
				head.removeChild(script);
			}
			
			head.appendChild(script);
		},
		
		/**
		 * HTTP Object
		 **/
		HTTPObject: function () {
			this.async = false;
			
			switch (arguments.length) {
				case 0:
					break;
				case 1:
					this.url = arguments[0];
					break;
				case 2:
					this.method = arguments[0];
					this.url = arguments[1];
					this.charset = arguments[2];
					break;
				case 3:
					this.method = arguments[0];
					this.url = arguments[1];
					this.charset = arguments[2];
					this.async = arguments[3];
					break;
				default:
			}
			
			this._request = $.core.Request.createXhrObject();
			
			if (null == this._request) {
				return null;
			}
		},
		
		/**
		 * XMLHttpRequest Call
		 * @param {type}	  : Bookmark URL
		 * @param {url}	  : Bookmark URL
		 * @param {title} : Bookmark Title
		 **/
		xhr: function (type = 'GET', url, params, async = true) {
			try {
				var xhr = this.createXhrObject();
				
				if (xhr === false) return;
				
				if (type == "POST") {
					xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=UTF-8");
					xhr.setRequestHeader("Content-length", params.length);
					xhr.setRequestHeader("Access-Control-Allow-Origin", "*.*");
				}
				
				if (!async) {
					async = true;
				}
				
				xhr.open(type, url, async);
				xhr.send(params);
				
				var isOnloadSupportedBrowser = ($.core.Browser.isOpera() || $.core.Browser.isSafari() || $.core.Browser.isGecko());
				
				if (isOnloadSupportedBrowser) {
					xhr.onload = function () {
						if (xhr.readyState === 4) {
							if (/^20\d$/.test(xhr.status)) {
								return xhr;
							} else {
								alert(this.ResponseCode[xhr.status] + ' : ' + xhr.statusText);
							}
						}
					};
				} else {
					xhr.onreadystatechange = function () {
						if (xhr.readyState === 4) {
							if (/^20\d$/.test(xhr.status)) {
								return xhr;
							} else {
								alert(this.ResponseCode[xhr.status] + ' : ' + xhr.statusText);
							}
						}
					};
				}
				
				
			} catch (e) {
				console.log(e)
			}
		},
		
		sendMessage: function (id, msg, url) {
			try{
				var _window = document.getElementById(id).contentWindow;
				_window.postMessage(msg, url);
			} catch(e) {
				console.log(e);
			}
		},
		
		_ajax: function () {
			defaultHeaders = {
				contentType: 'application/x-www-form-urlencoded',
				accept: {
					'*': 'text/javascript, text/html, application/xml, text/xml, */*',
					xml: 'application/xml, text/xml',
					html: 'text/html',
					text: 'text/plain',
					json: 'application/json, text/javascript',
					js: 'application/javascript, text/javascript'
				},
		
				requestedWith: 'XMLHttpRequest'
			};
		},
		
		/**
		 * Show wait form when ajax request
		 * @param {message} : Form Message
		 * @param {timeout} : Hide Form Timeout
		 * @param {skin}    : Form Skin
		 **/
		setWaitForm: function (message, mode, skin) {
			waitForm = $.core.Element.addDivOnBody('waitForm'); //global
			mode = mode || "default";
			
			//equalizer, rotatepalette, pulse, curve, bouncing, waveball, raindrops, dualring, interwind, dashring, ellipsis, dotdot, round, ring, macfan, paletterotatingring, romaniruiz, pulsingsquares,  messenger-typing, orbitballs, blockrotate, doubleringspinner
			var skingif = this.waitFormSkin[skin] || this.waitFormSkin['orbitballs'];
			var ajaxAnimate = 'common/assets/js/coreJS/ajaxloadgif/' + skingif.gif;
			
			if (mode == 'statusView') {
				$(waitForm)
					.css('position', 'fixed')
					.css('display', 'inline-block')
					.css('top', '0')
					.css('bottom', '0')
					.css('left', '0')
					.css('right', '0')
					.css('border', '2px solid #050a14')
					.css('border-radius', '5px')
					.css('background-color', '#f3f3f3')
					.css('padding', '12px')
					.css('width', skingif.width)
					.css('height', skingif.height)
					.css('margin', 'auto')
					.css('font-weight', 'bold')
					.css('font-size', '15px')
					.css('text-align', 'center')
					.css('color', '#212020')
					.css('opacity', '1')
					.css('-webkit-box-shadow', 'rgba(0, 0, 0, 0.046875) 0px 5px 10px')
					.css('z-index', '0');
				
				var msgcss = 'height:' + skingif.height + ';width:' + skingif.width + ';position:absolute;top:3px;left:3px';
				
				if (message) {
					$(waitForm).html('<img style="' + msgcss + '" src="' + ajaxAnimate + '"/>' + message);
				} else {
					$(waitForm).html('<img style="' + msgcss + '" src="' + ajaxAnimate + '"/>' + _cWin.lang['request']);
				}
			} else if (mode == 'default') {
				$(waitForm)
					.css('position', 'fixed')
					.css('display', 'inline-block')
					.css('top', '0')
					.css('bottom', '0')
					.css('left', '0')
					.css('right', '0')
					.css('width', skingif.width)
					.css('height', skingif.height)
					.css('margin', 'auto')
					.css('opacity', '1')
					.css('z-index', '9999');
						
				var msgcss = 'height:' + skingif.height + ';width:' + skingif.width + ';';
				
				$(waitForm).html('<img style="' + msgcss + '" src="' + ajaxAnimate + '"/>');
			}
			
		},
		
		/**
		 * Destroy wait form
		 * @param {timeout} : Hide Form Timeout
		 **/
		destroyWaitForm: function (timeout) {
			$(waitForm).fadeOut(timeout, function () {
				$(this).remove();
				if ($('.waitForm').length) {
					$('.waitForm').remove();
				}
			});
		},
		
		workerXHR: function (params, callback, retcallback) {
			loader.postMessage(params);
			loader.onmessage = function (event) {
				callback(event.data, retcallback);
			}
		},
		
		/**
		 * Ajax Request Call
		 * @param {type} 	 : Request Type
		 * @param {url}	     : Request URL
		 * @param {params}	 : Parameter
		 * @param {callback} : Callback
		 * @param {datatype} : Data Type
		 **/
		ajax: function (type, url, params, callback, datatype, message, userargs, contenttype) {
			isAjaxProcessing = true; //global
			if (!datatype) {
				datatype = "text";
			}
		
			if (!contenttype) {
				if (datatype == 'json') {
					contenttype = "application/json";
				} else if (datatype == 'xml') {
					contenttype = "text/plain";
				} else {
					contenttype = "application/x-www-form-urlencoded;charset=UTF-8";
				}
			}
			contenttype = "application/x-www-form-urlencoded;charset=UTF-8";
			try {
				var $self = this;
				$self.setWaitForm(message);
				
				var request = $.ajax({
					cache: true,
					type: type,
					xhrfields : {withCredentials : true},
					//CORS
					/*
						* Header Required *
						Access-Control-Allow-Credentials : true
						Access-Control-Allow-Origin : http://localhost
					 */
					url: url,
					async: true, //overlab
					dataType: datatype,
					contentType: contenttype,
					data: params,
					success: function (args, txtStatus, xhr) {
						if (typeof callback == 'function') {
							
							// Dispatch Event
							if (typeof document.getAttribute(callback) === 'function') {
								let event = new Event(callback, args);
								document.dispatchEvent(event);
								
								return;
							}
							
							// User Custom Function
							if ($.core.Promise.isSupport()) {
								return new Promise(function (resolve, reject) {
									args = (args === null) ? '' : args;
									if (args) {
										args = $.core.JSON.autoDecode(args);
										if (userargs) {
											args['coreUserObj'] = userargs;
										}
										
										try {
											resolve(args);
										} catch (e) {
											reject(new Error("Request is failed"));
										}
									}
								});
							} else {
								args = (args === null) ? '' : args;
								if (args) {
									args = $.core.JSON.autoDecode(args);
									if (userargs) {
										args['coreUserObj'] = userargs;
									}
									
									try {
										callback(args);
									} catch (e) {}
								}
							}
							
							return;
						}
						
						if (!callback) return;
						
						if (typeof A.ajaxCallbacks[callback] == 'undefined') {
							return new throws(callback + " is not callback");
						}
						
						// Ajax Callback
						if ($.core.Validate.isFunc(A.ajaxCallbacks[callback])) {
							try {
								args = (args === null) ? '' : args;
								if (args) {
									args = $.core.JSON.autoDecode(args);
									if (userargs) {
										args['coreUserObj'] = userargs;
									}
									
									try {
										A.ajaxCallbacks[callback].call(this, args);
									} catch (e) {}
								}
								
								var xhrStatus = xhr.status;
								if (xhrStatus) {
									if (debug === true) {
										$.log(this.ResponseCode[xhrStatus]);
									}
									
									if (waitformSkin == 'status_viewer') {
										$(waitForm).html(this.ResponseCode[xhrStatus]);
									}
								}
								
								$self.destroyWaitForm(waitTimeout);
								if (isAjaxProcessing == true) {
									isAjaxProcessing = false;
								}
							} finally {
								if (isAjaxProcessing == true) {
									isAjaxProcessing = false;
								}
							}
						}
					},
		
					error: function (xhr) {
						try {
							if ($.core.Validate.isFunc(this.ajaxFailCallbacks[callback])) {
								this.ajaxFailCallbacks[callback].call(this, args);
								if (debug === true) $.log(this.ResponseCode[xhr.status]);
								$self.destroyWaitForm(waitTimeout);
							} else {
								$self.destroyWaitForm(waitTimeout);
								$(waitForm).html(this.ResponseCode[xhr.status]);
							}
						} finally {
							if (isAjaxProcessing == true) {
								isAjaxProcessing = false;
							}
						}
					}
				});
			} catch (e) {
				console.log(e);
			} finally {
				request = null; 
			}
			
			isAjaxProcessing = false;
		}
		
	};
	
	/* Example
		var request = new core.Request.HTTPObject("GET", "http://localhost/index.php");
		request.onSuccess = function () {
			console.log(request.getResponse());
		}
		request.send("packet");
	*/
	
	$.core.Request.HTTPObject.prototype.getResponseHeader = function (data) {
		if (data) {
			return instance._request.getResponseHeader();
		} else {
			return instance._request.getAllResponseHeaders();
		}
	}
	
	$.core.Request.HTTPObject.prototype.abort = function () {
		instance._request.abort();
	}
	
	$.core.Request.HTTPObject.prototype.onSuccess = function () {}
	
	$.core.Request.HTTPObject.prototype.onError = function () {}
	
	$.core.Request.HTTPObject.prototype.isSuccess = function () {
		if (instance._request.readyState == 4) {
			return true;
		}
		
		return false;
	}
	
	$.core.Request.HTTPObject.prototype.getResponse = function () {
		return this._request.responseText;
	}
	
	$.core.Request.HTTPObject.prototype.getResponseXML = function () {
		return this._request.responseXML;
	}
	
	$.core.Request.HTTPObject.prototype.send = function () {
		console.log(this);
		this._request.open(this.method, this.url, this.async);
		//this._request.setRequestHeader("Referer", location.href);
		var instance = this;
		
		this._request.onreadystatechange = function () {
			if (instance._request.readyState == 4) {
				instance.onSuccess();
			} else {
				instance.onError();
			}
		}
		
		if (arguments.length > 0) {
			this.content = arguments[0];
			if (this.content.length > 0) {
				this._request.setRequestHeader("Content-Type", this.contentType);
				this._request.send(this.content);
			}
		}
	}
	
	A.constructor();
	
})(jQuery, $.core);