<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from admin.php
if($Mode=="waiver_wire")
{

	Switch($Action)
	{
		case "waiver_wire_main":
		default:
			waiver_wire_main($Teams_ID);
		break;
		case "request_player_search":
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_waiver_search_main($Teams_ID, $Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "request_player":
			$Players_ID=$_REQUEST['Players_ID'];
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_request_player($Players_ID, $Teams_ID, $Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "confirm_request_player":
			$Drop_Players_ID=$_REQUEST['Drop_Players_ID'];
			$Players_ID=$_REQUEST['Players_ID'];
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Waiver_Comments=$_REQUEST['Waiver_Comments'];
			$gmt_date=gmdate("Y-m-d H:i:s");
			//Check to see if this waiver exceeds Max Player in Roster Requirements
			$errors="";
			$players_position_totals=get_players_position_totals_team($Teams_ID);
			$drop_players_positions_ID=get_players_positions_ID($Drop_Players_ID);
			$pickup_players_positions_ID=get_players_positions_ID($Players_ID);
			if($drop_players_positions_ID!=$pickup_players_positions_ID)
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
						$errors=$errors.REQUEST_ROSTER_LIMIT_EXCEEDED_WARNING."<br>";
						$errors=$errors."$position_name: $max_allowed<br>";
					}
					elseif($players_position_totals[$key] < $roster_requirements_array[$key]['min_players'] && $roster_requirements_array[$key]['min_players']>0 && $key==$pickup_players_positions_ID)
					{
						$min_allowed=$roster_requirements_array[$key]['min_players'];
						$position_name=get_lineup_position_name($key, "long");
						$errors=$errors.REQUEST_ROSTER_MINIMUM_EXCEEDED_WARNING."<br>";
						$errors=$errors."$position_name: $min_allowed<br>";
					}
				}
			}

			$roster_maximum=get_roster_maximum($LEAGUEID);
			$team_total_players=0;
			foreach($players_position_totals as $key => $val)
			{
				$team_total_players=$team_total_players+$val;
			}
			if($team_total_players>$roster_maximum && $roster_maximum>0 && $Drop_Players_ID=='0')
			{
				$errors=$errors.REQUEST_ROSTER_TOTAL_MAXIMUM_WARNING."<br>";
				$errors=$errors.ROSTER_MAXIMUM.": $roster_maximum<br>";
			}

			if(strlen($errors)<1)
			{
				$sql="select allow_auto_waivers, days_clear_waivers, draft_date from leagues where ID=$LEAGUEID;";
				if(get_magic_quotes_gpc())
				{
					$Waiver_Comments=stripslashes($Waiver_Comments);
				}
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$allow_auto_waivers=$rs->fields("allow_auto_waivers");
					$days_clear_waivers=$rs->fields("days_clear_waivers");
					$draft_date=$rs->fields("draft_date");
				}
				$Auto_Process=false;
				if($allow_auto_waivers=="Yes")
				{

					$clear_waivers_timestamp=mktime(date("H"),gmdate("i"), date("s"), date("m"), date("d")-$days_clear_waivers,date("y"));
					$clear_waivers_date=gmdate("Y-m-d H:i:s", $clear_waivers_timestamp);

					$sql="select ID from waiver_wire where leagues_ID=$LEAGUEID and waive_players_ID='$Players_ID' and approval_status='Approved' and date_approved>'$clear_waivers_date';";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$Auto_Process=false;
					}
					else
					{
						$Auto_Process=true;
					}

				}
				if($Drop_Players_ID=="0" || $Players_ID=="0")
				{
					$Auto_Process=false;
				}
				if($Auto_Process)
				{
					$sql="insert into waiver_wire (teams_ID, waive_players_ID, pickup_players_ID, approval_status, date_entered, leagues_ID, request_users_ID, approve_users_ID, date_approved) values ('$Teams_ID', '$Drop_Players_ID', '$Players_ID', 'Approved', '$gmt_date', '$LEAGUEID', '$USERSID', '$USERSID', '$gmt_date');";
					$DB->Execute($sql);
					$sql="delete from rosters where players_ID='$Drop_Players_ID' and leagues_ID=$LEAGUEID and current_teams_ID=$Teams_ID;";
					$DB->Execute($sql);
					$sql="select ID from rosters where players_ID='$Players_ID' and current_teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
					$rosters_rs=$DB->Execute($sql);
					if($rosters_rs->EOF)
					{
						$sql="insert into rosters (players_ID, current_teams_ID, leagues_ID) values ('$Players_ID', '$Teams_ID', '$LEAGUEID');";
						$DB->Execute($sql);
					}


					if($Drop_Players_ID!=0 || strlen($Drop_Players_ID)>1)
					{

						$week_ID=get_current_startinglineup_week();
						$current_week_ID=$week_ID;
						//Remove player from starting lineup for any subsequent weeks
						$players_game_date=get_players_game_time($Drop_Players_ID, $week_ID);
						$current_est_date=get_current_EST_date();
						//Check to see if the game has already started for the current week.
						if($current_est_date>=$players_game_date && $players_game_date!=-1)
						{
							//do nothing because game has already started
							$current_week_ID=$week_ID+1;
						}
						$sql="delete from starting_lineup_actuals where players_ID='$Drop_Players_ID' and weeks_ID>=$current_week_ID and games_ID>=$current_week_ID and leagues_ID=$LEAGUEID;";
						$DB->Execute($sql);
					}
					$current_week_ID=$week_ID;


					echo YOUR_WAIVER_REQEUEST_AUTO_APPROVED."<br>";
				}
				else
				{
					$sql="insert into waiver_wire (teams_ID, waive_players_ID, pickup_players_ID, approval_status, date_entered, leagues_ID, request_users_ID) values ('$Teams_ID', '$Drop_Players_ID', '$Players_ID', 'Pending', '$gmt_date', '$LEAGUEID', '$USERSID');";
					echo YOUR_WAIVER_REQEUEST_PENDING_APPROVAL."<br>";
					$DB->Execute($sql);

					$sql="select users_ID from admin_users_leagues where leagues_ID=$LEAGUEID;";
					$rs=$DB->Execute($sql);
					$current_team_name=get_team_name($Teams_ID);
					$drop_player_array=get_player_data_array($Drop_Players_ID);
					$pickup_player_array=get_player_data_array($Players_ID);
					$drop_player_name="{$drop_player_array['firstname']} {$drop_player_array['lastname']}";
					$pickup_player_name="{$pickup_player_array['firstname']} {$pickup_player_array['lastname']}";
					$Email_subject="Waiver Request: $current_team_name";
					$Email_message="Waiver Request: $current_team_name\n";
					$Email_message=$Email_message."Drop: $drop_player_name\n";
					$Email_message=$Email_message."Pickup: $pickup_player_name\n\n";
					$Email_message=$Email_message."Comments: $Waiver_Comments\n";
					while(!($rs->EOF))
					{
						$current_users_ID=$rs->fields("users_ID");
						$users_email=get_users_email($current_users_ID);
						if(strlen($users_email)>0)
						{
							send_email($users_email, $Email_subject, $Email_message);
						}
						$rs->MoveNext();
					}
				}
			}
			else
			{
				echo "<span class='errors'>{$errors}</span>";
			}
			waiver_wire_main($Teams_ID);
		break;
		case "remove_waiver_wire_request":
			$WaiverWire_ID=$_REQUEST['WaiverWire_ID'];
			echo SURE_YOU_WANT_TO_DELETE_WAIVER_REQUEST."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_waiver_wire_request&WaiverWire_ID=$WaiverWire_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=waiver_wire_main'>".NO."</a>";
		break;
		case "confirm_remove_waiver_wire_request":
			$WaiverWire_ID=$_REQUEST['WaiverWire_ID'];
			$sql="select teams_ID, approval_status from waiver_wire where ID=$WaiverWire_ID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$waiver_teams_ID=$rs->fields("teams_ID");
				$waiver_status=$rs->fields("approval_status");
				if($waiver_teams_ID==$Teams_ID && $waiver_status=="Pending")
				{
					$sql="delete from waiver_wire where ID=$WaiverWire_ID;";
					$DB->Execute($sql);
				}
			}
			waiver_wire_main($Teams_ID);
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
				echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".BACK."</a></td></tr>";
				echo "</table>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
	}
}


?>
