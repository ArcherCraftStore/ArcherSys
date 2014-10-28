<?php

function display_players_main($Search_Type="", $Search_Position="", $Current_Letter="", $OrderBy="", $SortBy="")
{

	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT, $PHPFFL_IMAGE_PATH;


	$current_week=get_current_week(-5);
	$team_opponent_array=get_team_opponent_array($current_week);
	if(strlen($Search_Type)<1)
		$Search_Type="Available";
	if(strlen($Search_Position)<1)
	{
		$sql="select distinct(positions.ID), positions.type from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";
		$positions_rs=$DB->Execute($sql);
		if(!($positions_rs->EOF))
		{
			$Search_Position=$positions_rs->fields("ID");
		}
		else
		{
			$Search_Position="All";
		}
	}
	if(strlen($Current_Letter)<1)
		$Current_Letter="ALL";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".STATUS.": </span></td>";
	echo "<td>";
	echo "<select name='Search_Type'>";
	echo "<option value='All'>".ALL."</option>";
	$s="";
	if($Search_Type=="Available")
		$s="selected";
	echo "<option value='Available' $s>".AVAILABLE."</option>";
	$s="";
	if($Search_Type=="Owned")
		$s="selected";
	echo "<option value='Owned' $s>".OWNED."</option>";
	echo "</select>";
	echo "</td>";
	echo "<td><span class='table_row_title'>".POSITION.": </span></td>";
	echo "<td>";
	echo "<select name='Search_Position'>";
	echo "<option value='All'>".ALL."</option>";
	$sql="select distinct(positions.ID), positions.type from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by type ASC";
	$positions_rs=$DB->Execute($sql);
	while(!($positions_rs->EOF))
	{
		$positions_type=$positions_rs->fields("type");
		$positions_ID=$positions_rs->fields("ID");
		$s="";
		if($Search_Position==$positions_ID)
			$s="selected";
		echo "<option value='$positions_ID' $s>$positions_type</option>";
		$positions_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value='".SEARCH."'></td>";
	echo "<td rowspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=search_players&Search_Type=$Search_Type&Search_Position=$Search_Position&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
	echo "</tr>";
	echo "<input type='hidden' name='Action' value='search_players'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</table>";


	if(strlen($Current_Letter)<1)
		$Current_Letter="A";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";

	if($SortBy=="ASC")
	{
		$NewSort="DESC";
		$image="arrow_down.gif";
	}
	else
	{
		$NewSort="ASC";
		$image="arrow_up.gif";
	}
	$alphabet="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";
	$alphabet=explode(" ", $alphabet);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='5'>";
	foreach($alphabet as $key => $val)
	{
		if($Current_Letter==$val)
		{
			echo "&nbsp;<strong>{$val}</strong>&nbsp;";
		}
		else
		{
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>".SHOW_ALL."</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".SHOW_ALL."</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".NAME."</a></span>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".NAME."</a></span></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POSITION."</a></span>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POSITION."</a></span></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".LEAGUE_TEAM."</a></span>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".LEAGUE_TEAM."</a></span></td>";
	}

	if($Search_Type=="Owned")
	{
		if($OrderBy=="current_teams_ID")
		{
			echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=current_teams_ID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".TEAM."</a></span>";
			echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
			echo "</td>";
		}
		else
		{
			echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=current_teams_ID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".TEAM."</a></span></td>";
		}
	}

	if($OrderBy=="points")
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=points&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POINTS."</a></span>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=points&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POINTS."</a></span></td>";
	}
	echo "<td><span class='table_row_title'>".NEXT_OPPONENT_SHORT."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
	if($Current_Letter!="ALL")
	{
		$extra_logic=$extra_logic."and lastname like '$Current_Letter%'";
		//$sql="select * from players where active='yes' and lastname like '$Current_Letter%' order by $OrderBy $SortBy";
	}
	if($Search_Position=="All")
	{
		$positions_rs->MoveFirst();
		$extra_logic=$extra_logic."and (0=1 ";
		while(!($positions_rs->EOF))
		{
			$positions_type=$positions_rs->fields("type");
			$positions_ID=$positions_rs->fields("ID");

			$sql="select players_positionID from positions where ID='$positions_ID';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$players_positionID=$rs->fields("players_positionID");
				$positions_array=explode(":",  $players_positionID);
				if(is_array($positions_array))
				{
					foreach($positions_array as $key => $val)
					{
						$extra_logic=$extra_logic."or positionID='$val'";
					}
				}
			}
			$positions_rs->MoveNext();
		}
		$extra_logic=$extra_logic.")";
	}
	else
	{
		$sql="select players_positionID from positions where ID='$Search_Position';";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$players_positionID=$rs->fields("players_positionID");
			$extra_logic=$extra_logic."and (0=1 ";
			$positions_array=explode(":",  $players_positionID);
			if(is_array($positions_array))
			{
				foreach($positions_array as $key => $val)
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}
			$extra_logic=$extra_logic.")";
		}
	}
	if($Search_Type=="All")
	{
		$sql="select * from players where active='yes' $extra_logic";

	}
	elseif($Search_Type=="Available")
	{
		$sql="select players.* from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NULL $extra_logic";
	}
	elseif($Search_Type=="Owned")
	{
		$sql="select players.*, current_teams_ID from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NOT NULL $extra_logic";
	}
	if($OrderBy=="points" || $OrderBy=="current_teams_ID")
	{
		$sql=$sql." order by lastname DESC";

	}
	else
	{
		$sql=$sql." order by $OrderBy $SortBy";
	}
	$rs=$DB->Execute($sql);

	if($OrderBy=="points")
	{
		while(!($rs->EOF))
		{
			$players_ID=$rs->fields("ID");
			$total_value=0;
			$sql="select sum(fantasy_value) as total_value from players_statistics_fantasy where players_ID='$players_ID' and leagues_ID=$LEAGUEID;";
			$fantasy_rs=$DB->Execute($sql);
			$total_value=$fantasy_rs->fields("total_value");
			$players_array[$players_ID]=$total_value;
			$rs->MoveNext();
		}
		if($SortBy=="ASC")
		{
			if(is_array($players_array))
			{
				arsort($players_array, SORT_NUMERIC);
			}
		}
		else
		{
			if(is_array($players_array))
			{
				asort($players_array, SORT_NUMERIC);
			}
		}
		if(is_array($players_array))
		{
			reset($players_array);
		}
	}
	elseif($OrderBy=="current_teams_ID")
	{
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("current_teams_ID");
			$players_ID=$rs->fields("ID");
			$sql="select team_name from teams where ID=$current_teams_ID";
			$teams_rs=$DB->Execute($sql);
			$teamname=$teams_rs->fields("team_name");
			$players_array[$players_ID]=$teamname;
			$rs->MoveNext();
		}
		if($SortBy=="ASC")
		{
			if(is_array($players_array))
			{
				arsort($players_array);
			}
		}
		else
		{
			if(is_array($players_array))
			{
				asort($players_array);
			}
		}
		if(is_array($players_array))
		{
			reset($players_array);
		}
	}
	else
	{
		while(!($rs->EOF))
		{
			$players_ID=$rs->fields("ID");
			$players_array[$players_ID]="";
			$rs->MoveNext();
		}
	}
	if(is_array($players_array))
	{
		foreach($players_array as $key => $val)
		{
			$sql="select * from players where ID='$key';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$bg=get_row_bg($bg);
				$players_ID=$rs->fields("ID");
				$lastname=$rs->fields("lastname");
				$firstname=$rs->fields("firstname");
				$team=$rs->fields("teamID");
				$sql="select sum(fantasy_value) as total_fantasy_points from players_statistics_fantasy where players_ID='$players_ID' and leagues_ID=$LEAGUEID group by players_ID;";
				$points_rs=$DB->Execute($sql);
				if(!($points_rs->EOF))
				{
					$total_fantasy_points=$points_rs->fields("total_fantasy_points");
				}
				else
				{
					$total_fantasy_points=0;
				}
				if(strlen($team)<1)
					$team="FA";
				$position=$rs->fields("positionID");
				echo "<tr bgcolor='$bg'>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Printable=1&height=600&width=950' class='thickbox'>$lastname, $firstname</a></td>";
				echo "<td>$position</td>";
				echo "<td>$team</td>";
				$current_nfl_opponent=$team_opponent_array["detail"][$team];
				if($Search_Type=="Owned")
				{
					$sql="select current_teams_ID from rosters where players_ID='$players_ID' and leagues_ID=$LEAGUEID;";
					$teams_rs=$DB->Execute($sql);
					$current_teams_ID=$teams_rs->fields("current_teams_ID");
					$sql="select team_name from teams where ID=$current_teams_ID;";
					$team_rs=$DB->Execute($sql);
					if(!($team_rs->EOF))
					{
						$Team_Name=$team_rs->fields("team_name");
					}
					echo "<td>$Team_Name</td>";
				}

				echo "<td>$total_fantasy_points</td>";
				echo "<td>$current_nfl_opponent</td>";
				echo "</tr>";
				$rs->MoveNext();
			}
		}
	}
	echo "</table>";
}


function display_player_detail($Players_ID, $Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;

	$current_week=get_current_week();
	$number_of_games=get_number_games_season();

	$sql="select firstname, lastname, positionID, teamID from players where ID='$Players_ID';";
	$rs=$DB->Execute($sql);

	$firstname=$rs->fields("firstname");
	$lastname=$rs->fields("lastname");
	$positionID=$rs->fields("positionID");
	$teamID=$rs->fields("teamID");

	$sql="select * from players_positions where positionID='$positionID';";
	$rs=$DB->Execute($sql);
	$position_description=$rs->fields("description");
	$statistic_categories_group=$rs->fields("statistic_categories_group");

	$total_value=0;
	$sql="select sum(fantasy_value) as total_value from players_statistics_fantasy where players_ID='$Players_ID' and leagues_ID=$Leagues_ID group by players_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$total_value=$rs->fields("total_value");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='main_title'>$firstname $lastname</span></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TOTAL_POINTS."</span></td><td><span class='table_row_title'>$total_value</span></td></tr>";
	echo "<tr><td><span class='table_row_title'>".POSITION."</span></td><td><span class='table_row_title'>$position_description</span></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM."</span></td><td><span class='table_row_title'>$teamID</span></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table border='0' cellpadding='4' cellspacing='3' width='100%'>";
	echo "<tr align='center'>";
	echo "<td><span class='table_data_bold_small'>".WEEK."</span></td>";
	$cols=1;
	$scoring_categories_array=get_scoring_categories($positionID, $Leagues_ID);
	$used_statistic_categories=array();
	foreach($scoring_categories_array as $key => $val)
	{
		$statistic_categories=explode(":", $val);
		foreach($statistic_categories as $key2 => $val2)
		{
			if(!(in_array($val2, $used_statistic_categories)))
			{
				$sql="select short_description from statistic_categories where ID=$val2;";
				$rs=$DB->Execute($sql);
				$statistic_description=$rs->fields("short_description");
				echo "<td><span class='table_data_bold_small'>$statistic_description</span></td>";
				$used_statistic_categories[]=$val2;
				$cols++;
			}
		}
		$sql="select short_title from scoring_categories where ID=$key;";
		$rs=$DB->Execute($sql);
		$scoring_short_title=$rs->fields("short_title");
		//echo "<td><span class='table_row_title'>$scoring_short_title</span></td>";
		//$cols++;
	}
	$cols++;
	echo "<td><span class='table_data_bold_small'>".POINTS."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='$cols'></td></tr>";
	for($i=1; $i<=$number_of_games;$i++)
	{
		$bg=get_row_bg($bg);
		$team_opponent_array=get_team_opponent_array($i);
		$current_nfl_opponent=$team_opponent_array["detail"][$teamID];
		echo "<tr bgcolor='$bg' align='center'>";
		echo "<td><span class='table_data_small'>$i - $current_nfl_opponent</span></td>";
		$used_statistic_categories=array();
		foreach($scoring_categories_array as $key => $val)
		{
			$statistic_categories=explode(":", $val);
			foreach($statistic_categories as $key2 => $val2)
			{
				if(!(in_array($val2, $used_statistic_categories)))
				{
					$total_value=0;
					$sql="select sum(statistical_value) as total_value from players_statistics_actuals where players_ID='$Players_ID' and game_ID=$i and statistic_categories_ID=$val2 group by players_ID;";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$total_value=$rs->fields("total_value");
					}
					echo "<td><span class='table_data_small'>$total_value</span></td>";
					$used_statistic_categories[]=$val2;
				}
			}
			//echo "<td><span class='table_row_title'>$scoring_short_title</span></td>";
			//$cols++;
		}
		$total_value=0;
		$sql="select sum(fantasy_value) as total_value from players_statistics_fantasy where players_ID='$Players_ID' and leagues_ID=$Leagues_ID and game_ID=$i group by players_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$total_value=$rs->fields("total_value");
		}
		echo "<td><span class='table_data_bold_small'>$total_value</span></td>";
		echo "</tr>";
	}
	echo "</table>";
}



?>