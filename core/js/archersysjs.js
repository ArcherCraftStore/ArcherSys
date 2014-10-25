/*
 * This is the ArcherSys OS Object Model.
 
*
 This deals with selectors and events
*/


var ArcherSys = new Object();
ArcherSys.jQ = $.noConflict(); 
ArcherSys.notifyOnline = function(e){
     alert("You are online!");
};

ArcherSys.liFi = localforage;
ArcherSys.liFi.config({
  name: "ArcherSys OS DB",
  description: "ArcherSys LocalStorage",
  version: "1.0"
});

ArcherSys.liFi.setDriver([localforage.WEBSQL,localforage.INDEXEDDB]);
ArcherSys.BeximalJS = BeximalJS;
ArcherSys.Menu = {

      toggleSM: function(){
        ArcherSys.jQ(".submenu").toggle();
     }
};
ArcherSys.asyncFi = window.asyncStorage;
ArcherSys.asyncFi._initStorage().then(function(){
   alert("AsyncStorage");
});
ArcherSys.asyncFi.setItem("connected", (window.navigator.onLine) ? true : false);
window.onprogress = function(e){
        ArcherSys.jQ("#pbar").progressbar({value: e.completed});
};        
