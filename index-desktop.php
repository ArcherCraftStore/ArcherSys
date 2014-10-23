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
<link type='text/css' href='core/css/osx.css' rel='stylesheet' media='screen' />
<script src="core/js/mozilla/events.js"></script>
<script src="core/js/archersysjs.js"></script>


<body>
<script>
$(function(){
setInterval(function(){window.applicationCache.update();}, 4000);
ArcherSys.jQ(".menuItem #mainMenu").hover( function(){
          ArcherSys.jQ("#mainMenu .submenu").show();
  

          }, function(){
                ArcherSys.jQ("#mainMenu .submenu").hide();
            });
$("#pdflint-app").dialog();
$("#pdflint").click(function(){
      $("#pdflint-app").toggle();
});

});
</script>
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
<li><a href="#" class="bird-starter"></a>
</ul>
</div>
<div id="pdflint" title="Producktiviti PDFLint">
  <iframe src="Produktiviti/PDFLint"></iframe>
</div>

</body>
</html>