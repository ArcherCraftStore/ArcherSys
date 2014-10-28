<?php
include("program_files/config.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/custom_pages.php");
$Logged_In_Display=get_users_display($USERSID);



$Pages_ID=$_REQUEST['Pages_ID'];
$Printable=$_REQUEST['Printable'];

if(strlen($LEAGUEID)<1)
{
	session_write_close(); 
	header("Location: {$PHPFFL_WEB_ROOT}leagues.php?PHPSESSID=$PHPSESSID");
	exit();
}

if(strlen($Pages_ID)<1)
{
	$sql="select ID, title, page_content from custom_pages where leagues_ID=$LEAGUEID and is_link=0 order by display_order ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Pages_ID=$rs->fields("ID");
		$Pages_Title=$rs->fields("title");
		$Pages_Content=$rs->fields("page_content");
	}
}
else
{
	$sql="select title, page_content from custom_pages where ID=$Pages_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Pages_Title=$rs->fields("title");
		$Pages_Content=$rs->fields("page_content");
	}
}

$Page_Title="$Pages_Title";
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
if($Printable)
{
	include("template/printable_header.php");
}
else
{
	include("template/header.php");
}
if(!($Printable))
{
	include("template/custom_pages_leftnav.php");
}
if(strlen($Pages_ID)>0)
{
	echo "$Pages_Content";
}
else
{
	echo NO_CUSTOM_PAGES_EXIST_FOR_THIS_LEAGUE;
}
echo "</td></tr></table></td></tr></tbody></table>";
if($Printable)
{
	include("template/printable_footer.php");
}
else
{
	include("template/footer.php");
}
?>
