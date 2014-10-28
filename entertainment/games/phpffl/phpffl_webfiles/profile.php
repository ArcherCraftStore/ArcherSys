<?php
include("program_files/config.php");
include("program_files/profile/functions/profile_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/profile.php");


$Mode=$_REQUEST['Mode'];
if(strlen($USERSID)<1)
{
	session_write_close(); 
	header("Location: {$PHPFFL_WEB_ROOT}login.php?PHPSESSID=$PHPSESSID");
	exit();
}
$sql="select teams_ID from users_teams, teams where users_ID=$USERSID and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
if(strlen($USERSID)>0 && strlen($LEAGUEID)>0)
{
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Teams_ID=$rs->fields("teams_ID");
		$Teamname=get_team_name($Teams_ID);
	}
}

Switch($Mode)
{
	default:
	case "myprofile":
		$Mode="myprofile";
		$File_To_Include="program_files/profile/profile.php";
		$Page_Title=MY_PROFILE;
	break;
}
$Logged_In_Display=get_users_display($USERSID);
include("template/header.php");
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
include("template/profile_leftnav.php");
include($File_To_Include);
echo "</td></tr></table></td></tr></tbody></table>";
include("template/footer.php");
?>

