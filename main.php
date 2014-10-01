<!DOCTYPE HTML>
<html>
  <head>
  <link rel="icon"  href="favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <title>ArcherSys Desktop</title>
     
<script src="http://localhost:80/js/libs/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
 <script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap.js"></script>
<link href="bootstrap.css" rel="stylesheet"/>
<link href="bootstrap-tour.min.css" rel="stylesheet"/>
<link href="bootstrap-tour.min.css" rel="stylesheet"/>
<script src="bootstrap-tour.min.js"></script>
<script src="bootstrap-tour.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script>
TogetherJSConfig_toolName = "BIRD";
</script>
<script src="/js/libs/togetherjs.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
 
<script>

  

$(function(){
$(".contentspace #tabs").tabs();
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
  $("#contentspace #tabs-1").append("<iframe id=\"lbview\"  width=\"1700\" height=\"1004\" src=\"" + prompt("URL:") + "\"></iframe>");
 
   
 });
});
</script>

</head>
<body>
<div class="container-fluid">
  <ul class="nav nav-tabs">

     <li><a class="active" href="#">ArcherSys Desktop</a></li>
      <li><a href="wordpress">Social</a></li>
      <li><a href="#tab">Tab 1</a></li>
       
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
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Nunc tincidunt</a></li>
    <li><a href="#tabs-2">Proin dolor</a></li>
    <li><a href="#tabs-3">Aenean lacinia</a></li>
  </ul>
  <div id="tabs-1">
    
  </div>
  <div id="tabs-2">
    
  </div>
  <div id="tabs-3">
    
  </div>
</div>
</div>
<div class="container-fluid">

<script>
  function onYtEvent(payload) {
    if (payload.eventType == 'subscribe') {
      // Add code to handle subscribe event.
    } else if (payload.eventType == 'unsubscribe') {
      // Add code to handle unsubscribe event.
    }
    if (window.console) { // for debugging only
      window.console.log('YT event: ', payload);
    }
  }
</script>



<div class="container-fluid">

     <nav class="nav navbar-default navbar-fixed-bottom">
     
         <button id="birdc" class="btn btn-default btn-lg" onclick="TogetherJS(this); return false;">Connect</button>
         <button class="btn btn-default btn-lg"  id="mapstoggler" >Show Maps</button>
         <button class="btn btn-default btn-lg"  id="lbactivate" >Open Window</button>
        
        <div class="g-ytsubscribe" data-channel="GoogleDevelopers" data-layout="full" data-theme="dark" data-count="default" data-onytevent="onYtEvent"></div>
        <div class="g-plusone" data-size="small" data-href="https://twitter.com"></div>

        
       </nav>
</div>
</div>
 <script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</body>
</html>