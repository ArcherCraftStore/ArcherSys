<?php

function display_live_scoring_main($week_ID="", $called_from_js=0)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_IMAGE_PATH;

	ob_start();

	$current_date=gmdate("Y-m-d H:i:s");
	$last_update_display_date=display_users_time($current_date, 0, "H:i");
	$current_week=$week_ID;
	$sql="select short_player_names from leagues where ID=$LEAGUEID;";
	$leagues_rs=$DB->Execute($sql);
	if(!($leagues_rs->EOF))
	{
		$short_player_names=$leagues_rs->fields("short_player_names");
	}

	echo "<table border='0' cellpadding='0' cellspacing='0'>";
	echo "<tr><td colspan='2'><span class='main_title'>".LIVE_SCORING.": ".WEEK." $current_week</span></td></tr>";
	echo "<tr><td colspan='2'><span class='table_data_bold_small'>".PAST_LAST_UPDATED.": {$last_update_display_date}</span></td></tr>";
	echo "</table>";
	$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC";
	$schedules_rs=$DB->Execute($sql);
	$schedulesID_teamname=get_schedulesID_teamname_array($LEAGUEID);
	$games_array=get_games_array_byweek($current_week,$LEAGUEID);
	$bg="";
	$count=0;
	echo "<table border='0' cellpadding='3' cellspacing='3' width='100%'>";
	echo "<tr>";
	foreach($games_array as $key => $val)
	{
		if($count%2==0 && $count!=0)
		{
			echo "</tr><tr><td colspan='7'>&nbsp;</td></tr><tr>";
		}
		$teams=explode(":", $val);
		$schedules_ID_1=$teams[0];
		$teams_ID_1=get_teamsID_from_schedulesID($schedules_ID_1,$LEAGUEID);
		$team1_total_points=get_total_points_game($teams_ID_1, $current_week, $current_week, $LEAGUEID);
		$schedules_ID_2=$teams[1];
		$teams_ID_2=get_teamsID_from_schedulesID($schedules_ID_2,$LEAGUEID);
		$team2_total_points=get_total_points_game($teams_ID_2, $current_week, $current_week, $LEAGUEID);
		$bg=get_row_bg($bg);
		echo "<td width='50%' valign='top'>";
		echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' >";
		echo "<tr><td width='48%' colspan='3'>";
		$schedules_rs->MoveFirst();
		$team1_schedules_ID=0;
		$team2_schedules_ID=0;
		while(!($schedules_rs->EOF))
		{
			$current_schedules_ID=$schedules_rs->fields("schedules_ID");
			$display=$current_schedules_ID;
			if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
				$display=$schedulesID_teamname[$current_schedules_ID];
			if($current_schedules_ID==$schedules_ID_1)
			{
				echo "<span class='live_scoring_data_title'><a href='$PHP_SELF?Mode=$Mode&Action=display_team_detail&Teams_ID=$teams_ID_1&Week_ID=$current_week'>$display</a> ($team1_total_points)</span>";
			}
			$schedules_rs->MoveNext();
		}
		if($schedules_ID_1==0)
		{
			echo "<span class='eleven_title'>".NONE."</span>";
		}
		echo "</td>";
		echo "<td width='4%'><span class='live_scoring_data_title'>".VERSUS_SHORT."</span></td>";
		echo "<td width='48%' colspan='2'>";
		$schedules_rs->MoveFirst();
		while(!($schedules_rs->EOF))
		{
			$current_schedules_ID=$schedules_rs->fields("schedules_ID");
			$display=$current_schedules_ID;
			if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
				$display=$schedulesID_teamname[$current_schedules_ID];
			if($current_schedules_ID==$schedules_ID_2)
			{
				$team2_schedules_ID=$current_schedules_ID;
				echo "<span class='live_scoring_data_title'><a href='$PHP_SELF?Mode=$Mode&Action=display_team_detail&Teams_ID=$teams_ID_2&Week_ID=$current_week'>$display</a> ($team2_total_points)</span>";
			}
			$schedules_rs->MoveNext();
		}
		if($schedules_ID_2==0)
		{
			echo "<span class='eleven_title'>".NONE."</span>";
		}
		echo "</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=display_game_detail&Team1_ID=$teams_ID_1&Team2_ID=$teams_ID_2&Week_ID=$current_week&Leagues_ID=$LEAGUEID' title='".VIEW_DETAILED_GAME_STATISTICS."'><img src='{$PHPFFL_IMAGE_PATH}arrow_right.gif' border='0'></a></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='7' width='100%'></td></tr>";
		echo "<tr>";
		echo "<td>";
		display_live_scoring_game($teams_ID_1, $teams_ID_2, $LEAGUEID, $current_week, $current_week, $short_player_names);
		echo "</td></tr>";
		echo "</table>";
		echo "</td>";
		$count++;
	}
	echo "</table>";
	echo "<br>";
	echo "<table border='0' cellpadding='1' cellspacing='1'>";
	echo "<tr><td><span class='live_scoring_data_green_title'>".BOLD_GREEN." = ".IN_PROGRESS."</span></td></tr>";
	echo "<tr><td><span class='live_scoring_data'>".NORMAL." = ".GAME_COMPLETED."</span></td></tr>";
	echo "<tr><td><span class='live_scoring_data'>- = ".NOT_STARTED." / ".BYE."</span></td></tr>";
	echo "</table>";
	$live_scoring_html = ob_get_contents();
	ob_end_clean();
	if($called_from_js)
	{
		$live_scoring_html=str_replace("+","%20",urlencode($live_scoring_html));
	}
	return $live_scoring_html;


}

function display_live_scoring_game($Team1_ID, $Team2_ID, $leagues_ID, $week_ID, $game_ID="", $short_player_names="")
{
	global $PHP_SELF, $DB, $Mode;

	$game_status_array=get_game_status_array($week_ID);
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
	$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Team1_ID and leagues_ID=$leagues_ID and weeks_ID=$week_ID and games_ID=$game_ID;";
	$actuals_team1_rs=$DB->Execute($sql);
	while(!($actuals_team1_rs->EOF))
	{
		$players_ID=$actuals_team1_rs->fields("players_ID");
		$positions_ID=$actuals_team1_rs->fields("positions_ID");
		$actuals_team1_array[$positions_ID][]=$players_ID;
		$actuals_team1_rs->MoveNext();
	}
	$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Team2_ID and leagues_ID=$leagues_ID and weeks_ID=$week_ID and games_ID=$game_ID;";
	$actuals_team2_rs=$DB->Execute($sql);
	while(!($actuals_team2_rs->EOF))
	{
		$players_ID=$actuals_team2_rs->fields("players_ID");
		$positions_ID=$actuals_team2_rs->fields("positions_ID");
		$actuals_team2_array[$positions_ID][]=$players_ID;
		$actuals_team2_rs->MoveNext();
	}
	$requirements_rs->MoveFirst();
	$bg="";
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$position_name=get_lineup_position_name($positions_ID, "short");
		for($i=0;$i<$players_required;$i++)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			if(strlen($actuals_team1_array[$positions_ID][$i])>0)
			{
				$current_players_ID=$actuals_team1_array[$positions_ID][$i];
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				$sql="select firstname, lastname, teamID, positionID from players where ID='$current_players_ID';";
				$players_rs=$DB->Execute($sql);
				if(!($players_rs->EOF))
				{
					$firstname=$players_rs->fields("firstname");
					$lastname=$players_rs->fields("lastname");
					$teamID=$players_rs->fields("teamID");
					$game_status=$game_status_array[$teamID];
					if(is_numeric($current_players_ID))
					{
						if($short_player_names=="Yes")
						{
							$firstname=substr($firstname, 0, 1);
							$firstname="{$firstname}.";
						}
						echo "<td><span class='live_scoring_data'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$current_players_ID&Week_ID=$week_ID&Printable=1&height=600&width=950' class='thickbox'>{$firstname} {$lastname}</a></span></td>";
					}
					else
					{
						echo "<td><span class='live_scoring_data'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$current_players_ID&Week_ID=$week_ID&Printable=1&height=600&width=950' class='thickbox'>$firstname</a></span></td>";
					}
				}
				else
				{
					$game_status="N/A";
					echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				}
				$total_points=get_fantasy_value($current_players_ID, $week_ID, $leagues_ID);
				if($game_status=="Scheduled" || $game_status=="Bye" || $game_status=="N/A")
				{

					echo "<td><span class='live_scoring_data'>-</span></td>";
				}
				elseif($game_status=="Final" || $game_status=="OT Final")
				{
					echo "<td><span class='live_scoring_data'>$total_points</span></td>";
				}
				else
				{
					echo "<td><span class='live_scoring_data_green_title'>$total_points</span></td>";
				}
			}
			else
			{
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				echo "<td><span class='live_scoring_data'>-</span></td>";
			}
			echo "<td></td>";
			//team2here
			if(strlen($actuals_team2_array[$positions_ID][$i])>0)
			{
				$current_players_ID=$actuals_team2_array[$positions_ID][$i];
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				$sql="select firstname, lastname, teamID, positionID from players where ID='$current_players_ID';";
				$players_rs=$DB->Execute($sql);
				if(!($players_rs->EOF))
				{
					$firstname=$players_rs->fields("firstname");
					$lastname=$players_rs->fields("lastname");
					$teamID=$players_rs->fields("teamID");
					$game_status=$game_status_array[$teamID];
					if(is_numeric($current_players_ID))
					{
						if($short_player_names=="Yes")
						{
							$firstname=substr($firstname, 0, 1);
							$firstname="{$firstname}.";
						}
						echo "<td><span class='live_scoring_data'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$current_players_ID&Week_ID=$week_ID&Printable=1&height=600&width=950' class='thickbox'>{$firstname} {$lastname}</a></span></td>";
					}
					else
					{
						echo "<td><span class='live_scoring_data'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$current_players_ID&Week_ID=$week_ID&Printable=1&height=600&width=950' class='thickbox'>$firstname</a></span></td>";
					}
				}
				else
				{
					$game_status="N/A";
					echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				}
				$total_points=get_fantasy_value($current_players_ID, $week_ID, $leagues_ID);
				if($game_status=="Scheduled" || $game_status=="Bye" || $game_status=="N/A")
				{
					echo "<td><span class='live_scoring_data'>-</span></td>";
				}
				elseif($game_status=="Final" || $game_status=="OT Final")
				{
					echo "<td><span class='live_scoring_data'>$total_points</span></td>";
				}
				else
				{
					echo "<td><span class='live_scoring_data_green_title'>$total_points</span></td>";
				}
			}
			else
			{
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				echo "<td><span class='live_scoring_data'>-</span></td>";
			}
			echo "</tr>";
		}
		$requirements_rs->MoveNext();
	}
}

function display_game_detail($Team1_ID, $Team2_ID, $leagues_ID, $week_ID, $game_ID="", $called_from_js=0)
{
	global $PHP_SELF, $DB, $Mode;
	ob_start();
	$current_date=gmdate("Y-m-d H:i:s");
	$last_update_display_date=display_users_time($current_date, 0, "H:i");
	echo "<table><tr><td><span class='table_data_bold_small'>".PAST_LAST_UPDATED.": {$last_update_display_date}</span></td></tr></table><br />";
	display_team_game_detail($Team1_ID, $leagues_ID, $week_ID);
	echo "<table>";
	echo "<tr><td><span class='table_row_title'>".VERSUS_SHORT."</span></td></tr>";
	echo "</table>";
	display_team_game_detail($Team2_ID, $leagues_ID, $week_ID);


	$live_scoring_game_html = ob_get_contents();
	ob_end_clean();
	if($called_from_js)
	{
		$live_scoring_game_html=str_replace("+","%20",urlencode($live_scoring_game_html));
	}
	return $live_scoring_game_html;

}

function display_team_game_detail($Team_ID, $leagues_ID, $week_ID, $game_ID="")
{
	global $PHP_SELF, $DB, $Mode;

	if( (strlen($game_ID)<1) || $game_ID==0)
	{
		$game_ID=$week_ID;
	}
	$sql="select * from starting_lineup_requirements where leagues_ID=$leagues_ID order by display_order ASC;";
	$requirements_rs=$DB->Execute($sql);
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$actuals_array[$positions_ID]=array();
		$requirements_rs->MoveNext();
	}
	$sql="select players_ID, positions_ID from starting_lineup_actuals where teams_ID=$Team_ID and leagues_ID=$leagues_ID and weeks_ID=$week_ID and games_ID=$game_ID;";
	$actuals_rs=$DB->Execute($sql);
	while(!($actuals_rs->EOF))
	{
		$players_ID=$actuals_rs->fields("players_ID");
		$positions_ID=$actuals_rs->fields("positions_ID");
		$actuals_array[$positions_ID][]=$players_ID;
		$actuals_rs->MoveNext();
	}
	$requirements_rs->MoveFirst();
	$bg="";
	$team_name=get_team_name($Team_ID);
	$total_points=get_total_points_game($Team_ID, $week_ID, $week_ID, $leagues_ID);
	echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' >";
	echo "<tr><td colspan='20'><span class='table_row_title'>$team_name ($total_points)</span></td></tr>";


	$count=0;
	while(!($requirements_rs->EOF))
	{
		$positions_ID=$requirements_rs->fields("positions_ID");
		$players_required=$requirements_rs->fields("players_required");
		$position_name=get_lineup_position_name($positions_ID, "short");
		$sql="select statistic_categories_group from positions where ID=$positions_ID;";
		$positions_rs=$DB->Execute($sql);
		$statistic_categories_group=$positions_rs->fields("statistic_categories_group");
		if($statistic_categories_group!=$previous_statistic_categories_group)
		{
			$current_statistic_categories_array=array();
			if($count>0)
			{
				echo "</table></td></tr>";
			}
			echo "<tr><td>";
			echo "<table border='0' cellpadding='1' cellspacing='1' width='100%' >";
			echo "<tr>";
			echo "<td><span class='live_scoring_data_title'>".POSITION."</span></td></td>";
			echo "<td><span class='live_scoring_data_title'>".PLAYER."</span></td></td>";
			$cols=4;
			$statistic_categories_group_array=explode(":", $statistic_categories_group);
			$logic="0=1 ";
			foreach($statistic_categories_group_array as $key => $val)
			{
				$logic=$logic." or groupby='$val' ";
			}
			$sql="select * from statistic_categories where $logic order by orderby ASC;";
			$category_rs=$DB->Execute($sql);
			while(!($category_rs->EOF))
			{
				$categories_ID=$category_rs->fields("ID");
				$categories_short_description=$category_rs->fields("short_description");
				$sql="select scoring_categories.ID from scoring_categories, scoring_categories_leagues_values where scoring_categories.ID=scoring_categories_ID and leagues_ID=$leagues_ID and (statistic_categories_ID='$categories_ID' or statistic_categories_ID like '$categories_ID:%' or statistic_categories_ID like '%:$categories_ID' or statistic_categories_ID like '%:$categories_ID:%');";

				$scoring_rs=$DB->Execute($sql);
				if(!($scoring_rs->EOF))
				{
					echo "<td><span class='live_scoring_data_title'>$categories_short_description</span></td></td>";
					$current_statistic_categories_array[]=$categories_ID;
				}
				$category_rs->MoveNext();
			}
			echo "<td><span class='live_scoring_data_title'>".POINTS_SHORT."</span></td></td>";
			echo "</tr>";
			echo "<tr class='tablerowline' height='8'><td colspan='20'></td></tr>";
			$count++;
		}
		for($i=0;$i<$players_required;$i++)
		{
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			if(strlen($actuals_array[$positions_ID][$i])>0)
			{
				$current_players_ID=$actuals_array[$positions_ID][$i];
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				$sql="select firstname, lastname, teamID, positionID from players where ID='$current_players_ID';";
				$players_rs=$DB->Execute($sql);
				if(!($players_rs->EOF))
				{
					$firstname=$players_rs->fields("firstname");
					$lastname=$players_rs->fields("lastname");
					echo "<td><span class='live_scoring_data'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$current_players_ID&Week_ID=$week_ID&Printable=1&height=600&width=950' class='thickbox'>$firstname $lastname</a></span></td>";
				}
				else
				{
					echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				}
				if(is_array($current_statistic_categories_array))
				{
					foreach($current_statistic_categories_array as $key => $val)
					{
						$total_value=get_statistical_value($week_ID, $current_players_ID, $val);
						echo "<td><span class='live_scoring_data'>$total_value</span></td>";
					}
				}
				$total_points=get_fantasy_value($current_players_ID, $week_ID, $leagues_ID);
				echo "<td><span class='live_scoring_data'>$total_points</span></td>";
			}
			else
			{
				echo "<td><span class='live_scoring_data'>$position_name</span></td>";
				echo "<td><span class='live_scoring_data'>".NONE."</span></td>";
				if(is_array($current_statistic_categories_array))
				{
					foreach($current_statistic_categories_array as $key => $val)
					{
						echo "<td><span class='live_scoring_data'>0</span></td>";
					}
				}
				echo "<td><span class='live_scoring_data'>0</span></td>";
			}
			echo "</tr>";
		}
		$previous_statistic_categories_group=$statistic_categories_group;
		$requirements_rs->MoveNext();
	}
	echo "</table></td></tr>";
}

?>