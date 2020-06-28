/////////////////////////////////////////////////////////
//EffectManager.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Init EffectManager
var EffectManager = {
    effectMenuStarting: false,
};
EffectManager.horizontalSlideEff = function() {
    var maxcW = document.getElementById('mod-wrapper').offsetWidth;
    var mincW = 0 - maxcW;
	if(Config.bNextContent == true) {
		if(Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {left: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		} else if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {left: 0, ease:Power1.easeInOut});
		} else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {left: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		}
	} else {
		if(Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {left: 0, ease:Power1.easeInOut});
		} else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {left: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		} else if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {left: mincW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {left: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {left: maxcW, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		}
	}
    debugMsg("sliding effect done");
};
EffectManager.verticalSlideEff = function() {
    var maxcH = document.getElementById('mod-wrapper').offsetHeight;
    var mincH = 0 - maxcH;
    if(Config.bNextContent == true) {
		if(Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {top: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		} else if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {top: 0, ease:Power1.easeInOut});
		} else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {top: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		}
	} else {
		if(Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {top: 0, ease:Power1.easeInOut});
		} else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {top: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		} else if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {top: mincH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {top: 0, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {top: maxcH, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
		}
	}
    debugMsg("sliding effect done");
};
EffectManager.fadingSlideEff = function() {
    if (Config.bNextContent) {
        if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        } else if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {opacity: 1, ease:Power1.easeInOut});
        } else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        }
    } else {
        if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {opacity: 1, ease:Power1.easeInOut});
        } else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        } else if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        }
    }
    debugMsg("sliding effect done");
};
EffectManager.zoomingSlideEff = function() {
    if (Config.bNextContent) {
        if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        } else if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
        } else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        }
    } else {
        if (Config.frameObj == 3) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
        } else if (Config.frameObj == 1) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content2F.src = "about:blank"; }});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        } else if (Config.frameObj == 2) {
            TweenMax.to(Config.content1F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content1F.src = "about:blank"; }});
            TweenMax.to(Config.content2F, 1.1, {transformOrigin:"50% 50%", scale: 1, opacity: 1, ease:Power1.easeInOut});
            TweenMax.to(Config.content3F, 1.1, {transformOrigin:"50% 50%", scale: 1.2, opacity: 0, display: 'none', ease:Power1.easeInOut, onComplete: function() { Config.content3F.src = "about:blank"; }});
        }
    }
    debugMsg("sliding effect done");
};
EffectManager.changeBGColor = function(_color) {
    if (!Config.dynamicBGColor) return;
    if (_color != "") {
        TweenMax.to(document.getElementsByTagName("BODY")[0], 1.1, { backgroundColor: _color, ease:Power1.easeInOut });
    }
};
EffectManager.popupSlideEff = function(_type) {
    var popupOpened = false;
    var popupType = -1;
    var popupFrame = null;
    var popupHype = null;
    if (_type == null || _type == undefined) return;
    switch(_type) {
        case "help":
        {
            popupOpened = Config.helpOpen;
            popupType = Config.helpType;
            popupFrame = Config.helpF;
            popupHype = Config.hypeHelp;
        }
        break;
        case "indexlist":
        {
            popupOpened = Config.indexLOpen;
            popupType = Config.indexLType;
            popupFrame = Config.indexLF;
            popupHype = Config.hypeIndexL;
        }
        break;
        case "glossary":
        {
            popupOpened = Config.glossOpen;
            popupType = Config.glossType;
            popupFrame = Config.glossF;
            popupHype = Config.hypeGloss;
        }
        break;
        case "volume":
        {
            popupOpened = Config.volumeOpen;
            popupType = null;
            popupFrame = Config.volumeF;
            popupHype = Config.hypeVolume;
        }
        break;
    }
    if (_type == "volume") {
        if (!popupOpened) {
            popupOpened = true;
            TweenMax.set(popupFrame, {display:"block"});
            TweenMax.to(popupFrame, .5, {opacity:1, onComplete: function() { popupHype.startTimelineNamed('Main Timeline', popupHype.kDirectionForward); }});
        } else {
            popupOpened = false;
            TweenMax.to(popupFrame, .5, {opacity:0, display:'none', onComplete: function() { popupHype.pauseTimelineNamed('Main Timeline'); popupHype.goToTimeInTimelineNamed(0, 'Main Timeline'); }});
        }
    } else {
        if (!popupOpened) {
            popupOpened = true;
            TweenMax.set(popupFrame, {display:"block"});
            switch (popupType) {
                case 0:
                {
                    TweenMax.to(popupFrame, .5, {opacity:1, onComplete: function() { popupHype.startTimelineNamed('Main Timeline', popupHype.kDirectionForward); }});
                }
                break;
                case 1:
                {
                    TweenMax.to(popupFrame, .5, {left:0, opacity:1, onComplete: function() { popupHype.startTimelineNamed('Main Timeline', popupHype.kDirectionForward); }});
                }
                break;
                case 2:
                {
                    var fW = document.getElementById('mod-frames').offsetWidth;
                    var pW = popupFrame.offsetWidth;
                    var showPos = fW - pW;
                    TweenMax.to(popupFrame, .5, {left:showPos, opacity:1, onComplete: function() { popupHype.startTimelineNamed('Main Timeline', popupHype.kDirectionForward); }});
                }
                break;
            }
        } else {
            popupOpened = false;
            switch (popupType) {
                case 0:
                {
                    TweenMax.to(popupFrame, .5, {opacity:0, display:'none', onComplete: function() { popupHype.pauseTimelineNamed('Main Timeline'); popupHype.goToTimeInTimelineNamed(0, 'Main Timeline'); }});
                }
                break;
                case 1:
                {
                    var pW = popupFrame.offsetWidth;
                    var hidePos = 0 - ((pW - (pW * 2)) - 50);
                    TweenMax.to(popupFrame, .5, {left:hidePos, opacity:0, display:'none', onComplete: function() { popupHype.pauseTimelineNamed('Main Timeline'); popupHype.goToTimeInTimelineNamed(0, 'Main Timeline'); }});
                }
                break;
                case 2:
                {
                    var fW = document.getElementById('mod-frames').offsetWidth;
                    var pW = popupFrame.offsetWidth;
                    var hidePos = fW + (pW + 50);
                    TweenMax.to(popupFrame, .5, {left:hidePos, opacity:0, display:'none', onComplete: function() { popupHype.pauseTimelineNamed('Main Timeline'); popupHype.goToTimeInTimelineNamed(0, 'Main Timeline'); }});
                }
                break;
            }
        }
    }
    switch(_type) {
        case "help":
        {
            Config.helpOpen = popupOpened;
        }
        break;
        case "indexlist":
        {
            Config.indexLOpen = popupOpened;
        }
        break;
        case "glossary":
        {
            Config.glossOpen = popupOpened;
        }
        break;
        case "volume":
        {
            Config.volumeOpen = popupOpened;
        }
        break;
    }
};
EffectManager.menuAnim = function(_state) {
    EffectManager.effectMenuStarting = true;
    switch(Config.navType) {
        case 0:
        {
            if (_state) {
                TweenMax.to(document.getElementById('ico-open-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('ico-close-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { width: (Config.navWidth + 5) + "px", ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { opacity: 1, ease:Power1.easeInOut });
            } else {
                TweenMax.to(document.getElementById('ico-open-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('ico-close-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { width:"60px", ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { opacity: 0, ease:Power1.easeInOut });
            }
            TweenMax.delayedCall(0.5, function() { EffectManager.effectMenuStarting = false; });
        }
        break;
        case 1:
        {
            var navPosXOpen = 0, navPosXClose = -250;
            if (_state) {
                if (!Config.dynamicBGColor) {
                    navPosXOpen = parseInt(document.getElementById("mod-header").offsetLeft);
                }
                TweenMax.to(document.getElementById('ico-open-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('ico-close-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { left:navPosXOpen + "px", backgroundColor: '#FFFFFF', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { opacity: 1, ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-title-' + Config.navType), 0.3, { width: '195px', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('nav-head-' + Config.navType), 0.3, { width: '250px', ease:Power1.easeInOut });
            } else {
                if (!Config.dynamicBGColor) {
                    navPosXClose = parseInt(document.getElementById("mod-header").offsetLeft) - 250;
                }
                TweenMax.to(document.getElementById('ico-open-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('ico-close-' + Config.navType), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { left:navPosXClose + "px", backgroundColor: 'none', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { opacity: 0, ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('box-menu-title-' + Config.navType), 0.3, { width: '250px', ease:Power1.easeInOut });
                TweenMax.to(document.getElementById('nav-head-' + Config.navType), 0.3, { width: '300px', ease:Power1.easeInOut });
            }
            TweenMax.delayedCall(0.5, function() { EffectManager.effectMenuStarting = false; });
        }
        break;
        case 2:
        {
            if (_state) {
                TweenMax.to(document.getElementById('btn-menu'), 0.3, { rotation: 0, transformOrigin: "50% 50%", ease: Back.easeOut});
                TweenMax.to(document.getElementById('box-menu-' + Config.navType + '-bg'), 0.3, { rotation: 0, transformOrigin: "50% 50%", opacity: 1, ease: Back.easeOut}); 
                TweenMax.delayedCall(0.15, function() {
                    TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { rotation: 0, transformOrigin: "50% 50%", opacity: 1, ease: Back.easeOut});
                });
                TweenMax.delayedCall(0.7, function() {
                    TweenMax.set(document.getElementById("btn-menu"), { rotation: 360, transformOrigin: "50% 50%"});
                    TweenMax.set(document.getElementById("box-menu-2-bg"), { rotation: 360, transformOrigin: "50% 50%"});
                    TweenMax.set(document.getElementById("box-menu-2"), { rotation: 360, transformOrigin: "50% 50%"});
                });
            } else {
                TweenMax.to(document.getElementById('btn-menu'), 0.3, { rotation: 180, transformOrigin: "50% 50%", ease: Back.easeOut});
                TweenMax.to(document.getElementById('box-menu-' + Config.navType), 0.3, { rotation: 180, transformOrigin: "50% 50%", opacity: 0, ease: Back.easeOut});
                TweenMax.delayedCall(0.15, function() {
                    TweenMax.to(document.getElementById('box-menu-' + Config.navType + '-bg'), 0.3, { rotation: 180, transformOrigin: "50% 50%", ease: Back.easeOut, opacity: 0});
                });
            }
            TweenMax.delayedCall(0.8, function() { EffectManager.effectMenuStarting = false; });
        }
        break;
    }
};