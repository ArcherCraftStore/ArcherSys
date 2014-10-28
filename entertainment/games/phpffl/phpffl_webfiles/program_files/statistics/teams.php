<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="teams")
{
	Switch($Action)
	{
		default:
		case "teams_main":
			$View_All_Rosters=$_REQUEST['View_All_Rosters'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			display_teams_main($Teams_ID, $View_All_Rosters);
		break;
		case "view_player_detail":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Players_ID=$_REQUEST['Players_ID'];
			$View_All_Rosters=$_REQUEST['View_All_Rosters'];
			if(!($Printable))
			{
				echo "<table border='0' cellpadding='4' cellspacing='3'>";
				echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=teams_main&Teams_ID=$Teams_ID&View_All_Rosters=$View_All_Rosters'>".BACK."</a></td></tr>";
				echo "</table>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
	}
}


?>