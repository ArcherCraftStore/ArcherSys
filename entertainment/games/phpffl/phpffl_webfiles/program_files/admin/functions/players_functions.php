<?php 


function admin_players_main($Current_Letter="", $OrderBy="", $SortBy="")
{
	global $Mode, $DB, $PHPFFL_WEB_ROOT;
	
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
	//Add a player is removed because players are updated automatically
	//echo "<tr><td colspan='5'><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>Add a New Player</a></td></tr>";
	echo "<tr><td colspan='5'>";
	foreach($alphabet as $key => $val)
	{
		if($Current_Letter==$val)
		{
			echo "&nbsp;<strong>{$val}</strong>&nbsp;";
		}
		else
		{
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>".SHOW_ALL."</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy'>".SHOW_ALL."</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort'>".NAME."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC'>".NAME."</a></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort'>".POSITION."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC'>".POSITION."</a></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort'>".TEAM."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC'>".TEAM."</a></td>";
	}
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
	if($Current_Letter=="ALL")
	{
		$sql="select * from players where active='yes' order by $OrderBy $SortBy";
	}
	else
	{
		$sql="select * from players where active='yes' and lastname like '$Current_Letter%' order by $OrderBy $SortBy";
	}
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$players_ID=$rs->fields("ID");
		$lastname=$rs->fields("lastname");
		$firstname=$rs->fields("firstname");
		$team=$rs->fields("teamID");
		if(strlen($team)<1)
			$team="FA";
		$position=$rs->fields("positionID");
		echo "<tr bgcolor='$bg'>";
		echo "<td>$lastname, $firstname</td>";
		echo "<td>$position</td>";
		echo "<td>$team</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_player&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>".EDIT."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_player_stats&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>".MODIFY_STATS."</a></td>";
		echo "</tr>";
		$rs->MoveNext();
	}
	echo "</table>";

}

function display_edit_player($Players_ID, $Current_Letter, $OrderBy, $SortBy)
{
	global $PHP_SELF, $DB, $Mode;
	
	$sql="select * from players where ID='$Players_ID';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$lastname=$rs->fields("lastname");
		$firstname=$rs->fields("firstname");
		$teamID=$rs->fields("teamID");
		$positionID=$rs->fields("positionID");
	}
	echo "<table width='75%'>";
	
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>".BACK."</a></td></tr>";
	echo "<tr><td><span class='table_row_title'>".WARNING_MODIFY_PLAYERS_ID."</span></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".EDIT_PLAYER.": $lastname, $firstname</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".PLAYERS_ID."</span></td><td><input type=\"text\" name=\"New_Players_ID\" value=\"$Players_ID\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td>";
	echo "<select name='TeamID'>";
	echo "<option value=''>".FREE_AGENT."</a>";
	$sql="select distinct(teamID) from players where teamID<>'' order by teamID ASC";
	$team_rs=$DB->Execute($sql);
	while(!($team_rs->EOF))
	{
		$current_teamID=$team_rs->fields("teamID");
		$s="";
		if($current_teamID==$teamID)
			$s="selected";
		echo "<option value='$current_teamID' $s>$current_teamID</option>";
		$team_rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td>";
	echo "<select name='PositionID'>";
	$sql="select distinct(positionID) from players where positionID<>'' order by teamID ASC";
	$team_rs=$DB->Execute($sql);
	while(!($team_rs->EOF))
	{
		$current_positionID=$team_rs->fields("positionID");
		$s="";
		if($current_positionID==$positionID)
			$s="selected";
		echo "<option value='$current_positionID' $s>$current_positionID</option>";
		$team_rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Players_ID' value='$Players_ID'>";
	echo "<input type=hidden name='Current_Letter' value='$Current_Letter'>";
	echo "<input type=hidden name='OrderBy' value='$OrderBy'>";
	echo "<input type=hidden name='SortBy' value='$SortBy'>";
	echo "<input type=hidden name='Action' value='confirm_edit_player'>";
	echo "</form></table>";

}

function display_add_player($Current_Letter, $OrderBy, $SortBy, $TeamID="", $PositionID="", $Players_ID="", $LastName="", $FirstName="")
{
	global $PHP_SELF, $DB, $Mode;
	
	echo "<table width='75%'>";
	
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>".BACK."</a></td></tr>";
	echo "<tr><td><span class='table_row_title'>".WARNING_MODIFY_PLAYERS_ID."</span></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='main_title'>".CREATE_NEW_PLAYER."</span></td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".PLAYERS_ID."</span></td><td><input type=\"text\" name=\"Players_ID\" value=\"$Players_ID\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LAST_NAME."</span></td><td><input type=\"text\" name=\"LastName\" value=\"$LastName\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".FIRST_NAME."</span></td><td><input type=\"text\" name=\"FirstName\" value=\"$FirstName\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td>";
	echo "<select name='TeamID'>";
	echo "<option value=''>".FREE_AGENT."</a>";
	$sql="select distinct(teamID) from players where teamID<>'' order by teamID ASC";
	$team_rs=$DB->Execute($sql);
	while(!($team_rs->EOF))
	{
		$current_teamID=$team_rs->fields("teamID");
		$s="";
		if($current_teamID==$TeamID)
			$s="selected";
		echo "<option value='$current_teamID' $s>$current_teamID</option>";
		$team_rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td>";
	echo "<select name='PositionID'>";
	$sql="select distinct(positionID) from players where positionID<>'' order by teamID ASC";
	$team_rs=$DB->Execute($sql);
	while(!($team_rs->EOF))
	{
		$current_positionID=$team_rs->fields("positionID");
		$s="";
		if($current_positionID==$PositionID)
			$s="selected";
		echo "<option value='$current_positionID' $s>$current_positionID</option>";
		$team_rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Current_Letter' value='$Current_Letter'>";
	echo "<input type=hidden name='OrderBy' value='$OrderBy'>";
	echo "<input type=hidden name='SortBy' value='$SortBy'>";
	echo "<input type=hidden name='Action' value='confirm_add_player'>";
	echo "</form></table>";

}

function edit_player_stats($Players_ID, $Week_ID, $Current_Letter, $OrderBy, $SortBy)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	
	if(strlen($Week_ID)<1)
		$Week_ID=1;
	$Game_ID=$Week_ID;
	$weeks_in_season=get_number_weeks_season();
	$sql="select firstname, lastname, positionID from players where ID='$Players_ID'";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$firstname=$rs->fields("firstname");
		$lastname=$rs->fields("lastname");
		$positionID=$rs->fields("positionID");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='3'><a href='$PHP_SELF?Mode=$Mode&Action=&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy'>".BACK."</a></td></tr>";
	echo "<tr><td colspan='3'><span class='main_title'>$firstname $lastname</span></td></tr>";
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
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Current_Letter' value='$Current_Letter'>";
	echo "<input type=hidden name='OrderBy' value='$OrderBy'>";
	echo "<input type=hidden name='SortBy' value='$SortBy'>";
	echo "<input type=hidden name='Players_ID' value='$Players_ID'>";
	echo "<input type=hidden name='Action' value='edit_player_stats'>";
	echo "</form>";
	echo "</table>";
	echo "<br>";
	$statistic_categories_group=get_players_statistic_group($positionID);
	$statistic_categories_group_array=array();
	$statistic_categories_group_array=explode(":", $statistic_categories_group);
	
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".OVERRIDE_AUTO_STATS."</td>";
	echo "<td>";
	echo "<select name='Stats_Override'>";
	$sql="select ID from players_statistics_override where week_ID=$Week_ID and players_ID='$Players_ID' and game_ID=$Game_ID;";
	$override_rs=$DB->Execute($sql);
	echo "<option value='0'>".NO."</option>";
	$s="";
	if(!($override_rs->EOF))
		$s="selected";
	echo "<option value='1' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	foreach($statistic_categories_group_array as $key => $val)
	{
		$sql="select ID, description from statistic_categories where groupby='$val';";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$statistic_categories_ID=$rs->fields("ID");
			$statistic_categories_description=$rs->fields("description");
			$statistic_value=get_statistical_value($Week_ID, $Players_ID, $statistic_categories_ID, $Game_ID);
			echo "<tr>";
			echo "<td><span class='table_row_title'>$statistic_categories_description</span></td>";
			echo "<td><input type='text' name='Statistic_Category_Value[$statistic_categories_ID]' value='$statistic_value' size='5'></td>";
			echo "</tr>";
			$rs->MoveNext();
		}
	}
	$sql="select fantasy_value from players_statistics_fantasy where players_ID='$Players_ID' and week_ID=$Week_ID and game_ID=$Game_ID and leagues_ID=$LEAGUEID and scoring_categories_ID=0;";
	$random_rs=$DB->Execute($sql);
	if(!($random_rs->EOF))
	{
		$random_points=$random_rs->fields("fantasy_value");
	}
	else
	{
		$random_points=0;
	}
	echo "<tr>";
	echo "<td><span class='table_row_title'>".RANDOM_FANTASY_POINTS."</span></td>";
	echo "<td><input type='text' name='Random_Points' value='$random_points' size='5'></td>";
	echo "</tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Current_Letter' value='$Current_Letter'>";
	echo "<input type=hidden name='OrderBy' value='$OrderBy'>";
	echo "<input type=hidden name='SortBy' value='$SortBy'>";
	echo "<input type=hidden name='Players_ID' value='$Players_ID'>";
	echo "<input type=hidden name='Week_ID' value='$Week_ID'>";
	echo "<input type=hidden name='Game_ID' value='$Game_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_player_stats'>";
	echo "</form>";
	echo "</table>";

}
?>