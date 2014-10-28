<?php

function display_draft_myteam_main($Teams_ID, $Page, $Position)
{
	global $PHP_SELF, $DB, $Mode;

	if(strlen($Position)<1)
	{
		$Position="All";
	}
	$current_session_id=session_id();
	$current_session_name=session_name();
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	$sql="select ID from draft where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<td><a href='{$PHP_SELF}?Mode=$Mode&Action=target_picks_position' class='eleven'>".TARGET_PICKS_BY_POSITION."</a></td>";
		echo "<td>&nbsp;</td>";
	}
	echo "<td><a href='{$PHPFFL_WEB_ROOT}draft.php?Mode=draft&Action=draft_main&{$current_session_name}={$current_session_id}' target='_blank' class='eleven'>".ENTER_BASIC_DRAFT."</a></td>";
	echo "<td>&nbsp;</td>";
	echo "<td><a href='{$PHPFFL_WEB_ROOT}livedraft.php?Mode=livedraft&Action=livedraft_main&{$current_session_name}={$current_session_id}' target='_blank' class='eleven'>".ENTER_LIVE_DRAFT."</a></td>";
	echo "<td><a href='{$PHP_SELF}?Mode=$Mode&Action=reset_player_ranking' class='eleven'>".RESET_PLAYER_RANKING."</a></td>";
	echo "</tr>";
	echo "</table>";

	display_draft_rank($Teams_ID, $Page, $Position);


}

function display_draft_rank($Teams_ID, $Page, $Position, $Pagesize=100)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_IMAGE_PATH;

	if(strlen($Page)<1)
	{
		$Page=1;
	}
	$Page_start=($Page-1)*$Pagesize;
	//Check to make sure this team has data in autorank table.
	$sql="select ID from draft_rank_teams where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if($rs->EOF)
	{
		set_team_autorank_players($Teams_ID, $LEAGUEID);
	}


	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";

	$positions_rs=$DB->Execute($sql);
	if(!($positions_rs->EOF))
	{
		$positions_type_array=array();
		$positions_rs->MoveFirst();
		$extra_logic=$extra_logic." and (0=1 ";
		while(!($positions_rs->EOF))
		{
			$positions_type=$positions_rs->fields("type");
			$positions_type_array[]=$positions_type;
			$players_positionID=$positions_rs->fields("players_positionID");
			$players_positionID_array=explode(":", $players_positionID);
			foreach($players_positionID_array as $key => $val)
			{
				if(strlen($val)>0 && ($positions_type==$Position || $Position=="All" || $Position=="AllAvailable"))
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}

			$positions_rs->MoveNext();
		}
		$extra_logic=$extra_logic." ) ";

		$sql="select positionID, description from players_positions;";
		$players_positions_rs=$DB->Execute($sql);
		$players_positions_array=array();
		while(!($players_positions_rs->EOF))
		{
			$current_positionID=$players_positions_rs->fields("positionID");
			$current_description=$players_positions_rs->fields("description");
			$players_positions_array[$current_positionID]=$current_description;
			$players_positions_rs->MoveNext();
		}
		$sql="select count(draft_rank_teams.players_ID) as total_records from draft_rank_teams, players where players.ID=draft_rank_teams.players_ID and draft_rank_teams.teams_ID=$Teams_ID and draft_rank_teams.leagues_ID=$LEAGUEID $extra_logic";
		$players_rs=$DB->Execute($sql);
		$number_records=$players_rs->fields('total_records');
		$number_pages=ceil($number_records/$Pagesize);
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td>".POSITION."</td><td>";
		echo "<select name='Position'>";
		echo "<option value='All'>".ALL." (".EDIT.")</option>";
		$s="";
		if($Position=="AllAvailable")
		{
			$s="selected";
		}
		echo "<option value='AllAvailable' $s>".ALL." (".AVAILABLE.")</option>";
		foreach($positions_type_array as $key => $val)
		{
			$s="";
			if($val==$Position)
			{
				$s="selected";
			}
			echo "<option value='$val' $s>$val (".AVAILABLE.")</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value='".SUBMIT."'></td>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "<input type='hidden' name='Action' value='view_draft_rank'>";
		echo "</form>";
		echo "</table>";
		echo "<table border='0' cellpadding='4' cellspacing='3'>";

		echo "<tr><td>";
		if($Page!=1)
		{
			$previous_page=$Page-1;
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Page=$previous_page&Position=$Position'>".PREVIOUS."</a>&nbsp;";
		}
		else
		{
			echo PREVIOUS."&nbsp;";
		}
		for($i=1;$i<=$number_pages;$i++)
		{
			if($i==$Page)
			{
				echo "{$i}&nbsp;";
			}
			else
			{
				echo "<a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Page=$i&Position=$Position'>{$i}</a>&nbsp;";
			}
		}
		if($Page!=$number_pages)
		{
			$next_page=$Page+1;
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Page=$next_page&Position=$Position'>".NEXT."</a>&nbsp;";
		}
		else
		{
			echo NEXT."&nbsp;";
		}
		echo "</td></tr>";
		echo "</table>";
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".RANK."</span></td>";
		echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'>".POSITION."</span></td>";

		if($Position=="All")
		{
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
		}
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='15'></td></tr>";

		$limit_sql=" limit $Page_start, $Pagesize";

		$available_sql="";
		if($Position!="All")
		{
			$available_sql="and draft_rank_teams.players_ID NOT IN (select players_ID from rosters where leagues_ID=$LEAGUEID) ";
		}
		$sql="select draft_rank_teams.rank, draft_rank_teams.players_ID, players.positionID, players.firstname, players.lastname, players.teamID from draft_rank_teams, players where players.ID=draft_rank_teams.players_ID and draft_rank_teams.teams_ID=$Teams_ID and draft_rank_teams.leagues_ID=$LEAGUEID $extra_logic $available_sql order by draft_rank_teams.rank ASC {$limit_sql};";

		$players_rs=$DB->Execute($sql);
		while(!($players_rs->EOF))
		{
			$current_players_ID=$players_rs->fields("players_ID");
			$current_players_rank=$players_rs->fields("rank");
			$current_players_positionID=$players_rs->fields("positionID");
			$current_players_firstname=$players_rs->fields("firstname");
			$current_players_lastname=$players_rs->fields("lastname");
			$current_players_teamID=$players_rs->fields("teamID");
			echo "<tr>";
			echo "<td>{$current_players_rank}</td>";
			echo "<td>{$current_players_lastname}, {$current_players_firstname}</td>";
			echo "<td>{$current_players_teamID}</td>";
			if(array_key_exists($current_players_positionID, $players_positions_array))
			{
				$current_position_description=$players_positions_array[$current_players_positionID];
			}
			else
			{
				$current_position_description=$current_players_positionID;
			}
			echo "<td>{$current_position_description}</td>";

			if($Position=="All")
			{
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=up&Move_Number=1&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_up_1.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=up&Move_Number=5&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_up_5.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=up&Move_Number=10&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_up_10.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=up&Move_Number=50&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_up_50.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=down&Move_Number=1&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_down_1.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=down&Move_Number=5&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_down_5.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=down&Move_Number=10&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_down_10.gif' border='0'></a></td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_draft_rank&Players_ID=$current_players_ID&Page=$Page&Move=down&Move_Number=50&Position=$Position'><img src='{$PHPFFL_IMAGE_PATH}arrow_down_50.gif' border='0'></a></td>";
			}
			echo "</tr>";
			$players_rs->MoveNext();
		}
		echo "</table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td>".ADMIN_SETUP_STARTING_LINEUP_REQUIREMENTS."</td></tr>";
		echo "</table>";
	}


}

function check_draft_rank_sequence($Teams_ID)
{
	global $DB, $LEAGUEID;
	//Check to make sure players are in sequential order for positions in league
	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";
	$positions_rs=$DB->Execute($sql);
	$extra_logic=$extra_logic."and (0=1 ";
	while(!($positions_rs->EOF))
	{
		$positions_type=$positions_rs->fields("type");
		$players_positionID=$positions_rs->fields("players_positionID");
		$players_positionID_array=explode(":", $players_positionID);
		foreach($players_positionID_array as $key => $val)
		{
			if(strlen($val)>0)
			{
				$extra_logic=$extra_logic."or positionID='$val'";
			}
		}

		$positions_rs->MoveNext();
	}
	$extra_logic=$extra_logic.")";
	$sql="select draft_rank_teams.rank, draft_rank_teams.players_ID from draft_rank_teams, players where players.ID=draft_rank_teams.players_ID and draft_rank_teams.teams_ID=$Teams_ID and draft_rank_teams.leagues_ID=$LEAGUEID $extra_logic order by draft_rank_teams.rank ASC;";
	$players_rs=$DB->Execute($sql);
	$previous_rank=0;
	$redo_rank=0;
	while(!($players_rs->EOF) && $redo_rank==0)
	{
		$current_players_rank=$players_rs->fields("rank");
		$previous_rank++;
		if($current_players_rank!=$previous_rank)
		{
			$redo_rank=1;
		}
		$players_rs->MoveNext();
	}
	if($redo_rank==1)
	{

		$players_processed=array();
		$players_rs->MoveFirst();
		$rank=1;
		while(!($players_rs->EOF))
		{
			$current_players_ID=$players_rs->fields("players_ID");
			$sql="update draft_rank_teams set rank=$rank where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and players_ID='$current_players_ID' order by rank ASC;";
			$DB->Execute($sql);
			$players_processed[$rank]=$current_players_ID;
			$rank++;
			$players_rs->MoveNext();
		}
		$sql="select players_ID from draft_rank_teams where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID order by rank ASC;";
		$rank_rs=$DB->Execute($sql);
		while(!($rank_rs->EOF))
		{
			$current_players_ID=$rank_rs->fields("players_ID");
			if(!(in_array($current_players_ID, $players_processed)))
			{
				$sql="update draft_rank_teams set rank=$rank where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and players_ID='$current_players_ID' order by rank ASC;";
				$DB->Execute($sql);
				$players_processed[$rank]=$current_players_ID;
				$rank++;
			}
			$rank_rs->MoveNext();

		}
	}
	$sql="select max(draft_rank_teams.rank) as max_rank from draft_rank_teams, players where players.ID=draft_rank_teams.players_ID and draft_rank_teams.teams_ID=$Teams_ID and draft_rank_teams.leagues_ID=$LEAGUEID $extra_logic order by draft_rank_teams.rank ASC;";
	$players_rs=$DB->Execute($sql);
	$max_rank=$players_rs->fields("max_rank");
	return $max_rank;

}

function display_target_picks_position($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;


	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";

	$positions_rs=$DB->Execute($sql);
	$positions_type_array=array();
	$positions_rs->MoveFirst();
	while(!($positions_rs->EOF))
	{
		$positions_ID=$positions_rs->fields("ID");
		$positions_type=$positions_rs->fields("type");
		$positions_type_array[$positions_ID]=$positions_type;
		$positions_rs->MoveNext();
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".ROUND."</span></td>";
	echo "<td><span class='table_row_title'>".PICK."</span></td>";
	echo "<td><span class='table_row_title'>".TARGET."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
	$sql="select ID, round, pick from draft where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID order by display_order ASC;";
	$draft_rs=$DB->Execute($sql);
	while(!($draft_rs->EOF))
	{
		$draft_ID=$draft_rs->fields("ID");
		$draft_round=$draft_rs->fields("round");
		$draft_pick=$draft_rs->fields("pick");
		$current_target="";
		$sql="select positions_ID from draft_teams_target_position where round=$draft_round and pick=$draft_pick and teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
		$target_rs=$DB->Execute($sql);
		if(!($target_rs->EOF))
		{
			$current_target=$target_rs->fields("positions_ID");
		}
		echo "<tr>";
		echo "<td>$draft_round</td>";
		echo "<td>$draft_pick</td>";
		echo "<td>";
		echo "<select name='Target_Position[$draft_ID]'>";
		echo "<option value='0'>".BEST_AVAILABLE."</option>";
		foreach($positions_type_array as $key => $val)
		{
			$s="";
			if($key==$current_target)
			{
				$s="selected";
			}
			echo "<option value='$key' $s>$val</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		$draft_rs->MoveNext();
	}
	echo "<tr><td><input type='Submit' name='Submit' value='".SUBMIT."'></td></tr>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='update_target_picks_position'>";
	echo "</form>";
	echo "</table>";

}
?>