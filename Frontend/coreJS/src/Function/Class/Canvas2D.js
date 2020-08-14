export default class OPenGLObject {
	
	constructor(CanvasID) {
		try {
			this.canvas = document.getElementById(CanvasID);
		} catch(e) {
			throw "Cannot found Canvas Object";
		}
		
		this.context = null;
		this.fontSize = "12";
		this.fontFamily = "Arial";
	}
	
	setFullScreenSize () {
		this.canvas.height = window.innerHeight;
		this.canvas.width = window.innerWidth;
	}
	
	initialize () {
		this.context = this.canvas.getContext("2d");
	}
	
	setFontStyle () {
		let fontSize = '';
		if (typeof this.fontSize !== 'undefined') {
			fontSize = this.fontSize + "pt ";
		}
		this.context.font = fontSize + this.fontFamily;
	}
	
	setFontSize (fontsize) {
		this.fontSize = fontsize;
		this.setFontStyle();
	}
	
	setFontFamily (font) {
		this.fontFamily = font;
		this.setFontStyle();
	}
	
	setStrokeStyle (stroke) {
		this.canvas.strokeStyle = stroke;
	}
	
	setFillStyle (style) {
		this.context.fillStyle = style;
	}
	
	fillText (text, x, y) {
		this.context.fillText(text, x, y);
	}
	
	getImage (URL) {
		return $.core.Element.preloadImage(URL);
	}
	
	fillRect (x, y, width, height) {
		this.canvas.fillRect(x, y, width, height);
	}
	
	drawImage (img, sx, sy, swidth, sheight, x, y, width, height) {
		this.canvas.drawImage(img, sx, sy, swidth, sheight, x, y, width, height);
	}
	
	
}
