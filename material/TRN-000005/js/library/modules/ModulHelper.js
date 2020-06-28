/////////////////////////////////////////////////////////
//ModulHelper.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize ModulHelper
var ModulHelper = {
    mParent: parent,
    mhypeDoc: null,
    mFirstLoad: true,
    mChangeScene: false,
    layoutType: parent.Config.layoutType,
    animTimeline: {},
    animSymTimeline: {}
};
ModulHelper.docLoaded = function(hypeDocument, element, event) {
    ModulHelper.mhypeDoc = hypeDocument;
    window.myHypeContainerId = hypeDocument.documentId();
    if (ModulHelper.isScalePossible()) {
        $('#' + window.myHypeContainerId).css({
            '-moz-transform-origin': '0% 0%',
            '-webkit-transform-origin': '0% 0%',
            '-ms-transform-origin': '0% 0%',
            '-o-transform-origin': '0% 0%',
            'transform-origin': '0% 0%',
            margin: 0
        });
        ModulHelper.scaleSite();
        $(window).resize(function() {
            ModulHelper.scaleSite();
        });
    }
    ModulHelper.mhypeDoc.currSceneElem = function() {
        var hc = document.getElementById(hypeDocument.documentId());
        var sa = hc.getElementsByClassName("HYPE_scene");
        for (i = 0; i < sa.length; i++) {
            if (sa[i].style.display === "block") return sa[i];
        }
        return "body";
    }
    return true;
};
ModulHelper.sceneLoaded = function(hypeDocument, event) {
    ModulHelper.scaleSite();
    ModulHelper.loadContent();
};
ModulHelper.sceneUnloaded = function(hypeDocument, element, event) {
    ModulHelper.unloadedContent();
};
ModulHelper.layoutChange = function(hypeDocument, element, event) {
    if (ModulHelper.layoutType !=0) {
        return "layout_" + ModulHelper.mParent.Config.breakIdx;
    }
};
ModulHelper.isScalePossible = function() {
    can = 'MozTransform' in document.body.style;
    if(!can) can = 'webkitTransform' in document.body.style;
    if(!can) can = 'msTransform' in document.body.style;
    if(!can) can = 'OTransform' in document.body.style;
    if(!can) can = 'transform' in document.body.style;
    if(!can) can = 'Transform' in document.body.style;
    return can;
};
ModulHelper.scaleSite = function() {
    var hypeContainer = $('#' + window.myHypeContainerId);
    var containerWidth = hypeContainer.width();
    var containerHeight = hypeContainer.height();
    var parentWidth = ModulHelper.mParent.document.getElementById('mod-wrapper').offsetWidth;
    var parentHeight = ModulHelper.mParent.document.getElementById('mod-wrapper').offsetHeight;
    var scaleWidth = parentWidth / containerWidth;
    var scaleHeight = parentHeight / containerHeight;
    var scale = Math.max(scaleWidth, scaleHeight);
    var left = (containerWidth * scale < parentWidth) ? ((parentWidth - (containerWidth * scale)) / 2) + 'px' : '0px';
    var top = (containerHeight * scale < parentHeight) ? ((parentHeight - (containerHeight * scale)) / 2) + 'px' : '0px';
    hypeContainer.css({
        "-moz-transform"    : "scale("+scale+")",
        "-webkit-transform" : "scale("+scale+")",
        "-ms-transform"     : "scale("+scale+")",
        "-o-transform"      : "scale("+scale+")",
        "transform"         : "scale("+scale+")",
        "left" : left,
        "top" : top
    });
};
ModulHelper.loadContent = function() {
    var i, j;
    ModulHelper.mhypeDoc.contentSymbol = [];
    var allID = document.querySelectorAll('[id]');
    Array.prototype.forEach.call( allID, function( el, sy ) {
        if (ModulHelper.mhypeDoc.getSymbolInstanceById(el.id) != null && ModulHelper.mhypeDoc.getSymbolInstanceById(el.id) != undefined) {
            ModulHelper.mhypeDoc.contentSymbol.push(ModulHelper.mhypeDoc.getSymbolInstanceById(el.id));
        }
    });
    ModulHelper.mhypeDoc.setParentBGColor = function() {
        setTimeout(function() {
            ModulHelper.mParent.EffectManager.changeBGColor($(ModulHelper.mhypeDoc.currSceneElem()).css("background-color"));
        }, 100);
    };
    ModulHelper.mParent.Config.hypeContent = ModulHelper.mhypeDoc;
    ModulHelper.mParent.Main.checkContent();
    var scID = parseInt(ModulHelper.mhypeDoc.currentSceneName().substr(6));
    if (ModulHelper.mParent.Config.sceneLocation[ModulHelper.mParent.Config.page] < scID) {
        ModulHelper.mParent.Config.sceneLocation[ModulHelper.mParent.Config.page] = scID;
    }
    ModulHelper.mParent.Config.currScene = scID;
    ModulHelper.mParent.ScormManager.setLmsLocation();
    if (ModulHelper.mFirstLoad) {
        ModulHelper.mFirstLoad = false;
        ModulHelper.mParent.Config.nextState = false;
        ModulHelper.mParent.Config.jumpingState = false;
        setTimeout(function() {
            ModulHelper.mParent.Main.startSlidingEff();
        }, 200);
        if (ModulHelper.mhypeDoc.sceneNames().length > 1) {
            if (ModulHelper.mParent.Config.checkingLastPage) {
                ModulHelper.mParent.Config.prevState = false;
                ModulHelper.mParent.Config.checkingLastPage = false;
                ModulHelper.mhypeDoc.showSceneNamed('scene_' + ModulHelper.mParent.Config.currScene, ModulHelper.mhypeDoc.kSceneTransitionInstant, 0);
            } else {
                if (ModulHelper.mParent.Config.prevState) {
                    ModulHelper.mParent.Config.prevState = false;
                    ModulHelper.mhypeDoc.showSceneNamed('scene_' + ModulHelper.mhypeDoc.sceneNames().length, ModulHelper.mhypeDoc.kSceneTransitionInstant, 0);
                }
            }
        } else {
            ModulHelper.mParent.Config.prevState = false;
        }
    }
    if (ModulHelper.mParent.Config.page == ModulHelper.mParent.Config.endPage) {
        ModulHelper.mParent.ScormManager.updateLms();
    }
    ModulHelper.loadedLayout();
};
ModulHelper.loadedLayout = function() {
    if (ModulHelper.layoutType == 0) return;
    if ((ModulHelper.mhypeDoc.kuis != null && ModulHelper.mhypeDoc.kuis != undefined) || (ModulHelper.mhypeDoc.info != null && ModulHelper.mhypeDoc.info != undefined)) return;
    var i;
    if (ModulHelper.mChangeScene) {
        ModulHelper.mChangeScene = false;
    } else {
        var timelineNames = ["Main Timeline"];
        for(i = 0; i < timelineNames.length; i++) {
            var timelineName = timelineNames[i];
            var timelineKey = "timeline_" + ModulHelper.mhypeDoc.currentSceneName() + "_" + timelineName;
            var timelineInfo = ModulHelper.animTimeline[timelineKey];
            if(timelineInfo != null) {
                ModulHelper.mhypeDoc.goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
                if(timelineInfo["state"] == true) {
                    ModulHelper.mhypeDoc.continueTimelineNamed(timelineName, timelineInfo["direction"]);
                } else {
                    ModulHelper.mhypeDoc.pauseTimelineNamed(timelineName);
                }
            }
        }
        for(i = 0; i < ModulHelper.mhypeDoc.contentSymbol.length; i++) {
            for (j = 0; j < timelineNames.length; j++) {
                var timelineName = timelineNames[i];
                var timelineKey = "timeline_" + ModulHelper.mhypeDoc.contentSymbol[i].symbolName() + "_" + timelineName;
                var timelineInfo = ModulHelper.animSymTimeline[timelineKey];
                if(timelineInfo != null) {
                    ModulHelper.mhypeDoc.contentSymbol[i].goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
                    if(timelineInfo["state"] == true) {
                        ModulHelper.mhypeDoc.contentSymbol[i].continueTimelineNamed(timelineName, timelineInfo["direction"]);
                    } else {
                        ModulHelper.mhypeDoc.contentSymbol[i].pauseTimelineNamed(timelineName);
                    }
                }
            }
        }
    }
};
ModulHelper.unloadedContent = function() {
    if (ModulHelper.layoutType == 0) return;
    if ((ModulHelper.mhypeDoc.kuis != null && ModulHelper.mhypeDoc.kuis != undefined) || (ModulHelper.mhypeDoc.info != null && ModulHelper.mhypeDoc.info != undefined)) return;
    var i, j;
    if (!ModulHelper.mChangeScene) {
        var timelineNames = ["Main Timeline"];
		for(i = 0; i < timelineNames.length; i++) {
			var timelineName = timelineNames[i];
			var timelineKey = "timeline_" + ModulHelper.mhypeDoc.currentSceneName() + "_" + timelineName;
			var timelineInfo = {};
			timelineInfo["time"] = ModulHelper.mhypeDoc.currentTimeInTimelineNamed(timelineName);
			timelineInfo["direction"] = ModulHelper.mhypeDoc.currentDirectionForTimelineNamed(timelineName);
			timelineInfo["state"] = ModulHelper.mhypeDoc.isPlayingTimelineNamed(timelineName);
			ModulHelper.animTimeline[timelineKey] = timelineInfo;
		}
        for(i = 0; i < ModulHelper.mhypeDoc.contentSymbol.length; i++) {
            for (j = 0; j < timelineNames.length; j++) {
                var timelineName = timelineNames[i];
                var timelineKey = "timeline_" + ModulHelper.mhypeDoc.contentSymbol[i].symbolName() + "_" + timelineName;
			    var timelineInfo = {};
                timelineInfo["time"] = ModulHelper.mhypeDoc.contentSymbol[i].currentTimeInTimelineNamed(timelineName);
                timelineInfo["direction"] = ModulHelper.mhypeDoc.contentSymbol[i].currentDirectionForTimelineNamed(timelineName);
                timelineInfo["state"] = ModulHelper.mhypeDoc.contentSymbol[i].isPlayingTimelineNamed(timelineName);
                ModulHelper.animSymTimeline[timelineKey] = timelineInfo;
            }
        }
    }
};
ModulHelper.changeScene = function() {
    ModulHelper.mChangeScene = true;
};
ModulHelper.prevContent = function(_animType, _animDur) {
    if (ModulHelper.mParent.Config.useSubtitle) {
        ModulHelper.resetSubtitle();
    }
    var animDur = 1.1;
    var animType = 3;
    var listAnimType = [ModulHelper.mhypeDoc.kSceneTransitionInstant,ModulHelper.mhypeDoc.kSceneTransitionCrossfade,ModulHelper.mhypeDoc.kSceneTransitionSwap,ModulHelper.mhypeDoc.kSceneTransitionPushLeftToRight,ModulHelper.mhypeDoc.kSceneTransitionPushRightToLeft,ModulHelper.mhypeDoc.kSceneTransitionPushBottomToTop,ModulHelper.mhypeDoc.kSceneTransitionPushTopToBottom];
    if (parseInt(ModulHelper.mhypeDoc.currentSceneName().substr(6,1)) > 1) {
        if (_animType != null && _animType != undefined && _animType != 4) {
            animType = _animType;
        }
        if (animType == 0) {
            animDur = 0;
        }
        if (_animDur != null && _animDur != undefined && _animDur != 1.1) {
            animDur = _animDur;
        }
        ModulHelper.changeScene();
        ModulHelper.mhypeDoc.showSceneNamed('scene_' + (parseInt(ModulHelper.mhypeDoc.currentSceneName().substr(6,1)) - 1), listAnimType[animType], animDur);
    } else {
        ModulHelper.mParent.Main.prevContent();
    }
};
ModulHelper.nextContent = function(_animType, _animDur) {
    if (ModulHelper.mParent.Config.useSubtitle) {
        ModulHelper.resetSubtitle();
    }
    var animDur = 1.1;
    var animType = 4;
    var listAnimType = [ModulHelper.mhypeDoc.kSceneTransitionInstant,ModulHelper.mhypeDoc.kSceneTransitionCrossfade,ModulHelper.mhypeDoc.kSceneTransitionSwap,ModulHelper.mhypeDoc.kSceneTransitionPushLeftToRight,ModulHelper.mhypeDoc.kSceneTransitionPushRightToLeft,ModulHelper.mhypeDoc.kSceneTransitionPushBottomToTop,ModulHelper.mhypeDoc.kSceneTransitionPushTopToBottom];
    if (parseInt(ModulHelper.mhypeDoc.currentSceneName().substr(6,1)) < parseInt(ModulHelper.mhypeDoc.sceneNames().length)) {
        if (_animType != null && _animType != undefined && _animType != 4) {
            animType = _animType;
        }
        if (animType == 0) {
            animDur = 0;
        }
        if (_animDur != null && _animDur != undefined && _animDur != 1.1) {
            animDur = _animDur;
        }
        ModulHelper.changeScene();
        ModulHelper.mhypeDoc.showSceneNamed('scene_' + (parseInt(ModulHelper.mhypeDoc.currentSceneName().substr(6,1)) + 1), listAnimType[animType], animDur);
    } else {
        ModulHelper.mParent.ScormManager.updateLms();
        ModulHelper.mParent.Main.nextContent();
    }
};
ModulHelper.moveToContent = function(_strContent, _updateLms) {
    var updateLms = false;
    if (_updateLms !== null && _updateLms != undefined) {
        updateLms = _updateLms;
    }
    if (updateLms) {
        ModulHelper.mParent.ScormManager.updateLms();
    }
    ModulHelper.mParent.Main.moveToContent(_strContent);
};
ModulHelper.openPDF = function(_pdfFileName) {
    ModulHelper.mParent.PopupManager.openPDFFrame(_pdfFileName);
};
ModulHelper.playBacksound = function(_id) {
    ModulHelper.mParent.AudioManager.playBacksound(_id);
};
ModulHelper.stopBacksound = function() {
    ModulHelper.mParent.AudioManager.stopBacksound();
};
ModulHelper.playSoundFX = function(_id) {
    ModulHelper.mParent.AudioManager.playSoundFX(_id);
};
ModulHelper.stopSoundFX = function(_id) {
    ModulHelper.mParent.AudioManager.stopSoundFX(_id);
};
ModulHelper.playAudio = function(_id, _useContinue, _symID, _callback) {
    ModulHelper.mParent.AudioManager.playAudio(_id, _useContinue, _symID, _callback);
};
ModulHelper.stopAudio = function() {
    ModulHelper.mParent.AudioManager.stopAudio();
};
ModulHelper.setSubtitle = function(_id) {
    ModulHelper.mParent.PopupManager.updateSubtitleText(_id);
};
ModulHelper.resetSubtitle = function() {
    ModulHelper.mParent.PopupManager.resetSubtitleText();
};
ModulHelper.updateLms = function() {
    ModulHelper.mParent.ScormManager.updateLms();
};
ModulHelper.updateChapLms = function() {
    ModulHelper.mParent.ScormManager.updateChapLms();
};
if("HYPE_eventListeners" in document === false) {
    window.HYPE_eventListeners = Array();
}
window.HYPE_eventListeners.push({"type":"HypeDocumentLoad", "callback":ModulHelper.docLoaded});
window.HYPE_eventListeners.push({"type":"HypeSceneLoad", "callback":ModulHelper.sceneLoaded});
window.HYPE_eventListeners.push({"type":"HypeSceneUnload", "callback":ModulHelper.sceneUnloaded});
window.HYPE_eventListeners.push({"type":"HypeLayoutRequest", "callback":ModulHelper.layoutChange});