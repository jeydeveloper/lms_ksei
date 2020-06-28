/////////////////////////////////////////////////////////
//Main.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Init Frames DOM element
Config.screenF = document.getElementById('screenF');
Config.helpF = document.getElementById('helpF');
Config.indexLF = document.getElementById('indexListF');
Config.glossF = document.getElementById('glossaryF');
Config.volumeF = document.getElementById('audioF');
Config.content1F = document.getElementById('content-1F');
Config.content2F = document.getElementById('content-2F');
Config.content3F = document.getElementById('content-3F');
Config.preloaderF = document.getElementById('loading');
/////////////////////////////////////////////////////////
//Init First Launch
var Main = {};
Main.hidePreload = function() {
    Config.preloaderState = false;
    TweenMax.to(Config.preloaderF, 0.3, {opacity:0,display:'none'});
};
Main.showPreload = function() {
    Config.preloaderState = true;
    TweenMax.set(Config.preloaderF, {display:"block"});
    TweenMax.to(Config.preloaderF, 0.3, {opacity:1});
};
Main.setFramesFirstTime = function() {
    //Init Main/Content Frame
    Config.frameObj = 1;
    Config.content1F.src = "about:blank";
    Config.content2F.src = "about:blank";
    Config.content3F.src = "about:blank";
    TweenMax.set(Config.content2F, {display:'none'});
    TweenMax.set(Config.content3F, {display:'none'});
    switch(Config.slidingType) {
        case 0:
        {
            var cW = document.getElementById('mod-wrapper').offsetWidth;
            Config.content1F.style.left = "0px";
            Config.content2F.style.left = cW + "px";
            Config.content3F.style.left = "-" + cW + "px";
            Config.content1F.style.zIndex = "0";
            Config.content2F.style.zIndex = "-1";
            Config.content3F.style.zIndex = "1";
        }
        break;
        case 1:
        {
            var cH = document.getElementById('mod-wrapper').offsetHeight;
            Config.content1F.style.top = "0px";
            Config.content2F.style.top = cH + "px";
            Config.content3F.style.top = "-" + cH + "px";
            Config.content1F.style.zIndex = "0";
            Config.content2F.style.zIndex = "-1";
            Config.content3F.style.zIndex = "1";
        }
        break;
        case 2:
        {
            Config.content1F.style.top = "0px";
            Config.content2F.style.top = "0px";
            Config.content3F.style.top = "0px";
            Config.content1F.style.left = "0px";
            Config.content2F.style.left = "0px";
            Config.content3F.style.left = "0px";
            Config.content1F.style.zIndex = "1";
            Config.content2F.style.zIndex = "0";
            Config.content3F.style.zIndex = "-1";
            Config.content1F.style.opacity = "1";
            Config.content2F.style.opacity = "0";
            Config.content3F.style.opacity = "0";
        }
        break;
        case 3:
        {
            Config.content1F.style.top = "0px";
            Config.content2F.style.top = "0px";
            Config.content3F.style.top = "0px";
            Config.content1F.style.left = "0px";
            Config.content2F.style.left = "0px";
            Config.content3F.style.left = "0px";
            Config.content1F.style.zIndex = "1";
            Config.content2F.style.zIndex = "0";
            Config.content3F.style.zIndex = "-1";
            TweenMax.set(Config.content1F, {transformOrigin:"50% 50%", opacity: 1, scale: 1});
            TweenMax.set(Config.content2F, {transformOrigin:"50% 50%", opacity: 0, scale: 1.2});
            TweenMax.set(Config.content3F, {transformOrigin:"50% 50%", opacity: 0, scale: 1.2});
        }
        break;
    }
    debugMsg("Set content frame for first time, slidingType : " + Config.slidingType);
    //Init Help Frame
    Config.helpF.style.display = 'none';
    if (Config.hypeHelp != null) {
        Config.hypeHelp.pauseTimelineNamed('Main Timeline');
        Config.hypeHelp.goToTimeInTimelineNamed(0, 'Main Timeline');
    }
    switch(Config.helpType) {
        case 0:
        {
            TweenMax.set(Config.helpF, {opacity:0});
        }
        break;
        case 1:
        {
            var hW = Config.helpF.offsetWidth;
            var finalL = 0 - (hW - (hW * 2)) - 50;
            Config.helpF.style.left = finalL + "px";
            TweenMax.set(Config.helpF, {opacity:0});
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var hW = Config.helpF.offsetWidth;
            var finalL = fW + (hW + 50);
            Config.helpF.style.left = finalL + "px";
            TweenMax.set(Config.helpF, {opacity:0});
        }
        break;
    }
    debugMsg("Set help frame for first time, helpType : " + Config.helpType);
    //Init Index List Frame
    Config.indexLF.style.display = 'none';
    if (Config.hypeIndexL != null) {
        Config.hypeIndexL.pauseTimelineNamed('Main Timeline');
        Config.hypeIndexL.goToTimeInTimelineNamed(0, 'Main Timeline');
    }
    switch(Config.indexLType) {
        case 0:
        {
            TweenMax.set(Config.indexLF, {opacity:0});
        }
        break;
        case 1:
        {
            var iW = Config.indexLF.offsetWidth;
            var finalL = 0 - (iW - (iW * 2)) - 50;
            Config.indexLF.style.left = finalL + "px";
            TweenMax.set(Config.indexLF, {opacity:0});
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var iW = Config.indexLF.offsetWidth;
            var finalL = fW + (iW + 50);
            Config.indexLF.style.left = finalL + "px";
            TweenMax.set(Config.indexLF, {opacity:0});
        }
        break;
    }
    debugMsg("Set index list frame for first time, indexLType : " + Config.indexLType);
    //Init Glossary Frame
    Config.glossF.style.display = 'none';
    if (Config.hypeGloss != null) {
        Config.hypeGloss.pauseTimelineNamed('Main Timeline');
        Config.hypeGloss.goToTimeInTimelineNamed(0, 'Main Timeline');
    }
    switch(Config.glossType) {
        case 0:
        {
            TweenMax.set(Config.glossF, {opacity:0});
        }
        break;
        case 1:
        {
            var gW = Config.glossF.offsetWidth;
            var finalL = 0 - (gW - (gW * 2)) - 50;
            Config.glossF.style.left = finalL + "px";
            TweenMax.set(Config.glossF, {opacity:0});
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var gW = Config.glossF.offsetWidth;
            var finalL = fW + (gW + 50);
            Config.glossF.style.left = finalL + "px";
            TweenMax.set(Config.glossF, {opacity:0});
        }
        break;
    }
    debugMsg("Set glossary frame for first time, glossType : " + Config.glossType);
    //Init Help Frame
    Config.volumeF.style.display = 'none';
    TweenMax.set(Config.volumeF, {opacity:0});
    debugMsg("Set volume frame for first time");
};
Main.resetFrame = function() {
    if (Config.frameObj == 1) {
        Config.content2F.src = "about:blank";
        Config.content3F.src = "about:blank";
    } else if (Config.frameObj == 2) {
        Config.content1F.src = "about:blank";
        Config.content3F.src = "about:blank";
    } else if (Config.frameObj == 3) {
        Config.content1F.src = "about:blank";
        Config.content2F.src = "about:blank";
    }
    debugMsg("Reset content frame");
};
Main.startSlidingEff = function() {
    Main.hidePreload();
    if (Config.firstLoad) {
        Config.firstLoad = false;
        return;
    }
    if (Config.slidingType == 0) {
        EffectManager.horizontalSlideEff();
    } else if (Config.slidingType == 1) {
        EffectManager.verticalSlideEff();
    } else if (Config.slidingType == 2) {
        EffectManager.fadingSlideEff();
    } else if (Config.slidingType == 3) {
        EffectManager.zoomingSlideEff();
    }
    TweenMax.delayedCall(1.1, Main.resetFrame);
};
Main.setNaviButton = function() {
    if (!Config.useHelpWindow && !Config.useIndexLWindow && !Config.useVolumeWindow && !Config.useGlossWindow) return;
    //Init Navigation/Menu Button
    document.getElementById('mod-navi').className = 'nav-type-' + Config.navType;
    switch(Config.navType) {
        case 0:
        {
            var strNavDesign = "";
            strNavDesign = '<div id="btn-menu" class="btn-menu-' + Config.navType + ' full-height"><img id="ico-open-' + Config.navType + '" src="data/image/setting.png"><img id="ico-close-' + Config.navType + '" src="data/image/close_setting.png"></div><div id="box-menu-' + Config.navType + '" class="full-height"><div id="container-menu-' + Config.navType + '"><div class="row nomargin-nopadding">';
            var countCol = 0;
            if (Config.useIndexLWindow) {
                countCol++;
            }
            if (Config.useHelpWindow) {
                countCol++;
            }
            if (Config.useGlossWindow) {
                countCol++;
            }
            if (Config.useVolumeWindow) {
                countCol++;
            }
            var finalCol = 12 / countCol;
            Config.colNav = (countCol + 1);
            Config.navWidth = ((60 * Config.colNav) - 5);
            if (Config.useIndexLWindow) {
                strNavDesign += '<div class="col-xs-' + finalCol + ' col-padding"><div class="box-ico-menu"><img class="ico-menu" src="data/image/indexlist.png"></div><div id="btn-indexlist" class="btn-ico-menu-' + Config.navType + '"></div></div>';
            }
            if (Config.useGlossWindow) {
                strNavDesign += '<div class="col-xs-' + finalCol + ' col-padding"><div class="box-ico-menu"><img class="ico-menu" src="data/image/glossary.png"></div><div id="btn-glossary" class="btn-ico-menu-' + Config.navType + '"></div></div>';
            }
            if (Config.useVolumeWindow) {
                strNavDesign += '<div class="col-xs-' + finalCol + ' col-padding"><div class="box-ico-menu"><img class="ico-menu" src="data/image/volume.png"></div><div id="btn-volume" class="btn-ico-menu-' + Config.navType + '"></div></div>';
            }
            if (Config.useHelpWindow) {
                strNavDesign += '<div class="col-xs-' + finalCol + ' col-padding"><div class="box-ico-menu"><img class="ico-menu" src="data/image/help.png"></div><div id="btn-help" class="btn-ico-menu-' + Config.navType + '"></div></div>';
            }
            strNavDesign += '</div></div></div>';
            document.getElementById('mod-navi').innerHTML = strNavDesign;
            document.getElementById('box-menu-' + Config.navType).style.width = Config.navWidth + 'px';
            TweenMax.set(document.getElementById('ico-open-' + Config.navType), { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block' });
            TweenMax.set(document.getElementById('ico-close-' + Config.navType), { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none' });
        }
        break;
        case 1:
        {
            var strNavDesign = "";
            strNavDesign = '<div><div id="nav-head-' + Config.navType + '"><div id="box-menu-title-' + Config.navType + '" class="nomargin-nopadding"><div class="nav-text"><p class="nomargin-nopadding">Menu</p></div></div><div id="box-menu-btn-' + Config.navType + '" class="nomargin-nopadding"><div id="btn-menu" class="btn-menu-' + Config.navType + '"><img id="ico-open-' + Config.navType + '" src="data/image/setting.png"><img id="ico-close-' + Config.navType + '" src="data/image/close_setting.png"></div></div></div><div class="nav-content"><div id="box-menu-' + Config.navType + '" class="full-height"><div id="container-menu-' + Config.navType + '">';
            var countCol = 0;
            if (Config.useIndexLWindow) {
                countCol++;
            }
            if (Config.useHelpWindow) {
                countCol++;
            }
            if (Config.useGlossWindow) {
                countCol++;
            }
            if (Config.useVolumeWindow) {
                countCol++;
            }
            Config.colNav = countCol;
            if (Config.useIndexLWindow) {
                strNavDesign += '<div id="btn-indexlist" class="col-nav-' + Config.navType + ' col-padding"><div class="row nomargin-nopadding"><div class="col-xs-2 nomargin-nopadding"><div class="box-ico-menu-' + Config.navType + '"><img class="ico-menu-' + Config.navType + '" src="data/image/indexlist.png"></div></div><div class="col-xs-10 nomargin-nopadding"><div class="nav-text"><p class="nomargin-nopadding">Index List</p></div></div></div></div>';
            }
            if (Config.useGlossWindow) {
                strNavDesign += '<div id="btn-glossary" class="col-nav-' + Config.navType + ' col-padding"><div class="row nomargin-nopadding"><div class="col-xs-2 nomargin-nopadding"><div class="box-ico-menu-' + Config.navType + '"><img class="ico-menu-' + Config.navType + '" src="data/image/glossary.png"></div></div><div class="col-xs-10 nomargin-nopadding"><div class="nav-text"><p class="nomargin-nopadding">Glossary</p></div></div></div></div>';
            }
            if (Config.useVolumeWindow) {
                strNavDesign += '<div id="btn-volume" class="col-nav-' + Config.navType + ' col-padding"><div class="row nomargin-nopadding"><div class="col-xs-2 nomargin-nopadding"><div class="box-ico-menu-' + Config.navType + '"><img class="ico-menu-' + Config.navType + '" src="data/image/volume.png"></div></div><div class="col-xs-10 nomargin-nopadding"><div class="nav-text"><p class="nomargin-nopadding">Volume</p></div></div></div></div>';
            }
            if (Config.useHelpWindow) {
                strNavDesign += '<div id="btn-help" class="col-nav-' + Config.navType + ' col-padding"><div class="row nomargin-nopadding"><div class="col-xs-2 nomargin-nopadding"><div class="box-ico-menu-' + Config.navType + '"><img class="ico-menu-' + Config.navType + '" src="data/image/help.png"></div></div><div class="col-xs-10 nomargin-nopadding"><div class="nav-text"><p class="nomargin-nopadding">Help</p></div></div></div></div>';
            }
            strNavDesign += '</div></div></div>';
            document.getElementById('mod-navi').innerHTML = strNavDesign;
            TweenMax.set(document.getElementById('ico-open-' + Config.navType), { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block' });
            TweenMax.set(document.getElementById('ico-close-' + Config.navType), { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none' });
        }
        break;
        case 2:
        {
            var strNavDesign = "";
            strNavDesign = '<div id="btn-menu" class="btn-menu-2"><img src="data/image/nav_btn_2.png" /></div><div id="box-menu-2-bg"></div><div id="box-menu-2">';
            var countCol = 0;
            if (Config.useIndexLWindow) {
                countCol++;
            }
            if (Config.useHelpWindow) {
                countCol++;
            }
            if (Config.useGlossWindow) {
                countCol++;
            }
            if (Config.useVolumeWindow) {
                countCol++;
            }
            var slotBtn = [];
            var slotInden = [], i;
            switch (countCol) {
                case 4:
                {
                    slotBtn = ["btn-menu-2-0", "btn-menu-2-1", "btn-menu-2-3", "btn-menu-2-4"];
                }
                break;
                case 3:
                {
                    slotBtn = ["btn-menu-2-0", "btn-menu-2-2", "btn-menu-2-4"];
                }
                break;
                case 2:
                {
                    slotBtn = ["btn-menu-2-1", "btn-menu-2-3"];
                }
                break;
                case 1:
                {
                    slotBtn = ["btn-menu-2-2"];
                }
                break;
            }
            for (i = 0; i < countCol; i++) {
                if (Config.useIndexLWindow) {
                    if (slotInden.indexOf("index") == -1) {
                        strNavDesign += '<div id="' + slotBtn[i] + '" class="btn-ico-menu-2"><div id="btn-indexlist"><img src="data/image/indexlist.png" /></div></div>';
                        slotInden.push("index");
                        continue;
                    }
                }
                if (Config.useGlossWindow) {
                    if (slotInden.indexOf("gloss") == -1) {
                        strNavDesign += '<div id="' + slotBtn[i] + '" class="btn-ico-menu-2"><div id="btn-glossary"><img src="data/image/glossary.png" /></div></div>';
                        slotInden.push("gloss");
                        continue;
                    }
                }
                if (Config.useVolumeWindow) {
                    if (slotInden.indexOf("vol") == -1) {
                        strNavDesign += '<div id="' + slotBtn[i] + '" class="btn-ico-menu-2"><div id="btn-volume"><img src="data/image/volume.png" /></div></div>';
                        slotInden.push("vol");
                        continue;
                    }
                }
                if (Config.useHelpWindow) {
                    if (slotInden.indexOf("help") == -1) {
                        strNavDesign += '<div id="' + slotBtn[i] + '" class="btn-ico-menu-2"><div id="btn-help"><img src="data/image/help.png" /></div></div>';
                        slotInden.push("help");
                        continue;
                    }
                }
            }
            strNavDesign += '</div>';
            document.getElementById('mod-navi').innerHTML = strNavDesign;
            document.getElementById("mod-navi").style.zIndex = 3;
            LayoutManager.resettingNavigation();
        }
        break;
    }
    //Init Navigation Button
    if (document.getElementById("btn-menu") != null && document.getElementById("btn-menu") != undefined) {
        if (document.getElementById("btn-menu").addEventListener) {
            document.getElementById("btn-menu").addEventListener("click", Main.showMenu);
        } else if (document.getElementById("btn-menu").attachEvent) {
            document.getElementById("btn-menu").attachEvent("onclick", Main.showMenu);
        }
    }
    if (document.getElementById("btn-indexlist") != null && document.getElementById("btn-indexlist") != undefined) {
        if (document.getElementById("btn-indexlist").addEventListener) {
            document.getElementById("btn-indexlist").addEventListener("click", function() { PopupManager.popupShow('indexlist'); });
        } else if (document.getElementById("btn-indexlist").attachEvent) {
            document.getElementById("btn-indexlist").attachEvent("onclick", function() { PopupManager.popupShow('indexlist'); });
        }
    }
    if (document.getElementById("btn-glossary") != null && document.getElementById("btn-glossary") != undefined) {
        if (document.getElementById("btn-glossary").addEventListener) {
            document.getElementById("btn-glossary").addEventListener("click", function() { PopupManager.popupShow('glossary'); });
        } else if (document.getElementById("btn-glossary").attachEvent) {
            document.getElementById("btn-glossary").attachEvent("onclick", function() { PopupManager.popupShow('glossary'); });
        }
    }
    if (document.getElementById("btn-volume") != null && document.getElementById("btn-volume") != undefined) {
        if (document.getElementById("btn-volume").addEventListener) {
            document.getElementById("btn-volume").addEventListener("click", function() { PopupManager.popupShow('volume'); });
        } else if (document.getElementById("btn-volume").attachEvent) {
            document.getElementById("btn-volume").attachEvent("onclick", function() { PopupManager.popupShow('volume'); });
        }
    }
    if (document.getElementById("btn-help") != null && document.getElementById("btn-help") != undefined) {
        if (document.getElementById("btn-help").addEventListener) {
            document.getElementById("btn-help").addEventListener("click", function() { PopupManager.popupShow('help'); });
        } else if (document.getElementById("btn-help").attachEvent) {
            document.getElementById("btn-help").attachEvent("onclick", function() { PopupManager.popupShow('help'); });
        }
    }
};
Main.showNavigation = function() {
    if (!Config.useHelpWindow && !Config.useIndexLWindow && !Config.useVolumeWindow && !Config.useGlossWindow) return;
    Config.showNavButton = true;
    switch (Config.navType) {
        case 0:
        {
            var navPosX = 0;
            if (!Config.dynamicBGColor) {
                navPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                TweenMax.set(document.getElementById("mod-navi"), { left: (navPosX - 60) + 'px' });
            }
            TweenMax.to(document.getElementById("mod-navi"), 0.3, { left: navPosX + 'px', opacity: 1, display: "block" });
        }
        break;
        case 1:
        {
            var navPosX = -250;
            if (!Config.dynamicBGColor) {
                navPosX = parseInt(document.getElementById("mod-header").offsetLeft) - 250;
                TweenMax.set(document.getElementById("mod-navi"), { left: (navPosX - 60) + 'px' });
            }
            TweenMax.to(document.getElementById("mod-navi"), 0.3, { left: navPosX + 'px', opacity: 1, display: "block" });
        }
        break;
        case 2:
        {
            TweenMax.set(document.getElementById("mod-navi"), { top: '-80px' });
            TweenMax.set(document.getElementById("btn-menu"), { rotation: 180, transformOrigin: "50% 50%"});
            TweenMax.set(document.getElementById("box-menu-2-bg"), { rotation: 180, transformOrigin: "50% 50%"});
            TweenMax.set(document.getElementById("box-menu-2"), { rotation: 180, transformOrigin: "50% 50%"});
            TweenMax.to(document.getElementById("mod-navi"), 0.3, { top: '-40px', opacity: 1, display: "block" });
        }
        break;
    }
};
Main.showMenu = function() {
    if (EffectManager.effectMenuStarting) return;
    if (!Config.menuOpen) {
        Config.menuOpen = true;
    } else {
        Config.menuOpen = false;
    }
    EffectManager.menuAnim(Config.menuOpen);
};
Main.setSubtitleDesign = function() {
    var modSub = document.getElementById('mod-subtitle');
    var boxSub = document.getElementById('box-subtitle');
    var textSub = document.getElementById('subTxt');
    var modSubBtn = document.getElementById('mod-sub-btn');
    switch (Config.subType) {
        case 0:
        {
            modSub.style.borderRadius = '5px';
            modSub.style.backgroundColor = '#ffffff';
            modSub.style.paddingTop = '5px';
            modSub.style.paddingLeft = '5px';
            boxSub.style.overflow = 'hidden';
            boxSub.style.paddingTop = '10px';
            boxSub.style.position = 'relative';
            textSub.style.height = 'auto';
            textSub.style.position = 'absolute';
            modSubBtn.style.right = '-60px';
            modSubBtn.style.bottom = '0px';
            modSubBtn.style.position = 'absolute';
            document.getElementById('btn-sub-open').src = "data/image/btn_sub_open_" + Config.subType + ".png";
            document.getElementById('btn-sub-close').src = "data/image/btn_sub_close_" + Config.subType + ".png";
            document.getElementById("btn-subtxt-prev").style.cursor = "pointer";
            document.getElementById("btn-subtxt-next").style.cursor = "pointer";
            if (document.getElementById("btn-subtxt-prev").addEventListener) {
                document.getElementById("btn-subtxt-prev").addEventListener("click", function() { PopupManager.subTextPrev(); });
            } else if (document.getElementById("btn-subtxt-prev").attachEvent) {
                document.getElementById("btn-subtxt-prev").attachEvent("onclick", function() { PopupManager.subTextPrev(); });
            }
            if (document.getElementById("btn-subtxt-next").addEventListener) {
                document.getElementById("btn-subtxt-next").addEventListener("click", function() { PopupManager.subTextNext(); });
            } else if (document.getElementById("btn-subtxt-next").attachEvent) {
                document.getElementById("btn-subtxt-next").attachEvent("onclick", function() { PopupManager.subTextNext(); });
            }
        }
        break;
        case 1:
        {
            modSub.style.background = "url('data/image/bg-sub.png')";
            modSub.style.background = 'rgba(0,0,0,0.8)';
            modSub.style.height = 'auto';
            modSub.style.paddingTop = '5px';
            modSub.style.paddingBottom = '5px';
            boxSub.style.width = '95%';
            boxSub.style.height = 'auto';
            textSub.style.margin = '0px';
            textSub.style.color = '#ffffff';
            textSub.style.textAlign = 'center';
            var btnSubY = 0 - (modSubBtn.offsetHeight + 10);
            modSubBtn.style.bottom = btnSubY + 'px';
            modSubBtn.style.right = '-60px';
            modSubBtn.style.position = 'absolute';
            modSubBtn.style.cursor = 'pointer';
            modSubBtn.style.paddingTop = '10px';
            modSubBtn.style.paddingBottom = '0px';
            document.getElementById('btn-sub-open').style.top = '10px';
            document.getElementById('btn-sub-close').style.top = '10px';
            document.getElementById('btn-sub-open').src = "data/image/btn_sub_open_" + Config.subType + ".png";
            document.getElementById('btn-sub-close').src = "data/image/btn_sub_close_" + Config.subType + ".png";
        }
        break;
    }
    TextHostManager.setAllText();
};
Main.initSubtitleBtn = function() {
    if (document.getElementById("mod-sub-btn").addEventListener) {
        document.getElementById("mod-sub-btn").addEventListener("click", function() { Main.showSubWindow(); });
    } else if (document.getElementById("mod-sub-btn").attachEvent) {
        document.getElementById("mod-sub-btn").attachEvent("onclick", function() { Main.showSubWindow(); });
    }
    switch (Config.subType) {
        case 0:
        {
            var subPosX = 0;
            if (!Config.dynamicBGColor) {
                subPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                TweenMax.set(document.getElementById("mod-sub-btn"), { right: (subPosX - 60) + 'px' });
            }
            TweenMax.to(document.getElementById("mod-sub-btn"), 0.3, { right: subPosX + 'px', opacity: 0.5, display: "block" });
            TweenMax.set($("#btn-sub-close"), { transformOrigin: "50% 50%", scale: 0 });
            Draggable.create(document.getElementById('mod-subtitle'), {
                type: 'left,top',
                onDrag: function() {
                    if (this.target.offsetTop > (Config.maxSubY - 10)) {
                        document.getElementById('mod-subtitle').style.top = (Config.maxSubY - 10) + 'px';
                    }
                    if (this.target.offsetLeft > (Config.maxSubX - 10)) {
                        document.getElementById('mod-subtitle').style.left = (Config.maxSubX - 10) + 'px';
                    }
                    if (this.target.offsetTop < 90) {
                        document.getElementById('mod-subtitle').style.top = '80px';
                    }
                    if (this.target.offsetLeft < 10) {
                        document.getElementById('mod-subtitle').style.left = '0px';
                    }
                },
                onDragEnd: function() {
                    this.target.style.zIndex = 2;
                }
            });
            Draggable.get(document.getElementById('mod-subtitle')).disable();
        }
        break;
        case 1:
        {
            var subPosX = 0;
            if (!Config.dynamicBGColor) {
                subPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                TweenMax.set(document.getElementById("mod-sub-btn"), { right: (subPosX - 60) + 'px' });
            }
            var subBtnY = 0 - (document.getElementById("mod-sub-btn").offsetHeight + 10);
            TweenMax.set(document.getElementById("mod-sub-btn"), { bottom: subBtnY + 'px' });
            TweenMax.to(document.getElementById("mod-sub-btn"), 0.3, { bottom: '0px', right: subPosX + 'px', opacity: 0.5, display: "block" });
            TweenMax.set($("#btn-sub-close"), { transformOrigin: "50% 50%", scale: 0 });
        }
        break;
    }
};
Main.showSubWindow = function() {
    if (Config.blockSubBtn || !Config.subtitleNotEmpty || Config.indexLOpen || Config.helpOpen || Config.glossOpen || Config.volumeOpen) return;
    if (Config.subType == 0) {
        if (!Config.canOpenSubWindow) return;
    }
    if (Config.showSubWindow) {
        Config.showSubWindow = false;
        PopupManager.closeSubtitleWindow();
    } else {
        Config.showSubWindow = true;
        PopupManager.openSubtitleWindow();
    }
};
Main.setModulTitle = function() {
    $("#modul-title").html("<b>" + Config.modulTitle + "</b>");
    setTimeout(function() {
        var boxH = document.getElementById('modul-title-box').offsetHeight;
        var txtH = document.getElementById('modul-title').offsetHeight;
        if (txtH < boxH) {
            document.getElementById('modul-title').style.marginTop = ((boxH - txtH) / 2) + 'px';
        } else {
            document.getElementById('modul-title').style.marginTop = '0px';
        }
    }, 110);
};
Main.setChapterTitle = function() {
    var c = Config.contentIDs[Config.page].substr(4,2);
    $("#chapter-title").html(Config.chapTitle[(c-1)]);
    setTimeout(function() {
        var boxH = document.getElementById('chapter-title-box').offsetHeight;
        var txtH = document.getElementById('chapter-title').offsetHeight;
        if (txtH < boxH) {
            document.getElementById('chapter-title').style.marginTop = ((boxH - txtH) / 2) + 'px';
        } else {
            document.getElementById('chapter-title').style.marginTop = '0px';
        }
    }, 110);
};
Main.checkIndexReady = function() {
    if (Config.useScreenWindow) {
        if (Config.hypeScreen == null) return;
    }
    if (Config.useHelpWindow) {
        if (Config.hypeHelp == null) return;
    }
    if (Config.useIndexLWindow) {
        if (Config.hypeIndexL == null) return;
    }
    if (Config.useGlossWindow) {
        if (Config.hypeGloss == null) return;
    }
    if (Config.useVolumeWindow) {
        if (Config.hypeVolume == null) return;
    }
    clearInterval(Config.intervalFunction);
    Main.initModul();
};
Main.initModul = function() {
    Main.showPreload();
    Config.firstLoad = true;
    Main.setFramesFirstTime();
    if (Config.navType == 2) {
        document.getElementById('title-box').style.paddingLeft = '30px';
    }
    Main.setModulTitle();
    Main.setNaviButton();
    if (Config.useSubtitle) {
        Main.setSubtitleDesign();
    }
    if (Config.bScorm) {
        ScormManager.scromTracking();
    } else {
        if (Config.hypeScreen != null) {
            Main.hidePreload();
            PopupManager.screenShow();
        } else {
            if (Config.hypeHelp != null) {
                Main.hidePreload();
                PopupManager.popupShow('help');
            } else {
                if (Config.useBackSound) {
                    AudioManager.initBacksound();
                }
                Main.checkLastPage();
            }
        }
    }
    if (!Config.bLock) {
        if (document.getElementById('prev-bypass').addEventListener) {
            document.getElementById('prev-bypass').addEventListener("click", Main.prevContent);
        } else if (document.getElementById('prev-bypass').attachEvent) {
            document.getElementById('prev-bypass').attachEvent("onclick", Main.prevContent);
        }
        if (document.getElementById('next-bypass').addEventListener) {
            document.getElementById('next-bypass').addEventListener("click", Main.nextContent);
        } else if (document.getElementById('next-bypass').attachEvent) {
            document.getElementById('next-bypass').attachEvent("onclick", Main.nextContent);
        }
    }
    debugMsg("Initializing");
};
Main.checkLastPage = function() {
    var lp = 0;
    if (Config.lmsConnected) {
        for (var i = 0; i < Config.lessonLocation.length; i++) {
            if (Config.lessonLocation[i] == 0) {
                break;
            }
            lp += Config.lessonLocation[i];
        }
    }
    Config.page = lp;
    if (Config.page > Config.endPage) {
        Config.page = Config.endPage;
    }
    Config.lastPage = Config.page;
    Config.checkingLastPage = true;
    if (Config.lessonStatus == 'completed') {
        Config.page = Config.currPage;
    } else {
        Config.currPage = Config.page;
        Config.currScene = Config.sceneLocation[Config.currPage];
    }
    Main.showNavigation();
    if (Config.useSubtitle) {
        Main.initSubtitleBtn();
    }
    if (Config.useAudio) {
        AudioManager.initAudio();
    } else {
        Main.loadContent("", null);
    }
};
Main.loadContent = function(_strContent, _bNext) {
    Main.showPreload();
    if (_strContent != "") {
        for (var i = 0; i < Config.contentIDs.length; i++) {
            if (Config.contentIDs[i] == _strContent) {
                Config.page = i;
                break;
            }
        }
    }
    Config.currPage = Config.page;
    if (_bNext == null) {
        Config.bNextContent = false;
        Config.content1F.src = "about:blank";
        Config.content2F.src = "about:blank";
        Config.content3F.src = "about:blank";
        switch (Config.frameObj) {
            case 1:
            {
                Config.content1F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
            }
            break;
            case 2:
            {
                Config.content2F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
            }
            break;
            case 3:
            {
                Config.content3F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
            }
            break;
        }
    } else if (_bNext == true) {
        Config.bNextContent = true;
        switch(Config.frameObj) {
            case 1:
            {
                TweenMax.set(Config.content2F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '1';
                        Config.content2F.style.zIndex = '0';
                        Config.content3F.style.zIndex = '-1';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '0';
                        Config.content2F.style.zIndex = '1';
                        Config.content3F.style.zIndex = '-1';
                    }
                    break;
                }
                Config.content2F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 2;
            }
            break;
            case 2:
            {
                TweenMax.set(Config.content3F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '-1';
                        Config.content2F.style.zIndex = '1';
                        Config.content3F.style.zIndex = '0';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '-1';
                        Config.content2F.style.zIndex = '0';
                        Config.content3F.style.zIndex = '1';
                    }
                    break;
                }
                Config.content3F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 3;
            }
            break;
            case 3:
            {
                TweenMax.set(Config.content1F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '0';
                        Config.content2F.style.zIndex = '-1';
                        Config.content3F.style.zIndex = '1';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '1';
                        Config.content2F.style.zIndex = '-1';
                        Config.content3F.style.zIndex = '0';
                    }
                    break;
                }
                Config.content1F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 1;
            }
            break;
        }
    } else if (_bNext == false) {
        Config.bNextContent = false;
        switch (Config.frameObj) {
            case 1:
            {
                TweenMax.set(Config.content3F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '0';
                        Config.content2F.style.zIndex = '-1';
                        Config.content3F.style.zIndex = '1';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '1';
                        Config.content2F.style.zIndex = '-1';
                        Config.content3F.style.zIndex = '0';
                    }
                    break;
                }
                Config.content3F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 3;
            }
            break;
            case 2:
            {
                TweenMax.set(Config.content1F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '1';
                        Config.content2F.style.zIndex = '0';
                        Config.content3F.style.zIndex = '-1';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '0';
                        Config.content2F.style.zIndex = '1';
                        Config.content3F.style.zIndex = '-1';
                    }
                    break;
                }
                Config.content1F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 1;
            }
            break;
            case 3:
            {
                TweenMax.set(Config.content2F, {display:"block"});
                switch(Config.slidingType) {
                    case 0:
                    case 1:
                    {
                        Config.content1F.style.zIndex = '-1';
                        Config.content2F.style.zIndex = '1';
                        Config.content3F.style.zIndex = '0';
                    }
                    break;
                    case 2:
                    case 3:
                    {
                        Config.content1F.style.zIndex = '-1';
                        Config.content2F.style.zIndex = '0';
                        Config.content3F.style.zIndex = '1';
                    }
                    break;
                }
                Config.content2F.src = "content/modul/" + Config.contentIDs[Config.page] + ".html";
                Config.frameObj = 2;
            }
            break;
        }
    }
    debugMsg("Load content without file name, content string : " + Config.contentIDs[Config.page] + " content page : " + Config.page);
};
Main.checkContent = function() {
    Main.setChapterTitle();
    Config.hypeContent.setParentBGColor();
    if (Config.useAudio) {
        if (Config.audio != null) {
            if (Config.layoutType == 0) {
                AudioManager.forceStopAudio();
            } else {
                if (Config.hypeContent.nextPrev) {
                    AudioManager.forceStopAudio();
                }
            }
        }
    }
};
Main.pauseContent = function() {
    if (Config.hypeContent == null) return;
    if (Config.contentPaused) return;
    var timelineName = "Main Timeline";
    var timelineKey, timelineInfo, i;
    timelineKey = "";
    timelineKey = "timeline_" + Config.hypeContent.currentSceneName() + "_" + timelineName;
    timelineInfo = {};
    timelineInfo["time"] = Config.hypeContent.currentTimeInTimelineNamed(timelineName);
    timelineInfo["direction"] = Config.hypeContent.currentDirectionForTimelineNamed(timelineName);
    timelineInfo["state"] = Config.hypeContent.isPlayingTimelineNamed(timelineName);
    Config.cAnim[timelineKey] = timelineInfo;
    Config.hypeContent.pauseTimelineNamed(timelineName);
    for (i = 0; i < Config.hypeContent.contentSymbol.length; i++) {
        timelineKey = "";
        timelineKey = "timeline_" + Config.hypeContent.contentSymbol[i].symbolName() + "_" + timelineName;
        timelineInfo = {};
        timelineInfo["time"] = Config.hypeContent.contentSymbol[i].currentTimeInTimelineNamed(timelineName);
        timelineInfo["direction"] = Config.hypeContent.contentSymbol[i].currentDirectionForTimelineNamed(timelineName);
        timelineInfo["state"] = Config.hypeContent.contentSymbol[i].isPlayingTimelineNamed(timelineName);
        Config.cSymAnim[timelineKey] = timelineInfo;
        Config.hypeContent.contentSymbol[i].pauseTimelineNamed(timelineName);
    }
    if (Config.useAudio) {
        AudioManager.pauseAudio();
    }
    if (Config.useBackSound) {
        AudioManager.pauseBacksound();
        AudioManager.pauseSoundFX();
    }
    Config.contentPaused = true;
};
Main.resumeContent = function() {
    if (Config.hypeContent == null) return;
    if (!Config.contentPaused) return;
    var timelineName = "Main Timeline";
    var timelineKey, timelineInfo, i;
    var timelineKey = "timeline_" + Config.hypeContent.currentSceneName() + "_" + timelineName;
    var timelineInfo = Config.cAnim[timelineKey];
    if (timelineInfo != null) {
        Config.hypeContent.goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
        if (timelineInfo["state"] == true) {
            Config.hypeContent.continueTimelineNamed(timelineName, timelineInfo["direction"]);
        } else {
            Config.hypeContent.pauseTimelineNamed(timelineName);
        }
    }
    for (i = 0; i < Config.hypeContent.contentSymbol.length; i++) {
        var timelineKey = "timeline_" + Config.hypeContent.contentSymbol[i].symbolName() + "_" + timelineName;
        var timelineInfo = Config.cSymAnim[timelineKey];
        if (timelineInfo != null) {
            Config.hypeContent.contentSymbol[i].goToTimeInTimelineNamed(timelineInfo["time"], timelineName);
            if (timelineInfo["state"] == true) {
                Config.hypeContent.contentSymbol[i].continueTimelineNamed(timelineName, timelineInfo["direction"]);
            } else {
                Config.hypeContent.contentSymbol[i].pauseTimelineNamed(timelineName);
            }
        }
    }
    Config.cAnim = {};
    Config.cSymAnim = {};
    if (Config.useAudio) {
        AudioManager.resumeAudio();
    }
    if (Config.useBackSound) {
        AudioManager.resumeBacksound();
        AudioManager.resumeSoundFX();
    }
    Config.contentPaused = false;
};
Main.nextContent = function() {
    if (Config.nextState) return;
    Config.nextState = true;
    Config.lastPage = Config.page;
    Config.page++;
    if (Config.page > Config.endPage) {
        Config.page = Config.endPage;
        return;
    }
    if (Config.useAudio) {
        AudioManager.initAudio();
    } else {
        Main.loadContent("", true);
    }
};
Main.prevContent = function() {
    if (Config.prevState) return;
    Config.prevState = true;
    Config.lastPage = Config.page;
    Config.page--;
    if (Config.page < 0) {
        Config.page = 0;
        return;
    }
    if (Config.useAudio) {
        AudioManager.initAudio();
    } else {
        Main.loadContent("", false);
    }
};
Main.moveToContent = function(_strContent) {
    if (Config.jumpingState) return;
    jumpingState = true;
    Config.lastPage = Config.page;
    for (var i = 0; i < Config.contentIDs.length; i++) {
        if (Config.contentIDs[i] == _strContent) {
            Config.page = i;
            break;
        }
    }
    if (Config.useAudio) {
        AudioManager.initAudio();
    } else {
        if (Config.lastPage < Config.page) {
            Main.loadContent("", true);
        } else {
            Main.loadContent("", false);
        }
    }
};
window.onload = function() {
    if (Config.useHelpWindow) {
        Config.helpF.src = "content/misc/help.html";
    }
    if (Config.useIndexLWindow) {
        Config.indexLF.src = "content/misc/indexlist.html";
    }
    if (Config.useGlossWindow) {
        Config.glossF.src = "content/misc/glossary.html";
    }
    if (Config.useVolumeWindow) {
        Config.volumeF.src = "content/misc/volume.html";
    }
    if (Config.useScreenWindow) {
        Config.screenF.src = "content/misc/screen.html";
    }
    Config.intervalFunction = null;
    Config.intervalFunction = setInterval(Main.checkIndexReady, 0.5);
};
$(window).on('resize', function() {
    TweenMax.delayedCall(0.1, LayoutManager.refreshFrame);
});
$(document).ready(function() {
    TweenMax.delayedCall(0.1, LayoutManager.refreshFrame);
});
//Browser state
ifvisible.on('blur', function() {
    Main.pauseContent();
});
ifvisible.on('focus', function() {
    Main.resumeContent();
});