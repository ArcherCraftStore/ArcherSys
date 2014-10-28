<?php
include("program_files/config.php");
include("program_files/transactions/functions/waiver_wire_functions.php");
include("program_files/transactions/functions/trades_functions.php");
include("program_files/myteam/functions/trades_functions.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/transactions.php");

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
	default:
	case "waiver_wire":
		$Mode="waiver_wire";
		$File_To_Include="program_files/transactions/waiver_wire.php";
		$Page_Title=WAIVER_WIRE;
	break;
	case "trades":
		$File_To_Include="program_files/transactions/trades.php";
		$Page_Title=TRADES;
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
	include("template/transactions_leftnav.php");
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

