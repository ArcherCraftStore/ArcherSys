<?php
include("program_files/config.php");
include("program_files/myteam/functions/myteam_home_functions.php");
include("program_files/myteam/functions/starting_lineup_functions.php");
include("program_files/myteam/functions/waiver_wire_functions.php");
include("program_files/myteam/functions/trades_functions.php");
include("program_files/myteam/functions/team_correspondance_functions.php");
include("program_files/myteam/functions/draft_functions.php");
include("program_files/myteam/functions/private_message_functions.php");
include("program_files/statistics/functions/teams_functions.php");
include("program_files/statistics/functions/players_functions.php");
include("program_files/statistics/functions/schedules_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/my_team.php");


$Mode=$_REQUEST['Mode'];
$Printable=$_REQUEST['Printable'];

if(strlen($USERSID)<1 || strlen($LEAGUEID)<1)
{
	session_write_close();
	header("Location: {$PHPFFL_WEB_ROOT}leagues.php?PHPSESSID=$PHPSESSID");
	exit();
}
$sql="select teams_ID from users_teams, teams where users_ID=$USERSID and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
$rs=$DB->Execute($sql);
if(!($rs->EOF))
{
	$Teams_ID=$rs->fields("teams_ID");
	$Teamname=get_team_name($Teams_ID);
}
if(strlen($Teams_ID)<1)
{
	session_write_close();
	header("Location: {$PHPFFL_WEB_ROOT}statistics.php?PHPSESSID=$PHPSESSID");
	exit();
}

Switch($Mode)
{
	default:
	case "myteam":
		$Mode="myteam";
		$File_To_Include="program_files/myteam/myteam_home.php";
		$Page_Title="$Teamname";
	break;
	case "starting_lineup":
		$File_To_Include="program_files/myteam/starting_lineup.php";
		$Page_Title=STARTING_LINEUP;
	break;
	case "waiver_wire":
		$File_To_Include="program_files/myteam/waiver_wire.php";
		$Page_Title=WAIVER_WIRE;
	break;
	case "trades":
		$File_To_Include="program_files/myteam/trades.php";
		$Page_Title=TRADES;
	break;
	case "team_correspondance":
		$File_To_Include="program_files/myteam/team_correspondance.php";
		$Page_Title=CORRESPONDANCE;
	break;
	case "draft":
		$File_To_Include="program_files/myteam/draft.php";
		$Page_Title=DRAFT;
	break;
	case "private_message":
		$File_To_Include="program_files/myteam/private_message.php";
		$Page_Title=PRIVATE_MESSAGES;
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
	include("template/myteam_leftnav.php");
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