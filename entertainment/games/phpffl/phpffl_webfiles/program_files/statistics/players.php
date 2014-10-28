<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="players")
{

	Switch($Action)
	{
		default:
		case "search_players":
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_players_main($Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "view_player_detail":
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Players_ID=$_REQUEST['Players_ID'];
			if(!($Printable))
			{
				echo "<table border='0' cellpadding='4' cellspacing='3'>";
				echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".BACK."</a></td></tr>";
				echo "</table>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
	}
}


?>