/////////////////////////////////////////////////////////
//PopupManager.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize PopupManager
var PopupManager = {
    pdfFrame: null,
    pdfFrameBody: null
};
PopupManager.closePDFFrame = function() {
    $(PopupManager.pdfFrame).fadeOut(300);
    PopupManager.pdfFrameBody.innerHTML = '<iframe id="pdfF" frameborder="0" src="about:blank">This browser does not support PDFs. Please download the PDF to view it: <a href="#">Download PDF</a></iframe>';
    Main.resumeContent();
};
PopupManager.openPDFFrame = function(_pdfName) {
    if (md.os() == 'iOS') {
        window.open("../../pdf/" + _pdfName + ".pdf", '_blank');
    } else {
        Main.pauseContent();
        var pdfiFrame = document.getElementById('pdfF');
        pdfiFrame.src = "pdf/" + _pdfName + ".pdf";
        $(PopupManager.pdfFrame).fadeIn(300);
        setTimeout(LayoutManager.resizePDFFrame, 400);
    }
};
PopupManager.setPDFFrame = function() {
    PopupManager.pdfFrame = document.getElementById('mod-pdf');
    PopupManager.pdfFrameBody = document.getElementById('pdf-frame-body');
    PopupManager.pdfFrame.style.display = "none";
    PopupManager.pdfFrameBody.innerHTML = '<iframe id="pdfF" frameborder="0" src="about:blank">This browser does not support PDFs. Please download the PDF to view it: <a href="#">Download PDF</a></iframe>';
    if (document.getElementById('pdf-btn-close').addEventListener) {
        document.getElementById('pdf-btn-close').addEventListener("click", PopupManager.closePDFFrame);
    } else if (document.getElementById('pdf-btn-close').attachEvent) {
        document.getElementById('pdf-btn-close').attachEvent("onclick", PopupManager.closePDFFrame);
    }
};
PopupManager.setPDFFrame();
PopupManager.screenShow = function() {
    TweenMax.set(Config.screenF, {display: 'block'});
    TweenMax.to(Config.screenF, .3, {opacity: 1});
    Config.hypeScreen.setParentBGColor();
};
PopupManager.screenHide = function() {
    TweenMax.to(Config.screenF, .3, {opacity: 0, display:'none'});
    if (Config.firstLoad) {
        if (Config.hypeHelp != null) {
            PopupManager.popupShow('help');
        } else {
            if (Config.useBackSound) {
                AudioManager.initBacksound();
            }
            Main.checkLastPage();
        }
    }
};
PopupManager.popupShow = function(_type) {
    var popupHype = null;
    if (_type == null || _type == undefined) return;
    switch (_type) {
        case 'help':
        {
            if (Config.indexLOpen) {
                PopupManager.popupHide('indexlist');
            }
            if (Config.glossOpen) {
                PopupManager.popupHide('glossary');
            }
            if (Config.volumeOpen) {
                PopupManager.popupHide('volume');
            }
            popupHype = Config.hypeHelp;
        }
        break;
        case 'indexlist':
        {
            if (Config.helpOpen) {
                PopupManager.popupHide('help');
            }
            if (Config.glossOpen) {
                PopupManager.popupHide('glossary');
            }
            if (Config.volumeOpen) {
                PopupManager.popupHide('volume');
            }
            popupHype = Config.hypeIndexL;
        }
        break;
        case 'glossary':
        {
            if (Config.indexLOpen) {
                PopupManager.popupHide('indexlist');
            }
            if (Config.helpOpen) {
                PopupManager.popupHide('help');
            }
            if (Config.volumeOpen) {
                PopupManager.popupHide('volume');
            }
            popupHype = Config.hypeGloss;
        }
        break;
        case 'volume':
        {
            if (Config.indexLOpen) {
                PopupManager.popupHide('indexlist');
            }
            if (Config.glossOpen) {
                PopupManager.popupHide('glossary');
            }
            if (Config.helpOpen) {
                PopupManager.popupHide('help');
            }
            popupHype = Config.hypeVolume;
        }
        break;
    }
    popupHype.setParentBGColor();
    if (popupHype != null) {
        EffectManager.popupSlideEff(_type);
    }
    if (Config.subtitleOpened) {
        PopupManager.closeSubtitleWindow();
    }
    if (!Config.firstLoad) {
        Main.showMenu();
        Main.pauseContent();
    }
};
PopupManager.popupHide = function(_type) {
    var popupHype = null;
    if (_type == null || _type == undefined) return;
    switch (_type) {
        case 'help':
        {
            popupHype = Config.hypeHelp;
        }
        break;
        case 'indexlist':
        {
            popupHype = Config.hypeIndexL;
        }
        break;
        case 'glossary':
        {
            popupHype = Config.hypeGloss;
        }
        break;
        case 'volume':
        {
            popupHype = Config.hypeVolume;
        }
        break;
    }
    if (popupHype != null) {
        EffectManager.popupSlideEff(_type);
    }
    if (Config.hypeContent != null) {
        Config.hypeContent.setParentBGColor();
    }
    if (Config.subtitleOpened) {
        PopupManager.openSubtitleWindow();
    }
    if (Config.firstLoad) {
        if (_type == 'help') {
            if (Config.useBackSound) {
                AudioManager.initBacksound();
            }
            Main.checkLastPage();
        }
    } else {
        Main.resumeContent();
    }
};
PopupManager.initIndexList = function() {
    if (Config.hypeIndexL == null) return;
    var i;
    for (i = 0; i < 100; i++) {
        if (i > 9) {
            if (Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != undefined) {
                Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx).style.display = 'none';
            } else {
                break;
            }
        } else {
            if (Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx) != undefined) {
                Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx).style.display = 'none';
            } else {
                break;
            }
        }
    }
    for (i = 0; i < 100; i++) {
        if (Config.lessonLocation[i] > 0) {
            if (i > 9) {
                if (Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != undefined) {
                    Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx).style.display = 'block';
                } else {
                    break;
                }
            } else {
                if (Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx) != undefined) {
                    Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx).style.display = 'block';
                } else {
                    break;
                }
            }
        }
    }
    Config.hypeIndexL.getElementById('btn_index_00_' + Config.breakIdx).style.display = 'block';
    PopupManager.updateBookmark();
};
PopupManager.selectIndex = function(_idx) {
    var nc = 0, nextPage = 0, i = 0;
    if (Config.bLock) {
        if (Config.lessonLocation[_idx] == 0) {
            return;
        }
    }
    for (i = 0; i < _idx; i++) {
        if (Config.bLock) {
            nc += Config.lessonLocation[i];
        } else {
            nc += Config.nContent[i];
        }
    }
    nextPage = nc;
    PopupManager.popupHide('indexlist');
    Config.lastPage = Config.page;
    Config.page = nextPage;
    if (Config.useAudio) {
        AudioManager.initAudio();
    } else {
        if (nextPage > Config.page) {
            Main.loadContent("", true);
        } else {
            Main.loadContent("", false);
        }
    }
};
PopupManager.updateBookmark = function() {
    if (Config.hypeIndexL == null) return;
    for (var i = 0; i < 100; i++) {
        if (Config.lessonLocation[i] == 0) {
            break;
        }
        if (i > 9) {
            if (Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != undefined) {
                Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx).style.display = 'block';
            } else {
                break;
            }
        } else {
            if (Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx) != null && Config.hypeIndexL.getElementById('btn_index_' + i + '_' + Config.breakIdx) != undefined) {
                Config.hypeIndexL.getElementById('btn_index_0' + i + '_' + Config.breakIdx).style.display = 'block';
            } else {
                break;
            }
        }
    }
};
//subtitle
PopupManager.updateSubtitleText = function(_idx) {
    if (TextHostManager.audioText[Config.page][_idx] == "" || TextHostManager.audioText[Config.page][_idx] == " ") {
        document.getElementById('subTxt').innerHTML = "";
        return;
    }
    var subTxt = TextHostManager.audioText[Config.page][_idx];
    document.getElementById('subTxt').innerHTML = subTxt;
    Config.subtitleNotEmpty = true;
    if (Config.subType == 0) {
        Config.canOpenSubWindow = true;
        document.getElementById('mod-sub-btn').style.cursor = 'pointer';
        if (document.getElementById('mod-subtitle').style.display == "block") {
            var boxSub = document.getElementById('box-subtitle');
            var subTxt = document.getElementById('subTxt');
            if (subTxt.offsetHeight > boxSub.offsetHeight) {
                subTxt.style.top = '0px';
                subTxt.style.width = (boxSub.offsetWidth - 30) + 'px';
                document.getElementById('btn-subtxt-con').style.display = 'block';
                document.getElementById('btn-subtxt-prev-icn').style.display = 'none';
                document.getElementById('btn-subtxt-next-icn').style.display = 'block';
            } else {
                subTxt.style.width = '100%';
                document.getElementById('btn-subtxt-con').style.display = 'none';
                var fPosY = (boxSub.offsetHeight / 2) - (subTxt.offsetHeight / 2);
                subTxt.style.top = fPosY + 'px';
            }
            var btnPosY = document.getElementById('mod-subtitle').offsetHeight + 10;
            var posY = document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight;
            if ((document.getElementById('mod-subtitle').offsetWidth + 150) > LayoutManager.fixWidth) {
                posY = posY - 60;
            } else {
                posY = posY - 10;
            }
            posY = posY - 10;
            if (Config.breakIdx == 1) {
                if (Config.navType == 0) {
                    TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: btnPosY });
                }
                TweenMax.to(document.getElementById('mod-sub-btn'), 0.3, { bottom: btnPosY });
            }
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { top: posY + "px", opacity: 1 });
            var posX = (document.getElementById('mod-frames').offsetWidth / 2) - (document.getElementById('mod-subtitle').offsetWidth / 2);
            document.getElementById('mod-subtitle').style.left = posX + "px";
        }
    } else if (Config.subType == 1) {
        if (document.getElementById('mod-subtitle').style.display == "block") {
            var subBtnY = document.getElementById('mod-subtitle').offsetHeight;
            if (Config.navType == 0) {
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: subBtnY + 'px' });
            }
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { bottom: "0px", opacity: 1 });
            TweenMax.to(document.getElementById("mod-sub-btn"), 0.3, { bottom: subBtnY + 'px' });
        }
    }
    TweenMax.to(document.getElementById('mod-sub-btn'), 0.3, { opacity: 1 });
};
PopupManager.resetSubtitleText = function() {
    TweenMax.to(document.getElementById('mod-sub-btn'), 0.3, { opacity: 0.5 });
    document.getElementById('subTxt').innerHTML = "";
    Config.subtitleNotEmpty = false;
    if (Config.subType == 0) {
        Config.canOpenSubWindow = false;
        document.getElementById('mod-sub-btn').style.cursor = 'default';
    }
    //Temporary
    PopupManager.closeSubtitleWindow();
};
PopupManager.openSubtitleWindow = function() {
    Config.blockSubBtn = true;
    Config.subtitleOpened = true;
    document.getElementById('mod-subtitle').style.display = "block";
    TweenMax.to(document.getElementById('btn-sub-open'), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
    TweenMax.to(document.getElementById('btn-sub-close'), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
    switch (Config.subType) {
        case 0:
        {
            var boxSub = document.getElementById('box-subtitle');
            var subTxt = document.getElementById('subTxt');
            if (subTxt.offsetHeight > boxSub.offsetHeight) {
                subTxt.style.top = '0px';
                subTxt.style.width = (boxSub.offsetWidth - 30) + 'px';
                document.getElementById('btn-subtxt-con').style.display = 'block';
                document.getElementById('btn-subtxt-prev-icn').style.display = 'none';
                document.getElementById('btn-subtxt-next-icn').style.display = 'block';
            } else {
                subTxt.style.width = '100%';
                document.getElementById('btn-subtxt-con').style.display = 'none';
                var fPosY = (boxSub.offsetHeight / 2) - (subTxt.offsetHeight / 2);
                subTxt.style.top = fPosY + 'px';
            }
            var btnPosY = document.getElementById('mod-subtitle').offsetHeight + 10;
            var posY = document.getElementById('mod-frames').offsetHeight - document.getElementById('mod-subtitle').offsetHeight;
            if ((document.getElementById('mod-subtitle').offsetWidth + 150) > LayoutManager.fixWidth) {
                posY = posY - 60;
            } else {
                posY = posY - 10;
            }
            posY = posY - 10;
            if (Config.breakIdx == 1) {
                if (Config.navType == 0) {
                    TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: btnPosY });
                }
                TweenMax.to(document.getElementById('mod-sub-btn'), 0.3, { bottom: btnPosY });
            }
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { top: posY + "px", opacity: 1 });
            var posX = (document.getElementById('mod-frames').offsetWidth / 2) - (document.getElementById('mod-subtitle').offsetWidth / 2);
            document.getElementById('mod-subtitle').style.left = posX + "px";
            TweenMax.delayedCall(0.4, function() { 
                Config.blockSubBtn = false; 
                Draggable.get(document.getElementById('mod-subtitle')).enable(); 
            });
        }
        break;
        case 1:
        {
            var subBtnY = document.getElementById('mod-subtitle').offsetHeight;
            if (Config.navType == 0) {
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: subBtnY + 'px' });
            }
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { bottom: "0px", opacity: 1 });
            TweenMax.to(document.getElementById("mod-sub-btn"), 0.3, { bottom: subBtnY + 'px' });
            TweenMax.delayedCall(0.4, function() { 
                Config.blockSubBtn = false;
            });
        }
        break;
    }
};
PopupManager.closeSubtitleWindow = function() {
    Config.blockSubBtn = true;
    if (!Config.subtitleNotEmpty) {
        Config.subtitleOpened = false;
    }
    TweenMax.to(document.getElementById('btn-sub-open'), 0.3, { transformOrigin:"50% 50%", scale: 1, opacity: 1, display: 'block', ease:Power1.easeInOut });
    TweenMax.to(document.getElementById('btn-sub-close'), 0.3, { transformOrigin:"50% 50%", scale: 0, opacity: 0, display: 'none', ease:Power1.easeInOut });
    switch (Config.subType) {
        case 0:
        {
            if (Config.breakIdx == 1) {
                if (Config.navType == 0) {
                    TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: '0px' });
                }
                TweenMax.to(document.getElementById('mod-sub-btn'), 0.3, { bottom: '0px' });
            }
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { opacity: 0, display: "none" });
            TweenMax.delayedCall(0.4, function() { 
                Config.blockSubBtn = false;
                Draggable.get(document.getElementById('mod-subtitle')).disable();
                TweenMax.set(document.getElementById('mod-subtitle'), { top: Config.maxSubY + "px" });
            });
        }
        break;
        case 1:
        {
            var posY = 0 - document.getElementById('mod-frames').offsetHeight;
            TweenMax.to(document.getElementById('mod-subtitle'), 0.3, { opacity: 0, display: "none" });
            var subBtnY = 0 - (document.getElementById("mod-sub-btn").offsetHeight / 2);
            TweenMax.to(document.getElementById("mod-sub-btn"), 0.3, { bottom: '0px' });
            if (Config.navType == 0) {
                TweenMax.to(document.getElementById('mod-navi'), 0.3, { bottom: '0px' });
            }
            TweenMax.delayedCall(0.4, function() { 
                Config.blockSubBtn = false;
                TweenMax.set(document.getElementById('mod-subtitle'), { bottom: posY + 'px' });
            });
        }
        break;
    }
};
PopupManager.subTextPrev = function() {
    if (document.getElementById('btn-subtxt-prev-icn').style.display == 'none') {
        return;
    }
    var subTxt = document.getElementById('subTxt');
    var currT = subTxt.offsetTop;
    var nextT = currT + Config.subtitleFS;
    document.getElementById('btn-subtxt-next-icn').style.display = 'block';
    if (nextT >= 0) {
        nextT = 0;
        document.getElementById('btn-subtxt-prev-icn').style.display = 'none';
    }
    subTxt.style.top = nextT + 'px';
};
PopupManager.subTextNext = function() {
    if (document.getElementById('btn-subtxt-next-icn').style.display == 'none') {
        return;
    }
    var subTxt = document.getElementById('subTxt');
    var currT = subTxt.offsetTop;
    var nextT = currT - Config.subtitleFS;
    document.getElementById('btn-subtxt-prev-icn').style.display = 'block';
    if (nextT <= (document.getElementById('box-subtitle').offsetHeight - (subTxt.offsetHeight + Config.subtitleFS))) {
        nextT = (document.getElementById('box-subtitle').offsetHeight - (subTxt.offsetHeight + Config.subtitleFS));
        document.getElementById('btn-subtxt-next-icn').style.display = 'none';
    }
    subTxt.style.top = nextT + 'px';
};