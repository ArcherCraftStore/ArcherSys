<?php
include("program_files/config.php");
include("program_files/statistics/functions/teams_functions.php");
include("program_files/statistics/functions/players_functions.php");
include("program_files/statistics/functions/schedules_functions.php");
include("program_files/statistics/functions/standings_functions.php");
include("program_files/statistics/functions/draft_functions.php");
include("program_files/statistics/functions/scoring_functions.php");
include("program_files/statistics/functions/live_scoring_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/statistics.php");
$Mode=$_REQUEST['Mode'];
$Printable=$_REQUEST['Printable'];
if(strlen($LEAGUEID)<1)
{
	session_write_close();
	header("Location: {$PHPFFL_WEB_ROOT}leagues.php?PHPSESSID=$PHPSESSID");
	exit();
}

Switch($Mode)
{
	case "teams":
		$File_To_Include="program_files/statistics/teams.php";
		$Page_Title=TEAMS;
	break;
	case "players":
		$File_To_Include="program_files/statistics/players.php";
		$Page_Title=PLAYERS;
	break;
	case "schedules":
		$File_To_Include="program_files/statistics/schedules.php";
		$Page_Title=SCHEDULES;
	break;
	default:
	case "standings":
		$Mode="standings";
		$File_To_Include="program_files/statistics/standings.php";
		$Page_Title=STANDINGS;
	break;
	case "live_scoring":
		$File_To_Include="program_files/statistics/live_scoring.php";
		$Page_Title=LIVE_SCORING;
		//$Meta_Refresh="<meta http-equiv=\"refresh\" content=\"120\">";
	break;
	case "draft":
		$File_To_Include="program_files/statistics/draft.php";
		$Page_Title=DRAFT;
	break;
	case "scoring":
		$File_To_Include="program_files/statistics/scoring.php";
		$Page_Title=SCORING;
	break;
}
$Logged_In_Display=get_users_display($USERSID);
if($Printable)
{
	include("template/printable_header.php");
}
elseif($IsAjax)
{
	//No Header
}
else
{
	include("template/header.php");
}
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
if(!($Printable) && !($IsAjax))
{
	include("template/statistics_leftnav.php");
}
include($File_To_Include);
if(!($Printable) && !($IsAjax))
{
	echo "</td></tr></table></td></tr></tbody></table>";

}
if($Printable)
{
	include("template/printable_footer.php");
}
elseif($IsAjax)
{
	//No Footer
}
else
{
	include("template/footer.php");
}

?>