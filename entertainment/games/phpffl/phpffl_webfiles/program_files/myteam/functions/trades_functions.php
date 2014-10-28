<?php 

function display_trades_main($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='6'><span class='main_title'>".TRADES."</span></td></tr>";
	$current_est_date=get_current_EST_date();
	$sql="select trade_deadline, allow_trade_cancellations from leagues where ID=$LEAGUEID;";
	$tradedate_rs=$DB->Execute($sql);
	$trade_date_display=NA;
	if(!($tradedate_rs->EOF))
	{
		$allow_trade_cancellations=$tradedate_rs->fields("allow_trade_cancellations");
		$Trade_Date=$tradedate_rs->fields("trade_deadline");
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
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=view_trade_protests'>".VIEW_TRADE_PROTESTS."</a></td></tr>";
	echo "</table>";
	$sql="select trade_deadline from leagues where ID=$LEAGUEID and trade_deadline>'$current_est_date';";
	$tradedate_rs=$DB->Execute($sql);
	if(!($tradedate_rs->EOF))
	{
		$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID and ID<>$Teams_ID order by team_name ASC;";
		$teams_rs=$DB->Execute($sql);
		if(!($teams_rs->EOF))
		{
			echo "<form method='post' action='$PHP_SELF?'>";
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><span class='table_row_title'>".PROPOSE_TRADE."</span></td>";
			echo "<td>";
			echo "<select name='Team2_ID'>";
			while(!($teams_rs->EOF))
			{
				$current_teams_ID=$teams_rs->fields("ID");
				$current_teams_name=$teams_rs->fields("team_name");
				echo "<option value='$current_teams_ID'>$current_teams_name</option>";
				$teams_rs->MoveNext();
			}
			echo "</select>";
			echo "</td>";
			echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
			echo "<input type='hidden' name='Action' value='propose_trade'>";
			echo "<input type='hidden' name='Mode' value='$Mode'>";
			echo "<input type='hidden' name='Team1_ID' value='$Teams_ID'>";
			echo "</table>";
			echo "</form>";
			echo "<br>";
		}
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$sql="select * from trades where team1_ID=$Teams_ID or team2_ID=$Teams_ID and leagues_ID=$LEAGUEID order by team1_date_entered DESC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".DATE."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS_TRADED."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS_TRADED."</span></td>";
		echo "<td><span class='table_row_title'>".STATUS."</span></td>";
		echo "<td><span class='table_row_title'>".EXPIRATION_DATE."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
		$current_date=gmdate("Y-m-d H:i:s");
		$sql="select * from trades where team1_ID=$Teams_ID or team2_ID=$Teams_ID and leagues_ID=$LEAGUEID order by team1_date_entered DESC;";
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
			$expiration_date_display=display_users_time($expiration_date);
			$team1_ID=$trades_rs->fields("team1_ID");
			$team1_name=get_team_name($team1_ID);
			$team2_ID=$trades_rs->fields("team2_ID");
			$team2_name=get_team_name($team2_ID);
			$team2_approval_status=$trades_rs->fields("team2_approval_status");
			if($team2_approval_status=="Approved")
			{
				$team2_approval_status_display=APPROVED;
			}
			elseif($team2_approval_status=="Rejected")
			{
				$team2_approval_status_display=REJECTED;
			}
			elseif($team2_approval_status=="Pending")
			{
				$team2_approval_status_display=PENDING;
			}
			elseif($team2_approval_status=="Expired")
			{
				$team2_approval_status_display=EXPIRED;
			}
			elseif($team2_approval_status=="Cancelled")
			{
				$team2_approval_status_display=CANCELLED;
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
			if($team2_ID==$Teams_ID && $team2_approval_status=="Pending" && $expiration_date>=$current_date)
			{
				echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=accept_trade&Trades_ID=$trades_ID' class='table_data_normal'>".ACCEPT."</a></td></tr>";
				echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=reject_trade&Trades_ID=$trades_ID' class='table_data_normal'>".REJECT."</a></td></tr>";
			}
			elseif($team1_ID==$Teams_ID && $team2_approval_status=="Pending" && $expiration_date>=$current_date && $allow_trade_cancellations=="Yes")
			{
				echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=cancel_trade&Trades_ID=$trades_ID' class='table_data_normal'>".CANCEL."</a></td></tr>";
			
			}
			echo "</table>";
			echo "</td>";
			echo "<td><span class='table_data_normal'>$expiration_date_display</span></td>";
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

function get_players_trade_array($trades_ID, $teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	$players_traded_array=array();
	$sql="select players_ID, draft_pick_round, draft_pick_teams_ID, draft_pick_year from trades_teams_players where trades_ID=$trades_ID and teams_trading_ID=$teams_ID;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$players_ID=$rs->fields("players_ID");
		$draft_pick_round=$rs->fields("draft_pick_round");
		$draft_pick_teams_ID=$rs->fields("draft_pick_teams_ID");
		$draft_pick_year=$rs->fields("draft_pick_year");
		if(strlen($players_ID)>0)
		{
			$player_data=get_player_data_array($players_ID);
			$players_traded_array[]="{$player_data['firstname']} {$player_data['lastname']} - {$player_data['positionID']}, {$player_data['teamID']}";
		}
		else
		{
			$team_name=get_team_name($draft_pick_teams_ID);
			$players_traded_array[]="$team_name: ".ROUND." $draft_pick_round , $draft_pick_year";
		}
		$rs->MoveNext();
	}
	return $players_traded_array;
}

function display_propose_trade($Team1_ID, $Team2_ID, $Team1_Players, $Team2_Players, $Team1_Draft, $Team2_Draft, $Admin=0)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	$sql="select draft_pick_trades_future_years from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$future_draft_picks=$rs->fields("draft_pick_trades_future_years");
	}
	if(!(is_array($Team1_Players)))
	{
		$Team1_Players=explode(":", $Team1_Players);
	}
	if(!(is_array($Team2_Players)))
	{
		$Team2_Players=explode(":", $Team2_Players);
	}
	if(!(is_array($Team1_Draft)))
	{
		$Team1_Draft=explode(":", $Team1_Draft);
	}
	if(!(is_array($Team2_Draft)))
	{
		$Team2_Draft=explode(":", $Team2_Draft);
	}
	$Team1_Players_implode=implode(":", $Team1_Players);
	$Team2_Players_implode=implode(":", $Team2_Players);
	$Team1_Draft_implode=implode(":", $Team1_Draft);
	$Team2_Draft_implode=implode(":", $Team2_Draft);
	$team1_team_name=get_team_name($Team1_ID);
	$team2_team_name=get_team_name($Team2_ID);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TRADE.": $team1_team_name</span></td>";
	echo "<td></td>";
	echo "<td><span class='table_row_title'>".RECEIVE.": $team2_team_name</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	echo "<tr>";
	echo "<td>";
	echo "<table>";
	$team1_count=0;
	if(is_array($Team1_Players))
	{
		foreach($Team1_Players as $key => $val)
		{
			if(strlen($val)>0)
			{
				
				$player_data=get_player_data_array($val);
				echo "<tr><td>{$player_data['firstname']} {$player_data['lastname']} - {$player_data['positionID']}, {$player_data['teamID']}</td>";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=trade&Remove_Player_ID=$val'>".REMOVE."</a></td></tr>";
				$team1_count++;
			}
		
		}
	}
	$team1_pick_count=0;
	if(is_array($Team1_Draft))
	{
		foreach($Team1_Draft as $key => $val)
		{
			if(strlen($val)>0)
			{
				$Team1_Draft_current=explode("|", $val);
				$current_teams_ID=$Team1_Draft_current[0];
				$current_pick_year=$Team1_Draft_current[1];
				$current_pick_round=$Team1_Draft_current[2];
				if(strlen($current_teams_ID)>0)
				{
					$current_team_name=get_team_name($current_teams_ID);
					echo "<tr><td>$current_team_name: ".ROUND." $current_pick_round, $current_pick_year</td>";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=trade&Remove_Pick_ID=$val'>".REMOVE."</a></td></tr>";
					$team1_pick_count++;
				}
			}
		
		
		}
	}
	if($team1_count==0 && $team1_pick_count==0)
	{
		echo "<tr><td>".NONE."</td></tr>";
	}
	
	
	echo "</table>";
	echo "</td>";
	echo "<td></td>";
	echo "<td>";
	echo "<table>";
	$team2_count=0;
	if(is_array($Team2_Players))
	{
		foreach($Team2_Players as $key => $val)
		{
			if(strlen($val)>0)
			{
				$player_data=get_player_data_array($val);
				echo "<tr><td>{$player_data['firstname']} {$player_data['lastname']} - {$player_data['positionID']}, {$player_data['teamID']}</td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=receive&Remove_Player_ID=$val'>".REMOVE."</a></td></tr>";
				$team2_count++;
			}
		
		}
	}
	$team2_pick_count=0;
	if(is_array($Team2_Draft))
	{
		foreach($Team2_Draft as $key => $val)
		{
			if(strlen($val)>0)
			{
				$Team2_Draft_current=explode("|", $val);
				$current_teams_ID=$Team2_Draft_current[0];
				$current_pick_year=$Team2_Draft_current[1];
				$current_pick_round=$Team2_Draft_current[2];
				if(strlen($current_teams_ID)>0)
				{
					$current_team_name=get_team_name($current_teams_ID);
					echo "<tr><td>$current_team_name: ".ROUND." $current_pick_round, $current_pick_year</td>";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=receive&Remove_Pick_ID=$val'>".REMOVE."</a></td></tr>";
					$team2_pick_count++;
				}
			}
		
		
		}
	}
	if($team2_count==0 && $team2_pick_count==0)
	{
		echo "<tr><td>".NONE."</td></tr>";
	}
	echo "</table>";
	echo "</td></tr>";
	echo "<tr>";
	echo "<tr>";
	echo "<td>";
	echo "<table>";
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=display_add_player_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=trade'>".ADD_PLAYER."</a></td></tr>";
	if($future_draft_picks>0)
	{
		echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=display_add_pick_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=trade'>".ADD_DRAFT_PICK."</a></td></tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "<td></td>";
	echo "<td>";
	echo "<table>";
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=display_add_player_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=receive'>".ADD_PLAYER."</a></td></tr>";
	if($future_draft_picks>0)
	{
		echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=display_add_pick_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode&Trade_Type=receive'>".ADD_DRAFT_PICK."</a></td></tr>";
	}
	echo "</table>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	if(($team1_count>0 || $team1_pick_count>0) && ($team2_count>0 || $team2_pick_count>0))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<input type='hidden' name='Team1_Players' value='$Team1_Players_implode'>";
		echo "<input type='hidden' name='Team2_Players' value='$Team2_Players_implode'>";
		echo "<input type='hidden' name='Team1_Draft' value='$Team1_Draft_implode'>";
		echo "<input type='hidden' name='Team2_Draft' value='$Team2_Draft_implode'>";
		echo "<input type='hidden' name='Team1_ID' value='$Team1_ID'>";
		echo "<input type='hidden' name='Team2_ID' value='$Team2_ID'>";
		echo "<input type='hidden' name='Action' value='propose_trade_confirmation'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "<tr>";
		if(!($Admin))
		{
			echo "<td>".DAYS_TO_ACCEPT_TRADE."</td>";
			echo "<td>";
			echo "<select name='Days_Valid'>";
			for($i=0;$i<=14;$i++)
			{
				$s="";
				if($i==1)
				{
					$s="selected";
				}
				echo "<option value='$i' $s>$i</option>";
			}
			echo "</select>";
			echo "</td>";

			echo "<td>".HOURS_TO_ACCEPT_TRADE."</td>";
			echo "<td>";
			echo "<select name='Hours_Valid'>";
			for($i=0;$i<=24;$i++)
			{
				echo "<option value='$i'>$i</option>";
			}
			echo "</select>";
			echo "</td>";
		}
		echo "<td><input type='Submit' name='Submit' value='".SUBMIT_TRADE."'></td></tr>";
		echo "</form>";
		echo "</table>";
	}
	
}

function display_add_player_trade($Team1_ID, $Team2_ID, $Team1_Players, $Team2_Players, $Team1_Draft, $Team2_Draft, $Trade_Type)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	if(!(is_array($Team1_Players)))
	{
		$Team1_Players=explode(":", $Team1_Players);
	}
	if(!(is_array($Team2_Players)))
	{
		$Team2_Players=explode(":", $Team2_Players);
	}
	if(!(is_array($Team1_Draft)))
	{
		$Team1_Draft=explode(":", $Team1_Draft);
	}
	if(!(is_array($Team2_Draft)))
	{
		$Team2_Draft=explode(":", $Team2_Draft);
	}
	$Team1_Players_implode=implode(":", $Team1_Players);
	$Team2_Players_implode=implode(":", $Team2_Players);
	$Team1_Draft_implode=implode(":", $Team1_Draft);
	$Team2_Draft_implode=implode(":", $Team2_Draft);
	
	if($Trade_Type=="trade")
	{
		$Display_Team_ID=$Team1_ID;
	}
	else
	{
		$Display_Team_ID=$Team2_ID;
	}
	$Display_Team_Name=get_team_name($Display_Team_ID);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='4'><span class='main_title'>".ADD_PLAYER_TO_TRADE."</span></td></tr>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode'>".BACK."</a></td></tr>";
	echo "<tr><td colspan='4'><span class='thirteen_title'>$Display_Team_Name</span></td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".PLAYER."</span></td>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		
	$sql="select players_ID from rosters where current_teams_ID=$Display_Team_ID;";
	$rs=$DB->Execute($sql);
	$player_count=0;
	if(!($rs->EOF))
	{
		while(!($rs->EOF))
		{
			
			$current_players_ID=$rs->fields("players_ID");
			$player_data=get_player_data_array($current_players_ID);
			
			if( !(is_player_locked($current_players_ID, $LEAGUEID)) && !(in_array($current_players_ID, $Team2_Players)) && !(in_array($current_players_ID, $Team1_Players)) )
			{
				$bg=get_row_bg($bg);
				$current_lastname=$player_data["lastname"];
				$current_firstname=$player_data["firstname"];
				$current_teamID=$player_data["teamID"];
				$current_positionID=$player_data["positionID"];
				
				if($Trade_Type=="trade")
				{
					if(strlen($Team1_Players_implode)>0)
					{
						$Team1_Players_implode_temp=$Team1_Players_implode.":{$current_players_ID}";
					}
					else
					{
						$Team1_Players_implode_temp="$current_players_ID";
					}
					$Team2_Players_implode_temp=$Team2_Players_implode;
				}
				else
				{
					if(strlen($Team2_Players_implode)>0)
					{
						$Team2_Players_implode_temp=$Team2_Players_implode.":{$current_players_ID}";
					}
					else
					{
						$Team2_Players_implode_temp="$current_players_ID";
					}
					$Team1_Players_implode_temp=$Team1_Players_implode;
				}
	
				echo "<tr bgcolor='$bg'>";
				echo "<td>$current_lastname, $current_firstname</td>";
				echo "<td>$current_teamID</td>";
				echo "<td>$current_positionID</td>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode_temp&Team2_Players=$Team2_Players_implode_temp&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode'>".ADD_PLAYER."</a></td>";
				echo "</tr>";
				$player_count++;
			}
			$rs->MoveNext();
		}
	}
	if($player_count<1)
	{
		echo "<tr><td><span class='table_row_title'>".NO_AVAILABLE_PLAYERS_ON_TEAM."</span></td></tr>";
	}
	echo "</table>";
	
}


function display_add_pick_trade($Team1_ID, $Team2_ID, $Team1_Players, $Team2_Players, $Team1_Draft, $Team2_Draft, $Trade_Type, $Trade_Year)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	$sql="select draft_pick_trades_future_years, draft_length_rounds from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$future_years=$rs->fields("draft_pick_trades_future_years");
		$draft_length_rounds=$rs->fields("draft_length_rounds");
	}
	if(!(is_array($Team1_Players)))
	{
		$Team1_Players=explode(":", $Team1_Players);
	}
	if(!(is_array($Team2_Players)))
	{
		$Team2_Players=explode(":", $Team2_Players);
	}
	if(!(is_array($Team1_Draft)))
	{
		$Team1_Draft=explode(":", $Team1_Draft);
	}
	if(!(is_array($Team2_Draft)))
	{
		$Team2_Draft=explode(":", $Team2_Draft);
	}
	$Team1_Players_implode=implode(":", $Team1_Players);
	$Team2_Players_implode=implode(":", $Team2_Players);
	$Team1_Draft_implode=implode(":", $Team1_Draft);
	$Team2_Draft_implode=implode(":", $Team2_Draft);
	
	$Trade_Year_Start=get_draft_year($LEAGUEID);
	$Trade_Year_End=$Trade_Year_Start+$future_years-1;
	if(strlen($Trade_Year)<1)
	{
		$Trade_Year=$Trade_Year_Start;
	}
	if($Trade_Type=="trade")
	{
		$Display_Team_ID=$Team1_ID;
	}
	else
	{
		$Display_Team_ID=$Team2_ID;
	}
	$Display_Team_Name=get_team_name($Display_Team_ID);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='4'><span class='main_title'>".ADD_DRAFT_PICK_TO_TRADE."</span></td></tr>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode&Team2_Draft=$Team2_Draft_implode'>".BACK."</a></td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".SELECT_YEAR."</td><td>";
	echo "<select name='Trade_Year'>";
	while($Trade_Year_Start<=$Trade_Year_End)
	{
		$s="";
		if($Trade_Year_Start==$Trade_Year)
			$s="selected";
		echo "<option value='$Trade_Year_Start' $s>$Trade_Year_Start</option>";
		$Trade_Year_Start++;
	}
	echo "</select>";
	echo "</td><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Team1_Players' value='$Team1_Players_implode'>";
	echo "<input type='hidden' name='Team2_Players' value='$Team2_Players_implode'>";
	echo "<input type='hidden' name='Team1_Draft' value='$Team1_Draft_implode'>";
	echo "<input type='hidden' name='Team2_Draft' value='$Team2_Draft_implode'>";
	echo "<input type='hidden' name='Team1_ID' value='$Team1_ID'>";
	echo "<input type='hidden' name='Team2_ID' value='$Team2_ID'>";
	echo "<input type='hidden' name='Trade_Type' value='$Trade_Type'>";
	echo "<input type='hidden' name='Action' value='display_add_pick_trade'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td><span class='table_row_title'>".ROUND."</span></td>";
	echo "<td></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	$bg="";
	for($i=1;$i<=$draft_length_rounds;$i++)
	{
		$sql="select ID from teams_traded_picks where traded_pick_teams_ID=$Display_Team_ID and pick_round=$i and pick_year=$Trade_Year;";
		$pick_rs=$DB->Execute($sql);
		if(!(in_array("$Display_Team_ID|$Trade_Year|$i", $Team1_Draft)) && !(in_array("$Display_Team_ID:$Trade_Year:$i", $Team2_Draft)) && $pick_rs->EOF)
		{
			if($Trade_Type=="trade")
			{
				if(strlen($Team1_Draft_implode)<1)
				{
					$Team1_Draft_implode_temp="$Team1_ID|$Trade_Year|$i";
				}
				else
				{
					$Team1_Draft_implode_temp=$Team1_Draft_implode.":$Team1_ID|$Trade_Year|$i";
				}
				$Team2_Draft_implode_temp=$Team2_Draft_implode;
			}
			else
			{
				if(strlen($Team2_Draft_implode)<1)
				{
					$Team2_Draft_implode_temp="$Team2_ID|$Trade_Year|$i";
				}
				else
				{
					$Team2_Draft_implode_temp=$Team2_Draft_implode.":$Team2_ID|$Trade_Year|$i";
				}
				$Team1_Draft_implode_temp=$Team1_Draft_implode;
			}
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$Display_Team_Name</td>";
			echo "<td>$i</td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode_temp&Team2_Draft=$Team2_Draft_implode_temp'>Add Pick</a></td>";
			echo "</tr>";
			$pick_count++;
		}
	}
	$sql="select * from teams_traded_picks where current_teams_ID=$Display_Team_ID and pick_year=$Trade_Year order by pick_round ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$pick_teams_ID=$rs->fields("traded_pick_teams_ID");
		$pick_round=$rs->fields("pick_round");
		$pick_teams_name=get_team_name($pick_teams_ID);
	
		if(!(in_array("$pick_teams_ID|$Trade_Year|$pick_round", $Team1_Draft)) && !(in_array("$pick_teams_ID:$Trade_Year:$pick_round", $Team2_Draft)) )
		{
			if($Trade_Type=="trade")
			{
				if(strlen($Team1_Draft_implode)<1)
				{
					$Team1_Draft_implode_temp="$pick_teams_ID|$Trade_Year|$pick_round";
				}
				else
				{
					$Team1_Draft_implode_temp=$Team1_Draft_implode.":$pick_teams_ID|$Trade_Year|$pick_round";
				}
				$Team2_Draft_implode_temp=$Team2_Draft_implode;
			}
			else
			{
				if(strlen($Team2_Draft_implode)<1)
				{
					$Team2_Draft_implode_temp="$pick_teams_ID|$Trade_Year|$pick_round";
				}
				else
				{
					$Team2_Draft_implode_temp=$Team2_Draft_implode.":$pick_teams_ID|$Trade_Year|$pick_round";
				}
				$Team1_Draft_implode_temp=$Team1_Draft_implode;
			}
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$pick_teams_name</td>";
			echo "<td>$pick_round</td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=propose_trade&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_ID=$Team1_ID&Team2_ID=$Team2_ID&Team1_Players=$Team1_Players_implode&Team2_Players=$Team2_Players_implode&Team1_Draft=$Team1_Draft_implode_temp&Team2_Draft=$Team2_Draft_implode_temp'>".ADD_DRAFT_PICK."</a></td>";
			echo "</tr>";
			$pick_count++;
		}
		$rs->MoveNext();
	}
	if($pick_count<1)
	{
		echo "<tr><td><span class='table_row_title'>".NO_AVAILABLE_DRAFT_PICKS_ON_TEAM."</span></td></tr>";
	}
	echo "</table>";
	
}

function display_confirm_trade_detail($Team1_ID, $Team2_ID, $Team1_Players, $Team2_Players, $Team1_Draft, $Team2_Draft, $Days_Valid="", $Hours_Valid="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	if(!(is_array($Team1_Players)))
	{
		$Team1_Players=explode(":", $Team1_Players);
	}
	if(!(is_array($Team2_Players)))
	{
		$Team2_Players=explode(":", $Team2_Players);
	}
	if(!(is_array($Team1_Draft)))
	{
		$Team1_Draft=explode(":", $Team1_Draft);
	}
	if(!(is_array($Team2_Draft)))
	{
		$Team2_Draft=explode(":", $Team2_Draft);
	}
	$Team1_Players_implode=implode(":", $Team1_Players);
	$Team2_Players_implode=implode(":", $Team2_Players);
	$Team1_Draft_implode=implode(":", $Team1_Draft);
	$Team2_Draft_implode=implode(":", $Team2_Draft);
	$team1_team_name=get_team_name($Team1_ID);
	$team2_team_name=get_team_name($Team2_ID);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='table_row_title'>".SURE_YOU_WANT_TO_SUBMIT_TRADE_OFFER."</span></td></tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TRADE.": $team1_team_name</span></td>";
	echo "<td></td>";
	echo "<td><span class='table_row_title'>".RECEIVE.": $team2_team_name</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	echo "<tr>";
	echo "<td>";
	echo "<table>";
	$team1_count=0;
	if(is_array($Team1_Players))
	{
		foreach($Team1_Players as $key => $val)
		{
			if(strlen($val)>0)
			{
				
				$player_data=get_player_data_array($val);
				echo "<tr><td>{$player_data['firstname']} {$player_data['lastname']} - {$player_data['positionID']}, {$player_data['teamID']}</td>";
					echo "</tr>";
				$team1_count++;
			}
		
		}
	}
	$team1_pick_count=0;
	if(is_array($Team1_Draft))
	{
		foreach($Team1_Draft as $key => $val)
		{
			if(strlen($val)>0)
			{
				$Team1_Draft_current=explode("|", $val);
				$current_teams_ID=$Team1_Draft_current[0];
				$current_pick_year=$Team1_Draft_current[1];
				$current_pick_round=$Team1_Draft_current[2];
				if(strlen($current_teams_ID)>0)
				{
					$current_team_name=get_team_name($current_teams_ID);
					echo "<tr><td>$current_team_name: ".ROUND." $current_pick_round, $current_pick_year</td>";
					echo "</tr>";
					$team1_pick_count++;
				}
			}
		
		
		}
	}
	if($team1_count==0 && $team1_pick_count==0)
	{
		echo "<tr><td>".NONE."</td></tr>";
	}
	
	
	echo "</table>";
	echo "</td>";
	echo "<td></td>";
	echo "<td>";
	echo "<table>";
	$team2_count=0;
	if(is_array($Team2_Players))
	{
		foreach($Team2_Players as $key => $val)
		{
			if(strlen($val)>0)
			{
				$player_data=get_player_data_array($val);
				echo "<tr><td>{$player_data['firstname']} {$player_data['lastname']} - {$player_data['positionID']}, {$player_data['teamID']}</td>";
				echo "</tr>";
				$team2_count++;
			}
		
		}
	}
	$team2_pick_count=0;
	if(is_array($Team2_Draft))
	{
		foreach($Team2_Draft as $key => $val)
		{
			if(strlen($val)>0)
			{
				$Team2_Draft_current=explode("|", $val);
				$current_teams_ID=$Team2_Draft_current[0];
				$current_pick_year=$Team2_Draft_current[1];
				$current_pick_round=$Team2_Draft_current[2];
				if(strlen($current_teams_ID)>0)
				{
					$current_team_name=get_team_name($current_teams_ID);
					echo "<tr><td>$current_team_name: ".ROUND." $current_pick_round, $current_pick_year</td>";
					echo "</tr>";
					$team2_pick_count++;
				}
			}
		
		
		}
	}
	if($team2_count==0 && $team2_pick_count==0)
	{
		echo "<tr><td>".NONE."</td></tr>";
	}
	echo "</table>";
	echo "</td></tr>";
	//Don't display when admin submits a trade.
	if(strlen($Days_Valid)>0)
	{
		echo "<tr><td colspan='4'>".DAYS_VALID.": {$Days_Valid}</td></tr>";
	}
	if(strlen($Hours_Valid)>0)
	{
		echo "<tr><td colspan='4'>".HOURS_VALID.": {$Hours_Valid}</td></tr>";
	}
	echo "</table>";
	
	echo "<table>";
	echo "<tr><td>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<input type='hidden' name='Team1_Players' value='$Team1_Players_implode'>";
	echo "<input type='hidden' name='Team2_Players' value='$Team2_Players_implode'>";
	echo "<input type='hidden' name='Team1_Draft' value='$Team1_Draft_implode'>";
	echo "<input type='hidden' name='Team2_Draft' value='$Team2_Draft_implode'>";
	echo "<input type='hidden' name='Team1_ID' value='$Team1_ID'>";
	echo "<input type='hidden' name='Team2_ID' value='$Team2_ID'>";
	echo "<input type='hidden' name='Action' value='confirm_propose_trade'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Days_Valid' value='$Days_Valid'>";
	echo "<input type='hidden' name='Hours_Valid' value='$Hours_Valid'>";
	echo "<tr>";
	echo "<td><input type='Submit' name='Submit' value='".SUBMIT_TRADE."'></td></tr>";
	echo "</form>";
	echo "</table>";
	echo "</td>";
	echo "<td>";
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<input type='hidden' name='Action' value='trades_main'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<tr>";
	echo "<td><input type='Submit' name='Submit' value='".CANCEL."'></td></tr>";
	echo "</form>";
	echo "</table>";
	echo "</td></tr>";
	echo "</table>";

}
function display_trade_detail($trades_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	
	$current_date=gmdate("Y-m-d H:i:s");
	$sql="select * from trades where ID=$trades_ID;";
	//echo "$sql<br>";
	//echo "$sql<br>";
	$trades_rs=$DB->Execute($sql);
	if(!($trades_rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		$trades_ID=$trades_rs->fields("ID");
		$team1_ID=$trades_rs->fields("team1_ID");
		$team1_name=get_team_name($team1_ID);
		$team2_ID=$trades_rs->fields("team2_ID");
		$team2_name=get_team_name($team2_ID);
		$team2_approval_status=$trades_rs->fields("team2_approval_status");
		$admin_reverse=$trades_rs->fields("admin_reverse");
		$players_traded_array_team1=get_players_trade_array($trades_ID, $team1_ID);
		$players_traded_array_team2=get_players_trade_array($trades_ID, $team2_ID);
		echo "<tr>";
		echo "<td><span class='table_row_title'>$team1_name</span></td>";
		echo "<td><span class='table_row_title'>$team2_name</span></td>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		echo "</tr>";
		echo "<tr><td>";
		echo "<table>";
		foreach($players_traded_array_team1 as $key => $val)
		{
			echo "<tr><td>$val</td></tr>";
		}
		echo "</table>";
		echo "</td>";
		echo "<td>";
		echo "<table>";
		foreach($players_traded_array_team2 as $key => $val)
		{
			echo "<tr><td>$val</td></tr>";
		}
		echo "</table>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
	}
}

function display_trade_protests($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='6'><span class='main_title'>".TRADE_PROTESTS."</span></td></tr>";
	$current_est_date=get_current_EST_date();
	
	$sql="select trades.*, trade_protests.protest_date, trade_protests.protest_users_ID, trade_protests.users_comments, trade_protests.protest_status from trades, trade_protests where trades.ID=trade_protests.trades_ID and protest_teams_ID=$Teams_ID and leagues_ID=$LEAGUEID order by protest_date DESC;";
	$trades_rs=$DB->Execute($sql);
	if(!($trades_rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".PROTEST_DATE."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM." / ".PLAYERS."</span></td>";
		echo "<td><span class='table_row_title'>".STATUS."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
		$current_date=gmdate("Y-m-d H:i:s");
		$bg="";
		while(!($trades_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$trades_ID=$trades_rs->fields("ID");
			
			$protest_date=$trades_rs->fields("protest_date");
			$protest_date_date_display=display_users_time($protest_date, 0, "F, d Y");
			$team1_ID=$trades_rs->fields("team1_ID");
			$team1_name=get_team_name($team1_ID);
			$team2_ID=$trades_rs->fields("team2_ID");
			$team2_name=get_team_name($team2_ID);
			$players_traded_array_team1=get_players_trade_array($trades_ID, $team1_ID);
			$players_traded_array_team2=get_players_trade_array($trades_ID, $team2_ID);
			$protest_status=$trades_rs->fields("protest_status");
			if($protest_status=="Approved")
			{
				$protest_status=APPROVED;
			}
			elseif($protest_status=="Rejected")
			{
				$protest_status=REJECTED;
			}
			$protest_comments=$trades_rs->fields("users_comments");
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>$protest_date_date_display</span></td>";
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
			echo "<td><span class='table_data_normal'>$protest_status</span></td>";
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

function update_expired_trades()
{
	global $DB;
	$gm_date=gmdate("Y-m-d H:i:s");
	
	$sql="update trades set team2_approval_status='Expired' where trade_expiration_date < '$gm_date' and team2_approval_status='Pending';";
	$DB->Execute($sql);
}
?>
