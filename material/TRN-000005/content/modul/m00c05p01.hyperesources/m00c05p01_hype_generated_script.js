//	HYPE.documents["m00c05p01"]

(function(){(function k(){function l(a,b,d){var c=!1;null==window[a]&&(null==window[b]?(window[b]=[],window[b].push(k),a=document.getElementsByTagName("head")[0],b=document.createElement("script"),c=h,false==!0&&(c=""),b.type="text/javascript",b.src=c+"/"+d,a.appendChild(b)):window[b].push(k),c=!0);return c}var h="m00c05p01.hyperesources",c="m00c05p01",e="m00c05p01_hype_container";if(false==!1)try{for(var f=document.getElementsByTagName("script"),
a=0;a<f.length;a++){var b=f[a].src,d=null!=b?b.indexOf("m00c05p01_hype_generated_script.js"):-1;if(-1!=d){h=b.substr(0,d-1);break}}}catch(n){}if(false==!1&&(a=navigator.userAgent.match(/MSIE (\d+\.\d+)/),a=parseFloat(a&&a[1])||null,a=l("HYPE_578","HYPE_dtl_578",!0==(null!=a&&10>a||false==!0)?"HYPE-578.full.min.js":"HYPE-578.thin.min.js"),false==!0&&(a=a||l("HYPE_w_578","HYPE_wdtl_578","HYPE-578.waypoints.min.js")),a))return;f=window.HYPE.documents;
if(null!=f[c]){b=1;a=c;do c=""+a+"-"+b++;while(null!=f[c]);d=document.getElementsByTagName("div");b=!1;for(a=0;a<d.length;a++)if(d[a].id==e&&null==d[a].getAttribute("HYP_dn")){var b=1,g=e;do e=""+g+"-"+b++;while(null!=document.getElementById(e));d[a].id=e;b=!0;break}if(!1==b)return}b=[];b=[{name:"onNextContent",source:"function(hypeDocument, element, event) {\tModulHelper.nextContent();\n}",identifier:"50"},{name:"hostTalk1",source:"function(hypeDocument, element, event) {\thypeDocument.getSymbolInstanceById('host_mouth').goToTimeInTimelineNamed(1, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_mouth').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\thypeDocument.getSymbolInstanceById('host_eye').goToTimeInTimelineNamed(1, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_eye').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\thypeDocument.getSymbolInstanceById('host_body').goToTimeInTimelineNamed(1, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_body').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n}",identifier:"418"},{name:"hostSilent1",source:"function(hypeDocument, element, event) {\thypeDocument.getSymbolInstanceById('host_mouth').goToTimeInTimelineNamed(0, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_mouth').pauseTimelineNamed('Main Timeline');\n\t\n\thypeDocument.getSymbolInstanceById('host_body').goToTimeInTimelineNamed(0, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_body').pauseTimelineNamed('Main Timeline');\n\t\n}",identifier:"419"},{name:"hostHai",source:"function(hypeDocument, element, event) {\thypeDocument.getSymbolInstanceById('host_body').goToTimeInTimelineNamed(6, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_body').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\thypeDocument.getSymbolInstanceById('host').goToTimeInTimelineNamed(6, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n}",identifier:"447"},{name:"hostStop",source:"function(hypeDocument, element, event) {\t\n\thypeDocument.getSymbolInstanceById('host_body').goToTimeInTimelineNamed(9, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_body').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\thypeDocument.getSymbolInstanceById('host').goToTimeInTimelineNamed(8, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n}",identifier:"448"},{name:"hostTalk2",source:"function(hypeDocument, element, event) {\thypeDocument.getSymbolInstanceById('host_mouth').goToTimeInTimelineNamed(1, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_mouth').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\thypeDocument.getSymbolInstanceById('host_body').goToTimeInTimelineNamed(11, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_body').continueTimelineNamed('Main Timeline', hypeDocument.kDirectionForward);\n\t\n\t\n}",identifier:"476"},{name:"hostSilent2",source:"function(hypeDocument, element, event) {\thypeDocument.getSymbolInstanceById('host_mouth').goToTimeInTimelineNamed(0, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('host_mouth').pauseTimelineNamed('Main Timeline');\n\t\n\t\n}",identifier:"477"},{name:"onPlayAudio_1",source:"function(hypeDocument, element, event) {\t// 1 = id sound\n\t// false = continue (true) / tidak (false)\n\t// null = nama id symbol yang mau di auto continue timeline (kondisinya true) \"\"\n\t// null = fungsi tambahan setelah\n\tModulHelper.playAudio(1, false, null, null);\n}",identifier:"481"},{name:"onPlayAudio_2",source:"function(hypeDocument, element, event) {\tModulHelper.playAudio(2, false, null, null);\n}",identifier:"482"},{name:"onPlayAudio_3",source:"function(hypeDocument, element, event) {\tModulHelper.playAudio(3, false, null, null);\n}",identifier:"483"},{name:"onPlayAudio_4",source:"function(hypeDocument, element, event) {\tModulHelper.playAudio(4, false, null, null);\n}",identifier:"484"},{name:"onPrevContent",source:"function(hypeDocument, element, event) {\tModulHelper.prevContent();\n\t\n}",identifier:"793"},{name:"onStopMouth",source:"function(hypeDocument, element, event) {\tvar layID = ModulHelper.mParent.Config.breakIdx;\n\n\thypeDocument.getSymbolInstanceById('mouth_1_' + layID).goToTimeInTimelineNamed(0, 'Main Timeline');\n\thypeDocument.getSymbolInstanceById('mouth_1_' + layID).pauseTimelineNamed('Main Timeline');\n\t\n}",identifier:"940"},{name:"stopAudio",source:"function(hypeDocument, element, event) {\tModulHelper.stopAudio();\n\t\n}",identifier:"1703"}];d={};g={};for(a=0;a<b.length;a++)try{g[b[a].identifier]=b[a].name,d[b[a].name]=eval("(function(){return "+b[a].source+"})();")}catch(m){window.console&&window.console.log(m),d[b[a].name]=
function(){}}a=new HYPE_578(c,e,{"3":{p:1,n:"next3_2x.png",g:"738",o:true,t:"@2x"},"12":{p:1,n:"car_eye_left-min.png",g:"840",t:"@1x"},"21":{p:1,n:"car_feet_left-min.png",g:"862",t:"@1x"},"4":{p:1,n:"next2.png",g:"740",o:true,t:"@1x"},"30":{p:1,n:"car3_arm_right-min.png",g:"1167",t:"@1x"},"13":{p:1,n:"car_eye_right-min.png",g:"842",t:"@1x"},"5":{p:1,n:"next2_2x.png",g:"740",o:true,t:"@2x"},"22":{p:1,n:"car_hand_right_2-min.png",g:"957",t:"@1x"},"6":{p:1,n:"next1.png",g:"742",o:true,t:"@1x"},"31":{p:1,n:"car3_hand_left-min.png",g:"1169",t:"@1x"},"14":{p:1,n:"car_eyebrow_left-min.png",g:"844",t:"@1x"},"7":{p:1,n:"next1_2x.png",g:"742",o:true,t:"@2x"},"23":{p:1,n:"car2_eye_right-min.png",g:"1139",t:"@1x"},"40":{p:1,n:"bubble2-min.png",g:"1607",t:"@1x"},"32":{p:1,n:"car3_hand_right-min.png",g:"1172",t:"@1x"},"15":{p:1,n:"car_eyebrow_right-min.png",g:"846",t:"@1x"},"8":{p:1,n:"car_body-min.png",g:"832",t:"@1x"},"24":{p:1,n:"car2_eye_left-min.png",g:"1141",t:"@1x"},"9":{p:1,n:"car_face_1-min.png",g:"834",t:"@1x"},"33":{p:1,n:"car3_feet_right-min.png",g:"1176",t:"@1x"},"16":{p:1,n:"car_lip_1-min.png",g:"850",t:"@1x"},"41":{p:1,n:"background-min-1.png",g:"1654",t:"@1x"},"25":{p:1,n:"car3_body-min.png",g:"1154",t:"@1x"},"42":{p:1,n:"tujuan-min.png",g:"1656",t:"@1x"},"34":{p:1,n:"car3_feet_left-min.png",g:"1178",t:"@1x"},"17":{p:1,n:"car_hand_left-min.png",g:"852",t:"@1x"},"43":{p:1,n:"icon5-min.png",g:"1659",t:"@1x"},"26":{p:1,n:"car3_arm_left-min.png",g:"1156",t:"@1x"},"35":{p:1,n:"background-min.png",g:"1456",t:"@1x"},"18":{p:1,n:"car_thigh_left-min.png",g:"856",t:"@1x"},"44":{p:1,n:"icon4-min.png",g:"1661",t:"@1x"},"27":{p:1,n:"car3_face-min.png",g:"1161",t:"@1x"},"36":{p:1,n:"shadow2-min.png",g:"1458",t:"@1x"},"19":{p:1,n:"car_thigh_right-min.png",g:"858",t:"@1x"},"45":{p:1,n:"icon3-min.png",g:"1663",t:"@1x"},"28":{p:1,n:"car3_hair-min.png",g:"1163",t:"@1x"},"-1":{n:"PIE.htc"},"37":{p:1,n:"shadow1-min.png",g:"1460",t:"@1x"},"46":{p:1,n:"icon2-min.png",g:"1665",t:"@1x"},"29":{p:1,n:"car3_lip-min.png",g:"1165",t:"@1x"},"-2":{n:"blank.gif"},"38":{p:1,n:"bubble1-min.png",g:"1590",t:"@1x"},"47":{p:1,n:"icon1-min.png",g:"1667",t:"@1x"},"39":{p:1,n:"nametag-min.png",g:"1592",t:"@1x"},"10":{p:1,n:"car_arm_left-min.png",g:"836",t:"@1x"},"0":{p:1,n:"next4.png",g:"736",o:true,t:"@1x"},"1":{p:1,n:"next4_2x.png",g:"736",o:true,t:"@2x"},"11":{p:1,n:"car_arm_right-min.png",g:"838",t:"@1x"},"2":{p:1,n:"next3.png",g:"738",o:true,t:"@1x"},"20":{p:1,n:"car_feet_right-min.png",g:"860",t:"@1x"}},h,["<style>\n    @font-face {\n        font-family: 'Calibri';\n        src: url('../../fonts/Calibri.eot');\n        src: url('../../fonts/Calibri.eot') format('embedded-opentype'),\n             url('../../fonts/Calibri.woff2') format('woff2'),\n             url('../../fonts/Calibri.woff') format('woff'),\n             url('../../fonts/Calibri.ttf') format('truetype'),\n             url('../../fonts/Calibri.svg#Calibri') format('svg');\n        font-weight: normal;\n        font-style: normal;\n    }\n    @font-face {\n        font-family: 'Calibri';\n        src: url('../../fonts/CalibriItalic.eot');\n        src: url('../../fonts/CalibriItalic.eot') format('embedded-opentype'),\n             url('../../fonts/CalibriItalic.woff2') format('woff2'),\n             url('../../fonts/CalibriItalic.woff') format('woff'),\n             url('../../fonts/CalibriItalic.ttf') format('truetype'),\n             url('../../fonts/CalibriItalic.svg#CalibriItalic') format('svg');\n        font-weight: normal;\n        font-style: italic;\n    }\n    @font-face {\n        font-family: 'Calibri';\n        src: url('../../fonts/CalibriBold.eot');\n        src: url('../../fonts/CalibriBold.eot') format('embedded-opentype'),\n             url('../../fonts/CalibriBold.woff2') format('woff2'),\n             url('../../fonts/CalibriBold.woff') format('woff'),\n             url('../../fonts/CalibriBold.ttf') format('truetype'),\n             url('../../fonts/CalibriBold.svg#CalibriBold') format('svg');\n        font-weight: bold;\n        font-style: normal;\n    }\n    @font-face {\n        font-family: 'Calibri';\n        src: url('../../fonts/CalibriBoldItalic.eot');\n        src: url('../../fonts/CalibriBoldItalic.eot') format('embedded-opentype'),\n             url('../../fonts/CalibriBoldItalic.woff2') format('woff2'),\n             url('../../fonts/CalibriBoldItalic.woff') format('woff'),\n             url('../../fonts/CalibriBoldItalic.ttf') format('truetype'),\n             url('../../fonts/CalibriBoldItalic.svg#CalibriBoldItalic') format('svg');\n        font-weight: bold;\n        font-style: italic;\n    }\n</style>"],d,[{n:"scene_1",o:"1545",X:[0]},{n:"scene_2",o:"1616",X:[1]}],[{o:"1576",p:"600px",cA:false,Y:1024,Z:576,L:[],c:"#B9B9EA",bY:1,d:769,U:{"1752":{V:{"Main Timeline":"1760"},W:"1760",n:"lip_1"},"1712":{V:{"Main Timeline":"1757"},W:"1757",n:"clue_prev"},"1717":{V:{"Main Timeline":"1758"},W:"1758",n:"clue_next"},"1708":{V:{"Main Timeline":"1756"},W:"1756",n:"mc_pulse 2"},"1747":{V:{"Main Timeline":"1759"},W:"1759",n:"Symbol 2"}},T:{"1757":{c:"1712",z:1,i:"1757",n:"Main Timeline",a:[{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1716"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1716"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1716"},{f:"c",y:0,z:0.15,i:"a",e:3,s:57,o:"1714"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1715"},{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1715"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1715"},{f:"c",y:0.15,z:0.15,i:"a",e:57,s:3,o:"1714"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1716"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1715"},{f:"c",p:2,y:1,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1757",p:9,symbolOid:"750"}]},o:"1757"},{y:1,i:"cR",s:1,z:0,o:"1716",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1716",f:"c"},{y:1,i:"a",s:57,z:0,o:"1714",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1715",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1715",f:"c"},{y:1,i:"e",s:0,z:0,o:"1716",f:"c"},{y:1,i:"e",s:0,z:0,o:"1715",f:"c"}],f:30,b:[]},"1760":{c:"1752",z:0.15,i:"1760",n:"Main Timeline",a:[{f:"c",y:0,z:0.08,i:"cY",e:"1",s:"0",o:"1754"},{f:"c",y:0,z:0.08,i:"cY",e:"0",s:"1",o:"1753"},{f:"c",y:0.08,z:0.07,i:"cY",e:"1",s:"0",o:"1753"},{f:"c",y:0.08,z:0.07,i:"cY",e:"0",s:"1",o:"1754"},{f:"c",p:2,y:0.15,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1760",p:9,symbolOid:"930"}]},o:"1760"},{y:0.15,i:"cY",s:"1",z:0,o:"1753",f:"c"},{y:0.15,i:"cY",s:"0",z:0,o:"1754",f:"c"}],f:30,b:[]},kTimelineDefaultIdentifier:{i:"kTimelineDefaultIdentifier",n:"Main Timeline",z:18.18,b:[{D:3,H:true,E:true,z:false,F:0,G:0,C:0,b:"1759"},{D:0.15,H:true,E:true,z:false,F:0,G:0,C:1.15,b:"1760"},{D:0.15,H:true,E:true,z:false,F:0,G:0,C:10.15,b:"1760"},{D:1,H:true,E:true,z:false,F:0,G:0,C:15.03,b:"1758"},{D:1,H:true,E:true,z:false,F:0,G:0,C:15.03,b:"1757"},{D:2,H:true,E:true,z:false,F:0,G:0,C:16.18,b:"1756"}],a:[{f:"c",y:0,z:0.15,i:"f",e:-103,s:-2,o:"1733"},{f:"c",y:0.15,z:3,i:"f",e:-103,s:-103,o:"1733"},{f:"h",y:1,z:0.15,i:"cR",e:1,s:0,o:"1727"},{f:"h",y:1,z:0.15,i:"cQ",e:1,s:0,o:"1727"},{f:"h",y:1,z:0.15,i:"f",e:0,s:64,o:"1727"},{f:"c",p:2,y:1.15,z:7,i:"ActionHandler",e:{a:[{p:4,h:"940"}]},s:{a:[{p:4,h:"481"}]},o:"kTimelineDefaultIdentifier"},{f:"c",y:1.15,z:7.15,i:"cR",e:1,s:1,o:"1727"},{f:"c",y:1.15,z:7.15,i:"cQ",e:1,s:1,o:"1727"},{f:"c",y:1.15,z:7.15,i:"f",e:0,s:0,o:"1727"},{f:"c",y:2,z:0.15,i:"f",e:-25,s:107,o:"1741"},{y:2.15,i:"f",s:-25,z:0,o:"1741",f:"c"},{f:"c",y:3.15,z:0.15,i:"b",e:303,s:297,o:"1732"},{f:"c",y:3.15,z:0.15,i:"a",e:1,s:0,o:"1732"},{f:"c",y:3.15,z:0.15,i:"f",e:13,s:0,o:"1732"},{f:"c",y:3.15,z:0.15,i:"f",e:3,s:-103,o:"1733"},{y:4,i:"b",s:303,z:0,o:"1732",f:"c"},{y:4,i:"a",s:1,z:0,o:"1732",f:"c"},{y:4,i:"f",s:13,z:0,o:"1732",f:"c"},{y:4,i:"f",s:3,z:0,o:"1733",f:"c"},{f:"c",p:2,y:8.15,z:2,i:"ActionHandler",e:{a:[{p:4,h:"482"}]},s:{a:[{p:4,h:"940"}]},o:"kTimelineDefaultIdentifier"},{f:"i",y:9,z:0.15,i:"cR",e:0,s:1,o:"1727"},{f:"i",y:9,z:0.15,i:"cQ",e:0,s:1,o:"1727"},{f:"i",y:9,z:0.15,i:"f",e:64,s:0,o:"1727"},{y:9.15,i:"cR",s:0,z:0,o:"1727",f:"h"},{y:9.15,i:"cQ",s:0,z:0,o:"1727",f:"h"},{y:9.15,i:"f",s:64,z:0,o:"1727",f:"h"},{f:"h",y:10,z:0.15,i:"cR",e:1,s:0,o:"1704"},{f:"h",y:10,z:0.15,i:"cQ",e:1,s:0,o:"1704"},{f:"h",y:10,z:0.15,i:"f",e:0,s:51,o:"1704"},{y:10.15,i:"cR",s:1,z:0,o:"1704",f:"c"},{y:10.15,i:"cQ",s:1,z:0,o:"1704",f:"c"},{f:"c",p:2,y:10.15,z:3.18,i:"ActionHandler",e:{a:[{p:4,h:"940"}]},s:{a:[{p:4,h:"482"}]},o:"kTimelineDefaultIdentifier"},{y:10.15,i:"f",s:0,z:0,o:"1704",f:"c"},{f:"c",p:2,y:14.03,z:1.15,i:"ActionHandler",e:{a:[{b:"kTimelineDefaultIdentifier",symbolOid:"1546",p:7}]},s:{a:[{p:4,h:"940"}]},o:"kTimelineDefaultIdentifier"},{f:"c",y:14.18,z:0.15,i:"e",e:1,s:0,o:"1717"},{f:"c",y:14.18,z:0.15,i:"e",e:1,s:0,o:"1712"},{y:15.03,i:"e",s:1,z:0,o:"1717",f:"c"},{y:15.03,i:"e",s:1,z:0,o:"1712",f:"c"},{f:"c",p:2,y:15.18,z:0,i:"ActionHandler",s:{a:[{b:"kTimelineDefaultIdentifier",symbolOid:"1546",p:7}]},o:"kTimelineDefaultIdentifier"}],f:30},"1756":{c:"1708",z:2,i:"1756",n:"Main Timeline",a:[{f:"e",y:0,z:1,i:"c",e:122,s:12,o:"1711"},{f:"e",y:0,z:1,i:"d",e:122,s:12,o:"1711"},{f:"e",y:0,z:1,i:"b",e:-14,s:41,o:"1711"},{f:"e",y:0,z:1,i:"a",e:-14,s:41,o:"1711"},{f:"e",y:0,z:0.15,i:"e",e:1,s:0,o:"1711"},{f:"e",y:0.1,z:1,i:"c",e:122,s:12,o:"1709"},{f:"e",y:0.1,z:1,i:"b",e:-14,s:41,o:"1709"},{f:"e",y:0.1,z:1,i:"a",e:-14,s:41,o:"1709"},{f:"e",y:0.1,z:1,i:"d",e:122,s:12,o:"1709"},{f:"e",y:0.1,z:0.15,i:"e",e:1,s:0,o:"1709"},{f:"e",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1711"},{f:"e",y:0.2,z:1,i:"d",e:122,s:12,o:"1710"},{f:"e",y:0.2,z:1,i:"a",e:-14,s:41,o:"1710"},{f:"e",y:0.2,z:1,i:"b",e:-14,s:41,o:"1710"},{f:"e",y:0.2,z:1,i:"c",e:122,s:12,o:"1710"},{f:"e",y:0.2,z:0.15,i:"e",e:1,s:0,o:"1710"},{f:"e",y:0.25,z:0.15,i:"e",e:0,s:1,o:"1709"},{y:1,i:"a",s:-14,z:0,o:"1711",f:"c"},{y:1,i:"d",s:122,z:0,o:"1711",f:"c"},{y:1,i:"b",s:-14,z:0,o:"1711",f:"c"},{y:1,i:"c",s:122,z:0,o:"1711",f:"c"},{y:1,i:"e",s:0,z:0,o:"1711",f:"c"},{f:"e",y:1.05,z:0.15,i:"e",e:0,s:1,o:"1710"},{y:1.1,i:"c",s:122,z:0,o:"1709",f:"c"},{y:1.1,i:"b",s:-14,z:0,o:"1709",f:"c"},{y:1.1,i:"a",s:-14,z:0,o:"1709",f:"c"},{y:1.1,i:"d",s:122,z:0,o:"1709",f:"c"},{y:1.1,i:"e",s:0,z:0,o:"1709",f:"c"},{y:1.2,i:"c",s:122,z:0,o:"1710",f:"c"},{y:1.2,i:"b",s:-14,z:0,o:"1710",f:"c"},{y:1.2,i:"a",s:-14,z:0,o:"1710",f:"c"},{y:1.2,i:"d",s:122,z:0,o:"1710",f:"c"},{y:1.2,i:"e",s:0,z:0,o:"1710",f:"c"},{f:"c",p:2,y:2,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1756",p:9,symbolOid:"8"}]},o:"1756"}],f:30,b:[]},"1758":{c:"1717",z:1,i:"1758",n:"Main Timeline",a:[{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1718"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1718"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1718"},{f:"c",y:0,z:0.15,i:"a",e:164,s:109,o:"1720"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1721"},{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1721"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1721"},{f:"c",y:0.15,z:0.15,i:"a",e:109,s:164,o:"1720"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1718"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1721"},{f:"c",p:2,y:1,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1758",p:9,symbolOid:"744"}]},o:"1758"},{y:1,i:"cR",s:1,z:0,o:"1718",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1718",f:"c"},{y:1,i:"a",s:109,z:0,o:"1720",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1721",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1721",f:"c"},{y:1,i:"e",s:0,z:0,o:"1718",f:"c"},{y:1,i:"e",s:0,z:0,o:"1721",f:"c"}],f:30,b:[]},"1759":{c:"1747",z:3,i:"1759",n:"Main Timeline",a:[{f:"c",y:0,z:0.15,i:"cR",e:0.30000000000000021,s:1,o:"1750"},{f:"c",y:0,z:0.15,i:"b",e:5,s:3,o:"1748"},{f:"c",y:0,z:0.15,i:"cR",e:0.30000000000000021,s:1,o:"1751"},{f:"c",y:0,z:0.15,i:"b",e:5,s:3,o:"1749"},{f:"c",y:0.15,z:0.15,i:"cR",e:1,s:0.30000000000000021,o:"1750"},{f:"c",y:0.15,z:0.15,i:"b",e:3,s:5,o:"1748"},{f:"c",y:0.15,z:0.15,i:"cR",e:1,s:0.30000000000000021,o:"1751"},{f:"c",y:0.15,z:0.15,i:"b",e:3,s:5,o:"1749"},{y:1,i:"cR",s:1,z:0,o:"1750",f:"c"},{y:1,i:"b",s:3,z:0,o:"1748",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1751",f:"c"},{y:1,i:"b",s:3,z:0,o:"1749",f:"c"},{f:"c",p:2,y:3,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1759",p:9,symbolOid:"934"}]},o:"1759"}],f:30,b:[]}},bZ:180,O:["1724","1725","1723","1731","1755","1746","1727","1704","1706","1728","1712","1715","1721","1717","1716","1730","1705","1718","1722","1729","1707","1726","1713","1719","1714","1720","1748","1747","1749","1750","1751","1708","1754","1752","1753","1710","1709","1711","1738","1740","1739","1741","1734","1732","1742","1733","1744","1743","1735","1737","1736","1745"],n:"layout_0","_":0,v:{"1705":{h:"1607",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:39,j:"absolute",bF:"1704",z:1,k:"div",dB:"img",d:165,c:311,r:"inline"},"1717":{x:"visible",a:746,cA:false,b:190,j:"absolute",r:"inline",c:300,k:"div",z:142,d:217,bY:1,cQ:0.29999999999999999,e:0,bZ:180,bX:false,cV:[],cR:0.29999999999999999},"1729":{G:"#000000",aU:8,c:328,aV:8,d:135,r:"inline",s:"Calibri",t:27,Z:"break-word",w:"Salah satu fasilitas yang akan didapat oleh Investor yaitu mendapatkan Rekening Dana Nasabah (RDN)",bF:"1727",j:"absolute",x:"visible",k:"div",y:"preserve",z:2,aS:8,aT:8,a:72,F:"center",b:59},"1713":{h:"740",p:"no-repeat",x:"visible",a:131,q:"100% 100%",b:54,j:"absolute",bF:"1712",z:81,k:"div",dB:"img",d:110,c:110,r:"inline"},"1725":{h:"1458",p:"no-repeat",x:"visible",a:-142,q:"100% 100%",b:-76,j:"absolute",dB:"img",z:116,k:"div",c:771,d:757,r:"inline",cQ:1,e:1,cR:1},"1737":{h:"856",p:"no-repeat",x:"visible",a:53,q:"100% 100%",b:0,j:"absolute",bF:"1735",z:1,k:"div",dB:"img",d:125,c:70,r:"inline"},"1749":{h:"846",p:"no-repeat",x:"visible",a:80,q:"100% 100%",b:3,j:"absolute",bF:"1747",z:6,k:"div",dB:"img",d:13,c:30,r:"inline"},"1721":{h:"736",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",dB:"img",z:79,k:"div",bF:"1717",d:217,c:217,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1733":{h:"852",p:"no-repeat",x:"visible",tY:0.76000000000000001,q:"100% 100%",b:44,a:8,j:"absolute",z:2,dB:"img",k:"div",d:114,bF:"1732",c:185,r:"inline",f:-2,tX:0.070000000000000007},"1745":{h:"860",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:82,j:"absolute",bF:"1743",z:3,k:"div",dB:"img",d:99,c:112,r:"inline"},"1741":{x:"visible",tY:0.84999999999999998,a:51,b:17,j:"absolute",bF:"1739",z:2,k:"div",c:183,d:123,f:107,tX:0.080000000000000002},"1753":{c:33,d:18,I:"None",cY:"1",e:1,J:"None",K:"None",g:"#FFFFFF",L:"None",M:0,N:0,aI:"50%",A:"#D8DDE4",O:0,x:"visible",j:"absolute",aJ:"50%",k:"div",C:"#D8DDE4",z:8,B:"#D8DDE4",D:"#D8DDE4",aK:"50%",bF:"1752",P:0,a:7,aL:"50%",b:3},"1706":{h:"1592",p:"no-repeat",x:"visible",a:149,q:"100% 100%",b:0,j:"absolute",bF:"1704",z:3,k:"div",dB:"img",d:55,c:185,r:"inline"},"1718":{h:"738",p:"no-repeat",x:"visible",a:24,q:"100% 100%",b:24,j:"absolute",dB:"img",z:80,k:"div",bF:"1717",d:169,c:170,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1714":{h:"742",p:"no-repeat",x:"visible",a:57,q:"100% 100%",b:63,j:"absolute",dB:"img",z:82,k:"div",bF:"1712",d:91,c:127,r:"inline",e:1,f:180},"1726":{c:256,d:156,I:"None",cY:"0",r:"inline",J:"None",K:"None",L:"None",aP:"pointer",M:0,N:0,A:"#D8DDE4",x:"visible",aA:{a:[{p:4,h:"50"}]},O:0,j:"absolute",k:"div",dB:"button",z:144,C:"#D8DDE4",D:"#D8DDE4",B:"#D8DDE4",P:0,a:768,b:225},"1738":{h:"832",p:"no-repeat",x:"visible",a:43,q:"100% 100%",b:279,j:"absolute",bF:"1731",z:5,k:"div",dB:"img",d:246,c:208,r:"inline"},"1710":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:4,B:"#888888",D:"#888888",aK:"50%",bF:"1708",P:5,a:41,aL:"50%",b:41},"1722":{c:266,d:156,I:"None",cY:"0",J:"None",K:"None",L:"None",aP:"pointer",M:0,N:0,A:"#D8DDE4",x:"visible",aA:{a:[{p:4,h:"793"}]},O:0,j:"absolute",k:"div",dB:"button",z:145,C:"#D8DDE4",D:"#D8DDE4",B:"#D8DDE4",P:0,a:0,b:225},"1734":{h:"836",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",bF:"1732",z:1,k:"div",dB:"img",d:154,c:66,r:"inline"},"1746":{x:"visible",tY:1,a:19,b:0,j:"absolute",bF:"1731",z:4,k:"div",c:205,d:304,f:0,tX:0.51000000000000001},"1730":{h:"1590",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:39,j:"absolute",bF:"1727",z:1,k:"div",dB:"img",d:184,c:430,r:"inline"},"1742":{p:"no-repeat",b:39,c:154,q:"100% 100%",d:84,r:"inline",cY:"0",cQ:1,f:0,cR:1,h:"957",bF:"1741",j:"absolute",x:"visible",k:"div",dB:"img",z:2,tX:0.059999999999999998,a:0,tY:0.80000000000000004},"1754":{h:"850",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",cY:"0",z:7,k:"div",dB:"img",d:24,bF:"1752",c:47,r:"inline"},"1707":{G:"#000000",aU:8,c:278,aV:8,d:62,r:"inline",s:"Calibri",t:27,Z:"break-word",w:"Apakah Anda sudah tahu apa tujuan dari RDN? ",bF:"1704",j:"absolute",x:"visible",k:"div",y:"preserve",z:2,aS:8,aT:8,a:10,F:"center",b:61},"1719":{h:"740",p:"no-repeat",x:"visible",a:54,q:"100% 100%",b:54,j:"absolute",bF:"1717",z:81,k:"div",dB:"img",d:110,c:110,r:"inline"},"1750":{h:"840",p:"no-repeat",x:"visible",a:18,q:"100% 100%",b:19,j:"absolute",dB:"img",z:3,k:"div",bF:"1747",d:21,c:21,cQ:1,r:"inline",cR:1},"1715":{h:"736",p:"no-repeat",x:"visible",a:77,q:"100% 100%",b:0,j:"absolute",dB:"img",z:79,k:"div",bF:"1712",d:217,c:217,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1727":{x:"visible",tY:0.72999999999999998,a:426,b:168,j:"absolute",z:119,k:"div",c:445,d:223,cQ:0,f:64,cR:0,tX:0.02},"1739":{x:"visible",tY:0.040000000000000001,a:193,b:281,j:"absolute",bF:"1731",z:3,k:"div",c:130,d:244,f:0,tX:0.23999999999999999},"1711":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:2,B:"#888888",D:"#888888",aK:"50%",bF:"1708",P:5,a:41,aL:"50%",b:41},"1723":{h:"1456",p:"no-repeat",x:"visible",a:-24,q:"100% 100%",b:-7,j:"absolute",dB:"img",z:115,k:"div",c:1072,d:589,r:"inline",cQ:1,e:1,cR:1},"1735":{k:"div",x:"visible",c:123,d:177,z:1,a:23,j:"absolute",bF:"1731",b:508},"1747":{x:"visible",cA:false,a:65,b:154,j:"absolute",bF:"1746",c:110,k:"div",bY:1,d:40,z:2,bX:false,bZ:180,cV:[]},"1731":{x:"visible",tY:0.75,a:189,b:112,j:"absolute",cY:"0",z:118,k:"div",c:323,d:685,r:"inline",f:0,tX:0.47999999999999998},"1743":{k:"div",x:"visible",c:112,d:181,z:2,a:176,j:"absolute",bF:"1731",b:498},"1755":{h:"834",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",bF:"1746",z:1,k:"div",dB:"img",d:304,c:205,r:"inline"},"1708":{x:"visible",a:541,cA:false,b:338,j:"absolute",cY:"0",c:104,k:"div",bY:1,d:104,z:133,r:"none",e:1,bZ:180,bX:false,cV:[]},"1751":{h:"842",p:"no-repeat",x:"visible",a:83,q:"100% 100%",b:19,j:"absolute",dB:"img",z:4,k:"div",bF:"1747",d:21,c:21,r:"inline",cR:1},"1704":{x:"visible",tY:0.97999999999999998,a:505,b:166,j:"absolute",z:120,k:"div",c:334,d:204,cQ:0,f:51,cR:0,tX:0.02},"1716":{h:"738",p:"no-repeat",x:"visible",a:101,q:"100% 100%",b:24,j:"absolute",dB:"img",z:80,k:"div",bF:"1712",d:169,c:170,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1728":{h:"1592",p:"no-repeat",x:"visible",a:260,q:"100% 100%",b:0,j:"absolute",bF:"1727",z:3,k:"div",dB:"img",d:55,c:185,r:"inline"},"1712":{x:"visible",a:-12,cA:false,b:190,j:"absolute",r:"inline",c:300,k:"div",z:143,d:217,bY:1,cQ:0.29999999999999999,e:0,bZ:180,bX:false,cV:[],cR:0.29999999999999999},"1724":{h:"1460",p:"no-repeat",x:"visible",a:363,q:"100% 100%",b:-127,j:"absolute",dB:"img",z:117,k:"div",c:771,d:757,r:"inline",cQ:1,e:1,cR:1},"1736":{h:"862",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:72,j:"absolute",bF:"1735",z:2,k:"div",dB:"img",d:105,c:99,r:"inline"},"1748":{h:"844",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:3,j:"absolute",bF:"1747",z:5,k:"div",dB:"img",d:12,c:44,r:"inline"},"1720":{h:"742",p:"no-repeat",x:"visible",a:109,q:"100% 100%",b:63,j:"absolute",dB:"img",z:82,k:"div",bF:"1717",d:91,c:127,r:"inline",e:1},"1732":{x:"visible",tY:0.080000000000000002,a:0,b:297,j:"absolute",bF:"1731",z:6,k:"div",c:193,d:158,f:0,tX:0.22},"1744":{h:"858",p:"no-repeat",x:"visible",a:3,q:"100% 100%",b:0,j:"absolute",bF:"1743",z:1,k:"div",dB:"img",d:123,c:57,r:"inline"},"1740":{h:"838",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",bF:"1739",z:1,k:"div",dB:"img",d:141,c:79,r:"inline"},"1709":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:3,B:"#888888",D:"#888888",aK:"50%",bF:"1708",P:5,a:41,aL:"50%",b:41},"1752":{x:"visible",i:"mouth_1_0",a:103,b:246,j:"absolute",cY:"0",c:47,k:"div",z:7,d:24,bF:"1746",bY:1,e:1,bZ:180,cA:false,bX:false,cV:[]}}},{o:"1653",p:"600px",cA:false,Y:1024,Z:576,L:[],c:"#FCB526",bY:1,d:769,U:{"1769":{V:{"Main Timeline":"1786"},W:"1786",n:"mc_pulse 2"},"1777":{V:{"Main Timeline":"1787"},W:"1787",n:"clue_prev"},"1764":{V:{"Main Timeline":"1785"},W:"1785",n:"clue_next"}},T:{"1786":{c:"1769",z:2,i:"1786",n:"Main Timeline",a:[{f:"e",y:0,z:1,i:"c",e:122,s:12,o:"1772"},{f:"e",y:0,z:1,i:"d",e:122,s:12,o:"1772"},{f:"e",y:0,z:1,i:"b",e:-14,s:41,o:"1772"},{f:"e",y:0,z:1,i:"a",e:-14,s:41,o:"1772"},{f:"e",y:0,z:0.15,i:"e",e:1,s:0,o:"1772"},{f:"e",y:0.1,z:1,i:"c",e:122,s:12,o:"1770"},{f:"e",y:0.1,z:1,i:"b",e:-14,s:41,o:"1770"},{f:"e",y:0.1,z:1,i:"a",e:-14,s:41,o:"1770"},{f:"e",y:0.1,z:1,i:"d",e:122,s:12,o:"1770"},{f:"e",y:0.1,z:0.15,i:"e",e:1,s:0,o:"1770"},{f:"e",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1772"},{f:"e",y:0.2,z:1,i:"d",e:122,s:12,o:"1771"},{f:"e",y:0.2,z:1,i:"a",e:-14,s:41,o:"1771"},{f:"e",y:0.2,z:1,i:"b",e:-14,s:41,o:"1771"},{f:"e",y:0.2,z:1,i:"c",e:122,s:12,o:"1771"},{f:"e",y:0.2,z:0.15,i:"e",e:1,s:0,o:"1771"},{f:"e",y:0.25,z:0.15,i:"e",e:0,s:1,o:"1770"},{y:1,i:"a",s:-14,z:0,o:"1772",f:"c"},{y:1,i:"d",s:122,z:0,o:"1772",f:"c"},{y:1,i:"b",s:-14,z:0,o:"1772",f:"c"},{y:1,i:"c",s:122,z:0,o:"1772",f:"c"},{y:1,i:"e",s:0,z:0,o:"1772",f:"c"},{f:"e",y:1.05,z:0.15,i:"e",e:0,s:1,o:"1771"},{y:1.1,i:"c",s:122,z:0,o:"1770",f:"c"},{y:1.1,i:"b",s:-14,z:0,o:"1770",f:"c"},{y:1.1,i:"a",s:-14,z:0,o:"1770",f:"c"},{y:1.1,i:"d",s:122,z:0,o:"1770",f:"c"},{y:1.1,i:"e",s:0,z:0,o:"1770",f:"c"},{y:1.2,i:"c",s:122,z:0,o:"1771",f:"c"},{y:1.2,i:"b",s:-14,z:0,o:"1771",f:"c"},{y:1.2,i:"a",s:-14,z:0,o:"1771",f:"c"},{y:1.2,i:"d",s:122,z:0,o:"1771",f:"c"},{y:1.2,i:"e",s:0,z:0,o:"1771",f:"c"},{f:"c",p:2,y:2,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1786",p:9,symbolOid:"8"}]},o:"1786"}],f:30,b:[]},kTimelineDefaultIdentifier:{i:"kTimelineDefaultIdentifier",n:"Main Timeline",z:12.15,b:[{D:1,H:true,E:true,z:false,F:0,G:0,C:9.15,b:"1787"},{D:1,H:true,E:true,z:false,F:0,G:0,C:9.15,b:"1785"},{D:2,H:true,E:true,z:false,F:0,G:0,C:10.15,b:"1786"}],a:[{f:"c",y:0,z:1,i:"cQ",e:1,s:1.3,o:"1782"},{f:"c",y:0,z:1,i:"e",e:1,s:0,o:"1782"},{f:"c",y:0,z:1,i:"cR",e:1,s:1.3,o:"1782"},{f:"g",y:1,z:1,i:"b",e:112,s:99,o:"1773"},{f:"g",y:1,z:1,i:"e",e:1,s:0,o:"1773"},{y:1,i:"cQ",s:1,z:0,o:"1782",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1782",f:"c"},{y:1,i:"e",s:1,z:0,o:"1782",f:"c"},{y:2,i:"b",s:112,z:0,o:"1773",f:"c"},{f:"h",y:2,z:0.15,i:"cQ",e:1,s:0.80000000000000004,o:"1763"},{f:"h",y:2,z:0.15,i:"cR",e:1,s:0.80000000000000004,o:"1763"},{f:"h",y:2,z:0.15,i:"e",e:1,s:0,o:"1763"},{y:2,i:"e",s:1,z:0,o:"1773",f:"c"},{f:"c",p:2,y:2.15,z:8,i:"ActionHandler",e:{a:[{b:"kTimelineDefaultIdentifier",symbolOid:"1546",p:7}]},s:{a:[{p:4,h:"483"}]},o:"kTimelineDefaultIdentifier"},{y:2.15,i:"cQ",s:1,z:0,o:"1763",f:"c"},{y:2.15,i:"cR",s:1,z:0,o:"1763",f:"c"},{y:2.15,i:"e",s:1,z:0,o:"1763",f:"c"},{f:"g",y:3,z:1,i:"b",e:394,s:411,o:"1774"},{f:"g",y:3,z:1,i:"e",e:1,s:0,o:"1774"},{f:"g",y:3.15,z:1,i:"b",e:437,s:418,o:"1761"},{f:"g",y:3.15,z:1,i:"e",e:1,s:0,o:"1761"},{f:"g",y:3.21,z:0.3,i:"b",e:443,s:422,o:"1775"},{f:"g",y:3.21,z:0.3,i:"e",e:1,s:0,o:"1775"},{f:"g",y:4,z:1,i:"b",e:512,s:491,o:"1762"},{y:4,i:"b",s:394,z:0,o:"1774",f:"c"},{f:"g",y:4,z:1,i:"e",e:1,s:0,o:"1762"},{y:4,i:"e",s:1,z:0,o:"1774",f:"c"},{f:"g",y:4.15,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1784"},{f:"g",y:4.15,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1784"},{y:4.15,i:"b",s:437,z:0,o:"1761",f:"c"},{f:"g",y:4.15,z:1,i:"e",e:1,s:0,o:"1784"},{y:4.15,i:"e",s:1,z:0,o:"1761",f:"c"},{y:4.21,i:"b",s:443,z:0,o:"1775",f:"c"},{y:4.21,i:"e",s:1,z:0,o:"1775",f:"c"},{y:5,i:"b",s:512,z:0,o:"1762",f:"c"},{y:5,i:"e",s:1,z:0,o:"1762",f:"c"},{y:5.15,i:"cR",s:1,z:0,o:"1784",f:"c"},{y:5.15,i:"cQ",s:1,z:0,o:"1784",f:"c"},{y:5.15,i:"e",s:1,z:0,o:"1784",f:"c"},{f:"c",y:9,z:0.15,i:"e",e:1,s:0,o:"1777"},{f:"c",y:9,z:0.15,i:"e",e:1,s:0,o:"1764"},{y:9.15,i:"e",s:1,z:0,o:"1777",f:"c"},{y:9.15,i:"e",s:1,z:0,o:"1764",f:"c"},{f:"c",p:2,y:10.15,z:0,i:"ActionHandler",s:{a:[{b:"kTimelineDefaultIdentifier",symbolOid:"1546",p:7}]},o:"kTimelineDefaultIdentifier"}],f:30},"1785":{c:"1764",z:1,i:"1785",n:"Main Timeline",a:[{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1765"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1765"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1765"},{f:"c",y:0,z:0.15,i:"a",e:164,s:109,o:"1767"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1768"},{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1768"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1768"},{f:"c",y:0.15,z:0.15,i:"a",e:109,s:164,o:"1767"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1765"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1768"},{f:"c",p:2,y:1,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1785",p:9,symbolOid:"744"}]},o:"1785"},{y:1,i:"cR",s:1,z:0,o:"1765",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1765",f:"c"},{y:1,i:"a",s:109,z:0,o:"1767",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1768",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1768",f:"c"},{y:1,i:"e",s:0,z:0,o:"1765",f:"c"},{y:1,i:"e",s:0,z:0,o:"1768",f:"c"}],f:30,b:[]},"1787":{c:"1777",z:1,i:"1787",n:"Main Timeline",a:[{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1781"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1781"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1781"},{f:"c",y:0,z:0.15,i:"a",e:3,s:57,o:"1779"},{f:"c",y:0,z:1,i:"cQ",e:1,s:0.70000000000000007,o:"1780"},{f:"c",y:0,z:0.15,i:"e",e:1,s:0,o:"1780"},{f:"c",y:0,z:1,i:"cR",e:1,s:0.70000000000000007,o:"1780"},{f:"c",y:0.15,z:0.15,i:"a",e:57,s:3,o:"1779"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1781"},{f:"c",y:0.15,z:0.15,i:"e",e:0,s:1,o:"1780"},{f:"c",p:2,y:1,z:0,i:"ActionHandler",s:{a:[{i:0,b:"1787",p:9,symbolOid:"750"}]},o:"1787"},{y:1,i:"cR",s:1,z:0,o:"1781",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1781",f:"c"},{y:1,i:"a",s:57,z:0,o:"1779",f:"c"},{y:1,i:"cQ",s:1,z:0,o:"1780",f:"c"},{y:1,i:"cR",s:1,z:0,o:"1780",f:"c"},{y:1,i:"e",s:0,z:0,o:"1781",f:"c"},{y:1,i:"e",s:0,z:0,o:"1780",f:"c"}],f:30,b:[]}},bZ:180,O:["1782","1773","1763","1777","1780","1768","1764","1781","1765","1783","1776","1778","1766","1779","1767","1769","1784","1771","1770","1772","1774","1761","1775","1762"],n:"layout_0","_":1,v:{"1780":{h:"736",p:"no-repeat",x:"visible",a:77,q:"100% 100%",b:0,j:"absolute",dB:"img",z:79,k:"div",bF:"1777",d:217,c:217,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1774":{h:"1665",p:"no-repeat",x:"visible",a:410,q:"100% 100%",b:411,j:"absolute",dB:"img",z:137,k:"div",c:152,d:168,r:"inline",e:0},"1763":{G:"#333333",aU:8,c:652,d:184,aV:8,r:"inline",cQ:0.80000000000000004,s:"Calibri",e:0,t:30,cR:0.80000000000000004,Z:"break-word",w:"Dengan Rekening Dana Nasabah ini, dana investor tidak lagi menjadi satu dengan dana Perusahaan Efek, melainkan benar-benar terpisah dan berada di bank pembayar. Sehingga <font color=\"#113498\"><b>meningkatkan jaminan keamanan dan transparansi informasi bagi investor</b></font>.",j:"absolute",x:"visible",k:"div",y:"preserve",z:135,aS:8,aT:8,a:178,b:162},"1779":{h:"742",p:"no-repeat",x:"visible",a:57,q:"100% 100%",b:63,j:"absolute",dB:"img",z:82,k:"div",bF:"1777",d:91,c:127,r:"inline",e:1,f:180},"1768":{h:"736",p:"no-repeat",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",dB:"img",z:79,k:"div",bF:"1764",d:217,c:217,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1783":{c:266,d:156,I:"None",cY:"0",J:"None",K:"None",L:"None",aP:"pointer",M:0,N:0,A:"#D8DDE4",x:"visible",aA:{a:[{p:4,h:"793"}]},O:0,j:"absolute",k:"div",dB:"button",z:153,C:"#D8DDE4",D:"#D8DDE4",B:"#D8DDE4",P:0,a:0,b:225},"1772":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:2,B:"#888888",D:"#888888",aK:"50%",bF:"1769",P:5,a:41,aL:"50%",b:41},"1761":{h:"1663",p:"no-repeat",x:"visible",a:536,q:"100% 100%",b:418,j:"absolute",dB:"img",z:138,k:"div",c:87,d:113,r:"inline",e:0},"1777":{x:"visible",a:-12,cA:false,b:190,j:"absolute",r:"inline",c:300,k:"div",z:151,d:217,bY:1,cQ:0.29999999999999999,e:0,bZ:180,bX:false,cV:[],cR:0.29999999999999999},"1766":{h:"740",p:"no-repeat",x:"visible",a:54,q:"100% 100%",b:54,j:"absolute",bF:"1764",z:81,k:"div",dB:"img",d:110,c:110,r:"inline"},"1781":{h:"738",p:"no-repeat",x:"visible",a:101,q:"100% 100%",b:24,j:"absolute",dB:"img",z:80,k:"div",bF:"1777",d:169,c:170,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007},"1770":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:3,B:"#888888",D:"#888888",aK:"50%",bF:"1769",P:5,a:41,aL:"50%",b:41},"1775":{h:"1661",p:"no-repeat",x:"visible",a:606,q:"100% 100%",b:422,j:"absolute",dB:"img",z:136,k:"div",c:74,d:101,r:"inline",e:0},"1764":{x:"visible",a:746,cA:false,b:190,j:"absolute",r:"inline",c:300,k:"div",z:150,d:217,bY:1,cQ:0.29999999999999999,e:0,bZ:180,bX:false,cV:[],cR:0.29999999999999999},"1769":{x:"visible",a:541,cA:false,b:338,j:"absolute",cY:"0",c:104,k:"div",bY:1,d:104,z:141,r:"none",e:1,bZ:180,bX:false,cV:[]},"1784":{h:"1667",p:"no-repeat",x:"visible",a:336,q:"100% 100%",b:363,j:"absolute",dB:"img",z:139,k:"div",c:105,d:125,r:"inline",cQ:0.70000000000000007,e:0,cR:0.70000000000000007},"1773":{h:"1656",p:"no-repeat",x:"visible",a:181,q:"100% 100%",b:99,j:"absolute",dB:"img",z:134,k:"div",c:195,d:44,r:"inline",e:0},"1762":{h:"1659",p:"no-repeat",x:"visible",a:588,q:"100% 100%",b:491,j:"absolute",dB:"img",z:140,k:"div",c:69,d:38,r:"inline",e:0},"1778":{h:"740",p:"no-repeat",x:"visible",a:131,q:"100% 100%",b:54,j:"absolute",bF:"1777",z:81,k:"div",dB:"img",d:110,c:110,r:"inline"},"1767":{h:"742",p:"no-repeat",x:"visible",a:109,q:"100% 100%",b:63,j:"absolute",dB:"img",z:82,k:"div",bF:"1764",d:91,c:127,r:"inline",e:1},"1782":{h:"1654",p:"no-repeat",x:"visible",a:-238,q:"100% 100%",b:-13,j:"absolute",dB:"img",z:133,k:"div",c:1500,d:602,r:"inline",cQ:1.3,e:0,cR:1.3},"1771":{c:12,d:12,I:"Solid",e:0,J:"Solid",K:"Solid",L:"Solid",M:5,N:5,aI:"50%",A:"#888888",x:"visible",O:5,j:"absolute",aJ:"50%",k:"div",C:"#888888",z:4,B:"#888888",D:"#888888",aK:"50%",bF:"1769",P:5,a:41,aL:"50%",b:41},"1776":{c:256,d:156,I:"None",cY:"0",r:"inline",J:"None",K:"None",L:"None",aP:"pointer",M:0,N:0,A:"#D8DDE4",x:"visible",aA:{a:[{p:4,h:"50"}]},O:0,j:"absolute",k:"div",dB:"button",z:152,C:"#D8DDE4",D:"#D8DDE4",B:"#D8DDE4",P:0,a:768,b:225},"1765":{h:"738",p:"no-repeat",x:"visible",a:24,q:"100% 100%",b:24,j:"absolute",dB:"img",z:80,k:"div",bF:"1764",d:169,c:170,cQ:0.70000000000000007,e:0,r:"inline",cR:0.70000000000000007}}}],{},g,{g:[[0,0,0.0425,0.22,0.089,1.373,0.169,1.373],[0.169,1.373,0.223,1.373,0.2656,0.868,0.356,0.868],[0.356,0.868,0.4085,0.868,0.457,1.047,0.544,1.047],[0.544,1.047,0.5976,1.047,0.637,0.984,0.731,0.984],[0.731,0.984,0.794,0.984,0.829,1.006,0.919,1.006],[0.919,1.006,0.953,1.006,1,1,1,1]],h:[[0,0,0.175,0.885,0.32,1.25,1,1]],i:[[0,0,0.6,-0.28,0.735,0.045,1,1]]},null,false,true,-1,true,true,true,true);f[c]=a.API;document.getElementById(e).setAttribute("HYP_dn",
c);a.z_o(this.body)})();})();
