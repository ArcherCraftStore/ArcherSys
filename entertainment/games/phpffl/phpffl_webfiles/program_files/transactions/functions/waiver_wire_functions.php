<?php 

function display_waiver_wire_main($Order_By="ASC")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID, $PHPFFL_IMAGE_PATH;
	
	if(strlen($Order_By)<1)
	{
		$Order_By="ASC";
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
	$sql="select allow_auto_waivers, days_clear_waivers from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$allow_auto_waivers=$rs->fields("allow_auto_waivers");
		$days_clear_waivers=$rs->fields("days_clear_waivers");
	}
	if($allow_auto_waivers=="Yes")
	{
		$clear_waivers_timestamp=mktime(date("H"),gmdate("i"), date("s"), date("m"), date("d")-$days_clear_waivers,date("y"));
		$clear_waivers_date=gmdate("Y-m-d H:i:s", $clear_waivers_timestamp);
		$clear_waivers_date=display_users_time($clear_waivers_date);
	}
	$sql="select ID from teams where leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$waiver_wire_count[$current_teams_ID]=1;
			$rs->MoveNext();
		}
	}
	$sql="select * from waiver_wire where leagues_ID=$LEAGUEID and approval_status='Approved' order by date_entered {$Order_By};";
	$waiver_rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if($allow_auto_waivers=="Yes")
	{
		echo "<tr><td colspan='9'><span class='thirteen_title'>$clear_waivers_date - ".PLAYERS_WAIVED_BEFORE_AUTO_PROCESSED."</span></td></tr>";
	}
	if(!($waiver_rs->EOF))
	{
		echo "<tr>";
		echo "<td><span class='table_row_title'>#</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'><a href='$PHP_SELF?Action=waiver_wire_main&Mode=$Mode&Order_By=$New_Order_By'>".DATE_APPROVED."</span><br /><img src='{$PHPFFL_IMAGE_PATH}{$image}' /></td>";
		echo "<td><span class='table_row_title'>".WAIVE."</span></td>";
		echo "<td><span class='table_row_title'>".POSITION_SHORT."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'>".PICK_UP."</span></td>";
		echo "<td><span class='table_row_title'>".POSITION_SHORT."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='9'></td></tr>";
		$bg="";
		
		$players_need_clear_waivers=get_players_need_clear_waivers();
		while(!($waiver_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$waiver_ID=$waiver_rs->fields("ID");
			$waiver_teams_ID=$waiver_rs->fields("teams_ID");
			$waiver_team_name=get_team_name($waiver_teams_ID);
			$waiver_date=$waiver_rs->fields("date_approved");
			$waiver_waive=$waiver_rs->fields("waive_players_ID");
			$waiver_pickup=$waiver_rs->fields("pickup_players_ID");
			$approval_status=$waiver_rs->fields("approval_status");
			$waiver_date=display_users_time($waiver_date);
			$waiver_waive_player_data=get_player_data_array($waiver_waive);
			$waiver_waive_name="{$waiver_waive_player_data['lastname']}, {$waiver_waive_player_data['firstname']}";
			$waiver_pickup_player_data=get_player_data_array($waiver_pickup);
			$waiver_pickup_name="{$waiver_pickup_player_data['lastname']}, {$waiver_pickup_player_data['firstname']}";
			
			if(in_array($waiver_waive, $players_need_clear_waivers))
			{
				$css_class="clear_waivers_data_normal";
			}
			else
			{
				$css_class="table_data_normal";
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='{$css_class}'>$waiver_wire_count[$waiver_teams_ID]</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_team_name</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_date</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_waive_name</span></td>";
			echo "<td><span class='{$css_class}'>{$waiver_waive_player_data['positionID']}</span></td>";
			echo "<td><span class='{$css_class}'>{$waiver_waive_player_data['teamID']}</span></td>";
			echo "<td><span class='{$css_class}'>$waiver_pickup_name</span></td>";
			echo "<td><span class='{$css_class}'>{$waiver_pickup_player_data['positionID']}</span></td>";
			echo "<td><span class='{$css_class}'>{$waiver_pickup_player_data['teamID']}</span></td>";
			echo "</tr>";
			$waiver_wire_count[$waiver_teams_ID]++;
			$waiver_rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td>".NO_WAIVER_ACTIVITY."</td></tr>";
	}
	if(strlen($days_clear_waivers)>0 && $days_clear_waivers>0)
	{
		echo "<tr><td colspan='10'>&nbsp</td></tr>";
		echo "<tr><td colspan='10'><span class='clear_waivers_data_normal'>".RED_CLEAR_WAIVER."</span></td></tr>";
	}
	echo "</table>";




}



?>
