
let apply = function (dom) {
	
	dom.click = function (callback) {
		sjs.addEventListener(dom, 'click', callback);
	};
	
	dom.dblclick = function (callback) {
		sjs.addEventListener(dom, 'dblclick', callback);
	};
	
	dom.mouseover = function (callback) {
		sjs.addEventListener(dom, 'mouseover', callback);
	};
	
	dom.mouseleave = function (callback) {
		sjs.addEventListener(dom, 'mouseleave', callback);
	};
	
	dom.menuToggleClass = function (cls) {
		$.core.Element.setMenuToggleClass(dom, cls);
	};

	dom.appendDiv = function (cls) {
		if (cls.match(/^\..*$/i)) {
			return $.core.Element.appendDiv(cls);
		} else if (cls.match(/^#.*$/i)) {
			return $.core.Element.appendDivId(cls);
		}
	};
	
	dom.top = function () {
		return $.core.Element.getTop(dom);
	};
	
	dom.left = function () {
		return $.core.Element.getLeft(dom);
	};
	
	dom.getTextNode = function () {
		return $.core.Element.getTextNode(dom);
	};
	
	dom.parseString = function () {
		return $.core.Element.parseString(dom);
	};
	
	dom.isFullScreen = function () {
		return $.core.Screen.isFullScreen(dom);
	};
	
	dom.lineCount = function () {
		return $.core.Str.lineCount(dom);
	};
	
	dom.firstChild = function () {
		return dom.firstChild;
	};
	
	dom.fullScreen = function (val) {
		if (val === true) {
			$.core.Screen.requestFullScreen(dom);
		} else if (val === false) {
			$.core.Screen.cancelFullScreen(dom);
		} else {
			$.core.Screen.toggleFullScreen(dom);
		}
	};
	
	dom.checkBox = function (prop) {
		if (typeof prop === 'undefined') {
			isChekced = $.core.Element.isChecked(dom);
			isChekced ? $.core.Element.setChecked(dom) : $.core.Element.unsetChecked(dom);
		}
		
		if (prop == true) {
			$.core.Element.setChecked(dom);
		} else {
			$.core.Element.unsetChecked(dom);
		}
	};
	
	dom.height = function () {
		return $.core.Element.getHeight(dom);
	};
	
	dom.width = function () {
		return $.core.Element.getWidth(dom);
	};
	
	dom.setAttribute = function (attribute) {
		$.core.Element.setAttribute(dom, attribute);
	};
	
	dom.removeAttribute = function (attribute) {
		$.core.Element.removeAttribute(dom, attribute);
	};
	
	dom.disableDraggable = function () {
		$.core.Evt.disableDraggable();
	};
	
	dom.forceVal = function (val) {
		$.core.Element.forceChange(dom, val);
	};
	
	dom.removeClass = function (cls) {
		$.core.Element.removeClass(dom, cls);
	};
	
	dom.hasClass = function (cls) {
		$.core.Element.hasClass(dom, cls);
	};
	
	dom.addClass = function (cls) {
		$.core.Element.addClass(dom, cls);
	};
	
	dom.isHTMLElement = function () {
		return $.core.Element.isHTMLElement(dom);
	};
	
	dom.parent = function () {
		return dom.parentNode;
	};
	
	dom.getVal = function (val) {
		if (dom.isHTMLElement() && typeof dom.outerHTML !== 'undefined') {
			return $.core.Element.getinnerHTML(dom);
		}
	};
	
	dom.getValue = dom.getVal;
	
	dom.setVal = function (val) {
		$.core.Element.setinnerHTML(dom, val);
	};
	
	dom.setValue = dom.setVal;
	
	dom.val = function (val) {
		if (typeof val === 'undefined') {
			dom.getVal(val);
		} else {
			dom.setVal(val);
		}
	};
	
	dom.value = dom.val;
	
	return dom;
};

let sjs = function (selector) {
	if (typeof selector === 'string') {
		let dom = document.querySelector(selector);
		
		return apply(dom);
	}
};

sjs.winver = $.core.Browser.getWindowsVersion;

sjs.forward = $.core.Browser.Forward;

sjs.refresh = $.core.Browser.Refresh;

sjs.back = $.core.Browser.Back;

sjs.protocol = $.core.Browser.protocol;

sjs.host = $.core.Browser.Host;

sjs.userAgent = $.core.Browser.userAgent;

sjs.isUserNeedPayCost = $.core.Browser.isUserNeedPayCost;

sjs.isCellular = $.core.Browser.isCellular;

sjs.hasConnection = $.core.Browser.hasConnection;

sjs.lang = $.core.Browser.getLang;

sjs.isMac = $.core.Browser.isMac;

sjs.isBlackBerry = $.core.Browser.isBlackBerry;

sjs.isMacPlatform = $.core.Browser.isMacPlatform;

sjs.isSunOS = $.core.Browser.isSunOS;

sjs.isMacPowerPC = $.core.Browser.isMacPowerPC;

sjs.isOpenBSD = $.core.Browser.isOpenBSD;

sjs.isLinux = $.core.Browser.isLinux;

sjs.isIOS = $.core.Browser.isIOS;

sjs.isIE = $.core.Browser.isIE;

sjs.isSafari = $.core.Browser.isSafari;

sjs.isKonqueror = $.core.Browser.isKonqueror;

sjs.isGecko = $.core.Browser.isGecko;

sjs.isChrome = $.core.Browser.isChrome;

sjs.isOpera = $.core.Browser.isOpera;

sjs.isNetscape = $.core.Browser.isNetscape;

sjs.isFirefox = $.core.Browser.isFirefox;

sjs.isWin = $.core.Browser.isWindows;

sjs.disableDrag = $.core.Browser.disableDrag;

sjs.disableContextMenu = $.core.Browser.disableContextMenu;

sjs.chromeVersion = $.core.Browser.chromeVersion;

sjs.is64Bit = $.core.Browser.is64Bit;

sjs.hasConsole = $.core.Browser.hasConsole;

sjs.hasTouchScreen = $.core.Browser.hasTouchScreen;

sjs.isFileProtocol = $.core.Browser.isFileProtocol;

sjs.isLocalhost = $.core.Browser.isLocalhost;

sjs.isDownloadSupport = $.core.Browser.isDownloadSupport;

sjs.isContextMenuSupport = $.core.Browser.isContextMenuSupport;

sjs.screenColorDepth = $.core.Screen.getScreenColorDepth;

sjs.hasPip = $.core.Screen.hasPip;

sjs.addEventListener = function (dom, eventName, handler) {
	$.core.Evt.addEventListener(dom, eventName, handler);
};
	
sjs.play = function (url) {
	$.core.Audio.loadAudio(url);
	$.core.Audio.playAudio();
};

sjs.isJSON = function (json) {
	return $.core.JSON.isJSON(json);
};

sjs.ucfirst = function (str) {
	return $.core.Str.ucFirst(str);
};

sjs.lcase = function (str) {
	return $.core.Str.lcase(str);
};

sjs.len = function (str) {
	return $.core.Str.length(str);
};

sjs.ucase = function (str) {
	return $.core.Str.ucase(str);
};

sjs.rtrim = function (str) {
	return $.core.Str.rtrim(str);
};

sjs.trim = function (str) {
	return $.core.Str.trim(str);
};

sjs.ltrim = function (str) {
	return $.core.Str.ltrim(str);
};

sjs.reverse = function (str) {
	return $.core.Str.reverse(str);
};

sjs.replace = function (find, replace, arr) {
	if (arr === 'undefined') {
		
	} else {
		$.core.Arr.replace(find, replace, arr);
	}
};

sjs.getScrollLeft = $.core.Element.getScrollLeft;

sjs.getScrollTop = $.core.Element.getScrollTop;

sjs.getInnerWidth = $.core.Element.getInnerWidth;

sjs.getInnerHeight = $.core.Element.getInnerHeight;

sjs.isWheelExists = $.core.Element.isWheelExists();

sjs.color = function (text) {
	$.core.Element.getWebColor(text);
};

sjs.copy = function (text) {
	$.core.Clipboard.Copy(text);
};

sjs.isArrayEqual = function (arr1, arr2) {
	return $.core.Arr.isArrayEqual(arr1, arr2);
};

sjs.speecher = function (speecher) {
	if (typeof speecher === 'undefined') {
		return $.core.Speech.getPopularVoiceList();
	}
};

sjs.date = (function() {
	return {
		year: (function () {
			var date = new Date;
			return date.getFullYear();
		}),
		month: (function () {
			var date = new Date;
			return ++date.getMonth();
		}),
		date: (function () {
			var date = new Date;
			return date.getDate();
		})
	};
})();

sjs.time = (function() {
	return {
		now: (function () {
			return $.core.Time.now();
		}),
		date: (function () {
			return $.core.Time.getDate();
		})
	};
})();

sjs.storage = (function() {
	return {
		set: (function (name, value) {
			if (typeof value === 'undefined') {
				return $.core.Storage.setEmpty(name);
			} else {
				return $.core.Storage.setItem(name, value);
			}
		}),
		get: (function (item) {
			return $.core.Storage.getItem(item);
		}),
		isEmpty: (function (item) {
			return $.core.Storage.isEmpty(item);
		}),
		isSupport: (function () {
			return $.core.Storage.isSupport();
		})
	};
})();

sjs.sessionStorage = (function() {
	return {
		clear: (function (item) {
			$.core.sessionStorage.clear();
		}),
		set: (function (item, value, useOverwrite) {
			return $.core.sessionStorage.setItem(item, value, useOverwrite);
		}),
		unset: (function (item) {
			return $.core.sessionStorage.removeItem(item);
		}),
		get: (function (item) {
			if (item === 'undefined') {
				return $.core.sessionStorage.getAllItem();
			} else {
				return $.core.sessionStorage.getItem(item);
			}
		}),
		isEmpty: (function (item) {
			return $.core.sessionStorage.isEmpty(item);
		}),
		isSupport: (function () {
			return $.core.sessionStorage.isSupport();
		})
	};
})();

sjs.cookie = (function() {
	return {
		unset: (function (cName) {
			return $.core.Cookie.unSet(cName);
		}),
		set: (function (cName, cValue, cDay) {
			return $.core.Cookie.Set(cName, cValue, cDay);
		}),
		get: (function (cName) {
			return $.core.Cookie.Get(cName);
		}),
		isAccept: (function () {
			return $.core.Cookie.isAccept();
		}),
	};
})();

sjs.flash = (function() {
	return {
		version: (function () {
			return $.core.Flash.getVersion();
		}),
		get: (function (file, width, height, id, clsID) {
			return $.core.Flash.generate(file, width, height, id, clsID);
		})
	};
})();

sjs.audio = (function(url) {
	return {
		load: (function () {
			$.core.Audio.loadAudio(url);
			
			return this;
		}),
		play: (function () {
			$.core.Audio.playAudio();
		}),
		pause: (function () {
			$.core.Audio.pauseAudio();
		}),
		stop: (function () {
			$.core.Audio.stopAudio();
		}),
		isPlaying: (function () {
			return $.core.Audio.isPlaying();
		})
	};
})();

sjs.notify = (function() {
	return {
		isSupport: (function () {
			return $.core.Notify.isSupport();
		}),
		show: (function (title, message, icon, body, options) {
			$.core.Notify.Show(title, message, icon, body, options);
		}),
		permitLevel: (function () {
			return $.core.Notify.getPermitLevel();
		})
	};
})();

sjs.optionList = (function() {
	return {
		exchange: (function (cls1, cls2) {
			$.core.OptionList.moveSelectedItem(cls1, cls2);
		}),
		moveUp: (function (cls) {
			$.core.OptionList.moveItemUp(cls);
		}),
		moveDown: (function (cls) {
			$.core.OptionList.moveItemDown(cls);
		}),
		moveTop: (function (cls) {
			$.core.OptionList.moveItemTop(cls);
		}),
		moveBottom: (function (cls) {
			$.core.OptionList.moveItemBottom(cls);
		})
	};
})();

sjs.hash = function (str, hash) {
	if (typeof hash === 'undefined') {
		$.core.Str.removeTagHash(str);
	}
};

sjs.getAvoidNotes = function (scale) {
	return $.core.harmonicGenerator.getAvoidNotes(scale);
};

sjs.getMajorChord = function (root) {
	return $.core.harmonicGenerator.getMajorChord(root);
};

sjs.brToLine = function (str) {
	return $.core.Str.brToLine(str);
};

sjs.removeExceptNumber = function (str) {
	return $.core.Str.removeExceptNumber(str);
};

sjs.isNumeric = function (str) {
	return $.core.Str.isNumeric(str);
};

sjs.isEmptyObject = function (str) {
	return $.core.Str.isEmptyObject(str);
};

sjs.isBlobBuilder = function (str) {
	return $.core.Str.isBlobBuilder(str);
};

sjs.isRegex = function (str) {
	return $.core.Str.isRegex(str);
};

sjs.isFormData = function (str) {
	return $.core.Str.isFormData(str);
};

sjs.confirm = function (message, callback) {
	if (typeof callback === 'function') {
		$.core.Browser.answer(message, callback);
	} else {
		return confirm(message);
	}
};

sjs.on = function (object, state, callback) {
	$.core.Evt.addListener(object, state, callback);
};

sjs.getKeyDownCode = function (keyCode) {
	return $.core.Element.getKeyDownCode(keyCode);
};

sjs.addAjaxCallback = function (name, callback) {
	core.Request.addAjaxCallback(name, callback);
};

sjs.isBlank = function (str) {
	return $.core.Str.isBlank(str);
};

sjs.isObject = function (str) {
	return $.core.Str.isObject(str);
};

sjs.isFunction = function (str) {
	return $.core.Str.isFunc(str);
};

sjs.isDate = function (str) {
	return $.core.Str.isDate(str);
};

sjs.isNull = function (str) {
	return $.core.Str.isNull(str);
};

sjs.isArray = function (str) {
	return $.core.Str.isArray(str);
};

sjs.isBool = function (str) {
	return $.core.Str.isBool(str);
};

sjs.isUndefined = function (str) {
	return $.core.Str.isUndefined(str);
};

sjs.isBlob = function (str) {
	return $.core.Str.isBlob(str);
};

sjs.isFile = function (str) {
	return $.core.Str.isFile(str);
};

sjs.isWindow = function (str) {
	return $.core.Str.isWindow(str);
};

sjs.isArrayBuffer = function (str) {
	return $.core.Str.isArrayBuffer(str);
};

sjs.isEmail = function (str) {
	return $.core.Str.isEmail(str);
};

sjs.isURL = function (str) {
	return $.core.Str.isURL(str);
};

sjs.isKatakana = function (str) {
	return $.core.Str.isKatakana(str);
};

sjs.isHiragana = function (str) {
	return $.core.Str.isHiragana(str);
};

sjs.escape = function (str) {
	return $.core.Str.escape(str);
};

sjs.recovery = function (str) {
	return $.core.Str.recovery(str);
};

sjs.stripTags = function (str) {
	return $.core.Str.stripTags(str);
};

sjs.lineToBr = function (str) {
	return $.core.Str.lineToBr(str);
};

sjs.int = function (val) {
	return parseInt(val);
};

sjs.bookmark = function (title, url) {
	$.core.Browser.bookmark(title, url);
};

sjs.urlParam = function (param, url, data) {
	if (typeof data === 'undefined') {
		return $.core.URL.getParam(param, url);
	} else {
		if (url === 'undefined') {
			let url = $.core.URL.setParam(param, data, url);
			
			$.core.Browser.pushState(null, null, url);
		} else {
			return $.core.URL.setParam(param, data, url);
		}
	}
};

sjs.AESDecrypt = function (key, plainText) {
	return $.core.SimpleCrypto.AESDecrypt(key, plainText);
};

sjs.AESEncrypt = function (plainText, key) {
	return $.core.SimpleCrypto.AESEncrypt(plainText, key);
};

sjs.AES = (function() {
	return {
		encrypt: (function (plainText, key) {
			var aes = sjs.AESEncrypt(plainText, key);
			
			return aes;
		}),
		decrypt: (function (key, plainText) {
			var aes = sjs.AESDecrypt(key, plainText);
			
			return aes;
		})
	}
})();

sjs.baseConvert = function (number, frombase, tobase) {
	$.core.SimpleCrypto.baseConvert(number, frombase, tobase);
};

sjs.title = function (title) {
	if (typeof title === 'undefined') {
		return $.core.Str.Browser.getTitle();
	} else {
		$.core.Str.Browser.setTitle(title);
	}
};

sjs.speech = function (speecher, pitch, rate, word) {
	$.core.Speech.speech(speecher, pitch, rate, word);
};
