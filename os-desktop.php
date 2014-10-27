<!DOCTYPE HTML>
<html>
<head>

<meta name="viewport" content="width=device-width  initial-scale=1.0 user-scalable=no" >
<script type="text/javascript" src="core/js/jquery.js"></script>
<script src="core/js/libs/jquery.min.js"></script>
<script src="core/js/jquery-ui.min.js"></script>


 
<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
<script src="core/js/localforage.js"></script>        

<script>
      $(function(){

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
    
     
    });
</script>
<script src="core/js/time.js"></script>
<script src="core/js/localforage.min.js"></script>
<script src="core/js/ximal.js"></script>

<script src="https://login.persona.org/include.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/desktop.css"/>
<link rel="stylesheet" type="text/css" href="core/font-awesome/css/font-awesome.min.css"/>
<script src="https://togetherjs.com/togetherjs-min.js"></script>
<script src="core/js/mozilla/events.js"></script>
<script src="core/js/archersysjs.js"></script>

<body>

<div id="bar">
  <ul>
    <li class="menuItem" id="mainMenu">
       ArcherSys Desktop

      <ul class="submenu">
         
         <li>ArcherSys Desktop</li>
        
      </ul>
      
    </li>
   <li class="menuItem" id="file">File
    <ul class="submenu">
         <li class="menuItem">Open..
             <ul class="submenu">
                 <li><a href="#" class="asos-application" id="pdflint">PDFLint</a></li>
             </ul>
          </li>
          </ul></li>
   <li class="menuItem"><div id="status">

</div></li>
</ul>
</div>
<div class="main">
<iframe class="window" webkitallowfullscreen></iframe>
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
</ul>
</div>

</body>
</html>