<?php 

function display_leagues_trades_main($Order_By="DESC")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $PHPFFL_IMAGE_PATH;

	if(strlen($Order_By)<1)
	{
		$Order_By="DESC";
	}
	if($Order_By=="ASC")
	{
		$New_Order_By="DESC";
		$image="arrow_down.gif";
	}
	else
	{
		$New_Order_By="ASC";
		$image="arrow_up.gif";
	}

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$current_est_date=get_current_EST_date();
	$sql="select trade_deadline, days_protest_trade from leagues where ID=$LEAGUEID;";
	$tradedate_rs=$DB->Execute($sql);
	$trade_date_display=NA;
	$days_protest_trade=0;
	if(!($tradedate_rs->EOF))
	{
		$Trade_Date=$tradedate_rs->fields("trade_deadline");
		$days_protest_trade=$tradedate_rs->fields("days_protest_trade");
		if(strlen($Trade_Date)>5)
		{
			$year=substr($Trade_Date,0,4);
			$month=substr($Trade_Date,5, 2);
			$day=substr($Trade_Date,8,2); 
			$hour=substr($Trade_Date,11,2);
			$minute=substr($Trade_Date,14, 2);
			$second=substr($Trade_Date,17,2); 
			
			$trade_timestamp=mktime($hour,$minute, $second, $month, $day,$year);
			$trade_date_display=date("F, d Y H:i:s", $trade_timestamp);
		}
	}
	echo "<tr><td colspan='6'><span class='table_row_title'>".TRADE_DEADLINE." (EST): $trade_date_display</span></td></tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$sql="select * from trades where team2_approval_status='Approved' and leagues_ID=$LEAGUEID order by team2_approval_date {$Order_By};";
	$trades_rs=$DB->Execute($sql);
	if(!($trades_rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Action=trades_main&Mode=$Mode&Order_By=$New_Order_By'>".DATE."</a></span><br /><img src='{$PHPFFL_IMAGE_PATH}{$image}' /></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS_TRADED."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS_TRADED."</span></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		$current_date=gmdate("Y-m-d H:i:s");
		$bg="";
		while(!($trades_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$trades_ID=$trades_rs->fields("ID");
			$team1_date_entered=$trades_rs->fields("team1_date_entered");
			$team1_date_entered_display=display_users_time($team1_date_entered,0, "F, d Y");
			$team2_approval_date=$trades_rs->fields("team2_approval_date");
			$team2_approval_date_display=display_users_time($team2_approval_date, 0, "F, d Y");
			$year=substr($team2_approval_date,0,4);
			$month=substr($team2_approval_date,5, 2);
			$day=substr($team2_approval_date,8,2); 
			$hour=substr($team2_approval_date,11,2);
			$minute=substr($team2_approval_date,14, 2);
			$second=substr($team2_approval_date,17,2); 
			$protest_approval_date_timestamp=mktime($hour,$minute, $second, $month, $day+$days_protest_trade,$year);
			$protest_approval_date=date("Y-m-d H:i:s", $protest_approval_date_timestamp);
			$team1_ID=$trades_rs->fields("team1_ID");
			$team1_name=get_team_name($team1_ID);
			$team2_ID=$trades_rs->fields("team2_ID");
			$team2_name=get_team_name($team2_ID);
			$players_traded_array_team1=get_players_trade_array($trades_ID, $team1_ID);
			$players_traded_array_team2=get_players_trade_array($trades_ID, $team2_ID);
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>$team2_approval_date_display</span></td>";
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
			if(strlen($USERSID)>0)
			{
				if(is_user_in_league($USERSID, $LEAGUEID))
				{
					if($current_date<=$protest_approval_date)
					{
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=protest_trade&Trades_ID=$trades_ID' class='table_data_normal'>".PROTEST_TRADE."</a></td>";
					}
				}
			}
			echo "</tr>";
			$trades_rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_TRADE_ACTIVITY."</span></td></tr>";
	}

	echo "</table>";
}


function display_protest_trade($Trades_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='main_title'>".PROTEST_TRADE."</span></td></tr>";
	echo "<tr><td colspan='2'>";
	display_trade_detail($Trades_ID);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".COMMENTS."</td>";
	echo "<td><textarea name='Comments' rows='10' cols='35'></textarea></td>";
	echo "</tr>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Action' value='confirm_protest_trade'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Trades_ID' value='$Trades_ID'>";
	echo "</table>";
	echo "</form>";

}



?>
