/*
 * This is the ArcherSys OS Object Model.
 
*
 This deals with selectors and events
*/


var ArcherSys = new Object();
ArcherSys.jQ = jQuery.noConflict(); 
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
