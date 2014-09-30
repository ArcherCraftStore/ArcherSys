<!DOCTYPE HTML>
<html>
<head>
<title>GheddoBox</title>
</head>
<body>
<script src="http://connect.soundcloud.com/sdk.js"></script>
<script>
// initialize client with app credentials
SC.initialize({
  client_id: '289d14c5f3cb11ae08cb6d18ec6f1ff8',
  redirect_uri: 'https://vm-0.archervmperidot.kd.io'
});

// initiate auth popup
SC.connect(function() {
  SC.get('/me', function(me) { 
    alert('Hello, ' + me.username);
var iframeElement   = document.querySelector('iframe');
var main        = SC.Widget(iframeElement);
 
  });
});
</script>
<h1 style="font-family: Segoe UI; text-align: center;">GheddoBox</h1>
<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/52911936&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
<iframe allowtransparency="true" scrolling="no" frameborder="no" src="https://w.soundcloud.com/icon/?url=http%3A%2F%2Fsoundcloud.com%2Facosf&color=orange_white&size=32" style="width: 32px; height: 32px;"></iframe>
</body>
</html>