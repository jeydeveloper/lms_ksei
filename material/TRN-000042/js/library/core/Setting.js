/////////////////////////////////////////////////////////
//Setting.js
//Author : Ikhsan Nurrahim
//E-mail : ikhsan@netpolitanteam.com
/////////////////////////////////////////////////////////
//Modul Setting
Config.debugMode = true; //debug console
Config.debugLayout = true; //debug screen
Config.layoutType = 0; // 0 = scalling, 1 = responsive
Config.bLock = false; // true = konten di lock, false = bisa langsung next prev
Config.bScorm = true; //keperluan scorm harus true
Config.slidingType = 0; //0 = kiri - kanan, 1 = atas - bawah, 2 = fade in / out, 3 = zoom in /out
Config.helpType = 0; //0 = full screen, 1 / 2 = half screen 
Config.indexLType = 0; //0 = full screen, 1 / 2 = half screen 
Config.glossType = 0; //0 = full screen, 1 / 2 = half screen 
Config.navType = 0; //0 = icon navigation left bottom, 1 = half screen left top, 2 = middle top half circle
Config.subType = 0; //0 = Audio Text Bubble (Draggable), 1 = Movie like Subtitle
Config.useAudio = true; //false = no audio, true = with audio
Config.useBackSound = false; //false = no bgm & sfx, true = with bgm & sfx
Config.useScreenWindow = false; //false = no screen, true = with screen
Config.useHelpWindow = true; //false = no help, true = with help
Config.useIndexLWindow = true; //false = no index, true = with index
Config.useGlossWindow = false; //false = no glossary, true = with glossary
Config.useVolumeWindow = true; //false = no audio/volume, true = with audio/volume
Config.useSubtitle = true; //false = no subtitle, true = with subtitle
Config.autoUpdateSub = true; //false = harus panggil fungsinya manual dari content, true = otomatis sesuai id sound dikurang 1
Config.resetSubTxt = false; //true = text subtitle akan dihapus setelah audio selesai, false = text subtitle akan tetap ada setelah audio selesai
Config.dynamicBGColor = true; //false = box view, true = no box view
Config.modul = 0; //modul berapa
Config.nContent = [1,1,1,1,1,1]; //jumlah page per chapter
Config.setContentIDs(); //no edit
Config.setLocation(); //no edit
Config.modulTitleFS = 25; //Modul Title Font Size
Config.chapTitleFS = 20; //Chapter Title Font Size
Config.subtitleFS = 15; //Subtitle Font Size
Config.modulTitle = "Fasilitas AKSes KSEI"; //judul modul
Config.chapTitle = ["Intro","Fasilitas AKSes KSEI","Partisipan-Partisipan KSEI","SID dan SRE", "Rekening Dana Nasabah","Penutup"]; //judul chapter / sub judul / sub title
/////////////////////////////////////////////////////////
//Audio Setting
AudioConfig.bgmSprite = {
    bgm: [0, 48000, true]
};
AudioConfig.bgmSize = 1; //jumlah bgm yang dipakai
AudioConfig.sfxSize = 0; //jumlah sfx yang dipakai
AudioConfig.setAudioSprite = function() {
    var sprite = {};
    AudioConfig.audioSprite = [];
    //Page 1 (m0Xc01p01)
    sprite = {
        m00c01p01_0 : [0, 500]
    };
    AudioConfig.audioSprite.push(sprite);
    //Page 2 (m0Xc02p01)
    sprite = {
        m00c02p01_0 : [0, 500],
        m00c02p01_1 : [953, 8000],
        m00c02p01_2 : [9961, 8300],
        m00c02p01_3 : [18947, 5000],
        m00c02p01_4 : [25319, 3000],
        m00c02p01_5 : [28677, 4800],
        m00c02p01_6 : [35348, 21600],
        m00c02p01_7 : [58420, 8500],
        m00c02p01_8 : [70262, 6900]
    };
    AudioConfig.audioSprite.push(sprite);
    //Page 3 (m0Xc03p01)
    sprite = {
        m00c03p01_0 : [0, 500],
        m00c03p01_1 : [1000, 7800],
        m00c03p01_2 : [9943, 19300]
    };
    AudioConfig.audioSprite.push(sprite);
    //Page 4 (m0Xc03p01)
    sprite = {
        m00c04p01_0 : [0, 500],
        m00c04p01_1 : [705, 13600],
        m00c04p01_2 : [15125, 14300],
        m00c04p01_3 : [30055, 9400],
        m00c04p01_4 : [40551, 11000],
        m00c04p01_5 : [52926, 14211]
    };
    AudioConfig.audioSprite.push(sprite);
    //Page 5 (m0Xc03p01)
    sprite = {
        m00c05p01_0 : [0, 500],
        m00c05p01_1 : [500, 7000],
        m00c05p01_2 : [8160, 3600],
        m00c05p01_3 : [12695, 3400]
    };
    AudioConfig.audioSprite.push(sprite);
    //Page 5 (m0Xc03p01)
    sprite = {
        m00c06p01_0 : [0, 500],
        m00c06p01_1 : [1000, 4100],
        m00c06p01_2 : [6160, 8600],
        m00c06p01_3 : [15799, 3600],
        m00c06p01_4 : [20485, 7300],
        m00c06p01_5 : [28772, 6900],
        m00c06p01_6 : [36935, 3700]
    };
    AudioConfig.audioSprite.push(sprite);
    debugMsg("AudioSprite list loaded, size : " + AudioConfig.audioSprite.length);
};
AudioConfig.setAudioSprite();