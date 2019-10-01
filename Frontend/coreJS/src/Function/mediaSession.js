//mediaSession-related functions
'use strict';

(function ($, core) {

	var A = core.MediaSession = {
		
		isSupport: function () {
			if ('MediaSession' in navigator) {
				return true;
			}
			
			return false;
		},
		
		setMetadata: function (title, artist, album, artwork) {
			navigator.mediaSession.metadata = new MediaMetadata({
				title: title,
				artist: artist,
				album: album,
				artwork: artwork
				/*
					artwork: [
					  { src: 'https://dummyimage.com/96x96',   sizes: '96x96',   type: 'image/png' },
		
					  { src: 'https://dummyimage.com/128x128', sizes: '128x128', type: 'image/png' },
		
					  { src: 'https://dummyimage.com/192x192', sizes: '192x192', type: 'image/png' },
		
					  { src: 'https://dummyimage.com/256x256', sizes: '256x256', type: 'image/png' },
		
					  { src: 'https://dummyimage.com/384x384', sizes: '384x384', type: 'image/png' },
		
					  { src: 'https://dummyimage.com/512x512', sizes: '512x512', type: 'image/png' },
		
					]
				 */
			});
		},
		
		setActionHandler: function (action, callback) {
			if (this.isSupport()) {
				navigator.mediaSession.setActionHandler(action, callback);
			}
		},
		
		setPlayHandler: function (callback) {
			this.setActionHandler('play', callback);
		},
		
		setPauseHandler: function (callback) {
			this.setActionHandler('pause', callback);
		},
		
		setSeekbackwardHandler: function (callback) {
			this.setActionHandler('seekbackward', callback);
		},
		
		setSeekforwardHandler: function (callback) {
			this.setActionHandler('seekforward', callback);
		},
		
		setPrevioustrackHandler: function (callback) {
			this.setActionHandler('previoustrack', callback);
		},
		
		setNextrackHandler: function (callback) {
			this.setActionHandler('nexttrack', callback);
		},
		
		setPlaybackState: function (state) {
			navigator.mediaSession.playbackState = state;
		},
		
		setStateToPlaying: function () {
			this.setPlaybackState("playing");
		},
		
		setStateToPaused: function () {
			this.setPlaybackState("paused");
		}
		
	}
	
})(jQuery, $.core);