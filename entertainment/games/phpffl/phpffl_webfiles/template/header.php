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
<link href="css/thickbox.css" rel="stylesheet" type="text/css">
<link href="<?php echo $PHPFFL_WEB_ROOT;?>css/main.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/writelayer.js"></script>
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/jquery-1.3.2.js"></script>
<script language="javascript" src="<?php echo $PHPFFL_WEB_ROOT;?>js/thickbox.js"></script>

<script type="text/javascript">

function reStripeTables(){
	$(".stripeMe tr:even").removeClass("alt");
	$(".stripeMe tr:even").addClass("alt");

	$(".stripeMe tr").mouseover(function(){
		$(this).addClass("over");
	});
	$(".stripeMe tr").mouseout(function(){
		$(this).removeClass("over");
	});
}
$(document).ready(function() {
	reStripeTables();
});
</script>
</head>
<body <?php echo $BODY_TAG_TEXT;?>>
<table class="bodyline" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td>
<table class="" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr><?php
					$MAIN_PHPFFL_LOGO=$PHPFFL_IMAGE_PATH."phpffl_280.jpg";
					if(strlen($LEAGUEID)>0)
					{
						$sql="select league_logo from leagues where ID=$LEAGUEID;";
						$leagues_rs=$DB->Execute($sql);
						if(!($leagues_rs->EOF))
						{
							$current_league_logo=$leagues_rs->fields("league_logo");
							if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$current_league_logo"))
							{
								$MAIN_PHPFFL_LOGO=$PHPFFL_IMAGE_PATH."/team_logos/{$current_league_logo}";
							}
						}
					}
					?><td align="left"><img src="<?php echo $MAIN_PHPFFL_LOGO;?>" border="0" alt="phpFFL Home" title="phpFFL Home" /></td><td align="right" valign="bottom"><div id="Logged_In_Display" class="Logged_In_Display"><?php echo "$Logged_In_Display";?></div></td>
				</tr>

				<tr class="topbkg">
					<td height="11" colspan="2">
</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td align="center" class="topnav">&nbsp;
		<?php
		if(strlen($USERSID)<1)
		{?>
			<a href="signup.php"><?php echo SIGN_UP;?></a>&nbsp; &#8226; &nbsp;
			<a href="login.php"><?php echo LOGIN;?></a>&nbsp; &#8226; &nbsp;
		<?php
		}
		else
		{
			$user_in_league=is_user_in_league($USERSID, $LEAGUEID);
		?>
			<a href="logout.php"><?php echo LOGOUT;?></a>&nbsp; &#8226; &nbsp;
		<?php
			if($user_in_league==1)
			{
		?>
				<a href="my_team.php"><?php echo MY_TEAM;?></a>&nbsp; &#8226; &nbsp;
		<?php
			}
		}
		?>
		<?php
		if(strlen($LEAGUEID)>0)
		{
		?>

			<a href="statistics.php"><?php echo STATISTICS;?></a>&nbsp; &#8226; &nbsp;
			<a href="transactions.php"><?php echo TRANSACTIONS;?></a>&nbsp;&#8226;&nbsp;
			<!--<a href="history.php">History</a>&nbsp; &#8226;&nbsp;-->
			<a href="custom_pages.php"><?php echo CUSTOM_PAGES;?></a>&nbsp; &#8226;&nbsp;
		<?php
		}
		?>
<a href="leagues.php"><?php echo LEAGUES;?></a>&nbsp; &#8226; &nbsp;
<?php
if($ISADMIN==1)
{
?>
<a href="admin.php"><?php echo ADMIN;?></a>&nbsp; &#8226; &nbsp;
<?php
}
?>
<?php
if(strlen($USERSID>0))
{
?>
<a href="profile.php"><?php echo PROFILE;?></a>&nbsp; &#8226; &nbsp;
<?php
}
?>
<a href="faq.php"><?php echo FAQ;?></a></td>
	</tr>
</table>
<table style="width: 95%;" border="0" cellspacing="5" cellpadding="5">
<tr>
<td style="vertical-align: top; width: 100%;">