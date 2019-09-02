//Mouse-related functions
'use strict';

(function ($, core) {

	var A = core.Mouse = {
		
		hasTouchscreen: function () {
			var result = false;
			
			if (window.PointerEvent && ('maxTouchPoints' in navigator)) {
				if (navigator.maxTouchPoints > 0) {
					result = true;
				}
			} else {
				if (window.matchMedia && window.matchMedia("(any-pointer:coarse)").matches) {
					result = true;
				} else if (window.TouchEvent || ('ontouchstart' in window)) {
					result = true;
				}
			}
			
			return result;
		},
		
		getEventType: function () {
			var type = ('ontouchstart' in window ? 'touchend' : 'click');
			
			return type;
		},
		
		getEventPosition: function (e) {
			var pos = [];
			
			pos.type = e.type;
			if ((e.changedTouches) && (e.changedTouches.length > 0)) {
				pos.position = e.changedTouches;
			} else if (e.clientX && e.clientY) {
				pos.position = e;
			}
			
			return pos;
		},
		
		moveFakeCursor: function (X, Y, completeCallback, onChangeCallback) {
			var moveInterval = setInterval(function () {
				
				if (typeof onChangeCallback == 'function') {
					onChangeCallback();
				}
				
				var left = $(".cursor_help").css("left").replace("px","");
				
				if (left != parseInt(X)) {
					if ($(".cursor_help").css("left").replace("px","") > X) {
						$(".cursor_help").css("left", parseInt(left) - 1);
					} else {
						$(".cursor_help").css("left", parseInt(left) + 1);
					}
				}
				
				var top = $(".cursor_help").css("top").replace("px","");
				
				if (top != parseInt(Y)) {
					if ($(".cursor_help").css("top").replace("px","") > Y) {
						$(".cursor_help").css("top", parseInt(top) - 1);
					} else {
						$(".cursor_help").css("top", parseInt(top) + 1);
					}
				}
				
				if (left == parseInt(X) && top == parseInt(Y)) {
					if (typeof completeCallback == 'function') {
						completeCallback();
					}
					
					clearInterval(moveInterval);
				}
			},
		 0.2);
		},
		
		exitPointerLock: function () {
			document.exitPointerLock = document.exitPointerLock || document.mozExitPointerLock;

			document.exitPointerLock();
		},
		
		setPointerLockErrorEventListener: function (callback) {
			if ("pointerlockerror" in document) {
				document.addEventListener('pointerlockerror', callback, false);
			} else if ("mozpointerlockerror" in document) {
				document.addEventListener('mozpointerlockerror', callback, false);
			}
		},
		
		setPointerLockChangeEventListener: function (callback) {
			if ("onpointerlockchange" in document) {
				document.addEventListener('pointerlockchange', callback, false);
			} else if ("onmozpointerlockchange" in document) {
				document.addEventListener('mozpointerlockchange', callback, false);
			}
		},
		
		isLocked: function (id) {
			var canvas = document.getElementById(id);
			if(document.pointerLockElement === canvas || document.mozPointerLockElement === canvas) {
				return true;
			} else {
				return false;
			}
		},
		
		requestPointerLock: function (id) {
			var canvas = document.getElementById(id);
			canvas.requestPointerLock = canvas.requestPointerLock || canvas.mozRequestPointerLock;
			canvas.requestPointerLock();
		}
		
	}
	
})(jQuery, $.core);