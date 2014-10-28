<!DOCTYPE HTML>

<html>
<head>
<meta name="viewport" content="width=device-width  initial-scale=1.0 user-scalable=no" >
<script type="text/javascript" src="core/js/jquery.js"></script>
<script src="core/js/localforage.js"></script>
<script src="core/js/time.js"></script>
<script src="core/js/localforage.min.js"></script>
<script src="core/js/ximal.js"></script>

<script src="https://login.persona.org/include.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/desktop.css"/>
<link rel="stylesheet" type="text/css" href="core/font-awesome/css/font-awesome.min.css"/>

<script src="core/js/mozilla/events.js"></script>
<script src="core/js/archersysjs.js"></script>

<script>
$(function(){
setInterval(function(){window.applicationCache.update();}, 4000);
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

    
     
});
</script>

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
<div id="desktop">

</div>
<div class="dock" id="main">
<ul>
<li><a href="index.php"><em>ArcherSys Start Screen</em>

 <i class="fa fa-home fa-5x"></i>
</a>
</li>
<li><a href="Producktiviti/PDFLint"><em>PDFLint</em>
<i class="fa fa-file-word-o fa-5x"></i>
</a></li>
</ul>
</div>


</body>
</html>