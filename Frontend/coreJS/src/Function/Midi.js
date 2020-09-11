//Midi-related functions
'use strict';

(function ($, core) {

	var A = core.Midi = {
		
		constructor: function () {
			
			// http://fmslogo.sourceforge.net/manual/midi-instrument.html
			this.midiInstruments = [
				// Piano
				{"Instrument" : "Acoustic Grand Piano", "Class" : "Piano"},
				{"Instrument" : "Bright Acoustic Piano", "Class" : "Piano"},
				{"Instrument" : "Electric Grand Piano", "Class" : "Piano"},
				{"Instrument" : "Honky-tonk Piano", "Class" : "Piano"},
				{"Instrument" : "Rhodes Piano", "Class" : "Piano"},
				{"Instrument" : "Chorused Piano", "Class" : "Piano"},
				{"Instrument" : "Harpsichord", "Class" : "Piano"},
				{"Instrument" : "Clavinet", "Class" : "Piano"},
				// Chromatic Percussion
				{"Instrument" : "Celesta", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Glockenspiel", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Music box", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Vibraphone", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Marimba", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Xylophone", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Tubular Bells", "Class" : "Chromatic Percussion"},
				{"Instrument" : "Dulcimer", "Class" : "Chromatic Percussion"},
				// Organ
				{"Instrument" : "Hammond Organ", "Class" : "Organ"},
				{"Instrument" : "Percussive Organ", "Class" : "Organ"},
				{"Instrument" : "Rock Organ", "Class" : "Organ"},
				{"Instrument" : "Church Organ", "Class" : "Organ"},
				{"Instrument" : "Reed Organ", "Class" : "Organ"},
				{"Instrument" : "Accordion", "Class" : "Organ"},
				{"Instrument" : "Harmonica", "Class" : "Organ"},
				{"Instrument" : "Tango Accordion", "Class" : "Organ"},
				// Guitar
				{"Instrument" : "Acoustic Guitar (nylon)", "Class" : "Guitar"},
				{"Instrument" : "Acoustic Guitar (steel)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (jazz)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (clean)", "Class" : "Guitar"},
				{"Instrument" : "Electric Guitar (muted)", "Class" : "Guitar"},
				{"Instrument" : "Overdriven Guitar", "Class" : "Guitar"},
				{"Instrument" : "Distortion Guitar", "Class" : "Guitar"},
				{"Instrument" : "Guitar Harmonics", "Class" : "Guitar"},
				// Bass
				{"Instrument" : "Acoustic Bass", "Class" : "Bass"},
				{"Instrument" : "Electric Bass (finger)", "Class" : "Bass"},
				{"Instrument" : "Electric Bass (pick)", "Class" : "Bass"},
				{"Instrument" : "Fretless Bass", "Class" : "Bass"},
				{"Instrument" : "Slap Bass 1", "Class" : "Bass"},
				{"Instrument" : "Slap Bass 2", "Class" : "Bass"},
				{"Instrument" : "Synth Bass 1", "Class" : "Bass"},
				{"Instrument" : "Synth Bass 2", "Class" : "Bass"},
				// Strings
				{"Instrument" : "Violin", "Class" : "Strings"},
				{"Instrument" : "Viola", "Class" : "Strings"},
				{"Instrument" : "Cello", "Class" : "Strings"},
				{"Instrument" : "Contrabass", "Class" : "Strings"},
				{"Instrument" : "Tremolo Strings", "Class" : "Strings"},
				{"Instrument" : "Pizzicato Strings", "Class" : "Strings"},
				{"Instrument" : "Orchestral Harp", "Class" : "Strings"},
				// Ensemble
				{"Instrument" : "String Ensemble 1", "Class" : "Ensemble"},
				{"Instrument" : "String Ensemble 2", "Class" : "Ensemble"},
				{"Instrument" : "Synth Strings 1", "Class" : "Ensemble"},
				{"Instrument" : "Synth Strings 2", "Class" : "Ensemble"},
				{"Instrument" : "Choir Aahs", "Class" : "Ensemble"},
				{"Instrument" : "Voice Oohs", "Class" : "Ensemble"},
				{"Instrument" : "Synth Voice", "Class" : "Ensemble"},
				{"Instrument" : "Orchestra Hit", "Class" : "Ensemble"},
				{"Instrument" : "Timpani", "Class" : "Ensemble"},
				// Brass
				{"Instrument" : "Trumpet", "Class" : "Brass"},
				{"Instrument" : "Trombone", "Class" : "Brass"},
				{"Instrument" : "Tuba", "Class" : "Brass"},
				{"Instrument" : "Muted Trumpet", "Class" : "Brass"},
				{"Instrument" : "French Horn", "Class" : "Brass"},
				{"Instrument" : "Brass Section", "Class" : "Brass"},
				{"Instrument" : "Synth Brass 1", "Class" : "Brass"},
				{"Instrument" : "Synth Brass 2", "Class" : "Brass"},
				// Reed
				{"Instrument" : "Soprano Sax", "Class" : "Reed"},
				{"Instrument" : "Alto Sax", "Class" : "Reed"},
				{"Instrument" : "Tenor Sax", "Class" : "Reed"},
				{"Instrument" : "Baritone Sax", "Class" : "Reed"},
				{"Instrument" : "Oboe", "Class" : "Reed"},
				{"Instrument" : "English Horn", "Class" : "Reed"},
				{"Instrument" : "Bassoon", "Class" : "Reed"},
				{"Instrument" : "Clarinet", "Class" : "Reed"},
				// Pipe
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
		},
		
		parseMessage: function (message) {
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
		
		setOnAccessRequestEvent: function () {
			return navigator.requestMIDIAccess();
		},
		
		isPressed: function (command) {
			if (command === 145) {
				return true;
			} else if(command === 129) {
				return false;
			}
		},
		
		setOnMessageEvent: function (callback) {
			if (typeof callback === 'function') {
				// command, key, velocity
				device.onmidimessage = callback;
			}
		},
		
		isSupported: function () {
			if (navigator.requestMIDIAccess) {
				return true;
			}
			return false;
		},
		
		request: function (onSuccessCallback, onErrorCallback) {
			if (this.isSupport()) {
				navigator.requestMIDIAccess({
					sysex: false
				}).then(onSuccessCallback, onErrorCallback);
			}
		}
		
	};
	
})(jQuery, $.core);
