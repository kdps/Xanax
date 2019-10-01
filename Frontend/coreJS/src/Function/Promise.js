//Promise-related functions
'use strict';

(function ($, core) {

	var A = core.Promise = {
		
		isSupport: function () {
			if(typeof Promise !== "undefined" && Promise.toString().indexOf("[native code]") !== -1) {
				return false;
			}
			
			return true;
		},
		
		RequestHanlder: function (request) {
			return new Promise(function (resolve, reject) {
				request.onsuccess = function () {
					resolve(request.result);
				},
				request.onerror = function () {
					reject(request.error);
				};
			});
		},
		
		RequestCall: function (obj, method, args) {
			var request;
			var p = new Promise(function (resolve, reject) {
				request = obj[method].apply(obj, args);
				this.RequestHanlder(request).then(resolve, reject);
			});

			p.request = request;
			
			return p;
		}
		
	};
	
})(jQuery, $.core);