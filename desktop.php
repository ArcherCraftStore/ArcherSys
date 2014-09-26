<!DOCTYPE HTML>
<html>
  <head>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>

<script src="js/libs/jquery.min.js"></script>
 <script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap.js"></script>
<link href="bootstrap.css" rel="stylesheet"/>
<link href="bootstrap-tour.min.css" rel="stylesheet"/>
<link href="bootstrap-tour.min.css" rel="stylesheet"/>
<script src="bootstrap-tour.min.js"></script>
<script src="bootstrap-tour.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script>
TogetherJSConfig_toolName = "BIRD";
</script>
<script src="js/libs/togetherjs.js"></script>
<script>
$(function(){
   var enabled = (enabled === true) ? false : true;
 $("#contentspace").append("<iframe id=\"mapsframe\" width=\"1261\" height=\"634\" frameborder=\"0\" style=\"border:0\" src=\"https://www.google.com/maps/embed/v1/place?q=United%20States&key=AIzaSyAPx5WHasOtdyDoWMq2jnJ3RLId1MIeXgo&maptype=satellite\"></iframe>");
 $("#mapstoggler").click(function(){

   $("#mapsframe").toggle();
    enabled = (enabled === true) ? false : true;
   if(enabled){
     $("#mapstoggler").html("Hide Maps");
   
   }else{
     $("#mapstoggler").html("Show Maps");
   }
   
 });
 $("#lbactivate").click(function(){
  $("#mapsframe").hide();
  $("#contentspace").append("<iframe id=\"lbview\"  width=\"1351\" height=\"594\" src=\"" + prompt("URL:") + "\"></iframe>");
 
   
 });
});
</script>


</head>
<body>
<div class="container-fluid">
  <ul class="nav nav-tabs">

     <li><a class="brand" href="#">ArcherSys Desktop</a></li>
      <li><a href="wordpress">Social</a></li>
       
  </ul>
  
 



  
<div class="container-fluid" id="contentspace">
 <script>
  (function() {
    var cx = '008504857794623096248:mitppbrolh4';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>

</div>
<div class="container-fluid">
</div>
     <nav class="nav navbar-default navbar-fixed-bottom">
         <button id="birdc" onclick="TogetherJS(this); return false;">Connect</button>
         <button id="mapstoggler" >Show Maps</button>
         <button id="lbactivate" >Show Maps</button>
       </nav>

</div>
</body>
</html>