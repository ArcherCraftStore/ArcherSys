<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="waiver_wire" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_waiver_wire_main();
		break;
		case "process_waiver":
			$Waiver_ID=$_REQUEST['Waiver_ID'];
			$Approval_Status=$_REQUEST['Approval_Status'];
			$Override_Warning=$_REQUEST['Override_Warning'];
			echo SURE_PROCESS_WAIVER_REQUEST."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_process_waiver&Waiver_ID=$Waiver_ID&Approval_Status=$Approval_Status&Override_Warning=$Override_Warning'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
			echo "<br><br>";
			display_process_waiver($Waiver_ID, $Approval_Status);
		break;
		case "confirm_process_waiver":
			$Waiver_ID=$_REQUEST['Waiver_ID'];
			$Approval_Status=$_REQUEST['Approval_Status'];
			$Override_Warning=$_REQUEST['Override_Warning'];
			
			$sql="select teams_ID, waive_players_ID, pickup_players_ID from waiver_wire where ID=$Waiver_ID;";
			$rs=$DB->Execute($sql);
			$waive_players_ID=$rs->fields("waive_players_ID");
			$pickup_players_ID=$rs->fields("pickup_players_ID");
			$waiver_wire_teams_ID=$rs->fields("teams_ID");
			//Check to see if this waiver exceeds Max Player in Roster Requirements
			$errors="";
			$players_position_totals=get_players_position_totals_team($waiver_wire_teams_ID);
			$drop_players_positions_ID=get_players_positions_ID($waive_players_ID);
			$pickup_players_positions_ID=get_players_positions_ID($pickup_players_ID);
			if($drop_players_positions_ID!=$pickup_players_positions_ID && $Approval_Status!="Reject")
			{
				$players_position_totals[$drop_players_positions_ID]--;
				$players_position_totals[$pickup_players_positions_ID]++;
				$roster_requirements_array=get_roster_requirements_array($LEAGUEID);
				foreach($roster_requirements_array as $key => $val)
				{
					if($players_position_totals[$key] > $roster_requirements_array[$key]['max_players'] && $roster_requirements_array[$key]['max_players']>0 && $key==$pickup_players_positions_ID)
					{
						$max_allowed=$roster_requirements_array[$key]['max_players'];
						$position_name=get_lineup_position_name($key, "long");
						$errors=$errors.ADMIN_REQUEST_ROSTER_LIMIT_EXCEEDED_WARNING."<br>";
						$errors=$errors."<a href='$PHP_SELF?Mode=$Mode&Action=process_waiver&Waiver_ID=$Waiver_ID&Approval_Status=Approve&Override_Warning=Yes'>".APPROVE."</a><br>";
						$errors=$errors."$position_name: $max_allowed<br><br>";
						
					}
				}
			}
			
			if(strlen($errors)<1 || $Override_Warning=="Yes")
			{
				$current_date=gmdate("Y-m-d H:i:s");
				if($Approval_Status=="Approve")
					$Approval_Status="Approved";
				if($Approval_Status=="Reject")
					$Approval_Status="Rejected";
				$sql="update waiver_wire set approval_status='$Approval_Status', date_approved='$current_date', approve_users_ID=$USERSID where ID=$Waiver_ID;";
				$DB->Execute($sql);
				if($Approval_Status=="Approved")
				{
					$sql="select * from waiver_wire where ID=$Waiver_ID;";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$waive_players_ID=$rs->fields("waive_players_ID");
						$pickup_players_ID=$rs->fields("pickup_players_ID");
						$teams_ID=$rs->fields("teams_ID");
						$sql="delete from rosters where players_ID='$waive_players_ID' and leagues_ID=$LEAGUEID and current_teams_ID=$teams_ID;";
						$DB->Execute($sql);
						$sql="select ID from rosters where players_ID='$pickup_players_ID' and current_teams_ID=$teams_ID and leagues_ID=$LEAGUEID;";
						$rosters_rs=$DB->Execute($sql);
						if($rosters_rs->EOF)
						{
							$sql="insert into rosters (players_ID, current_teams_ID, leagues_ID) values ('$pickup_players_ID', '$teams_ID', '$LEAGUEID');";
							$DB->Execute($sql);
						}
						if($waive_players_ID!=0 || strlen($waive_players_ID)>1)
						{
							$week_ID=get_current_startinglineup_week();
							$current_week_ID=$week_ID;
							//Remove player from starting lineup for any subsequent weeks
							$players_game_date=get_players_game_time($waive_players_ID, $week_ID);
							$current_est_date=get_current_EST_date();
							//Check to see if the game has already started for the current week. 
							if($current_est_date>=$players_game_date && $players_game_date!=-1)
							{
								//do nothing because game has already started
								$current_week_ID=$week_ID+1;
							}
							$sql="delete from starting_lineup_actuals where players_ID='$waive_players_ID' and weeks_ID>=$current_week_ID and games_ID>=$current_week_ID and leagues_ID=$LEAGUEID;";
							$DB->Execute($sql);
						}
						$current_week_ID=$week_ID;
					}
				}
				
				$sql="select teams_ID from waiver_wire where ID=$Waiver_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$teams_ID=$rs->fields("teams_ID");
					$pickup_players_ID=$rs->fields("pickup_players_ID");
					$player_data=get_player_data_array($pickup_players_ID);
					$Email_subject="Waiver Processed";
					$Email_message="Your request to pick up {$player_data['firstname']} {$player_data['lastname']} has been $Approval_Status.";
					$sql="select users_ID from users_teams where teams_ID=$teams_ID;";
					$users_rs=$DB->Execute($sql);
					while(!($users_rs->EOF))
					{
						$current_users_ID=$rs->fields("users_ID");
						$users_email=get_users_email($current_users_ID);
						if(strlen($users_email))
						{
							send_email($users_email, $Email_subject, $Email_message);
						}
						$users_rs->MoveNext();
					}	
				}
			}
			else
			{
				echo "<span class='errors'>{$errors}</span>";
			}
			
			admin_waiver_wire_main();
		break;
	}
}



?>
