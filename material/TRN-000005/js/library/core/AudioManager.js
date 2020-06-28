/////////////////////////////////////////////////////////
//AudioManager.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize AudioManager
//Backsound
var AudioManager = {};
AudioManager.initBacksound = function() {
    if (!Config.preloaderState) {
        Main.showPreload();
    }
    var volBGM;
    if (AudioConfig.bgmMuteState) {
        volBGM = 0;
    } else {
        volBGM = AudioConfig.bgmVol;
    }
    Config.audioBGM = new Howl({
        src: ["data/audio/bgm.mp3","data/audio/bgm.ogg"],
        sprite: AudioConfig.bgmSprite,
        volume: volBGM,
        onload: function() {
            Main.hidePreload();
            if (AudioConfig.bgmSize > 1) {
                AudioConfig.BGMID = [];
                for (var i = 0; i < AudioConfig.bgmSize; i++) {
                    AudioConfig.BGMID.push(null);
                }
                AudioConfig.BGMID[0] = Config.audioBGM.play('bgm_0');
            } else {
                AudioConfig.BGMID = null;
                AudioConfig.BGMID = Config.audioBGM.play('bgm');
            }
            if (AudioConfig.sfxSize > 1) {
                AudioConfig.SFXID = [];
                for (var i = 0; i < AudioConfig.sfxSize; i++) {
                    AudioConfig.SFXID.push(null);
                }
            } else {
                AudioConfig.SFXID = null;
            }
        }
    });
};
AudioManager.playBacksound = function(_id) {
    AudioManager.stopBacksound();
    if (AudioConfig.bgmSize > 1) {
        AudioConfig.playedIDBGM = _id;
        AudioConfig.BGMID[_id] = Config.audioBGM.play('bgm_' + _id);
    } else {
        AudioConfig.BGMID = Config.audioBGM.play('bgm');
    }
};
AudioManager.stopBacksound = function() {
    if (AudioConfig.bgmSize > 1) {
        for (var i = 0; i < AudioConfig.bgmSize; i++) {
            if (AudioConfig.BGMID[i] != null) {
                Config.audioBGM.stop(AudioConfig.BGMID[i]);
            }
        }
    } else {
        Config.audioBGM.stop(AudioConfig.BGMID);
    }
    AudioConfig.playedIDBGM = -1;
};
AudioManager.pauseBacksound = function() {
    if (AudioConfig.muteBacksound) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.bgmSize > 1) {
        if (AudioConfig.playedIDBGM == -1) return;
        Config.audioBGM.pause(AudioConfig.BGMID[AudioConfig.playedIDBGM]);
    } else {
        if (AudioConfig.BGMID == null) return;
        Config.audioBGM.pause(AudioConfig.BGMID);
    }
};
AudioManager.resumeBacksound = function() {
    if (AudioConfig.muteBacksound) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.bgmSize > 1) {
        if (AudioConfig.playedIDBGM == -1) return;
        Config.audioBGM.play(AudioConfig.BGMID[AudioConfig.playedIDBGM]);
    } else {
        if (AudioConfig.BGMID == null) return;
        Config.audioBGM.play(AudioConfig.BGMID);
    }
};
AudioManager.muteBacksound = function() {
    if (!AudioConfig.bgmMuteState) {
        if (Config.audioBGM != null) {
            Config.audioBGM.volume(0);
        }
        AudioConfig.bgmMuteState = true;
    } else {
        if (Config.audioBGM != null) {
            Config.audioBGM.volume(AudioConfig.bgmVol);
        }
        AudioConfig.bgmMuteState = false;
    }
};
AudioManager.decBacksoundVolume = function() {
    TweenMax.killDelayedCallsTo(AudioManager.incBacksoundVolume);
    if (AudioConfig.bgmMuteState) return;
    AudioConfig.bgmVol = Config.audioBGM.volume();
    if (AudioConfig.bgmVol > 0.2) {
        AudioConfig.bgmVol -= 0.05;
        TweenMax.delayedCall(0.1, AudioManager.decBacksoundVolume, null, AudioManager);
    } else {
        TweenMax.killDelayedCallsTo(AudioManager.decBacksoundVolume);
        AudioConfig.bgmVol = 0.2;
    }
    Config.audioBGM.volume(AudioConfig.bgmVol);
};
AudioManager.incBacksoundVolume = function() {
    TweenMax.killDelayedCallsTo(AudioManager.decBacksoundVolume);
    if (AudioConfig.bgmMuteState) return;
    AudioConfig.bgmVol = Config.audioBGM.volume();
    if (AudioConfig.bgmVol < 0.7) {
        AudioConfig.bgmVol += 0.05;
        TweenMax.delayedCall(0.1, AudioManager.incBacksoundVolume, null, AudioManager);
    } else {
        TweenMax.killDelayedCallsTo(AudioManager.incBacksoundVolume);
        AudioConfig.bgmVol = 0.7;
    }
    Config.audioBGM.volume(AudioConfig.bgmVol);
};
//Sound FX
AudioManager.playSoundFX = function(_id) {
    if (AudioConfig.sfxSize > 1) {
        AudioConfig.playedIDSFX = _id;
        AudioConfig.SFXID[_id] = Config.audioBGM.play('sfx_' + _id);
        Config.audioBGM.once('end', function() {
            AudioConfig.playedIDSFX = -1;
        }, AudioConfig.SFXID[_id]);
    } else {
        AudioConfig.SFXID = Config.audioBGM.play('sfx_' + _id);
    }
};
AudioManager.stopSoundFX = function(_id) {
    if (AudioConfig.sfxSize > 1) {
        Config.audioBGM.stop(AudioConfig.SFXID[_id]);
    } else {
        Config.audioBGM.stop(AudioConfig.SFXID);
    }
    AudioConfig.playedIDSFX = -1;
};
AudioManager.pauseSoundFX = function() {
    if (AudioConfig.muteBacksound) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.sfxSize > 1) {
        if (AudioConfig.playedIDSFX == -1) return;
        Config.audioBGM.pause(AudioConfig.SFXID[AudioConfig.playedIDSFX]);
    } else {
        if (AudioConfig.SFXID == null) return;
        Config.audioBGM.pause(AudioConfig.SFXID);
    }
};
AudioManager.resumeSoundFX = function() {
    if (AudioConfig.muteBacksound) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.sfxSize > 1) {
        if (AudioConfig.playedIDSFX == -1) return;
        Config.audioBGM.play(AudioConfig.SFXID[AudioConfig.playedIDSFX]);
    } else {
        if (AudioConfig.SFXID == null) return;
        Config.audioBGM.play(AudioConfig.SFXID);
    }
};
//General Audio
AudioManager.initAudio = function() {
    var i;
    if (Config.audio != null) {
        AudioManager.forceStopAudio();
        Config.audio.unload();
        Config.audio = null;
    }
    if (!Config.preloaderState) {
        Main.showPreload();
    }
    var volAudio;
    if (AudioConfig.audioMuteState) {
        volAudio = 0;
    } else {
        volAudio = AudioConfig.audioVol;
    }
    Config.audio = new Howl({
        src: ["data/audio/" + Config.contentIDs[Config.page] + ".mp3","data/audio/" + Config.contentIDs[Config.page] + ".ogg"],
        sprite: AudioConfig.audioSprite[Config.page],
        volume: volAudio,
        onload: function() {
            if (Config.firstLoad) {
                Main.loadContent("", null);
            } else {
                if (Config.lastPage < Config.page) {
                    Main.loadContent("", true);
                } else {
                    Main.loadContent("", false);
                }
            }
            Config.audio.play(Config.contentIDs[Config.page] + '_0');
        }
    });
    Config.audio.once("loaderror", function() {
        if (Config.firstLoad) {
            Main.loadContent("", null);
        } else {
            if (Config.lastPage < Config.page) {
                Main.loadContent("", true);
            } else {
                Main.loadContent("", false);
            }
        }
        Config.audio.unload();
        Config.audio = null;
    });
};
AudioManager.playAudio = function(_id,_useContinue,_symbolID,_callback) {
    Config.audio.stop();
    AudioConfig.useContinue = false;
    if (_useContinue != null && _useContinue != undefined) {
        AudioConfig.useContinue = _useContinue;
    }
    AudioConfig.callBack = null;
    if (_callback != null && _callback != undefined) {
        AudioConfig.callBack = _callback;
    }
    AudioConfig.symbolID = "";
    if (_symbolID != null && _symbolID != undefined && _symbolID != "") {
        AudioConfig.symbolID = _symbolID;
    }
    //Trial
    if (Config.useSubtitle && Config.autoUpdateSub) {
        var txtID = parseInt(_id) - 1;
        PopupManager.updateSubtitleText(txtID);
    }
    Config.audio.once('end', function() {
        if (AudioConfig.useContinue) {
            if (AudioConfig.symbolID != "") {
                if (Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != null && Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != undefined) {
                    Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID).continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
                } else {
                    Config.hypeContent.continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
                }
            } else {
                Config.hypeContent.continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
            }
        }
        if (Config.useBackSound) {
            AudioManager.incBacksoundVolume();
        }
        if (AudioConfig.callBack != null) {
            AudioConfig.callBack();
        }
        AudioConfig.playedIDAudio = null;
        if (Config.useSubtitle && Config.resetSubTxt) {
            PopupManager.resetSubtitleText();
        }
    });
    //TODO: auto pause content timeline jika _useContinue: true
    /*if (AudioConfig.useContinue) {
        if (AudioConfig.symbolID != "") {
            if (Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != null && Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != undefined) {
                Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID).pauseTimelineNamed('Main Timeline');
            } else {
                Config.hypeContent.pauseTimelineNamed('Main Timeline');
            }
        } else {
            Config.hypeContent.pauseTimelineNamed('Main Timeline');
        }
    }*/
    AudioConfig.playedIDAudio = Config.audio.play(Config.contentIDs[Config.page] + '_' + _id);
    if (Config.useBackSound) {
        AudioManager.decBacksoundVolume();
    }
};
AudioManager.stopAudio = function() {
    if (Config.audio == null) return;
    if (AudioConfig.useContinue) {
        if (Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != null && Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID) != undefined) {
            Config.hypeContent.getSymbolInstanceById(AudioConfig.symbolID).continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
        } else {
            Config.hypeContent.continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
        }
    } else {
        Config.hypeContent.continueTimelineNamed('Main Timeline', Config.hypeContent.kDirectionForward, false);
    }
    if (Config.useBackSound) {
        AudioManager.incBacksoundVolume();
    }
    if (AudioConfig.callBack != null) {
        AudioConfig.callBack();
    }
    Config.audio.stop();
    AudioConfig.playedIDAudio = null;
    if (Config.useSubtitle && Config.resetSubTxt) {
        PopupManager.resetSubtitleText();
    }
};
AudioManager.forceStopAudio = function() {
    if (Config.audio == null) return;
    if (Config.useBackSound) {
        AudioManager.incBacksoundVolume();
    }
    if (AudioConfig.callBack != null) {
        AudioConfig.callBack = null;
    }
    Config.audio.stop();
    AudioConfig.playedIDAudio = null;
    if (Config.useSubtitle && Config.resetSubTxt) {
        PopupManager.resetSubtitleText();
    }
};
AudioManager.pauseAudio = function() {
    if (AudioConfig.muteAudio) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.playedIDAudio == null) return;
    Config.audio.pause(AudioConfig.playedIDAudio);
};
AudioManager.resumeAudio = function() {
    if (AudioConfig.muteAudio) return;
    if (AudioConfig.muteAllAudio) return;
    if (AudioConfig.playedIDAudio == null) return;
    Config.audio.play(AudioConfig.playedIDAudio);
};
AudioManager.muteAudio = function() {
    if (!AudioConfig.audioMuteState) {
        if (Config.audio != null) {
            Config.audio.volume(0);
        }
        AudioConfig.audioMuteState = true;
    } else {
        if (Config.audio != null) {
            Config.audio.volume(AudioConfig.audioVol);
        }
        AudioConfig.audioMuteState = false;
    }
};
//All Audio
AudioManager.setAudioVolume = function(_vol, _allAudio) {
    if (Config.audio != null) {
        AudioConfig.audioVol = _vol;
        Config.audio.volume(AudioConfig.audioVol);
    }
    if (_allAudio) {
        if (Config.audioBGM != null) {
            AudioConfig.bgmVol = (_vol / 1) * 0.7;
            Config.audioBGM.volume(AudioConfig.bgmVol);
        }
    }
};
AudioManager.muteAllAudio = function(_state) {
    AudioConfig.allMuteState = _state;
    if (AudioConfig.allMuteState) {
        if (Config.audio != null) {
            Config.audio.volume(0);
        }
        if (Config.audioBGM != null) {
            Config.audioBGM.volume(0);
        }
    } else {
        if (Config.audio != null) {
            Config.audio.volume(AudioConfig.audioVol);
        }
        if (Config.audioBGM != null) {
            Config.audioBGM.volume(AudioConfig.bgmVol);
        }
    }
    AudioConfig.muteBacksound = AudioConfig.allMuteState;
    AudioConfig.muteAudio = AudioConfig.allMuteState;
};