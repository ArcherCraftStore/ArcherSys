<?php

function waiver_wire_main($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;

	$sql="select * from waiver_wire where teams_ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='6'><span class='main_title'>".WAIVER_WIRE."</span></td></tr>";
	$current_est_date=get_current_EST_date();
	$sql="select waiver_deadline from leagues where ID=$LEAGUEID;";
	$waiverdate_rs=$DB->Execute($sql);
	$waiver_date_display=NA;
	if(!($waiverdate_rs->EOF))
	{
		$Waiver_Date=$waiverdate_rs->fields("waiver_deadline");
		if(strlen($Waiver_Date)>5)
		{
			$year=substr($Waiver_Date,0,4);
			$month=substr($Waiver_Date,5, 2);
			$day=substr($Waiver_Date,8,2);
			$hour=substr($Waiver_Date,11,2);
			$minute=substr($Waiver_Date,14, 2);
			$second=substr($Waiver_Date,17,2);

			$waiver_timestamp=mktime($hour,$minute, $second, $month, $day,$year);
			$waiver_date_display=date("F, d Y H:i:s", $waiver_timestamp);
		}
	}
	echo "<tr><td colspan='6'><span class='table_row_title'>".WAIVER_WIRE_DEADLINE." (EST): $waiver_date_display</span></td></tr>";
	$sql="select waiver_deadline from leagues where ID=$LEAGUEID and waiver_deadline>'$current_est_date';";
	$waiverdate_rs=$DB->Execute($sql);
	if(!($waiverdate_rs->EOF))
	{
		echo "<tr><td colspan='6'><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search'>".REQUEST_A_PLAYER."</a></td></tr>";
	}

	if(!($rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>#</span></td>";
		echo "<td><span class='table_row_title'>".DATE_REQUESTED."</span></td>";
		echo "<td><span class='table_row_title'>".WAIVE."</span></td>";
		echo "<td><span class='table_row_title'>".PICK_UP."</span></td>";
		echo "<td><span class='table_row_title'>".STATUS."</span></td>";
		echo "<td><span class='table_row_title'>".REMOVE."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
		$sql="select * from waiver_wire where teams_ID=$Teams_ID and approval_status='Approved' order by date_entered DESC;";
		$waiver_rs=$DB->Execute($sql);
		$number_of_waivers=1;
		$bg="";
		while(!($waiver_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$waiver_ID=$waiver_rs->fields("ID");
			$waiver_date=$waiver_rs->fields("date_entered");
			$waiver_waive=$waiver_rs->fields("waive_players_ID");
			$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
			$approval_status=$waiver_rs->fields("approval_status");
			if($approval_status=="Approved")
			{
				$approval_status=APPROVED;
			}
			elseif($approval_status=="Rejected")
			{
				$approval_status=REJECTED;
			}
			elseif($approval_status=="Pending")
			{
				$approval_status=PENDING;
			}
			$waiver_date=display_users_time($waiver_date);
			$waiver_waive_player_data=get_player_data_array($waiver_waive);
			$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
			$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
			$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>$number_of_waivers</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_date</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_waive_name</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_pickup_name</span></td>";
			echo "<td><span class='table_data_normal'>$approval_status</span></td>";
			echo "<td></td>";
			echo "</tr>";
			$number_of_waivers++;
			$waiver_rs->MoveNext();
		}


		$sql="select * from waiver_wire where teams_ID=$Teams_ID and approval_status='Pending' order by date_entered DESC;";
		$waiver_rs=$DB->Execute($sql);
		while(!($waiver_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$waiver_ID=$waiver_rs->fields("ID");
			$waiver_date=$waiver_rs->fields("date_entered");
			$waiver_waive=$waiver_rs->fields("waive_players_ID");
			$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
			$approval_status=$waiver_rs->fields("approval_status");
			$waiver_date=display_users_time($waiver_date);
			$waiver_waive_player_data=get_player_data_array($waiver_waive);
			$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
			$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
			$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>".NA."</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_date</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_waive_name</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_pickup_name</span></td>";
			echo "<td><span class='table_data_normal'>$approval_status</span></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_waiver_wire_request&WaiverWire_ID=$waiver_ID' class='table_data_normal'>".REMOVE_REQUEST."</a></td>";
			echo "</tr>";
			$number_of_waivers++;
			$waiver_rs->MoveNext();
		}

		$sql="select * from waiver_wire where teams_ID=$Teams_ID and approval_status='Rejected' order by date_entered DESC;";
		$waiver_rs=$DB->Execute($sql);
		while(!($waiver_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$waiver_ID=$waiver_rs->fields("ID");
			$waiver_date=$waiver_rs->fields("date_entered");
			$waiver_waive=$waiver_rs->fields("waive_players_ID");
			$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
			$approval_status=$waiver_rs->fields("approval_status");
			$waiver_date=display_users_time($waiver_date);
			$waiver_waive_player_data=get_player_data_array($waiver_waive);
			$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
			$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
			$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='table_data_normal'>".NA."</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_date</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_waive_name</span></td>";
			echo "<td><span class='table_data_normal'>$waiver_pickup_name</span></td>";
			echo "<td><span class='table_data_normal'>$approval_status</span></td>";
			echo "<td></td>";
			echo "</tr>";
			$number_of_waivers++;
			$waiver_rs->MoveNext();
		}



	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_WAIVER_ACTIVITY."</span></td></tr>";
	}
	echo "</table>";

}


function display_waiver_search_main($Teams_ID, $Search_Type="", $Search_Position="", $Current_Letter="", $OrderBy="", $SortBy="")
{

	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT;

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
	echo "<tr><td colspan='4'><span class='main_title'>".SEARCH_PLAYERS."</span></td></tr>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=waiver_wire_main'>".BACK."</a></td></tr>";
	echo "<tr>";
	echo "<input type='hidden' name='Search_Type' value='Available'>";
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
	echo "</tr>";
	echo "<input type='hidden' name='Action' value='request_player_search'>";
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
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>".SHOW_ALL."</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".SHOW_ALL."</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".NAME."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".NAME."</a></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POSITION."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POSITION."</a></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".LEAGUE_TEAM."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".LEAGUE_TEAM."</a></td>";
	}

	if($Search_Type=="Owned")
	{
		if($OrderBy=="current_teams_ID")
		{
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=current_teams_ID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".TEAM."</a>";
			echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
			echo "</td>";
		}
		else
		{
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=current_teams_ID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".TEAM."</a></td>";
		}
	}

	if($OrderBy=="points")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=points&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POINTS."</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=points&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position'>".POINTS."</a></td>";
	}
	echo "<td></td>";
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
			$extra_logic=$extra_logic."or positionID='$positions_type'";
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
	$players_need_clear_waivers=get_players_need_clear_waivers();
	if(is_array($players_array))
	{
		foreach($players_array as $key => $val)
		{
			$sql="select ID from waiver_wire where teams_ID=$Teams_ID and pickup_players_ID='$key' and approval_status='Pending';";
			$waiver_rs=$DB->Execute($sql);
			$already_requested=false;
			if(!($waiver_rs->EOF))
			{
				$already_requested=true;
			}
			$sql="select * from players where ID='$key';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF) && !($already_requested))
			{
				$bg=get_row_bg($bg);
				$players_ID=$rs->fields("ID");
				$lastname=$rs->fields("lastname");
				$firstname=$rs->fields("firstname");
				$team=$rs->fields("teamID");
				if(in_array($players_ID, $players_need_clear_waivers))
				{
					$css_class="clear_waivers_data_large";
				}
				else
				{
					$css_class="table_data_large";
				}
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
				echo "<td><span class='{$css_class}'><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Printable=1&height=600&width=950' class='thickbox'>$lastname, $firstname</a></span></td>";
				echo "<td><span class='{$css_class}'>$position</span></td>";
				echo "<td><span class='{$css_class}'>$team</span></td>";
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
					echo "<td><span class='{$css_class}'>$Team_Name</span></td>";
				}
				echo "<td><span class='{$css_class}'>$total_fantasy_points</td>";
				echo "<td><span class='{$css_class}'><a href='$PHP_SELF?Mode=$Mode&Action=request_player&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".REQUEST_PLAYER."</a></span></td>";
				echo "</tr>";
				$rs->MoveNext();
			}
		}
		$bg=get_row_bg($bg);
		echo "<tr bgcolor='$bg'>";
		echo "<td><span class='{$css_class}'>".NONE."</span></td>";
		echo "<td><span class='{$css_class}'>".NA."</span></td>";
		echo "<td><span class='{$css_class}'>".NA."</span></td>";
		if($Search_Type=="Owned")
		{
			echo "<td><span class='{$css_class}'>".NA."</span></td>";
		}
		echo "<td><span class='{$css_class}'>".NA."</td>";
		echo "<td><span class='{$css_class}'><a href='$PHP_SELF?Mode=$Mode&Action=request_player&Players_ID=0&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".REQUEST_PLAYER."</a></span></td>";
		echo "</tr>";
	}
	echo "</table>";
}


function display_request_player($Players_ID, $Teams_ID, $Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT;

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='4'><span class='main_title'>".REQUEST_PLAYER."</span></td></tr>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=request_player_search&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position'>".BACK."</a></td></tr>";
	$requested_players_data=get_player_data_array($Players_ID);
	$requested_players_name="{$requested_players_data['lastname']}, {$requested_players_data['firstname']}";
	$requested_players_teamID=$requested_players_data["teamID"];
	$requested_players_positionID=$requested_players_data["positionID"];
	echo "<tr>";
	echo "<td><span class='table_row_title'>".NAME."</span></td>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	echo "<tr>";
	echo "<td>$requested_players_name</td>";
	echo "<td>$requested_players_teamID</td>";
	echo "<td>$requested_players_positionID</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><span class='table_row_title'>".DROP_PLAYER."</span></td>";
	echo "<td colspan='2'>";
	echo "<select name='Drop_Players_ID'>";
	$sql="select players_ID from rosters, players where players_ID=players.ID and current_teams_ID=$Teams_ID order by lastname ASC, firstname ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_players_ID=$rs->fields("players_ID");
		$player_locked=is_player_locked($current_players_ID, $LEAGUEID);
		if(!($player_locked))
		{
			$current_players_data=get_player_data_array($current_players_ID);
			$current_players_name="{$current_players_data['lastname']}, {$current_players_data['firstname']}";
			echo "<option value='$current_players_ID'>$current_players_name</option>";
		}
		$rs->MoveNext();
	}
	echo "<option value='0'>".NONE."</option>";
	echo "</select>";
	echo "</td>";
	echo "</tr>";
	echo "<tr><td><span class='table_row_title'>".COMMENTS."</span></td><td colspan='2'><textarea name='Waiver_Comments' rows='4' cols='30'></textarea></td></tr>";
	echo "<tr><td colspan='3'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Action' value='confirm_request_player'>";
	echo "<input type='hidden' name='Players_ID' value='$Players_ID'>";
	echo "<input type='hidden' name='Search_Type' value='$Search_Type'>";
	echo "<input type='hidden' name='Search_Position' value='$Search_Position'>";
	echo "<input type='hidden' name='Current_Letter' value='$Current_Letter'>";
	echo "<input type='hidden' name='OrderBy' value='$OrderBy'>";
	echo "<input type='hidden' name='SortBy' value='$SortBy'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</table>";
	echo "</form>";
}

?>