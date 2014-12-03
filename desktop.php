<!DOCTYPE HTML>
<html>
  <head>
  <link rel="icon"  href="favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <title>ArcherSys Desktop</title>
     
<script src="core/js/libs/jquery.min.js"></script>
<script>
var TogetherJSConfig_toolName = "BIRD";

// Spotlight toggles
$(function() {
  $('.results').hide();
 

  $( "#spotlight" ).click(function() {
    $(this).toggleClass( "active" );
    $('.spotlight-search').toggleClass( "active" );
    $('.demo').toggleClass( "active" );
  });
  
  $('#search').focus(function(){
    $('.results'+ this.value).show();
  });
    
  $('#search').on("focusout", function(){
    $('.spotlight-search').toggleClass( "active" );
    $('#spotlight').toggleClass( "active" );
  });
  
});


// Clock [from: unknown]
function updateClock ( ) {
  var currentTime = new Date ( );
  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

</script>
<script src="/js/libs/togetherjs.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
 

<style>
/* ------------ Base Styles ------------ */
body {
  padding: 0;
  margin: 0;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  font-smooth: always;
  background: #434343;
  font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;
}

a {
  text-decoration: none;
}

.clear {
  clear: both;
}

/* ------------ App Styles ------------ */
.header {
  height: 21px;
  background: linear-gradient(to bottom, #E5E5E5 0%, #A0A0A0 100%);
  -webkit-box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.4), 0 0 20px 3px rgba(0, 0, 0, 0.5), 0px 0px 0px 1px black;
  -moz-box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.4), 0 0 20px 3px rgba(0, 0, 0, 0.5), 0px 0px 0px 1px black;
  box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.4), 0 0 20px 3px rgba(0, 0, 0, 0.5), 0px 0px 0px 1px black;
}
.header .menu-bar {
  list-style: none;
  margin: 0;
  padding: 0;
}
.header .menu-bar li {
  float: left;
}
.header .menu-bar li a {
  display: block;
}
.header .menu-bar.icons {
  float: right;
}
.header .menu-bar li {
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  font-smooth: always;
  font-weight: 400;
  font-size: 14px;
  line-height: 21px;
  height: 21px;
}
.header .menu-bar li:last-of-type {
  margin-right: 16px;
}
.header .menu-bar li:active a, .header .menu-bar li.active a {
  background: linear-gradient(to bottom, #6485F5 0%, #275AF2 100%);
  color: #fff;
}
.header .menu-bar li:active a i.icon, .header .menu-bar li.active a i.icon {
  background-image: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/menu-icons_active.png");
  -webkit-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0));
  -moz-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0));
  -ms-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0));
  -o-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0));
  filter: drop-shadow(1px 1px rgba(255, 255, 255, 0));
}
.header .menu-bar li:active a i.icon.spotlight:after, .header .menu-bar li.active a i.icon.spotlight:after {
  background: #1E4CE8;
  position: absolute;
  top: 23px;
  content: "";
  width: 36px;
  height: 1px;
  margin-left: -11px;
}
.header .menu-bar li a {
  cursor: default;
  height: 21px;
  color: #000;
}
.header .menu-bar li a#clock {
  padding: 0 7px 0 8px;
}
.header .menu-bar li a i.icon {
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/menu-icons.png");
  height: 21px;
  width: 23px;
  -webkit-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0.3));
  -moz-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0.3));
  -ms-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0.3));
  -o-filter: drop-shadow(1px 1px rgba(255, 255, 255, 0.3));
  filter: drop-shadow(1px 1px rgba(255, 255, 255, 0.3));
  display: inline-block;
}
.header .menu-bar li a i.icon.notification {
  background-position: -582px    0;
  width: 21px;
  padding: 0 4px 0  5px;
}
.header .menu-bar li a i.icon.spotlight {
  background-position: -547px    0;
  width: 16px;
  padding: 0 9px 0 11px;
}
.header .menu-bar li a i.icon.volume {
  background-position: -516px    0;
  width: 17px;
  padding: 0 6px 0  7px;
}
.header .menu-bar li a i.icon.battery {
  background-position: -353px    0;
  width: 23px;
  padding: 0 5px 0  4px;
}
.header .menu-bar li a i.icon.wifi {
  background-position: -412px -1px;
  width: 23px;
  padding: 0 3px 0 4px;
}
.header .menu-bar li a i.icon.bluetooth {
  background-position: -382px    0;
  width: 13px;
  padding: 0 8px 0 9px;
}
.header .menu-bar li a:hover {
  text-decoration: none;
}

.spotlight-search {
  margin-top: 1px;
  margin-right: 46px;
  width: 430px;
  float: right;
  position: relative;
  display: none;
}
.spotlight-search.active {
  display: block;
}
.spotlight-search .input {
  background: linear-gradient(to bottom, #6485F5 0%, #275AF2 100%);
  height: 30px;
  border-bottom: 1px solid #1E4CE8;
  -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.5), 0 4px 8px rgba(0, 0, 0, 0.4);
  -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.5), 0 4px 8px rgba(0, 0, 0, 0.4);
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.5), 0 4px 8px rgba(0, 0, 0, 0.4);
}
.spotlight-search .input span {
  float: right;
  display: inline-block;
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  text-shadow: 0 0px 2px rgba(0, 0, 0, 0.5);
  line-height: 30px;
}
.spotlight-search .input input {
  float: right;
  margin: 4px 12px 0 15px;
  padding: 4px 10px;
  border: 1px solid #3E559F;
  width: 291px;
  height: 22px;
  line-height: 12px;
  font-size: 12px;
  -webkit-border-radius: 1em;
  -moz-border-radius: 1em;
  border-radius: 1em;
}
.spotlight-search .input input:focus {
  outline-width: 0;
}
.spotlight-search .results {
  font-size: 12px;
  margin: 0;
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/results-bg.gif") repeat-y right #fff;
  padding: 0 0 5px 0;
  -webkit-border-radius: 0 0 5px 5px;
  -moz-border-radius: 0 0 5px 5px;
  border-radius: 0 0 5px 5px;
  -webkit-box-shadow: inset 0 0 0 1px #B5B5B5, 0 4px 8px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: inset 0 0 0 1px #B5B5B5, 0 4px 8px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 0 0 1px #B5B5B5, 0 4px 8px rgba(0, 0, 0, 0.2);
}
.spotlight-search .results ul.section {
  margin: 0;
  padding: 9px 0 0;
  list-style: none;
}
.spotlight-search .results ul.section li a {
  padding: 0 0 0 125px;
  display: block;
  color: #333;
  line-height: 20px;
  cursor: default;
}
.spotlight-search .results ul.section li a .result {
  display: none;
}
.spotlight-search .results ul.section li a:hover, .spotlight-search .results ul.section li a .active {
  background: linear-gradient(to bottom, #7693F5 0%, #265AF2 100%);
  color: #fff;
  text-decoration: none;
}
.spotlight-search .results ul.section li a:hover .result, .spotlight-search .results ul.section li a .active .result {
  display: block;
  position: absolute;
  margin: -75px 0 0 -531px;
  color: #000;
  border: 1px solid #B5B5B5;
  background: linear-gradient(to bottom, #FDFDFD 0%, #EAEAEA 100%);
  width: 372px;
  height: 120px;
  padding: 10px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  -webkit-filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
  -moz-filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
  -ms-filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
  -o-filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
  filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
  -webkit-box-shadow: inset 0 0 0 1px #fff;
  -moz-box-shadow: inset 0 0 0 1px #fff;
  box-shadow: inset 0 0 0 1px #fff;
}
.spotlight-search .results ul.section li a:hover .result i, .spotlight-search .results ul.section li a .active .result i {
  float: left;
  display: block;
  margin-right: 10px;
}
.spotlight-search .results ul.section li a:hover .result i.folder, .spotlight-search .results ul.section li a .active .result i.folder {
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/results-icons.png");
  height: 16px;
  width: 16px;
  background-position: 0 -16px;
  width: 112px;
  height: 90px;
}
.spotlight-search .results ul.section li a:hover .result .details, .spotlight-search .results ul.section li a .active .result .details {
  float: left;
}
.spotlight-search .results ul.section li a:hover .result .details div, .spotlight-search .results ul.section li a .active .result .details div {
  margin: 5px 0;
}
.spotlight-search .results ul.section li a:hover .result .details div.title, .spotlight-search .results ul.section li a .active .result .details div.title {
  font-size: 16px;
  font-weight: 700;
  margin-top: 0;
}
.spotlight-search .results ul.section li a:hover .result.website, .spotlight-search .results ul.section li a .active .result.website {
  margin: -75px 0 0 -639px;
  width: 500px;
  height: 500px;
  padding: 3px 0 0 0;
}
.spotlight-search .results ul.section li a:hover .result.website .page-display, .spotlight-search .results ul.section li a .active .result.website .page-display {
  -webkit-transform: scale(0.5);
  width: 990px;
  height: 998px;
  position: absolute;
  margin: -50% 0 0 -50%;
  padding-left: 6px;
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
}
.spotlight-search .results ul.section li a:hover .result.website:after, .spotlight-search .results ul.section li a .active .result.website:after {
  left: 499px;
}
.spotlight-search .results ul.section li a:hover .result.image, .spotlight-search .results ul.section li a .active .result.image {
  height: auto;
  width: 385px;
  padding: 2px 5px 3px 2px;
}
.spotlight-search .results ul.section li a:hover .result.image img, .spotlight-search .results ul.section li a .active .result.image img {
  border: 1px solid #ccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  width: 385px;
  height: auto;
}
.spotlight-search .results ul.section li a:hover .result:after, .spotlight-search .results ul.section li a .active .result:after {
  content: "";
  border-style: solid;
  border-color: transparent transparent transparent #F5F5F5;
  border-width: 12px;
  position: absolute;
  left: 391px;
  top: 52px;
  -webkit-filter: drop-shadow(1px 0 0 #B5B5B5);
  -moz-filter: drop-shadow(1px 0 0 #B5B5B5);
  -ms-filter: drop-shadow(1px 0 0 #B5B5B5);
  -o-filter: drop-shadow(1px 0 0 #B5B5B5);
  filter: drop-shadow(1px 0 0 #B5B5B5);
  -webkit-box-shadow: inset 0 0 1px #000;
  -moz-box-shadow: inset 0 0 1px #000;
  box-shadow: inset 0 0 1px #000;
}
.spotlight-search .results ul.section.no-preview {
  padding: 6px 0 0;
}
.spotlight-search .results ul.section.no-preview li a {
  line-height: 17px;
}
.spotlight-search .results ul.section.no-preview li a .result {
  display: none !important;
}
.spotlight-search .results ul.section.lbl li:first-of-type:before {
  content: "label";
  font-size: 11px;
  position: absolute;
  color: #8C8C8C;
  line-height: 20px;
  width: 100px;
  text-align: right;
}
.spotlight-search .results ul.section.lbl li:hover:first-of-type:before {
  color: #fff;
}
.spotlight-search .results ul.section.lbl.top-hit li:first-of-type:before {
  content: "Top Hit" !important;
}
.spotlight-search .results ul.section.lbl.folders li:first-of-type:before {
  content: "Folders";
}
.spotlight-search .results ul.section.lbl.folders li a > span {
  margin-left: 24px;
}
.spotlight-search .results ul.section.lbl.folders li a:before {
  content: "";
  position: absolute;
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/results-icons.png");
  height: 16px;
  width: 16px;
  margin-top: 1px;
}
.spotlight-search .results ul.section.lbl.web li:first-of-type:before {
  content: "Websites";
}
.spotlight-search .results ul.section.lbl.web li a span {
  margin-left: 24px;
}
.spotlight-search .results ul.section.lbl.web li a:before {
  content: "";
  position: absolute;
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/results-icons.png");
  height: 16px;
  width: 16px;
  background-position: -16px 0;
  margin-top: 1px;
}
.spotlight-search .results ul.section.lbl.images li:first-of-type:before {
  content: "Images";
}
.spotlight-search .results ul.section.lbl.images li a span {
  margin-left: 24px;
}
.spotlight-search .results ul.section.lbl.images li a:before {
  content: "";
  position: absolute;
  background: url("https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/results-icons.png");
  height: 16px;
  width: 16px;
  background-position: -32px 0;
  margin-top: 1px;
}

.loading-wrapper {
  position: absolute;
  z-index: 10;
  top: 7px;
  margin-left: 10px;
}

.loading {
  height: 16px;
  width: 16px;
  margin: 0 auto;
  opacity: 0.6;
  -webkit-animation: spin 0.5s steps(12, end) infinite;
}
.loading i {
  height: 5px;
  width: 2px;
  margin-left: 0px;
  display: block;
  background: #000;
  position: absolute;
  left: 45%;
  -webkit-transition: height 1s;
  -moz-transition: height 1s;
  -ms-transition: height 1s;
  -o-transition: height 1s;
  transition: height 1s;
  -webkit-transform-origin: center 8px;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}
.loading i:nth-child(1) {
  opacity: 0.08;
}
.loading i:nth-child(2) {
  -webkit-transform: rotate(30deg);
  opacity: 0.167;
}
.loading i:nth-child(3) {
  -webkit-transform: rotate(60deg);
  opacity: 0.25;
}
.loading i:nth-child(4) {
  -webkit-transform: rotate(90deg);
  opacity: 0.33;
}
.loading i:nth-child(5) {
  -webkit-transform: rotate(120deg);
  opacity: 0.4167;
}
.loading i:nth-child(6) {
  -webkit-transform: rotate(150deg);
  opacity: 0.5;
}
.loading i:nth-child(7) {
  -webkit-transform: rotate(180deg);
  opacity: 0.583;
}
.loading i:nth-child(8) {
  -webkit-transform: rotate(210deg);
  opacity: 0.67;
}
.loading i:nth-child(9) {
  -webkit-transform: rotate(240deg);
  opacity: 0.75;
}
.loading i:nth-child(10) {
  -webkit-transform: rotate(270deg);
  opacity: 0.833;
}
.loading i:nth-child(11) {
  -webkit-transform: rotate(300deg);
  opacity: 0.9167;
}
.loading i:nth-child(12) {
  -webkit-transform: rotate(330deg);
  opacity: 1;
}

@-webkit-keyframes spin {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
  }
}
html, body {
  height: 100%;
}

body {
  margin-top: 2px;
}

.demo {
  text-align: center;
  bottom: 50%;
  left: 43%;
  position: absolute;
  vertical-align: middle;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  font-smooth: always;
  color: rgba(255, 255, 255, 0.8);
  text-shadow: 0 1px 0 #000;
}
.demo.active {
  display: none;
}
.demo .click {
  font-size: 1.3rem;
  font-weight: 200;
}

</style>
</head>
<body onload="updateClock(); setInterval('updateClock()', 1000 )">
  
  <div class="header">
    <ul class="menu-bar icons">
      <li>
        <a href="#">
          <i class="icon bluetooth"></i>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="icon wifi"></i>
        </a>
      </li>
      <li>
        <a href="#" id="clock">12:41:59</a>
      </li>
      <li>
        <a href="#">
          <i class="icon volume"></i>
        </a>
      </li>
      <li id="spotlight">
        <a href="#">
          <i class="icon spotlight"></i>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="icon notification"></i>
        </a>
      </li>
    </ul>
  </div><!--/.container.header -->

  <div class="spotlight-search">
    <div class="input">
      <div class="loading-wrapper">
        <div class="loading">
          <i></i><i></i><i></i><i></i><i></i><i></i>
          <i></i><i></i><i></i><i></i><i></i><i></i>
        </div>
      </div>
      <input type="search" id="search" />
      <span>Spotlight</span>
    </div><!--/.input -->
    <div class="results">
      <ul class="section no-preview">
        <li>
          <a href="#">
            <span>Show All in Finder</span>
            <div class="result"></div>
          </a>
        </li>
      </ul>
      <ul class="section lbl images top-hit">
        <li>
                <a href="#">
                    <span>yeoman-logo</span>
                    <div class="result image">
                        <img src="https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/yeoman-logo.png" />
                    </div>
                </a>
        </li>
      </ul>
      <ul class="section lbl images">
            <li>
                <a href="#">
                    <span>yeoman-logo</span>
                    <div class="result image">
                        <img src="https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/yeoman-logo.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <span>yeoman</span>
                    <div class="result image">
                        <img src="https://dl.dropboxusercontent.com/u/1621719/Codepen/Spotlight/yeoman.gif" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="section lbl folders">
            <li>
                <a href="#">
                    <span>angular-spotlight</span>
                    <div class="result">
                        <i class="folder"></i>
                        <div class="details">
                            <div class="title">angular-spotlight</div>
                            <div class="type">Folder</div>
                            <div class="size">
                                <span>2 KB</span>
                                <span>2 items</span>
                            </div>
                            <div class="modified">Last modified Dec 22, 2013, 8:14:26 PM</div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="section lbl web">
            <li>
                <a href="#">
                    <span>ng-conf</span>
                    <div class="result website">
                        <iframe class="page-display" src="http://www.ng-conf.org" frameborder="0"></iframe>
                    </div>
                </a>
            </li>
        </ul>
        <ul class="section no-preview">
            <li>
                <a href="#">
                    <span>Spotlight Preferences...</span>
                    <div class="result"></div>
                </a>
            </li>
        </ul>
    </div>
  </div>
</div>

<div class="demo">
 <a href="https://codeclimate.com/github/ArcherSys/ArcherSys"><img src="https://codeclimate.com/github/ArcherSys/ArcherSys/badges/gpa.svg" /></a>
</div>

</body>
</html>