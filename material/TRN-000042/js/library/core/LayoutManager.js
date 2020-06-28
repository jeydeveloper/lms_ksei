/////////////////////////////////////////////////////////
//LayoutManager.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize LayoutManager
var LayoutManager = {
    fixWidth: 0,
    fixHeight: 0,
    mobileOrientation: 0,
};
LayoutManager.refreshFrame = function() {
    switch (Config.layoutType) {
        case 0:
        {
            LayoutManager.scalling();
        }
        break;
        case 1:
        {
            LayoutManager.scallingResponsive();
        }
        break;
    }
};
LayoutManager.scalling = function() {
    var wWidth, wHeight, wrapW, wrapH, headerW, headerH;
	Config.breakIdx = 0;
    if((md.mobile() != null) || (md.phone() != null) || (md.tablet() != null)) {
        wWidth = document.documentElement.clientWidth || document.body.clientWidth;
		wHeight = document.documentElement.clientHeight || document.body.clientHeight;
        if (LayoutManager.mobileOrientation != 1) {
            //Portrait
            LayoutManager.mobileOrientation = 1;
            LayoutManager.fixWidth = wWidth;
            LayoutManager.fixHeight = wHeight;
        } else if (LayoutManager.mobileOrientation != 0) {
            //Landscape
            LayoutManager.mobileOrientation = 0;
            LayoutManager.fixWidth = wWidth;
            LayoutManager.fixHeight = wHeight;
        }
    } else {
        wWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        wHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        LayoutManager.fixWidth = wWidth;
        LayoutManager.fixHeight = wHeight;
    }
    document.getElementById('mod-frames').style.width = LayoutManager.fixWidth + 'px';
    document.getElementById('mod-frames').style.height = LayoutManager.fixHeight + 'px';
    document.getElementById('mod-pdf').style.width = LayoutManager.fixWidth + 'px';
    document.getElementById('mod-pdf').style.height = LayoutManager.fixHeight + 'px';
    wrapH = LayoutManager.fixHeight;
    wrapW = (wrapH / 56.25) * 100;
    var squreScreen = false;
    var lessSqureScreen = false;
    if (LayoutManager.fixWidth < wrapW) {
        squreScreen = true;
    }
    if (squreScreen) {
        if ((LayoutManager.fixWidth / 78.125) * 100 < wrapW) {
            wrapW = (LayoutManager.fixWidth / 78.125) * 100;
            wrapH = (wrapW * 56.25) / 100;
            lessSqureScreen = true;
        }
    }
    headerH = (wrapH * 13.888888888888889) / 100;
    if (headerH < 60) { headerH = 60; }
    else if (headerH > 80) { headerH = 80; }
    document.getElementById('mod-header').style.height = headerH + 'px';
    if (!Config.dynamicBGColor) {
        if (lessSqureScreen || squreScreen) {
            headerW = LayoutManager.fixWidth;
            document.getElementById('mod-header').style.width = headerW + 'px';
            document.getElementById('mod-header').style.left = "0px";
        } else {
            headerW = wrapW;
            document.getElementById('mod-header').style.width = headerW + 'px';
            document.getElementById('mod-header').style.left = (0 - ((headerW - LayoutManager.fixWidth) / 2)) + "px";
        }
    }
    document.getElementById('mod-wrapper').style.width = wrapW + 'px';
    document.getElementById('mod-wrapper').style.height = wrapH + 'px';
    if (lessSqureScreen || squreScreen) {
        document.getElementById('mod-wrapper').style.top = (0 + ((LayoutManager.fixHeight - wrapH) / 2)) + 'px';
        document.getElementById('mod-wrapper').style.left = (0 - ((wrapW - LayoutManager.fixWidth) / 2)) + "px";
    } else {
        document.getElementById('mod-wrapper').style.top = (0 - ((wrapH - LayoutManager.fixHeight) / 2)) + 'px';
        document.getElementById('mod-wrapper').style.left = (0 + ((LayoutManager.fixWidth - wrapW) / 2)) + "px";
    }
    switch (Config.subType) {
        case 0:
        {
            var subW;
            if (wrapH >= LayoutManager.fixHeight) {
                subW = (wrapW * 58.59375) / 100;
            } else {
                subW = (LayoutManager.fixWidth * 95) / 100;
            }
            var subH = (subW * 26.666666666666667) / 100;
            document.getElementById('mod-subtitle').style.width = subW + "px";
            document.getElementById('mod-subtitle').style.height = subH + "px";
            document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
            document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
            Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
            Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
            if ($('#btn-subtxt-con').css('display') == 'block') {
                document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                document.getElementById('subTxt').style.top = '0px';
            } else {
                document.getElementById('subTxt').style.width = '100%';
                var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                document.getElementById('subTxt').style.top = fPosY + 'px';
            }
            document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
            var btnPosX = 0;
            if (!Config.dynamicBGColor) {
                btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
            }
            TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
            if (Config.showSubWindow) {
                var posY = parseInt(document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                if ((subW + 150) > LayoutManager.fixWidth) {
                    posY = posY - 60;
                } else {
                    posY = posY - 10;
                }
                document.getElementById('mod-subtitle').style.top = posY + "px";
                posX = parseInt(document.getElementById('mod-frames').offsetWidth / 2) - parseInt(document.getElementById('mod-subtitle').offsetWidth / 2);
                document.getElementById('mod-subtitle').style.left = posX + "px";
            }
        }
        break;
        case 1:
        {
            var subW = LayoutManager.fixWidth;
            document.getElementById('mod-subtitle').style.width = subW + "px";
            if (!Config.dynamicBGColor) {
                document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
            }
            Config.maxSubX = 0;
            Config.maxSubY = 0;
            var btnPosX = 0;
            if (!Config.dynamicBGColor) {
                btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
            }
            TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
            var btnSubY = 0;
            if (Config.showSubWindow) {
                document.getElementById('mod-subtitle').style.bottom = '0px';
                btnSubY = document.getElementById('mod-subtitle').offsetHeight;
            }
            if (Config.navType == 0) {
                document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
            }
            document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
            document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
        }
        break;
    }
    document.getElementById('modul-title').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.modulTitleFS) / 100) + "px";
    setTimeout(function() {
        var mboxH = document.getElementById('modul-title-box').offsetHeight;
        var mtxtH = document.getElementById('modul-title').offsetHeight;
        if (mtxtH < mboxH) {
            document.getElementById('modul-title').style.marginTop = ((mboxH - mtxtH) / 2) + 'px';
        } else {
            document.getElementById('modul-title').style.margin = '0';
        }
    }, 110);
    document.getElementById('chapter-title').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.chapTitleFS) / 100) + "px";
    setTimeout(function() {
        var cboxH = document.getElementById('chapter-title-box').offsetHeight;
        var ctxtH = document.getElementById('chapter-title').offsetHeight;
        if (ctxtH < cboxH) {
            document.getElementById('chapter-title').style.marginTop = ((cboxH - ctxtH) / 2) + 'px';
        } else {
            document.getElementById('chapter-title').style.margin = '0';
        }
    }, 110);
    if (Config.navType == 0) {
        document.getElementById('mod-navi').style.left = document.getElementById('mod-header').offsetLeft + 'px';
    }
    if (Config.subType == 1) {
        document.getElementById('mod-sub-btn').style.right = document.getElementById('mod-header').offsetLeft + 'px';
    }
    if (Config.navType == 1) {
        document.getElementById('mod-navi').style.paddingTop = document.getElementById('mod-header').offsetHeight + 'px';
        if (!Config.dynamicBGColor) {
            if (Config.menuOpen) {
                document.getElementById('mod-navi').style.left = parseInt(document.getElementById("mod-header").offsetLeft) + "px";
            } else {
                document.getElementById('mod-navi').style.left = (parseInt(document.getElementById("mod-header").offsetLeft) - 250) + "px";
            }
        }
    }
    LayoutManager.resettingFrame();
    LayoutManager.resizePDFFrame();
    if (Config.navType == 2) {
        LayoutManager.resettingNavigation();
    }
};
LayoutManager.scallingResponsive = function() {
	var wWidth, wHeight, wrapW, wrapH, headerW, headerH;
    if((md.mobile() != null) || (md.phone() != null) || (md.tablet() != null)) {
        wWidth = document.documentElement.clientWidth || document.body.clientWidth;
		wHeight = document.documentElement.clientHeight || document.body.clientHeight;
        if (wWidth < (wHeight + 50)) {
            //Portrait
            if (Config.breakIdx != 1) {
                Config.breakIdx = 1;
                LayoutManager.fixWidth = wWidth;
                LayoutManager.fixHeight = wHeight;
            }
            document.getElementById('mod-frames').style.width = LayoutManager.fixWidth + 'px';
            document.getElementById('mod-frames').style.height = LayoutManager.fixHeight + 'px';
            document.getElementById('mod-pdf').style.width = LayoutManager.fixWidth + 'px';
            document.getElementById('mod-pdf').style.height = LayoutManager.fixHeight + 'px';
            wrapW = LayoutManager.fixWidth;
            wrapH = (wrapW / 56.25) * 100;
            headerH = (wrapH * 8) / 100;
            if (headerH < 60) { headerH = 60; }
            else if (headerH > 80) { headerH = 80; }
            document.getElementById('mod-header').style.height = headerH + 'px';
            if (!Config.dynamicBGColor) {
                headerW = wrapW;
                document.getElementById('mod-header').style.width = headerW + 'px';
                document.getElementById('mod-header').style.left = "0px";
            }
            document.getElementById('mod-wrapper').style.width = wrapW + 'px';
            document.getElementById('mod-wrapper').style.height = wrapH + 'px';
            if (LayoutManager.fixHeight < wrapH) {
                document.getElementById('mod-wrapper').style.top = (0 - ((wrapH - LayoutManager.fixHeight) / 2)) + "px";
            } else {
                document.getElementById('mod-wrapper').style.top = (0 + ((LayoutManager.fixHeight - wrapH) / 2)) + "px";
            }
            document.getElementById('mod-wrapper').style.left = "0px";
            switch (Config.subType) {
                case 0:
                {
                    var subW = (wrapW * 95) / 100;
                    var subH = (subW * 26.666666666666667) / 100;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    document.getElementById('mod-subtitle').style.height = subH + "px";
                    document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
                    document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
                    Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
                    Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
                    if ($('#btn-subtxt-con').css('display') == 'block') {
                        document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                        document.getElementById('subTxt').style.top = '0px';
                    } else {
                        document.getElementById('subTxt').style.width = '100%';
                        var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                        document.getElementById('subTxt').style.top = fPosY + 'px';
                    }
                    document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
                    var btnSubY = 0;
                    if (Config.showSubWindow) {
                        var posY = (document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                        posY = posY - 10;
                        document.getElementById('mod-subtitle').style.top = posY + "px";
                        posX = (document.getElementById('mod-frames').offsetWidth / 2) - (document.getElementById('mod-subtitle').offsetWidth / 2);
                        document.getElementById('mod-subtitle').style.left = posX + "px";
                        btnSubY = document.getElementById('mod-subtitle').offsetHeight + 10;
                    }
                    var btnPosX = 0;
                    if (!Config.dynamicBGColor) {
                        btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                    }
                    TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                    if (Config.navType == 0) {
                        document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                    }
                    document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                }
                break;
                case 1:
                {
                    var subW = LayoutManager.fixWidth;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    if (!Config.dynamicBGColor) {
                        document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                        document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
                    }
                    Config.maxSubX = 0;
                    Config.maxSubY = 0;
                    var btnPosX = 0;
                    if (!Config.dynamicBGColor) {
                        btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                    }
                    TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                    var btnSubY = 0;
                    if (Config.showSubWindow) {
                        document.getElementById('mod-subtitle').style.bottom = '0px';
                        btnSubY = document.getElementById('mod-subtitle').offsetHeight;
                    }
                    if (Config.navType == 0) {
                        document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                    }
                    document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                    document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
                }
                break;
            }
        } else if (wHeight < (wWidth + 50)) {
            //Landscape
            if (Config.breakIdx != 0) {
                Config.breakIdx = 0;
                LayoutManager.fixWidth = wWidth;
                LayoutManager.fixHeight = wHeight;
            }
            document.getElementById('mod-frames').style.width = LayoutManager.fixWidth + 'px';
            document.getElementById('mod-frames').style.height = LayoutManager.fixHeight + 'px';
            document.getElementById('mod-pdf').style.width = LayoutManager.fixWidth + 'px';
            document.getElementById('mod-pdf').style.height = LayoutManager.fixHeight + 'px';
            wrapH = LayoutManager.fixHeight;
            wrapW = (wrapH / 56.25) * 100;
            headerH = (wrapH * 13.888888888888889) / 100;
            if (headerH < 60) { headerH = 60; }
            else if (headerH > 80) { headerH = 80; }
            document.getElementById('mod-header').style.height = headerH + 'px';
            if (!Config.dynamicBGColor) {
                if (LayoutManager.fixWidth < wrapW) {
                    headerW = LayoutManager.fixWidth;
                    document.getElementById('mod-header').style.width = headerW + 'px';
                    document.getElementById('mod-header').style.left = "0px";
                } else {
                    headerW = wrapW;
                    document.getElementById('mod-header').style.width = headerW + 'px';
                    document.getElementById('mod-header').style.left = (0 - ((headerW - LayoutManager.fixWidth) / 2)) + "px";
                }
            }
            document.getElementById('mod-wrapper').style.width = wrapW + 'px';
            document.getElementById('mod-wrapper').style.height = wrapH + 'px';
            if (LayoutManager.fixWidth < wrapW) {
                document.getElementById('mod-wrapper').style.left = (0 - ((wrapW - LayoutManager.fixWidth) / 2)) + "px";
            } else {
                document.getElementById('mod-wrapper').style.left = (0 + ((LayoutManager.fixWidth - wrapW) / 2)) + "px";
            }
            document.getElementById('mod-wrapper').style.top = "0px";
            switch (Config.subType) {
                case 0:
                {
                    var subW = (wrapW * 58.59375) / 100;
                    var subH = (subW * 26.666666666666667) / 100;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    document.getElementById('mod-subtitle').style.height = subH + "px";
                    document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
                    document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
                    Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
                    Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
                    if ($('#btn-subtxt-con').css('display') == 'block') {
                        document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                        document.getElementById('subTxt').style.top = '0px';
                    } else {
                        document.getElementById('subTxt').style.width = '100%';
                        var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                        document.getElementById('subTxt').style.top = fPosY + 'px';
                    }
                    var btnPosX = 0;
                    if (!Config.dynamicBGColor) {
                        btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                    }
                    TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                    document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
                    if (Config.showSubWindow) {
                        var posY = (document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                        posY = posY - 10;
                        document.getElementById('mod-subtitle').style.top = posY + "px";
                        posX = (document.getElementById('mod-frames').offsetWidth / 2) - (document.getElementById('mod-subtitle').offsetWidth / 2);
                        document.getElementById('mod-subtitle').style.left = posX + "px";
                    }
                }
                break;
                case 1:
                {
                    var subW = LayoutManager.fixWidth;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    if (!Config.dynamicBGColor) {
                        document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                        document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
                    }
                    Config.maxSubX = 0;
                    Config.maxSubY = 0;
                    var btnPosX = 0;
                    if (!Config.dynamicBGColor) {
                        btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                    }
                    TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                    var btnSubY = 0;
                    if (Config.showSubWindow) {
                        document.getElementById('mod-subtitle').style.bottom = '0px';
                        btnSubY = document.getElementById('mod-subtitle').offsetHeight;
                    }
                    if (Config.navType == 0) {
                        document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                    }
                    document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                    document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
                }
                break;
            }
        }
    } else {
        wWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		wHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        Config.breakIdx = 0;
        document.getElementById('mod-frames').style.width = wWidth + 'px';
        document.getElementById('mod-frames').style.height = wHeight + 'px';
        document.getElementById('mod-pdf').style.width = wWidth + 'px';
        document.getElementById('mod-pdf').style.height = wHeight + 'px';
        if (Config.debugLayout) {
            if (wWidth < (wHeight + 50)) {
                //Portrait
                Config.breakIdx = 1;
                wrapW = wWidth;
                wrapH = (wrapW / 56.25) * 100;
                headerH = (wrapH * 8) / 100;
                if (headerH < 60) { headerH = 60; }
                else if (headerH > 80) { headerH = 80; }
                document.getElementById('mod-header').style.height = headerH + 'px';
                if (!Config.dynamicBGColor) {
                    headerW = wWidth;
                    document.getElementById('mod-header').style.width = headerW + 'px';
                    document.getElementById('mod-header').style.left = "0px";
                }
                document.getElementById('mod-wrapper').style.width = wrapW + 'px';
                document.getElementById('mod-wrapper').style.height = wrapH + 'px';
                if (wHeight < wrapH) {
                    document.getElementById('mod-wrapper').style.top = (0 - ((wrapH - wHeight) / 2)) + "px";
                } else {
                    document.getElementById('mod-wrapper').style.top = (0 + ((wHeight - wrapH) / 2)) + "px";
                }
                document.getElementById('mod-wrapper').style.left = "0px";
                switch (Config.subType) {
                    case 0:
                    {
                        var subW = (wrapW * 95) / 100;
                        var subH = (subW * 26.666666666666667) / 100;
                        document.getElementById('mod-subtitle').style.width = subW + "px";
                        document.getElementById('mod-subtitle').style.height = subH + "px";
                        document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
                        document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
                        Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
                        Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
                        if ($('#btn-subtxt-con').css('display') == 'block') {
                            document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                            document.getElementById('subTxt').style.top = '0px';
                        } else {
                            document.getElementById('subTxt').style.width = '100%';
                            var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                            document.getElementById('subTxt').style.top = fPosY + 'px';
                        }
                        document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
                        var btnPosX = 0;
                        if (!Config.dynamicBGColor) {
                            btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                        }
                        TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                        var btnSubY = 0;
                        if (Config.showSubWindow) {
                            var posY = parseInt(document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                            posY = posY - 10;
                            document.getElementById('mod-subtitle').style.top = posY + "px";
                            posX = parseInt(document.getElementById('mod-frames').offsetWidth / 2) - parseInt(document.getElementById('mod-subtitle').offsetWidth / 2);
                            document.getElementById('mod-subtitle').style.left = posX + "px";
                            btnSubY = document.getElementById('mod-subtitle').offsetHeight + 10;
                        }
                        if (Config.navType == 0) {
                            document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                        }
                        document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                    }
                    break;
                    case 1:
                    {
                        var subW = wWidth;
                        document.getElementById('mod-subtitle').style.width = subW + "px";
                        if (!Config.dynamicBGColor) {
                            document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                            document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
                        }
                        Config.maxSubX = 0;
                        Config.maxSubY = 0;
                        var btnPosX = 0;
                        if (!Config.dynamicBGColor) {
                            btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                        }
                        TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                        var btnSubY = 0;
                        if (Config.showSubWindow) {
                            document.getElementById('mod-subtitle').style.bottom = '0px';
                            btnSubY = document.getElementById('mod-subtitle').offsetHeight;
                        }
                        if (Config.navType == 0) {
                            document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                        }
                        document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                        document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
                    }
                    break;
                }
            } else if (wHeight < (wWidth + 50)) {
                //Landscape
                Config.breakIdx = 0;
                wrapH = wHeight;
                wrapW = (wrapH / 56.25) * 100;
                headerH = (wrapH * 13.888888888888889) / 100;
                if (headerH < 60) { headerH = 60; }
                else if (headerH > 80) { headerH = 80; }
                document.getElementById('mod-header').style.height = headerH + 'px';
                if (!Config.dynamicBGColor) {
                    if (wWidth < wrapW) {
                        headerW = wWidth;
                        document.getElementById('mod-header').style.width = headerW + 'px';
                        document.getElementById('mod-header').style.left = "0px";
                    } else {
                        headerW = wrapW;
                        document.getElementById('mod-header').style.width = headerW + 'px';
                        document.getElementById('mod-header').style.left = (0 - ((headerW - wWidth) / 2)) + "px";
                    }
                }
                document.getElementById('mod-wrapper').style.width = wrapW + 'px';
                document.getElementById('mod-wrapper').style.height = wrapH + 'px';
                if (wWidth < wrapW) {
                    document.getElementById('mod-wrapper').style.left = (0 - ((wrapW - wWidth) / 2)) + "px";
                } else {
                    document.getElementById('mod-wrapper').style.left = (0 + ((wWidth - wrapW) / 2)) + "px";
                }
                document.getElementById('mod-wrapper').style.top = "0px";
                switch (Config.subType) {
                    case 0:
                    {
                        var subW = (wrapW * 58.59375) / 100;
                        var subH = (subW * 26.666666666666667) / 100;
                        document.getElementById('mod-subtitle').style.width = subW + "px";
                        document.getElementById('mod-subtitle').style.height = subH + "px";
                        document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
                        document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
                        Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
                        Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
                        if ($('#btn-subtxt-con').css('display') == 'block') {
                            document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                            document.getElementById('subTxt').style.top = '0px';
                        } else {
                            document.getElementById('subTxt').style.width = '100%';
                            var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                            document.getElementById('subTxt').style.top = fPosY + 'px';
                        }
                        document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
                        if (Config.showSubWindow) {
                            var posY = parseInt(document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                            posY = posY - 10;
                            document.getElementById('mod-subtitle').style.top = posY + "px";
                            posX = parseInt(document.getElementById('mod-frames').offsetWidth / 2) - parseInt(document.getElementById('mod-subtitle').offsetWidth / 2);
                            document.getElementById('mod-subtitle').style.left = posX + "px";
                        }
                        var btnPosX = 0;
                        if (!Config.dynamicBGColor) {
                            btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                        }
                        TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                    }
                    break;
                    case 1:
                    {
                        var subW = wWidth;
                        document.getElementById('mod-subtitle').style.width = subW + "px";
                        if (!Config.dynamicBGColor) {
                            document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                            document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
                        }
                        Config.maxSubX = 0;
                        Config.maxSubY = 0;
                        var btnPosX = 0;
                        if (!Config.dynamicBGColor) {
                            btnPosX = 0 + parseInt(document.getElementById("mod-header").offsetLeft);
                        }
                        TweenMax.set(document.getElementById("mod-sub-btn"), { right: btnPosX + 'px' });
                        var btnSubY = 0;
                        if (Config.showSubWindow) {
                            document.getElementById('mod-subtitle').style.bottom = '0px';
                            btnSubY = document.getElementById('mod-subtitle').offsetHeight;
                        }
                        if (Config.navType == 0) {
                            document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                        }
                        document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                        document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
                    }
                    break;
                }
            }
        } else {
            wrapH = wHeight;
            wrapW = (wrapH / 56.25) * 100;
            headerH = (wrapH * 13.888888888888889) / 100;
            if (headerH < 60) { headerH = 60; }
            else if (headerH > 80) { headerH = 80; }
            document.getElementById('mod-header').style.height = headerH + 'px';
            if (!Config.dynamicBGColor) {
                if (wWidth < wrapW) {
                    headerW = wWidth;
                    document.getElementById('mod-header').style.width = headerW + 'px';
                    document.getElementById('mod-header').style.left = "0px";
                } else {
                    headerW = wrapW;
                    document.getElementById('mod-header').style.width = headerW + 'px';
                    document.getElementById('mod-header').style.left = (0 - ((headerW - wWidth) / 2)) + "px";
                }
            }
            document.getElementById('mod-wrapper').style.width = wrapW + 'px';
            document.getElementById('mod-wrapper').style.height = wrapH + 'px';
            if (wWidth < wrapW) {
                document.getElementById('mod-wrapper').style.left = (0 - ((wrapW - wWidth) / 2)) + "px";
            } else {
                document.getElementById('mod-wrapper').style.left = (0 + ((wWidth - wrapW) / 2)) + "px";
            }
            document.getElementById('mod-wrapper').style.top = "0px";
            switch (Config.subType) {
                case 0:
                {
                    var subW = (wrapW * 58.59375) / 100;
                    var subH = (subW * 26.666666666666667) / 100;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    document.getElementById('mod-subtitle').style.height = subH + "px";
                    document.getElementById('box-subtitle').style.width = (subW - 10) + 'px';
                    document.getElementById('box-subtitle').style.height = (subH - 10) + 'px';
                    Config.maxSubX = document.getElementById('mod-frames').offsetWidth - subW;
                    Config.maxSubY = document.getElementById('mod-frames').offsetHeight - subH;
                    if ($('#btn-subtxt-con').css('display') == 'block') {
                        document.getElementById('subTxt').style.width = (document.getElementById('box-subtitle').offsetWidth - 30) + 'px';
                        document.getElementById('subTxt').style.top = '0px';
                    } else {
                        document.getElementById('subTxt').style.width = '100%';
                        var fPosY = (document.getElementById('box-subtitle').offsetHeight / 2) - (document.getElementById('subTxt').offsetHeight / 2);
                        document.getElementById('subTxt').style.top = fPosY + 'px';
                    }
                    document.getElementById('subTxt').style.fontSize = ((subH * Config.subtitleFS) / 100) + "px";
                    if (Config.showSubWindow) {
                        var posY = parseInt(document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight);
                        posY = posY - 10;
                        document.getElementById('mod-subtitle').style.top = posY + "px";
                        posX = parseInt(document.getElementById('mod-frames').offsetWidth / 2) - parseInt(document.getElementById('mod-subtitle').offsetWidth / 2);
                        document.getElementById('mod-subtitle').style.left = posX + "px";
                    }
                }
                break;
                case 1:
                {
                    var subW = wWidth;
                    document.getElementById('mod-subtitle').style.width = subW + "px";
                    if (!Config.dynamicBGColor) {
                        document.getElementById('mod-subtitle').style.width = document.getElementById('mod-header').offsetWidth + 'px';
                        document.getElementById('mod-subtitle').style.left = document.getElementById('mod-header').offsetLeft + 'px';
                    }
                    Config.maxSubX = 0;
                    Config.maxSubY = 0;
                    var btnSubY = 0;
                    if (Config.showSubWindow) {
                        document.getElementById('mod-subtitle').style.bottom = '0px';
                        btnSubY = document.getElementById('mod-subtitle').offsetHeight;
                    }
                    if (Config.navType == 0) {
                        document.getElementById('mod-navi').style.bottom = btnSubY + 'px';
                    }
                    document.getElementById('mod-sub-btn').style.bottom = btnSubY + 'px';
                    document.getElementById('subTxt').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.subtitleFS) / 100) + "px";
                }
                break;
            }
        }
    }
    document.getElementById('modul-title').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.modulTitleFS) / 100) + "px";
    setTimeout(function() {
        var mboxH = document.getElementById('modul-title-box').offsetHeight;
        var mtxtH = document.getElementById('modul-title').offsetHeight;
        if (mtxtH < mboxH) {
            document.getElementById('modul-title').style.marginTop = ((mboxH - mtxtH) / 2) + 'px';
        } else {
            document.getElementById('modul-title').style.margin = '0';
        }
    }, 110);
    document.getElementById('chapter-title').style.fontSize = ((document.getElementById('mod-header').offsetHeight * Config.chapTitleFS) / 100) + "px";
    setTimeout(function() {
        var cboxH = document.getElementById('chapter-title-box').offsetHeight;
        var ctxtH = document.getElementById('chapter-title').offsetHeight;
        if (ctxtH < cboxH) {
            document.getElementById('chapter-title').style.marginTop = ((cboxH - ctxtH) / 2) + 'px';
        } else {
            document.getElementById('chapter-title').style.margin = '0';
        }
    }, 110);
    if (Config.navType == 0) {
        document.getElementById('mod-navi').style.left = document.getElementById('mod-header').offsetLeft + 'px';
    }
    if (Config.subType == 1) {
        document.getElementById('mod-sub-btn').style.right = document.getElementById('mod-header').offsetLeft + 'px';
    }
    if (Config.navType == 1) {
        document.getElementById('mod-navi').style.paddingTop = document.getElementById('mod-header').offsetHeight + 'px';
        if (!Config.dynamicBGColor) {
            if (Config.menuOpen) {
                document.getElementById('mod-navi').style.left = (document.getElementById("mod-header").offsetLeft) + "px";
            } else {
                document.getElementById('mod-navi').style.left = ((document.getElementById("mod-header").offsetLeft) - 250) + "px";
            }
        }
    }
    LayoutManager.resettingFrame();
    LayoutManager.resizePDFFrame();
    if (Config.navType == 2) {
        LayoutManager.resettingNavigation();
    }
};
LayoutManager.resettingFrame = function() {
    switch(Config.slidingType) {
        case 0:
        {
            var cW = document.getElementById('mod-wrapper').offsetWidth;
            switch(Config.frameObj) {
                case 1:
                {
                    Config.content1F.style.left = "0px";
                    Config.content2F.style.left = cW + "px";
                    Config.content3F.style.left = "-" + cW + "px";
                }
                break;
                case 2:
                {
                    Config.content1F.style.left = "-" + cW + "px";
                    Config.content2F.style.left = "0px";
                    Config.content3F.style.left = cW + "px";
                }
                break;
                case 3:
                {
                    Config.content1F.style.left = cW + "px";
                    Config.content2F.style.left = "-" + cW + "px";
                    Config.content3F.style.left = "0px";
                }
                break;
            }
        }
        break;
        case 1:
        {
            var cH = document.getElementById('mod-wrapper').offsetHeight;
            switch(Config.frameObj) {
                case 1:
                {
                    Config.content1F.style.top = "0px";
                    Config.content2F.style.top = cH + "px";
                    Config.content3F.style.top = "-" + cH + "px";
                }
                break;
                case 2:
                {
                    Config.content1F.style.top = "-" + cH + "px";
                    Config.content2F.style.top = "0px";
                    Config.content3F.style.top = cH + "px";
                }
                break;
                case 3:
                {
                    Config.content1F.style.top = cH + "px";
                    Config.content2F.style.top = "-" + cH + "px";
                    Config.content3F.style.top = "0px";
                }
                break;
            }
        }
        break;
    }
    //Init Help Frame
    switch(Config.helpType) {
        case 1:
        {
            var hW = Config.helpF.offsetWidth;
            var finalL = 0 - (hW - (hW * 2)) - 50;
            Config.helpF.style.left = finalL + "px";
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var hW = Config.helpF.offsetWidth;
            var finalL = fW + (hW + 50);
            Config.helpF.style.left = finalL + "px";
        }
        break;
    }
    //Init Index List Frame
    switch(Config.indexLType) {
        case 1:
        {
            var iW = Config.indexLF.offsetWidth;
            var finalL = 0 - (iW - (iW * 2)) - 50;
            Config.indexLF.style.left = finalL + "px";
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var iW = Config.indexLF.offsetWidth;
            var finalL = fW + (iW + 50);
            Config.indexLF.style.left = finalL + "px";
        }
        break;
    }
    //Init Glossary Frame
    switch(Config.glossType) {
       case 1:
        {
            var gW = Config.glossF.offsetWidth;
            var finalL = 0 - (gW - (gW * 2)) - 50;
            Config.glossF.style.left = finalL + "px";
        }
        break;
        case 2:
        {
            var fW = document.getElementById('mod-frames').offsetWidth;
            var gW = Config.glossF.offsetWidth;
            var finalL = fW + (gW + 50);
            Config.glossF.style.left = finalL + "px";
        }
        break;
    }
};
LayoutManager.resizePDFFrame = function() {
    var pH = document.getElementById('mod-pdf').offsetHeight;
    var pFH = pH - 45;
    document.getElementById('pdf-frame-body').style.height = pFH + 'px';
};
LayoutManager.resettingNavigation = function() {
    var frameW = document.getElementById('mod-frames').offsetWidth;
    var leftN = (frameW / 2) - (80 / 2);
    if (document.getElementsByClassName('nav-type-2')[0] != null && document.getElementsByClassName('nav-type-2')[0] != undefined) {
        document.getElementsByClassName('nav-type-2')[0].style.left = leftN + "px";
    }
};