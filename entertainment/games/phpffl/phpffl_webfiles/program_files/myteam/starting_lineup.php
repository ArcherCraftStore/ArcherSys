<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from admin.php
if($Mode=="starting_lineup")
{

	Switch($Action)
	{
		case "starting_lineup_main":
		default:
			$current_week=get_current_startinglineup_week();
			if($current_week==-1)
			{
				$sql="select max(week) as max_week from league_schedules;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$current_week=$rs->fields("max_week");
				}
			}
			display_starting_lineup($Teams_ID, $LEAGUEID, $current_week);
		break;
		case "update_starting_lineup":
			$Week_ID=$_POST['Week_ID'];
			$current_week=get_current_startinglineup_week();
			if($Week_ID<$current_week)
			{
				$Week_ID=$current_week;
			}

			if($current_week==-1)
			{
				echo "<span class='errors'>".SEASON_OVER_CANT_SUBMIT_LINEUP."<br></span>";
				display_starting_lineup($Teams_ID, $LEAGUEID, $current_week);
			}
			else
			{
				display_update_starting_lineup($Teams_ID, $LEAGUEID, $Week_ID);
			}
		break;
		case "confirm_update_starting_lineup":
			$Starting_Lineup=$_REQUEST['Starting_Lineup'];
			$UpdateFutureWeeks=$_REQUEST['UpdateFutureWeeks'];
			$Week_ID=$_REQUEST['Week_ID'];
			$current_week=get_current_startinglineup_week();
			$weeks_in_season=get_number_weeks_season();
			if($current_week==-1)
			{
				$sql="select max(week) as max_week from league_schedules;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$current_week=$rs->fields("max_week");
				}
			}
			$duplicate_players=false;
			$players_test=array();
			//Test to make sure not trying to set lineup for a previous week
			if($Week_ID<$current_week)
			{
				echo "<span class='errors'>".LINEUP_SUBMISSION_ERROR_WEEK_OVER."<br></span>";
				display_update_starting_lineup($Teams_ID, $LEAGUEID, $current_week, "", $UpdateFutureWeeks);
			}
			else
			{
				$current_week=$Week_ID;
				if(is_array($Starting_Lineup))
				{
					//Test for Duplicate Players
					foreach($Starting_Lineup as $key => $val)
					{
						if(is_array($Starting_Lineup[$key]))
						{
							foreach($Starting_Lineup[$key] as $key2 => $val2)
							{
								if($val2!="ZZZ")
								{
									if(!(in_array($val2, $players_test)))
									{
										$players_test[]=$val2;
									}
									else
									{
										$duplicate_players=true;
									}
								}
							}
						}
					}

					if($duplicate_players==true)
					{
						echo "<span class='errors'>".ENTERED_SAME_PLAYER_MORE_THAN_ONCE."<br></span>";
						display_update_starting_lineup($Teams_ID, $LEAGUEID, $current_week, "", $UpdateFutureWeeks);
					}
					else
					{
						$sql="delete from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and weeks_ID=$current_week and games_ID=$current_week;";
						$DB->Execute($sql);
						if($UpdateFutureWeeks)
						{
							for($i=$current_week+1; $i<=$weeks_in_season; $i++)
							{
								$sql="delete from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and weeks_ID=$i and games_ID=$i;";
								$DB->Execute($sql);
							}
						}
						foreach($Starting_Lineup as $key => $val)
						{
							if(is_array($Starting_Lineup[$key]))
							{
								foreach($Starting_Lineup[$key] as $key2 => $val2)
								{

									if($val2!="ZZZ")
									{
										$sql="insert into starting_lineup_actuals (teams_ID, players_ID, weeks_ID, games_ID, leagues_ID, positions_ID) values ('$Teams_ID', '$val2', '$current_week', '$current_week', '$LEAGUEID', '$key');";
										$DB->Execute($sql);
										if($UpdateFutureWeeks)
										{
											for($i=$current_week+1; $i<=$weeks_in_season; $i++)
											{
												$sql="insert into starting_lineup_actuals (teams_ID, players_ID, weeks_ID, games_ID, leagues_ID, positions_ID) values ('$Teams_ID', '$val2', '$i', '$i', '$LEAGUEID', '$key');";
												$DB->Execute($sql);
											}
										}
										$position_name=get_lineup_position_name($key, "short");
										$sql="select firstname, lastname from players where ID='$val2';";
										$rs=$DB->Execute($sql);
										if(!($rs->EOF))
										{
											$firstname=$rs->fields("firstname");
											$lastname=$rs->fields("lastname");
											$starting_lineup_text=$starting_lineup_text."$position_name: $lastname, $firstname \n";
										}

										$DB->Execute($sql);
									}

								}
							}
						}
						$current_date=gmdate("Y-m-d H:i:s");
						$starting_lineup_text=mysql_escape_string($starting_lineup_text);
						$sql="insert into starting_lineup_submissions (teams_ID, weeks_ID, games_ID, users_ID, starting_lineup, submission_date, leagues_ID) values ('$Teams_ID', '$current_week', '$current_week', '$USERSID', '$starting_lineup_text', '$current_date', '$LEAGUEID');";
						$DB->Execute($sql);
						display_starting_lineup($Teams_ID, $LEAGUEID, $current_week);
					}
				}
				else
				{
					$current_week=get_current_startinglineup_week();
					if($current_week==-1)
					{
						$sql="select max(week) as max_week from league_schedules;";
						$rs=$DB->Execute($sql);
						if(!($rs->EOF))
						{
							$current_week=$rs->fields("max_week");
						}
					}
					display_starting_lineup($Teams_ID, $LEAGUEID, $current_week);
				}
			}
		break;
		case "view_submission_history":
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=starting_lineup_main'>".BACK."</a></td></tr>";
			echo "</table>";
			display_view_submission_history($Teams_ID);
		break;
		case "view_lineup_submission":
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=view_submission_history'>".BACK."</a></td></tr>";
			echo "</table>";
			$Lineup_ID=$_REQUEST['Lineup_ID'];
			display_view_lineup_submission($Lineup_ID);
		break;
	}
}


?>