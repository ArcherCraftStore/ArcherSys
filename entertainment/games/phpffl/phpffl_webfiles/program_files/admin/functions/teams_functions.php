<?php
/*

function admin_teams_main() - Displays the main view that is seen when Teams is clicked on in the Admin section.

function display_add_team($Team_Name="", $Divisions_ID="") - Displays Add a New Team.

function display_edit_team($Teams_ID) - Displays Edit for an existing Team.


*/
function admin_teams_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select a.*,b.division_name from teams a left outer join divisions b on b.ID =
a.divisions_ID where a.leagues_ID=$LEAGUEID order by a.team_name;";
	$rs = $DB->Execute($sql);
	if(!$rs->EOF)
		$total_teams=$rs->RecordCount();
	else
		$total_teams=0;
	echo "<table border='0' cellpadding='4' cellspacing='3'>";

	$sql="select count(ID) as num_leagues from leagues;";
	$leagues_rs=$DB->Execute($sql);
	$num_leagues=$leagues_rs->fields("num_leagues");
	echo "<tr><td colspan='5'><a
href=\"$PHP_SELF?Mode=$Mode&Action=add_new_team\">".ADD_NEW_TEAM."</a></td></tr>";
	echo "<tr><td colspan='6'>&nbsp;</td></tr>";
	echo "<tr><td colspan='6'><span class='thirteen_title'>".TOTAL_TEAMS.": $total_teams</span></td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td><span class='table_row_title'>".DIVISION."</span></td>";
	echo "<td></td><td></td><td></td><td></td>";
	if($num_leagues>1)
	{
		echo "<td></td>";
	}
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='7'></td></tr>";
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$team_name=$rs->fields("team_name");
		$team_ID=$rs->fields("ID");
		$divisions_ID=$rs->fields("division_ID");
		$division_name=$rs->fields("division_name");
		if( strlen($division_name)<1 or $division_name=="NULL")
			$division_name=NA;
		echo "<tr bgcolor='$bg'><td>$team_name</td><td>$division_name</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_roster&Teams_ID=$team_ID'>".EDIT_ROSTER."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_teamlogo&Teams_ID=$team_ID'>".UPDATE_TEAM_LOGO."</td>";
		//echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=manage_random&Teams_ID=$team_ID'>Random Points</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_team&Teams_ID=$team_ID'>".EDIT."</a></td>";
		if($num_leagues>1)
		{
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=move_team&Teams_ID=$team_ID'>".MOVE."</a></td>";
		}
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_team&Teams_ID=$team_ID'>".DELETE."</a></td>";
		echo "</tr>";
		$rs->MoveNext();
	}
	echo "</table>";
}

function display_add_team($Team_Name="", $Divisions_ID="", $Leagues_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	if(strlen($Leagues_ID)<1)
		$compare_leagues_ID=$LEAGUEID;
	else
		$compare_leagues_ID=$Leagues_ID;

	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_TEAM."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td><input type=\"text\" name=\"Team_Name\" value=\"$Team_Name\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".DIVISION."</span></td><td>";
	$sql="select * from divisions where leagues_ID=$LEAGUEID order by display_order;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Divisions_ID'>";
		while(!($rs->EOF))
		{
			$cur_divisions_ID=$rs->fields("ID");
			$cur_divisions_name=$rs->fields("division_name");
			$selected="";
			if($cur_divisions_ID==$Divisions_ID)
				$selected="selected";
			echo "<option value='$cur_divisions_ID' $selected>$cur_divisions_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
	}
	else
	{
		echo NA;
	}
	echo "</td></tr>";
	echo "<input type='hidden' name='Leagues_ID' value='$LEAGUEID'>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_team'>";
	echo "</form></table>";
}

function display_edit_team($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select team_name, divisions_ID, leagues_ID from teams where ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Team_Name=$rs->fields("team_name");
		$Divisions_ID=$rs->fields("divisions_ID");
		$Leagues_ID=$rs->fields("leagues_ID");
	}
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='2'><span class='main_title'>".EDIT_TEAM."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td><input type=\"text\" name=\"Team_Name\" value=\"$Team_Name\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".DIVISION."</span></td><td>";
	$sql="select * from divisions where leagues_ID=$LEAGUEID order by display_order;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Divisions_ID'>";
		while(!($rs->EOF))
		{
			$cur_divisions_ID=$rs->fields("ID");
			$cur_divisions_name=$rs->fields("division_name");
			$selected="";
			if($cur_divisions_ID==$Divisions_ID)
				$selected="selected";

			echo "<option value='$cur_divisions_ID' $selected>$cur_divisions_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
	}
	else
	{
		echo NA;
	}
	echo "</td></tr>";
	echo "<input type='hidden' name='Leagues_ID' value='$LEAGUEID'>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Teams_ID' value='$Teams_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_team'>";
	echo "</form></table>";
}

function display_edit_roster($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode;

	$sql="select team_name from teams where ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Team_Name=$rs->fields("team_name");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='main_title'>$Team_Name</td></tr>";
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Teams_ID=$Teams_ID&Is_Keeper=0'>".ADD_PLAYER."</a></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Teams_ID=$Teams_ID&Is_Keeper=1'>".ADD_KEEPER."</a></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";

	$sql="select players_ID from rosters where current_teams_ID=$Teams_ID";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{

		echo "<tr>";
		echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
		echo "<td><span class='table_row_title'>".POSITION."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		while(!($rs->EOF))
		{
			$players_ID=$rs->fields("players_ID");
			$sql="select lastname, firstname, positionID, teamID from players where ID='$players_ID' order by positionID ASC, teamID ASC, lastname ASC";
			$players_rs=$DB->Execute($sql);
			if(!($players_rs->EOF))
			{
				$firstname=$players_rs->fields("firstname");
				$lastname=$players_rs->fields("lastname");
				$positionID=$players_rs->fields("positionID");
				$teamID=$players_rs->fields("teamID");
				echo "<tr>";
				echo "<td>$lastname, $firstname</td>";
				echo "<td>$positionID</td>";
				echo "<td>$teamID</td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_player&Teams_ID=$Teams_ID&Players_ID=$players_ID'>".REMOVE."</a></td>";
				echo "</tr>";
			}
			$rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_PLAYERS_ON_TEAM."</span></td></tr>";
	}
	echo "</table>";
}

function display_add_player_team($Teams_ID, $Is_Keeper, $Current_Letter="", $OrderBy="", $SortBy="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	$sql="select team_name from teams where ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Team_Name=$rs->fields("team_name");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td>";
	echo "<a href='$PHP_SELF?Mode=$Mode&Action=edit_roster&Teams_ID=$Teams_ID'>".BACK."</a>";
	echo "</td></tr>";
	if($Is_Keeper==1)
	{
		echo "<tr><td><span class='main_title'>$Team_Name: ".ADD_A_KEEPER."</td></tr>";
	}
	else
	{
		echo "<tr><td><span class='main_title'>$Team_Name: ".ADD_A_PLAYER."</td></tr>";
	}
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
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>".SHOW_ALL."</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".SHOW_ALL."</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".NAME."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".NAME."</a></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".POSITION."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".POSITION."</a></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".TEAM."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_player&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".TEAM."</a></td>";
	}
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
	if($Current_Letter=="ALL")
	{
		$sql="select players.* from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NULL order by $OrderBy $SortBy";
	}
	else
	{
		$sql="select players.* from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and lastname like '$Current_Letter%' and rosters.players_ID IS NULL order by $OrderBy $SortBy";
	}
	//echo "$sql<br>";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$players_ID=$rs->fields("ID");
		$lastname=$rs->fields("lastname");
		$firstname=$rs->fields("firstname");
		$team=$rs->fields("teamID");
		if(strlen($team)<1)
			$team=FREE_AGENT;
		$position=$rs->fields("positionID");
		echo "<tr bgcolor='$bg'>";
		echo "<td>$lastname, $firstname</td>";
		echo "<td>$position</td>";
		echo "<td>$team</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=confirm_add_player&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Teams_ID=$Teams_ID&Is_Keeper=$Is_Keeper'>".ADD_PLAYER."</a></td>";
		echo "</tr>";
		$rs->MoveNext();
	}
	echo "</table>";

}

function display_manage_random_points($Teams_ID, $Game_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	if(strlen($Game_ID)<1)
		$Game_ID=1;
	$team_name=get_team_name($Teams_ID);
	$random_points=0;
	$sql="select fantasy_value from players_statistics_fantasy where players_ID='0' and scoring_categories_ID=0 and leagues_ID=$LEAGUEID and week_ID=$Game_ID and game_ID=$Game_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$random_points=$rs->fields("fantasy_value");
	}
	$games=get_number_games_season();
	echo "<table>";
	echo "<tr><td colspan='2'><span class='main_title'>$team_name</span></td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".GAME.": </span></td>";
	echo "<td>";
	echo "<select name='Game_ID'>";
	for($i=1;$i<=$games;$i++)
	{
		$s="";
		if($i==$Game_ID)
		{
			$s="selected";
		}
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".RANDOM_POINTS.": </span></td>";
	echo "<td>";
	echo "<input type='text' name='Random_Points' value='$random_points' size='2'>";
	echo "<input type='hidden' name='Teams_ID' value='$Teams_ID'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='update_random_points'>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "</table>";
	echo "</form>";
}

function display_move_team($Teams_ID)
{
	global $DB, $LEAGUEID, $PHP_SELF, $Mode;

	$team_name=get_team_name($Teams_ID);
	echo "<table>";
	echo "<tr><td colspan='2'><span class='main_title'>".MOVE_TEAM.": $team_name</span></td></tr>";
	echo "<tr><td colspan='2'><span class='errors'>".MOVE_TEAM_WARNING."</span></td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td width='90'><span class='table_row_title'>".LEAGUE.": </span></td>";
	echo "<td>";
	echo "<select name='Leagues_ID'>";
	$sql="select ID, league_name from leagues where ID<>$LEAGUEID order by league_name ASC;";
	$leagues_rs=$DB->Execute($sql);
	while(!($leagues_rs->EOF))
	{
		$current_leauges_ID=$leagues_rs->fields("ID");
		$current_leauges_name=$leagues_rs->fields("league_name");
		echo "<option value='$current_leauges_ID'>$current_leauges_name</option>";
		$leagues_rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<td>";
	echo "<input type='hidden' name='Teams_ID' value='$Teams_ID'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='confirm_move_team'>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "</table>";
	echo "</form>";
}
?>
