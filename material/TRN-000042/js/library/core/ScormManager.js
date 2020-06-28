/////////////////////////////////////////////////////////
//ScormManager.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Initialize ScormManager
var ScormManager = {
    dtmSessionTime: new Date()
};
ScormManager.getCMIString = function(_type) {
    var retCMI = "";
    switch (Config.scorm.version) {
        case '1.2':
        {
            switch (_type) {
                case "location": { retCMI = "cmi.core.lesson_location"; } break;
                case "score": { retCMI = "cmi.core.score.raw"; } break;
                case "time": { retCMI = "cmi.core.session_time"; } break;
            }
        }
        break;
        case '2004':
        {
            switch (_type) {
                case "location": { retCMI = "cmi.location"; } break;
                case "score": { retCMI = "cmi.score.scaled"; } break;
                case "time": { retCMI = "cmi.session_time"; } break;
            }
        }
        break;
    }
    return retCMI;
};
ScormManager.scromTracking = function() {
    if (!Config.bScorm) return;
    Config.lmsConnected = Config.scorm.init();
    if (Config.lmsConnected) {
        ScormManager.dtmSessionTime = new Date();
        var compStat = Config.scorm.get("cmi.core.lesson_status");
        var lessLocal = Config.scorm.get(ScormManager.getCMIString("location"));
        if (lessLocal != "" && lessLocal != " ") {
            var arrLessLoc = lessLocal.split(',');
            for (var i = 0; i < Config.nContent.length; i++) {
                Config.lessonLocation[i] = parseInt(arrLessLoc[i]);
            }
            for (var j = parseInt(Config.nContent.length); j < parseInt(Config.nContent.length + Config.contentIDs.length); j++) {
                Config.sceneLocation[j - parseInt(Config.nContent.length)] = parseInt(arrLessLoc[j]);
            }
            var k = parseInt(Config.nContent.length + Config.contentIDs.length);
            Config.currPage = parseInt(arrLessLoc[k]);
            Config.currScene = parseInt(arrLessLoc[k + 1]);
        } else {
            ScormManager.setLmsLocation();
        }
        var tScore
        tScore = Config.scorm.get(ScormManager.getCMIString('score'));
        if (tScore == "" || tScore == " ") {
            Config.scoreRaw = 0;
        } else {
            Config.scoreRaw = parseInt(tScore);
        }
        if (compStat === 'completed' || compStat === 'passed') {
            Config.lessonStatus = 'completed';
        } else {
            Config.lessonStatus = 'incomplete';
        }
    }
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
};
ScormManager.setLmsStatus = function() {
    if (!Config.bScorm) return;
    if (Config.lmsConnected) {
        var success = Config.scorm.set("cmi.core.lesson_status", "completed");
        if (success) {
            Config.scorm.save();
        }
    }
};
ScormManager.setLmsScore = function() {
    if (!Config.bScorm) return;
    if (Config.lmsConnected) {
        var success = Config.scorm.set(ScormManager.getCMIString('score'), Config.scoreRaw.toString());
        if (success) {
            Config.scorm.save();
        }
    }
};
ScormManager.setLmsLocation = function() {
    if (!Config.bScorm) return;
    if (Config.lmsConnected) {
        var tmpLoc = [];
        var i;
        for (i = 0; i < Config.lessonLocation.length; i++) {
            tmpLoc.push(Config.lessonLocation[i]);
        }
        for (i = 0; i < Config.sceneLocation.length; i++) {
            tmpLoc.push(Config.sceneLocation[i]);
        }
        tmpLoc.push(Config.currPage);
        tmpLoc.push(Config.currScene);
        var success = Config.scorm.set(ScormManager.getCMIString('location'), tmpLoc.toString());
        if (success) {
            Config.scorm.save();
        }
    }
};
ScormManager.setLmsSession = function() {
    if (!Config.bScorm) return;
    if (Config.lmsConnected) {
        var dtm = new Date();
        var tm = dtm.getTime() - ScormManager.dtmSessionTime.getTime();
        var success = Config.scorm.set(ScormManager.getCMIString('time'), ScormManager.MillisecondsToCMIDuration(tm));
        if (success) {
            Config.scorm.save();
        }
    }
};
ScormManager.MillisecondsToCMIDuration = function(n) {
    var hms = "";
    var dtm = new Date();
    dtm.setTime(n);
    var h = "000" + Math.floor(n / 3600000);
    var m = "0" + dtm.getMinutes();
    var s = "0" + dtm.getSeconds();
    var cs = "0" + Math.round(dtm.getMilliseconds() / 10);
    switch (Config.scorm.version) {
        case "1.2":
            {
                hms = h.substr(h.length-4)+":"+m.substr(m.length-2)+":";
                hms += s.substr(s.length-2)+"."+cs.substr(cs.length-2);
            }
            break;
        case "2004":
            {
                hms = "PT" + h.substr(h.length-4)+"H"+m.substr(m.length-2)+"M";
                hms += s.substr(s.length-2)+"S";
            }
            break;
    }
    return hms;
};
ScormManager.checkCompleted = function() {
    var locStr = Config.lessonLocation.toString();
    var conStr = Config.nContent.toString();
    if (locStr == conStr) {
        Config.lessonStatus = "completed";
        ScormManager.setLmsStatus();
        ScormManager.setLmsSession(); //save session time
    }
};
ScormManager.updateLms = function() {
    if (!Config.bScorm) return;
    var c = parseInt(Config.contentIDs[Config.page].substr(4,2)) - 1;
    var p = parseInt(Config.contentIDs[Config.page].substr(7,2));
    if (Config.lessonLocation[c] < p) {
        Config.lessonLocation[c] = p;
    }
    ScormManager.setLmsLocation();
    ScormManager.checkCompleted();
    PopupManager.updateBookmark();
};
ScormManager.updateChapLms = function() {
    if (!Config.bScorm) return;
    var c = parseInt(Config.contentIDs[Config.page].substr(4,2)) - 1;
    var p = parseInt(Config.nContent[c]);
    if (Config.lessonLocation[c] < p) {
        Config.lessonLocation[c] = p;
    }
    ScormManager.setLmsLocation();
    ScormManager.checkCompleted();
    PopupManager.updateBookmark();
};