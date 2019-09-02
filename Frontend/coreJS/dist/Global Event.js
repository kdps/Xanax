(function ($) {
	$(window).getEvent(window,function (e) {
		let $type = e.type; 
		let $target = e.target;
		if ($type == 'click') {
			let $link = $target.href;
			if ($link) {
				let host = location.hostname;
				let protocol = location.hostname == 'localhost' ? '' : document.location.protocol + '//';
				let domain = protocol + host;
				let regex = new RegExp(domain + '\/', "i");
				let isSafeCaller = regex.test($link);
				if (!isSafeCaller) {
					//event.preventDefault();
					//return;
				}
			}
		}
	});
	
	let messangerType = 'messanger';
	
	$.core.CoreMessanger = {
		Show: function (msg, bottom, left, type) {
			if (messangerType=='messanger') {
				Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-left',
					theme: 'air'
				},
				Messenger().post({
					type: "info",
					message : msg,
					hideAfter: 5
				});
			} else {
				$.notify(msg, {
					globalPosition: 'bottom left',
					className: 'success'
				});
			}
			
			if ($.core.Audio.isSupport()) {
				if (type==='success') {
					$.core.Audio.loadAudio('./library/mp3/alert.mp3');
				} else if (type==='error') {
					$.core.Audio.loadAudio('./library/mp3/error.mp3');
				}
				
				$.core.Audio.playAudio();
			}
		}
	}
})(jQuery);