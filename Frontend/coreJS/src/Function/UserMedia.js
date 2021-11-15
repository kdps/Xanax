//Browser-related functions
'use strict';

(function ($, core) {

	var A = core.UserMedia = {
		
		getUserMedia: function () {
			return _cNavi.getUserMedia || 
				   _cNavi.webkitGetUserMedia || 
				   _cNavi.mozGetUserMedia || 
				   _cNavi.msGetUserMedia;
		},
		
		hasGetUserMedia: function () {
			return !!(this.getUserMedia());
		},
		
		startRecorder: function (onLoadCallback, onSuccessCallback, onErrorCallback) {
			if (this.hasGetUserMedia()) {
				navigator.mediaDevices.getUserMedia({audio: true}).then(function (stream) {
					if (typeof onSuccessCallback == 'function') {
						onSuccessCallback(stream);
					}
				}).then(function (status) {
					if (typeof onSuccessCallback == 'function') {
						return onSuccessCallback(status);
					}
				}).catch(onErrorCallback);
			}
		},
		
		startWebCam: function (onLoadCallback, onSuccessCallback, onErrorCallback) {
			if (this.hasGetUserMedia()) {
				this.getDeviceUserMedia({
					video: true
				}).then(function (mediaStream) {
					if (typeof onLoadCallback == 'function') {
						return onLoadCallback(mediaStream);
					}
				}).then(function (status) {
					if (typeof onSuccessCallback == 'function') {
						return onSuccessCallback(status);
					}
				}).catch(onErrorCallback);
			}
		},
		
		doCapture: function () {
			var imageCapture = this.getImageCaptureHandler();
			var blobData;
			
			imageCapture.takePhoto().then(function (blob) {
			//blob => {
				blobData = blob;
			}).catch(function () {
			//error => {
				return false;
			});
			
			return blobData;
		},
		
		newImageCapture: function (mediaStream) {
			var mediaStreamTrack = mediaStream.getVideoTracks()[0];
			
			if ($.core.Validate.isObject(mediaStreamTrack)) {
				return new ImageCapture(mediaStreamTrack);
			}
		},
		
		getDeviceUserMedia: function (params) {
			return _cWin.navigator.mediaDevices.getUserMedia(params);
		},
		
		getImageCaptureHandler: function () {
			this.getDeviceUserMedia({video: true}).then(gotMedia).catch(function () {
			//error => {
				return false;
			});
			
			function gotMedia(mediaStream) {
				const mediaStreamTrack = mediaStream.getVideoTracks()[0];
				const imageCapture = new ImageCapture(mediaStreamTrack);
				return imageCapture;
			}
		},
		
    }
});