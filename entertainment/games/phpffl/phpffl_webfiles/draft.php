<?php
include("program_files/config.php");
include("program_files/draft/functions/draft_functions.php");
include("program_files/livedraft/functions/livedraft_functions.php");
include("program_files/statistics/functions/players_functions.php");
include("program_files/statistics/functions/draft_functions.php");

$Mode=$_REQUEST['Mode'];
$Style=$_REQUEST['Style'];
$Printable=$_REQUEST['Printable'];
if(strlen($LEAGUEID)<1)
{
	session_write_close();
	header("Location: {$PHPFFL_WEB_ROOT}leagues.php?PHPSESSID=$PHPSESSID");
	exit();
}

Switch($Mode)
{
	default:
	case "draft":
		$Mode="draft";
		$File_To_Include="program_files/draft/draft.php";
		$Page_Title="Draft";
	break;
}
$Logged_In_Display=get_users_display($USERSID);
if($IsAjax)
{
	//No Header
}
elseif($Printable)
{
	include("template/printable_header.php");
}
else
{
	include("template/draft_header.php");
}
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
if(!($IsAjax) && !($Printable))
{
	include("template/draft_leftnav.php");
}
include($File_To_Include);
if(!($IsAjax) && !($Printable))
{
	echo "</td></tr></table></td></tr></tbody></table>";
}
if($IsAjax)
{
	//No Header
}
elseif($Printable)
{
	include("template/printable_footer.php");
}
else
{
	include("template/footer_nologo.php");
}
?>
