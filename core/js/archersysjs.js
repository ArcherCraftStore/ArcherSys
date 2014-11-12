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
  
};


ArcherSys.openMozVideo = function(){
$(".window").prepend();
$("<video height=\"180\" width=\"300\" id=\"PopCorn\" controls>"+
      "<source src=\"http://videos.mozilla.org/serv/webmademovies/popcornplug.mp4\">"+
     " <source src=\"http://videos.mozilla.org/serv/webmademovies/popcornplug.ogv\">" +
      "<source src=\"http://videos.mozilla.org/serv/webmademovies/popcornplug.webm\">"+
    "</video>").appendTo(".desktop");


};
ArcherSys.loadCamera = (function () {
    var takePicture = $("#take-picture"),
        showPicture = $("#show-picture");

    if (takePicture && showPicture) {
        // Set events
        takePicture.onchange = function (event) {
            // Get a reference to the taken picture or chosen file
            var files = event.target.files,
                file;
            if (files && files.length > 0) {
                file = files[0];
                try {
                    // Get window.URL object
                    var URL = window.URL || window.webkitURL;

                    // Create ObjectURL
                    var imgURL = URL.createObjectURL(file);

                    // Set img src to ObjectURL
                    showPicture.src = imgURL;

                    // Revoke ObjectURL
                    URL.revokeObjectURL(imgURL);
                }
                catch (e) {
                    try {
                        // Fallback if createObjectURL is not supported
                        var fileReader = new FileReader();
                        fileReader.onload = function (event) {
                            showPicture.src = event.target.result;
                        };
                        fileReader.readAsDataURL(file);
                    }
                    catch (e) {
                        //
                        var error = $("#error");
                        if (error) {
                            error.html("Neither createObjectURL or FileReader are supported");
                        }
                    }
                }
            }
        };
    }
})();