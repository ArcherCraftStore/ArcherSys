<?php 

function display_admin_trades_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=select_teams_trade'>".SUBMIT_TRADE."</a></td></tr>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$sql="select * from trades where leagues_ID=$LEAGUEID and team2_approval_status='Pending' order by team1_date_entered DESC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".DATE."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td><span class='table_row_title'>".STATUS."</span></td>";
		echo "<td><span class='table_row_title'>".EXPIRATION_DATE."</span></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='7'></td></tr>";
		$current_date=gmdate("Y-m-d H:i:s");
		$sql="select * from trades where leagues_ID=$LEAGUEID and team2_approval_status='Pending' order by team1_date_entered DESC;";
		//echo "$sql<br>";
		$bg="";
		$trades_rs=$DB->Execute($sql);
		while(!($trades_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$trades_ID=$trades_rs->fields("ID");
			$team1_date_entered=$trades_rs->fields("team1_date_entered");
			$team1_date_entered_display=display_users_time($team1_date_entered, 0, "F, d Y");
			$expiration_date=$trades_rs->fields("trade_expiration_date");
			$expiration_date_display=display_users_time($expiration_date, 0, "F, d Y H:i");
			$team1_ID=$trades_rs->fields("team1_ID");
			$team1_name=get_team_name($team1_ID);
			$team2_ID=$trades_rs->fields("team2_ID");
			$team2_name=get_team_name($team2_ID);
			$team2_approval_status=$trades_rs->fields("team2_approval_status");
			if($team2_approval_status=="Approved")
			{
				$team2_approval_status_display=APPROVED;
			}
			elseif($team2_approval_status_display=="Rejected")
			{
				$team2_approval_status=REJECTED;
			}
			elseif($team2_approval_status_display=="Pending")
			{
				$team2_approval_status=PENDING;
			}
			$admin_reverse=$trades_rs->fields("admin_reverse");
			$players_traded_array_team1=get_players_trade_array($trades_ID, $team1_ID);
			$players_traded_array_team2=get_players_trade_array($trades_ID, $team2_ID);
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>$team1_date_entered_display</span></td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><span class='table_row_title'>$team1_name</span></td></tr>";
			foreach($players_traded_array_team1 as $key => $val)
			{
				echo "<tr><td><span class='table_data_normal'>$val</span></td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><span class='table_row_title'>$team2_name</span></td></tr>";
			foreach($players_traded_array_team2 as $key => $val)
			{
				echo "<tr><td><span class='table_data_normal'>$val</span></td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><span class='table_data_normal'>$team2_approval_status_display</span></td></tr>";
			echo "</table>";
			echo "</td>";
			echo "<td><span class='table_data_normal'>$expiration_date_display</span></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=cancel_trade&Trades_ID=$trades_ID' class='table_data_normal'>".CANCEL."</a></td>";
			echo "</tr>";
			$trades_rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_PENDING_TRADES_DISPLAY."</span></td></tr>";
	}

	echo "</table>";
}

function display_admin_select_teams_trade($Team1_ID="", $Team2_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='main_title'>".SELECT_TEAMS_FOR_TRADE."</span></td></tr>";
	echo "</table>";
	
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$teams_rs=$DB->Execute($sql);
	if(!($teams_rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td>".TEAM_1.": </td><td>";
		
		if(!($teams_rs->EOF))
		{
			echo "<select name='Team1_ID'>";
			while(!($teams_rs->EOF))
			{
				$current_teams_ID=$teams_rs->fields("ID");
				$current_teams_name=$teams_rs->fields("team_name");
				$s="";
				if($Team1_ID==$current_teams_ID)
				{
					$s="selected";
				}
				echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
				$teams_rs->MoveNext();
			}
			echo "</select>";
		}
		echo "</td></tr>";
		
		echo "<tr><td>".TEAM_2.": </td><td>";
		$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
		$teams_rs=$DB->Execute($sql);
		if(!($teams_rs->EOF))
		{
			echo "<select name='Team2_ID'>";
			while(!($teams_rs->EOF))
			{
				$current_teams_ID=$teams_rs->fields("ID");
				$current_teams_name=$teams_rs->fields("team_name");
				$s="";
				if($Team2_ID==$current_teams_ID)
				{
					$s="selected";
				}
				echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
				$teams_rs->MoveNext();
			}
			echo "</select>";
		}
		echo "</td></tr>";
		
		echo "<tr><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type='hidden' name='Action' value='propose_trade'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</table>";
		echo "</form>";
	}
}


?>
