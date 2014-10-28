/*/*
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
ArcherSys.workspace = ArcherSys.jQ("iframe.window");
ArcherSys.toggleBIRD = function(){
        $("iframe").animate({
             width: "900px"
});
       TogetherJS(this);
  return false;
};
ArcherSys.feedbackAdapter = {
   renderAFRSClient: function(){
     <iframe src="https://docs.google.com/forms/d/19cdtVnKaBmW4XlZTdWjFuHwNIy5CmVja4OznuUwBaKU/viewform?embedded=true" width="900" height="500" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
    }
};