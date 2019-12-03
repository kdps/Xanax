//Battery-related functions
'use strict';

(function ($, core) {

	var A = core.Battery = {
		
		isGet: function () {
			if (!_cNavi.getBattery) {
				return false;
			}
			
			_cNavi.getBattery().then(function (battery) {
				return true;
			});
			
			return false;
		},
		
		charingTime: function () {
			if (this.isGet()) {
				return battery.chargingTime;
			}
		},
		
		dischargingTime: function () {
			if (this.isGet()) {
				return battery.dischargingTime;
			}
		},
		
		level: function () {
			if (this.isGet()) {
				return battery.level;
			}
		}
		
	};
	
})(jQuery, $.core);