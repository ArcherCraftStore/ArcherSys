<?php 
  require "config.php";
  
 require_once "includes/AppDataBucket.php";
 
?>
<!DOCTYPE HTML>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<title>ArcherSys OS Mobile Desktop</title>
<meta name="viewport" content="width=device-width initial-scale=1">

  <link rel="stylesheet" href="core/mobile-theme/themes/ArcherSys_OS.css" />
  <link rel="stylesheet" href="core/mobile-theme/themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="core/mobile-theme/themes/jquery.mobile.structure-1.4.5.min.css" /> 
  <script src="core/js/libs/jquery.min.js"></script> 
  <script src="core/mobile-theme/jquery.mobile-1.4.5.min.js"></script>
<script>
 $( window ).on( "orientationchange", function( event ) {
 $("#orientation").text("This device is in " + (event.orientation === "portrait" ) ? Phone : Phablet + " mode!" );
});
var SaveTheme = function(){
var theme = $("#theme").val();
   $("#os-home").attr("data-theme",theme);
};
</script>
  </head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <div data-role="page" id="os-home" data-theme="a">
    <div data-role="header"><h1>ArcherSys OS</h1></div>
 <div data-role="main" class="ui-content">
<p id="orientation">orientationchange Not Supported on this Device.</h1>
     <form class="ui-filterable">
      <input id="homeSearch" data-type="search" placeholder="Search Everything">
 </form>
   <ul data-role="listview" data-filter="true" data-input="#homeSearch">
     <li data-role="listdivider">Apps</li>
    <?php
       
   renderApps($config["dbhost"],$config["dbuser"],$config["dbpass"],$config["dbname"]);
       
   
      ?>  
    <li data-role="listdivider">Services</li>
    <li><a href="#facebook">My Facebook Shelf</a></li>
   <li><a href="#archersys-github">ArcherSys On Github.io</a></li>
   <li><a href="https://www.edmodo.com">Edmodo</a></li>
   <li><a href="#settings1">Settings</a></li>
  </ul>
</div>

 </div>
<div data-role"page" id="settings1">
   <div data-role="header"><h1>Settings</h1></div>
<div data-role="main" class="ui-content">
   <form>
    <select id="theme">
     <option value="a">Avocado</option>
     <option value="b">Espresso</option>
     <option value="c">Columbian</option>
   </select>
   <button id="save" onclick="SaveTheme();">Save</button>
</form>
</div>
</div>
<div data-role"page" id="facebook">
<div data-role="header"><h1>My Facebook Shelf</h1></div>
<div data-role="main" class="ui-content">
<fb:comments href="https://archersys.github.io/" numposts="20" colorscheme="light" mobile="true"></fb:comments>
</div>

</div>
<div data-role="page" id="archersys-github"></div>

</body>
</html>