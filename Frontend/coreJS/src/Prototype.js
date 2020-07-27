/**
 * Prototype
 */
(function () {

	// Number

	if (!Number.prototype.clamp) {
		Number.prototype.clamp = function (min, max) {
			return Math.min(Math.max(this, min), max);
		};
	}
	
	if (!Number.prototype.mod) {
		Number.prototype.mod = function (n) {
			return ((this % n) + n) % n;
		};
	}
	
	// String
	
	if (!String.prototype.trim) {
		String.prototype.trim = function() {
			return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
		};
	}

	if (!String.trim) {
		String.trim = function(s) {
			return String(s).trim();
		};
	}
	
	// Date
	
	if (!Date.now) {
		Date.now = function now() {
			return new Date().getTime();
		};
	}

	// Element
	
	if (!Element.prototype.getHeight) {
		Element.getHeight = function getHeight() {
			$.core.Element.getHeight(this);
		}
	}
	
	if (!Element.prototype.setAttribute) {
		Element.setAttribute = function setAttribute(attributes) {
			$.core.Element.setAttribute(this, attributes);
		}
	}
	
	if (!Element.prototype.removeAttribute) {
		Element.removeAttribute = function removeAttribute(attributes) {
			$.core.Element.removeAttribute(this, attributes);
		}
	}
	
	if (!Element.prototype.getWidth) {
		Element.getWidth = function getWidth() {
			$.core.Element.getWidth(this);
		}
	}
	
	if (!Element.prototype.requestFullScreen) {
		Element.requestFullScreen = function requestFullScreen() {
			$.core.Screen.requestFullScreen(this);
		}
	}
	
	if (!Element.prototype.toggleFullScreen) {
		Element.cancelFullScreen = function toggleFullScreen() {
			$.core.Screen.toggleFullScreen(this);
		}
	}
	
	if (!Element.prototype.cancelFullScreen) {
		Element.cancelFullScreen = function cancelFullScreen() {
			$.core.Screen.cancelFullScreen(this);
		}
	}
	
	// Audio
	
	if (!Audio.prototype.Restart) {
		Audio.prototype.Restart = function () {
			this.pause();
			this.currentTime = 0;
			this.play();
		};
	}
	
	// EventEmitter
	
	function EventEmitter() {
		this.listeners = {};
		this._owner = this;
	};
	
	EventEmitter.prototype.on = function (event, callback) {
		this._callbacks[event] = this._callbacks[event] || [];
		this._callbacks[event].push(callback);
	};
	
	EventEmitter.prototype.emit = function (event, data) {
		if ($.core.Validate.isUndefined(this._callbacks[event])) {
			return;
		}
		
		let callbacks = this._callbacks[event];
		
		for (let i = 0, len = callbacks.length; i < len; ++i) {
			try {
				callbacks[i].call(null, data);
			} catch (e) {
				console.log(e);
			}
		}
	};
	
	EventEmitter.prototype.off = function (event) {
		delete this._callbacks[event];
	};
	
	protoArr.indexOf = function (e) {
		for (let i = 0; i < this.length; i++) {
			if (this[i] == e) return i;
		}
		return -1;
	};
	
	protoArr.forEach = function (fn) {
		for (let i = 0; i < this.length; i++) {
			fn(this[i], i, this);
		}
	};
	
	protoArr.find = function (cond) {
		let code = (cond instanceof Function) ? cond : function (v) {
			return v == cond;
		};
		let arrL = this.length;
		for (let i = 0; i < arrL; i++) {
			if (code(this[i])) {
				return this[i];
			}
		}
		return undefined;
	};
	
	protoArr.isAlready = function (key) {
		let _isAlready = false;
		let _count = this.length;
		let i;
		for (i = 0; i < _count; i++) {
			if (this[i] == key) {
				_isAlready = true;
			}
		}
		return _isAlready;
	};
	
	protoArr.arsort = function (key) {
		this.sort(function (a, b) {
			return (a[key] < b[key]) ? 1 : -1;
		});
	};
	
	protoArr.remove = function (_count) {
		this.splice(_count, 1);
	};
	
	protoArr.unique = function () {
		let e = [];
		let _count = length = this.length;
		let k, h;
		for (k = 0; k < _count; k++) {
			for (h = 0; h < e.length; h++) {
				if (this[k] == e[h]) {
					break
				}
			}
			if (h >= e.length) {
				e[h] = this[k]
			}
		}
		return e;
	};
	
	protoArr.asort = function (key) {
		this.sort(function (a, b) {
			return (a[key] > b[key]) ? 1 : -1;
		});
	};
	
	protoArr.shuffle = function () {
		let l = this.length;
		while (l) {
			let m = Math.floor(Math.random() * l);
			let n = this[--l];
			this[l] = this[m];
			this[m] = n;
		}
	};
	
});
