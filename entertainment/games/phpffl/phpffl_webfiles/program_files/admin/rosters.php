<?php

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="rosters" && $ISADMIN==1)
{
	Switch($Action)
	{
		default:
			display_roster_requirements_main();
		break;
		case "update_roster_requirements":
			$Roster_Maximum=$_REQUEST['Roster_Maximum'];
			$Roster_Minimum=$_REQUEST['Roster_Minimum'];
			foreach($Roster_Maximum as $key => $val)
			{
				$current_roster_minimum=$Roster_Minimum[$key];
				$sql="select ID from rosters_requirements where positions_ID=$key and leagues_ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if($rs->EOF)
				{
					$sql="insert into rosters_requirements (positions_ID, max_players, min_players, leagues_ID) values ('$key', '$val', '$current_roster_minimum', '$LEAGUEID');";
				}
				else
				{
					$sql="update rosters_requirements set max_players=$val, min_players=$current_roster_minimum where positions_ID=$key and leagues_ID=$LEAGUEID;";
				}
				$DB->Execute($sql);
			}
			display_roster_requirements_main();
		break;
	}
}



?>
