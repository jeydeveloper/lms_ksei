/////////////////////////////////////////////////////////
//MiscHelper.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize MiscHelper
var MiscHelper = {
    mParent: parent,
    mhypeDoc: null,
    mChangeScene: false,
    layoutType: parent.Config.layoutType,
    animTimeline: {},
    animSymTimeline: {},
    contentSymbol: []
};
MiscHelper.docLoaded = function(hypeDocument, element, event) {
    MiscHelper.mhypeDoc = hypeDocument;
    window.myHypeContainerId = hypeDocument.documentId();
    if (MiscHelper.isScalePossible()) {
        $('#' + window.myHypeContainerId).css({
            '-moz-transform-origin': '0% 0%',
            '-webkit-transform-origin': '0% 0%',
            '-ms-transform-origin': '0% 0%',
            '-o-transform-origin': '0% 0%',
            'transform-origin': '0% 0%',
            margin: 0
        });
        MiscHelper.scaleSite();
        $(window).resize(function() {
            MiscHelper.scaleSite();
        });
    }
    MiscHelper.mhypeDoc.currSceneElem = function() {
        var hc = document.getElementById(hypeDocument.documentId());
        var sa = hc.getElementsByClassName("HYPE_scene");
        for (i = 0; i < sa.length; i++) {
            if (sa[i].style.display === "block") return sa[i];
        }
        return "body";
    }
    return true;
};
MiscHelper.sceneLoaded = function(hypeDocument, event) {
    MiscHelper.scaleSite();
    MiscHelper.loadContent();
};
MiscHelper.sceneUnloaded = function(hypeDocument, element, event) {
    MiscHelper.unloadedContent();
};
MiscHelper.layoutChange = function(hypeDocument, element, event) {
    if (MiscHelper.layoutType !=0) {
        return "layout_" + MiscHelper.mParent.Config.breakIdx;
    }
};
MiscHelper.isScalePossible = function() {
    can = 'MozTransform' in document.body.style;
    if(!can) can = 'webkitTransform' in document.body.style;
    if(!can) can = 'msTransform' in document.body.style;
    if(!can) can = 'OTransform' in document.body.style;
    if(!can) can = 'transform' in document.body.style;
    if(!can) can = 'Transform' in document.body.style;
    return can;
};
MiscHelper.scaleSite = function() {
    var hypeContainer = $('#' + window.myHypeContainerId);
    var containerWidth = hypeContainer.width();
    var containerHeight = hypeContainer.height();
    var parentWidth = MiscHelper.mParent.document.getElementById('mod-wrapper').offsetWidth;
    var parentHeight = MiscHelper.mParent.document.getElementById('mod-wrapper').offsetHeight;
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
MiscHelper.loadContent = function() {
    var i, j;
    MiscHelper.contentSymbol = [];
    var allID = document.querySelectorAll('[id]');
    Array.prototype.forEach.call( allID, function( el, sy ) {
        if (MiscHelper.mhypeDoc.getSymbolInstanceById(el.id) != null && MiscHelper.mhypeDoc.getSymbolInstanceById(el.id) != undefined) {
            MiscHelper.contentSymbol.push(MiscHelper.mhypeDoc.getSymbolInstanceById(el.id));
        }
    });
    switch (MiscHelper.mhypeDoc.documentName()) {
        case "help" :
        {
            MiscHelper.mParent.Config.hypeHelp = MiscHelper.mhypeDoc;
        }
        break;
        case "indexlist" :
        {
            MiscHelper.mParent.Config.hypeIndexL = MiscHelper.mhypeDoc;
            MiscHelper.mParent.PopupManager.initIndexList();
        }
        break;
        case "glossary" :
        {
            MiscHelper.mParent.Config.hypeGloss = MiscHelper.mhypeDoc;
        }
        break;
        case "volume" :
        {
            MiscHelper.mParent.Config.hypeVolume = MiscHelper.mhypeDoc;
        }
        break;
        case "screen" :
        {
            MiscHelper.mParent.Config.hypeScreen = MiscHelper.mhypeDoc;
        }
        break;
    }
    MiscHelper.mhypeDoc.setParentBGColor = function() {
        setTimeout(function() {
            MiscHelper.mParent.EffectManager.changeBGColor($(MiscHelper.mhypeDoc.currSceneElem()).css("background-color"));
        }, 100);
    };
    MiscHelper.loadedLayout(MiscHelper.mhypeDoc);
};
MiscHelper.loadedLayout = function() {
    if (MiscHelper.layoutType == 0) return;
    var i;
    if (MiscHelper.mChangeScene) {
        MiscHelper.mChangeScene = false;
    } else {
        var timelineNames = ["Main Timeline"];
        for(i = 0; i < timelineNames.length; i++) {
            var timelineName = timelineNames[i];
            var timelineKey = "timeline_" + MiscHelper.mhypeDoc.currentSceneName() + "_" + timelineName;
            var timelineInfo = MiscHelper.animTimeline[timelineKey];
            if(timelineInfo != null) {
                MiscHelper.mhypeDoc.goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
                if(timelineInfo["state"] == true) {
                    MiscHelper.mhypeDoc.continueTimelineNamed(timelineName, timelineInfo["direction"]);
                } else {
                    MiscHelper.mhypeDoc.pauseTimelineNamed(timelineName);
                }
            }
        }
        for(i = 0; i < MiscHelper.contentSymbol.length; i++) {
            for (j = 0; j < timelineNames.length; j++) {
                var timelineName = timelineNames[i];
                var timelineKey = "timeline_" + MiscHelper.contentSymbol[i].symbolName() + "_" + timelineName;
                var timelineInfo = MiscHelper.animSymTimeline[timelineKey];
                if(timelineInfo != null) {
                    MiscHelper.contentSymbol[i].goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
                    if(timelineInfo["state"] == true) {
                        MiscHelper.contentSymbol[i].continueTimelineNamed(timelineName, timelineInfo["direction"]);
                    } else {
                        MiscHelper.contentSymbol[i].pauseTimelineNamed(timelineName);
                    }
                }
            }
        }
    }
};
MiscHelper.unloadedContent = function() {
    if (MiscHelper.layoutType == 0) return;
    var i, j;
    if (!MiscHelper.mChangeScene) {
        var timelineNames = ["Main Timeline"];
		for(i = 0; i < timelineNames.length; i++) {
			var timelineName = timelineNames[i];
			var timelineKey = "timeline_" + MiscHelper.mhypeDoc.currentSceneName() + "_" + timelineName;
			var timelineInfo = {};
			timelineInfo["time"] = MiscHelper.mhypeDoc.currentTimeInTimelineNamed(timelineName);
			timelineInfo["direction"] = MiscHelper.mhypeDoc.currentDirectionForTimelineNamed(timelineName);
			timelineInfo["state"] = MiscHelper.mhypeDoc.isPlayingTimelineNamed(timelineName);
			MiscHelper.animTimeline[timelineKey] = timelineInfo;
		}
        for(i = 0; i < MiscHelper.contentSymbol.length; i++) {
            for (j = 0; j < timelineNames.length; j++) {
                var timelineName = timelineNames[i];
                var timelineKey = "timeline_" + MiscHelper.contentSymbol[i].symbolName() + "_" + timelineName;
			    var timelineInfo = {};
                timelineInfo["time"] = MiscHelper.contentSymbol[i].currentTimeInTimelineNamed(timelineName);
                timelineInfo["direction"] = MiscHelper.contentSymbol[i].currentDirectionForTimelineNamed(timelineName);
                timelineInfo["state"] = MiscHelper.contentSymbol[i].isPlayingTimelineNamed(timelineName);
                MiscHelper.animSymTimeline[timelineKey] = timelineInfo;
            }
        }
    }
};
MiscHelper.changeScene = function() {
    MiscHelper.mChangeScene = true;
};
MiscHelper.closeWindow = function() {
    switch (MiscHelper.mhypeDoc.documentName()) {
        case "screen":
        {
            MiscHelper.mParent.PopupManager.screenHide();
        }
        break;
        case "help":
        case "indexlist":
        case "glossary":
        case "volume":
        {
            MiscHelper.mParent.PopupManager.popupHide(MiscHelper.mhypeDoc.documentName());
        }
        break;
    }
};
MiscHelper.clickedIndexList = function(_str) {
    var idx = parseInt(_str.substr(10,2));
    MiscHelper.mParent.PopupManager.selectIndex(idx);
};
MiscHelper.getBreakID = function() {
    return MiscHelper.mParent.Config.breakIdx;
};
MiscHelper.setAudioVolume = function(_vol, _allAudio) {
    MiscHelper.mParent.AudioManager.setAudioVolume(_vol, _allAudio);
};
MiscHelper.muteAllAudio = function(_state) {
    MiscHelper.mParent.AudioManager.muteAllAudio(_state);
};
if("HYPE_eventListeners" in document === false) {
    window.HYPE_eventListeners = Array();
}
window.HYPE_eventListeners.push({"type":"HypeDocumentLoad", "callback":MiscHelper.docLoaded});
window.HYPE_eventListeners.push({"type":"HypeSceneLoad", "callback":MiscHelper.sceneLoaded});
window.HYPE_eventListeners.push({"type":"HypeSceneUnload", "callback":MiscHelper.sceneUnloaded});
window.HYPE_eventListeners.push({"type":"HypeLayoutRequest", "callback":MiscHelper.layoutChange});