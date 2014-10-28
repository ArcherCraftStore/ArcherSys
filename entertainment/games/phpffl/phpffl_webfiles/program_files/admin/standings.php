<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="standings" && $ISADMIN==1)
{

	Switch($Action)
	{
		case "standings_main":
		default:
			display_admin_standings_main();
		break;
		case "confirm_update_standings_text":
			$Standings_Footer_Text=$_REQUEST['Standings_Footer_Text'];
			$Standings_Team_Text=$_REQUEST['Standings_Team_Text'];
			if(1)
			{
				$Standings_Footer_Text=addslashes($Standings_Footer_Text);
			}
			$sql="update leagues set standings_footer_text='$Standings_Footer_Text' where ID=$LEAGUEID;";
			$DB->Execute($sql);
			if(is_array($Standings_Team_Text))
			{
				foreach($Standings_Team_Text as $key => $val)
				{
					if(1)
					{
						$val=addslashes($val);
					}
					$sql="update teams set standings_team_text='$val' where ID=$key;";
					$DB->Execute($sql);
				}
			}
			display_admin_standings_main();
		break;
		
	}
}



?>