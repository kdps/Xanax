//WebDB-related functions
(function ($, core) {

	var A = core.WebDB = {
		
		constructor: function () {
			this.HandlerWebDb = null;
			this.HandlerWebDbQuery = null;
			this.HandlerWebDbExec = null;
		},
		
		isSupport: function () {
			if (_cWin.openDatabase) {
				return true;
			}
			
			return false;
		},
		
		getIndexedDB: function () {
			return _cWin.indexedDB || _cWin.mozIndexedDB || _cWin.webkitIndexedDB || _cWin.msIndexedDB;
		},
		
		getIDBTransaction: function () {
			return _cWin.IDBTransaction || _cWin.webkitIDBTransaction || _cWin.msIDBTransaction;
		},
		
		getIDBKeyRange: function () {
			return _cWin.IDBKeyRange || _cWin.webkitIDBKeyRange || _cWin.msIDBKeyRange;
		},
		
		Open: function (db, version, exp, size) {
			if (this.isSupport()) {
				if ($.core.Validate.isUndefined(size)) {
					size = 1024 * 1024;
				}
				
				if ($.core.Validate.isUndefined(version)) {
					version = "1,0";
				}
				
				this.HandlerWebDb = _cWin.openDatabase(db, version, exp, size);
			}
		},
		
		executeUpdate: function () {
			if (this.isSupport()) {
				this.HandlerWebDb.transaction(function (tex) {
					this.HandlerWebDbExec.executeSql(this.HandlerWebDbQuery);
				});
			}
		},
		
		executeQuery: function () {
			if (this.isSupport()) {
				this.HandlerWebDb.transaction(function (tex) {
					this.HandlerWebDbExec = tex;
					tex.executeSql(this.HandlerWebDbQuery, [], function (tx, results) {
						return results;
					},
		 function (tx, error) {
						console.log(error);
					});
				});
			}
		},
		
		SetQuery: function (query) {
			if (this.isSupport()) {
				this.HandlerWebDbQuery = query;
			}
		},
		
		GetQuery: function (query) {
			if (this.isSupport()) {
				return this.HandlerWebDbQuery;
			}
		}
		
	};
	
	A.constructor();
	
})(jQuery, $.core);