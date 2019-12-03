//Stack-related functions
'use strict';

(function ($, core) {

	var A = core.Stack = {
		initialize: function (canvasID) {
			return new Canvas2D(canvasID);
		}
	};
	
})(jQuery, $.core);