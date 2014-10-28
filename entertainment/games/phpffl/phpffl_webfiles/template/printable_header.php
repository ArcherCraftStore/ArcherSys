<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="author" CONTENT="Jason Goetz">
<meta name="publisher" CONTENT="Jason Goetz">
<meta name="keywords" content="phpffl, php, mysql, web based fantasy football, fantasy football, nfl fantasy football, php fantasy football, php nfl fantasy football, free fantasy football, free nfl fantasy football, open source, open source fantasy football, open source php fantasy football, nfl, free fantasy american football, free fantasy football league manager, free fantasy football league, fantasy football league manager, custom fantasy football, customizable fantasy football, online fantasy football, free online fantasy football. fantasy football forum, fantasy football forums, fantasy football message board, fantasy football message boards, fantasy football bulletin boards, sourceforge fantasy football, sourceforge php mysql, sourceforge free fantasy football">
<meta name="description" content="phpFFL is a free, open-source and fully customizable online Fantasy Football League Manager with automatic live scoring. Everything in phpFFL, from league adminstration to individual team player transactions and lineup submissions is handled through an easy to use online interface. phpFFL is easy to install and you can have your league up and running very quickly. phpFFL is written in php and uses a MySQL database so the only requirements are that your server supports php and MySQL.">
<title>phpFFL : Free Online Fantasy Football League Manager</title>
<!--<link rel="shortcut icon" href="./favicon.ico" />-->
<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body <?php echo $BODY_TAG_TEXT;?>>
<?php
$width=645;
if(strlen($_GET['width'])>0)
{
	$width=floor(0.95  * $_GET['width']);
}
?>
<table class="bodyline" width="<?php echo $width; ?>" cellspacing="0" cellpadding="0" border="0">
<tr><td>