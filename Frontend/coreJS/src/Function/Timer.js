//Timer-related functions
(function ($, core) {

	var A = core.Timer = {
		
		//async function fn() { const variables = await $.core.Timer.sleep(...); }
		sleep: function (callback, delay) {
			return new Promise(function (resolve) {
			//(resolve) => {
				setTimeout(function () {
				//() => {
					resolve(callback);
				},
		 delay);
			});
		},
		
		wait: function (ms) {
			setTimeout(deferred.resolve, ms);
			return deferred.promise();
		},
		
		timeout: function (callback, ms, vars) {
			if (pTimer !== null) {
				this.Reset();
			}
			
			pTimer = setTimeout(function () {
				if (typeof callback === 'function') {
					callback(vars);
				}
			}, ms);
		},
		
		interval: function (callback, ms, vars) {
			if (pTimer !== null) {
				this.Reset();
			}
			
			pTimer = setInterval(function () {
				if (typeof callback === 'function') {
					callback(vars);
				}
			},  ms);
		},
		
		reset: function () {
			clearInterval(pTimer);
		}
		
	};
	
})(jQuery, $.core);