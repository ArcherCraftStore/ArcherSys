<?php 

function admin_scoring_main($Position_Description="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	$current_week=get_current_week();
	
	$sql="select distinct(position_description) from scoring_categories order by position_description ASC;";
	$description_rs=$DB->Execute($sql);
	
	if(strlen($Position_Description)<1)
	{
		$Position_Description=$description_rs->fields("position_description");
	}
	$sql="select distinct(scoring_categories_ID) as category_ID from scoring_categories_leagues_values where leagues_ID=$LEAGUEID";
	$rs=$DB->Execute($sql);
	$current_scoring_categories[]="";
	while(!($rs->EOF))
	{
		$categories_ID=$rs->fields("category_ID");
		$current_scoring_categories[]=$categories_ID;
		$rs->MoveNext();
	}
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action=calculate_fantasy_stats&Week_ID=$current_week'>".CALCULATE_FANTASY_STATS."</a></td></tr>";
	echo "<tr><td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action=copy_scoring'>".COPY_SCORING_FROM_ANOTHER_LEAGUE."</a></td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	
	echo "<tr>";
	echo "<td><span class='table_row_title'>".POSITION.": </span></td>";
	echo "<td>";
	echo "<select name='Position_Description'>";
	while(!($description_rs->EOF))
	{
		$current_position_description=$description_rs->fields("position_description");
		$s="";
		if($current_position_description==$Position_Description)
			$s="selected";
		echo "<option value='$current_position_description' $s>$current_position_description</option>";
		$description_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";
	
	
	$sql="select * from scoring_categories where position_description='$Position_Description' order by display_order ASC;";

	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".UNUSED_CATEGORIES."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		while(!($rs->EOF))
		{
			$categories_ID=$rs->fields("ID");
			$category_title=$rs->fields("category_title");
			$short_title=$rs->fields("short_title");
			$positionID_array=$rs->fields("positionID_array");
			$positionID_array=explode(":", $positionID_array);
			$short_titledb=addslashes($short_title);
			$logic="0=1";
			foreach($positionID_array as $key => $val)
			{
				$logic=$logic." or (positionID_array like '$val' or positionID_array like '%:$val:%' or positionID_array like '%:$val%' or positionID_array like '%$val:%')";
			}
			$sql="select scoring_categories.ID, positionID_array, position_description from scoring_categories, scoring_categories_leagues_values where short_title='$short_titledb' and scoring_categories.ID<>$categories_ID and scoring_categories.ID=scoring_categories_ID and leagues_ID=$LEAGUEID and ($logic);";
			$categories_rs=$DB->Execute($sql);
			$show_add_category=true;
			if(!($categories_rs->EOF))
			{
				$show_add_category=false;
				$added_position_description=$categories_rs->fields("position_description");
			}
			if(! (in_array($categories_ID, $current_scoring_categories)))
			{
				$bg=get_row_bg($bg);
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='table_row_title'>$category_title</span></td>";
				if($show_add_category)
				{
					echo "<td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action=add_scoring_category&Scoring_Category_ID=$categories_ID&Position_Description=$Position_Description'>".ADD."</a></td>";
				}
				else
				{
					$already_in_position=ALREADY_IN_POSITION;
					$already_in_position=str_replace("ACTUAL_POSITION_DESCRIPTION", $added_position_description, $already_in_position);
					echo "<td colspan='3'>{$already_in_position}</td>";
				}
				echo "</tr>";
			}
			$rs->MoveNext();
		}
		echo "</table>";
		echo "<br>";
	}
	$sql="select * from scoring_categories where position_description='$Position_Description' order by display_order ASC";
	$rs=$DB->Execute($sql);
	
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='4'><span class='table_row_title'>".CURRENT_CATEGORIES."</span></td></tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
	while(!($rs->EOF))
	{
		$categories_ID=$rs->fields("ID");
		if(in_array($categories_ID, $current_scoring_categories))
		{
			display_scoring_category_admin($categories_ID, $LEAGUEID, $Position_Description, "table_row_title");
		}
		
		$rs->MoveNext();
	}
	echo "</table>";
	
	
	
	

}

function display_scoring_category_admin($categories_ID, $leagues_ID, $Position_Description, $title_style="",  $style="")
{
	global $PHP_SELF, $DB, $Mode;
	
	if(strlen($style)<1)
	$sql="select * from scoring_categories where ID=$categories_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$category_title=$rs->fields("category_title");
		$category_type=$rs->fields("category_type");
		$category_description=$rs->fields("category_description");
	}
	$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$categories_ID and leagues_ID=$leagues_ID order by is_repeating ASC, value ASC, points ASC";
	$rs=$DB->Execute($sql);
	if($category_type=="Value")
	{
		$current_points=$rs->fields("points");
		if($current_points==1)
			$current_points=$current_points." ".POINT;
		else
			$current_points=$current_points." ".POINTS;
		echo "<tr>";
		echo "<td><span class='$title_style'>$category_title</span></td>";
		echo "<td><span class='$style'>$current_points</span></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_scoring_category&Scoring_Category_ID=$categories_ID&Position_Description=$Position_Description'>".EDIT."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_scoring_category&Scoring_Category_ID=$categories_ID&Position_Description=$Position_Description'>".REMOVE."</a></td>";
		echo "</tr>";
	}
	elseif($category_type=="Range")
	{
		echo "<tr><td><span class='$title_style'>$category_title</span></td>";
		echo "<td></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_scoring_category&Scoring_Category_ID=$categories_ID&Position_Description=$Position_Description'>".EDIT."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_scoring_category&Scoring_Category_ID=$categories_ID&Position_Description=$Position_Description'>".REMOVE."</a></td>";
		echo "</tr>";
		$previous_value=0;
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$current_value=$rs->fields("value");
			$current_points=$rs->fields("points");
			$is_repeating=$rs->fields("is_repeating");
			if($current_points==1)
				$current_points=$current_points." ".POINT;
			else
				$current_points=$current_points." ".POINTS;
			if(!$is_repeating)
			{
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='$style'>$previous_value - $current_value $category_description</span></td>";
				echo "<td colspan='3'><span class='$style'>$current_points</span></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='$style'>".EVERY_ADDITIONAL." $current_value $category_description</span></td>";
				echo "<td><span class='$style'>$current_points</span></td>";
				echo "</tr>";
			}
			$previous_value=$current_value+1;
			$rs->MoveNext();
		}
	}
}

function edit_scoring_category($Scoring_Category_ID, $Position_Description="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	$sql="select * from scoring_categories where ID=$Scoring_Category_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$category_title=$rs->fields("category_title");
		$category_type=$rs->fields("category_type");
		$category_description=$rs->fields("category_description");
	}
	$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$Scoring_Category_ID and leagues_ID=$LEAGUEID order by is_repeating ASC, value ASC, points ASC";
	$rs=$DB->Execute($sql);
	echo "<table>";
	if($category_type=="Value")
	{
		if(!$rs->EOF)
		{
			$current_points=$rs->fields("points");
		}
		else
		{
			$current_points=0;
		}
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><span class='main_title' colspan='3'>$category_title</td></tr>";
		echo "<tr><td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action=&Position_Description=$Position_Description'>".BACK."</a></td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td><input type=\"text\" name=\"Points\" value=\"$current_points\" size=\"2\">&nbsp;<span class='table_row_title'>".POINTS."</span></td>";
		echo "</tr>";
		echo "<tr><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		
		
		
	}
	elseif($category_type=="Range")
	{
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><span class='main_title' colspan='4'>$category_title</td></tr>";
		echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=&Position_Description=$Position_Description'>".BACK."</a></td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td><input type='text' name='New_Value' value='0' size='2'>&nbsp;$category_description</td>";
		echo "<td><input type='text' name='New_Points' value='0' size='2'>&nbsp;".POINTS."</td>";
		$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$Scoring_Category_ID and leagues_ID=$LEAGUEID and is_repeating=1";
		$repeating_rs=$DB->Execute($sql);
		if($repeating_rs->EOF)
		{
			echo "<td>";
			echo "<select name='Is_Repeating'>";
			echo "<option value='0'>".NOT_REPEATING."</option>";
			echo "<option value='1'>".REPEATING."</option>";
			echo "</select>";
			echo "</td>";
		}
		echo "<td><input type='Submit' name='Submit' value='".ADD_NEW_RANGE."'></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Position_Description' value='$Position_Description'>";
		echo "<input type='hidden' name='Action' value='confirm_add_new_scoring_range'>";
		echo "<input type='hidden' name='Scoring_Category_ID' value='$Scoring_Category_ID'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
		echo "<br>";
		echo "<table>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".CURRENT_SCORING."</span></td></tr>";
		echo "<form method='post' action='$PHP_SELF?'>";
		$previous_value=0;
		while(!($rs->EOF))
		{
			$current_ID=$rs->fields("ID");
			$current_value=$rs->fields("value");
			$current_points=$rs->fields("points");
			$is_repeating=$rs->fields("is_repeating");
			if($current_points==1)
				$points_display=" ".POINT;
			else
				$points_display=" ".POINTS;
			if(!$is_repeating)
			{
				echo "<tr>";
				echo "<td align='right'>$previous_value -></td><td><input type='text' name='Value[$current_ID]' value='$current_value' size='2'>&nbsp;$category_description &nbsp;=&nbsp;</td>";
				echo "<td><input type='text' name='Points[$current_ID]' value='$current_points' size='2'>&nbsp;$points_display</td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_scoring_range&Scoring_Range_ID=$current_ID&Scoring_Category_ID=$Scoring_Category_ID&Position_Description=$Position_Description'>".REMOVE."</a></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr>";
				echo "<td>Every</td><td><input type='text' name='Value[$current_ID]' value='$current_value' size='2'>&nbsp;$category_description &nbsp;=&nbsp;</td>";
				echo "<td><input type='text' name='Points[$current_ID]' value='$current_points' size='2'>&nbsp;$points_display ".REPEATING."</td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_scoring_range&Scoring_Range_ID=$current_ID&Scoring_Category_ID=$Scoring_Category_ID&Position_Description=$Position_Description'>".REMOVE."</a></td>";
				echo "</tr>";
			}
			$previous_value=$current_value+1;
			$rs->MoveNext();
		}
	
	}
	echo "<input type='hidden' name='Position_Description' value='$Position_Description'>";
	echo "<input type='hidden' name='Action' value='confirm_edit_scoring_category'>";
	echo "<input type='hidden' name='Scoring_Category_ID' value='$Scoring_Category_ID'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";


}

function display_calculate_fantasy_stats($Week_ID)
{
	global $Mode, $DB;
	
	$weeks_in_season=get_number_weeks_season();
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
	echo "<tr><td colspan='3'><span class='main_title'>".CALCULATE_FANTASY_STATS."</span></td></tr>";
	echo "<tr><td><span class='table_row_title'>".WEEK.": </span></td>";
	echo "<td>";
	echo "<select name='Week_ID'>";
	for($i=1; $i<=$weeks_in_season; $i++)
	{
		$s="";
		if($i==$Week_ID)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value='".RUN_STATS."'></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_calculate_fantasy_stats'>";
	echo "</form>";
	echo "</table>";
}

function calculate_stats($Week_ID, $leagues_ID, $Game_ID="")
{
	global $Mode, $DB;
	
	if(strlen($Game_ID)<1)
		$Game_ID=$Week_ID;
	$sql="select distinct(scoring_categories_ID) from scoring_categories_leagues_values where leagues_ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	
	while(!($rs->EOF))
	{
		$scoring_categories_ID=$rs->fields("scoring_categories_ID");
		$sql="select category_type, statistic_categories_ID, positionID_array from scoring_categories where ID=$scoring_categories_ID;";
		$scoring_rs=$DB->Execute($sql);
		$category_type=$scoring_rs->fields("category_type");
		$positionID_array=$scoring_rs->fields("positionID_array");
		$statistic_categories_ID=$scoring_rs->fields("statistic_categories_ID");
		
		$positionID_array=explode(":",$positionID_array);
		$statistic_categories_ID=explode(":",$statistic_categories_ID);
		$logic="0=1";
		foreach($statistic_categories_ID as $key => $val)
		{
			if(strlen($val)>0)
			{
				$logic=$logic." or statistic_categories_ID=$val";
			}
		}
		$sql="select sum(statistical_value) as stat_value, players_ID from players_statistics_actuals where ($logic) and week_ID=$Week_ID and game_ID=$Game_ID group by players_ID;";
		$players_rs=$DB->Execute($sql);
		while(!($players_rs->EOF))
		{
			$players_ID=$players_rs->fields("players_ID");
			$stat_value=$players_rs->fields("stat_value");
			$sql="select positionID from players where ID='$players_ID';";
			$player_detail_rs=$DB->Execute($sql);
			if(!($players_position_ID->EOF))
			{
				$players_position_ID=$player_detail_rs->fields("positionID");
				if(in_array($players_position_ID, $positionID_array))
				{
					$fantasy_value=calculate_fantasy_value($scoring_categories_ID, $leagues_ID, $stat_value);
					$sql="select ID from players_statistics_fantasy where players_ID='$players_ID' and scoring_categories_ID=$scoring_categories_ID and leagues_ID=$leagues_ID and week_ID=$Week_ID and game_ID=$Game_ID;";
					$fantasy_rs=$DB->Execute($sql);
					if(!($fantasy_rs->EOF))
					{
						$fantasy_ID=$fantasy_rs->fields("ID");
						$sql="update players_statistics_fantasy set fantasy_value=$fantasy_value where ID=$fantasy_ID;";
						$DB->Execute($sql);
					}
					else
					{
						$sql="insert into players_statistics_fantasy (players_ID, scoring_categories_ID, fantasy_value, leagues_ID, week_ID, game_ID) values('$players_ID', '$scoring_categories_ID', '$fantasy_value', '$leagues_ID', '$Week_ID', '$Game_ID');";
						$DB->Execute($sql);
					}
				}
			}
			$players_rs->MoveNext();
		}
		$rs->MoveNext();
	}
}

function calculate_fantasy_value($scoring_categories_ID, $leagues_ID, $stat_value)
{
	global $PHP_SELF, $DB;
	$sql="select category_type, statistic_categories_ID from scoring_categories where ID=$scoring_categories_ID;";
	$rs=$DB->Execute($sql);
	$category_type=$rs->fields("category_type");
	
	$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$scoring_categories_ID and leagues_ID=$leagues_ID and is_repeating=0 order by value ASC;";
	$rs=$DB->Execute($sql);
	$fantasy_value=0;
	if($category_type=="Value")
	{
		$points=$rs->fields("points");
		$fantasy_value=$points*$stat_value;
	}
	elseif($category_type=="Range")
	{
		$max=0;
		$previous=0;
		$found_value=0;
		while(!($rs->EOF))
		{
			$value=$rs->fields("value");
			$current=$value;
			$points=$rs->fields("points");
			if((($stat_value>$previous) || ($stat_value==0 && $previous==0 && $found_value!=1)) && $stat_value<=$current)
			{
				$found_value=1;
				$fantasy_value=$points;
			}
			
			$previous=$current;
			$max=$value;
			$rs->MoveNext();
		}
		if($found_value==0)
		{
			$fantasy_value=$points;
		}
		if($stat_value>$max)
		{
			$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$scoring_categories_ID and leagues_ID=$leagues_ID and is_repeating=1;";
			$repeating_rs=$DB->Execute($sql);
			if(!($repeating_rs->EOF))
			{
				$value=$repeating_rs->fields("value");
				$points=$repeating_rs->fields("points");
				if(strlen($value>0) && $value!=0)
				{
					$number_past_max=ceil(($stat_value-$max)/$value);
				}
				$fantasy_value=$fantasy_value+($number_past_max*$points);
			}
		}
	}
	return $fantasy_value;
}

function display_copy_scoring()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td><span class='table_row_title'>".CHOOSE_LEAGUE_COPY_RULES_FROM." ".WARNING_COPY_RULES_LEAGUE."</span></td></tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE."</span></td>";
	echo "<td>";
	echo "<select name='Copy_League_ID'>";
	$sql="select ID, league_name from leagues where ID<>$LEAGUEID;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$league_ID=$rs->fields("ID");
		$league_name=$rs->fields("league_name");
		echo "<option value='$league_ID'>$league_name</option>";
		$rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"</td></tr>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='confirm_copy_scoring'>";
	echo "</form>";
	echo "</table>";
}
?>
