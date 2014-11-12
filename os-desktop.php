<!DOCTYPE HTML>
<html>
<head>
<title>ArcherSys Desktop</title>
<meta name="viewport" content="width=device-width  initial-scale=1.0 user-scalable=no" >
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<script type="text/javascript" src="core/js/jquery.js"></script>
<script src="core/js/libs/jquery.min.js"></script>
<script src="core/js/jquery-ui.min.js"></script>

<script src="core/js/time.js"></script>

<script src="core/js/ximal.js"></script>

<script src="core/js/localforage.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">

     
<link rel="stylesheet" href="core/bootstrap-tour/build/css/bootstrap-tour.css">

<link rel="stylesheet"  href="core/bootstrap-tour/build/css/bootstrap-tour.min.css">
<link rel="stylesheet"  href="core/bootstrap-tour/build/css/bootstrap-tour-standalone.css">
<link rel="stylesheet"  href="core/bootstrap-tour/build/css/bootstrap-tour-standalone.min.css">

<script src="core/js/bootbox.min.js"></script>
<script src="core/bootstrap/js/bootbox.min.js"></script>
<script src="core/js/archersysjs.js"></script>
<script src="core/js/localforage.js"></script>
<script src="core/js/portBox-v1.0.1/js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="core/js/portBox-v1.0.1/js/jquery.portBox.min.js"></script>
<!-- Attach portBox script -->
<script src="core/js/portBox-v1.0.1/js/jquery.portBox.slimscroll.min.js"></script>

<!-- Attach portBox CSS -->
<link href="core/js/portBox-v1.0.1/css/portBox.css" rel="stylesheet" />

  
<script>
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  window.location.assign("os-mobile.php");
}
      jQuery(function($){

$("#mainMenu").hover(function(){
  $("#mainMenu").children().show();
}, function(){
  $("#mainMenu ").children().hide();
});
$("#file").hover(function(){
  $("#file ").children().show();
}, function(){
  $("#file").children().hide();
});

 TogetherJSConfig_enableAnalytics = true;

TogetherJSConfig_hubBase = "https://bird-c9-acosf.c9.io";
 TogetherJSConfig_toolName ="BIRD";
 TogetherJSConfig_cloneClicks = "#main";
 TogetherJSConfig_findRoom = "Desktop";
 TogetherJSConfig_inviteFromRoom = true;
 TogetherJSConfig_youtube = true;
  window.setInterval(function(){
     if(TogetherJS.running){
    console.log("BIRD Running");
  }
},60000);
TogetherJS.on("bye",function(msg){
     $("iframe").animate({
             width: "1200px"
    });

});
$("#bird-base").html(TogetherJSConfig_hubBase);
  $(" #yt").click(function(){
    
        $("iframe").attr("src","//www.youtube.com/embed/qOsEABeHk5Y?list=PLhiFsDMzQiU7UFUKlh9Q7YHUhEpiFkfuK");
 $("iframe").attr("width","560");
$("iframe").attr("height","315"); 
 $("iframe").attr("frameborder","0"); 
$("iframe").attr("allowfullscreen","true");
       TogetherJS.reinitialize();
});

$(".asos-bird").click(ArcherSys.toggleBIRD);

     TogetherJS_hub_on = {
    "togetherjs.hello":function(msg){
     alert("Say Hello to "+ msg.name);

}
};  
$("#signin").click(function(){


window.navigator.id.get();


});
   

var introTour = new Tour({
     steps: [
      {
        element: "#main",
        title: "Start",
        content: "Welcome To ArcherSys Desktop! To get Started, click on a button in the dock"
        },
 {
   element: "#bar",
   title: "Menu",
   content: " Access Links by clicking on the menu"
}
]});


introTour.init();
introTour.start();
    });

</script>

 <script src="core/js/libs/min/togetherjs-min.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/desktop.css"/>
<link rel="stylesheet" type="text/css" href="core/font-awesome/css/font-awesome.min.css"/>


<script src="core/js/mozilla/events.js"></script>
<script src='//cdn.goroost.com/roostjs/5c55db4345ae4ee88f1bcfbcceb82145' async></script>
</head>
<body>

<div id="bar">
  <ul>
    <li class="menuItem" id="mainMenu">
       ArcherSys Desktop

      <ul class="submenu">
         
         <li>ArcherSys Desktop</li>
        <li id="bird-base"></li>
        
      </ul>
      
    </li>
   <li class="menuItem" id="file">File
    <ul class="submenu">
         <li class="menuItem">Open..
             <ul class="submenu">
                 <li><a href="#" class="asos-applicatione " id="pdflint">PDFLint</a></li>
                  <li><a href="#" data-display="window">Open The App Window </a>
             </ul>
          </li>
          </ul></li>
   <li class="menuItem">
<div id="status"></div>

</li>
<li class="menuItem" id="signin" >Sign In</li>
<li class="menuItem" id="yt">YouTube</li>
</ul>
</div>

<div class="main portBox" id="window">
<iframe class="window" webkitallowfullscreen></iframe>
<div id="loc"></div>
</div>
<div class="main " id="window">
<iframe class="window" webkitallowfullscreen></iframe>
<div id="loc"></div>
</div>
<div class="dock" id="main">
<ul>
<li><a href="index.php"><em>ArcherSys Start Screen</em>

 <i class="fa fa-home fa-fw fa-5x"></i>
</a>
</li>
<li class="asos-pdflint"><em>PDFLint</em>

<i class="fa fa-pencil fa-5x fa-fw "></i>
</li>
<li class="asos-owncloud"><em>ownCloud</em><i class="fa fa-cloud fa-5x"></i></li>
<li class="asos-bird"><a href="#"><img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxENDhAREBIVDxMQEhAQEBEQEA8QDg8QFRIXIhUVGBMYHiggGB4lGxQUIT0hMSkrLi4uFx8zODMsNygtLiwBCgoKDg0OGhAQGy4mICQsLCwsLC8sLCw0LCwwLC0sLCwsLCwsLCwsLiwsLCwsLC8sLCwuLCwsLiwsLCwsLDMsM//AABEIAMAAwAMBEQACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABQYCAwQHAf/EADkQAAIBAQQGCAQEBwEAAAAAAAABAgMEBREhBhIxQVFxEyJSYYGRsdEyQqHBU2KC4RQzNHKDwvAW/8QAGgEBAAMBAQEAAAAAAAAAAAAAAAMEBQIBBv/EACkRAQACAgEEAQEJAQAAAAAAAAABAgMRBBIhMUFRUhMUIiMyM0JhgQX/2gAMAwEAAhEDEQA/APcQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4rxvOnZljN57orByfgR5MtaR3d0x2v4Vm2aUVZt9GlBd6xkUb8y0/pW6cWI/UiK9tqVfjnKXNle2W9vMp4x1jxDRgRu2VObi8YvB9x1F7R4lzNYnykbNf1op/PrrhPMmryslUVuPSU/YNKKc1hVTpvuzi+W8vYM8ZZ6dd1TNi+zjcz2RV6abZuNnj+ua9EalOL9TLycz6Vdtd+2mtjrVXg90co+RYrhpHpVtnyW9o6Um9uZJEaRTMz5Iya2ZCY2RMx4SNkv200cNWq8FulnHyI7YaT6S1z5K+1iuvTbNK0R/XBeqK9+L9K1j5n1LdZbTCtBTpyUoveniVJiYnUrtbRaNw3Hj0AAAAAAAAAV+/r/AFRxp0s5/NLLCHd3sqZ+T0dq+VjDg6u8+FQqTcm3J4t5tva2ZszMzuV+IiI1DE8egAAB9jFvYWONxrZp7ePlX5HJrhjv5+HRCCRv4sNMUarD5/LmvlndnPa7Ep5rKX0ZZrfSC1doicXF4PJomidoXw9eAAAB23XedWyz1qbw4rdJcCO+Ot47pceW1J3D0i475p22GMerJfHBvNe6M7Jjmk6lqYssZI3CTI0oAAAAAACG0kvX+HgoR+OaeH5VxK/IzfZxqPMp8GLrnv4UdvEyZnbRAAAAASxJMOKct4rCLNljFSbS6YQ1UfS4sdcdYrV83ly2yWm1mZ2jAOO32bXWK2r6okpbTi9dognQgAAAA6rtt87NVjUg81tW6S3o4vSLxqUmPJNLbh6pdlujaaUakNklmt6e9GXes1nUtil4vG4dRy6AAAABjVmoxcnsim34HkzruRG3nN42t16spve8u6O4xsuSb2mWrjp0105iN2AAAADdQjv8jc/5+Hpp1z5lh/8ARzdV+iPTcaDOAAACGvGjqTxWyWZYpO4Q3jUuU7cAAAAAtGgt5dHWdGT6tXDV7prH1XoiryabjqXeJk1PTPt6AUGiAAAACH0ptPR2ZpfO1Dkv+RX5N+nHKbBXquoxktIAAAAA6pXqtEfLm1umsy6oLBI+prXpiIfLWt1TMsj1yAAAHHeVPGGPZzJMc93F47IgnQgAAAA2Was6dSE18soy8mc2jcTDqtumYl7BZ6uvCEu1GMvNGTManTbidxtsPHoAAAVfTaX8hcekflq+5R5s9ohb4kd5lVjPXQAAAAfYrFos8ON56q3LnWGzrPo3zYAAAANVoWMJcmdV8vJ8IEsq4AAAAAHqujM9axUG+x92ZWWNXls4Z3jhJkaUAAAKtpvtof5f9Chzv4/6ucT2q5QXAAAAAZU3mizwv36q3M/Ys6j6N82AAAADCs+rLk/Q9jyT4V8tKwAAAAAHqeiv9DQ/s+7MvN+uWxg/bhKkSYAAAK9pnRxpU59mTXhJfsipzK7ptZ406tpTzMXwAAAACXBfpyVn+0WenVjtH9OtM+nfLvoAAAA57bPVpy78jukblzaeyELCAAAAABLHLiHr1y6KHRWelDhCP1X7mRed2mW1SNViHYcuwAAA5bzs3TUakOMXhz3HGSvVWYdUt02iXnM4uLaeTTafNGJManTVidxt8D0AAAAHRRliuR9JxcsZMUS+b5WKceWYbCwrAAABG3rV2R8X9ibHHtHkn0jiVEAAAACU0asDtFqpx3RanJ8En74EOa/TRPx6dd4eqGY1wAAAAAKdpXdvRz6WK6s/i4Rl+5ncvFqeuF7jZNx0yr5SWgAAAAZU5YP1L3B5H2d+mfEqPO4/2lOqPMOk3mA+gANdaqoRbe76nsRuXkzpBVZuUm3vLMRpBM7YnrwAAACQevSND7n/AIWi5zXXq4N/liti+pm58nXbs1eNi6K7nzKwECwAAAAABrtFGNSLjJYqSwZ5MRMal7EzE7hRL5umVlnxg8dWX2Zk58E457eGjiyxeP7RpAmAAAABspVMMns9DY4XM3+Xf/GPzeHr8yn+t5qMp8nNRWLyR7EbENbLS6j7lsJ610htbbnO3AAAAALjojo221XrLBLB04PDN47X5FLPn/jVf43H/lZdymvgAAAAAAAGFalGpFxklJPanmjyYiY1L2J13hU700YlDGVHrR7LfWXLiUMvE90XMfJ9WV+pBxbUlg1tT2opTExOpWomJ7wxPHoAAASN3XZXrLGEerxk8F4M2OHnya1eO3yyeXxsczunafhD3vQrUp6taLhwXyvlxNrHNZj8LEy1tWfxI8lRAAAB1WC76tplq0ouT38FzZxe9a+UlMdr+F3uHROFDCdbCpPdHbCPuyll5E27R4aGHjRTvbys5WWgAAAAAAAAAAAaLTZKdZYTipcMVsObVi3mHsWmPCKr6L0JfDrQ5PH1ILcTHKaOReGj/wAlT/En5R9iP7lX5l396t8MoaJ0k85zl3dVeh1HDo8nlWSNluWhSzjBN8ZdZrzJq4aV8QitlvbzKQJUbCrSjNOMkpJ7U80xE6eTG0Na9FLLVxeo4N9htJeBNXPePaG3Gxz6R8tBqP4tReEPYkjlW+EU8OnyR0Go/i1H4Q9hPKt8EcOnykLJopZaWD1HNrtttPwI7Z7z7S142OvpM0qUYJRilFLYlkkQ72miNMw9AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//2Q==" width="40px" height="40px"></a></li>
</ul>


</div>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://localhost/admin/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://localhost/admin/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
</body>
</html>