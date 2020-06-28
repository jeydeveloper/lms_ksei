/////////////////////////////////////////////////////////
//Config.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Browser & Mobile Detection
var md = new MobileDetect(window.navigator.userAgent); //Mobile Browser
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0; //Opera 8.0+
var isFirefox = typeof InstallTrigger !== 'undefined'; //Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0; //At least Safari 3+: "[object HTMLElementConstructor]"
var isIE = /*@cc_on!@*/false || !!document.documentMode; //Internet Explorer 6-11
var isEdge = !isIE && !!window.StyleMedia; //Edge 20+
var isChrome = !!window.chrome && !!window.chrome.webstore; //Chrome 1+
var isBlink = (isChrome || isOpera) && !!window.CSS; //Blink engine detection
if (isIE) {
    var strError = "Your browser not fully support HTML5 and CSS3.\nPlease use one of the browser listed below for better experience.\n- Google Chrome. (latest version recommended)\n- Mozilla FireFox. (latest version recommended)\n- Safari. (latest version recommended)\n- Opera. (latest version recommended)\n- Microsoft Edge. (latest version recommended)\n\nBrowser Anda tidak sepenuhnya mendukung HTML5 dan CSS3.\nSilakan gunakan salah satu browser yang tercantum di bawah untuk pengalaman yang lebih baik.\n- Google Chrome. (Versi terbaru dianjurkan)\n- Mozilla FireFox. (Versi terbaru dianjurkan)\n- Safari. (Versi terbaru dianjurkan)\n- Opera. (Versi terbaru dianjurkan)\n- Microsoft Edge. (Versi terbaru dianjurkan)";
    window.alert(strError);
}
/////////////////////////////////////////////////////////
//Initializing Config
pipwerks.SCORM.version = "1.2";
var Config = {
    cAnim: {},
    cSymAnim: {},
    nContent: [],
    contentIDs: [],
    chapTitle: [],
    sceneLocation: [],
    lessonLocation: [],
    modul: 0,
    page: 0,
    endPage: 0,
    lastPage: 0,
    currPage: 0,
    currScene: 0,
    scoreRaw: 0,
    frameObj: 1,
    breakIdx: -1,
    layoutType: 0,
    slidingType: 0,
    helpType: 0,
    indexLType: 0,
    glossType: 0,
    navType: 0,
    subType: 0,
    colNav: 0,
    navWidth: 0,
    maxSubX: 0,
    maxSubY: 0,
    modulTitleFS: 0,
    chapTitleFS: 0,
    subtitleFS: 0,
    audio: null,
    audioBGM: null,
    preloaderF: null,
    helpF: null,
    indexLF: null,
    glossF: null,
    screenF: null,
    volumeF: null,
    content1F: null,
    content2F: null,
    content3F: null,
    pdfF: null,
    pdfFBody: null,
    hypeHelp: null,
    hypeIndexL: null,
    hypeGloss: null,
    hypeVolume: null,
    hypeScreen: null,
    hypeContent: null,
    intervalFunction: null,
    bScorm: true,
    bLock: false,
    firstLoad: true,
    nextState: false,
    prevState: false,
    jumpingState: false,
    lmsConnected: false,
    contentPaused: false,
    bNextContent: false,
    menuOpen: false,
    helpOpen: false,
    indexLOpen: false,
    glossOpen: false,
    volumeOpen: false,
    debugLayout: false,
    debugMode: false,
    useAudio: false,
    useBackSound: false,
    useScreenWindow: false,
    useHelpWindow: false,
    useIndexLWindow: false,
    useGlossWindow: false,
    useVolumeWindow: false,
    useSubtitle: false,
    dynamicBGColor: false,
    showNavButton: false,
    showSubWindow: false,
    canOpenSubWindow: false,
    blockSubBtn: false,
    checkingLastPage: false,
    preloaderState: false,
    autoUpdateSub: false,
    resetSubTxt: false,
    subtitleOpened: false,
    subtitleNotEmpty: false,
    modulTitle: "",
    lessonStatus: "incomplete",
    scorm: pipwerks.SCORM,
    setContentIDs: function() {
        var strM = "";
        if (Config.modul > 9) {
            strM = "m" + Config.modul;
        } else {
            strM = "m0" + Config.modul;
        }
        for (var i = 0; i < Config.nContent.length; i++) {
            for (var j = 0; j < Config.nContent[i]; j++) {
                var tmpStr = "";
                if (i > 8) {
                    if (j > 8) {
                        tmpStr = strM + "c" + (i + 1) + "p" + (j + 1);
                    } else {
                        tmpStr = strM + "c" + (i + 1) + "p0" + (j + 1);
                    }
                } else {
                    if (j > 8) {
                        tmpStr = strM + "c0" + (i + 1) + "p" + (j + 1);
                    } else {
                        tmpStr = strM + "c0" + (i + 1) + "p0" + (j + 1);
                    }
                }
                Config.contentIDs.push(tmpStr);
            }
        }
        Config.endPage = (Config.contentIDs.length - 1);
    },
    setLocation: function() {
        Config.sceneLocation = [];
        Config.lessonLocation = [];
        if (Config.bLock) {
            for (var i = 0; i < Config.nContent.length; i++) {
                Config.lessonLocation.push(0);
            }
        } else {
            for (var i = 0; i < Config.nContent.length; i++) {
                Config.lessonLocation.push(Config.nContent[i]);
            }
        }
        for (var j = 0; j < Config.contentIDs.length; j++) {
            Config.sceneLocation.push(0);
        }
    }
};
/////////////////////////////////////////////////////////
//Initializing AudioConfig
var AudioConfig = {
    bgmSize: 0,
    sfxSize: 0,
    bgmVol: 0.7,
    audioVol: 1,
    playedIDBGM: -1,
    playedIDSFX: -1,
    playedIDAudio: null,
    bgmSprite: {},
    audioSprite: [],
    allMuteState: false,
    bgmMuteState: false,
    audioMuteState: false,
    useContinue: false,
    BGMID: null,
    SFXID: null,
    callBack: null,
    setAudioSprite: null,
    symbolID: ""
};
/////////////////////////////////////////////////////////
//Print Debug Message
function debugMsg(_msg) {
    if (Config.debugMode) {
        console.log(_msg);
    }
}
/////////////////////////////////////////////////////////
//Ensure we handle window closing properly
var unloaded = false;
function unloadHandler() {
	if(!unloaded) {
        if (Config.bScorm) {
		    Config.scorm.save(); //save all data that has already been sent
		    Config.scorm.quit(); //close the SCORM API connection properly
        }
        unloaded = true;
		document.getElementById('mod-wrapper').innerHTML = '<iframe id="glossaryF" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="helpF" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="screenF" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="indexListF" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="audioF" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="content-1F" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="content-2F" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe><iframe id="content-3F" type="text/html" frameborder="0" scrolling="no" src="about:blank"></iframe>';
	}
}
window.onbeforeunload = unloadHandler;
window.onunload = unloadHandler;