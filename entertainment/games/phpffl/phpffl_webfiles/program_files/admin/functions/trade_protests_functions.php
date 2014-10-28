<?php

function trade_protests_main()
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='6'><span class='main_title'>".TRADE_PROTESTS."</span></td></tr>";
	$current_est_date=get_current_EST_date();
	
	$sql="select trades.*, trade_protests.protest_date, trade_protests.protest_users_ID, trade_protests.users_comments from trades, trade_protests where trades.ID=trade_protests.trades_ID and protest_status='Pending' and leagues_ID=$LEAGUEID order by protest_date DESC;";
	$trades_rs=$DB->Execute($sql);
	if(!($trades_rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".PROTEST_DATE."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td>".USER." / ".COMMENTS."</td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
		$current_date=gmdate("Y-m-d H:i:s");
		$bg="";
		while(!($trades_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$trades_ID=$trades_rs->fields("ID");
			
			$protest_date=$trades_rs->fields("protest_date");
			$protest_date_date_display=display_users_time($protest_date, "F, d Y");
			$team1_ID=$trades_rs->fields("team1_ID");
			$team1_name=get_team_name($team1_ID);
			$team2_ID=$trades_rs->fields("team2_ID");
			$team2_name=get_team_name($team2_ID);
			$players_traded_array_team1=get_players_trade_array($trades_ID, $team1_ID);
			$players_traded_array_team2=get_players_trade_array($trades_ID, $team2_ID);
			$protest_users_ID=$trades_rs->fields("protest_users_ID");
			$protest_comments=$trades_rs->fields("users_comments");
			$sql="select first_name, last_name from users where ID=$protest_users_ID;";
			$users_rs=$DB->Execute($sql);
			$users_name=NA;
			if(!($users_rs->EOF))
			{
				$firstname=$users_rs->fields("first_name");
				$lastname=$users_rs->fields("last_name");
				$users_name="{$firstname} {$lastname}";
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td>$protest_date_date_display</td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><span class='table_row_title'>$team1_name</span></td></tr>";
			foreach($players_traded_array_team1 as $key => $val)
			{
				echo "<tr><td>$val</td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><span class='table_row_title'>$team2_name</span></td></tr>";
			foreach($players_traded_array_team2 as $key => $val)
			{
				echo "<tr><td>$val</td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td><span class='table_row_title'>$users_name</span><br>$protest_comments</td>";
			echo "<td>";
			echo "<table>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=approve_protest&Trades_ID=$trades_ID'>".APPROVE."</a></td></tr>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=reject_protest&Trades_ID=$trades_ID'>".REJECT."</a></td></tr>";
			echo "</table>";
			echo "</td>";
			echo "</tr>";
			$trades_rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_TRADE_PROTEST_ACTIVITY."</span></td></tr>";
	}

	echo "</table>";
}



?>
