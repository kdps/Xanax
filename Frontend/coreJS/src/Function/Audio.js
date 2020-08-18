//Audio-related functions
//https://www.nyu.edu/classes/bello/FMT_files/9_MIDI_code.pdf
'use strict'

import AudioContextObject from './Class/AudioContextObject.js';
(function ($, core) {

	var A = core.Audio = {
		
		constructor: function () {
			/*this.bitRate = [
				[
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0xFFFF},
					{0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0xFFFF},
					{0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0xFFFF},
					{0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0xFFFF}
				],
				[
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
				],
				[
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0xFFFF},
					{0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0xFFFF},
					{0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0xFFFF},
				],
				[
					{0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0},
					{0, 32, 40, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 0xFFFF},
					{0, 32, 38, 56, 64, 80, 96, 12, 128, 160, 192, 224, 256, 320, 384, 0xFFFF},
					{0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448, 0xFFFF}
				],
			];
			
			this.sampleFrequency = [
				{11025, 12000, 8000, 0},
				{0, 0, 0, 0},
				{22050, 24000, 16000, 0},
				{44100, 48000, 32000, 0}
			];*/
			
			this.const midiInstruments = [
				{"Instrument" : "Acoustic Grand Piano", "Class" : "Piano"},
				{"Instrument" : "Bright Acoustic Piano", "Class" : "Piano"},
				{"Instrument" : "Electric Grand Piano", "Class" : "Piano"},
				{"Instrument" : "Honky-tonk Piano", "Class" : "Piano"},
				{"Instrument" : "Rhodes Piano", "Class" : "Piano"},
				{"Instrument" : "Chorused Piano", "Class" : "Piano"},
				{"Instrument" : "Harpsichord", "Class" : "Piano"},
				{"Instrument" : "Clavinet", "Class" : "Piano"},
				{"Instrument" : "Celesta", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Glockenspiel", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Music box", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Vibraphone", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Marimba", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Xylophone", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Tubular Bells", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Dulcimer", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Hammond Organ", "Class" : "Organ"},
				{"Instrument" : "Percussive Organ", "Class" : "Organ"},
				{"Instrument" : "Rock Organ", "Class" : "Organ"},
				{"Instrument" : "Church Organ", "Class" : "Organ"},
				{"Instrument" : "Reed Organ", "Class" : "Organ"},
				{"Instrument" : "Accordion", "Class" : "Organ"},
				{"Instrument" : "Harmonica", "Class" : "Organ"},
				{"Instrument" : "Tango Accordion", "Class" : "Organ"},
				{"Instrument" : "Acoustic Guitar (nylon)", "Class" : "Guitar"},
				{"Instrument" : "Acoustic Guitar (steel)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (jazz)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (clean)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (muted)", "Class" : "Guitar"},
				{"Instrument" : "Overdriven Guitar", "Class" : "Guitar"},
				{"Instrument" : "Distortion Guitar", "Class" : "Guitar"},
				{"Instrument" : "Guitar Harmonics", "Class" : "Guitar"},
				{"Instrument" : "Acoustic Bass", "Class" : "Bass"},
				{"Instrument" : "Electric Bass (finger)", "Class" : "Bass"},
				{"Instrument" : "Electric Bass (pick)", "Class" : "Bass"},
				{"Instrument" : "Fretless Bass", "Class" : "Bass"},
				{"Instrument" : "Slap Bass 1", "Class" : "Bass"},
				{"Instrument" : "Slap Bass 2", "Class" : "Bass"},
				{"Instrument" : "Synth Bass 1", "Class" : "Bass"},
				{"Instrument" : "Synth Bass 2", "Class" : "Bass"},
				{"Instrument" : "Violin", "Class" : "Strings"},
				{"Instrument" : "Viola", "Class" : "Strings"},
				{"Instrument" : "Cello", "Class" : "Strings"},
				{"Instrument" : "Contrabass", "Class" : "Strings"},
				{"Instrument" : "Tremolo Strings", "Class" : "Strings"},
				{"Instrument" : "Pizzicato Strings", "Class" : "Strings"},
				{"Instrument" : "Orchestral Harp", "Class" : "Strings"},
				{"Instrument" : "String Ensemble 1", "Class" : "Ensemble"},
				{"Instrument" : "String Ensemble 2", "Class" : "Ensemble"},
				{"Instrument" : "Synth Strings 1", "Class" : "Ensemble"},
				{"Instrument" : "Synth Strings 2", "Class" : "Ensemble"},
				{"Instrument" : "Choir Aahs", "Class" : "Ensemble"},
				{"Instrument" : "Voice Oohs", "Class" : "Ensemble"},
				{"Instrument" : "Synth Voice", "Class" : "Ensemble"},
				{"Instrument" : "Orchestra Hit", "Class" : "Ensemble"},
				{"Instrument" : "Timpani", "Class" : "Ensemble"},
				{"Instrument" : "Trumpet", "Class" : "Brass"},
				{"Instrument" : "Trombone", "Class" : "Brass"},
				{"Instrument" : "Tuba", "Class" : "Brass"},
				{"Instrument" : "Muted Trumpet", "Class" : "Brass"},
				{"Instrument" : "French Horn", "Class" : "Brass"},
				{"Instrument" : "Brass Section", "Class" : "Brass"},
				{"Instrument" : "Synth Brass 1", "Class" : "Brass"},
				{"Instrument" : "Synth Brass 2", "Class" : "Brass"},
				{"Instrument" : "Soprano Sax", "Class" : "Reed"},
				{"Instrument" : "Alto Sax", "Class" : "Reed"},
				{"Instrument" : "Tenor Sax", "Class" : "Reed"},
				{"Instrument" : "Baritone Sax", "Class" : "Reed"},
				{"Instrument" : "Oboe", "Class" : "Reed"},
				{"Instrument" : "English Horn", "Class" : "Reed"},
				{"Instrument" : "Bassoon", "Class" : "Reed"},
				{"Instrument" : "Clarinet", "Class" : "Reed"},
				{"Instrument" : "Piccolo", "Class" : "Pipe"},
				{"Instrument" : "Flute", "Class" : "Pipe"},
				{"Instrument" : "Recorder", "Class" : "Pipe"},
				{"Instrument" : "Pan Flute", "Class" : "Pipe"},
				{"Instrument" : "Bottle Blow", "Class" : "Pipe"},
				{"Instrument" : "Shakuhachi", "Class" : "Pipe"},
				{"Instrument" : "Whistle", "Class" : "Pipe"},
				{"Instrument" : "Ocarina", "Class" : "Pipe"},
				{"Instrument" : "Clarinet", "Class" : "Pipe"},
			];
			
			this.musicGenre = ["Blues", "Classic Rock", "Country", "Dance", "Disco", "Funk", "Grunge", "Hip-Hop", "Jazz", "Metal", "New Age", "Oldies", "Other", "Pop", "R&B", "Rap", "Reggae", "Rock", "Techno", "Industrial", "Alternative", "Ska", "Death Metal", "Pranks", "Soundtrack", "Euro-Techno", "Ambient", "Trip-Hop", "Vocal", "Jazz+Funk", "Fusion", "Trance", "Classical", "Instrumental", "Acid", "House", "Game", "Sound Clip", "Gospel", "Noise", "AlternRock", "Bass", "Soul", "Punk", "Space", "Meditative", "Instrumental Pop", "Instrumental Rock", "Ethnic", "Gothic", "Darkwave", "Techno-Industrial", "Electronic", "Pop-Folk", "Eurodance", "Dream", "Southern Rock", "Comedy", "Cult", "Gangsta Rap", "Top 40", "Christian Rap", "Pop / Funk", "Jungle", "Native American", "Cabaret", "New Wave", "Psychedelic", "Rave", "Showtunes", "Trailer", "Lo-Fi", "Tribal", "Acid Punk", "Acid Jazz", "Polka", "Retro", "Musical", "Rock & Roll", "Hard Rock", "Folk", "Folk-Rock", "National Folk", "Swing", "Fast  Fusion", "Bebob", "Latin", "Revival", "Celtic", "Bluegrass", "Avantgarde", "Gothic Rock", "Progressive Rock", "Psychedelic Rock", "Symphonic Rock", "Slow Rock", "Big Band", "Chorus", "Easy Listening", "Acoustic", "Humour", "Speech", "Chanson", "Opera", "Chamber Music", "Sonata", "Symphony", "Booty Bass", "Primus", "Porn Groove", "Satire", "Slow Jam", "Club", "Tango", "Samba", "Folklore", "Ballad", "Power Ballad", "Rhythmic Soul", "Freestyle", "Duet", "Punk Rock", "Drum Solo", "A Cappella", "Euro-House", "Dance Hall", "Goa", "Drum & Bass", "Club-House", "Hardcore", "Terror", "Indie", "BritPop", "Negerpunk", "Polsk Punk", "Beat", "Christian Gangsta Rap", "Heavy Metal", "Black Metal", "Crossover", "Contemporary Christian", "Christian Rock", "Merengue", "Salsa", "Thrash Metal", "Anime", "JPop", "Synthpop", "Rock/Pop"];
			
			this.StreamAudio = null;
		},
		
		parseMidiMessage: function (message) {
			let parsedMessage = "";
			
			switch (message) {
				case 128:
					parsedMessage = "Note Off";
					break;
				case 144:
					parsedMessage = "Note On";
					break;
				case 160:
					parsedMessage = "Poly Pressure";
					break;
				case 192:
					parsedMessage = "Program Change";
					break;
				case 208:
					parsedMessage = "Channel Pressure";
					break;
				case 224:
					parsedMessage = "Pitch Wheel";
					break;
				case 240:
					parsedMessage = "System Exclusive";
					break;
				case 242:
					parsedMessage = "Song Position";
					break;
				case 243:
					parsedMessage = "Song Select";
					break;
				case 246:
					parsedMessage = "Tune Request";
					break;
				case 247:
					parsedMessage = "End of Exclusive";
					break;
				case 248:
					parsedMessage = "Timing Clock";
					break;
				case 250:
					parsedMessage = "Start";
					break;
				case 251:
					parsedMessage = "Continue";
					break;
				case 252:
					parsedMessage = "Stop";
					break;
				case 254:
					parsedMessage = "Active Sensing";
					break;
				case 255:
					parsedMessage = "System Reset";
					break;
				case 255:
					parsedMessage = "System Reset";
					break;
				default:
					break;
			}
			
			return parsedMessage;
		},
		
		isMidiSupported: function () {
			return navigator.requestMIDIAccess;
		},
		
		hasMidiDevicePressed: function (command) {
			if (command === 145) {
				return true;
			} else if(command === 129) {
				return false;
			}
		},
		
		setOnMidiMessageEvent: function (callback) {
			if (typeof callback === 'function') {
				// command, key, velocity
				device.onmidimessage = callback;
			}
		},
		
		setOnRequestMIDIAccessEvent: function () :Promise {
			return navigator.requestMIDIAccess();
		},
		
		setResume: function (audioContext) {
			audioContext.resume();
		},
		
		setSuspend: function (audioContext) {
			audioContext.suspend();
		},
		
		// type = sine, square, sawtooth, triangle
		setOscillatorType: function (audioContext, type) {
			audioContext.type = type;
			
			return audioContext;
		},
		
		createOscillatorContext: function () {
			let audioContext = this.getContext();
			let Oscillator = this.createOscillator();
			let destination = audioContext.destination;
			Oscillator.connect(destination);
			
			return audioContext;
		},
		
		getFrequencyByNote: function (note) {
			let tone = yamahaTone[note];
			let freq = Math.pow(2, (tone - 69) / 12) * 440;
			return freq;
		},
		
		setMidiFrequency: function (audioContext, midiNote) {
			const frequency = Math.pow(2, (midiNote - 69) / 12) * 440;
			
			this.setOscillatorFrequency(audioContext, frequency, audioContext.currentTime);
		},
		
		setOscillatorFrequency: function (audioContext, target, startTime, timeConstant = 0) {
			audioContext.frequency.setTargetAtTime(target, startTime, timeConstant);
		},
		
		hasMediaCapabilities: function () {
			if ('mediaCapabilities' in navigator) {
				return true;
			}
			
			return false;
		},
		
		hasLoop: function () {
			if ('loop' in document.createElement('audio')) {
				return true;
			}
			
			return false;
		},
		
		isMediaCapabilities: function (audioFileConfiguration, callback) {
			if (this.hasMediaCapabilities()) {
				/*
					const audioFileConfiguration = {
						type : 'file', 
						audio : {
							contentType: "audio/mp3",
							channels: 2,  
							bitrate: 132700, 
							samplerate: 5200 
						} 
					  }; 
				*/
				navigator.mediaCapabilities.decodingInfo(audioFileConfiguration).then(function (result) {
					callback(callback);
				});
			}
		},
		
		/**
		 * Check that browser is support specify audio codec type
		 *
		 * @return boolean
		 **/
		isCanPlay: function (element, type, codecs) {
			let _codecs = '';
			let bool;
			
			switch (type) {
				case "opus":
					type = 'audio/opus';
					_codecs = 'opus';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "ogg":
					type = 'audio/ogg';
					_codecs = 'theora, vorbis';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "oga":
					type = 'audio/ogg';
					_codecs = 'vorbis';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "wav":
					type = 'audio/wav';
					_codecs = '1';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "weba":
					type = 'audio/weba';
					_codecs = 'vorbis';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "webm":
					type = 'audio/weba';
					_codecs = 'vp8.0, vorbis';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "dolby":
					type = 'audio/mp4';
					_codecs = 'ec-3';
					bool = element.canPlayType(type + ';codecs="' + _codecs + '"');
					break;
				case "aiff":
					bool = element.canPlayType("audio/x-aiff;");
					break;
				case "flac":
					bool = element.canPlayType("audio/x-flac;") || 
						element.canPlayType("audio/flac;");
					break;
				case "m4a":
					bool = element.canPlayType("audio/x-m4a;") || 
						element.canPlayType("audio/m4a;") || 
						element.canPlayType("audio/aac;");
					break;
				case "mp4":
					bool = element.canPlayType('audio/x-mp4;codecs="avc1.42E01E, mp4a.40.2"') || 
						element.canPlayType("audio/mp4;") || 
						element.canPlayType("audio/aac;");
					break;
				case "caf":
					bool = element.canPlayType("audio/x-caf;");
					break;
				case "aac":
					bool = element.canPlayType("audio/aac;");
					break;
				case "mpeg":
					bool = element.canPlayType("audio/mpeg;");
					break;
				case "mp3":
					bool = element.canPlayType("audio/mp3;") || element.canPlayType("audio/mpeg;");
					break;
				default:
					
			}
			
			return bool;
		},
		
		/**
		 * Check that audio support
		 *
		 * @return boolean
		 **/
		isSupport: function () {
			if (_cWin.HTMLAudioElement && !$.core.Mobile.isRefMobile()) {
				return true;
			}
			
			return false;
		},
		
		/**
		 * Check that audio playing
		 *
		 * @return boolean
		 **/
		isPlaying: function (audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			if ($.core.Validate.isObject(this.StreamAudio)) {
				try {
					if (this.StreamAudio.currentTime > 0 && !this.StreamAudio.paused && !this.StreamAudio.ended && this.StreamAudio.readyState > 2) {
						return true;
					}
				} catch(e) {}
				
				return false;
			}
		},
		
		Object: function (src, audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			this.StreamAudio.src = src;
			this.play = function () {
				this.StreamAudio.playAudio();
			};
			
			Object.defineProperty(this.StreamAudio, "default", {
				volume:100,
				writable:false,
				enumerable:false,
				configurable:false
			});

			Object.defineProperty(this.StreamAudio, 'src', {
					get: function () {
						return this.src;
					},
		
					set: function(src) {
						this.src = src;
					}
				}
			);
		},
		
		/**
		 * Load Audio File for Play
		 *
		 * @param {src} : Audio Source
		 *
		 * @return void
		 **/
		loadAudio: function (src, audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			if (this.isSupport()) {
				if (!this.StreamAudio || !$.core.Validate.isObject(this.StreamAudio)) {
					this.StreamAudio = $.core.Element.create("audio");
				}
				
				try{
					const playPromise = this.StreamAudio.play();
					
					if (this.isPlaying()) {
						this.pauseAudio();
					}
					
					if (playPromise !== null) {
						this.StreamAudio.setAttribute("src", src);
						this.StreamAudio.src = src;
						this.StreamAudio.load();
					} else if (!$.core.Validate.isUndefined(playPromise)) {
						playPromise.then(function () {
							this.StreamAudio.setAttribute("src", src);
							this.StreamAudio.src = src;
							this.StreamAudio.load();
						}).catch(function () {
							if (this.isPlaying()) {
								this.pauseAudio();
							}
							
							this.StreamAudio.setAttribute("src", src);
							this.StreamAudio.load();
						});
					}
				} catch(e) {
					console.log(e);
				}
			}
		},
		
		/**
		 * Decode Audio Context
		 *
		 * @param {result} : evt.target.result
		 * @param {audioContext} : Audio Context
		 * @param {callback} : Callback
		 * @param {failCallback} : Failure Callback
		 *
		 * @return Callback
		 **/
		decodeAudio: function (result, audioContext, callback, failCallback) {
			audioContext.decodeAudioData(result, function (buffer) {
				callback(audioContext, buffer);
			}, function (e) {
				failCallback(e);
			});
		},
		
		/**
		 * Play Audio File (* Need to Load Audio File)
		 *
		 * @return void
		 **/
		playAudio: function (audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			if ($.core.Validate.isObject(this.StreamAudio)) {
				this.StreamAudio.play();
			}
		},
		
		/**
		 * Pause Audio File (* Need to Load Audio File)
		 *
		 * @return void
		 **/
		pauseAudio: function (audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			if ($.core.Validate.isObject(this.StreamAudio)) {
				this.StreamAudio.pause();
			}
		},
		
		/**
		 * Set Audio Current Time (* Need to Load Audio File)
		 *
		 * @return void
		 **/
		setAudioTime: function (time, audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			if ($.core.Validate.isObject(this.StreamAudio)) {
				this.StreamAudio.currentTime = time;
			}
		},
		
		/**
		 * Pause Audio And Set Audio Time to 0 (* Need to Load Audio File)
		 *
		 * @return void
		 **/
		stopAudio: function (audioObject) {
			var letObject = audioObject || this.StreamAudio;
			
			this.pauseAudio(letObject);
			this.setAudioTime(0, letObject);
		},
		
		/**
		 * Get Offline Audio Context
		 *
		 * @return Object
		 **/
		getOfflineAudioContext: function () {
			var OfflineAudioContext = null;
			try {
				var OfflineAudioContext = _cWin.OfflineAudioContext;
				return new(OfflineAudioContext)();
			} catch (e) {}
			return OfflineAudioContext;
		},
		
		/**
		 * Get Audio Context
		 *
		 * @return Object
		 **/
		getContext: function () {
			var AudioContext = null;
			try {
				if (!window.hasOwnProperty('webkitAudioContext') && window.hasOwnProperty('AudioContext')) {
					var AudioContext = _cWin.AudioContext;
				} else {
					var AudioContext = _cWin.webkitAudioContext || _cWin.mozAudioContext || _cWin.msAudioContext;
				}
				return new(AudioContext)();
			} catch (e) {}
			
			return AudioContext;
		},
		
		getContextObject: function () {
			var audioContext = this.getContext();
			var contextObject = new AudioContextObject(audioContext);
			
			return contextObject;
		},
		
		/**
		 * Get Audio Context
		 *
		 * @param {audioContext} : AudioContext Object
		 * @param {audioElement} : Audio Element
		 *
		 * @return Object
		 **/
		createMediaElementSource: function (audioContext, audioElement) {
			return audioContext.createMediaElementSource(audioElement);
		},
		
		/**
		 * Get Node
		 *
		 * @param {context}      : AudioContext Object
		 * @param {audioElement} : Audio Element
		 *
		 * @return Object
		 **/
		getNode: function (context, audioElement) {
			return context.createMediaElementSource(audioElement);
		},
		
		/**
		 * Set Biquad Filter
		 *
		 * @param {context}      : AudioContext Object
		 * @param {type}         : [lowshelf, highshelf]
		 * @param {freq}         : AudioFrequency
		 * @param {gain}         : Audio Gain
		 *
		 * @return Object
		 **/
		setBiquadFilter: function (context, type, freq, gain) {
			var variable = context.createBiquadFilter();
			variable.type = type;
			
			try{
				variable.frequency.setTargetAtTime(0, context.currentTime, freq);
			} catch(e) {
				variable.frequency.value = freq; //is deprecated and will be removed in M64, around January 2018.
			}
			
			try{
				variable.gain.setTargetAtTime(0, context.currentTime, gain);
			} catch(e) {
				variable.gain.value = gain;
			}
			
			return variable;
		},
		
		/**
		 * Set Delay
		 *
		 * @param {context}      : AudioContext Object
		 * @param {audioNode}    : Audio Node
		 * @param {time}         : Delay Time
		 *
		 * @return void
		 **/
		setDelay: function (context, audioNode, time) {
			var variable = context.createDelay();
			variable.delayTime.value = time;
			audioNode.connect(variable);
			audioNode.connect(context.destination);
			variable.connect(context.destination);
		},
		
		//value : samples
		contextSamplesToSeconds: function (audioContext, value) {
			return audioContext.sampleRate / value;
		},
		
		//value : samples
		contextGetSamplesRate: function (audioContext) {
			return audioContext.sampleRate;
		},
		
		getContextCurrentTime: function (audioContext) {
			return audioContext.currentTime;
		},
		
		getContextListener: function (audioContext) {
			return audioContext.listener;
		},
		
		setGain: function (context, element) {
			var variable = context.createGain();
			element.connect(variable);
			return variable;
		},
		
		//AudioNode : context.createMediaElementSource(audioElement);
		setPan: function (context, audioNode) {
			var variable = context.createPanner();
			variable.panningModel = "equalpower";
			audionode.connect(variable);
			audionode.connect(context.destination);
			variable.connect(context.destination);
		},
		
		setInvert: function (value, context, element) {
			var variable = context.createGain();
			variable.gain.value = value;
			element.connect(variable);
			return variable;
		},
		
		createGain: function (audioContext) {
			if (!$.core.Validate.isFunc(audioContext.prototype.createGain)) {
				audioContext.prototype.createGain = audioContext.prototype.createGainNode;
			}
			
			return audioContext.createGain();
		},
		
		createBiquadFilter: function (audioContext) {
			return audioContext.createBiquadFilter();
		},
		
		setPeriodicWave: function (oscillatorNode) {
			if (!$.core.Validate.isFunc(oscillatorNode.prototype.setPeriodicWave)) {
				oscillatorNode.prototype.setPeriodicWave = oscillatorNode.prototype.setWaveTable;
			}
			
			return oscillatorNode.setPeriodicWave;
		},
		
		stopOscillatorNode: function (oscillatorNode) {
			if (!$.core.Validate.isFunc(oscillatorNode.prototype.stop)) {
				oscillatorNode.prototype.stop = oscillatorNode.prototype.noteOff;
			}
			
			return oscillatorNode.stop;
		},
		
		startOscillatorNode: function (oscillatorNode) {
			if (!$.core.Validate.isFunc(oscillatorNode.prototype.start)) {
				oscillatorNode.prototype.start = oscillatorNode.prototype.noteOn;
			}
			
			return oscillatorNode.start;
		},
		
		stopBufferSourceNode: function (audioBufferSourceNode) {
			if (!$.core.Validate.isFunc(audioBufferSourceNode.prototype.stop)) {
				audioBufferSourceNode.prototype.stop = audioBufferSourceNode.prototype.noteGrainOff;
			}
			
			return audioBufferSourceNode.stop;
		},
		
		startBufferSourceNode: function (audioBufferSourceNode) {
			if (!$.core.Validate.isFunc(audioBufferSourceNode.prototype.start)) {
				audioBufferSourceNode.prototype.start = audioBufferSourceNode.prototype.noteGrainOn;
			}
			
			return audioBufferSourceNode.start;
		},
		
		createPeriodicWave: function (audioContext) {
			if (!$.core.Validate.isFunc(audioContext.prototype.createPeriodicWave)) {
				audioContext.prototype.createPeriodicWave = audioContext.prototype.createWaveTable;
			}
			
			return audioContext.createPeriodicWave();
		},
		
		createDelay: function (audioContext) {
			if (!$.core.Validate.isFunc(audioContext.prototype.createDelay)) {
				audioContext.prototype.createDelay = audioContext.prototype.createDelayNode;
			}
			
			return audioContext.createDelay();
		},
		
		createPanner: function (audioContext) {
			return audioContext.createPanner();
		},
		
		createStereoPanner: function (context) {
			return context.createStereoPanner;
		},
		
		createOscillator: function (context) {
			return context.createOscillator;
		},
		
		createAnalyser: function (context) {
			return context.createAnalyser;
		},
		
		closeAudioEffect: function (input, output, AudioNode) {
			if (!$.core.Validate.isFunc(input)) {
				if (input instanceof AudioNode) {
					input.disconnect();
				} 
				input = null;
			}
			
			if (!$.core.Validate.isFunc(output)) {
				if (output instanceof AudioNode) {
					output.disconnect();
				} 
				output = null;
			}
		},
		
		/**
		 * analyser : createAnalyser
		 */
		analyserFreqBinCount: function (analyser) {
			return analyser.frequencyBinCount; //Array
		},
		
		/**
		 * analyser : createAnalyser
		 */
		analyserGetByteFreqData: function (analyser, array) {
			return analyser.getByteFrequencyData(array);
		},
		
		createBuffSource: function (context) {
			return context.createBufferSource;
		}
		
	};
	
	A.constructor();
	
})(jQuery, $.core);
