<?php

function display_draft_order($Round="", $Style="", $New_Action="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $PHPFFL_IMAGE_PATH;

	$current_date=gmdate("Y-m-d H:i:s");
	$sql="select draft_date, draft_length_rounds from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$draft_date=$rs->fields("draft_date");
		$draft_length_rounds=$rs->fields("draft_length_rounds");
		$draft_date_display=display_users_time($draft_date);
	}
	if(strlen($New_Action)<1)
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='thirteen_title'>".DRAFT_DATE.": $draft_date_display</span></td><td rowspan='2' valign='top'><a href='$PHP_SELF?Action=$Action&Mode=$Mode&Round=$Round&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td></tr>";
		echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=view_future_draft_info'>".VIEW_FUTURE_DRAFT_INFORMATION."</a></td></tr>";
		echo "</table>";
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".ROUND."</span></td>";
	echo "<td>";
	echo "<select name='Round'>";
	echo "<option value='view_all'>".SHOW_ALL."</option>";
	for($i=1;$i<=$draft_length_rounds;$i++)
	{
		$s="";
		if($Round==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
	echo "</tr>";
	echo "<input type='hidden' name='Style' value='$Style'>";
	if(strlen($New_Action)<1)
	{
		echo "<input type='hidden' name='Action' value='draft_main'>";
	}
	else
	{
		echo "<input type='hidden' name='Action' value='$New_Action'>";
	}
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".ROUND."</span></td>";
	echo "<td><span class='table_row_title'>".PICK."</span></td>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	if($current_date>$draft_date)
	{
		echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
		echo "<td><span class='table_row_title'>".POSITION."</span></td>";
		echo "<td><span class='table_row_title'>".LEAGUE_TEAM."</span></td>";
	}
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
	if(strlen($Round)<1 || $Round=="view_all")
	{
		$sql="select * from draft where leagues_ID=$LEAGUEID order by display_order ASC;";
	}
	else
	{
		$sql="select * from draft where leagues_ID=$LEAGUEID and round=$Round order by display_order ASC;";
	}
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$teams_ID=$rs->fields("teams_ID");
			$team_name=get_team_name($teams_ID);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$round</td>";
			echo "<td>$pick</td>";
			echo "<td>$team_name</td>";
			if($current_date>$draft_date)
			{
				$players_ID=$rs->fields("players_ID");
				$players_name="N/A";
				$players_position="N/A";
				$players_team="N/A";
				if(strlen($players_ID)>0)
				{
					$player_data=get_player_data_array($players_ID);
					$players_name="{$player_data['firstname']} {$player_data['lastname']}";
					$players_position="{$player_data['positionID']}";
					$players_team="{$player_data['teamID']}";
				}
				echo "<td>$players_name</td>";
				echo "<td>$players_position</td>";
				echo "<td>$players_team</td>";
			}
			echo "</tr>";
			$rs->MoveNext();
		}

	}
	else
	{
		echo "<tr><td colspan='6'><span class='table_row_title'>Draft information not yet available.</span></td></tr>";
	}
	echo "</table>";

}

function display_view_future_draft_info($Teams_ID="", $Draft_Year="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;

	$sql="select draft_pick_trades_future_years, draft_length_rounds from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$future_years=$rs->fields("draft_pick_trades_future_years");
		$draft_length_rounds=$rs->fields("draft_length_rounds");
	}
	$Draft_Year_Start=get_draft_year($LEAGUEID);
	$Draft_Year_End=$Draft_Year_Start+$future_years-1;
	if(strlen($Draft_Year)<1)
	{
		$Draft_Year=$Draft_Year_Start;
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=draft_main'>".BACK."</a></td></tr>";

	echo "<tr>";
	echo "<td><span class='table_row_title'>".SELECT_TEAM."</td><td>";
	echo "<select name='Teams_ID'>";
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$teams_rs=$DB->Execute($sql);
	while(!($teams_rs->EOF))
	{
		$current_teams_ID=$teams_rs->fields("ID");
		$current_team_name=$teams_rs->fields("team_name");
		$s="";
		if($current_teams_ID==$Teams_ID)
			$s="selected";
		echo "<option value='$current_teams_ID' $s>$current_team_name</option>";
		$teams_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><span class='table_row_title'>".SELECT_YEAR."</td><td>";
	echo "<select name='Draft_Year'>";
	while($Draft_Year_Start<=$Draft_Year_End)
	{
		$s="";
		if($Draft_Year_Start==$Draft_Year)
			$s="selected";
		echo "<option value='$Draft_Year_Start'>$Draft_Year_Start</option>";
		$Draft_Year_Start++;
	}
	echo "</select>";
	echo "</td><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Action' value='view_future_draft_info'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";

	if(strlen($Draft_Year)>0 && strlen($Teams_ID)>0 )
	{
		$bg="";
		$team_name=get_team_name($Teams_ID);
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'>".ROUND."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		for($i=1;$i<=$draft_length_rounds;$i++)
		{

			$sql="select ID from teams_traded_picks where traded_pick_teams_ID=$Teams_ID and pick_round=$i and pick_year=$Draft_Year;";
			$pick_rs=$DB->Execute($sql);
			if($pick_rs->EOF)
			{

				$bg=get_row_bg($bg);
				echo "<tr bgcolor='$bg'>";
				echo "<td>$team_name</td>";
				echo "<td>$i</td>";
				echo "</tr>";
				$pick_count++;
			}
		}
		$sql="select * from teams_traded_picks where current_teams_ID=$Teams_ID and pick_year=$Draft_Year order by pick_round ASC;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$pick_teams_ID=$rs->fields("traded_pick_teams_ID");
			$pick_round=$rs->fields("pick_round");
			$pick_teams_name=get_team_name($pick_teams_ID);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$pick_teams_name</td>";
			echo "<td>$pick_round</td>";
			echo "</tr>";
			$pick_count++;
			$rs->MoveNext();
		}
		echo "</table>";
	}

}





?>
