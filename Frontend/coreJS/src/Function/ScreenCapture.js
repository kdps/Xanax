//ScreenCapture-related functions
(function ($, core) {

	var A = core.ScreenCapture = {
		
		stop: function (videoElement) {
			let tracks = videoElement.srcObject.getTracks();

			tracks.forEach(function (track) {
				track.stop()
			});
			
			videoElement.srcObject = null;
		},
		
		 /*
			var displayMediaOptions = {
			  video: {
				cursor: "never"
			  },
			  audio: false
			};
		*/
		capture: function (videoElement, displayMediaOptions) {
			return navigator.mediaDevices.getDisplayMedia(displayMediaOptions).catch(function (err) { 
				console.error("Error:" + err); 
				return null; 
			});
		}
		
	};
	
})(jQuery, $.core);