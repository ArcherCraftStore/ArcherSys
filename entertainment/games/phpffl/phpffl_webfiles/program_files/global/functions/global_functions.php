<?php
/*
function get_row_bg($bg) - Used to get row background color for alternating row colors in tables.

function createRandomPassword() - Creates a random password of 6 characters from the characters contained in the $chars variable.

function get_games_array_byweek($weekID,$leagueID) - Returns an array of all games for any week. Pass in the week as an integer and the leagueID. Will return an array. Key is the game number and values lists each schedulesID separated by a :

function get_teamsID_from_schedulesID($schedules_ID,$leagueID) - Returns the teamsID of the team associated with a schedules. Pass in the schedulesID and leagueID.

*/

function get_users_email($Users_ID)
{
	global $DB;
	if(strlen($Users_ID)<1)
	{
		return "";
	}
	$sql="select email_address from users where ID=$Users_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$email_address=$rs->fields("email_address");
	}
	return $email_address;
}

function get_users_on_team($teams_ID)
{
	global $DB;

	$users_on_team=array();
	if(strlen($teams_ID)>0)
	{
		$sql="select users_ID from users_teams where teams_ID=$teams_ID;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$current_users_ID=$rs->fields("users_ID");
			$users_on_team[]=$current_users_ID;
			$rs->MoveNext();
		}
	}
	return $users_on_team;
}
function get_row_bg($bg)
{
	if($bg=="#FFFFFF")
		return "#E7EBF7";
	else
		return "#FFFFFF";

}

function createRandomPassword()
{
	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 6)
	{
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

function get_league_name($LEAUGEID="")
{
	global $PHP_SELF, $DB;
	$league_name=NONE;
	if(strlen($LEAUGEID)>0)
	{
		$sql="select league_name from leagues where ID=$LEAUGEID";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$league_name=$rs->fields("league_name");
		}
	}
	return $league_name;
}

function get_game_result($team1_ID, $team2_ID, $week_ID, $game_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;

	$current_week=get_current_week(-5);
	if(strlen($team2_ID)<1 || $team2_ID==0 || ($current_week<=$week_ID && $current_week!=-1))
	{
		return NA;
	}

	$team1_points=get_total_points_game($team1_ID, $week_ID, $game_ID, $leagues_ID);
	$team2_points=get_total_points_game($team2_ID, $week_ID, $game_ID, $leagues_ID);
	if($team1_points==0 && $team2_points==0)
	{
		return NA;
	}
	elseif($team1_points==$team2_points)
	{
		return TIE." ($team1_points - $team2_points)";
	}
	elseif($team1_points>$team2_points)
	{
		return WIN." ($team1_points - $team2_points)";
	}
	else
	{
		return LOSS." ($team1_points - $team2_points)";
	}

}

function get_total_points_game($team_ID, $week_ID, $game_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;

	$total_points=0;
	if(strlen($team_ID)<1)
	{
		return 0;
	}
	$sql="select players_ID from starting_lineup_actuals where weeks_ID=$week_ID and games_ID=$game_ID and teams_ID=$team_ID and leagues_ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_players_ID=$rs->fields("players_ID");
		$sql="select players_ID, SUM(fantasy_value) as total_points from players_statistics_fantasy where week_ID=$week_ID and game_ID=$game_ID and leagues_ID=$leagues_ID and players_ID='$current_players_ID' group by players_ID;";
		$points_rs=$DB->Execute($sql);
		if(!($points_rs->EOF))
		{
			$total_points=$total_points+$points_rs->fields("total_points");
		}
		$rs->MoveNext();
	}
	return $total_points;

}
function get_games_array_byweek($weekID,$leagueID, $all=0)
{
	global $PHP_SELF, $DB;

	$sql="select schedules_ID, opponent_ID as team2, game_number_per_week from schedules where leagues_ID=$leagueID and week_ID=$weekID order by schedules_ID ASC, game_number_per_week ASC;";
	$rs = $DB->Execute($sql);
	$games_array=array();
	$team_game_array=array();
	$control=1;
	while(!($rs->EOF))
	{
		$team1_ID=$rs->fields("schedules_ID");
		$team2_ID=$rs->fields("team2");
		$game_number_per_week=$rs->fields("game_number_per_week");
		$game="$team1_ID:$team2_ID:$game_number_per_week";
		$game_alt="$team2_ID:$team1_ID:$game_number_per_week";
		if(! (in_array($game, $games_array) || in_array($game_alt, $games_array)) || $all)
		{
			$games_array[$control]=$game;
			$team_game_array[$team1_ID][$control]=$team2_ID;
			$team_game_array[$team2_ID][$control]=$team1_ID;
			$control++;
		}
		$rs->MoveNext();
	}
	/*
	foreach($team_game_array as $key => $val)
	{
		$number_of_games=count($val);
		if($number_of_games > $game_number_per_week)
		{
			if(is_array($val))
			{
				foreach($val as $key2 => $opponent_ID)
				{
					if($opponent_ID==0)
					{
						unset($games_array[$key2]);
					}
				}
			}
		}
	}
	*/
	return $games_array;
}

function get_team_opponent($teams_ID, $week_ID, $game_ID, $league_ID, $game_number_per_week=1)
{
	global $PHP_SELF, $DB;

	$sql="select schedules_ID from teams where ID=$teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$team_schedules_ID=$rs->fields("schedules_ID");
	}
	$team_opponent_name=NA;
	if(strlen($team_schedules_ID)>0 && $team_schedules_ID!=0)
	{
		$sql="select opponent_ID from schedules where schedules_ID=$team_schedules_ID and week_ID=$week_ID and leagues_ID=$league_ID and game_number_per_week=$game_number_per_week;";
		$schedules_rs=$DB->Execute($sql);
		if(!($schedules_rs->EOF))
		{
			$team_opponent_schedules_ID=$schedules_rs->fields("opponent_ID");
			$team_opponent_ID=get_teamsID_from_schedulesID($team_opponent_schedules_ID,$league_ID);
			$team_opponent["teamname"]=get_team_name($team_opponent_ID);
			$team_opponent["ID"]=$team_opponent_ID;
		}
	}
	return $team_opponent;

}
function get_teamsID_from_schedulesID($schedules_ID,$leagueID)
{
	global $PHP_SELF, $DB;

	if(strlen($schedules_ID)<1)
	{
		return 0;
	}
	$sql="select ID from teams where schedules_ID=$schedules_ID and leagues_ID=$leagueID";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
	{
		return $rs->fields("ID");
	}
	else
	{
		return 0;
	}
}

function get_schedulesID_teamname_array($leagueID)
{
	global $PHP_SELF, $DB;

	$teams_array=array();
	$sql="select teams.schedules_ID, team_name from teams, schedules where teams.schedules_ID=schedules.schedules_ID and teams.leagues_ID=$leagueID and schedules.leagues_ID=$leagueID;";
	$rs = $DB->Execute($sql);
	while(!($rs->EOF))
	{
		$schedules_ID=$rs->fields("schedules_ID");
		$team_name=$rs->fields("team_name");
		$teams_array[$schedules_ID]=$team_name;
		$rs->MoveNext();
	}
	return $teams_array;

}

function get_teams_byleague_array($leagueID)
{
	global $PHP_SELF, $DB;

	$teams_array=array();
	$sql="select ID, team_name from teams where leagues_ID=$leagueID;";
	$rs = $DB->Execute($sql);
	while(!($rs->EOF))
	{
		$teams_ID=$rs->fields("ID");
		$team_name=$rs->fields("team_name");
		$teams_array[$teams_ID]=$team_name;
		$rs->MoveNext();
	}
	return $teams_array;

}

function get_users_byleague_array($leagueID)
{
	global $PHP_SELF, $DB;

	$users_array=array();
	$ctr=0;
	$sql="select username from users where leagues_ID=$leagueID;";
	$rs = $DB->Execute($sql);
	while(!($rs->EOF))
	{
		$username=$rs->fields("username");
		$users_array[$ctr]=$username;
		$ctr++;
		$rs->MoveNext();
	}
	return $users_array;

}

function get_team_name($teams_ID)
{
	global $PHP_SELF, $DB;
	if(strlen($teams_ID)<1)
		return NA;
	$sql="select team_name from teams where ID=$teams_ID;";
	$rs=$DB->Execute($sql);
	$teamname=NA;
	if(!($rs->EOF))
	{
		$teamname=$rs->fields("team_name");
	}
	return $teamname;
}
function get_games_array_byweek_templates($weekID,$schedules_type_ID)
{
	global $PHP_SELF, $DB;

	$get_week="week_".$weekID;
	$sql="select schedules_ID, opponent_ID as team2, game_number_per_week from schedules_templates where schedules_type_ID=$schedules_type_ID and week_ID=$weekID order by schedules_ID ASC, game_number_per_week ASC;";
	$rs = $DB->Execute($sql);
	$games_array=array();
	$team_game_array=array();
	$control=1;
	while(!($rs->EOF))
	{
		$team1_ID=$rs->fields("schedules_ID");
		$team2_ID=$rs->fields("team2");
		$game_number_per_week=$rs->fields("game_number_per_week");
		$game="$team1_ID:$team2_ID:$game_number_per_week";
		$game_alt="$team2_ID:$team1_ID:$game_number_per_week";

		//if(!(in_array($game, $games_array) && !(in_array($game_alt, $games_array))))
		//{
			$games_array[$control]=$game;
			$team_game_array[$team1_ID][$control]=$team2_ID;
			$team_game_array[$team2_ID][$control]=$team1_ID;
			$control++;
		//}
		$rs->MoveNext();
	}
	/*
	foreach($team_game_array as $key => $val)
	{
		$number_of_games=count($val);
		if($number_of_games > $game_number_per_week)
		{
			if(is_array($val))
			{
				foreach($val as $key2 => $opponent_ID)
				{
					if($opponent_ID==0)
					{
						unset($games_array[$key2]);
					}
				}
			}
		}
	}
	*/
	return $games_array;
}

function check_is_admin($users_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;

	if(strlen($users_ID<1))
	{
		return 0;
	}
	if(strlen($users_ID)>0)
	{
		$sql="select is_superuser from users where ID=$users_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$is_superuser=$rs->fields("is_superuser");
			if($is_superuser==1)
				return 1;
		}
	}
	if(strlen($users_ID)>0 && strlen($leagues_ID)>0 )
	{
		$sql="select ID from admin_users_leagues where users_ID=$users_ID and leagues_ID=$leagues_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			return 1;
		}
	}

	return 0;
}

function check_is_superuser($USERSID)
{
	global $PHP_SELF, $DB;

	if(strlen($USERSID)<1)
		return 0;
	$sql="select is_superuser from users where ID=$USERSID";
	$rs=$DB->Execute($sql);
	$is_superuser=0;
	if(!($rs->EOF))
	{
		$is_superuser=$rs->fields("is_superuser");
	}
	return $is_superuser;
}

function is_user_in_league($users_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;
	if( strlen($leagues_ID)<1 || strlen($users_ID)<1 )
	{
		return 0;
	}
	else
	{
		$sql="select teams_ID from users_teams, teams where teams_ID=teams.ID and users_ID=$users_ID and leagues_ID=$leagues_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			return 1;
		}
	}
	return 0;
}

function get_number_weeks_season()
{
	//replace with dynamic code when nfl_schedules table is setup
	return 17;
}
function get_number_games_season()
{
	//replace with dynamic code when nfl_schedules table is setup
	return 17;
}

function get_statistical_value($Week_ID, $Players_ID, $statistic_categories_ID, $Game_ID="")
{
	global $PHP_SELF, $DB;

	if(strlen($Game_ID)<1)
		$Game_ID=$Week_ID;
	$sql="select statistical_value from players_statistics_actuals where statistic_categories_ID=$statistic_categories_ID and week_ID=$Week_ID and players_ID='$Players_ID' and game_ID=$Game_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$value=$rs->fields("statistical_value");
	}
	else
	{
		$value=0;
	}
	return $value;
}

function get_fantasy_value($Players_ID, $week_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;

	if(strlen($Players_ID)<1)
	{
		return 0;
	}
	$sql="select SUM(fantasy_value) as total_points from players_statistics_fantasy where players_ID='$Players_ID' and week_ID='$week_ID' and leagues_ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$total_points=$rs->fields("total_points");
		if(strlen($total_points)<1)
			$total_points=0;
		return $total_points;
	}
	else
	{
		return 0;
	}
}
//Pass type=short (Short Description) or type=long (Long Description)
function get_lineup_position_name($positions_ID, $type="short")
{
	global $PHP_SELF, $DB;

	$sql="select * from positions where ID=$positions_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$position_short=$rs->fields("type");
		$position_long=$rs->fields("short_description");
	}
	if($type=="short")
		return $position_short;
	else
		return $position_long;
}

function get_players_statistic_group($positionID)
{
	global $PHP_SELF, $DB;

	$sql="select statistic_categories_group from players_positions where positionID='$positionID';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$statistic_categories_group=$rs->fields("statistic_categories_group");
	}
	return $statistic_categories_group;
}

function display_users_time($datetime, $offset=0, $format="F, d Y H:i")
{
	global $PHP_SELF, $DB, $USERSID;

	if(strlen($USERSID)>0)
	{
		$sql="select gmt_offset from users where ID=$USERSID;";
		$users_rs=$DB->Execute($sql);
		if(!($users_rs->EOF))
		{
			$offset=$users_rs->fields("gmt_offset");
		}
	}
	if($datetime=="0000-00-00 00:00:00" or $datetime=="0000-00-00" or strlen($datetime)<1)
	{
		return NA;
	}
	$year=substr($datetime,0,4);
    $month=substr($datetime,5, 2);
    $day=substr($datetime,8,2);
	$hour=substr($datetime,11,2);
    $minute=substr($datetime,14, 2);
    $second=substr($datetime,17,2);
	$datetime_timestamp=mktime($hour+$offset,$minute, $second, $month, $day,$year);
	$display_datetime=date($format, $datetime_timestamp);
	return $display_datetime;
}

function get_users_offset($users_ID)
{
	global $PHP_SELF, $DB;

	if(strlen($users_ID)<1)
		return 0;
	$sql="select gmt_offset from users where ID=$users_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$offset=$rs->fields("gmt_offset");
	}
	if(strlen($offset)<1)
		$offset=0;

	return $offset;
}
function get_current_startinglineup_week()
{
	global $PHP_SELF, $DB, $LEAGUEID;

	$sql="select sunday_lock from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$sunday_lock=$rs->fields("sunday_lock");
	}
	//Convert to EST because datetime in schedule stored in EST
	$current_date=get_current_EST_date();
	$current_EST_timestamp=strtotime($current_date);

	$sql="select max(game_date) as max_date from league_schedules where seasonID NOT LIKE '%PRE%';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$max_date=$rs->fields("max_date");
		if($current_date>$max_date)
		{
			//season over
			return -1;
		}
	}
	$sql="select distinct(week), game_date from league_schedules where game_date>'$current_date'  and seasonID NOT LIKE '%PRE%' order by week ASC, game_date DESC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$current_week=$rs->fields("week");
		$game_date=$rs->fields("game_date");
		$year=substr($game_date,0,4);
		$month=substr($game_date,5, 2);
		$day=substr($game_date,8,2);
		$hour=substr($game_date,11,2);
		$minute=substr($game_date,14, 2);
		$second=substr($game_date,17,2);

		$game_timestamp=mktime($hour,$minute, $second, $month, $day,$year);
		$game_day_of_week=date("w", $game_timestamp);
		$game_hour=date("H", $game_timestamp);
		$game_date_basic=date("Y-m-d", $game_timestamp);
		$current_date_basic=date("Y-m-d", $current_EST_timestamp);
		$current_day_of_week=date("w", $current_EST_timestamp);
		$current_hour=date("H", $current_EST_timestamp);
		if($sunday_lock==1)
		{
			if( ($current_day_of_week==0 && $current_hour>=13) || ($current_day_of_week==1 && $current_hour<=21))
			{
				//Don't allow teams to submit a lineup when it's after 1pm on Sunday or Monday
				$current_week++;
			}
		}
	}
	else
	{
		$current_week=1;
	}
	return $current_week;

}
function get_current_week($extra_offset=0)
{
	global $PHP_SELF, $DB;

	//Convert to EST because datetime in schedule stored in EST
	$current_date=get_current_EST_date($extra_offset);
	$sql="select max(game_date) as max_date from league_schedules where seasonID NOT LIKE '%PRE%';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$max_date=$rs->fields("max_date");
		if($current_date>$max_date)
		{
			//season over
			return -1;
		}
	}
	$sql="select distinct(week) from league_schedules where game_date>'$current_date' and seasonID NOT LIKE '%PRE%' order by week ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$current_week=$rs->fields("week");
	}
	else
	{
		$current_week=1;
	}
	return $current_week;

}

function get_current_EST_date($extra_offset=0)
{
	global $PHP_SELF, $DB, $PHPFFL_DST_CHANGE;

	//Convert to EST because datetime in schedule stored in EST
	$gmdate_timestamp=strtotime(gmdate("Y-m-d H:i:s"));
	$dst_change_timestamp=strtotime($PHPFFL_DST_CHANGE);
	if($gmdate_timestamp<$dst_change_timestamp)
	{
		$is_dst=1;
	}
	else
	{
		$is_dst=0;
	}

	if($is_dst==1)
	{
		$current_EST_timestamp=mktime(gmdate("H")-4+$extra_offset,gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"),gmdate("y"), 1);
	}
	else
	{
		$current_EST_timestamp=mktime(gmdate("H")-5+$extra_offset,gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"),gmdate("y"), -1);
	}
	$current_EST_date=date("Y-m-d H:i:s", $current_EST_timestamp);

	return $current_EST_date;

}

function get_scoring_categories($positionID, $Leagues_ID)
{
	global $PHP_SELF, $DB;

	$scoring_categories_array=array();
	$sql="select ID, positionID_array, statistic_categories_ID from scoring_categories order by display_order ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$ID=$rs->fields("ID");
		$positionID_array=$rs->fields("positionID_array");
		$statistic_categories_ID=$rs->fields("statistic_categories_ID");
		$sql="select distinct(ID) from scoring_categories_leagues_values where scoring_categories_ID=$ID and leagues_ID=$Leagues_ID;";
		$categories_rs=$DB->Execute($sql);
		if(!($categories_rs->EOF))
		{
			$positionID_array=explode(":", $positionID_array);
			if(in_array($positionID, $positionID_array))
			{
				$scoring_categories_array[$ID]=$statistic_categories_ID;
			}
		}

		$rs->MoveNext();
	}
	return $scoring_categories_array;
}

function display_time($time, $timezone_offset=0, $date_format="American")
{
	$time_timestamp=strtotime($time);
	if($date_format=="American")
	{
		$display_time=date("F j, Y g:i a", $time_timestamp);
	}
	return $display_time;
}

function get_gmt_offset_array()
{
	$gmt_offset_array["-12"]="GMT - 12 Hours";
	$gmt_offset_array["-11"]="GMT - 11 Hours";
	$gmt_offset_array["-10"]="GMT - 10 Hours";
	$gmt_offset_array["-9"]="GMT - 9 Hours";
	$gmt_offset_array["-8"]="GMT - 8 Hours";
	$gmt_offset_array["-7"]="GMT - 7 Hours";
	$gmt_offset_array["-6"]="GMT - 6 Hours";
	$gmt_offset_array["-5"]="GMT - 5 Hours";
	$gmt_offset_array["-4"]="GMT - 4 Hours";
	$gmt_offset_array["-3.5"]="GMT - 3.5 Hours";
	$gmt_offset_array["-3"]="GMT - 3 Hours";
	$gmt_offset_array["-2"]="GMT - 2 Hours";
	$gmt_offset_array["-1"]="GMT - 1 Hour";
	$gmt_offset_array["0"]="GMT";
	$gmt_offset_array["1"]="GMT + 1 Hour";
	$gmt_offset_array["2"]="GMT + 2 Hours";
	$gmt_offset_array["3"]="GMT + 3 Hours";
	$gmt_offset_array["3.5"]="GMT + 3.5 Hours";
	$gmt_offset_array["4"]="GMT + 4 Hours";
	$gmt_offset_array["4.5"]="GMT + 4.5 Hours";
	$gmt_offset_array["5"]="GMT + 5 Hours";
	$gmt_offset_array["5.5"]="GMT + 5.5 Hours";
	$gmt_offset_array["6"]="GMT + 6 Hours";
	$gmt_offset_array["6.5"]="GMT + 6.5 Hours";
	$gmt_offset_array["7"]="GMT + 7 Hours";
	$gmt_offset_array["8"]="GMT + 8 Hours";
	$gmt_offset_array["9"]="GMT + 9 Hours";
	$gmt_offset_array["10"]="GMT + 10 Hours";
	$gmt_offset_array["11"]="GMT + 11 Hours";
	$gmt_offset_array["12"]="GMT + 12 Hours";
	$gmt_offset_array["13"]="GMT + 13 Hours";
	return $gmt_offset_array;
}

function get_players_game_time($players_ID, $week_ID)
{
	global $PHP_SELF, $DB;

	$sql="select teamID from players where ID='$players_ID';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$teamID=$rs->fields("teamID");
		$sql="select game_date from league_schedules where ID like '%$teamID%' and week=$week_ID  and seasonID NOT LIKE '%PRE%';";
		$schedule_rs=$DB->Execute($sql);
		if(!($schedule_rs->EOF))
		{
			$game_date=$schedule_rs->fields("game_date");
			return $game_date;
		}
		else
		{
			return -1;
		}

	}
	else
	{
		return -1;
	}
}

function get_player_data_array($players_ID)
{
	global $PHP_SELF, $DB;

	if(strlen($players_ID)<1)
		$players_ID=0;
	$sql="select * from players where ID='$players_ID';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$player_array["lastname"]=$rs->fields("lastname");
		$player_array["firstname"]=$rs->fields("firstname");
		$player_array["teamID"]=$rs->fields("teamID");
		$player_array["positionID"]=$rs->fields("positionID");
	}
	else
	{
		$player_array["lastname"]=NA;
		$player_array["firstname"]=NA;
		$player_array["teamID"]=NA;
		$player_array["positionID"]=NA;
	}
	return $player_array;
}


function is_player_locked($players_ID, $leagues_ID)
{
	global $PHP_SELF, $DB;

	$sql="select ID from waiver_wire where waive_players_ID='$players_ID' and leagues_ID=$leagues_ID and approval_status='Pending';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		return $players_ID;
	}
	$current_date=gmdate("Y-m-d H:i:s");
	$sql="select trades.ID from trades, trades_teams_players where players_ID='$players_ID' and trades.leagues_ID=$leagues_ID and trades_teams_players.leagues_ID=$leagues_ID and trade_expiration_date>='$current_date' and team2_approval_status='Pending' and trades.ID=trades_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		return true;
	}
	return false;
}


function date_input_display($m, $d, $y, $h, $i, $s, $default_date=0)
{

	if( (strlen($default_date)<5))
	{
		$passed_m=gmdate("m");
		$passed_d=gmdate("d");
		$passed_y=gmdate("y");
		$passed_h=gmdate("H");
		$passed_i=gmdate("i");
		$passed_s=gmdate("s");
	}
	else
	{
		$passed_timestamp=strtotime($default_date);
		$passed_y=date("Y", $passed_timestamp);
		$passed_m=date("m", $passed_timestamp);
		$passed_d=date("d", $passed_timestamp);
		$passed_h=date("H", $passed_timestamp);
		$passed_i=date("i", $passed_timestamp);
		$passed_s=date("s", $passed_timestamp);
	}

   $month=array(1 => JANUARY, FEBRUARY, MARCH, APRIL, MAY, JUNE, JULY, AUGUST, SEPTEMBER, OCTOBER, NOVEMBER, DECEMBER);
   echo "<select name=".$m.">";
   foreach ($month as $key => $value)
   {
      $number=sprintf("%02d", $key);
      $month_number=$number;
      if($passed_m==$month_number)
      {
          $s="selected";
      }
       echo "<option value='$number' $s>$value</option>";
       $s="";
       $num++;
   }
   echo "</select>";


	$day=1;
	echo "<select name=".$d.">";
   while($day<32)
   {
       $number=sprintf("%02d", $day);
	   $day_number=$number;
       if($passed_d==$day_number)
       {
           $s="selected";
       }
       echo "<option value='$day_number' $s>$day</option>";
             $s="";
       $day++;
   }
   echo "</select>";
   $year=gmdate("Y");;
   echo "<select name=".$y.">";
   $control=0;
   while($control<2)
   {
       if($passed_y==$year)
       {
           $s="selected";
       }
       echo "<option value='$year' $s>$year</option>";
       $s="";
       $year++;
       $control++;
   }
   echo "</select>";
   echo "&nbsp;&nbsp;&nbsp;";
    echo "<select name=".$h.">";
   $hour=1;
   while($hour<=24)
   {
   		$number=sprintf("%02d", $hour);
       if($passed_h==$number)
       {
           $s="selected";
       }
       echo "<option value='$number' $s>$number</option>";
       $s="";
       $hour++;
   }
   echo "</select>";
   echo ":";
    echo "<select name=".$i.">";
   $minute=0;
   while($minute<60)
   {
   		$number=sprintf("%02d", $minute);
       if($passed_i==$number)
       {
           $s="selected";
       }
       echo "<option value='$number' $s>$number</option>";
       $s="";
       $minute++;
   }
   echo "</select>";
}
/*
function get_self_team()
{
    global $PHP_SELF, $DB, $LEAGUEID, $USERSID;

    $teamname="";

	$sql="select teams_ID from users_teams, teams where users_ID=$USERSID and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
	    $Teams_ID=$rs->fields("teams_ID");
	    $teamname=get_team_name($Teams_ID);
    }

    return $teamname;
}
*/
function get_num_new_messages($users_ID)
{
    global $PHP_SELF, $DB, $LEAGUEID;
    $num_new_messages = 0;

    $sql="select count(*) as num_new_messages from private_message where user_to_ID=$users_ID and message_read=0 and user_to_deleted=0 ;";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
    	$num_new_messages=$rs->fields("num_new_messages");
    }

	return $num_new_messages;
}

function get_num_messages($users_ID)
{
    global $PHP_SELF, $DB;
    $num_messages = 0;

    $sql="select count(*) as num_messages from private_message where user_to_ID=$users_ID;";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
    	$num_messages=$rs->fields("num_messages");
    }

	return $num_messages;
}

function get_users_username($users_ID)
{
	global $PHP_SELF, $DB, $LEAGUEID;
	$username="";

	$sql="select username from users where ID=$users_ID;";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
    	$username=$rs->fields("username");
    }

	return $username;
}

function get_users_ID($username)
{
	global $PHP_SELF, $DB, $LEAGUEID;

	$id="";
	$sql="select ID, username from users where username='$username';";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
    	$id=$rs->fields("ID");
    }

	return $id;
}

function get_users_display($users_ID)
{
	global $PHP_SELF, $DB, $LEAGUEID, $PHPFFL_WEB_ROOT;
	$display="";
	if(strlen($users_ID)<1)
	{
		return $display;
	}
	$sql="select first_name, last_name, gmt_offset from users where ID=$users_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$first_name=$rs->fields("first_name");
		$last_name=$rs->fields("last_name");
		$gmt_offset=$rs->fields("gmt_offset");
		$datetime=gmdate("Y-m-d H:i:s");
		$users_time=display_users_time($datetime, $gmt_offset);
		$display="<span class='table_toprow_title_sml'>".LOGGED_IN.": $first_name $last_name&nbsp;<br>$users_time</span>&nbsp;";
	}
	if(strlen($LEAGUEID)>0)
	{
		$sql="select teams.ID from users_teams, teams where users_teams.users_ID=$users_ID and teams.leagues_ID=$LEAGUEID and teams_ID=teams.ID;";
		$teams_rs=$DB->Execute($sql);
		if(!($teams_rs->EOF))
		{
			$teams_ID=$teams_rs->fields("ID");
			$sql="select ID from trades where team2_ID=$teams_ID and team2_approval_status='Pending';";
			$trades_rs=$DB->Execute($sql);
			if(!($trades_rs->EOF))
			{
				$display="<a href='{$PHPFFL_WEB_ROOT}my_team.php?Mode=trades&Action=trades_main'><span class='header_text_trade_pending'>".TRADE_PENDING."</span></a>&nbsp;<br>".$display;
			}
		}
	}
	$num_new_messages = get_num_new_messages($users_ID);
	if($num_new_messages>0)
	{
		$display="<a href='{$PHPFFL_WEB_ROOT}my_team.php?Mode=private_message&Action=private_message_main'><span class='header_text_trade_pending'>".NEW_PRIVATE_MESSAGE."</span></a>&nbsp;<br>".$display;
	}
	return $display;
}

function get_game_status_array($week)
{
	global $DB;

	$game_status_array=array();
	$sql="select distinct(teamID) as teamID from players;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_teamID=$rs->fields("teamID");
		if(strlen($current_teamID)>0)
		{
			$sql="select status from league_schedules where ID like '%$current_teamID%' and week=$week and seasonID NOT LIKE '%PRE%';";
			$status_rs=$DB->Execute($sql);
			if(!($status_rs->EOF))
			{
				$current_status=$status_rs->fields("status");
				$game_status_array[$current_teamID]=$current_status;
			}
			else
			{
				$game_status_array[$current_teamID]=BYE;
			}
		}
		$rs->MoveNext();
	}
	return $game_status_array;
}


function get_team_opponent_array($week)
{
	global $DB;

	$team_opponent_array=array();
	$sql="select distinct(teamID) as teamID from players;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_teamID=$rs->fields("teamID");
		if(strlen($current_teamID)>0)
		{
			$sql="select ID, game_date from league_schedules where ID like '%$current_teamID%' and week=$week and seasonID NOT LIKE '%PRE%';";
			$schedules_rs=$DB->Execute($sql);
			if(!($schedules_rs->EOF))
			{
				$current_ID=$schedules_rs->fields("ID");
				$teams=substr($current_ID, 9);
				$teams=explode("@", $teams);
				$home_team=$teams[0];
				$away_team=$teams[1];
				$game_date=$schedules_rs->fields("game_date");
				if(strtolower($current_teamID)==strtolower($home_team))
				{
					$team_opponent_array["basic"][$current_teamID]=$away_team;
					$team_opponent_array["detail"][$current_teamID]="@{$away_team}";
					$team_opponent_array["game_date"][$current_teamID]=$game_date;
				}
				else
				{
					$team_opponent_array["basic"][$current_teamID]=$home_team;
					$team_opponent_array["detail"][$current_teamID]=$home_team;
					$team_opponent_array["game_date"][$current_teamID]=$game_date;
				}

			}
			else
			{
				$team_opponent_array["basic"][$current_teamID]=BYE;
				$team_opponent_array["detail"][$current_teamID]=BYE;
				$team_opponent_array["game_date"][$current_teamID]="";
			}
		}
		$rs->MoveNext();
	}
	return $team_opponent_array;
}
/*
Used to determine which draft picks are tradeable by finding out of the current date is before or after the draft date for a league
*/
function get_draft_year($leagues_ID)
{
	global $PHP_SELF, $DB;

	$current_date=gmdate("Y-m-d H:i:s");
	$current_year=gmdate("Y");
	$sql="select draft_date from leagues where ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$draft_date=$rs->fields("draft_date");
		$draft_year=substr($draft_date, 0, 4);
		if($current_date>$draft_date)
		{
			$draft_year++;
			return $draft_year;
		}
		else
		{
			return $draft_year;
		}
	}
	else
	{
		return $current_year;
	}

}

function get_language_name($languages_ID)
{
	global $DB;

	$sql="select language_name from languages where ID='$languages_ID';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$language_name=$rs->fields("language_name");
		return $language_name;
	}
	else
	{
		return NA;
	}
}

function get_league_logo_array()
{
	global $PHP_SELF, $DB, $LEAGUEID;

	if(strlen($LEAGUEID)<1)
	{
		$LEAGUEID=0;
	}
	$logo_array['display_team_logos']=false;
	$logo_array['max_logo_width']=0;
	$logo_array['max_logo_height']=0;
	$sql="select display_team_logos, max_logo_width, max_logo_height from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$display_team_logos=$rs->fields("display_team_logos");
		$max_logo_width=$rs->fields("max_logo_width");
		$max_logo_height=$rs->fields("max_logo_height");

		$logo_array['display_team_logos']=$display_team_logos;
		$logo_array['max_logo_width']=$max_logo_width;
		$logo_array['max_logo_height']=$max_logo_height;
	}
	return $logo_array;
}

function get_team_logo($Teams_ID)
{
	global $DB;

	if(strlen($Teams_ID)<1)
		return "";
	$sql="select team_logo_filename from teams where ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$team_logo_filename=$rs->fields("team_logo_filename");
	}
	return $team_logo_filename;


}


function get_division_logo($Division_ID)
{
	global $DB;

	if(strlen($Division_ID)<1)
		return "";
	$sql="select division_logo_filename from divisions where ID=$Division_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$division_logo_filename=$rs->fields("division_logo_filename");
	}
	return $division_logo_filename;


}

function get_players_need_clear_waivers()
{
	global $PHP_SELF, $DB, $LEAGUEID;

	$players_need_clear_waivers=array();
	$sql="select days_clear_waivers from leagues where ID=$LEAGUEID;";
	$leagues_rs=$DB->Execute($sql);
	if(!($leagues_rs->EOF))
	{
		$days_clear_waivers=$leagues_rs->fields("days_clear_waivers");
	}
	if(strlen($days_clear_waivers)<1 || $days_clear_waivers==0)
	{
		return $players_need_clear_waivers;
	}
	else
	{
		$current_clear_waivers_timestamp=mktime(gmdate("H"),gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d")-$days_clear_waivers,gmdate("y"), gmdate("I"));
		$current_clear_waivers_date=date("Y-m-d H:i:s", $current_clear_waivers_timestamp);
	}

	$sql="select waive_players_ID from waiver_wire where leagues_ID=$LEAGUEID and approval_status='Approved' and date_approved > '$current_clear_waivers_date';";
	$players_rs=$DB->Execute($sql);
	while(!($players_rs->EOF))
	{
		$current_players_ID=$players_rs->fields("waive_players_ID");
		$players_need_clear_waivers[]=$current_players_ID;
		$players_rs->MoveNext();
	}
	return $players_need_clear_waivers;
}

function get_draft_length_round_array($leagues_ID)
{
	global $DB;
	$draft_length_round_array=array();
	$sql="select draft_length_rounds from leagues where ID=$leagues_ID;";
	$leagues_rs=$DB->Execute($sql);
	if($leagues_rs->EOF)
	{
		return $draft_length_round_array;
	}
	$draft_length_rounds=$leagues_rs->fields("draft_length_rounds");
	if(strlen($draft_length_rounds)<1 || $draft_length_rounds==0)
	{
		return $draft_length_round_array;
	}

	$default_length_minutes=0;
	$default_length_seconds=0;
	$sql="select length_minutes, length_seconds from draft_timer_length where is_default=1 and leagues_ID=$leagues_ID;";
	$draft_rs=$DB->Execute($sql);
	if(!($draft_rs->EOF))
	{
		$default_length_minutes=$draft_rs->fields("length_minutes");
		$default_length_seconds=$draft_rs->fields("length_seconds");
	}

	$sql="select round, length_minutes, length_seconds from draft_timer_length where leagues_ID=$leagues_ID and is_default<>1;";
	$draft_rs=$DB->Execute($sql);
	$round_length_array=array();
	while(!($draft_rs->EOF))
	{
		$current_round=$draft_rs->fields("round");
		$current_length_minutes=$draft_rs->fields("length_minutes");
		$current_length_seconds=$draft_rs->fields("length_seconds");
		$round_length_array[$current_round]['length_minutes']=$current_length_minutes;
		$round_length_array[$current_round]['length_seconds']=$current_length_seconds;
		$draft_rs->MoveNext();
	}
	for($i=1;$i<=$draft_length_rounds;$i++)
	{
		if(array_key_exists($i, $round_length_array))
		{
			$draft_length_round_array[$i]['length_minutes']=$round_length_array[$i]['length_minutes'];
			$draft_length_round_array[$i]['length_seconds']=$round_length_array[$i]['length_seconds'];
		}
		else
		{
			$draft_length_round_array[$i]['length_minutes']=$default_length_minutes;
			$draft_length_round_array[$i]['length_seconds']=$default_length_seconds;
		}
	}
	return $draft_length_round_array;
}

function get_roster_requirements_array($leagues_ID)
{
	global $DB;

	$roster_requirements_table_array=array();
	$sql="select positions_ID, max_players,min_players from rosters_requirements where leagues_ID=$leagues_ID;";
	$roster_rs=$DB->Execute($sql);
	while(!($roster_rs->EOF))
	{
		$current_positions_ID=$roster_rs->fields("positions_ID");
		$current_max_players=$roster_rs->fields("max_players");
		$current_min_players=$roster_rs->fields("min_players");
		$roster_requirements_table_array[$current_positions_ID]['max_players']=$current_max_players;
		$roster_requirements_table_array[$current_positions_ID]['min_players']=$current_min_players;
		$roster_rs->MoveNext();
	}
	$sql="select ID from positions where include_in_roster_requirements=1;";
	$positions_rs=$DB->Execute($sql);
	$roster_requirements=array();
	while(!($positions_rs->EOF))
	{
		$current_positions_ID=$positions_rs->fields("ID");
		if(array_key_exists($current_positions_ID, $roster_requirements_table_array))
		{
			$roster_requirements[$current_positions_ID]['max_players']=$roster_requirements_table_array[$current_positions_ID]['max_players'];
			$roster_requirements[$current_positions_ID]['min_players']=$roster_requirements_table_array[$current_positions_ID]['min_players'];
		}
		else
		{
			$roster_requirements[$current_positions_ID]['max_players']=0;
			$roster_requirements[$current_positions_ID]['min_players']=0;
		}
		$positions_rs->MoveNext();
	}
	return $roster_requirements;

}

function get_roster_maximum($leagues_ID){
	global $DB;

	$current_max=0;
	$sql="select max_players from rosters_requirements where positions_ID=0 and leagues_ID=$leagues_ID;";
	$roster_rs=$DB->Execute($sql);
	if(!($roster_rs->EOF))
	{
		$current_max=$roster_rs->fields("max_players");
	}
	return $current_max;

}
function get_players_position_totals_team($teams_ID)
{
	global $DB;

	$players_position_totals_team=array();
	$teams_players_position_array=array();
	$sql="select players.ID, players.positionID from rosters, players where rosters.players_ID=players.ID and current_teams_ID=$teams_ID";
	$teams_rs=$DB->Execute($sql);
	while(!($teams_rs->EOF))
	{
		$current_players_ID=$teams_rs->fields("ID");
		$current_positionID=$teams_rs->fields("positionID");
		$teams_players_position_array[$current_players_ID]=$current_positionID;
		$teams_rs->MoveNext();
	}
	$sql="select ID, players_positionID from positions where include_in_roster_requirements=1;";
	$positions_rs=$DB->Execute($sql);
	$roster_requirements=array();
	while(!($positions_rs->EOF))
	{
		$current_positions_ID=$positions_rs->fields("ID");
		$current_players_positionID=$positions_rs->fields("players_positionID");
		$players_position_totals_team[$current_positions_ID]=0;
		$all_position_array=explode(":", $current_players_positionID);
		foreach($all_position_array as $key => $val)
		{
			foreach($teams_players_position_array as $players_ID => $positionID)
			{
				if($val==$positionID)
				{
					$players_position_totals_team[$current_positions_ID]++;
				}
			}
		}
		$positions_rs->MoveNext();
	}
	return $players_position_totals_team;
}

function get_players_positions_ID($players_ID)
{
	global $DB;

	$positions_ID=0;
	$players_data_array=get_player_data_array($players_ID);
	$players_position_ID=$players_data_array['positionID'];
	$sql="select ID from positions where players_positionID='{$players_position_ID}' or players_positionID LIKE '%:{$players_position_ID}:%' or players_positionID LIKE '{$players_position_ID}:%' or players_positionID LIKE '%:{$players_position_ID}'";

	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$positions_ID=$rs->fields("ID");
	}

	return $positions_ID;
}

function set_team_autorank_players($teams_ID, $leagues_ID)
{
	global $DB;

	$sql="delete from draft_rank_teams where teams_ID=$teams_ID and leagues_ID=$leagues_ID;";
	$DB->Execute($sql);


	$sql="select ID from players where active='yes' order by rank ASC, lastname ASC, firstname ASC;";
	$players_rs=$DB->Execute($sql);

	$current_rank=1;
	while(!($players_rs->EOF))
	{
		$players_ID=$players_rs->fields("ID");
		$sql="insert into draft_rank_teams (players_ID, rank, teams_ID, leagues_ID) values ('$players_ID', '$current_rank', '$teams_ID', '$leagues_ID');";
		$DB->Execute($sql);
		$current_rank++;
		$players_rs->MoveNext();
	}


}

function get_users_data_array($Users_ID)
{
	global $DB;
	$users_data_array=array();
	if(strlen($Users_ID)<1)
	{
		return $users_data_array;
	}
	$sql="select first_name, last_name, email_address, telephone_number, username from users where ID=$Users_ID;";
	$users_rs=$DB->Execute($sql);
	$users_data_array['first_name']=$users_rs->fields("first_name");
	$users_data_array['last_name']=$users_rs->fields("last_name");
	$users_data_array['email_address']=$users_rs->fields("email_address");
	$users_data_array['telephone_number']=$users_rs->fields("telephone_number");
	$users_data_array['username']=$users_rs->fields("username");

	return $users_data_array;
}

function get_number_games_per_week_schedule_type($Schedules_Type_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	if(strlen($Schedules_Type_ID)<1)
	{
		return 1;
	}
	$sql="select games_per_week from schedules_type where ID=$Schedules_Type_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$games_per_week=$rs->fields("games_per_week");
	}
	if(strlen($games_per_week)<1)
	{
		$games_per_week=1;
	}
	return $games_per_week;
}
?>