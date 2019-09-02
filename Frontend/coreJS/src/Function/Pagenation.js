//Pagenation-related functions
'use strict';

(function ($, core) {

	let A = core.Pagenation = {
		
		constructor: function () {
			this.point = 0;
			this.list_count = 0;
			this.last_page = 0;
			this.page_margin = 0;
			this.first_page = 0;
			this.page_count = 0;
		},
		
		setObject: function (current_page = 1, list_count = 10, document_count = 10) {
			this.list_count = list_count;
			
			var page_margin = 0;
			var first_page = 0;
			var last_page = Math.ceil(document_count / list_count);
			var half_page_count = Math.ceil(list_count / 2);
			
			last_page = (last_page < 0) ? 1 : last_page;
			
			if (last_page > list_count) {
				if (current_page > last_page - (list_count - 1)) {
					page_margin = last_page - list_count;
					first_page = page_margin < list_count ? 0 : -1;
				} else if (current_page > half_page_count) {
					page_margin = current_page - (half_page_count);
					first_page = page_margin > list_count ? 0 : -1;
				}
				
				if (current_page > last_page - (list_count - 1) && current_page < last_page - (half_page_count - 1)) {
					page_margin = current_page - half_page_count;
					first_page = page_margin > list_count ? 0 : -1;
				}
			}
			
			this.page_margin = page_margin;
			this.last_page = last_page;
			this.first_page = first_page;
			this.page_count = last_page;
			this.list_count = list_count;
		},
		
		getLastPage: function () {
			return page_count;
		},
		
		getCurrentPage: function () {
			return (this.page_margin + this.first_page + this.point);
		},
		
		hasNextPage: function () {
			var page = this.first_page + ++this.point;
			if (page > this.list_count || this.getCurrentPage() > this.last_page) {
				this.point = 0;
				
				return false;
			} else {
				return true;
			}
		}
	};
	
	A.constructor();
	
})(jQuery, $.core);