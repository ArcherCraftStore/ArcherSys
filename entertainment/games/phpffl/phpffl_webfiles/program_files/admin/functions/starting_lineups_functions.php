<?php 
/*

function admin_lineups_main() - Displays the main view when starting Lineups is first clicked on

function display_add_new_position($Positions_ID="", $Players_Required="") - Displays the add screen for adding a new position to the starting lineup

*/

function admin_lineups_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	$sql="select starting_lineup_requirements.*, positions.type, positions.short_description from starting_lineup_requirements, positions where positions_ID=positions.ID and leagues_ID=$LEAGUEID order by display_order ASC";
	$rs=$DB->Execute($sql);
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><a href=\"$PHP_SELF?Mode=$Mode&Action=submit_starting_lineups\">".SUBMIT_STARTING_LINEUPS."</a></td>";
	echo "<td><a href=\"$PHP_SELF?Mode=$Mode&Action=lineup_submission_history\">".LINEUP_SUBMISSION_HISTORY."</a></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><a href=\"$PHP_SELF?Mode=$Mode&Action=add_new_position\">".ADD_NEW_POSITION."</a></td>";
	echo "</tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td><span class='table_row_title'>".NUMBER_REQUIRED."</span></td>";
	echo "<td></td>";
	echo "<td><span class='table_row_title'>".DISPLAY_ORDER."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$lineups_ID=$rs->fields("ID");
		$positions_ID=$rs->fields("positions_ID");
		$players_required=$rs->fields("players_required");
		$display_order=$rs->fields("display_order");
		$positions_type=$rs->fields("type");
		$positions_short_description=$rs->fields("short_description");
		echo "<tr bgcolor='$bg'>";
		echo "<td>$positions_type</td>";
		echo "<td>";
		echo "<select name='Players_Required[$lineups_ID]'>";
		for($i=1; $i<10; $i++)
		{
			$s="";
			if($i==$players_required)
				$s="selected";
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_position&Lineups_ID=$lineups_ID'>".DELETE."</td>";
		echo "<td><input type='text' name='Display_Order[$lineups_ID]' value='$display_order' size='2'></td>";
		echo "</tr>";
		$rs->MoveNext();
	}
	echo "<tr><td colspan='4'>&nbsp;</td></tr>";
	echo "<tr><td colspan='4'><input type='Submit' name='Submit' value='".UPDATE_LINEUP_INFO."'></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='update_lineups_main'>";
	echo "</form></table>";
}

function display_add_new_position($Positions_ID="", $Players_Required="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	if(strlen($Players_Required)<1)
		$Players_Required=1;
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_POSITION."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".POSITION."</span></td><td>";
	$sql="select ID, short_description from positions order by short_description;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Positions_ID'>";
		while(!($rs->EOF))
		{
			$positions_ID=$rs->fields("ID");
			$positions_description=$rs->fields("short_description");
			$selected="";
			if($positions_ID==$Positions_ID)
				$selected="selected";
			echo "<option value='$positions_ID' $selected>$positions_description</option>";
			$rs->MoveNext();
		}
		echo "</select>";
	}
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".PLAYERS_REQUIRED."</span></td><td>";
	echo "<select name='Players_Required'>";
	for($i=1; $i<10; $i++)
	{
		$s="";
		if($i==$Players_Required)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_position'>";
	echo "</form></table>";
}

function display_lineup_submission_history($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".SELECT_TEAM.": </span></td>";
		echo "<td>";
		echo "<select name='Teams_ID'>";
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$current_teams_name=$rs->fields("team_name");
			$s="";
			if($current_teams_ID==$Teams_ID)
				$s="selected";
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Action' value='lineup_submission_history'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='table_row_title'>".NO_TEAMS_EXIST_FOR_LEAGUE."</span></td></tr>";
		echo "</table>";
	}
	
	if(strlen($Teams_ID)>0)
	{
		display_view_submission_history($Teams_ID);
	}

}

function display_submit_starting_lineups($Teams_ID, $Game_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".SELECT_TEAM.": </span></td>";
		echo "<td>";
		echo "<select name='Teams_ID'>";
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$current_teams_name=$rs->fields("team_name");
			$s="";
			if($current_teams_ID==$Teams_ID)
				$s="selected";
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		echo "<td><span class='table_row_title'>".GAME.": </span></td>";
		echo "<td>";
		$weeks_in_season=get_number_weeks_season();
		echo "<select name='Game_ID'>";
		for($i=1;$i<=$weeks_in_season;$i++)
		{
			$s="";
			if($i==$Game_ID)
				$s="selected";
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Action' value='submit_starting_lineups'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='table_row_title'>".NO_TEAMS_EXIST_FOR_LEAGUE."</span></td></tr>";
		echo "</table>";
	}
	if( strlen($Teams_ID)>0 && strlen($Game_ID)>0 )
	{
		display_update_starting_lineup_admin($Teams_ID, $LEAGUEID, $Game_ID);
	}


}

function display_update_starting_lineup_admin($Teams_ID, $leagues_ID, $week_ID, $game_ID="")
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
	echo "<form method='post' action='$PHP_SELF?'>";
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
				$current_est_date=get_current_EST_date();
				//Don't allow user to change player once a game has started
				echo "<select name='Starting_Lineup[$positions_ID][$count]'>";
				while(!($roster_rs->EOF))
				{
					$current_players_ID=$roster_rs->fields("players_ID");
					$s="";
					if($val==$current_players_ID)
						$s="selected";
					$sql="select firstname, lastname, teamID, positionID from players where ID='$val';";
					$firstname=$roster_rs->fields("firstname");
					$lastname=$roster_rs->fields("lastname");
					echo "<option value='$current_players_ID' $s>$lastname, $firstname</option>";
					$roster_rs->MoveNext();
				}
				echo "<option value='ZZZ'>".NONE."</option>";
				echo "</select>";
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
					$firstname=$roster_rs->fields("firstname");
					$lastname=$roster_rs->fields("lastname");
					echo "<option value='$current_players_ID'>$lastname, $firstname</option>";
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

?>
