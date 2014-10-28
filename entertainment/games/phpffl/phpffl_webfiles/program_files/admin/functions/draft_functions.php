<?php 

function draft_leagues_main($Round="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $PHPFFL_WEB_ROOT, $PHPSESSID;
	
	$sql="select draft_date, draft_length_rounds from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$draft_date=$rs->fields("draft_date");
		$draft_length_rounds=$rs->fields("draft_length_rounds");
		$draft_date_display=display_users_time($draft_date);
	}
	$sql="select sum(leagues_ID) as number_teams from teams where leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$number_teams=$rs->fields("number_teams");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='main_title'>".DRAFT."</span></td></tr>";
	echo "<tr>";
	if($number_teams>1)
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=create_draft_order'>".CREATE_DRAFT_ORDER."</a></td>";
	}	
	echo "<td><a href='{$PHPFFL_WEB_ROOT}draft.php?Mode=draft&Action=draft_main&PHPSESSID=$PHPSESSID' target='_blank'>".DRAFT_MODULE."</a></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_time_length_per_pick'>".TIME_LENGTH_PER_PICK."</a></td>";
	echo "<td><a href='{$PHP_SELF}?Mode=$Mode&Action=reset_player_ranking'>".RESET_PLAYER_RANKING_ALL_TEAMS."</a></td>";
	echo "</tr>";
	echo "</table>";
	if(strlen($Round)<1)
	{
		$Round=1;
	}
	$sql="select * from draft where leagues_ID=$LEAGUEID and round=$Round order by display_order ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{	
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".ROUND."</span></td>";
		echo "<td>";
		echo "<select name='Round'>";
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
		echo "<input type='hidden' name='Action' value='draft_main'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
		
		$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
		$teams_rs=$DB->Execute($sql);
	
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<td><span class='table_row_title'>".PICK."</span></td>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='3'><td colspan='3'></td></tr>";
		if(!($rs->EOF))
		{
			$bg="";
			while(!($rs->EOF))
			{
				$bg=get_row_bg($bg);
				$pick=$rs->fields("pick");
				$teams_ID=$rs->fields("teams_ID");
				echo "<tr bgcolor='$bg'>";
				echo "<td>$pick</td>";
				echo "<td>";
				echo "<select name='Teams_Order[$pick]'>";
				$teams_rs->MoveFirst();
				while(!($teams_rs->EOF))
				{
					$current_teams_ID=$teams_rs->fields("ID");
					$current_teams_name=$teams_rs->fields("team_name");
					$s="";
					if($current_teams_ID==$teams_ID)
						$s="selected";
					echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
					$teams_rs->MoveNext();
				}
				echo "</td>";
				echo "</tr>";
				$rs->MoveNext();
			}
		}
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value='".UPDATE_DRAFT_ORDER."'></td></tr>";
		echo "<input type='hidden' name='Round' value='$Round'>";
		echo "<input type='hidden' name='Action' value='update_draft_order'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
	
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='table_row_title'>".NO_DRAFT_ORDER_EXISTS_LEAGUE."</span></td></tr>";
		echo "</table>";
	}

}

function display_create_draft_order($Draft_Order=array())
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;
	
	
	$sql="select count(leagues_ID) as number_teams from teams where leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$number_teams=$rs->fields("number_teams");
	}
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$teams_rs=$DB->Execute($sql);
	$teams_order_array=array();
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='2'><span class='main_title'>".CREATE_DRAFT_ORDER."</span></td></tr>";
	echo "<tr><td colspan='2'>".ASSIGN_PICKS_TEAMS_DRAFT_CREATED." ".CHOOSE_REVERSE_DESCRIPTION." ".CHOOSE_ASCENDING_DESCRIPTION." ".WARNING_DRAFT_ORDER_OVERWRITE."</td></tr>";
	echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=create_random_draft_order'>".CREATE_RANDOM_DRAFT_ORDER."</a></td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_ORDER."</span></td>";
	echo "<td>";
	echo "<select name='Order_Type'>";
	echo "<option value='reverse'>".REVERSE_ORDER_EVEN."</option>";
	echo "<option value='always_ascending'>".ALWAYS_ASCENDING."</option>";
	echo "</select>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".PICK."</span></td>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "</tr>";
	$bg="";
	for($i=1;$i<=$number_teams;$i++)
	{
		$bg=get_row_bg($bg);
		$teams_rs->MoveFirst();
		$team_selected=false;
		echo "<tr bgcolor='$bg'><td>$i</td>";
		echo "<td>";
		echo "<select name='Teams_Order[$i]'>";
		while(!($teams_rs->EOF))
		{
			$current_teams_ID=$teams_rs->fields("ID");
			$current_teams_name=$teams_rs->fields("team_name");
			$s="";
			if(count($Draft_Order)==0)
			{
				if(!(in_array($current_teams_ID, $teams_order_array)) && !($team_selected) )
				{
					$s="selected";
					$team_selected=true;
					$teams_order_array[]=$current_teams_ID;
				}
			}
			else
			{
				if($Draft_Order[$i]==$current_teams_ID)
				{
					$s="selected";
				}
			}
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			
			$teams_rs->MoveNext();
		}
		echo "</select>";
		echo "</td></tr>";
	}
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Number_Teams' value='$number_teams'>";
	echo "<input type='hidden' name='Action' value='confirm_create_draft_order'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";



}

function display_update_time_length_per_pick()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	$sql="select draft_length_rounds from leagues where ID=$LEAGUEID;";
	$leagues_rs=$DB->Execute($sql);
	$draft_length_rounds=$leagues_rs->fields("draft_length_rounds");
	
	if(strlen($draft_length_rounds)<1 || $draft_length_rounds<1)
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='2'><span class='table_row_title'>".ENTER_DRAFT_ROUNDS_FIRST."</span></td></tr>";
		echo "</table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='8'><span class='main_title'>".UPDATE_TIME_LENGTH_PER_PICK."</span></td></tr>";
		echo "<tr><td colspan='8'>".TIME_LENGTH_PER_PICK_LONG_TEXT."</td></tr>";
		echo "</table>";
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		$sql="select length_minutes, length_seconds from draft_timer_length where is_default=1 and leagues_ID=$LEAGUEID;";
		$draft_rs=$DB->Execute($sql);
		if(!($draft_rs->EOF))
		{
			$default_length_minutes=$draft_rs->fields("length_minutes");
			$default_length_seconds=$draft_rs->fields("length_seconds");
		}
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".DEFAULT_LENGTH_PER_ROUND.":</span></td>";
		//echo "</tr><tr>";
		echo "<td>";
		echo "<select name='Length_Minutes'>";
		for($i=0;$i<=60;$i++)
		{
			$s="";
			if($i==$default_length_minutes)
			{
				$s="selected";
			}
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "&nbsp;".MINUTES."</td>";
		//echo "</tr><tr>";
		echo "<td>";
		echo "<select name='Length_Seconds'>";
		for($i=0;$i<=59;$i++)
		{
			$s="";
			if($i==$default_length_seconds)
			{
				$s="selected";
			}
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "&nbsp;".SECONDS."</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Action' value='confirm_update_default_time_length'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
		
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr>";
		echo"<td><span class='table_row_title'>".ROUND."</span></td>";
		echo"<td><span class='table_row_title' colspan='2'>".LENGTH."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
		$draft_length_round_array=get_draft_length_round_array($LEAGUEID);
		for($j=1;$j<=$draft_length_rounds;$j++)
		{
			
			$current_default_length_minutes=$draft_length_round_array[$j]['length_minutes'];
			$current_default_length_seconds=$draft_length_round_array[$j]['length_seconds'];
			echo "<td><span class='table_row_title'>$j</span></td>";
			echo "<td>";
			echo "<select name='Length_Minutes[$j]'>";
			for($i=0;$i<=60;$i++)
			{
				$s="";
				if($i==$current_default_length_minutes)
				{
					$s="selected";
				}
				echo "<option value='$i' $s>$i</option>";
			}
			echo "</select>";
			echo "&nbsp;".MINUTES."</td>";
			//echo "</tr><tr>";
			echo "<td>";
			echo "<select name='Length_Seconds[$j]'>";
			for($i=0;$i<=59;$i++)
			{
				$s="";
				if($i==$current_default_length_seconds)
				{
					$s="selected";
				}
				echo "<option value='$i' $s>$i</option>";
			}
			echo "</select>";
			echo "&nbsp;".SECONDS."</td>";
			echo "</tr>";
		}
		echo "<tr><td colspan='3'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		
		echo "<input type='hidden' name='Action' value='confirm_update_time_length_per_pick'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
	}
	


}
?>
