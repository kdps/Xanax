//GEO-related functions
'use strict';

(function ($, core) {

	var A = core.GEO = {
		
		isSupport: function () {
			return (navigator.geolocation) ? true : false;
		},
		
		Get: function () {
			if (!this.isSupport()) return;
			
			var options = {
				enableHighAccuracy: true,
				timeout: 5000,
				maximumAge: 0
			};
			
			return new Promise(function (resolve, reject) {
				_cNavi.geolocation.getCurrentPosition(resolve, reject, options);
			});
		}
		
	};
	
})(jQuery, $.core);
