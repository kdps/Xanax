//harmonicGenerator-related functions
'use strict';

(function ($, core) {
	
	var A = core.harmonicGenerator = {
		constructor: function () {
			/**
			 * Perfect is 1,4,5,8
			 *
			 * Perfect Interval : Double Diminished... <- Diminished <- {Perfect} -> Augmented -> Double Augmented....
			 **/
			this.perfect4Interval = [0, 5]; // Perfect 4
			this.perfect5Interval = [0, 7]; // Perfect 5
			this.perfect8Interval = [0, 12]; // Perfect 8

			this.perfectInterval = [
				this.perfect4Interval, this.perfect5Interval, this.perfect8Interval
			];

			/**
			 * Major, Minor is 2,3,6,7
			 *
			 * Perfect Interval : Double Diminished... <- Diminished <- {Minor <-> Major} -> Augmented -> Double Augmented....
			 **/
			this.m2Interval = [0, 2], // major 2
			this.m3Interval = [0, 4], // major 3
			this.m6Interval = [0, 9], // major 6
			this.m7Interval = [0, 11], // major 7

			this.mInterval = [
				this.m2Interval, this.m3Interval, this.m6Interval, this.m7Interval
			],

			this.germanAugmentedSixthChord = [0, 3, 6, 9], // bA, C, Eb, Gb(F#)
			this.frenchAugmentedSixthChord = [0, 3, 5, 9], // bA, C, D, Gb(F#)
			this.italianAugmentedSixthChord = [0, 3, 9], // bA, C, Gb(F#)

			this.majorChord = [0, 4, 7], // Maj, C, E, G
			this.minorChord = [0, 3, 7], // Min, C, Eb, G
			this.augmentedChord = [0, 4, 8], // +, C, E, G#
			this.suspendedChord = [0, 5, 7], // sus4, C, F, G
			this.diminishedChord = [0, 3, 6], // dim, C, Eb, Gb
			this.minorMajorSeventhChord = [0, 3, 7, 11], // mM7, C, Eb, G, B
			this.majorSeventhChord = [0, 4, 7, 11], // M7, C, E, G, B
			this.minorSixthChord = [0, 3, 7, 9], // m7, C, Eb, G, A
			this.minorSeventhChord = [0, 3, 7, 10], // m7, C, Eb, G, Bb
			this.minorSeventhFlat5Chord = [0, 3, 8, 10], // m7b5, C, Eb, G#, Bb
			this.SeventhChord = [0, 4, 7, 10], // 7, C, E, G, Bb
			this.diminishedSeventhChord = [0, 3, 6, 9], // dim7, C, Eb, Gb, Bbb(=A)
			this.augmentedSeventhChord = [0, 4, 8, 10], // 7+, C, E, G#, Bb
			this.SeventhFlat5Chord = [0, 4, 6, 10], // 7b5, C, E, Gb, Bb
			this.SeventhSharp5Chord = [0, 4, 8, 10], // 7+5, C, E, G#, Bb
			this.SixthChord = [0, 4, 7, 9], // 6, C, E, G, A
			this.minorSixthChord = [0, 3, 7, 9], // 6, C, Eb, G, A
			this.SixthNinthChord = [0, 2, 4, 7, 9], // 6, C, D, E, G, A
			
			this.chordList = {
				"majorChord": this.majorChord, 
				"minorChord": this.minorChord, 
				"SixthChord": this.SixthChord,
				"augmentedChord": this.augmentedChord, 
				"suspendedChord": this.suspendedChord, 
				"diminishedChord": this.diminishedChord, 
				"majorSeventhChord": this.majorSeventhChord, 
				"minorSeventhChord": this.minorSeventhChord, 
				"minorSeventhFlat5Chord": this.minorSeventhFlat5Chord, 
				"SeventhChord": this.SeventhChord, 
				"diminishedSeventhChord": this.diminishedSeventhChord, 
				"augmentedSeventhChord": this.augmentedSeventhChord, 
				"SeventhFlat5Chord": this.SeventhFlat5Chord, 
				"SeventhSharp5Chord": this.SeventhSharp5Chord, 
				"germanAugmentedSixthChord": this.germanAugmentedSixthChord, 
				"frenchAugmentedSixthChord": this.frenchAugmentedSixthChord, 
				"italianAugmentedSixthChord": this.italianAugmentedSixthChord,
				"minorSixthChord": this.minorSixthChord,
				"SixthNinthChord": this.SixthNinthChord,
				"minorMajorSeventhChord": this.minorMajorSeventhChord,
			},

			this.aeolianChord = {
				"Cm7": {
					"root": 0,
					"chord": this.minorSeventhChord,
					"romename": "Im7",
					"yamahaname": "Cm7",
					"symbols": "C-7",
					"type": "Tonic Minor",
					"scale": {
						"aeolian": {
							"avoidnote": 8
						},

						"dorian": {
							"avoidnote": 8
						}
					}
				}, // Cm7
				"Dm7b5": {
					"root": 2,
					"chord": this.minorSeventhFlat5Chord,
					"romename": "IIm7b5",
					"yamahaname": "Dm7b5",
					"symbols": "D-7b5",
					"type": "SubDominant Minor",
					"scale": {
						"locrian": {
							"avoidnote": 1
						},

						"locrian9": {}
					}
				}, // Dm7b5
				"DbM7": {
					"root": 2,
					"chord": this.majorSeventhChord,
					"romename": "IIbM7",
					"yamahaname": "DbM7",
					"symbols": "Db-7",
					"type": "SubDominant Minor",
					"scale": {
						"locrian": {
							"avoidnote": 1
						},

						"locrian9": {}
					}
				}, // DbM7
				"EbM7": {
					"root": 4,
					"chord": this.majorSeventhChord,
					"romename": "IIIbM7",
					"yamahaname": "EbM7",
					"symbols": "EbΔ7",
					"type": "Tonic Minor",
					"scale": {
						"lydian": {}
					}
				}, // EbM7
				"IVm7": {
					"root": 5,
					"chord": this.minorSeventhChord,
					"romename": "IVm7",
					"yamahaname": "Fm7",
					"symbols": "F-7",
					"type": "SubDominant Minor",
					"scale": {
						"dorian": {
							"avoidnote": 9
						}
					}
				}, // IVm7
				"IVm6": {
					"root": 5,
					"chord": this.minorSeventhChord,
					"romename": "IVm6",
					"yamahaname": "Fm6",
					"symbols": "F-6",
					"type": "SubDominant Minor",
					"scale": {
						"dorian": {
							"avoidnote": 10
						}
					}
				}, // IVm6
				"IVmM7": {
					"root": 5,
					"chord": this.minorSeventhChord,
					"romename": "IVmM7",
					"yamahaname": "FmM7",
					"symbols": "F-Δ7",
					"type": "SubDominant Minor",
					"scale": {
						"melodicminor": {}
					}
				}, // IVmM7
				"Vm7": {
					"root": 7,
					"chord": this.minorSeventhChord,
					"romename": "Vm7",
					"yamahaname": "Vm7",
					"symbols": "G-7",
					"type": "Tonic Minor",
					"scale": {
						"dorian": {
							"avoidnote": 9
						},

						"aeolian": {
							"avoidnote": 8
						}
					}
				}, // Vm7
				"AbM7": {
					"root": 9,
					"chord": this.majorSeventhChord,
					"romename": "VIbM7",
					"yamahaname": "AbM7",
					"symbols": "VIbΔ7",
					"type": "Tonic",
					"SubDominant Minor": {
						"lydian": {}
					}
				}, // AbM7
				"Bb7": {
					"root": 11,
					"chord": this.SeventhChord,
					"romename": "VII7",
					"yamahaname": "Bb7",
					"symbols": "VII7",
					"type": "SubDominant Minor",
					"scale": {
						"locrianb7": {},

						"mixolydian": {
							"avoidnote": 5
						}
					}
				} // Bb7
			},

			this.passingDiminished = {
				// F#dim7 G7
				"F#dim7": {
					"root": "6",
					"related": "G7",
					"scale": "",
					"romename": "#IVdim7",
					"symbols": "F#dim7",
					"type": "Padding Diminished"
				},
				// G#dim7 Am7
				"G#dim7": {
					"root": "8",
					"related": "Am7",
					"scale": "",
					"romename": "#Vdim7",
					"symbols": "G#dim7",
					"type": "Padding Diminished"
				},
				// C#dim7 Dm7
				"C#dim7": {
					"root": "1",
					"related": "Dm7",
					"scale": "",
					"romename": "#Idim7",
					"symbols": "C#dim7",
					"type": "Padding Diminished"
				},
				// D#dim7 Em7
				"D#dim7": {
					"root": "3",
					"related": "Em7",
					"scale": "",
					"romename": "#IIdim7",
					"symbols": "D#dim7",
					"type": "Padding Diminished"
				}
			},
				
			this.substituteDominant = {
				// Ab7 G7
				"Ab7": {
					"root": "8",
					"related": "G7",
					"scale": "",
					"romename": "II7",
					"symbols": "D7",
					"type": "Substitute Dominant"
				},
				// Bb7 Am7
				"Bb7": {
					"root": "10",
					"related": "Bb7",
					"scale": "",
					"romename": "bVII7",
					"symbols": "Bb7",
					"type": "Substitute Dominant"
				},
				// Eb7 Dm7
				"Eb7": {
					"root": "3",
					"related": "Eb7",
					"scale": "",
					"romename": "bIII7",
					"symbols": "Eb7",
					"type": "Substitute Dominant"
				}
			},
				
			this.secondaryDominant = {
				// D7 G7
				"D7": {
					"root": "2",
					"related": "G7",
					"scale": "",
					"romename": "II7",
					"symbols": "D7",
					"type": "Secondary Dominant"
				},
				// E7 Am7
				"E7": {
					"root": "4",
					"related": "Am7",
					"scale": "",
					"romename": "III7",
					"symbols": "E7",
					"type": "Secondary Dominant"
				},
				// A7 Dm7
				"A7": {
					"root": "9",
					"related": "A7",
					"scale": "",
					"romename": "VI7",
					"symbols": "A7",
					"type": "Secondary Dominant"
				},
				// B7 Em7
				"B7": {
					"root": "11",
					"related": "B7",
					"scale": "",
					"romename": "VII7",
					"symbols": "B7",
					"type": "Secondary Dominant"
				}
			},
			
			this.diatonicChord = {
				"CM7": {
					"root": 0,
					"chord": this.majorSeventhChord,
					"romename": "IM7",
					"yamahaname": "CM7",
					"symbols": "CΔ7",
					"type": "Tonic"
				}, // CM7
				"Dm7": {
					"root": 2,
					"chord": this.minorSeventhChord,
					"romename": "IIm7",
					"yamahaname": "Dm7",
					"symbols": "D-7",
					"type": "SubDominant"
				}, // Dm7
				"Em7": {
					"root": 4,
					"chord": this.minorSeventhChord,
					"romename": "IIIm7",
					"yamahaname": "Em7",
					"symbols": "E-7",
					"type": "Dominant"
				}, // Em7
				"FM7": {
					"root": 5,
					"chord": this.majorSeventhChord,
					"romename": "IVM7",
					"yamahaname": "FM7",
					"symbols": "FΔ7",
					"type": "SubDominant"
				}, // F7
				"G7": {
					"root": 7,
					"chord": this.SeventhChord,
					"romename": "VM7",
					"yamahaname": "G7",
					"symbols": "G7",
					"type": "Dominant"
				}, // G7
				"Am7": {
					"root": 9,
					"chord": this.minorSeventhChord,
					"romename": "VIm7",
					"yamahaname": "Am7",
					"symbols": "VI-7",
					"type": "Tonic"
				}, // Am7
				"Bdim7": {
					"root": 11,
					"chord": this.diminishedSeventhChord,
					"romename": "VIIdim7",
					"yamahaname": "Bdim7",
					"symbols": "VIIo7",
					"type": ["Dominant", "SubDominant"]
				} // Bdim7
			},

			// Music
			this.OctaveTone = 12,
			
			this.toneYamaha = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B"],
			
			this.yamahaTone = {
				"C": 0,
				"Dbb": 0,
				"C#": 1,
				"Db": 1,
				"D": 2,
				"Cx": 2,
				"Ebb": 2,
				"D#": 3,
				"Eb": 3,
				"E": 4,
				"Fb": 4,
				"F": 5,
				"E#": 5,
				"Gbb": 5,
				"F#": 6,
				"Gb": 6,
				"G": 7,
				"Fx": 7,
				"Abb": 7,
				"G#": 8,
				"Ab": 8,
				"A": 9,
				"Gx": 9,
				"Bbb": 9,
				"A#": 10,
				"Bb": 10,
				"B": 11,
				"Ax": 11,
				"Cb": 11,
				"B#": 12
			},

			this.romeTone = {
				"I": 0,
				"IIbb": 0,
				"I#": 1,
				"IIb": 1,
				"II": 2,
				"Ix": 2,
				"IIIbb": 2,
				"II#": 3,
				"IIIb": 3,
				"III": 4,
				"IVb": 4,
				"IV": 5,
				"III#": 5,
				"Vbb": 5,
				"IV#": 6,
				"Vb": 6,
				"V": 7,
				"IVx": 7,
				"VIbb": 7,
				"V#": 8,
				"VIb": 8,
				"VI": 9,
				"Vx": 9,
				"VIIbb": 9,
				"VI#": 10,
				"VIIb": 10,
				"VII": 11,
				"VIx": 11,
				"Ib": 11,
				"VII#": 12
			},

			this.symbolTone = {
				"C": 0,
				"D--": 0,
				"C+": 1,
				"D-": 1,
				"D": 2,
				"C++": 2,
				"E--": 2,
				"D+": 3,
				"E-": 3,
				"E": 4,
				"F-": 4,
				"F": 5,
				"E+": 5,
				"G--": 5,
				"F+": 6,
				"G-": 6,
				"G": 7,
				"F++": 7,
				"A--": 7,
				"G+": 8,
				"A-": 8,
				"A": 9,
				"G++": 9,
				"B--": 9,
				"A+": 10,
				"B-": 10,
				"B": 11,
				"A++": 11,
				"C-": 11,
				"B+": 12
			},

			// Scale
			this.majorScale = [0, 2, 4, 5, 7, 9, 11],
			this.minorScale = [0, 2, 3, 5, 7, 8, 10],
			this.pentatonicScale = [0, 2, 4, 7, 9],
			this.bluesScale = [0, 3, 5, 6, 7, 10],
			this.melodicMinorScale = [0, 2, 3, 5, 7, 9, 11],

			// Mode
			this.ionianMode = this.majorScale, // C
			this.dorianMode = [0, 2, 3, 5, 7, 9, 10], // D
			this.phrygianMode = [0, 1, 3, 5, 7, 8, 10] // E
			this.lydianMode = [0, 2, 4, 6, 7, 9, 11], // F
			this.mixolydianMode = [0, 2, 4, 5, 7, 9, 10], // G
			this.aeolianMode = [0, 2, 3, 5, 7, 8, 10, 12], //A
			this.locrianMode = [0, 1, 3, 5, 6, 8, 10], // B
			this.locrian9Mode = [0, 2, 3, 5, 6, 8, 10], // B
			this.locrianb7Mode = [0, 2, 4, 6, 8, 10, 11], // B
			this.mixolydianMode = [0, 2, 4, 5, 8, 10, 11], // B

			this.modalInterchangeChordList = {
			
			},
				
			// hypo Mode
			this.hypoionianMode = this.mixolydianMode, // C
			this.hypodorianMode = this.aeolianMode, // D
			this.hypophrygianMode = this.locrianMode, // E
			this.hypolydianMode = this.ionianMode, // F
			this.hypomixolydianMode = this.dorianMode, // G
			this.hypoaeolianMode = this.phrygianMode, // A
			this.hypolocrianMode = this.lydianMode, // B

			this.scaleList = {
				"majorScale": this.majorScale, 
				"minorScale": this.minorScale, 
				"pentatonicScale": this.pentatonicScale, 
				"aeolianScale": this.aeolianMode, 
				"bluesScale": this.bluesScale
			};
			
			this.modeList = {
				"ionianMode": this.ionianMode, 
				"dorianMode": this.dorianMode, 
				"phrygianMode": this.phrygianMode, 
				"lydianMode": this.lydianMode, 
				"mixolydianMode": this.mixolydianMode, 
				"aeolianMode": this.aeolianMode, 
				"locrianMode": this.locrianMode, 
				"hypoionianMode": this.hypoionianMode, 
				"hypodorianMode": this.hypodorianMode, 
				"hypophrygianMode": this.hypophrygianMode, 
				"hypolydianMode": this.hypolydianMode, 
				"hypomixolydianMode": this.hypomixolydianMode, 
				"hypoaeolianMode": this.hypoaeolianMode, 
				"hypolocrianMode": this.hypolocrianMode
			};
		},

		getAvoidNotes: function (scale) {
			var scaleArr = [];
			var index = 0;
			while(true) {
				var avoidNote = scale[index + 1] - scale[index];
				if (avoidNote == 1) {
					scaleArr.push(scale[index + 1]);
				}
				index = index + 2;
				
				if (index > scale.length) break;
			}
			
			return scaleArr;
		},

		setScaleOctave: function (scale, octave) {
			var scaleArr = [];
			scale.forEach(function(note) {
				scaleArr.push((parseInt(12) * octave) + parseInt(note)); 
			});
			
			return scaleArr;
		},

		getChord: function (root, type) {
			var scaleArr = [];
			var Scale = this.chordList[type];
			Scale.forEach(function(note) {
				scaleArr.push(parseInt(root) + parseInt(note)); 
			});
			
			return scaleArr;
		},

		getScaleDiff: function (scale) {
			var scaleArr = [];
			var scaleCompare;
			var scaleTmp;
			scaleCompare = $.core.Arr.getMinValue(scale);
			scale.forEach(function(note) {
				if (!scaleTmp) {
					scaleTmp = note;
				} else {
					scaleTmp = note;
				}
				
				var diff = (parseInt(note) - parseInt(scaleCompare));
				scaleArr.push(diff);
			});
			
			return scaleArr;
		},

		getSixthChord: function (root) {
			return this.getChord(root, "SixthChord");
		},

		getSixthNinthChord: function (root) {
			return this.getChord(root, "SixthNinthChord");
		},

		getMajorChord: function (root) {
			return this.getChord(root, "majorChord");
		},

		getMinorChord: function (root) {
			return this.getChord(root, "minorChord");
		},

		getAugmentedChord: function (root) {
			return this.getChord(root, "augmentedChord");
		},

		getSuspendedChord: function (root) {
			return this.getChord(root, "suspendedChord");
		},

		getDiminishedChord: function (root) {
			return this.getChord(root, "diminishedChord");
		},

		getMajorSeventhChord: function (root) {
			return this.getChord(root, "majorSeventhChord");
		},

		getMinorSeventhChord: function (root) {
			return this.getChord(root, "minorSeventhChord");
		},

		getMinorSeventhFlat5Chord: function (root) {
			return this.getChord(root, "minorSeventhFlat5Chord");
		},

		getSeventhChord: function (root) {
			return this.getChord(root, "SeventhChord");
		},

		getDiminishedSeventhChord: function (root) {
			return this.getChord(root, "diminishedSeventhChord");
		},

		getAugmentedSeventhChord: function (root) {
			return this.getChord(root, "augmentedSeventhChord");
		},

		getSeventhFlat5Chord: function (root) {
			return this.getChord(root, "SeventhFlat5Chord");
		},

		getSeventhSharp5Chord: function (root) {
			return this.getChord(root, "SeventhSharp5Chord");
		},

		getNoteList: function (scale) {
			var scaleArr = [];
			var objectKeys = Object.keys(yamahaTone);
			var objectVars = Object.values(yamahaTone);
			
			function getYamahaNote(value) {
				var arrIndex = objectVars.indexOf(value % 12); // Remove Octave
				return objectKeys[arrIndex];
			}
			
			scale.forEach(function(note) {
				scaleArr.push(getYamahaNote(note));
			});
			
			return scaleArr;
		},

		getScale: function (root, type) {
			var scaleArr = [];
			var Scale = this.scaleList[type];
			
			Scale.forEach(function(note) {
				scaleArr.push(parseInt(root) + parseInt(note)); 
			});
			
			return scaleArr;
		},

		getMajorScale: function (root) {
			return this.getScale(root, 'majorScale');
		},

		getMinorScale: function (root) {
			return this.getScale(root, 'minorScale');
		},

		getPentatonicScale: function (root) {
			return this.getScale(root, 'pentatonicScale');
		},

		getBluesScale: function (root) {
			return this.getScale(root, 'bluesScale');
		},

		getMode: function (root, type) {
			var scaleArr = [];
			var Scale = this.modeList[type];
			Scale.forEach(function(note) {
				scaleArr.push(parseInt(root) + parseInt(note)); 
			});
			
			return scaleArr;
		},

		getIonianMode: function (root) {
			return this.getMode(root, 'ionianMode');
		},

		getDorianMode: function (root) {
			return this.getMode(root, 'dorianMode');
		},

		getPhrygianMode: function (root) {
			return this.getMode(root, 'phrygianMode');
		},

		getLydianMode: function (root) {
			return this.getMode(root, 'lydianMode');
		},

		getMixolydianMode: function (root) {
			return this.getMode(root, 'mixolydianMode');
		},

		getAeolianMode: function (root) {
			return this.getMode(root, 'aeolianMode');
		},

		getLocrianMode: function (root) {
			return this.getMode(root, 'locrianMode');
		},

		getHypoionianMode: function (root) {
			return this.getMode(root, 'hypoionianMode');
		},

		getHypodorianMode: function (root) {
			return this.getMode(root, 'hypodorianMode');
		},

		getHypophrygianMode: function (root) {
			return this.getMode(root, 'hypophrygianMode');
		},

		getHypolydianMode: function (root) {
			return this.getMode(root, 'hypolydianMode');
		},

		getHypomixolydianMode: function (root) {
			return this.getMode(root, 'hypomixolydianMode');
		},

		getHypoaeolianMode: function (root) {
			return this.getMode(root, 'hypoaeolianMode');
		},

		getHypolocrianMode: function (root) {
			return this.getMode(root, 'hypolocrianMode');
		}
		
	};
	
	A.constructor();
	
})(jQuery, $.core);
