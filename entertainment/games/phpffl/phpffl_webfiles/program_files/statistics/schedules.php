<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="schedules")
{

	Switch($Action)
	{
		default:
			display_league_schedule($LEAGUEID);
		break;
		case "view_player_detail":
			$Players_ID=$_REQUEST['Players_ID'];
			display_player_detail($Players_ID, $LEAGUEID);
		break;
		case "display_game_detail":
			$Team1_ID=$_REQUEST['Team1_ID'];
			$Team2_ID=$_REQUEST['Team2_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$Week_ID=$_REQUEST['Week_ID'];
			echo "<table>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
			echo "</table>";
			echo "<br>";
			$live_scoring_game_html=display_game_detail($Team1_ID, $Team2_ID, $Leagues_ID, $Week_ID);
			echo $live_scoring_game_html;
		break;
	}
}


?>
