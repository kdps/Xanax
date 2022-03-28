var PlayState;
(function (PlayState) {
    PlayState["ENDED"] = "ended";
    PlayState["PAUSE"] = "pause";
    PlayState["PLAY"] = "play";
    PlayState["PLAYING"] = "playing";
    PlayState["LOADED_METADATA"] = "loadedmetadata";
    PlayState["LOADED_DATA"] = "loadeddata";
    PlayState["CAN_PLAY"] = "canplay";
    PlayState["CAN_PLAY_THROUGH"] = "canplaythrough";
    PlayState["VOLUME_CHANGE"] = "volumechange";
    PlayState["RATE_CHANGE"] = "ratechange";
    PlayState["DURATION_CHANGE"] = "durationchange";
    PlayState["STALLED"] = "stalled";
    PlayState["EMPTIED"] = "emptied";
    PlayState["SUSPEND"] = "suspend";
    PlayState["SEEKING"] = "seeking";
    PlayState["WAITING"] = "waiting";
})(PlayState || (PlayState = {}));
class MediaPlayer {
    constructor(mediaContext) {
        this.mediaContext = typeof mediaContext === 'string' ? document.querySelector(mediaContext) : mediaContext;
        this.mediaType = this.mediaContext.getAttribute('mime-type');
        this.events = [];
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
        this.events[event].listeners = this.events[event].listeners.filter(listener => {
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
        if (this.events[event] === undefined) {
            return;
        }
        this.events[event].listeners.forEach((listener) => {
            listener(details);
        });
    }
    isPlaying() {
        return this.mediaContext
            && this.mediaContext.currentTime > 0
            && !this.mediaContext.paused
            && !this.mediaContext.ended
            && this.mediaContext.readyState > 2;
    }
    isPaused() {
        return this.mediaContext.paused;
    }
    isEnded() {
        return this.mediaContext.ended;
    }
    seekBackward(seconds) {
        if (this.getCurrentTime() - seconds > 0) {
            this.setCurrentTime(this.getCurrentTime() - seconds);
        }
        else {
            this.setCurrentTime(0);
        }
    }
    seekForward(seconds) {
        if (this.getCurrentTime() + seconds <= this.getCurrentDuration()) {
            this.setCurrentTime(this.getCurrentTime() + seconds);
        }
        else {
            this.setCurrentTime(this.getCurrentDuration());
        }
    }
    setCurrentTime(time) {
        this.mediaContext.currentTime = time;
    }
    getCurrentTime() {
        return this.mediaContext.currentTime;
    }
    setVolume(value) {
        this.mediaContext.volume = value;
    }
    getVolume() {
        return this.mediaContext.volume;
    }
    getBuffered() {
        return this.mediaContext.buffered;
    }
    getCurrentDuration() {
        return this.mediaContext.duration;
    }
    getDuration() {
        const self = this;
        return new Promise((resolve) => {
            if (self.mediaContext.duration === Infinity) {
                self.mediaContext.currentTime = 1e101;
                self.mediaContext.ontimeupdate = function () {
                    self.mediaContext.ontimeupdate = () => {
                        return;
                    };
                    self.mediaContext.currentTime = 0;
                    resolve(self.mediaContext.duration);
                };
            }
            else {
                resolve(self.mediaContext.duration);
            }
        });
    }
    addEvents() {
        const self = this;
        const onStalledEvent = (event) => {
            self.dispatch(PlayState.STALLED, event);
        };
        this.mediaContext.removeEventListener(PlayState.STALLED, onStalledEvent);
        this.mediaContext.addEventListener(PlayState.STALLED, onStalledEvent);
        const onEmptiesEvent = (event) => {
            self.dispatch(PlayState.EMPTIED, event);
        };
        this.mediaContext.removeEventListener(PlayState.EMPTIED, onEmptiesEvent);
        this.mediaContext.addEventListener(PlayState.EMPTIED, onEmptiesEvent);
        const onSuspendEvent = (event) => {
            self.dispatch(PlayState.SUSPEND, event);
        };
        this.mediaContext.removeEventListener(PlayState.SUSPEND, onSuspendEvent);
        this.mediaContext.addEventListener(PlayState.SUSPEND, onSuspendEvent);
        const onDurationChangeEvent = (event) => {
            self.dispatch(PlayState.DURATION_CHANGE, event);
        };
        this.mediaContext.removeEventListener(PlayState.DURATION_CHANGE, onDurationChangeEvent);
        this.mediaContext.addEventListener(PlayState.DURATION_CHANGE, onDurationChangeEvent);
        const onRateChangeEvent = (event) => {
            self.dispatch(PlayState.RATE_CHANGE, event);
        };
        this.mediaContext.removeEventListener(PlayState.RATE_CHANGE, onRateChangeEvent);
        this.mediaContext.addEventListener(PlayState.RATE_CHANGE, onRateChangeEvent);
        const onVolumeChangeEvent = (event) => {
            self.dispatch(PlayState.VOLUME_CHANGE, event);
        };
        this.mediaContext.removeEventListener(PlayState.VOLUME_CHANGE, onVolumeChangeEvent);
        this.mediaContext.addEventListener(PlayState.VOLUME_CHANGE, onVolumeChangeEvent);
        const onCanPlayThroughEvent = (event) => {
            self.dispatch(PlayState.CAN_PLAY_THROUGH, event);
        };
        this.mediaContext.removeEventListener(PlayState.CAN_PLAY_THROUGH, onCanPlayThroughEvent);
        this.mediaContext.addEventListener(PlayState.CAN_PLAY_THROUGH, onCanPlayThroughEvent);
        const onSeekingEvent = function (event) {
            self.dispatch(PlayState.SEEKING, event);
        };
        this.mediaContext.removeEventListener(PlayState.SEEKING, onSeekingEvent);
        this.mediaContext.addEventListener(PlayState.SEEKING, onSeekingEvent);
        const onWaitingEvent = function (event) {
            self.dispatch(PlayState.WAITING, event);
        };
        this.mediaContext.removeEventListener(PlayState.WAITING, onWaitingEvent);
        this.mediaContext.addEventListener(PlayState.WAITING, onWaitingEvent);
        const onCanPlayEvent = function (event) {
            self.dispatch(PlayState.CAN_PLAY, event);
        };
        this.mediaContext.removeEventListener(PlayState.CAN_PLAY, onCanPlayEvent);
        this.mediaContext.addEventListener(PlayState.CAN_PLAY, onCanPlayEvent);
        const onLoadedDataEvent = function (event) {
            self.dispatch(PlayState.LOADED_DATA, event);
        };
        this.mediaContext.removeEventListener(PlayState.LOADED_DATA, onLoadedDataEvent);
        this.mediaContext.addEventListener(PlayState.LOADED_DATA, onLoadedDataEvent);
        const onLoadedMetaDataEvent = function (event) {
            self.dispatch(PlayState.LOADED_METADATA, event);
        };
        this.mediaContext.removeEventListener(PlayState.LOADED_METADATA, onLoadedMetaDataEvent);
        this.mediaContext.addEventListener(PlayState.LOADED_METADATA, onLoadedMetaDataEvent);
        const onPlayingEvent = function (event) {
            self.dispatch(PlayState.PLAYING, event);
        };
        this.mediaContext.removeEventListener(PlayState.PLAYING, onPlayingEvent);
        this.mediaContext.addEventListener(PlayState.PLAYING, onPlayingEvent);
        const onPlayEvent = function (event) {
            self.dispatch(PlayState.PLAY, event);
        };
        this.mediaContext.removeEventListener(PlayState.PLAY, onPlayEvent);
        this.mediaContext.addEventListener(PlayState.PLAY, onPlayEvent);
        const onPauseEvent = function (event) {
            self.dispatch(PlayState.PAUSE, event);
        };
        this.mediaContext.removeEventListener(PlayState.PAUSE, onPauseEvent);
        this.mediaContext.addEventListener(PlayState.PAUSE, onPauseEvent, false);
        const onEndedEvent = function (event) {
            self.dispatch(PlayState.ENDED, event);
        };
        this.mediaContext.removeEventListener(PlayState.ENDED, onEndedEvent);
        this.mediaContext.addEventListener(PlayState.ENDED, onEndedEvent);
        this.mediaContext.onerror = function (event) {
            self.dispatch("error", event);
        };
    }
    isPlayable() {
        return this.mediaContext.canPlayType(this.mediaType);
    }
    isAutoPlayable() {
        return this.mediaContext.autoplay;
    }
    getNetworkStateConstant() {
        switch (this.getNetworkState()) {
            case 1:
                return `NETWORK_EMPTY`;
            case 2:
                return `NETWORK_IDLE`;
            case 3:
                return `NETWORK_LOADING`;
            case 4:
                return `NETWORK_NO_SOURCE`;
            default:
                return `UNKNOWN`;
        }
    }
    getNetworkState() {
        return this.mediaContext.networkState;
    }
    getCurrentSource() {
        return this.mediaContext.currentSrc;
    }
    getVideoTracks() {
        return this.mediaContext.videoTracks;
    }
    getTextTracks() {
        return this.mediaContext.textTracks;
    }
    getAudioTracks() {
        return this.mediaContext.audioTracks;
    }
    fastSeek(time) {
        this.mediaContext.fastSeek(time);
    }
    isMuted() {
        return this.mediaContext.muted;
    }
    isLooping() {
        return this.mediaContext.loop;
    }
    play() {
        this.mediaContext.play();
    }
    pause() {
        this.mediaContext.pause();
    }
    destroy() {
        if (this.mediaContext) {
            this.mediaContext.destroy();
        }
    }
}
;
