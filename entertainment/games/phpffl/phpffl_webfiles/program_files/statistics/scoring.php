<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="scoring")
{
	Switch($Action)
	{
		default:
		case "scoring_main":
			$Position_Description=$_REQUEST['Position_Description'];
			display_league_scoring($Position_Description);
		break;
	}
}


?>

