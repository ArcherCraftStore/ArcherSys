<?php 
include("program_files/config.php");
include("program_files/livedraft/functions/livedraft_functions.php");
include("program_files/livedraft/sajax.php");

$Mode=$_REQUEST['Mode'];

Switch($Mode)
{
	default:
	case "livedraft":
		$Mode="livedraft";
		$File_To_Include="program_files/livedraft/livedraft.php";
	break;
	case "admin":
		$File_To_Include="program_files/livedraft/admin.php";
	break;
}
$Logged_In_Display=get_users_display($USERSID);
include($File_To_Include);
?>
