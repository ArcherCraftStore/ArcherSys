<?php 

function admin_waiver_wire_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	$sql="select * from waiver_wire where leagues_ID=$LEAGUEID and approval_status='Pending' order by pickup_players_ID ASC, date_entered DESC;";
	$waiver_rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if(!($waiver_rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'>".DATE_REQUESTED."</span></td>";
		echo "<td><span class='table_row_title'>".WAIVE."</span></td>";
		echo "<td><span class='table_row_title'>".PICK_UP."</span></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
		$bg="";
		$players_need_clear_waivers=get_players_need_clear_waivers();
		while(!($waiver_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$waiver_ID=$waiver_rs->fields("ID");
			$waiver_teams_ID=$waiver_rs->fields("teams_ID");
			$waiver_team_name=get_team_name($waiver_teams_ID);
			$waiver_date=$waiver_rs->fields("date_entered");
			$waiver_waive=$waiver_rs->fields("waive_players_ID");
			$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
			$approval_status=$waiver_rs->fields("approval_status");
			$waiver_date=display_users_time($waiver_date);
			$waiver_waive_player_data=get_player_data_array($waiver_waive);
			$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
			$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
			$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
			if(in_array($waiver_pickup, $players_need_clear_waivers))
			{
				$css_class="clear_waivers_data_normal";
			}
			else
			{
				$css_class="table_data_normal";
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='{$css_class}'>$waiver_team_name</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_date</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_waive_name</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_pickup_name</span></td>";
			echo "<td><span class='{$css_class}'><a href='$PHP_SELF?Mode=$Mode&Action=process_waiver&Waiver_ID=$waiver_ID&Approval_Status=Approve'>".APPROVE."</a></span></td>";
			echo "<td><span class='{$css_class}'><a  href='$PHP_SELF?Mode=$Mode&Action=process_waiver&Waiver_ID=$waiver_ID&Approval_Status=Reject'>".REJECT."</a></span></td>";
			echo "</tr>";
			$number_of_waivers++;
			$waiver_rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td>".NO_WAIVERS_PENDING."</td></tr>";
	}
	echo "</table>";
}

function display_process_waiver($Waiver_ID, $Approval_Status)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if($Approval_Status=="Approve")
	{
		$display_process_title=APPROVE_WAIVER_REQUEST;
	}
	elseif($Approval_Status=="Reject")
	{
		$display_process_title=REJECT_WAIVER_REQUEST;
	}
	echo "<tr><td><span class='table_row_title'>{$display_process_title}</span></td></tr>";
	$sql="select * from waiver_wire where ID=$Waiver_ID;";
	$waiver_rs=$DB->Execute($sql);
	if(!($waiver_rs->EOF))
	{
		$bg=get_row_bg($bg);
		$waiver_ID=$waiver_rs->fields("ID");
		$waiver_teams_ID=$waiver_rs->fields("teams_ID");
		$waiver_team_name=get_team_name($waiver_teams_ID);
		$waiver_date=$waiver_rs->fields("date_entered");
		$waiver_waive=$waiver_rs->fields("waive_players_ID");
		$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
		$approval_status=$waiver_rs->fields("approval_status");
		$waiver_date=display_users_time($waiver_date);
		$waiver_waive_player_data=get_player_data_array($waiver_waive);
		$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
		$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
		$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
		echo "<tr><td><span class='table_row_title'>".TEAM."</span></td><td>$waiver_team_name</td></tr>";
		echo "<tr><td><span class='table_row_title'>".DATE_REQUESTED."</span></td><td>$waiver_date</td></tr>";
		echo "<tr><td><span class='table_row_title'>".WAIVE."</span></td><td>$waiver_waive_name</td></tr>";
		echo "<tr><td><span class='table_row_title'>".PICK_UP."</span></td><td>$waiver_pickup_name</td></tr>";
	}
	echo "</table>";
}
?>
