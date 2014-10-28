<?php
include("program_files/config.php");
include("program_files/signup/functions/signup_functions.php");
include("program_files/statistics/functions/scoring_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/signup.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/leagues.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/statistics.php");


$Mode=$_REQUEST['Mode'];

Switch($Mode)
{
	default:
	case "signup":
		$Mode="signup";
		$File_To_Include="program_files/signup/signup.php";
		$Page_Title=SIGN_UP;
	break;
}
$Logged_In_Display=get_users_display($USERSID);
include("template/header.php");
$league_name=get_league_name($LEAGUEID);
$Page_Title=$Page_Title;
include("template/signup_leftnav.php");
include($File_To_Include);
echo "</td></tr></table></td></tr></tbody></table>";
include("template/footer.php");
?>

