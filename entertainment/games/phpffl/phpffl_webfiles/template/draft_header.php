<html>
<head>
<?php echo "$Meta_Refresh"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="author" CONTENT="Jason Goetz">
<meta name="publisher" CONTENT="Jason Goetz">
<meta name="keywords" content="phpffl, php, mysql, web based fantasy football, fantasy football, nfl fantasy football, php fantasy football, php nfl fantasy football, free fantasy football, free nfl fantasy football, open source, open source fantasy football, open source php fantasy football, nfl, free fantasy american football, free fantasy football league manager, free fantasy football league, fantasy football league manager, custom fantasy football, customizable fantasy football, online fantasy football, free online fantasy football. fantasy football forum, fantasy football forums, fantasy football message board, fantasy football message boards, fantasy football bulletin boards, sourceforge fantasy football, sourceforge php mysql, sourceforge free fantasy football">
<meta name="description" content="phpFFL is a free, open-source and fully customizable online Fantasy Football League Manager with automatic live scoring. Everything in phpFFL, from league adminstration to individual team player transactions and lineup submissions is handled through an easy to use online interface. phpFFL is easy to install and you can have your league up and running very quickly. phpFFL is written in php and uses a MySQL database so the only requirements are that your server supports php and MySQL.">
<title>phpFFL : Free Online Fantasy Football League Manager</title>
<!--<link rel="shortcut icon" href="./favicon.ico" />-->
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/writelayer.js"></script>
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/jquery-1.3.2.js"></script>
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/thickbox.js"></script>
</head>
<body>
<link href="css/thickbox.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<style type="text/css">
.header {
	font-size: 18px;
	font-style: italic;
	font-weight: bold;
}
.current {
	font-size: 30px;
	font-style: italic;
	font-weight: bold;
	border: thin none;
	color: #009900;
}
.header1 {
	font-size: 22px;
	font-style: italic;
	font-weight: bold;
	color: #000099;


}
.ondeck {
	font-size: 24px;
	font-style: italic;
	font-weight: bold;
}
.title {
	font-size: 26px;
	font-style: italic;
	font-weight: bold;
}
.title2 {
	font-size: 18px;
	font-style: normal;
	font-weight: bold;
}
.title3 {
	font-size: 21px;
	font-style: italic;
	font-weight: bold;
}
.positionnums {
	font-size: 18px;
	font-style: italic;
	font-weight: bold;
}
.table {
	font-size: 19px;
	font-weight: bold;
	font-style: normal;

}
.table2 {
	font-size: 15px;
	font-weight: bold;
	font-style: normal;

}

.digits_small {
	margin-top: 15px;
	color: #FF0000;
	font-size: 14pt;
	font-weight: bold;

}
.digits_normal {
	margin-top: 15px;
	color: #FF0000;
	font-size: 22pt;
	font-weight: bold;

}
.digits_large {
	margin-top: 15px;
	color: #FF0000;
	font-size: 28pt;
	font-weight: bold;

}
.smallink {
	font-size: 12px;
}
.currentclock {

	font-size: 18px;
	font-style: italic;
	font-weight: bold;
	border: thin none;
	color: #009900;
}
</style>
<table class="bodyline" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td>
<!--
<table class="" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td align="left"><img src="images/phpffl_280.jpg" border="0" alt="phpFFL Home" title="phpFFL Home" /></td><td align="right" valign="bottom"><?=$Logged_In_Display?></td>
				</tr>

				<tr class="topbkg">
					<td height="11" colspan="2">
</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
-->
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td align="left" class="topnav" width="25%">&nbsp;
<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=draft_home&Style=Small">Small</a>&nbsp; &#8226; &nbsp;

<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=draft_home&Style=Normal">Normal</a>&nbsp; &#8226; &nbsp;

<a href="draft.php?Mode=<?php echo "$Mode";?>Action=draft_home&Style=Large">Large</a>
	</td>
		<td align="center" class="topnav" width="50%">&nbsp;
<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=draft_home&Style=<?php echo "$Style";?>">Draft Home</a>&nbsp; &#8226; &nbsp;

<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=players&Style=<?php echo "$Style";?>">Players</a>&nbsp; &#8226; &nbsp;

<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=teams&Style=<?php echo "$Style";?>">Teams</a>&nbsp; &#8226; &nbsp;

<a href="draft.php?Mode=<?php echo "$Mode";?>&Action=draft_order&Style=<?php echo "$Style";?>">Draft Order</a>
	</td>
	<td align="center" class="topnav" width="25%">&nbsp;

	</td>
	</tr>
</table>
<table style="width: 100%;" border="0" cellspacing="1" cellpadding="1">
<tr>
<td style="vertical-align: top; width: 100%;">
