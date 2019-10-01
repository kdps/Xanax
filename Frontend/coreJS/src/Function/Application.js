//Application-related functions
'use strict';

(function ($, core) {

	var A = core.App = {
		
		each: function(Array, args, callback) {
			if (Array) {
				if (Array instanceof Array) {
					for (let i = 0, length = Array.length; i < length && !1 !== args.call(callback, Array[i], i); i++);
				} else {
					for (let i in Array) {
						if (!1 === args.call(callback, Array[i], i)) {
							break;
						}
					}
				}
			}
		},
		
		extend: function(a) {
			let b = 2 <= arguments.length ? Array.prototype.slice.call(arguments, 1) : [];
			
			this.each(b, function(b) {
				for (let d in b) b.hasOwnProperty(d) && (a[d] = b[d])
			});
		
			return a;
		},
		
		registry: function (App) {
			appRegister.push(App);
		},
		
		fnCombine: function () {
			let fn = [];
			let vmem = [];
			let func = [];
			let prop = null;
			let _name = null;
			let args = arguments;
			if (typeof args[0] === undefined) {
				return null;
			}
			
			for (prop in args[0]) {
				fn[prop] = args[0][prop];
				vmem = new fn[prop](true);
				let _prop = null;
				
				if (vmem.PROP) {
					_prop = vmem.PROP;
					let _name = _prop.name;
				}
				
				_prop = _name ? _name : prop;
				if (typeof func[_prop] === 'undefined') {
					if (vmem._name) {
						delete vmem._name;
					}
					func[_prop] = vmem;
				}
			}
			
			return func;
		}
		
	};
	
})(jQuery, $.core);