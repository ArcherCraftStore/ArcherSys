<?php

function display_starting_lineup($Teams_ID, $leagues_ID, $week_ID, $game_ID="")
{
	global $PHP_SELF, $DB, $Mode;


	$game_ID=$week_ID;
	$sql="select * from starting_lineup_requirements where leagues_ID=$leagues_ID order by display_order ASC;";
	$requirements_rs=$DB->Execute($sql);
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$actuals_array[$positions_ID]=array();
		$requirements_rs->MoveNext();
	}
	$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$leagues_ID and weeks_ID=$week_ID and games_ID=$game_ID;";
	$actuals_rs=$DB->Execute($sql);
	while(!($actuals_rs->EOF))
	{
		$players_ID=$actuals_rs->fields("players_ID");
		$positions_ID=$actuals_rs->fields("positions_ID");
		$actuals_array[$positions_ID][]=$players_ID;
		$actuals_rs->MoveNext();
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td colspan='2'><span class='main_title'>".STARTING_LINEUP.": ".GAME." $game_ID</span></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_starting_lineup'>".SUBMIT_STARTING_LINEUP."</a></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_submission_history'>".LINEUP_SUBMISSION_HISTORY."</a></td>";
	echo "</tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	$requirements_rs->MoveFirst();
	$bg="";
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$position_name=get_lineup_position_name($positions_ID, "short");
		$count=0;
		foreach($actuals_array[$positions_ID] as $key => $val)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_bold_normal'>$position_name</span></td>";
			$sql="select firstname, lastname, teamID, positionID from players where ID='$val';";
			$players_rs=$DB->Execute($sql);
			if(!($players_rs->EOF))
			{
				$firstname=$players_rs->fields("firstname");
				$lastname=$players_rs->fields("lastname");
				echo "<td><span class='table_data_normal'>$firstname $lastname</span></td>";
				$count++;
			}
			else
			{
				echo "<td>".NONE."</td>";
			}
			echo "</tr>";
		}
		//Display Positions if there is no starting lineup
		while($count<$players_required)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_bold_normal'>$position_name</span></td>";
			echo "<td><span class='table_data_normal'>".NONE."</span></td>";
			echo "</tr>";
			$count++;
		}
		$requirements_rs->MoveNext();
	}
	echo "</table>";
}

function display_update_starting_lineup($Teams_ID, $leagues_ID, $week_ID, $game_ID="", $UpdateFutureWeeks="")
{
	global $PHP_SELF, $DB, $Mode;

	$game_ID=$week_ID;
	$team_opponent_array=get_team_opponent_array($week_ID);
	$weeks_in_season=get_number_weeks_season();
	$current_week=get_current_startinglineup_week();

	$sql="select * from starting_lineup_requirements where leagues_ID=$leagues_ID order by display_order ASC;";
	$requirements_rs=$DB->Execute($sql);
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$actuals_array[$positions_ID]=array();
		$requirements_rs->MoveNext();
	}
	$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$leagues_ID and weeks_ID=$week_ID and games_ID=$game_ID;";

	$actuals_rs=$DB->Execute($sql);
	while(!($actuals_rs->EOF))
	{
		$players_ID=$actuals_rs->fields("players_ID");
		$positions_ID=$actuals_rs->fields("positions_ID");
		$actuals_array[$positions_ID][]=$players_ID;
		$actuals_rs->MoveNext();
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";

	echo "<tr><td><span class='main_title'>".UPDATE_STARTING_LINEUP.": ".GAME." $game_ID</span></td>";
	echo "<tr>";
	echo "<td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=starting_lineup_main'>".BACK."</a></td>";
	echo "</tr>";
	echo "</table>";

	echo "<form id='changeLineupWeek' method='post' action='$PHP_SELF?'>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td>".SUBMIT_LINEUP_CHANGE_WEEK.": ";
	echo "<select name='Week_ID' id='changeWeekID'>";
	for($i=$current_week; $i<=$weeks_in_season; $i++)
	{
		$s="";
		if($i==$week_ID)
		{
			$s="selected";
		}
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td>";
	echo "<tr>";
	echo "</table>";
	echo "<input type='hidden' name='Leagues_ID' value='$leagues_ID'>";
	echo "<input type='hidden' name='Teams_ID' value='$Teams_ID'>";
	echo "<input type='hidden' name='Action' value='update_starting_lineup'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	   $("#changeWeekID").change(function () {
	      $("#changeLineupWeek").submit();
	    });

	 });

	</script>
	<?php

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	$requirements_rs->MoveFirst();
	$bg="";
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$sql="select players_positionID from positions where ID=$positions_ID;";
		$position_rs=$DB->Execute($sql);
		$players_positionID=$position_rs->fields("players_positionID");
		$players_positionID=explode(":",$players_positionID);
		$logic=" (0=1";
		foreach($players_positionID as $key => $val)
		{
			if(strlen($val)>0)
			{
				$logic=$logic." or positionID='$val'";
			}
		}
		$logic=$logic.") ";
		$sql="select * from rosters, players where players_ID=players.ID and current_teams_ID=$Teams_ID and $logic order by positionID ASC;";
		$roster_rs=$DB->Execute($sql);
		$position_name=get_lineup_position_name($positions_ID, "short");
		$count=0;
		$current_est_date=get_current_EST_date();
		foreach($actuals_array[$positions_ID] as $key => $val)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$position_name</td>";
			echo "<td>";

			$roster_rs->MoveFirst();
			if(!($roster_rs->EOF))
			{
				$players_game_date=get_players_game_time($val, $week_ID);

				//Don't allow user to change player once a game has started
				if($current_est_date>=$players_game_date && $players_game_date!=-1)
				{
					$sql="select firstname, lastname, teamID, positionID from players where ID='$val';";
					$player_rs=$DB->Execute($sql);
					$firstname=$player_rs->fields("firstname");
					$lastname=$player_rs->fields("lastname");
					echo "$lastname, $firstname";
					echo "<input type='hidden' name='Starting_Lineup[$positions_ID][$count]' value='$val'>";
				}
				else
				{
					echo "<select name='Starting_Lineup[$positions_ID][$count]'>";
					while(!($roster_rs->EOF))
					{
						$current_players_ID=$roster_rs->fields("players_ID");
						$players_game_date=get_players_game_time($current_players_ID, $week_ID);
						if($current_est_date<$players_game_date || $players_game_date==-1)
						{

							$s="";
							if($val==$current_players_ID)
								$s="selected";
							$sql="select firstname, lastname, teamID, positionID from players where ID='$val';";
							$firstname=$roster_rs->fields("firstname");
							$lastname=$roster_rs->fields("lastname");
							$current_teamID=$roster_rs->fields("teamID");
							$current_nfl_opponent=$team_opponent_array["detail"][$current_teamID];
							echo "<option value='$current_players_ID' $s>$lastname, $firstname ($current_teamID) - $current_nfl_opponent</option>";
						}
						$roster_rs->MoveNext();
					}
					echo "<option value='ZZZ'>".NONE."</option>";
					echo "</select>";
				}
			}
			else
			{
				echo NO_PLAYERS_EXIST;
			}
			$count++;
			echo "</td>";
			echo "</tr>";
		}
		//Display Positions if there is no starting lineup
		while($count<$players_required)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$position_name</td>";
			echo "<td>";
			$roster_rs->MoveFirst();
			if(!($roster_rs->EOF))
			{
				echo "<select name='Starting_Lineup[$positions_ID][$count]'>";
				while(!($roster_rs->EOF))
				{
					$current_players_ID=$roster_rs->fields("players_ID");
					$players_game_date=get_players_game_time($current_players_ID, $week_ID);
					if($current_est_date<$players_game_date || $players_game_date==-1)
					{
						$firstname=$roster_rs->fields("firstname");
						$lastname=$roster_rs->fields("lastname");
						$current_teamID=$roster_rs->fields("teamID");
						$current_nfl_opponent=$team_opponent_array["detail"][$current_teamID];
						echo "<option value='$current_players_ID'>$lastname, $firstname ($current_teamID) - $current_nfl_opponent</option>";
					}
					$roster_rs->MoveNext();
				}
				echo "<option value='ZZZ' selected>".NONE."</option>";
				echo "</select>";
			}
			else
			{
				echo NO_PLAYERS_EXIST;
			}
			echo "</td>";
			echo "</tr>";
			$count++;
		}
		$requirements_rs->MoveNext();
	}
	$c="";
	if($UpdateFutureWeeks)
	{
		$c="checked";
	}
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	echo "<tr><td colspan='2'><input type='checkbox' {$c} name='UpdateFutureWeeks' value='1'> ".SUBMIT_LINEUP_APPLY_FUTURE_WEEKS."</td></tr>";
	echo "<tr><td colspan='2' align='right'><input type='Submit' name='Submit' value='".SUBMIT_STARTING_LINEUP."'></td></tr>";
	echo "<input type='hidden' name='Week_ID' value='$week_ID'>";
	echo "<input type='hidden' name='Game_ID' value='$game_ID'>";
	echo "<input type='hidden' name='Leagues_ID' value='$leagues_ID'>";
	echo "<input type='hidden' name='Teams_ID' value='$Teams_ID'>";
	echo "<input type='hidden' name='Action' value='confirm_update_starting_lineup'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</table>";
	echo "</form>";

}

function display_view_submission_history($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID;

	$sql="select * from starting_lineup_submissions where teams_ID=$Teams_ID order by submission_date DESC;";
	$rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if(!($rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".DATE."</span></td>";
		echo "<td><span class='table_row_title'>".GAME."</span></td>";
		echo "<td><span class='table_row_title'>".USER."</span></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$lineup_ID=$rs->fields("ID");
			$users_ID=$rs->fields("users_ID");
			$sql="select first_name, last_name from users where ID=$users_ID;";
			$users_rs=$DB->Execute($sql);
			if(!($users_rs->EOF))
			{
				$firstname=$users_rs->fields("first_name");
				$lastname=$users_rs->fields("last_name");
				$fullname="$firstname $lastname";
			}
			else
			{
				$fullname=NA;
			}
			$games_ID=$rs->fields("games_ID");
			$submission_date=$rs->fields("submission_date");
			$starting_lineup=$rs->fields("starting_lineup");
			$submission_date=display_users_time($submission_date);
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>$submission_date</span></td>";
			echo "<td><span class='table_data_normal'>$games_ID</span></td>";
			echo "<td><span class='table_data_normal'>$fullname</span></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_lineup_submission&Lineup_ID=$lineup_ID&Teams_ID=$Teams_ID' class='table_data_normal'>".VIEW_LINEUP."</a></td>";
			echo "</tr>";
			$rs->MoveNext();
		}

	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NONE."</span></td></tr>";
	}
	echo "</table>";

}

function display_view_lineup_submission($Lineup_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID;

	$sql="select * from starting_lineup_submissions where ID=$Lineup_ID;";
	$rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if(!($rs->EOF))
	{

		$users_ID=$rs->fields("users_ID");
		$sql="select first_name, last_name from users where ID=$users_ID;";
		$users_rs=$DB->Execute($sql);
		if(!($users_rs->EOF))
		{
			$firstname=$users_rs->fields("first_name");
			$lastname=$users_rs->fields("last_name");
			$fullname="$firstname $lastname";
		}
		else
		{
			$fullname=NA;
		}
		$games_ID=$rs->fields("games_ID");
		$submission_date=$rs->fields("submission_date");
		$starting_lineup=$rs->fields("starting_lineup");
		$starting_lineup=nl2br($starting_lineup);
		$gmt_offset=get_users_offset($USERSID);
		$submission_date=display_users_time($submission_date);
		$bg="";
		$bg=get_row_bg($bg);
		echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".DATE."</span></td><td>$submission_date</td></tr>";
		$bg=get_row_bg($bg);
		echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".GAME."</span></td><td>$games_ID</td></tr>";
		$bg=get_row_bg($bg);
		echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".USER."</span></td><td>$fullname</td></tr>";
		$bg=get_row_bg($bg);
		echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".LINEUP."</span></td><td>$starting_lineup</td></tr>";
	}
	else
	{
		echo "<tr>td><span class='error'>".LINEUP_DOESNT_EXIST_TRY_AGAIN."</span></td></tr>";
	}
	echo "</table>";
}





?>