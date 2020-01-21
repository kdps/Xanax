import OpenGLAttributeObject from './OpenGLAttributeObject.js'

export default class OpenGLObject {
	
	constructor(CanvasID) {
		try {
		this.canvas = document.getElementById(CanvasID);
		} catch(e) {}
		
		this.gl = null;
		this.attribute = null;
	}
	
	getGLObject () {
		return this.gl;
	}
	
	setMatrixUniforms (shaderProgram, scriptID, flatten) {
		var Uniform = this.gl.getUniformLocation(shaderProgram, scriptID);
		this.gl.uniformMatrix4fv(Uniform, false, new Float32Array(flatten));
	}
		
	getShader(shaderId) {
		var theSource = "";
		var shaderScript = document.getElementById(shaderId);
		var currentChild = shaderScript.firstChild;
		var shader;
		
		while(currentChild) {
			if (currentChild.nodeType == currentChild.TEXT_NODE) {
				theSource += currentChild.textContent;
			}
		
			currentChild = currentChild.nextSibling;
		}
		
		if (shaderScript.type == "x-shader/x-fragment") {
			shader = this.gl.createShader(this.gl.FRAGMENT_SHADER);
		} else if (shaderScript.type == "x-shader/x-vertex") {
			shader = this.gl.createShader(this.gl.VERTEX_SHADER);
		} else {
			return null; // Unknown shader type
		}
		
		this.gl.shaderSource(shader, theSource);
    
		// Compile the shader program
		this.gl.compileShader(shader);  
		
		// See if it compiled successfully
		if (!this.gl.getShaderParameter(shader, this.attribute.COMPILE_STATUS)) {  
			alert("An error occurred compiling the shaders: " + this.gl.getShaderInfoLog(shader));  
			return null;  
		}
		
		return shader;
	}

	bufferData (mode, data, draw) {
		this.gl.bufferData(mode, data, draw);
	}
	
	bindBuffer (mode, buffer) {
		this.gl.bindBuffer(mode, buffer);
	}
	
	createBuffer () {
		return this.gl.createBuffer();
	}
	
	enableVertexAttribArray (AttribLocation) {
		this.gl.enableVertexAttribArray(AttribLocation);
	}
	
	getAttribLocation (shaderProgram, scriptID) {
		return this.gl.getAttribLocation(shaderProgram, scriptID);
	}
	
	useProgram (shaderProgram) {
		this.gl.useProgram(shaderProgram);
	}
	
	hasInitializedShaderProgramLink (shaderProgram) {
		if (this.gl.getProgramParameter(shaderProgram, this.attribute.LINK_STATUS)) {
			return true;
		}
		
		return false;
	}
	
	linkProgram (shaderProgram) {
		this.gl.linkProgram(shaderProgram);
		
		if (!this.hasInitializedShaderProgramLink(shaderProgram)) {
			return new Exception("Unable to initialize the shader program.");
		}
	}
	
	attachShader (shaderProgram, shader) {
		this.gl.attachShader(shaderProgram, shader);
	}
	
	createProgram () {
		return this.gl.createProgram();
	}
	
	initWebGL () {
		try {
			this.gl = this.canvas.getContext("webgl") || this.canvas.getContext("experimental-webgl")  || this.canvas.getContext("webkit-3d")  || this.canvas.getContext("moz-webgl");
			
			this.attribute = new OpenGLAttributeObject(this.gl);
		} catch (e) {}
	}
	
	setScissor (x = 0, y = 0, width, height) {
		this.gl.scissor(x, y, width, height);
	}
	
	/**
     	 * Set a scissor box
	 */
	setColorMask(red, green, blue, alpha = true) {
		this.gl.colorMask(red, green, blue, alpha);
	}
	
	/**
     	 * Set the viewport(Graphics Actual rendering area)
	 *
	 * @param x      : GLint (32bit long)
	 * @param y      : GLint (32bit long)
	 * @param width  : Glsizei (long)
	 * @param height : Glsizei (long)
	 */
	
	setViewPortSize (x = 0, y = 0, width, height) {
		this.gl.viewport(x, y, width, height);
	}
	
	/**
	 * Actual Width of the Cureent Drawing Buffer
	 * Read-Only
	 */
	get getDrawingBufferWidth() {
		return this.gl.drawingBufferWidth;
	}
	
	/**
	 * Actual Height of the Cureent Drawing Buffer
	 * Read-Only
	 */
	get getDrawingBufferHeight() {
		return this.gl.drawingBufferHeight;
	}
	
	/**
	 * Set Clear Color of OpenGL
	 *
	 * opacity (max 1.0) : set Opacity
	 */
	setClearColor (r, g, b, opacity) {
		this.gl.clearColor(r, g, b, opacity);
	}
	
	setColorBufferBitClear() {
		this.setClear(this.gl.COLOR_BUFFER_BIT);
	}
	
	setClear (mode) {
		this.gl.clear(mode);
	}
	
	setScissorTestEnable() {
		this.setEnable(this.gl.SCISSOR_TEST);
	}
	
	setEnable (mode) {
		this.gl.enable(mode);
	}
	
	setDepthFunc (func) {
		this.gl.depthFunc(func);
	}
	
	isInitialized () {
		if (this.gl == null) {
			return false;
		}
		
		return true;
	}
	
	initialize () {
		if (!this.isInitialized()) {
			this.initWebGL();
		}
	}
	
}
