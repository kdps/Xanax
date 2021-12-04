//Browser-related functions
'use strict';

(function ($, core) {

	var A = core.RTC = {
		
		getRTCPeerConnection: function () {
			_cWin.RTCPeerConnection = _cWin.RTCPeerConnection || 
									  _cWin.webkitRTCPeerConnection || 
									  _cWin.mozRTCPeerConnection;
									  
			return _cWin.RTCPeerConnection;
		},
		
		hasRTCPeerConnection: function () {
			return !!(this.getRTCPeerConnection());
		},
		
    }

});