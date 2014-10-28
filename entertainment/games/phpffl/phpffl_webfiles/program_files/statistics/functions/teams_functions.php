<?php

function display_teams_main($Teams_ID, $View_All_Rosters)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_IMAGE_PATH, $USERSID;



	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3' width='100%'>";
		echo "<tr><td valign='top'>";
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".SELECT_TEAM.": </span></td>";
		echo "<td>";
		echo "<select name='Teams_ID'>";
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$current_teams_name=$rs->fields("team_name");
			if(strlen($Teams_ID)<1)
			{
				$Teams_ID=$current_teams_ID;
			}
			$s="";
			if($current_teams_ID==$Teams_ID)
				$s="selected";
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "<td rowspan='2' valign='top'><a href='$PHP_SELF?Mode=$Mode&Action=teams_main&View_All_Rosters=$View_All_Rosters&Teams_ID=$Teams_ID&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
		echo "</tr>";
		echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=teams_main&View_All_Rosters=1'>".VIEW_ALL_ROSTERS."</a></td></tr>";
		echo "<input type='hidden' name='Action' value='teams_main'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
		echo "<td>";
		if(strlen($USERSID)>0)
		{

			echo "<td width='53%' valign='top'>";
			display_team_contact_details($Teams_ID, $LEAGUEID);
			echo "</td>";
		}
		echo "</tr></table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='table_row_title'>".NO_TEAMS_EXIST_FOR_THIS_LEAGUE."</span></td></tr>";
		echo "</table>";
	}
	if($View_All_Rosters)
	{

		display_view_all_rosters($LEAGUEID);
	}
	elseif(strlen($Teams_ID)>0)
	{
		$sql="select ID from teams where teams_ID=$Teams_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			display_team_detail($Teams_ID);
		}
	}


}

function display_team_detail($Teams_ID, $AllowChangeLineupWeek=0)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT;

	$league_logo_array=get_league_logo_array();
	$current_week=get_current_week(-5);

	$sql="select schedules_type_ID from leagues, schedules_type where schedules_type_ID=schedules_type.ID and leagues.ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	$schedule_exists=false;
	if(!($rs->EOF))
	{
		$schedule_exists=true;
	}
	$sql="select schedules_type_ID from leagues where ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
		$schedules_type_ID=$rs->fields("schedules_type_ID");

	if(strlen($schedules_type_ID)>0)
	{
		$sql="select * from schedules_type where ID=$schedules_type_ID;";
		$rs = $DB->Execute($sql);
		if(!($rs->EOF))
		{
			$schedules_title=$rs->fields("schedule_title");
			$number_of_teams=$rs->fields("number_of_teams");
			$number_of_weeks=$rs->fields("number_of_weeks");
			$games_per_week=$rs->fields("games_per_week");
		}
	}
	if(strlen($games_per_week)<1)
	{
		$games_per_week=1;
	}
	$sql="select * from teams where ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$team_name=$rs->fields("team_name");
		$team_wins=$rs->fields("wins");
		$team_losses=$rs->fields("losses");
		$team_ties=$rs->fields("ties");
		$team_total_points=$rs->fields("total_points");
		$team_winning_percentage=$rs->fields("winning_percentage");
		echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
		echo "<tr><td colspan='3' valign='top'><table cellpadding='1' cellspacing='1'><tr><td valign='top'><span class='main_title'>$team_name";
		if($schedule_exists)
		{
			echo ": $team_wins-$team_losses-$team_ties";
		}

		echo "</span></td></tr>";
		/*
		echo "<tr><td colspan='3'><span class='table_row_title'>";
		$sql="select first_name, last_name from users, users_teams where users.ID=users_ID and users_teams.teams_ID=$Teams_ID;";
		$users_rs=$DB->Execute($sql);
		$user_count=0;
		while(!($users_rs->EOF))
		{
			$current_first_name=$users_rs->fields("first_name");
			$current_last_name=$users_rs->fields("last_name");
			if($user_count>0)
			{
				echo ", ";
			}
			echo "{$current_first_name} {$current_last_name}";
			$user_count++;
			$users_rs->MoveNext();
		}
		echo "</span></td></tr>";
		*/
		if($league_logo_array['display_team_logos']=="Yes")
		{
			$team_logo_filename=get_team_logo($Teams_ID);
			if(strlen($team_logo_filename)>0 && is_file($PHPFFL_FILE_ROOT."images/team_logos/$team_logo_filename"))
			{
				echo "<tr><td colspan='3'>&nbsp;&nbsp;<img  src='{$PHPFFL_IMAGE_PATH}team_logos/$team_logo_filename' /></td></tr>";
			}
		}
		echo "</table>";
		echo "</td></tr>";


		echo "<tr><td colspan='2' height='2'></td></tr>";

		echo "<tr>";
		if($schedule_exists)
		{
			echo "<td valign='top' width='47%'>";
			echo "<table width='100%'>";
			echo "<tr><td colspan='3'><span class='main_title'>".SCHEDULE."</span></td></tr>";
			echo "</table>";
			echo "<table width='100%' class='stripeMe'>";
			echo "<tr><th>".WEEK."</th>";
			if($games_per_week>1)
			{
				//echo "<td><span class='table_row_title'>".GAME."</span></td>";
			}
			echo "<th>".OPPONENT."</th><th>".RESULT."</th></tr>";
			//echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
			$bg="";
			for($i=1;$i<=$number_of_weeks;$i++)
			{
				for($j=1;$j<=$games_per_week;$j++)
				{
					$opponent_data=get_team_opponent($Teams_ID, $i, $i, $LEAGUEID, $j);
					$opponent_name=$opponent_data["teamname"];
					$opponent_ID=$opponent_data["ID"];
					$game_result=get_game_result($Teams_ID, $opponent_ID, $i, $i, $LEAGUEID);
					echo "<tr>";
					echo "<td width='50'><span class='table_row_title'>$i</span></td>";
					if($games_per_week>1)
					{
						//echo "<td width='50'><span class='table_row_title'>$j</span></td>";
					}
					if($opponent_name=="N/A")
					{
						echo "<td>$opponent_name</td>";
					}
					else
					{
						echo "<td><a href='{$PHPFFL_WEB_ROOT}statistics.php?Mode=teams&Action=teams_main&Teams_ID=$opponent_ID'>$opponent_name</a></td>";
					}
					echo "<td>$game_result</td>";
					echo "</tr>";
				}
			}
			echo "</table></td>";
			echo "<td width='0%'>&nbsp;</td>";
		}

		echo "<td valign='top' width='53%'>";

		display_team_roster($Teams_ID, $View_All_Rosters, $current_week, ROSTER, $AllowChangeLineupWeek);

		echo "</td>";
		echo "</tr>";
		echo "</table>";
	}
}

function display_team_roster($Teams_ID, $View_All_Rosters, $current_week, $roster_title=ROSTER, $AllowChangeLineupWeek="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT, $IsAjax;


	if($current_week>0)
	{
		$starting_lineup_week=$current_week;
	}
	else
	{
		$starting_lineup_week=get_current_startinglineup_week();
	}
	$actuals_array=array();
	if(!($View_All_Rosters))
	{
		$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and weeks_ID=$starting_lineup_week and games_ID=$current_week;";
		$actuals_rs=$DB->Execute($sql);
		while(!($actuals_rs->EOF))
		{
			$players_ID=$actuals_rs->fields("players_ID");
			$actuals_array[]=$players_ID;
			$actuals_rs->MoveNext();
		}
	}

	$sql="select positionID, display_order from players_positions";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_position_ID=$rs->fields("positionID");
		$current_display_order=$rs->fields("display_order");
		$players_position_array[$current_position_ID]=$current_display_order;
		$rs->MoveNext();
	}



	$sql="select players_ID, lastname, firstname, teamID, positionID from rosters, players where players_ID=players.ID and current_teams_ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	$team_opponent_array=get_team_opponent_array($current_week);

	$starting_player_data=array();
	$starting_position_display_order=array();
	$starting_position_array=array();
	if(!($rs->EOF))
	{
		while(!($rs->EOF))
		{
			$current_players_ID=$rs->fields("players_ID");
			$current_lastname=$rs->fields("lastname");
			$current_firstname=$rs->fields("firstname");
			$current_teamID=$rs->fields("teamID");
			$current_positionID=$rs->fields("positionID");
			if(in_array($current_players_ID, $actuals_array))
			{
				$starting_player_data[$current_players_ID]["lastname"]=$current_lastname;
				$starting_player_data[$current_players_ID]["firstname"]=$current_firstname;
				$starting_player_data[$current_players_ID]["teamID"]=$current_teamID;
				$starting_player_data[$current_players_ID]["positionID"]=$current_positionID;
				$starting_position_display_order=$players_position_array[$current_positionID];
				$starting_position_array[$starting_position_display_order][$current_players_ID]=$current_lastname;
			}
			else
			{
				$player_data[$current_players_ID]["lastname"]=$current_lastname;
				$player_data[$current_players_ID]["firstname"]=$current_firstname;
				$player_data[$current_players_ID]["teamID"]=$current_teamID;
				$player_data[$current_players_ID]["positionID"]=$current_positionID;
				$position_display_order=$players_position_array[$current_positionID];
				$position_array[$position_display_order][$current_players_ID]=$current_lastname;
			}
			$rs->MoveNext();
		}

		foreach($position_array as $key => $val)
		{
			asort($position_array[$key]);
		}
		ksort($position_array);
		$bg="";
		//if(count($starting_player_data)>0)
		if(!($View_All_Rosters))
		{
			foreach($starting_position_array as $key => $val)
			{
				asort($starting_position_array[$key]);
			}
			ksort($starting_position_array);
			$roster_title=BENCH;
			if(!($IsAjax))
			{
				echo "<table width='100%'>";
				echo "<tr><td colspan='4'><span class='main_title'>".STARTING_LINEUP." - ".WEEK." ";
				if($AllowChangeLineupWeek && !($View_All_Rosters) )
				{
					$weeks_in_season=get_number_weeks_season();
					echo "<select id='lineupWeekID' name='Week_ID'>";
					for($j=1; $j<=$weeks_in_season; $j++)
					{
						$s="";
						if($j==$current_week)
						{
							$s="selected";
						}
						echo "<option value='$j' $s>$j</option>";
					}
					echo "</select>";
					?>
					<script type="text/javascript">
					$(document).ready(function() {
					   $("#lineupWeekID").change(function () {
					   		var lineupWeekID=$(this).val();
						      $.get("<?php echo $PHP_SELF; ?>", { Mode: "<?php echo $Mode; ?>", Action: "display_team_roster_ajax", Week_ID: lineupWeekID, Teams_ID: "<?php echo $Teams_ID; ?>", Leagues_ID: "<?php echo $LEAGUEID; ?>", IsAjax: "1" },
							    function(data){
							      $("#teamLineupDiv").html(data);
								  reStripeTables();
							 });
						});

					 });

					</script>
					<?php
				}
				else
				{
					echo $current_week;
				}
				echo "</span></td></tr>";
				echo "</table>";
				echo "<div id='teamLineupDiv'>";
			}
			echo "<table width='100%' class='stripeMe'>";
			echo "<tr><th>".PLAYER_NAME."</th><th>".TEAM."</th><th>".POSITION_SHORT."</th><th>".POINTS_SHORT."</th>";
			echo "<th>".OPPONENT_SHORT."</th>";
			echo "<th>".GAME_DATE."</th>";
			echo "</tr>";
			foreach($starting_position_array as $key => $val)
			{
				foreach($starting_position_array[$key] as $key2 => $val2)
				{
					$current_lastname=$starting_player_data[$key2]["lastname"];
					$current_firstname=$starting_player_data[$key2]["firstname"];
					$current_teamID=$starting_player_data[$key2]["teamID"];
					$current_positionID=$starting_player_data[$key2]["positionID"];
					$current_nfl_opponent=$team_opponent_array["detail"][$current_teamID];
					$current_gamedate=$team_opponent_array["game_date"][$current_teamID];
					if(strlen($current_gamedate)>0)
					{
						$current_gamedate_timestamp=strtotime($current_gamedate);
						$current_gamedate_display=date("M. j, g:ia", $current_gamedate_timestamp);
						//only display am
						$current_gamedate_display=str_replace("pm", "", $current_gamedate_display);
					}
					else
					{
						$current_gamedate_display=NA;
					}
					$sql="select sum(fantasy_value) as total_value from players_statistics_fantasy where players_ID='$key2' and leagues_ID=$LEAGUEID;";
					$points_rs=$DB->Execute($sql);
					if(!($points_rs->EOF))
					{
						$current_total_points=$points_rs->fields("total_value");
					}
					if(strlen($current_total_points)<1)
					{
						$current_total_points=0;
					}
					$class="thickbox";
					echo "<tr>";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$key2&Teams_ID=$Teams_ID&View_All_Rosters=$View_All_Rosters&Printable=1&height=600&width=950' class='$class'>{$current_lastname}, {$current_firstname}</a></td>";
					echo "<td>$current_teamID</td>";
					echo "<td>$current_positionID</td>";
					echo "<td>$current_total_points</td>";
					echo "<td>$current_nfl_opponent</td>";
					echo "<td>$current_gamedate_display</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "<br />";
		}

		if(count($player_data)>0)
		{
			echo "<table width='100%'>";
			echo "<tr><td colspan='4'><span class='main_title'>".$roster_title."</span></td></tr>";
			echo "</table>";
			echo "<table width='100%' class='stripeMe'>";
				echo "<tr><th>".PLAYER_NAME."</th><th>".TEAM."</th><th>".POSITION_SHORT."</th><th>".POINTS_SHORT."</th>";
			echo "<th>".OPPONENT_SHORT."</th>";
			echo "<th>".GAME_DATE."</th>";
			echo "</tr>";
			foreach($position_array as $key => $val)
			{

				foreach($position_array[$key] as $key2 => $val2)
				{
					$current_lastname=$player_data[$key2]["lastname"];
					$current_firstname=$player_data[$key2]["firstname"];
					$current_teamID=$player_data[$key2]["teamID"];
					$current_positionID=$player_data[$key2]["positionID"];
					$current_nfl_opponent=$team_opponent_array["detail"][$current_teamID];
					$current_gamedate=$team_opponent_array["game_date"][$current_teamID];
					if(strlen($current_gamedate)>0)
					{
						$current_gamedate_timestamp=strtotime($current_gamedate);
						$current_gamedate_display=date("M. j, g:ia", $current_gamedate_timestamp);
						//only display am
						$current_gamedate_display=str_replace("pm", "", $current_gamedate_display);
					}
					else
					{
						$current_gamedate_display=NA;
					}
					$sql="select sum(fantasy_value) as total_value from players_statistics_fantasy where players_ID='$key2' and leagues_ID=$LEAGUEID;";
					$points_rs=$DB->Execute($sql);
					if(!($points_rs->EOF))
					{
						$current_total_points=$points_rs->fields("total_value");
					}
					if(strlen($current_total_points)<1)
					{
						$current_total_points=0;
					}
					$class="thickbox";
					echo "<tr >";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$key2&Teams_ID=$Teams_ID&View_All_Rosters=$View_All_Rosters&Printable=1&height=600&width=950' class='$class'>$current_lastname, $current_firstname</a></td>";
					echo "<td>$current_teamID</td>";
					echo "<td>$current_positionID</td>";
					echo "<td>$current_total_points</td>";
					echo "<td>$current_nfl_opponent</td>";
					echo "<td>$current_gamedate_display</td>";
					echo "</tr>";
				}
			}
			//echo "</table>";

		}

	}
	else
	{

	echo "<tr><td colspan='4'>".NONE."</td></tr>";

	}
	echo "</table>";
	if(!($IsAjax))
	{
		echo "</div>";
	}
}
function display_view_all_rosters($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_WEB_ROOT, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT;

	$current_week=get_current_week(-5);
	$sql="select ID, team_name from teams where leagues_ID=$Leagues_ID;";
	$teams_rs=$DB->Execute($sql);
	if(!($teams_rs->EOF))
	{
		echo "<table width='60%'>";
		while(!($teams_rs->EOF))
		{
			$current_teams_ID=$teams_rs->fields("ID");
			$current_teams_name=$teams_rs->fields("team_name");

			echo "<tr><td>";
			display_team_roster($current_teams_ID, 1, $current_week, $current_teams_name);
			echo "</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$teams_rs->MoveNext();
		}

		echo "</table>";
	}
}

function display_team_contact_details($Teams_ID, $Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;

	$sql="select display_user_contact_details from leagues where ID=$Leagues_ID;";
	$leagues_rs=$DB->Execute($sql);
	$display_user_contact_details=0;
	if(!($leagues_rs->EOF))
	{
		$display_user_contact_details=$leagues_rs->fields("display_user_contact_details");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3' >";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TEAM_OWNER."</span></td>";
	if($display_user_contact_details)
	{
		echo "<td><span class='table_row_title'>".EMAIL_ADDRESS."</span></td>";
		echo "<td><span class='table_row_title'>".TELEPHONE_NUMBER."</span></td>";
	}
	echo "</tr>";
	echo "<tr class='tablerowline' height='4'><td colspan='3'></td></tr>";
	$sql="select first_name, last_name, email_address, telephone_number from users, users_teams where users_ID=users.ID and users_teams.teams_ID=$Teams_ID;";
	$users_rs=$DB->Execute($sql);
	while(!($users_rs->EOF))
	{
		$first_name=$users_rs->fields("first_name");
		$last_name=$users_rs->fields("last_name");
		echo "<tr>";
		echo "<td>{$first_name} {$last_name}</td>";
		if($display_user_contact_details)
		{
			$email_address=$users_rs->fields("email_address");
			$telephone_number=$users_rs->fields("telephone_number");
			echo "<td><a href='mailto:{$email_address}'>{$email_address}</a></td>";
			echo "<td>{$telephone_number}</td>";
		}
		echo "</tr>";
		$users_rs->MoveNext();
	}
	echo "</table>";
}
?>