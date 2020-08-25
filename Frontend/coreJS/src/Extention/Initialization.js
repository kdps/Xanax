// Create a Component

(function ($) {
	var core = core || function (element) {
		this.element = $(element);
	};
	
	// The current version of Core Javascript
	core.version = '1.0';
	
	$.core = {};
	$.fn.core = $.fn.core || function () {
		$.extend(this, $.fn.core);
		
		return this;
	};
})(jQuery);
