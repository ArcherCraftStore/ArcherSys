<?php
include("program_files/config.php");
include("program_files/admin/functions/config_global_functions.php");
include("program_files/admin/functions/teams_functions.php");
include("program_files/admin/functions/divisions_functions.php");
include("program_files/admin/functions/users_functions.php");
include("program_files/admin/functions/leagues_functions.php");
include("program_files/admin/functions/starting_lineups_functions.php");
include("program_files/admin/functions/schedules_functions.php");
include("program_files/admin/functions/schedules_templates_functions.php");
include("program_files/admin/functions/scoring_functions.php");
include("program_files/admin/functions/players_functions.php");
include("program_files/admin/functions/waiver_wire_functions.php");
include("program_files/admin/functions/trade_protests_functions.php");
include("program_files/admin/functions/trades_functions.php");
include("program_files/admin/functions/draft_functions.php");
include("program_files/admin/functions/custom_pages_functions.php");
include("program_files/admin/functions/standings_functions.php");
include("program_files/admin/functions/rosters_functions.php");
include("program_files/admin/functions/automated_scripts_functions.php");
include("program_files/myteam/functions/trades_functions.php");
include("program_files/myteam/functions/starting_lineup_functions.php");
include("program_files/profile/functions/profile_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/admin.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/my_team.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/profile.php");
$Mode=$_REQUEST['Mode'];
$Printable=$_REQUEST['Printable'];

if(check_is_superuser($USERSID) && strlen($LEAGUEID)<1)
{
	$sql="select ID from leagues;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$LEAGUEID=$rs->fields("ID");
		session_start();
		session_register('LEAGUEID');
		$_SESSION['LEAGUEID']=$LEAGUEID;
	}
	else
	{
		$LEAGUEID=0;
	}
}
Switch($Mode)
{
	case "home":
		$File_To_Include="program_files/admin/admin.php";
		$Page_Title=ADMIN_HOME;
	break;
	default:
	case "leagues":
		$Mode="leagues";
		$File_To_Include="program_files/admin/leagues.php";
		$Page_Title=LEAGUES;
	break;
	case "teams":
		$File_To_Include="program_files/admin/teams.php";
		$Page_Title=TEAMS;
	break;
	
	case "divisions":
		$File_To_Include="program_files/admin/divisions.php";
		$Page_Title=DIVISIONS;
	break;
	case "users":
		$File_To_Include="program_files/admin/users.php";
		$Page_Title=USERS;
	break;
	case "starting_lineups":
		$File_To_Include="program_files/admin/starting_lineups.php";
		$Page_Title=STARTING_LINEUPS;
	break;
	case "schedules":
		$File_To_Include="program_files/admin/schedules.php";
		$Page_Title=SCHEDULES;
	break;
	case "schedules_templates":
		$File_To_Include="program_files/admin/schedules_templates.php";
		$Page_Title=SCHEDULE_TEMPLATES;
	break;
	case "scoring":
		$File_To_Include="program_files/admin/scoring.php";
		$Page_Title=SCORING;
	break;
	case "players":
		$File_To_Include="program_files/admin/players.php";
		$Page_Title=PLAYERS;
	break;
	case "waiver_wire":
		$File_To_Include="program_files/admin/waiver_wire.php";
		$Page_Title=WAIVER_WIRE;
	break;
	case "trade_protests":
		$File_To_Include="program_files/admin/trade_protests.php";
		$Page_Title=TRADE_PROTESTS;
	break;
	case "draft":
		$File_To_Include="program_files/admin/draft.php";
		$Page_Title=DRAFT;
	break;
	case "custom_pages":
		include("program_files/FCKeditor/fckeditor.php");
		$File_To_Include="program_files/admin/custom_pages.php";
		$Page_Title=CUSTOM_PAGES;
	break;
	case "config_global":
		$File_To_Include="program_files/admin/config_global.php";
		$Page_Title=CONFIGURATION;
	break;
	case "trades":
		$File_To_Include="program_files/admin/trades.php";
		$Page_Title=TRADES;
	break;
	case "standings":
		$File_To_Include="program_files/admin/standings.php";
		$Page_Title=STANDINGS;
	break;
	case "rosters":
		$File_To_Include="program_files/admin/rosters.php";
		$Page_Title=ROSTERS;
	break;
	case "automated_scripts":
		$File_To_Include="program_files/admin/automated_scripts.php";
		$Page_Title=AUTOMATED_SCRIPTS;
	break;
}
$Logged_In_Display=get_users_display($USERSID);
if($Printable)
{
	include("template/printable_header.php");
}
else
{
	include("template/header.php");
}
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
if(!($Printable))
{
	if($ISADMIN==1)
	{
		include("template/admin_leftnav.php");
	}
	else
	{
		include("template/no_leftnav.php");
	}
}

if(ini_get("register_globals"))
{
	echo "<span class='errors'>".REGISTER_GLOBALS_WARNING."</span><br><br>";
}
include($File_To_Include);
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