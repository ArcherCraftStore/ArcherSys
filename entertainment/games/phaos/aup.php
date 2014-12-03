<?php

define('AUTH',true);
include "config.php";
include "global.php";
include_once "class_character.php";
include_once "functions.php";
include_once 'include_lang.php';

if ( !$auth ) {
	?>
	<html>
	<head>
	<title><?php echo $SITETITLE; ?></title>
	<link rel=stylesheet type=text/css href=styles/phaos.css>
	<link rel='shortcut icon' href='images/phaos.ico' type='image/x-icon'>
	<link rel='icon' href='images/phaos.ico' type='image/x-icon'>
	</head>
	<body bottommargin="0" rightmargin="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<div align=center>
	<br>
	<br>
	<form method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
	<table border="0" cellspacing="1" cellpadding="0" width="435" height="315" background="images/scroll.png">
	<tr>
	<td colspan="2" align=center>
	<img src="images/login_logo.gif">
	<p>
	<table cellspacing=0 cellpadding=0 border=0>
	<tr>
	<td align=right><font color="black"><strong><?php echo $lang_aup["user"]; ?>: &nbsp</strong></font></td>
	<td><input name="PHP_PHAOS_USER" type="text" value="<?php echo $_COOKIE[PHP_PHAOS_USER]; ?>"></td>
	</tr>
	<tr>
	<td align=right><font color="black"><strong><?php echo $lang_aup["pass"]; ?>: &nbsp</strong></font></td>
	<td><input name="PHP_PHAOS_PW" type="password"></td>
	</tr>
	</table>
	<br>
	<input type="submit" value="<?php echo $lang_aup["login"]; ?>"> 
	</td> 
	</tr> 
	</table> 
	</form> 
	<p>
	<a href="register.php"><?php echo $lang_aup["register"]; ?></a> 
	<p>
	<br>
	<br>
	<a href='http://www.worldofphaos.com/magewar/index.php?rbuid=1' target='_blank' title='World of Phaos: The Mage War - Free Online Strategy Game - www.WorldOfPhaos.com' style='border:none;'><div style='text-align: center'><img src='http://www.worldofphaos.com/magewar/images/banners/banner_468x60.gif' alt='World of Phaos: The Mage War - Free Online Strategy Game - www.WorldOfPhaos.com' title='World of Phaos: The Mage War - Free Online Strategy Game - www.WorldOfPhaos.com' width='468' height='60' style='border:none;'></div></a>
	<br>
	<br>
	<small>
	Copyright 2004-<?php echo date("Y",time()); ?>
	<br><a href="http://www.worldofphaos.com/" target="_blank"><?php echo $lang_aup["license"]; ?></a>

	</body>
	</html>
	<?php
	exit;
} 
?>
