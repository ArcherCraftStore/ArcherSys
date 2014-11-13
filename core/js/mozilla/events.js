$(function() {
  var status = ArcherSys.jQ("#status");

    var condition = (window.navigator.onLine) ? "online" : "offline";
     if(condition === "online"){
       status.removeClass("offline");
      
     }else if(condition === "online"){
       status.removeClass("online");
     }
     status.addClass(condition);
    status.html(condition.toUpperCase());

 $(window).bind('online', function(){
    condition = "online";
    status.html(condition);
    status.removeClass("offline");
    status.addClass(condition);
    Notidar.Notidex.push(new Notification("Online!",{body: "You're now connected! Enjoy your stay in wifi paradise now before you do anything else"}));
});
 $(window).bind('offline', function(){
   condition = "offline";
    status.html(condition);
    status.removeClass("online");
    status.addClass(condition);
Notidar.Notidex.push(new Notification("Offline!",{body: "You're disconnected - officially. "}));
});
$(".asos-pdflint").click(function(){
  $("iframe").attr("src", "http://localhost/Producktiviti/PDFLint");
});
$(".asos-owncloud").click(function(){
  $("iframe").attr("src", "http://localhost/owncloud-serv");
});
});