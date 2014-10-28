<?php 
include("program_files/config.php");
include("program_files/leagues/functions/leagues_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/leagues.php");

$Mode=$_REQUEST['Mode'];

Switch($Mode)
{
	default:
	case "leagues":
		$Mode="leagues";
		$File_To_Include="program_files/leagues/leagues.php";
		$Page_Title=LEAGUES;
	break;
}
$Logged_In_Display=get_users_display($USERSID);
include("template/header.php");
$league_name=get_league_name($LEAGUEID);
$Page_Title=$league_name.": ".$Page_Title;
include("template/no_leftnav.php");
include($File_To_Include);
echo "</td></tr></table></td></tr></tbody></table>";
include("template/footer.php");
?>
