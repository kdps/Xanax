var RecorderEvent;
(function (RecorderEvent) {
    RecorderEvent["ON_DATA_AVAILABLE"] = "ondataavailable";
    RecorderEvent["LOADED_METADATA"] = "loadedmetadata";
    RecorderEvent["ON_STOP"] = "onstop";
    RecorderEvent["ON_RESUME"] = "onresume";
    RecorderEvent["ON_PAUSE"] = "onpause";
    RecorderEvent["ON_START"] = "onstart";
    RecorderEvent["ON_ERROR"] = "onerror";
    RecorderEvent["ON_FREQUENCY"] = "onfrequency";
    RecorderEvent["ON_DETECT"] = "ondetect";
})(RecorderEvent || (RecorderEvent = {}));
var RecordAction;
(function (RecordAction) {
    RecordAction["STOP"] = "stop";
    RecordAction["RECORD"] = "record";
    RecordAction["PAUSE"] = "pause";
    RecordAction["RESUME"] = "resume";
})(RecordAction || (RecordAction = {}));
var RecordState;
(function (RecordState) {
    RecordState["RECORDING"] = "recording";
    RecordState["INACTIVE"] = "inactive";
    RecordState["PAUSED"] = "paused";
})(RecordState || (RecordState = {}));
var PermissionStates;
(function (PermissionStates) {
    PermissionStates["DENIED"] = "denied";
    PermissionStates["GRANTED"] = "granted";
    PermissionStates["PROMPT"] = "prompt";
})(PermissionStates || (PermissionStates = {}));
var Codecs;
(function (Codecs) {
    Codecs["OPERS"] = "codecs=opus";
    Codecs["VP9"] = "codecs=vp9";
    Codecs["H264"] = "codecs=h264";
})(Codecs || (Codecs = {}));
var MimeTypes;
(function (MimeTypes) {
    MimeTypes["MP3"] = "audio/mpeg";
    MimeTypes["WAV"] = "audio/wav";
    MimeTypes["OGG"] = "audio/ogg";
    MimeTypes["WEBM"] = "audio/webm";
    MimeTypes["MP4"] = "video/mp4";
    MimeTypes["MPEG"] = "video/mpeg";
})(MimeTypes || (MimeTypes = {}));
class AudioRecorder {
    constructor() {
        this.setCompatibility();
        this.state = RecordState.INACTIVE;
        this.timeslice = 1000;
        this.parse_frequence_timeout = 1000 / 30;
        this.is_granted = false;
        this.received_chunks = [];
        this.events = [];
        this.maximum_duration = -1;
        this.spectrum_callback = null;
        this.mediaRecorder = null;
        this.min_decibels = -120;
        this.fft_size = 9;
        this.requestAnimationFrame = window.requestAnimationFrame;
        this.cancelAnimationFrame = window.cancelAnimationFrame;
        this.use_autocorrelation = false;
    }
    hasGetUserMedia() {
        return !!(navigator.mediaDevices.getUserMedia || navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
    }
    useAutocorrelation(use) {
        this.use_autocorrelation = use;
    }
    fundamentalFrequence(buffer, sampleRate) {
        var sampleNumbers = 1024;
        var correctR = 0;
        var periodInFrame = -1;
        for (var products = 8; products <= 1000; products++) {
            let nomalize = 0;
            for (var i = 0; i < sampleNumbers; i++) {
                let current = ((buffer[i] - 127.5) / 127.5);
                let next = ((buffer[i + products] - 127.5) / 127.5);
                nomalize += current * next;
            }
            let R = nomalize / (sampleNumbers + products);
            if (R > correctR) {
                correctR = R;
                periodInFrame = products;
            }
            if (R > 0.9) {
                break;
            }
        }
        if (correctR > 0.0025) {
            return sampleRate / periodInFrame;
        }
        return -1;
    }
    fftHandler(stream) {
        const self = this;
        const audioContext = new AudioContext();
        const analyserNode = audioContext.createAnalyser();
        const streamNode = audioContext.createMediaStreamSource(stream);
        streamNode.connect(analyserNode);
        analyserNode.minDecibels = this.min_decibels;
        analyserNode.fftSize = 32 << this.fft_size;
        analyserNode.smoothingTimeConstant = 0.45;
        const arrayLength = new Uint8Array(analyserNode.frequencyBinCount);
        const trigger = () => {
            if (self.isRecording()) {
                analyserNode.getByteFrequencyData(arrayLength);
                if (arrayLength) {
                    self.dispatch(RecorderEvent.ON_FREQUENCY, arrayLength);
                }
                const buffer = new Uint8Array(analyserNode.fftSize);
                analyserNode.getByteTimeDomainData(buffer);
                const fundalmentalFreq = self.fundamentalFrequence(buffer, audioContext.sampleRate);
                if (fundalmentalFreq > -1) {
                    self.dispatch(RecorderEvent.ON_DETECT, stream);
                }
            }
            if (self.isRecording()) {
                setTimeout(() => {
                    requestAnimationFrame(trigger);
                }, self.parse_frequence_timeout);
            }
        };
        requestAnimationFrame(trigger);
    }
    clearSpectrum() {
        let target_div = document.querySelectorAll('#div');
        if (target_div.length > 0) {
            target_div = target_div[0];
        }
        target_div.innerHTML = '';
        const canvas = target_div.appendChild(document.createElement("canvas"));
        canvas.width = target_div.clientWidth;
        canvas.height = 24;
        canvas.style.verticalAlign = "middle";
        const canvasContext = canvas.getContext("2d");
        canvasContext.clearRect(0, 0, canvas.width, canvas.height);
        canvasContext.fillStyle = 'rgba(255, 0, 0, 0)';
    }
    setSpectrum() {
        this.useAutocorrelation(true);
        let target_div = document.querySelectorAll('#div');
        if (target_div.length > 0) {
            target_div = target_div[0];
        }
        target_div.innerHTML = '';
        const canvas = target_div.appendChild(document.createElement("canvas"));
        canvas.width = target_div.clientWidth;
        canvas.height = 24;
        canvas.style.verticalAlign = "middle";
        const canvasContext = canvas.getContext("2d");
        let fillColor = `rgb(255, 255, 255)`;
        let lineWidth = 2;
        this.addListener(RecorderEvent.ON_FREQUENCY, (freq) => {
            canvasContext.clearRect(0, 0, canvas.width, canvas.height);
            canvasContext.fillStyle = 'rgba(255, 0, 0, 0)';
            canvasContext.fillRect(0, 0, canvas.width, canvas.height);
            canvasContext.lineWidth = lineWidth;
            let x = 0;
            for (let d of freq) {
                const y = (canvas.height / canvasContext.lineWidth) - (d / 128) * canvas.height / canvasContext.lineWidth;
                canvasContext.fillStyle = fillColor;
                canvasContext.fillRect(x * 4, y, canvasContext.lineWidth, ((canvas.height / 2) - y) * canvasContext.lineWidth);
                x++;
            }
            canvasContext.beginPath();
        });
    }
    setCompatibility() {
        if (!window.AudioContext) {
            window.AudioContext = window.webkitAudioContext || window.mozAudioContext;
        }
        if (!window.requestAnimationFrame) {
            this.requestAnimationFrame = window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
        }
        if (!window.cancelAnimationFrame) {
            this.cancelAnimationFrame = window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame;
        }
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
        }
        if (navigator.mediaDevices.getUserMedia === undefined) {
            navigator.mediaDevices.getUserMedia = function (constraints) {
                var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                }
                return new Promise(function (resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            };
        }
    }
    clearRecordChunks() {
        this.received_chunks = [];
    }
    async getDeviceList() {
        return new Promise(async (resolve, reject) => {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                resolve(devices);
            }
            catch (error) {
                reject(error);
            }
        });
    }
    async isDevicePermissionGranted() {
        let isGranted = false;
        try {
            if (typeof navigator.permissions.query !== 'undefined') {
                const permissionName = "microphone";
                const permission = await navigator.permissions.query({ name: permissionName });
                if (permission.state) {
                    isGranted = permission.state == PermissionStates.GRANTED;
                }
            }
        }
        catch (error) {
            console.error(error);
        }
        return isGranted;
    }
    async requestPermission() {
        return new Promise(async (resolve, reject) => {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: false });
                this.setRecorder();
                if (typeof this.spectrum_callback === 'function') {
                    this.spectrum_callback(this.stream);
                }
                if (this.use_autocorrelation) {
                    this.fftHandler(this.stream);
                }
                this.biquadFilter(this.stream);
                resolve(true);
            }
            catch (error) {
                reject(error);
            }
        });
    }
    biquadFilter(stream) {
        var audioContext = new AudioContext();
        var inputNode = audioContext.createMediaStreamSource(stream);
        var filter = audioContext.createBiquadFilter();
    }
    addSpectrum(spectrum) {
        if (typeof spectrum === 'undefined') {
            this.setSpectrum();
        }
        else {
            this.spectrum_callback = spectrum;
        }
    }
    getState() {
        if (typeof this.mediaRecorder.state == 'undefined') {
            return;
        }
        return this.mediaRecorder.state;
    }
    isRecording() {
        return this.getState() === RecordState.RECORDING;
    }
    isInactive() {
        return this.getState().toLowerCase() === RecordState.INACTIVE;
    }
    isPaused() {
        return this.getState().toLowerCase() === RecordState.PAUSED;
    }
    getOptions() {
        return {
            audioBitsPerSecond: 128000
        };
    }
    setRecorder() {
        this.mediaRecorder = new MediaRecorder(this.stream, this.getOptions());
    }
    isRecorderPresents() {
        return typeof this.mediaRecorder !== 'undefined';
    }
    removeAllListeners() {
        Object.keys(this.events).forEach(key => {
            delete this.events[key];
        });
    }
    removeListeners(event) {
        if (this.events[event] === undefined) {
            return false;
        }
        delete this.events[event];
        return true;
    }
    removeListener(event, callback) {
        if (this.events[event] === undefined) {
            return false;
        }
        this.events[event].listeners = this.events[event].listeners.filter((listener) => {
            return listener.toString() !== callback.toString();
        });
    }
    addListener(event, callback) {
        if (this.events[event] === undefined) {
            this.events[event] = {
                listeners: []
            };
        }
        this.events[event].listeners.push(callback);
    }
    dispatch(event, details) {
        if (typeof this.events[event] === 'undefined') {
            return;
        }
        this.events[event].listeners.forEach((listener) => {
            listener(details);
        });
    }
    stopTracks() {
        this.getTrack().forEach(function (track) {
            track.stop();
        });
    }
    getTrack() {
        return this.stream.getTracks();
    }
    isTypeSuppported(type) {
        if (typeof MediaRecorder.isTypeSupported == 'function') {
            return MediaRecorder.isTypeSupported(type);
        }
        return false;
    }
    addEvents() {
        const self = this;
        this.mediaRecorder.onresume = function (event) {
            self.dispatch(RecorderEvent.ON_RESUME, event);
        };
        this.mediaRecorder.onpause = function (event) {
            self.dispatch(RecorderEvent.ON_PAUSE, event);
        };
        this.mediaRecorder.onstart = function (event) {
            self.dispatch(RecorderEvent.ON_START, event);
        };
        this.mediaRecorder.ondataavailable = (event) => {
            self.dispatch(RecorderEvent.ON_DATA_AVAILABLE, event);
        };
        this.mediaRecorder.onerror = (event) => {
            self.dispatch(RecorderEvent.ON_ERROR, event);
        };
        this.mediaRecorder.onstop = (event) => {
            self.dispatch(RecorderEvent.ON_STOP, event);
        };
        const onLoadedMetadataEvent = (event) => {
            self.dispatch(RecorderEvent.LOADED_METADATA, event);
        };
        this.mediaRecorder.removeEventListener('loadedmetadata', onLoadedMetadataEvent);
        this.mediaRecorder.addEventListener(RecorderEvent.LOADED_METADATA, onLoadedMetadataEvent);
        this.removeListeners(RecorderEvent.ON_STOP);
        this.addListener(RecorderEvent.ON_STOP, (event) => {
            self.clearSpectrum();
        });
        this.removeListeners(RecorderEvent.ON_DATA_AVAILABLE);
        this.addListener(RecorderEvent.ON_DATA_AVAILABLE, (event) => {
            if (typeof event.data === 'undefined') {
                return;
            }
            if (event.data && event.data.size > 0) {
                self.received_chunks.push(event.data);
            }
        });
    }
    setMaximumDuration(duration = -1) {
        this.maximum_duration = duration;
    }
    throwStateError(method) {
        return new Error(`Failed to execute '${method}' on 'MediaRecorder': The MediaRecorder's state is '${this.state}'.`);
    }
    start() {
        if (!this.isRecorderPresents()) {
            return;
        }
        if (this.isRecording()) {
            throw new Error('Cannot start MediaRecorder when already recording');
        }
        if (!this.isInactive()) {
            throw this.throwStateError(RecordAction.RECORD);
        }
        this.state = RecordState.RECORDING;
        this.mediaRecorder.start(this.timeslice);
    }
    getBlob(type = MimeTypes.MP3) {
        return new Blob(this.received_chunks, { "type": type });
    }
    pause() {
        if (!this.isRecorderPresents()) {
            return;
        }
        if (!this.isRecording()) {
            throw this.throwStateError(RecordAction.PAUSE);
        }
        this.state = RecordState.PAUSED;
        this.mediaRecorder.pause();
    }
    resume() {
        if (!this.isRecorderPresents()) {
            return;
        }
        if (!this.isPaused()) {
            throw this.throwStateError(RecordAction.RESUME);
        }
        this.state = RecordState.RECORDING;
        this.mediaRecorder.resume();
    }
    stop() {
        if (!this.isRecorderPresents()) {
            return;
        }
        if (this.isInactive()) {
            throw this.throwStateError(RecordAction.STOP);
        }
        this.clearSpectrum();
        this.state = RecordState.INACTIVE;
        this.mediaRecorder.stop();
        this.stopTracks();
    }
}
