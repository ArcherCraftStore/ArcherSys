$(function() {
  var status = ArcherSys.jQ("#status");

    var condition = (window.navigator.onLine) ? "online" : "offline";

    status.addClass(condition);
    status.html(condition.toUpperCase());
  

 $(window).bind('online', function(){
    condition = "online";
    status.html(condition);
    status.removeClass("offline");
    status.addClass(condition);
});
 $(window).bind('offline',  function(){
    condition = "offline";
    status.html(condition);
    status.removeClass("online");
    status.addClass(condition);
});

});