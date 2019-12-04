//WebCam-related functions
'use strict';

(function ($, core) {

	var A = core.WebCam = {
		
		constructor: function () {
			this.recorder = null;
		},
		
		stopCaptureAudio: function () {
			recorder.stop();
		},
		
		captureAudio: function () {
			var onRecordingReady = function () {
				var audio = document.getElementById('audio');
				audio.src = URL.createObjectURL(e.data);
			};
			
			$.core.Browser.startRecorder(function (stream) {
				this.recorder = new MediaRecorder(stream);
				this.recorder.addEventListener('dataavailable', onRecordingReady);
			});
		},
		
		captureVideo: function (selector, onSuccessCallback, onErrorCallback) {
			const vid = document.querySelector(selector);
			
			$.core.Browser.startWebCam(function (stream) {
				vid.srcObject = stream;
				return vid.play(); 
			// resolve
			},
			function(args) {
				if (typeof onSuccessCallback == 'function') {
					onSuccessCallback(args);
				}
			// reject
			},
			function(args) {
				if (typeof onErrorCallback == 'function') {
					onErrorCallback(args);
				}
			});
		},
		
		takeSnapshot: function (id, filetype) {
			if (!filetype) {
				filetype = 'image/jpeg';
			}
			
			const canvas = document.createElement(id);
			const ctx = canvas.getContext('2d');
			canvas.width = vid.videoWidth;
			canvas.height = vid.videoHeight;
			ctx.drawImage(vid, 0,0);
			
			return new Promise(function(res, rej) {
				canvas.toBlob(res, filetype);
			});
		},
		
		downloadSnapshot: function (blob, filename) {
			let a = document.createElement('a'); 
			a.href = URL.createObjectURL(blob);
			a.download = filename;
			document.body.appendChild(a);
			a.click();
		}
		
	};
	
	A.constructor();
	
})(jQuery, $.core);