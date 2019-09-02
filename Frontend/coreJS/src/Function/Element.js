//Element-related functions
'use strict';

(function ($, core) {

	var A = core.Element = {
		
		constructor: function () {
			this.SVG_NS = 'http://www.w3.org/2000/svg';
	
			this.SVG_ICON = {
				// https://commons.wikimedia.org/wiki/File:B%C3%A9mol.svg
				'flat': 'm 1.380956,10.84306 -0.02557,1.68783 0,0.28131 c 0,0.56261 0.02557,1.12522 0.102293,1.68783 1.150797,-0.97178 2.378313,-2.04586 2.378313,-3.55468 0,-0.84392 -0.358026,-1.7134103 -1.09965,-1.7134103 -0.792771,0 -1.329809,0.7672 -1.355382,1.6111203 z M 0.306879,15.42067 0,0.20457992 C 0.204586,0.07671992 0.460319,-7.6580061e-8 0.690478,-7.6580061e-8 0.920637,-7.6580061e-8 1.17637,0.07669992 1.380956,0.20457992 L 1.201943,9.0273597 c 0.639331,-0.53704 1.483249,-0.8695 2.327166,-0.8695 1.329809,0 2.27602,1.22752 2.27602,2.6084803 0,2.04586 -2.1993,2.99207 -3.759269,4.32188 C 1.662261,15.42067 1.432102,16.06 0.895064,16.06 0.562612,16.06 0.306879,15.77869 0.306879,15.42067 Z',
				'flat_height': 16.059999465942383, // https://commons.wikimedia.org/wiki/File:Di%C3%A8se.svg
				'sharp': 'm 4.6252809,-11.71096 c 0,-0.21414 -0.1713067,-0.40686 -0.38544,-0.40686 -0.2141334,0 -0.4068535,0.19272 -0.4068535,0.40686 l 0,3.1049303 -1.777307,-0.66381 0,-3.3833103 c 0,-0.21413 -0.19272,-0.40685 -0.4068534,-0.40685 -0.2141334,0 -0.3854401,0.19272 -0.3854401,0.40685 l 0,3.1049303 -0.68522678,-0.25696 c -0.0428267,-0.0214 -0.10706669,-0.0214 -0.14989337,-0.0214 C 0.19272004,-9.8265897 0,-9.6338697 0,-9.3983197 l 0,1.2847998 c 0,0.1713 0.10706669,0.34261 0.27837339,0.40685 l 0.98501351,0.34261 0,3.42614 -0.68522678,-0.23555 c -0.0428267,-0.0214 -0.10706669,-0.0214 -0.14989337,-0.0214 C 0.19272004,-4.1948799 0,-4.0021599 0,-3.7666099 l 0,1.2848 c 0,0.1713 0.10706669,0.3212 0.27837339,0.38544 l 0.98501351,0.36402 0,3.38331 c 0,0.21413 0.1713067,0.40685 0.3854401,0.40685 0.2141334,0 0.4068534,-0.19272 0.4068534,-0.40685 l 0,-3.10493 1.777307,0.66380998 0,3.38331002 c 0,0.21413 0.1927201,0.40685 0.4068535,0.40685 0.2141333,0 0.38544,-0.19272 0.38544,-0.40685 l 0,-3.10494002 0.6852268,0.25696 c 0.042827,0.0214 0.1070667,0.0214 0.1498934,0.0214 0.2355467,0 0.4282668,-0.19272 0.4282668,-0.42827 l 0,-1.28479998 c 0,-0.17131 -0.1070667,-0.34261 -0.2783734,-0.40685 l -0.9850136,-0.34262 0,-3.42613 0.6852268,0.23554 c 0.042827,0.0214 0.1070667,0.0214 0.1498934,0.0214 0.2355467,0 0.4282668,-0.19272 0.4282668,-0.42827 l 0,-1.2848 c 0,-0.17131 -0.1070667,-0.3212 -0.2783734,-0.38544 l -0.9850136,-0.36403 0,-3.3833001 z m -2.5696005,8.0728301 0,-3.42614 1.777307,0.6424 0,3.42614 z',
				'sharp_height': 16.059999465942383,
				'bar': 'M 0,0 0,100',
				'bar_height': 100,
				'delta_char': '\u0394',
				'oslash_char': '\u00F8',
				'slabo27px_H_height_ratio': 33.33 / 50
			},
			
			//keyCode ascii code array
			this.keydownKeycode = {
				'backspace': 8,
				'tab': 9,
				'enter': 13,
				'shift': 16,
				'ctrl': 17,
				'alt': 18,
				'pause/break': 19,
				'capslock': 20,
				'esc': 27,
				'pageup': 33,
				'pagedown': 34,
				'end': 35,
				'home': 36,
				'arrowleft': 37,
				'arrowup': 38,
				'arrowright': 39,
				'arrowdown': 40,
				'insert': 45,
				'delete': 46,
				0: 48,
				1: 49,
				2: 50,
				3: 51,
				4: 52,
				5: 53,
				6: 54,
				7: 55,
				8: 56,
				9: 57,
				';:': 59,
				'=+': 61,
				'a': 65,
				'b': 66,
				'c': 67,
				'd': 68,
				'e': 69,
				'f1': 112,
				'f2': 113,
				'f3': 114,
				'f4': 115,
				'f5': 116,
				'f6': 117,
				'f7': 118,
				'f8': 119,
				'f9': 120,
				'f10': 121,
				'f11': 122,
				'f12': 123,
				'f': 70,
				'g': 71,
				'h': 72,
				'i': 73,
				'j': 74,
				'k': 75,
				'l': 76,
				'm': 77,
				'n': 78,
				'o': 79,
				'p': 80,
				'q': 81,
				'r': 82,
				's': 83,
				't': 84,
				'u': 85,
				'v': 86,
				'w': 87,
				'x': 88,
				'y': 89,
				'z': 90,
				'windows': 91,
				'rightclick': 93,
				'numlock': 144,
				'scrolllock': 145,
				'.>': 190,
				'/?': 1991,
				'mycomputer': 182,
				'mycalcurator': 183,
				"'~": 192,
				',<': 188,
				'\|': 220,
				']}': 220,
				'[{': 219,
				"'": 222,
				'"': 222
			},

			this.webColorCodes = {
				boogerbuster: "DDE26A",
				blizzardblue: "ACE5EE",
				cadetblue: "5F9EA0",
				celadon: "ACE1AF",
				azure: "007FFF",
				aztecgold: "C39953",
				avocado: "568203",
				aureolin: "FDEE00",
				auburn: "A52A2A",
				atomictangerine: "FF9966",
				asparagus: "87A96B",
				ashgrey: "B2BEB5",
				arylideyellow: "E9D66B",
				artichoke: "8F9779",
				arsenic: "3B444B",
				armygreen: "4B5320",
				arcticlime: "D0FF14",
				apricot: "FBCEB1",
				applegreen: "8DB600",
				antiquewhite: "FAEBD7",
				antiqueruby: "841B2D",
				antiquefuchsia: "915C83",
				antiquebronze: "665D1E",
				antiquebrass: "CD9575",
				antiflashwhite: "F2F3F4",
				androidgreen: "A4C639",
				amethyst: "9966CC",
				americanrose: "FF033E",
				amber: "FFBF00",
				amazon: "3B7A57",
				amaranthred: "D3212D",
				amaranthpurple: "AB274F",
				amaranthpink: "F19CBB",
				amaranthdeeppurple: "AB274F",
				amaranth: "E52B50",
				almond: "EFDECD",
				alloyorange: "C46210",
				alizarincrimson: "E32636",
				alienarmpit: "84DE02",
				aliceblue: "F0F8FF",
				alabamacrimson: "AF002A",
				airsuperiorityblue: "72A0C1",
				airforceblue: "5D8AA8",
				africanviolet: "B284BE",
				aeroblue: "C9FFE5",
				aero: "7CB9E8",
				absolutezero: "0048BA",
				acidgreen: "B0BF1A",
				lemonchiffon: "FFFACD",
				rebeccapurple: "663399",
				aliceblue: "f0f8ff",
				antiquewhite: "faebd7",
				aqua: "00ffff",
				aquamarine: "7fffd4",
				azure: "f0ffff",
				beige: "f5f5dc",
				bisque: "ffe4c4",
				black: "000000",
				blanchedalmond: "ffebcd",
				blue: "0000ff",
				blueviolet: "8a2be2",
				brown: "a52a2a",
				burlywood: "deb887",
				cadetblue: "5f9ea0",
				chartreuse: "7fff00",
				chocolate: "d2691e",
				coral: "ff7f50",
				cornflowerblue: "6495ed",
				cornsilk: "fff8dc",
				crimson: "dc143c",
				cyan: "00ffff",
				darkblue: "00008b",
				darkcyan: "008b8b",
				darkgoldenrod: "b8860b",
				darkgray: "a9a9a9",
				darkgreen: "006400",
				darkkhaki: "bdb76b",
				darkmagenta: "8b008b",
				darkolivegreen: "556b2f",
				darkorange: "ff8c00",
				darkorchid: "9932cc",
				darkred: "8b0000",
				darksalmon: "e9967a",
				darkseagreen: "8fbc8f",
				darkslateblue: "483d8b",
				darkslategray: "2f4f4f",
				darkturquoise: "00ced1",
				darkviolet: "9400d3",
				deeppink: "ff1493",
				deepskyblue: "00bfff",
				dimgray: "696969",
				dodgerblue: "1e90ff",
				firebrick: "b22222",
				floralwhite: "fffaf0",
				forestgreen: "228b22",
				fuchsia: "ff00ff",
				gainsboro: "dcdcdc",
				ghostwhite: "f8f8ff",
				gold: "ffd700",
				goldenrod: "daa520",
				gray: "808080",
				green: "008000",
				greenyellow: "adff2f",
				honeydew: "f0fff0",
				hotpink: "ff69b4",
				indianred: "cd5c5c",
				indigo: "4b0082",
				ivory: "fffff0",
				khaki: "f0e68c",
				lavender: "e6e6fa",
				lavenderblush: "fff0f5",
				lawngreen: "7cfc00",
				lemonchiffon: "fffacd",
				lightblue: "add8e6",
				lightcoral: "f08080",
				lightcyan: "e0ffff",
				lightgoldenrodyellow: "fafad2",
				lightgrey: "d3d3d3",
				lightgreen: "90ee90",
				lightpink: "ffb6c1",
				lightsalmon: "ffa07a",
				lightseagreen: "20b2aa",
				lightskyblue: "87cefa",
				lightslategray: "778899",
				lightsteelblue: "b0c4de",
				lightyellow: "ffffe0",
				lime: "00ff00",
				limegreen: "32cd32",
				linen: "faf0e6",
				magenta: "ff00ff",
				maroon: "800000",
				mediumaquamarine: "66cdaa",
				mediumblue: "0000cd",
				mediumorchid: "ba55d3",
				mediumpurple: "9370d8",
				mediumseagreen: "3cb371",
				mediumslateblue: "7b68ee",
				mediumspringgreen: "00fa9a",
				mediumturquoise: "48d1cc",
				mediumvioletred: "c71585",
				midnightblue: "191970",
				mintcream: "f5fffa",
				mistyrose: "ffe4e1",
				moccasin: "ffe4b5",
				navajowhite: "ffdead",
				navy: "000080",
				oldlace: "fdf5e6",
				olive: "808000",
				olivedrab: "6b8e23",
				orange: "ffa500",
				orangered: "ff4500",
				orchid: "da70d6",
				palegoldenrod: "eee8aa",
				palegreen: "98fb98",
				f: "afeeee",
				palevioletred: "d87093",
				papayawhip: "ffefd5",
				peachpuff: "ffdab9",
				peru: "cd853f",
				pink: "ffc0cb",
				plum: "dda0dd",
				powderblue: "b0e0e6",
				purple: "800080",
				red: "ff0000",
				rosybrown: "bc8f8f",
				royalblue: "4169e1",
				saddlebrown: "8b4513",
				salmon: "fa8072",
				sandybrown: "f4a460",
				seagreen: "2e8b57",
				seashell: "fff5ee",
				sienna: "a0522d",
				silver: "c0c0c0",
				skyblue: "87ceeb",
				slateblue: "6a5acd",
				slategray: "708090",
				snow: "fffafa",
				springgreen: "00ff7f",
				steelblue: "4682b4",
				tan: "d2b48c",
				teal: "008080",
				thistle: "d8bfd8",
				tomato: "ff6347",
				turquoise: "40e0d0",
				violet: "ee82ee",
				wheat: "f5deb3",
				white: "ffffff",
				whitesmoke: "f5f5f5",
				yellow: "ffff00",
				yellowgreen: "9acd32",
				transparent: "transparent"
			};
		},
		
		setFontResizableByWheel: function (object) {
			$(object).bind('wheel', function(event) {
				var fontsize = parseInt($(this).css("font-size").replace("px", ""));

				if (event.originalEvent.deltaY < 0) {
					if (fontsize < 250) {
						$(this).css("font-size", fontsize + 1);
					}
				} else {
					if (fontsize > 9) {
						$(this).css("font-size", fontsize - 1);
					}
				}

				return false;
			});
		},
		
		setMovableOnWindow: function (object, attributeObject) {
			$(object).mousedown(function(e) {

				var eventWhich = $.core.Evt.getMouseEventWhichType(e);

				if (eventWhich != 'left') return;

				document.body.style.cursor = "grabbing";

				var offsetX = $.core.Element.getElementOffsetLeft(object);
				var offsetY = $.core.Element.getElementOffsetTop(object);

				e.preventDefault();

				var xPosition = -((offsetX - e.pageX));
				var yPosition = -((offsetY - e.pageY));

				$(document).mousemove(function(e) {
					$(attributeObject).css("top", (e.pageY - yPosition));
					$(attributeObject).css("left", (e.pageX - xPosition));
				});

				$(document).mouseup(function(e) {
					document.body.style.cursor = "default";
					$(document).unbind('mousemove');
				});
			});
		},
		
		setXYResizable: function (container, object, callback, widthPadding, heightPadding) {
			var moveX = false;
			var moveY = false;

			if (!widthPadding) {
				widthPadding = 2;
			}
			
			if (!heightPadding) {
				heightPadding = 20;
			}
			
			$(object).mousemove(function(e) {
				var leftOffset = $.core.Element.getElementOffsetLeft(container);
				var topOffset = $.core.Element.getElementOffsetTop(container);
				var posX = -(leftOffset - e.pageX);
				var posY = -(topOffset - e.pageY);

				document.body.style.cursor = "default";

				var isXCursorInControllBar = (parseInt(posX) > ($(object).width() - widthPadding) && parseInt(posX) < $(object).width()) ? true : false;
				var isXCursorInArea = (parseInt(posY) < $(object).height() - heightPadding) ? true : false;

				if (isXCursorInControllBar && isXCursorInArea) {
					document.body.style.cursor = "w-resize";
					moveX = true;
				} else {
					moveX = false;
				}
				var isYCursorInControllBar = (parseInt(posY) > ($(object).height() - widthPadding) && parseInt(posY) < $(object).height()) ? true : false;
				var isYCursorInArea = parseInt(posX) < ($(object).width() - heightPadding) ? true : false;

				if (isYCursorInControllBar && isYCursorInArea) {
					document.body.style.cursor = "s-resize";
					moveY = true;
				} else {
					moveY = false;
				}
			});

			$(object).mousedown(function(e) {
				if (moveX) {
					$(document).mousemove(function(e) {
						document.body.style.cursor = "w-resize";
						var offsetX = $.core.Element.getElementOffsetLeft(object);
						var xPosition = -(offsetX - e.pageX);
						$(object).css("width", xPosition);
						
						if (typeof callback === 'function') {
							callback("x", xPosition);
						}
					});
				} else if (moveY) {
					$(document).mousemove(function(e) {
						document.body.style.cursor = "s-resize";
						var offsetY = $.core.Element.getElementOffsetTop(object);
						var yPosition = -(offsetY - e.pageY);
						$(object).css("height", yPosition);
						
						if (typeof callback === 'function') {
							callback("y", yPosition);
						}
					});
				}
			});

			$(document).mouseup(function(e) {
				document.body.style.cursor = "default";
				$(document).unbind('mousemove');
			});
		},
		
		setMovableOnContainer: function (container, object) {
			$(object).mousedown(function(e) {
				var self = this;
				var eventWhich = $.core.Evt.getMouseEventWhichType(e);

				if (eventWhich != 'left') return;

				e.preventDefault();

				var width = $(container).height();
				var offsetLeft = $.core.Element.getElementOffsetLeft(container);
				var mousePositionX = -(parseInt($(self).css("left")) - (-(offsetLeft - e.pageX)));


				var height = $(container).height();
				var offsetTop = $.core.Element.getElementOffsetTop(container);
				var mousePositionY = -(parseInt($(self).css("top")) - -(height - (-(offsetTop - e.pageY))));

				document.body.style.cursor = "grabbing";

				var currWidth = $(self).width();
				var currHeight = $(self).height();

				$(document).mousemove(function(e) {
					var width = $(container).width();
					var offsetLeft = $.core.Element.getElementOffsetLeft(container);
					var diffOffsetX = ((width - (-(offsetLeft - e.pageX))));
					var marginY = ((width >> 1) > diffOffsetX) ? (width >> 1) - diffOffsetX : -(diffOffsetX - (width >> 1));

					var leftP = ($(container).width() >> 1) + marginY - (mousePositionX);

					if (leftP < 0) {
						leftP = 0;
					} else if (leftP + currWidth > width) {
						leftP = width - currWidth;
					}

					var height = parseInt($(container).height());
					var offset = $.core.Element.getElementOffsetTop(container);
					var diffOffsetY = -((height - (-(offset - e.pageY))));

					var topP = diffOffsetY - mousePositionY;

					if (topP < 0) {
						topP = 0;
					} else if (parseInt(topP) + parseInt(currHeight) > parseInt(height)) {
						topP = parseInt(height) - parseInt(currHeight);
					}

					$(self).css("left", leftP);
					$(self).css("top", topP);
				});
			});

			$(document).mouseup(function(e) {
				document.body.style.cursor = "default";
				$(document).unbind('mousemove');
			});
		},
		
		setResizableOnContainer: function (controller, container, callback) {
			$(controller).mousedown(function(e) {
				var eventWhich = $.core.Evt.getMouseEventWhichType(e);

				if (eventWhich != 'left') return;

				document.body.style.cursor = "nw-resize";

				e.preventDefault();

				$(document).mousemove(function(e) {
					document.body.style.cursor = "nw-resize";

					var offsetX = $.core.Element.getElementOffsetLeft(container);
					var offsetY = $.core.Element.getElementOffsetTop(container);

					var xPosition = -(offsetX - e.pageX);
					var yPosition = -(offsetY - e.pageY);

					$(container).css("width", xPosition);
					$(container).css("height", yPosition);
					
					if (typeof callback === 'function') {
						callback(xPosition, yPosition);
					}
				});

				$(document).mouseup(function(e) {
					document.body.style.cursor = "default";
					$(document).unbind('mousemove');
				});
			});
		},
		
		parseString: function (html) {
			var parser = new DOMParser();
			var doc = parser.parseFromString(html, "text/html");
			
			return doc;
		},
		
		setStyle: function (data, style, callback) {
			if ($.core.Validate.isFunc(callback)) {
				$(data).css(style).queue(callback);
			} else {
				$(data).css(style);
			}
		},
		
		isHTMLElement: function (elem) {
			return (elem instanceof window.HTMLElement) ? true : false;
		},
		
		getWebColor: function (id) {
			return this.webColorCodes[id];
		},
		
		setMenuToggleClass: function (target, cls) {
			//JQMIGRATE: 'hover' pseudo-event is deprecated, use 'mouseenter mouseleave'
			$(target).on('focus mouseenter mouseover mousedown', function () {
				$(this).addClass(cls);
			}),
			$(target).on('mouseleave mouseout contextmenu mouseup',function () { 
				$(this).removeClass(cls);
			});
		},
		
		insertDOMParentBefore: function (target, dom, id) {
			var elem = document.getElementById(target);
			
			if (elem) {
				if (!$.core.Validate.isObject(dom)) {
					var _dom = document.createElement(dom);
				} else {
					var _dom = document.getElementById(dom);
				}
				
				elem.parentNode.insertBefore(_dom, elem);
				_dom.setAttribute("id", id);
			}
		},
		
		getElementOffsetLeft: function (element) {
			var element =  document.querySelector(element);
			var bodyRect = document.body.getBoundingClientRect();
			var elemRect = element.getBoundingClientRect();
			var offset   = elemRect.left - bodyRect.left;
			
			return offset;
		},
		
		getElementOffsetTop: function (element) {
			var element =  document.querySelector(element);
			var bodyRect = document.body.getBoundingClientRect();
			var elemRect = element.getBoundingClientRect();
			var offset   = elemRect.top - bodyRect.top;
			
			return offset;
		},
		
		getElementOffsetBottom: function (element) {
			var element =  document.querySelector(element);
			var bodyRect = document.body.getBoundingClientRect();
			var elemRect = element.getBoundingClientRect();
			var offset   = elemRect.bottom - bodyRect.bottom;
			
			return offset;
		},
		
		getElementsByClassNameCompatible: function (cls) {
			if (document.getElementsByClassName) {
				return document.getElementsByClassName(cls);
			}
			
			var i;
			var classArr = new Array();
			var regex = new RegExp('^| ' + cls + ' |$');
			var elem = document.body.getElementsByTagName("*");
			var len = elem.length;
			for (i=0; i < len; i++) {
				var clsName = elem[i].className;
				
				if (clsName) {
					if (regEx.test(clsName)) {
						classArr.push(elem[i]);
					}
				}
			}
			
			return classArr;
		},
		
		makeStruct: function (item, duplicate) {
			var item = item.split(duplicate);
			var count = item.length;
			
			function constructor() {
				var i;
				for (i = 0; i < count; i++) {
					this[names[i]] = arguments[i];
				}
			}
			
			return constructor;
		},
		
		getBodyLastChild: function () {
			return document.body.lastChild;
		},
		
		isBodyRTL: function () {
			return window.getComputedStyle(document.body).direction === 'rtl';
		},
		
		isCorrectFunctionName: function (func) {
			var func = /^\s*function\s*([A-Za-z0-9_$]*)/;
			return func.exec(func);
		},
		
		fontTest: function (beforeweight, beforefamily, afterweight, afterfamily, id) {
			before.family = (typeof(beforefamily) != 'undefined')? beforefamily: 'serif';
			before.weight = (typeof(beforeweight) != 'undefined')? beforeweight: '300';
			after.family = (typeof(afterfamily) != 'undefined')? afterfamily: 'serif';
			after.weight = (typeof(afterweight) != 'undefined')? afterweight: '300';	
			
			$('body').prepend('<p id="' + id + '" style="font-family:' + before.family + ';font-size:72px;font-weight:' + before.weight + ';left:-9999px;top:-9999px;position:absolute;visibility:hidden;width:auto;height:auto;">ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./\!</p>');
			
			var beforeWidth = $('p#' + id).width();
			var beforeHeight = $('p#' + id).height();
			
			$('p#jQuery-Font-Test').css({
				'font-family': (after.family + ',' + base.family),
				'font-weight': after.weight
			});
			
			var afterWidth = $('p#' + id).width();
			var afterHeight = $('p#' + id).height();
			
			$('p#' + id).remove();
			
			return (((afterHeight != beforeHeight) || (afterWidth != beforeWidth)) ? true: false);
		},
		
		getChildsText: function (node) {
			function getStrings(node, arr) {
				if (node.nodeType == 3) { /* Node.TEXT_NODE */
					arr.push(node.data);
				} else if (node.nodeType == 1) { /* Node.ELEMENT_NODE */
					for (var m = node.firstChild; m != null; m = m.nextSibling) {
						getStrings(m, arr);
					}
				}
			}
			
			var arr = [];
			getStrings(node, arr);
			return arr.join("");
		},
		
		selectTextArea: function (id) {
			document.getElementById(id).select();
		},
		
		getPointerX: function (evt) {
			if (!evt) {
				evt = window.event;
			}
			
			try{
				return evt.pageX || (evt.clientX + this.getScrollLeft());
			} catch (e) {
				console.log(e);
			}
		},
		
		getFunction: function (name, params) {
			query = name + "(" + params + ");";
			return eval(query);
		},
		
		getPointerY: function (evt) {
			if (!evt) {
				evt = window.event;
			}
			
			return evt.pageY || (evt.clientY + this.getScrollLeft());
		},
		
		getScrollX: function () {
			if (self.pageXOffset) {
				return self.pageXOffset;
			} else if (document.documentElement && document.documentElement.scrollTop) {
				return document.documentElement.scrollLeft;
			} else if (document.body && document.body.scrollLeft) {
				return document.body.scrollLeft;
			}
		},
		
		getScrollY: function () {
			if (self.pageYOffset) {
				return self.pageYOffset;
			} else if (document.documentElement && document.documentElement.scrollTop) {
				return document.documentElement.scrollTop;
			} else if (document.body && document.body.scrollTop) {
				return document.body.scrollTop;
			}
		},
		
		toggleLayer: function (id) {
			try {
				var obj = document.getElementById(id);
				
				obj.style.display = "none" == obj.style.display ? "block" : "none";
			} catch (e) {
				console.log(e);
			}
			
			return true;
		},
		
		findForm: function (object) {
			for (var obj = object; obj; obj = obj.parentNode) {
				if ("FORM" == obj.nodeName) {
					return obj;
				}
			}
		},
		
		trimAllTags: function (form) {
			try {
				var i;
				this.length = form.elements.length;
				for (var i = 0; i < this.length; i++) {
					//form.elements[i].tagName.toLowerCase();
					//form.elements[i].type
					/*TODO*/
				}
				return !0
			} catch (e) {
				console.log(e);
			}
		},
		
		getPosition: function (id, type) {
			var elem = this.getById(id);
			
			if (!elem) {
				return 0;
			}
			
			var offset = 0;
			while (elem) {
				if (type=='left') {
					if (!$.core.Validate.isUndefined(elem.offsetLeft)) {
						offset += elem.offsetLeft;
					}
				} else {
					if (!$.core.Validate.isUndefined(elem.offsetTop)) {
						offset += elem.offsetTop;
					}
				}
				elem = !$.core.Validate.isUndefined(elem.offsetParent) ? elem.offsetParent : null
			}
			return offset;
		},
		
		getParent: function (id, node) {
			var elem = this.getById(id);
			
			if (!elem) {
				return null;
			}
			
			var p = null;
			
			if (!node && !$.core.Validate.isUndefined(elem.offsetParent)) {
				p = elem.offsetParent;
			} else if (!$.core.Validate.isUndefined(elem.parentNode)) {
				p = elem.parentNode;
			} else if (!$.core.Validate.isUndefined(elem.parentElement)) {
				p = elem.parentElement;
			}
			
			return p;
		},
		
		generateTooltip: function (elem, cls) {
			var _tooltip = [];
			
			if (!$(elem).length) {
				return;
			}
			
			$(elem).each(function (i, item) {
				var _tooltipItem = $('<div class="' + cls + '" data-index="' + i + '"></div>').appendTo($body);
				$(item).attr('data-index', i);
				_tooltip.push(_tooltipItem);
			});
			
			return _tooltip;
		},
		
		removeIEObject: function (id) {
			var obj = $.core.Element.getById(id);
			if (obj) {
				for (var i in obj) {
					if (typeof obj[i] == "function") {
						obj[i] = null;
					}
				}
				
				obj.parentNode.removeChild(obj);
			}
		},
		
		getAttr: function (elem, prop) {
			return elem.getAttribute(prop);
		},
		
		getStyleText: function (elem) {
			var style = this.getAttr(elem, "style");
			if (!style) {
				style = elem.style;
			}
			
			if (typeof(style)=="object") {
				return style;
			}
			
			return null;
		},
		
		addStyle: function (id, html) {
			var style = document.createElement("style");
			style.type = "text/css";
			style.innerHTML = html;
			style.id = id;
			
			document.head.appendChild(style);
		},
		
		getStyle: function (elem, prop) {
			if (elem.currentStyle) {
				return elem.currentStyle[prop];
			} else if (_cWin.getComputedStyle) {
				return document.defaultView.getComputedStyle(elem, null).getPropertyValue(prop);
			}
		},
		
		preloadImage: function (src) {
			var preloadIMage = new Image;
			preloadIMage.src = src;
		},
		
		getMatchesSelector: function (elem) {
			return elem.prototype.matchesSelector || 
				   elem.prototype.mozMatchesSelector || 
				   elem.prototype.msMatchesSelector || 
				   elem.prototype.oMatchesSelector || 
				   elem.prototype.webkitMatchesSelector;
		},
		
		setAllCheckboxToggle: function (elem, target) {
			var isChecked = elem.checked;
			
			if (target) {
				var checker = [];
				
				if (!target.length) {
					checker.push(target);
				} else if (target.length > 0) {
					for (var i=0; i<target.length; i++) {
						checker.push(target[i]);
					}
				}
				
				for (var i=0; i<checker.length; i++) {
					var currentItem = checker[i];
					
					if (isChecked && !currentItem.checked) {
						currentItem.checked = true;
					} else if (!isChecked && currentItem.checked) {
						currentItem.checked = false;
					}
				}
			}
		},
		
		setCheckboxToggle: function (item) {
			var obj = $('input[name=' + item + ']:checkbox');
			
			obj.each(function () {
				$(this).attr('checked', ($(this).attr('checked')) ? false : true)
			});
		},
		
		getSelectedText: function () {
			if (_cWin.getSelection) {
				return _cWin.getSelection();
			} else if (document.getSelection) {
				return document.getSelection();
			} else {
				var selection = document.selection && document.selection.createRange();
				
				if (!selection) {
					return false;
				}
				
				if (selection.text) {
					return selection.text;
				}
				
				return false;
			}
		},
		
		getDoc: function (elem) {
			return (elem.contentWindow || elem.contentDocument).document;
		},
		
		isIncludedVideo: function (Id) {
			var obj = this.getById(id);
			
			if (obj && /object|embed/i.test(obj.nodeName)) {
				return true;
			}
			
			return false;
		},
		
		setHeaderStyle: function (style) {
			var head = document.getElementsByTagName('head')[0];
			
			if (style && head) {
				var styles = this.create('style');
				styles.setAttribute('type', 'text/css');
				if (styles.styleSheet) {
					try {
						styles.styleSheet.cssText = style;
					} catch(e) {
						styles.nodeText = style;
					}
				} else {
					var styles = document.createTextNode(style);
					styles.appendChild(styles);
				}
				
				head.appendChild(styles);
			}
		},
		
		setJS: function (url, callback) {
			try {
				var head = document.getElementsByTagName('head')[0];
				var script = this.create('script');
				var scripts = head.getElementsByTagName('script');
				
				script.type = 'text/javascript';
				script.src = url;
				script.async = true;
				
				for (var i = 0; i < scripts.length; i++) {
					if (scripts[i].href === script.src) {
						return false;
					}
				}
				
				head.appendChild(script) || document.body.appendChild(script);
				
				script.onreadystatechange = function (self, callback) {
					if (/complete|loaded/.test(script.readyState)) {
						if ($.core.Validate.isFunc(callback)) {
							try {
								callback.call(this, script);
							} catch (e) {
								console.log(e)
							}
						}
					}
				}
				
				script.onload = function (self, callback) {
					if ($.core.Validate.isFunc(callback)) {
						try {
							callback.call(this, script);
						} catch (e) {
							console.log(e)
						}
					}
				}
			} catch (e) {
				console.log(e);
			}
		},
		
		setCSS: function (url, callback) {
			try {
				var head = document.getElementsByTagName('head')[0];
				var link = this.create('link');
				var links = head.getElementsByTagName('link');
				link.rel = 'stylesheet';
				link.type = 'text/css';
				link.href = url;
				
				for (var i = 0; i < links.length; i++) {
					if (links[i].href === link.href) {
						return false;
					}
				}
				
				head.appendChild(link) || document.body.appendChild(link);
				
				/*script.onreadystatechange = function () {
					if (/complete|loaded/.test(script.readyState)) {
						if (callback != null && callback != undefined) {
							callback();
						}
					}
				}
				
				script.onload = function () {
					if (callback != null && callback != undefined) {
						callback();
					}
				}*/
			} catch (e) {
				console.log(e);
			}
		},
		
		setChecked: function (element) {
			$(element).prop('checked', true);
		},
		
		unsetChecked: function (element) {
			$(element).prop('checked', false);
		},
		
		isChecked: function (element) {
			return $(element).is(':checked');
		},
		
		hasProperty: function (obj, prop) {
			return protoObj.hasOwnProperty.call(obj, prop);
		},
		
		setProperty: function (obj, prop, descriptor) {
			if (descriptor) {
				Object.defineProperty(obj, prop, descriptor);
			} else {
				Object.defineProperties(obj, prop);
			}
		},
		
		getInnerWinSize: function () {
			return {
				width: this.getInnerWidth(),
				height: this.getInnerHeight()
			};
		},
		
		getProperty: function (element, prop) {
			return Object.getOwnPropertyDescriptor(element, prop);
		},
		
		readLittleEndian: function (array, index) {
			/***
			 * LSB (Least Significant Byte)
			 * 0x78, 0x56, 0x34, 0x12...
			 * Speed LE > BE
			 *
			 * ${https://oeis.org/A133752}
			 *
			 * 1, 256, 65536, 16777216, 4294967296, 1099511627776, 281474976710656, 72057594037927936, 18446744073709551616, 4722366482869645213696, 1208925819614629174706176, 309485009821345068724781056
			 */
			 
			//
			return (array[index + 3] * numberCValue(16777216) + array[index + 2] * numberCValue(65536) + array[index + 1] * numberCValue(256) + array[index + 0]);
		},
		
		readBigEndian: function (array, index) {
			/***
			 * MSB (Most Significant Byte)
			 * 0x12, 0x34, 0x56, 0x78...
			 */
			return (array[index + 0] * numberCValue(16777216) + array[index + 1] * numberCValue(65536) + array[index + 2] * numberCValue(256) + array[index + 3]);
		},
		
		generateCode: function (target, type, content) {
			var src = "";
			
			switch (type) {
			case "a":
				src = '<a href="' + target + '">' + content + '</a>';
				break;
			case "button":
				src = '<input type="button" value="' + content + '">' + target + '</input>';
				break;
			case "range":
				src = '<input type="range" value="' + content + '">' + target + '</input>';
				break;
			case "text":
				src = '<input type="text" value="' + content + '">' + target + '</input>';
				break;
			case "textarea":
				src = '<input type="textarea" value="' + content + '">' + target + '</input>';
				break;
			case "audio":
				src = '<audio src="' + target + '" controls></audio>';
				break;
			case "img":
				src = '<img src="' + target + '"></img>';
				break;
			case "embed":
				src = '<embed src="' + target + '"></embed>';
				break;
			case "video":
				src = '<video src="' + target + '" controls></video>';
				break;
			}
			
			return src;
		},
		
		isWheelExists: function () {
			document.onmousewheel !== undefined ?  'mousewheel' : 'DOMMouseScroll';
			
			if (document.onmousewheel !== undefined) {
				return true;
			}
			
			var hasWheel = ('onwheel' in document.createElement('div'));
			return hasWheel ? true : false;
		},
		
		generateMultimediaCode: function (file, type) {
			var src = "";
			
			switch (type) {
			case "audio":
				src = '<audio src="' + file + '" controls></audio>';
				break;
			case "img":
				src = '<img src="' + file + '"></img>';
				break;
			case "embed":
				src = '<embed src="' + file + '"></embed>';
				break;
			case "video":
				src = '<video src="' + file + '" controls></video>';
				break;
			}
			
			return src;
		},
		
		getRoot: function () {
			return document.documentElement;
		},
		
		clone: function ($element) {
			return $element.clone();
		},
		
		getSpecificType: function (type) {
			return $(document.activeElement).is(type);
		},
		
		getParents: function (el) {
			var parents = [];
			var p = el.parentNode;
			while (p !== document) {
				var o = p;
				parents.push(o);
				p = o.parentNode;
			}
			
			return parents;
		},
		
		findClass: document.getElementsByClassName ? (function (cls, context) {
			return protoArr.slice.call((context || document).getElementsByClassName(cls));
		}) : (function (cls, context) {
			var nodes = [];
			
			if (!cls) {
				return nodes;
			}
			
			var targets = (context || document).getElementsByTagName('*'),
				tokens = cls.split(' '),
				tn = tokens.length;
				
			for (var i = 0, n = targets.length; i < n; i++) {
				
				var targetClass = targets[i].className,
					hasToken = true;
					
				if (!targetClass) {
					continue;
				}
				
				for (var j = tn; j--;) {
					if (!new RegExp('(^|\\s)' + tokens[j] + '(\\s|$)').test(targetClass)) {
						hasToken = false;
						break;
					}
				}
				
				if (hasToken) {
					nodes.push(targets[i]);
				}
			}
			
			return nodes;
		}),
		
		addClass: function (element, className) {
			if (element.classList) {
				element.classList.add(className);
			} else {
				element.className += ' ' + className;
			}
		},
		
		hasClass: function (element, className) {
			var name = element.className;
			var reg = new RegExp(className, 'g');
			return reg.test(name);
		},
		
		removeClass: function (element, className) {
			if (element.classList) {
				element.classList.remove(className);
			} else {
				var name = element.className;
				var reg = new RegExp('[\\s\\u00A0\\u3000]*' + className + '[\\s\\u00A0\\u3000]*', 'g');
				element.className = name.replace(reg, ' ').replace(/[\s\u00A0\u3000]*$/, '');
			}
		},
		
		hasClasses: function (elem, className) {
			return elem.className.split(' ').indexOf(className) > -1;
		},
		
		/**
		 * Get Text Node
		 * @param {node} : element name
		 **/
		getTextNode: function (elem) {
			var textNode = _cDoc.createTextNode(elem);
			return textNode;
		},
		
		/**
		 * Get Object Rectangle Size
		 * @param {scope} : element
		 **/
		getRectangle: function (scope) {
			return {
				'offset_left': $(scope).offset().left || 0,
				'offset_top': $(scope).offset().top || 0,
				'position_left': $(scope).position().left || 0,
				'position_top': $(scope).position().top || 0,
				'width': $(scope).width() || 0,
				'height': $(scope).height() || 0
			};
		},
		
		getBasenamebyID: function (id) {
			return document.getElementById(id).value.split(/(\\|\/)/g).pop();
		},
		
		appendElement: function (id, type, callback) {
			var ul = document.getElementById(id);
			var li = document.createElement(type);
			
			if ($.core.Validate.isFunc(callback)) {
				callback(li);
			}
			
			ul.appendChild(li);
		},
		
		appendText: function (id, txt, callback) {
			this.appendElement(id, 'a', function (attr) {
				if ($.core.Validate.isFunc(callback)) {
					callback(attr);
				}
				
				attr.appendChild(document.createTextNode(txt));
			});
		},
		
		appendDiv: function (dom, cls) {
			if ($.core.Validate.isObject(dom)) {
				dom = dom.id || dom.className;
			}
			
			if (dom.match(/^#(.*)/)) {
				dom = $.core.Element.getById(dom);
			} else if (dom.match(/^\.(.*)$/)) {
				dom = dom.replace(/(^.)/i, "");
				dom = $.core.Element.getByClass(document, dom, dom);
			} else if (!$.core.Validate.isObject(dom)) {
				dom = $.core.Element.getById(dom);
			}
			
			if ($(dom).length > 0) {
				var append = this.create('div');
				append.className = cls;
				dom.appendChild(append);
				return append;
			} else {
				return false;
			}
		},
		
		appendDivId: function (dom, cls) {
			if ($.core.Validate.isObject(dom)) {
				dom = dom.id || dom.className;
			}
			
			if (dom.match(/^#(.*)/)) {
				dom = $.core.Element.getById(dom);
			} else if (dom.match(/^\.(.*)$/)) {
				dom = dom.replace(/(^.)/i, "");
				dom = $.core.Element.getByClass(document, dom, dom);
			} else if (!$.core.Validate.isObject(dom)) {
				dom = $.core.Element.getById(dom);
			}
			
			if ($(dom).length > 0) {
				var append = this.create('div');
				append.setAttribute("id", cls);
				dom.appendChild(append);
				return append;
			} else {
				return false;
			}
		},
		
		addDivOnBody: function (cls) {
			var docFrag = this.createFragment();
			var container = this.create('div');
			
			container.className = cls;
			docFrag.appendChild(container);
			document.body.appendChild(docFrag);
			
			return container;
		},
		
		getObjectType: function (target) {
			try {
				switch (typeof target) {
				case "undefined":
					return null;
				case "object":
					return target;
				default:
					return document.getElementById(target)
				}
			} catch (e) {
				return null;
			}
		},
		
		getWithNumberKeyCode: function (keyCode) {
			if (
					(keyCode > 47 && keyCode < 58) || 
					(keyCode > 95 && keyCode < 106) || 
					(keyCode == 46 || 
					 keyCode == 39 || 
					 keyCode == 37 || 
					 keyCode == 9 || 
					 keyCode == 8)
				) {
				return true;
			}
			
			return false;
		},
		
		getKeyCodeType: function (keyCode) {
			//48 ~ 57
			if (keycode > 47 && keycode < 58) {
				return 'NUM';
			//65 ~ 90
			} else if (keycode > 64 && keycode < 91) {
				return 'ALPHABET_LOWER';
			//96 ~ 105
			} else if (keycode > 95 && keycode < 106) {
				return 'KEYPAD_NUM';
			//112 ~ 123
			} else if (keycode > 111 && keycode < 124) {
				return 'FNKEY';
			}
		},
		
		getKeyDownCode: function (keyCode) {
			return this.keydownKeycode[keyCode];
		},
		
		forceChange: function ($element, $content) {
			$($element).text($content);
			if ($($element).text() == $content) {
				return true;
			}
			
			$($element).html($content);
			if ($($element).html() == $content) {
				return true;
			}
			
			$($element).val($content);
			if ($($element).val() == $content) {
				return true;
			}
			
			return false;
		},
		
		removeAttribute: function (element, attributes) {
			for (var attr in attributes) {
				if (attributes.hasOwnProperty(attr)) {
					continue;
				}
				
				element.removeAttribute(attr, attributes[attr]);
			}
		},
		
		setAttribute: function (element, attributes) {
			for (var attr in attributes) {
				if (!attributes.hasOwnProperty(attr)) {
					continue;
				}
				
				element.setAttribute(attr, attributes[attr]);
			}
		},
		
		/**
		 * Get inner width in document
		 *
		 * @return <Integer>
		 **/
		getInnerWidth: function () {
			if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.clientWidth) {
				return document.documentElement.clientWidth;
			} else if (document.documentElement && document.documentElement.clientWidth) {
				return document.documentElement.clientWidth;
			} else if (document.body && document.body.clientWidth) {
				return document.body.clientWidth;
			} else if (typeof (_cWin.innerWidth) != "undefined") {
				$.core.Base.resetWinCache();
				return _cWin.innerWidth;
			} else {
				return screen.width;
			}
		},
		
		/**
		 * Get inner height in document
		 *
		 * @return <Integer>
		 **/
		getInnerHeight: function () {
			if (document.documentElement && document.documentElement.clientHeight) {
				return document.documentElement.clientHeight;
			} else if (document.body && document.body.clientHeight) {
				return document.body.clientHeight;
			} else if (typeof (_cWin.innerHeight) != "undefined") {
				$.core.Base.resetWinCache();
				return _cWin.innerHeight;
			} else {
				return screen.height;
			}
		},
		
		getScrollTop: function () {
			if (typeof (_cWin.pageYOffset) != "undefined") {
				$.core.Base.resetWinCache();
				return _cWin.pageYOffset;
			} else if (document.documentElement) {
				return document.documentElement.scrollTop;
			} else if (document.body) {
				return document.body.scrollTop;
			}
		},
		
		getScrollLeft: function () {
			if (document.documentElement) {
				return document.documentElement.scrollLeft;
			} else if (document.body) {
				return document.body.scrollLeft;
			}
		},
		
		getWidth: function (element) {
			if ($.core.Validate.isObject(element)) {
				return $(element).width();
			} else {
				return 0;
			}
		},
		
		getHeight: function (element) {
			if ($.core.Validate.isObject(element)) {
				return $(element).height();
			} else {
				return 0;
			}
		},
		
		getOffset: function (element) {
			var o;
			
			var offset = {
				"left": element.offsetLeft,
				"top": element.offsetTop
			};
			
			while (o = element.offsetParent) {
				offset.left += o.offsetLeft;
				offset.top += o.offsetTop;
			}
			
			return offset;
		},
		
		getImgPosition: function (element) {
			var _elem = element || document;
			
			if (!_elem) {
				return {
					"realOffset": 0,
					"correctOffset": 0
				};
			}
			
			var offset = this.getOffset(_elem);
			var real = parseInt(offset.top, 10);
			var currect = parseInt(real - defScreenHeight * 0.1);
			
			return {
				"realOffset": real,
				"correctOffset": currect
			};
		},
		
		getLeft: function (element) {
			var _elem = element || document;
			
			return $(_elem).offset().left;
		},
		
		getTop: function (element) {
			var _elem = element || document;
			
			return $(_elem).offset().top;
		},
		
		getByTag: function (tag, element) {
			var dom = element || document;
			
			if (typeof (tag) != 'string') {
				return tag;
			}
			
			var elem = null;
			
			try {
				elem = dom.getElementsByTagName(id);
			} catch (e) {
				console.log(e);
			}
			
			return elem;
		},
		
		getByName: function (id, element) {
			var dom = element || document;
			
			if (typeof (id) != 'string') {
				return id;
			}
			
			var elem = null;
			
			try {
				elem = dom.getElementsByName(id);
			} catch (e) {
				console.log(e);
			}
			
			return elem;
		},
		
		getById: function (id, elem) {
			var _elem = elem || document;
			
			if (typeof (id) != 'string') {
				return null;
			}
			
			var elem = null;
			
			try {
				elem = _elem.getElementById(id);
			} catch (e) {
				console.log(e);
			}
			
			return elem;
		},
		
		getinnerHTML: function (element) {
			var elem = element || document;
			
			return elem.innerHTML;
		},
		
		getByClass: function (elem, tagName, className) {
			var cls = this.getByClasses(tagName);
			this.length = cls.length;
			
			for (var i = 0; i < this.length; i++) {
				if ((new RegExp(className)).test(cls[i].className)) {
					return cls[i];
				}
			}
			
			return null;
		},
		
		getByClasses: function (cls, elem) {
			var elem = elem || document;
			return elem.getElementsByClassName(cls);
		},
		
		getClassCount: function (cls) {
			return this.getByClasses(cls).length;
		},
		
		setAllInnerHTMLbyClass: function (cls, html) {
			var _target = this.getByClasses(cls);
			var _length = this.getClassCount(cls);
			
			for (var i = 0; i < _length; i++) {
				_target[i].innerHTML = html;
			}
		},
		
		setIframeToggleMute: function (id) {
			var browser = document.querySelector(id);
			var request = browser.getMuted();
			
			request.onsuccess = function () {
				if (request.result) {
					browser.unmute();
				} else {
					browser.mute();
				}
			}
		},
		
		setinnerHTML: function (element, html) {
			element.innerHTML = html;
		},
		
		isSelectedType: function (type) {
			if ($(this.getSelected()).is(type)) {
				return true;
			}
			
			return false;
		},
		
		getSelected: function () {
			return document.activeElement;
		},
		
		createEvent: function (event) {
			var cEvent;
			if (document.createEvent != null) {
				cEvent = document.createEvent(event);
			} else if (document.createEventObject != null) {
				cEvent = document.createEventObject(event);
			}
			
			return cEvent;
		},
		
		create: function (element) {
			return document.createElement(element);
		},
		
		createSVGNS: function (tags) {
			return document.createElementNS(SVG_NS, tags);
		},
		
		createNS: function (attribute, tags) {
			if (attribute) {
				if (tags) {
					return document.createElementNS(attribute, tags);
				} else {
					return document.createElementNS(attribute);
				}
			}
			
			return document.createElementNS || document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;
		},
		
		createFragment: function (element) {
			return document.createDocumentFragment();
		},
		
		setStyles: function (element, props) {
			var props = props || {};
			
			for (var prop in props) {
				element.style[prop] = props[prop];
			}
		}
		
	}
	
	A.constructor();
	
})(jQuery, $.core);