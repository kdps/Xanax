//Define a global variables
const 

	html5Elements = ['source', 'track', 'audio', 'video'],
    
	dataType = "Boolean_Number_String_Function_Array_Date_RegExp_Object_Error".split("_"),
    
	revEvent = {
        'mouseenter': "mouseover", 'mouseleave': "mouseout", 'pointerenter': "pointerover", 'pointerleave': "pointerout"
    },
    
	domType = [
        "", "Webkit", "Moz", "ms", "O"
    ],
    
	doctype = document.doctype || {},
	
    numberList = '0123456789',

    upperAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',

    lowerAlphabet = 'abcdefghijklmnopqrstuvwxyz',

    xmlHeader = '<?xml version="1.0" encoding="utf-8"?>',

    machinePlatform = {
        "web": "Website", "win": "Windows", "dos": "DOS", "lin": "Linux", "mac": "Mac OS", "ios": "Apple iProduct", "and": "Android", "dvd": "DVD Player", "bdp": "Blu-ray Player", "fmt": "FM Towns", "gba": "Game Boy Advance", "gbc": "Game Boy Color", "msx": "MSX", "nds": "Nintendo DS", "nes": "Famicom", "p88": "PC-88", "p98": "PC-98", "pce": "PC Engine", "pcf": "PC-FX", "psp": "PlayStation Portable", "ps1": "PlayStation 1", "ps2": "PlayStation 2", "ps3": "PlayStation 3", "ps4": "PlayStation 4", "psv": "PlayStation Vita", "drc": "Dreamcast", "sat": "Sega Saturn", "sfc": "Super Nintendo", "wii": "Nintendo Wii", "n3d": "Nintendo 3DS", "x68": "X68000", "xb1": "Xbox", "xb3": "Xbox 360", "xbo": "Xbox One"
    },

    utf8Str = {
        'utf8bom': '\xEF\xBB\xBF', 'non-breaking space': '\x0B\xC2\xA0'
    },

    unicodeString = {
        ' ': '&nbsp;', '\u0009': 'tab', '\u000B': 'left tab', ' ': 'blank'
    },

    asciiEncodeUTF8 = {
        ' ': '%20', '!': '%21', '"': '%22', '#': '%23', '$': '%24', '%': '%25', '&': '%26', "'": '%27', '(': '%28', ')': '%29', '*': '%2A', '+': '%2B', ',': '%2C', '-': '%2D', '.': '%2E', '/': '%2F', '0': '%30', '1': '%31', '2': '%32', '3': '%33', '4': '%34', '5': '%35', '6': '%36', '7': '%37', '8': '%38', '9': '%39', ':': '%3A', ';': '%3B', '<': '%3C', '=': '%3D', '>': '%3C', '?': '%3F', '@': '%40', 'A': '%41', 'B': '%42', 'C': '%43', 'D': '%44', 'E': '%45', 'F': '%46', 'G': '%47', 'H': '%48', 'I': '%49', 'J': '%4A', 'K': '%4B', 'L': '%4C', 'M': '%4D', 'N': '%4E', 'O': '%4F', 'P': '%50', 'Q': '%51', 'R': '%52', 'S': '%53', 'T': '%54', 'U': '%55', 'V': '%56', 'W': '%57', 'X': '%58', 'Y': '%59', 'Z': '%5A', '[': '%5B', '\\': '%5C', ']': '%5D', '^': '%5E', '_': '%5F', '``': '%60', 'a': '%61', 'b': '%62', 'c': '%63', 'd': '%64', 'e': '%65', 'f': '%66', 'g': '%67', 'h': '%68', 'i': '%69', 'j': '%6A', 'k': '%6B', 'l': '%6C', 'm': '%6D', 'n': '%6E', 'o': '%6F', 'p': '%70', 'q': '%71', 'r': '%72', 's': '%73', 't': '%74', 'u': '%75', 'v': '%76', 'w': '%77', 'x': '%78', 'y': '%79', 'z': '%7A', '{': '%7B', '|': '%7C', '}': '%7D', '~': '%7E', '  ': '%7F', '`': '%E2%82%AC', '': '%81', '‚': '%E2%80%9A', 'ƒ': '%C6%92', '„': '%E2%80%9E', '…': '%E2%80%A6', '†': '%E2%80%A0', '‡': '%E2%80%A1', 'ˆ': '%CB%86'
    },

    fileHeaderBytes = {
        'B16': {
            'pos': 0, 'bytes': '50434F2D'
        }, 'BCIF': {
            'pos': 0, 'bytes': '42434946'
        }, 'BFLI': {
            'pos': 0, 'bytes': 'FF3B62'
        }, 'BGA': {
            'pos': 0, 'bytes': '4241'
        }, 'BIF': {
            'pos': 0, 'bytes': '424946'
        }, 'BMP': {
            'pos': 0, 'bytes': '424D'
        }, 'BMPv1': {
            'pos': 14, 'bytes': '424D'
        }, 'BMPv2': {
            'pos': 14, 'bytes': '40000000'
        }, 'BMPv2a': {
            'pos': 14, 'bytes': '34000000'
        }, 'BMPv2o': {
            'pos': 14, 'bytes': '10000000'
        }, 'BMPv3': {
            'pos': 14, 'bytes': '28000000'
        }, 'BMPv3a': {
            'pos': 14, 'bytes': '38000000'
        }, 'BMPv4': {
            'pos': 14, 'bytes': '6C000000'
        }, 'BMPv5': {
            'pos': 14, 'bytes': '7C000000'
        }, 'GIF': {
            'pos': 0, 'bytes': '474946'
        }, 'GIF87a': {
            'pos': 0, 'bytes': '474946383761'
        }, 'GIF89a': {
            'pos': 0, 'bytes': '474946383961'
        }, 'GIFAnimate': {
            'pos': 0, 'bytes': '474946383961'
        }
    },

    numberCValue = {
        0: 0x000000, 1: 0x000001, 2: 0x000002, 3: 0x000003, 4: 0x000004, 5: 0x000005, 6: 0x000006, 7: 0x000007, 8: 0x000008, 9: 0x000009, 10: 0x00000A, 11: 0x00000B, 12: 0x00000C, 13: 0x00000D, 14: 0x00000E, 15: 0x00000F, 16: 0x000010, 17: 0x000011, 18: 0x000012, 127: 0x00007F, 256: 0x100, 2047: 0x0007FF, 65535: 0x00FFFF, 65536: 0x10000, 16777216: 0x1000000
    },

    asciiHex = {
        /* Varicode */
        '': 0x01, '': 0x02, '': 0x03, '': 0x04, '': 0x05, '': 0x06, '': 0x07, '': 0x08, '': 0x0b, '': 0x0c, '': 0x0e, '': 0x0f, '': 0x10, '': 0x11, '': 0x15, '': 0x16, '': 0x17, '': 0x18, '': 0x19, '': 0x0a, '': 0x0b, '': 0x0c, '': 0x1d, '': 0x1e, '': 0x1f, '!': 0x21, '"': 0x22, '#': 0x23, '$': 0x24, '%': 0x25, '&': 0x26, "'": 0x27, '(': 0x28, ')': 0x29, '*': 0x2a, '+': 0x2b, ',': 0x2c, '-': 0x2d, '.': 0x2e, '/': 0x2f, 0: 0x30, 1: 0x31, 2: 0x32, 3: 0x33, 4: 0x34, 5: 0x35, 6: 0x36, 7: 0x37, 8: 0x38, 9: 0x39, ':': 0x3a, ';': 0x3b, '<': 0x3c, '=': 0x3d, '>': 0x3e, '?': 0x3f, '@': 0x40, 'A': 0x41, 'B': 0x42, 'C': 0x43, 'D': 0x44, 'E': 0x45, 'F': 0x46, 'G': 0x47, 'H': 0x48, 'I': 0x49, 'J': 0x4a, 'K': 0x4b, 'L': 0x4c, 'M': 0x4d, 'N': 0x4e, 'O': 0x4f, 'P': 0x50, 'Q': 0x51, 'R': 0x52, 'S': 0x53, 'T': 0x54, 'U': 0x55, 'V': 0x56, 'W': 0x57, 'X': 0x58, 'Y': 0x59, 'Z': 0x5a, '[': 0x5b, '\\': 0x5c, ']': 0x5d, '^': 0x5e, '_': 0x5f, '`': 0x60, 'a': 0x61, 'b': 0x62, 'c': 0x63, 'd': 0x64, 'e': 0x65, 'f': 0x66, 'g': 0x67, 'h': 0x68, 'i': 0x69, 'j': 0x6a, 'k': 0x6b, 'l': 0x6c, 'm': 0x6d, 'n': 0x6e, 'o': 0x6f, 'p': 0x70, 'q': 0x71, 'r': 0x72, 's': 0x73, 't': 0x74, 'u': 0x75, 'v': 0x76, 'w': 0x77, 'x': 0x78, 'y': 0x79, 'z': 0x7a, '{': 0x7b, '': 0x7f, /*SREG &(Atmega128)*/ '€': 0x80, /*SREG |(Atmega128)*/ '': 0x81, '‚': 0x82, 'ƒ': 0x83, '„': 0x84, '…': 0x85, '†': 0x86, '‡': 0x87, 'ˆ': 0x88, '‰': 0x89, 'Š': 0x8a, '‹': 0x8b, 'Œ': 0x8c, '': 0x8d, 'Ž': 0x8e, '': 0x8f, '': 0x90, '‘': 0x91, '’': 0x92, '“': 0x93, '”': 0x94, '•': 0x95, '–': 0x96, '—': 0x97, '˜': 0x98, '™': 0x99, 'š': 0x9a, '›': 0x9b, 'œ': 0x9c, '': 0x9d, 'ž': 0x9e, 'Ÿ': 0x9f, ' ': 0xa0, '¡': 0xa1, '¢': 0xa2, '£': 0xa3, '¤': 0xa4, '¥': 0xa5, '¦': 0xa6, '§': 0xa7, '¨': 0xa8, '©': 0xa9, 'ª': 0xaa, '«': 0xab, '¬': 0xac, '­': 0xad, '®': 0xae, '¯': 0xaf, '°': 0xb0, '±': 0xb1, '²': 0xb2, '³': 0xb3, '´': 0xb4, 'µ': 0xb5, '¶': 0xb6, '·': 0xb7, '¸': 0xb8, '¹': 0xb9, 'º': 0xba, '»': 0xbb, '¼': 0xbc, '½': 0xbd, '¾': 0xbe, '¿': 0xbf, 'À': 0xc0, 'Á': 0xc1, 'Â': 0xc2, 'Ã': 0xc3, 'Ä': 0xc4, 'Å': 0xc5, 'Æ': 0xc6, 'Ç': 0xc7, 'È': 0xc8, 'É': 0xc9, 'Ê': 0xca, 'Ë': 0xcb, 'Ì': 0xcc, 'Í': 0xcd, 'Î': 0xce, 'Ï': 0xcf, 'Ð': 0xd0, 'Ñ': 0xd1, 'Ò': 0xd2, 'Ó': 0xd3, 'Ô': 0xd4, 'Õ': 0xd5, 'Ö': 0xd6, '×': 0xd7, 'Ø': 0xd8, 'Ù': 0xd9, 'Ú': 0xda, 'Û': 0xdb, 'Ü': 0xdc, 'Ý': 0xdd, 'Þ': 0xde, 'ß': 0xdf, 'à': 0xe0, 'á': 0xe1, 'â': 0xe2, 'ã': 0xe3, 'ä': 0xe4, 'å': 0xe5, 'æ': 0xe6, 'ç': 0xe7, 'è': 0xe8, 'é': 0xe9, 'ê': 0xea, 'ë': 0xeb, 'ì': 0xec, 'í': 0xed, 'î': 0xee, 'ï': 0xef, 'ð': 0xf0, 'ñ': 0xf1, 'ò': 0xf2, 'ó': 0xf3, 'ô': 0xf4, 'õ': 0xf5, 'ö': 0xf6, '÷': 0xf7, 'ø': 0xf8, 'ù': 0xf9, 'ú': 0xfa, 'û': 0xfb, 'ü': 0xfc, 'ý': 0xfd, 'þ': 0xfe, 'ÿ': 0xff
    },

    shiftNums = {
        "`": "~", "1": "!", "2": "@", "3": "#", "4": "$", "5": "%", "6": "^", "7": "&", "8": "*", "9": "(", "0": ")", "-": "_", "=": "+", ";": ":", "'": "\"", ",": "<", ".": ">", "/": "?", "\\": "|"
    },

    WinSize = {
		1 : "640x400", 2 : "800x600", 3 : "960x600", 4 : "960x720", 5 : "1024x576", 6 : "1024x600", 7 : "1024x640", 8 : "1024x768", 9 : "1280x720", 10 : "1280x800", 11 : "1280x960", 12 : "1366x768", 13 : "1400x1050", 14 : "1440x1080", 15 : "1600x900", 16 : "1600x1200", 17 : "1856x1392", 18 : "1920x1080", 19 : "1920x1440", 20 : "2048x1080", 21 : "2048x1600", 22 : "2560x1440", 23 : "3840x2160", 24 : "7680x4320"
    },

    allowFileFormat = ["jpg", "jpeg", "gif", "bmp", "png", "jpe", "cur", "svg", "svgz", "tif", "tiff", "ico", "wma", "wav", "mp3", "aac", "ra", "ram", "mp2", "ogg", "aif", "mpega", "amr", "mid", "midi", "m4a", "wmv", "rmvb", "mpeg4", "mpeg2", "flv", "avi", "3gp", "mpga", "qt", "rm", "wmz", "wmd", "wvx", "wmx", "wm", "swf", "mpg", "mp4", "mkv", "mpeg", "mov", "asf", "zip", "rar", "7z", "flac"],

    movieFormat = ["moov", "udta", "mdia", "meta", "ilst", "stbl", "minf", "moof", "traf", "trak", "stsd"],

    fFormat = {
        0: "IMPLICIT", 1: "UTF8", 2: "UTF16", 3: "SJIS", 6: "HTML", 7: "XML", 8: "UUID", 9: "ISRC", 10: "MI3P", 12: "GIF", 13: "JPEG", 14: "PNG", 15: "URL", 16: "DURATION", 17: "DATETIME", 18: "GENRED", 21: "INTEGER", 24: "RIAAPA", 25: "UPC", 27: "BMP", 255: "UNDEFINED"
    },

    cardType = ["visa", "mastercard", "amex", "jcb", "unionpay", "rupay", "discover", "dinersclub"],

    //File Resouce
    unicodeHeader = 0xfeff, //Little endian
    bomStr = '﻿',

    regSubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
    regSubmittable = /^(?:input|select|textarea|keygen)/i;
//from jQuery
booleanAtributes = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
    //regEx Resource
    // http://www.w3.org/TR/css3-selectors/#whitespace
    whitespace = "[\\x20\\t\\r\\n\\f]", // 
    // http://www.w3.org/TR/CSS21/syndata.html#value-def-identifier
    regIdentifier = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
    // Attribute selectors: http://www.w3.org/TR/selectors/#attribute-selectors
    attributes = "\\[" + whitespace + "*(" + regIdentifier + ")(?:" + whitespace +
    // Operator (capture 2)
    "*([*^$|!~]?=)" + whitespace +
    // "Attribute values must be CSS identifiers [capture 5] or strings [capture 3 or capture 4]"
    "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + regIdentifier + "))|)" + whitespace +
    "*\\]",
    pseudos = ":(" + regIdentifier + ")(?:\\((" +
    // To reduce the number of selectors needing tokenize in the preFilter, prefer arguments:
    // 1. quoted (capture 3; capture 4 or capture 5)
    "('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" +
    // 2. simple (capture 6)
    "((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" +
    // 3. anything else (capture 2)
    ".*" +
    ")\\)|)",
    matchExpr = {
        "ID": new RegExp("^#(" + regIdentifier + ")"), "CLASS": new RegExp("^\\.(" + regIdentifier + ")"), "TAG": new RegExp("^(" + regIdentifier + "|[*])"), "ATTR": new RegExp("^" + attributes), "PSEUDO": new RegExp("^" + pseudos), "CHILD": new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace +
            "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace +
            "*(\\d+)|))" + whitespace + "*\\)|)", "i"), "bool": new RegExp("^(?:" + booleanAtributes + ")$", "i"), // For use in libraries implementing .is()
        // We use this for POS matching in `select`
        "needsContext": new RegExp("^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" +
            whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i")
    },
    regInputs = /^(?:input|select|textarea|button)$/i,
    regHeader = /^h\d$/i,
    regNative = /^[^{]+\{\s*\[native \w/,
    regQuickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
    regSibling = /[+~]/,
    regEscape = /'|\\/g,
    regJapanese = /([ぁ-んァ-ヶー一-龠])/,
    regJapan = /^[\p{Katakana}\p{Hiragana}\p{Han}]+$/,
    regKanji = /[一-龠]$/,
    regHiragana = /^([ぁ-ん]+)$/,
    regKatakana = /^([ァ-ヶー]+)$/,
    regHalfKana = /^([ｧ-ﾝﾞﾟ]+)$/,
    regHiraganaKatakana = /^([ァ-ヶーぁ-ん]+)$/,
    regFArrtype = /^\[object (?:Uint8|Uint8Clamped|Uint16|Uint32|Int8|Int16|Int32|Float32|Float64)Array]$/,
    regURLParmas = /([^=&?]+)=([^&#]*)/g,
    regRewriteParams = /^\/(.+)\/([A-Za-z0-9]*)$/,
    regWhiteSpace = /^\s*$/,
    regEmail = /^[^"'@]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/,
    regUrl = /^(http\:\/\/)*[.a-zA-Z0-9-]+\.[a-zA-Z]+$/,
    regWords = /\w+/g,
    regNum = /^[0-9]+$/,
    regAlpha = /^[a-zA-Z]+$/,
    regOnlyKor = /^[\uAC00-\uD7A3]*$/,
    regKor = /[^\uAC00-\uD7AF\u1100-\u11FF\u3130-\u318F]/,
    regPerfectKor = /[\uAC00-\uD7A3]/,
    regKorEng = /[\uAC00-\uD7A3a-zA-Z]/,
    regRRN = /^\d{6}[1234]\d{6}$/, //Jumin
    regId = /#([\w\-]+)/,
    regIds = /^#([\w\-]+)$/,
    regClasss = /^\.([\w\-]+)$/,
    regcanvas = /canvas/i,
    regimg = /img/i,
    reginput = /input/i,
    regdata = /^data:[^,]+,/,
    monthHanja = "日_月_火_水_木_金_土".split("_"),
    months = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
    monthsShort = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
    dayOfWeek = 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split("_"),
    dayOfWeekShort = 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split("_"),
    elOptions = booleanAtributes.split("|"),

    //System language
    initLang = (function() {
        _cWin.lang = [];
        (globalLang == 'ko') ? (
            _cWin.lang['favorite'] = ' + D를 누르시면 즐겨찾기가 등록됩니다',     _cWin.lang['request'] = '서버에 요청중입니다',     _cWin.lang['uncaught'] = '잡히지 않는',     _cWin.lang['property'] = '정의하지 않은 객체의',     _cWin.lang['undefined'] = '가 정의되지 않았습니다.',     _cWin.lang['isnotfunc'] = '는 함수가 아닙니다.',     _cWin.lang['cannotreadproperty'] = '속성을 읽을 수 없습니다.',     _cWin.lang['typeerror'] = ' 타입에러 : ',     _cWin.lang['referror'] = ' 레퍼런스에러 : ',     _cWin.lang['notonline'] = '인터넷이 연결되어 있지 않습니다.'
        ) :
        (globalLang == 'jp') ? (
            _cWin.lang['favorite'] = '+ Dを押すとお気に入り登録されます。',     _cWin.lang['request'] = 'サーバーに要請中です',     _cWin.lang['uncaught'] = '捕まらない',     _cWin.lang['property'] = '正義しない客体の',     _cWin.lang['undefined'] = 'は定義されませんでした。',     _cWin.lang['isnotfunc'] = '関数が存在しません。',     _cWin.lang['cannotreadproperty'] = '俗性が読めません。',     _cWin.lang['typeerror'] = ' タイプエラー : ',     _cWin.lang['referror'] = ' レファレンスエラー : ',     _cWin.lang['notonline'] = 'インターネットがつながっていません。'
        ) : false;
    }),

	unicodeCharList = {
		
		/* CJK symbols and punctuation */
		
		"u3000" : {
			"name" : "IDEOGRAPHIC SPACE", "char" : ""
		}, "u3001" : {
			"name" : "IDEOGRAPHIC COMMA", "char" : "、"
		}, "u3002" : {
			"name" : "IDEOGRAPHIC FULL STOP", "char" : "。"
		}, "u3003" : {
			"name" : "DITTO MARK", "char" : "〃"
		}, "u3004" : {
			"name" : "JAPANESE INDUSTRIAL STANDARD SYMBOL", "char" : "〄"
		}, "u3005" : {
			"name" : "IDEOGRAPHIC ITERATION MARK", "char" : "々"
		}, "u3006" : {
			"name" : "IDEOGRAPHIC CLOSING MARK", "char" : "〆"
		}, "u3007" : {
			"name" : "IDEOGRAPHIC NUMBER ZERO", "char" : "〇"
		}, 
		/* CJK angle brackets */
		
		"u3008" : {
			"name" : "LEFT ANGLE BRACKET", "char" : "〈"
		}, "u3009" : {
			"name" : "RIGHT ANGLE BRACKET", "char" : "〉"
		}, "u300A" : {
			"name" : "LEFT DOUBLE ANGLE BRACKET", "char" : "《"
		}, "u300B" : {
			"name" : "RIGHT DOUBLE ANGLE BRACKET", "char" : "》"
		}, 
		/* CJK corner brackets */
		
		"300C" : {
			"name" : "LEFT CORNER BRACKET", "char" : "「"
		}, "300D" : {
			"name" : "RIGHT CORNER BRACKET", "char" : "」"
		}, "300E" : {
			"name" : "LEFT WHITE CORNER BRACKET", "char" : "『"
		}, "300F" : {
			"name" : "RIGHT WHITE CORNER BRACKET", "char" : "』"
		}, 
		/* CJK brackets */
		
		"3010" : {
			"name" : "LEFT BLACK LENTICULAR BRACKET", "char" : "【"
		}, "3011" : {
			"name" : "RIGHT BLACK LENTICULAR BRACKET", "char" : "】"
		}, 
		/* CJK symbols */
		
		"3012" : {
			"name" : "POSTAL MARK", "char" : "〒"
		}, "3013" : {
			"name" : "POSTAL MARK", "char" : "〓"
		}, 
		/* CJK brackets */
		
		"3014" : {
			"name" : "LEFT TORTOISE SHELL BRACKET", "char" : "〔"
		}, "3015" : {
			"name" : "RIGHT TORTOISE SHELL BRACKET", "char" : "〕"
		}, "3016" : {
			"name" : "LEFT WHITE LENTICULAR BRACKET", "char" : "〖"
		}, "3017" : {
			"name" : "RIGHT WHITE LENTICULAR BRACKET", "char" : "〗"
		}, "3018" : {
			"name" : "LEFT WHITE TORTOISE SHELL BRACKET", "char" : "〘"
		}, "3019" : {
			"name" : "RIGHT WHITE TORTOISE SHELL BRACKET", "char" : "〙"
		}, "301A" : {
			"name" : "LEFT WHITE SQUARE BRACKET", "char" : "〚"
		}, "301B" : {
			"name" : "RIGHT WHITE SQUARE BRACKET", "char" : "〛"
		}, 
		/* CJK punctuation */
		
		"301C" : {
			"name" : "WAVE DASH", "char" : "〜"
		}, "301D" : {
			"name" : "REVERSED DOUBLE PRIME QUOTATION MARK", "char" : "〝"
		}, "301E" : {
			"name" : "DOUBLE PRIME QUOTATION MARK", "char" : "〞"
		}, "301F" : {
			"name" : "LOW DOUBLE PRIME QUOTATION MARK", "char" : "〟"
		}, 
		/* CJK symbol */
		
		"3020" : {
			"name" : "POSTAL MARK FACE", "char" : "〠"
		}, 
		/* Suzhou numerals */
		
		"3021" : {
			"name" : "HANGZHOU NUMERAL ONE", "char" : "〡"
		}, "3022" : {
			"name" : "HANGZHOU NUMERAL TWO", "char" : "〢"
		}, "3023" : {
			"name" : "HANGZHOU NUMERAL THREE", "char" : "〣"
		}, "3024" : {
			"name" : "HANGZHOU NUMERAL FOUR", "char" : "〤"
		}, "3025" : {
			"name" : "HANGZHOU NUMERAL FIVE", "char" : "〥"
		}, "3026" : {
			"name" : "HANGZHOU NUMERAL SIX", "char" : "〦"
		}, "3027" : {
			"name" : "HANGZHOU NUMERAL SEVEN", "char" : "〧"
		}, "3028" : {
			"name" : "HANGZHOU NUMERAL EIGHT", "char" : "〨"
		}, "3029" : {
			"name" : "HANGZHOU NUMERAL NINE", "char" : "〩"
		}, 
		/* Combining tone marks */
		
		"302A" : {
			"name" : "IDEOGRAPHIC LEVEL TONE MARK", "char" : "$〪"
		}, "302B" : {
			"name" : "IDEOGRAPHIC RISING TONE MARK", "char" : "$〫"
		}, "302C" : {
			"name" : "IDEOGRAPHIC DEPARTING TONE MARK", "char" : "$〫"
		}, "302D" : {
			"name" : "IDEOGRAPHIC ENTERING TONE MARK", "char" : "$〭"
		}, "302E" : {
			"name" : "HANGUL SINGLE DOT TONE MARK", "char" : "$〮"
		}, "302F" : {
			"name" : "HANGUL DOUBLE DOT TONE MARK", "char" : "$〯"
		}, 
		/* Other CJK punctuation */
		
		"3030" : {
			"name" : "WAVY DASH", "char" : "〰"
		}, 
		/* Kana repeat marks */
		
		"3031" : {
			"name" : "VERTICAL KANA REPEAT MARK", "char" : "〱"
		}, "3032" : {
			"name" : "VERTICAL KANA REPEAT WITH VOICED SOUND MARK", "char" : "〲"
		}, "3033" : {
			"name" : "VERTICAL KANA REPEAT MARK UPPER HALF", "char" : "〳"
		}, "3034" : {
			"name" : "VERTICAL KANA REPEAT WITH VOICED SOUND MARK UPPER HALF", "char" : "〴"
		}, "3035" : {
			"name" : "VERTICAL KANA REPEAT MARK LOWER HALF", "char" : "〵"
		}, 
		/* Other CJK symbols */
		
		"3036" : {
			"name" : "CIRCLED POSTAL MARK", "char" : "〶"
		}, "3037" : {
			"name" : "IDEOGRAPHIC TELEGRAPH LINE FEED SEPARATOR SYMBOL", "char" : "〷"
		}, 
		/* Additional Suzhou numerals */
		
		"3038" : {
			"name" : "HANGZHOU NUMERAL TEN", "char" : "〸"
		}, "3039" : {
			"name" : "HANGZHOU NUMERAL TWENTY", "char" : "〹"
		}, "303A" : {
			"name" : "HANGZHOU NUMERAL THIRTY", "char" : "〺"
		}, 
		/* Other CJK punctuation */
		
		"303B" : {
			"name" : "VERTICAL IDEOGRAPHIC ITERATION MARK", "char" : "〻"
		}, "303C" : {
			"name" : "MASU MARK", "char" : "〼"
		}, "303D" : {
			"name" : "PART ALTERNATION MARK", "char" : "〽"
		}, "303E" : {
			"name" : "IDEOGRAPHIC VARIATION INDICATOR", "char" : ""
		}, 
		//"NO-BREAK SPACE" : "u00A0" //
	}
		
Object.seal(asciiHex);
Object.seal(unicodeCharList);

var root = this,
    waitformSkin = "default",
    IteratorsTemp = '',
    $body = $body || $('body'),
    $window = $window || $('window'),
    $document = $document || $('document'),
    $q = $q || $,
    secure_opt = false,
    hexChar = '0123456789ABCDEF',
    EOF = "/* EOF */",
    _root = {}, //sth
    $cache = {}, //cache
    jqueryExist = true,

    //Configure
    debug = false,
    messangerType = 'messanger',
    uniquenum = 0,
    waitTimeout = 150,
    gamePadValue = 0.5,

    rewriteRegister = {},

    //Gamepad
    gamePadControllers = {},
    gamePadDynamicKeys = {},

    //init
    $trigDeprecated = {},
    pressedGamePadPressedIndex = null,
    indexedDBStorage = null,
    HandlerWebSocket = null,
    waitForm = null,
    onRequestProcessing = false,

    deferred = $q.defer,
    n4 = (document.layers) ? true : false,
    e4 = (document.all) ? true : false,

    resourcePreloader = [],

    //Scripter
    StopLabel = null,
    VarNames = null,

    //Prototype
    protoArr = Array.prototype,
    protoObj = Object.prototype,
    toString = protoObj.toString,
    hasOwnProperty = protoObj.hasOwnProperty,
    nativeIsArr = Array.isArray,
    nativeKeys = Object.keys,

    requireJS = [],
    requireCSS = [],
    //Callback
    customCallbacks = {},
    //onclick Handler
    onclickCallbacksType = {},
    onclickCallbacksClass = {},
    onclickCallbacksID = {},
    defaults = {
        "none_function": $.noop
    }, //=> Resource

    //Browser
    _cDoc = document, //navi cache(must renewal if set)
    _cNavi = navigator, //navi cache(must renewal if set)
    _cWin = window, //win cache(must renewal if set)
    _cUserAgent = _cNavi.userAgent,
    _cBlob = _cWin.Blob,
    _cFile = _cWin.File,
    _cFileReader = _cWin.FileReader,
    _cFormData = _cWin.FormData,
    _cXMLHttpRequest = _cWin.XMLHttpRequest,
    _cdataURLtoBlob = _cWin.dataURLtoBlob,
    _cMath = _cWin.Math,
    _cjQuery = _cWin.jQuery,

    //Internet Explorer
    isIE7 = /*@cc_on!@*/ false && (!document.documentMode || document.documentMode === 7),
    isIE = /*@cc_on!@*/ false && document.documentMode <= 8,

    //Ajax callback
    appRegister = {},
    resizeHandler = {},

    //Process
    pTimer = null, //processTimer
    pAudio = null, //processAudio
    pAdBlocker = null; //processAdBlock

initLang();
