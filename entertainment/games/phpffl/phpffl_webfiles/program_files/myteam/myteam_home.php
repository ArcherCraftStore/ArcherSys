<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from admin.php
if($Mode=="myteam")
{

	Switch($Action)
	{
		case "myteam_main":
		default:
			display_team_detail($Teams_ID, 1);
		break;
		case "view_player_detail":
			$Players_ID=$_REQUEST['Players_ID'];
			if(!($Printable))
			{
				echo "<table border='0' cellpadding='4' cellspacing='3'>";
				echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=myteam_main'>".BACK."</a></td></tr>";
				echo "</table>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
		case "display_team_roster_ajax":
			$Week_ID=$_GET['Week_ID'];
			display_team_roster($Teams_ID, 0, $Week_ID, ROSTER, 0);
		break;
	}
}


?>