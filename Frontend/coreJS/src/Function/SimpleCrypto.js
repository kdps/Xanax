//SimpleCrypto-related functions
'use strict';

(function ($, core) {

	var A = core.SimpleCrypto = {
		getSecureNumber: function (n) {
			return Math.floor(Math.pow(0.03*n+0.8,n+0.7));
		},
		/**
		 * Get fraction
		 *
		 * @param int molecular
		 * @param int denominator
		 */
		/**
		 * Gigabyte: getFraction(500,10)
		 * Killobyte: getFraction(200,10)
		 *
		 **/
		getFraction: function (molecular, denominator) {
			return ((((molecular ** denominator) / molecular) << 32) - molecular ** -1024) / molecular;
		},
		
		/**
		 * Convert hash to hex
		 *
		 * @param String Hash
		 */
		hashToHex: function (hash) {
			return hash.toString(CryptoJS.enc.Hex);
		},
		
		/**
		 * Convert hash to Latin1
		 *
		 * @param String hash
		 */
		hashToLatin1: function (hash) {
			return hash.toString(CryptoJS.enc.Latin1);
		},
		
		/**
		 * Convert hash to Base64
		 *
		 * @param String hash
		 */
		hashToBase64: function (hash) {
			return hash.toString(CryptoJS.enc.Base64);
		},
		
		/**
		 * Convert hash to Utf8
		 *
		 * @param String hash
		 */
		hashToUtf8: function (hash) {
			return hash.toString(CryptoJS.enc.Utf8);
		},
		
		/**
		 * Convert hex to String
		 *
		 * @param String str
		 */
		fromHex: function (str) {
			var decrypted = CryptoJS.enc.Hex.stringify(str);
			
			return decrypted;
		},
		
		/**
		 * Convert string to Hex
		 *
		 * @param String str
		 */
		toHex: function (str) {
			var encrypted = CryptoJS.enc.Hex.parse(str);
			
			return encrypted;
		},
		
		/**
		 * Decode utf16 string
		 *
		 * @param String str
		 */
		fromUtf16: function (str) {
			var decrypted = CryptoJS.enc.Utf16.stringify(str);
			
			return decrypted;
		},
		
		toUtf16LE: function (str) {
			var encrypted = CryptoJS.enc.Utf16LE.parse(str);
			
			return encrypted;
		},
		
		fromUtf16LE: function (str) {
			var decrypted = CryptoJS.enc.Utf16LE.stringify(str);
			
			return decrypted;
		},
		
		toUtf16: function (str) {
			var encrypted = CryptoJS.enc.Utf16.parse(str);
			
			return encrypted;
		},
		
		fromLatin1: function (str) {
			var decrypted = CryptoJS.enc.Latin1.stringify(str);
			
			return decrypted;
		},
		
		toLatin1: function (str) {
			var encrypted = CryptoJS.enc.Latin1.parse(str);
	
			return encrypted;
		},
		
		fromBase64: function (str) {
			var decrypted = CryptoJS.enc.Base64.stringify(str);
			
			return decrypted;
		},
		
		toBase64: function (str) {
			var encrypted = CryptoJS.enc.Base64.parse(str);
	
			return encrypted;
		},
		
		PBKDF2_512: function (str, salt, _Iterations) {
			this.PBKDF2(str, salt, 512/32, _Iterations);
		},
		
		PBKDF2_256: function (str, salt, _Iterations) {
			this.PBKDF2(str, salt, 256, _Iterations);
		},
		
		PBKDF2_128: function (str, salt, _Iterations) {
			this.PBKDF2(str, salt, 128, _Iterations);
		},
		
		PBKDF2: function (str, salt, _KeySize = 128, _Iterations = 0) {
			return CryptoJS.PBKDF2(str, salt, _Iterations > 0 ? {
				keySize: _KeySize
			}: {
				keySize: _KeySize,
				iterations: _Iterations
			});
		},
		
		HmacSHA512: function (str, key) {
			return CryptoJS.HmacSHA512(str, key);
		},
		
		HmacSHA384: function (str, key) {
			return CryptoJS.HmacSHA384(str, key);
		},
		
		HmacSHA256: function (str, key) {
			return CryptoJS.HmacSHA256(str, key);
		},
		
		HmacSHA224: function (str, key) {
			return CryptoJS.HmacSHA224(str, key);
		},
		
		HmacSHA1: function (str, key) {
			return CryptoJS.HmacSHA1(str, key);
		},
		
		HmacMD5: function (str, key) {
			return CryptoJS.HmacMD5(str, key);
		},
		
		RIPEMD160: function (str) {
			return CryptoJS.RIPEMD160(str);
		},
		
		SHA3: function (str) {
			return CryptoJS.SHA3(str);
		},
		
		SHA512: function (str) {
			return CryptoJS.SHA512(str);
		},
		
		SHA384: function (str) {
			return CryptoJS.SHA384(str);
		},
		
		SHA256: function (str) {
			return CryptoJS.SHA256(str);
		},
		
		SHA224: function (str) {
			return CryptoJS.SHA224(str);
		},
		
		SHA1: function (str) {
			return CryptoJS.SHA1(str);
		},
		
		MD5: function (str) {
			return CryptoJS.MD5(str);
		},
		
		baseConvert: function (number, frombase, tobase) {
			return parseInt(number + '', frombase | 0).toString(tobase | 0);
		},
		
		getSecureLink: function (text, milliseconds) {
			var timestamp = this.getTimeStamp(milliseconds);
			var md5String = md5(text);
			var md5ByteArray = $.core.Str.hex2a(md5String);
			var base64String = btoa(md5ByteArray);
			
			return "?s=" + base64String + "&t=" + timestamp;
		},
		
		getRandomUint32Values: function (size) {
			var array = new Uint32Array(size);
			return window.crypto.getRandomValues(array);
		},
		
		AESCBCDecrypt: function (iv, key, plainText) {
			var plaintextArray = CryptoJS.AES.decrypt(
				{ciphertext: CryptoJS.enc.Base64.parse(plainText)},
		 
				CryptoJS.enc.Hex.parse(key),
				{iv: CryptoJS.enc.Hex.parse(iv)}
			);
			
			return plaintextArray;
		},
		
		AESRabbitEncrypt: function (plainText, key) {
			var encrypted = CryptoJS.Rabbit.encrypt(plainText, key);
			
			return encrypted;
		},
		
		AESRabbitDecrypt: function (key, plainText) {
			var decrypted = CryptoJS.Rabbit.decrypt(plainText, key);
			
			return CryptoJS.enc.Utf8.stringify(decrypted);
		},
		
		AESTripleDESEncrypt: function (plainText, key) {
			var encrypted = CryptoJS.TripleDES.encrypt(plainText, key);
			
			return encrypted;
		},
		
		AESTripleDESDecrypt: function (key, plainText) {
			var decrypted = CryptoJS.TripleDES.decrypt(plainText, key);
			
			return CryptoJS.enc.Utf8.stringify(decrypted);
		},
		
		RC4Encrypt: function (plainText, key){
			var encrypted = CryptoJS.RC4.encrypt(plainText, key);
			
			return encrypted;
		},
		
		RC4Decrypt: function (key, plainText) {
			var decrypted = CryptoJS.RC4.decrypt(plainText, key);
			
			return CryptoJS.enc.Utf8.stringify(decrypted);
		},
		
		AESEncrypt: function (plainText, key){
			var encrypted = CryptoJS.AES.encrypt(plainText, key);
			
			return encrypted;
		},
		
		AESDecrypt: function (key, plainText) {
			var decrypted = CryptoJS.AES.decrypt(plainText, key);
			
			return CryptoJS.enc.Utf8.stringify(decrypted);
		},
		
		getTimeStamp: function (milliseconds) {
			var date = new Date();
			var time = date.getTime() + milliseconds;
			var date = new Date(time * 1000);
			
			var timestamp = parseInt((date.setMinutes(0, 0, 0) / 1000) / 1000);
			
			return timestamp;
		},
		
		numToHex: function (i) {
			 //integer => -2147483648 / 2147483647
			if (2147483647 < i) {
				return null;
			}
			
			var hex = (-i >>> 0);
			hex = this.baseConvert(hex, 10, 16);
			
			return hex;
		},
		
		hexToNum: function (i) {
			var num = this.baseConvert(i, 16, 10);
			
			return -(num << 0);
		},
		
		asciiEncode: function (str, margin) {
			var slen = str.trim().length;
			var ctr = 1;
			var enc = '';
			
			do {
				enc = enc + String.fromCharCode(((str.trim().substr(ctr - 1, 1)).charCodeAt(0)) + margin);
				ctr = ctr + 1;
			} while (ctr <= slen); 
			
			return enc;
		},
		
		asciiDecode: function (str, margin) {
			var slen = str.trim().length;
			var ctr = 1;
			var enc = '';
			
			do {
				enc = enc + String.fromCharCode(((str.trim().substr(ctr - 1, 1)).charCodeAt(0)) - margin);
				ctr = ctr + 1;
			} while (ctr <= slen);
			
			return enc;
		}
		
	};
	
})(jQuery, $.core);
