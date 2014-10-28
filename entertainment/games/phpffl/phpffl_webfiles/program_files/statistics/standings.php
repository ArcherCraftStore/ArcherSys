<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="standings")
{
	Switch($Action)
	{
		default:
			$sql="select ID from divisions where leagues_ID=$LEAGUEID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				display_standard_standings($LEAGUEID);
			}
			else
			{
				display_power_ranking($LEAGUEID);
			}
		break;
		case "standard_standings":
			display_standard_standings($LEAGUEID);
		break;
		case "power_rankings_standings":
			display_power_ranking($LEAGUEID);
		break;
	}
}


?>
