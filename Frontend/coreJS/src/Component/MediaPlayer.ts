interface MediaPlayerInterface {
    removeListeners(event: string) :boolean;
    removeListener(event: string, callback: Function);
    addListener(event: string, callback: Function);
    isPlaying(): boolean;
    isPaused(): boolean;
    isEnded(): boolean;
    seekBackward(seconds: number): void;
    seekForward(seconds: number): void;
    setCurrentTime(time: number): void;
    getCurrentTime(): number;
}

enum PlayState {
    ENDED = 'ended',
    PAUSE = 'pause',
    PLAY = 'play',
    PLAYING = 'playing',
    LOADED_METADATA = 'loadedmetadata',
    LOADED_DATA = 'loadeddata',
    CAN_PLAY = 'canplay',
    CAN_PLAY_THROUGH = 'canplaythrough',
    VOLUME_CHANGE = 'volumechange',
    RATE_CHANGE = 'ratechange',
    DURATION_CHANGE = 'durationchange',
    STALLED = 'stalled',
    EMPTIED = 'emptied',
    SUSPEND = 'suspend',
    SEEKING = 'seeking',
    WAITING = 'waiting'
}

class MediaPlayer implements MediaPlayerInterface {

    private mediaType: any;
    public mediaContext: any;
    public events: Array<any>;

    constructor(mediaContext: any) {
        this.mediaContext = typeof mediaContext === 'string' ? document.querySelector(mediaContext) : mediaContext;
        this.mediaType = this.mediaContext.getAttribute('mime-type');

        this.events = [];
    }

    public removeListeners(event: string) :boolean {
        if (this.events[event] === undefined) {
            return false;
        }

        delete this.events[event];
        return true;
    }

    public removeListener(event: string, callback: Function) {
        if (this.events[event] === undefined) {
            return false;
        }

        this.events[event].listeners = this.events[event].listeners.filter(listener => {
            return listener.toString() !== callback.toString();
        })
    }

    public addListener(event: string, callback: Function) {
        if (this.events[event] === undefined) {
            this.events[event] = {
                listeners: []
            }
        }
        
        this.events[event].listeners.push(callback);
    }

    private dispatch(event: string, details: any) {
        if (this.events[event] === undefined) {
            return;
        }

        this.events[event].listeners.forEach((listener) => {
            listener(details);
        })
    }

    public isPlaying(): boolean {
        return this.mediaContext
            && this.mediaContext.currentTime > 0
            && !this.mediaContext.paused
            && !this.mediaContext.ended
            && this.mediaContext.readyState > 2;
    }

    public isPaused(): boolean {
        return this.mediaContext.paused;
    }

    public isEnded(): boolean {
        return this.mediaContext.ended;
    }

    public seekBackward(seconds: number): void {
        if (this.getCurrentTime() - seconds > 0) {
            this.setCurrentTime(this.getCurrentTime() - seconds);
        } else {
            this.setCurrentTime(0);
        }
    }

    public seekForward(seconds: number): void {
        if (this.getCurrentTime() + seconds <= this.getCurrentDuration()) {
            this.setCurrentTime(this.getCurrentTime() + seconds);
        } else {
            this.setCurrentTime(this.getCurrentDuration());
        }
    }

    public setCurrentTime(time: number): void {
        this.mediaContext.currentTime = time;
    }

    public getCurrentTime(): number {
        return this.mediaContext.currentTime;
    }

    public setVolume(value: number): void {
        this.mediaContext.volume = value;
    }

    public getVolume(): number {
        return this.mediaContext.volume;
    }

    public getBuffered() {
        return this.mediaContext.buffered;
    }

    public getCurrentDuration(): number {
        return this.mediaContext.duration;
    }

    public getDuration(): any {
        const self = this;

        return new Promise((resolve) => {
            if (self.mediaContext.duration === Infinity) {
                self.mediaContext.currentTime = 1e101;
                self.mediaContext.ontimeupdate = function() {
                    self.mediaContext.ontimeupdate = () => {
                        return;
                    }

                    self.mediaContext.currentTime = 0;
                    resolve(self.mediaContext.duration);
                }
            } else {
                resolve(self.mediaContext.duration);
            }
        });
    }

    public addEvents(): void {
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

        // The suspend event is fired when media data loading has been suspended.
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

        // The volumechange event is fired when the volume has changed.
        this.mediaContext.removeEventListener(PlayState.VOLUME_CHANGE, onVolumeChangeEvent);
        this.mediaContext.addEventListener(PlayState.VOLUME_CHANGE, onVolumeChangeEvent);

        const onCanPlayThroughEvent = (event) => {
            self.dispatch(PlayState.CAN_PLAY_THROUGH, event);
        };

        this.mediaContext.removeEventListener(PlayState.CAN_PLAY_THROUGH, onCanPlayThroughEvent);
        this.mediaContext.addEventListener(PlayState.CAN_PLAY_THROUGH, onCanPlayThroughEvent);

        const onSeekingEvent = function(event) {
            self.dispatch(PlayState.SEEKING, event);
        };

        this.mediaContext.removeEventListener(PlayState.SEEKING, onSeekingEvent);
        this.mediaContext.addEventListener(PlayState.SEEKING, onSeekingEvent);

        const onWaitingEvent = function(event) {
            self.dispatch(PlayState.WAITING, event);
        };

        this.mediaContext.removeEventListener(PlayState.WAITING, onWaitingEvent);
        this.mediaContext.addEventListener(PlayState.WAITING, onWaitingEvent);

        const onCanPlayEvent = function(event) {
            self.dispatch(PlayState.CAN_PLAY, event);
        };

        this.mediaContext.removeEventListener(PlayState.CAN_PLAY, onCanPlayEvent);
        this.mediaContext.addEventListener(PlayState.CAN_PLAY, onCanPlayEvent);

        const onLoadedDataEvent = function(event) {
            self.dispatch(PlayState.LOADED_DATA, event);
        };

        this.mediaContext.removeEventListener(PlayState.LOADED_DATA, onLoadedDataEvent);
        this.mediaContext.addEventListener(PlayState.LOADED_DATA, onLoadedDataEvent);

        const onLoadedMetaDataEvent = function(event) {
            self.dispatch(PlayState.LOADED_METADATA, event);
        };

        this.mediaContext.removeEventListener(PlayState.LOADED_METADATA, onLoadedMetaDataEvent);
        this.mediaContext.addEventListener(PlayState.LOADED_METADATA, onLoadedMetaDataEvent);

        const onPlayingEvent = function (event) {
            self.dispatch(PlayState.PLAYING, event);
        };

        // The playing event is fired after playback is first started, and whenever it is restarted
        this.mediaContext.removeEventListener(PlayState.PLAYING, onPlayingEvent);
        this.mediaContext.addEventListener(PlayState.PLAYING, onPlayingEvent);

        const onPlayEvent = function(event) {
            self.dispatch(PlayState.PLAY, event);
        };

        this.mediaContext.removeEventListener(PlayState.PLAY, onPlayEvent);
        this.mediaContext.addEventListener(PlayState.PLAY, onPlayEvent);

        const onPauseEvent = function(event) {
            self.dispatch(PlayState.PAUSE, event);
        };

        this.mediaContext.removeEventListener(PlayState.PAUSE, onPauseEvent);
        this.mediaContext.addEventListener(PlayState.PAUSE, onPauseEvent, false);

        const onEndedEvent = function(event) {
            self.dispatch(PlayState.ENDED, event);
        };

        this.mediaContext.removeEventListener(PlayState.ENDED, onEndedEvent);
        this.mediaContext.addEventListener(PlayState.ENDED, onEndedEvent);

        this.mediaContext.onerror = function(event) {
            self.dispatch("error", event);
        };

    }

    public isPlayable() :boolean {
        return this.mediaContext.canPlayType(this.mediaType);
    }

    public isAutoPlayable(): any {
        return this.mediaContext.autoplay;
    }

    private getNetworkStateConstant(): string {
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

    private getNetworkState(): number {
        return this.mediaContext.networkState;
    }

    private getCurrentSource(): string {
        return this.mediaContext.currentSrc;
    }
    
    public getVideoTracks(): any {
        return this.mediaContext.videoTracks;
    }

    public getTextTracks(): any {
        return this.mediaContext.textTracks;
    }

    public getAudioTracks(): any {
        return this.mediaContext.audioTracks;
    }

    public fastSeek(time: number): void {
        this.mediaContext.fastSeek(time);
    }

    public isMuted(): void {
        return this.mediaContext.muted;
    }

    public isLooping(): boolean {
        return this.mediaContext.loop;
    }

    public play(): void {
        this.mediaContext.play();
    }

    public pause(): void {
        this.mediaContext.pause();
    }

    destroy(): void {
        if (this.mediaContext) {
            this.mediaContext.destroy();
        }
    }
};