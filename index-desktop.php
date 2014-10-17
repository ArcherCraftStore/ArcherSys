<!DOCTYPE HTML>

<html>
<head>
<meta name="viewport" content="width=device-width  initial-scale=1.0 user-scalable=no" >
<script type="text/javascript" src="core/js/jquery.js"></script>
<script src="core/js/localforage.js"></script>

<script src="core/js/localforage.min.js"></script>
<script src="core/js/ximal.js"></script>
<script src="https://login.persona.org/include.js"></script>
<link rel="stylesheet" type="text/css" href="core/css/desktop.css"/>
<link rel="stylesheet" type="text/css" href="core/font-awesome/css/font-awesome.min.css"/>

<script>
$(function(){
ArcherSys.jQ(".menuItem").hover( function(){
          ArcherSys.jQ("ul.submenu").show();
  

          }, function(){
                ArcherSys.jQ(".submenu").hide();
            });
});
</script>
<script src="core/js/archersysjs.js"></script>

<body>
<div id="bar">
  <ul>
    <li class="menuItem" >
       ArcherSys Desktop

      <ul class="submenu">
         
         <li>ArcherSys Desktop</li>
        
      </ul>
      
    </li>
   <li class="menuItem">File</li>
  
</ul>
</div>

<div class="dock" id="main">
<ul>
<li><a href="index.php"><em>ArcherSys Start Screen</em>

 <i class="fa fa-home fa-5x"></i>
</a>
</li>
</ul>
</div>


</body>
</html>