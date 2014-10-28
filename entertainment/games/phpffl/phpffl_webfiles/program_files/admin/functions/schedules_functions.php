<?php


function display_schedules_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select schedules_type_ID from leagues where ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
		$schedules_type_ID=$rs->fields("schedules_type_ID");

	if(strlen($schedules_type_ID)>0)
	{
		$sql="select * from schedules_type where ID=$schedules_type_ID;";
		$rs = $DB->Execute($sql);
		if(!($rs->EOF))
		{
			$schedules_title=$rs->fields("schedule_title");
			$number_of_teams=$rs->fields("number_of_teams");
			$number_of_weeks=$rs->fields("number_of_weeks");
		}
	}
	$sql="select * from schedules where leagues_ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='4'>";

	if($rs->EOF)
	{
			echo "<tr><td><span class='table_row_title'>".SELECT_SCHEDULE_LEAGUE."</span></td></tr>";
			echo "<tr>";
		echo "<td><a
href=\"$PHP_SELF?Mode=$Mode&Action=select_new_schedule\">".SELECT_NEW_SCHEDULE."</a></td>";
		echo "</tr>";
			echo "</table>";
	}
	else
	{

		echo "<tr><td colspan='3'><span class='table_row_title'>".CURRENT_SCHEDULE.": $schedules_title</span></td></tr>";
		echo "<tr>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_week_schedule'>".EDIT_SCHEDULE."</a></td>";
		echo "<td><a
href=\"$PHP_SELF?Mode=$Mode&Action=select_new_schedule\">".SELECT_NEW_SCHEDULE."</a></td>";
		echo "<td><a
href=\"$PHP_SELF?Mode=$Mode&Action=remove_schedule\">".REMOVE_SCHEDULE."</a></td>";
		echo "</tr>";
		echo "<tr><td colspan='3'><a
href=\"$PHP_SELF?Mode=$Mode&Action=assign_team_schedules\">".ASSIGN_TEAM_SCHEDULES."</a></td></tr>";
		echo "</table>";

		echo "<table border='0' cellpadding='4' cellspacing='4'>";
		for($i=1;$i<=$number_of_weeks;$i++)
		{
			$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC";
			$schedules_rs=$DB->Execute($sql);
			$schedulesID_teamname=get_schedulesID_teamname_array($LEAGUEID);


			echo "<tr>";
			echo "<td colspan=3><span class='table_row_title'>".WEEK." $i</span></td>";
			echo "</tr>";
			echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
			$games_array=get_games_array_byweek($i,$LEAGUEID);
			foreach($games_array as $key => $val)
			{
				$teams=explode(":", $val);
				$schedules_ID_1=$teams[0];
				$teams_ID_1=get_teamsID_from_schedulesID($schedules_ID_1,$LEAGUEID);
				$schedules_ID_2=$teams[1];
				$teams_ID_2=get_teamsID_from_schedulesID($schedules_ID_2,$LEAGUEID);
				echo "<tr><td>";
				$schedules_rs->MoveFirst();
				while(!($schedules_rs->EOF))
				{
					$current_schedules_ID=$schedules_rs->fields("schedules_ID");
					$display=$current_schedules_ID;
					if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
						$display=$schedulesID_teamname[$current_schedules_ID];
					if($current_schedules_ID==$schedules_ID_1)
						echo "$display";
					$schedules_rs->MoveNext();
				}
				if($schedules_ID_1==0)
					echo NONE;
				echo "</td>";
				echo "<td> ".VERSUS_SHORT." </td>";
				echo "<td>";
				$schedules_rs->MoveFirst();
				while(!($schedules_rs->EOF))
				{
					$current_schedules_ID=$schedules_rs->fields("schedules_ID");
					$display=$current_schedules_ID;
					if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
						$display=$schedulesID_teamname[$current_schedules_ID];
					if($current_schedules_ID==$schedules_ID_2)
						echo "$display";
					$schedules_rs->MoveNext();
				}
				if($schedules_ID_2==0)
					echo NONE;
				echo "</select></td>";
				echo "</tr>";


			}


		}
		echo "</table>";
	}

}

function display_select_new_schedule()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	echo "<table width='75%'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".SELECT_NEW_SCHEDULE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td colspan='2' class='table_row_title'>".SELECT_SCHEDULE_TEMPLATE_LEAGUE." ".WARNING_SELECT_SCHEDULE_TEMPLATE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".SCHEDULE_TEMPLATE."</span></td><td>";
	$sql="select * from schedules_type order by schedule_title;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Schedules_Type_ID'>";
		while(!($rs->EOF))
		{
			$schedules_type_ID=$rs->fields("ID");
			$schedule_title=$rs->fields("schedule_title");
			echo "<option value='$schedules_type_ID' $selected>$schedule_title</option>";
			$rs->MoveNext();
		}
		echo "</select>";
	}
	else
	{
		echo CREATE_SCHEDULE_TEMPLATE_FIRST;
	}
	echo "</td></tr>";

	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_select_new_schedule'>";
	echo "</form></table>";
}

function display_assign_team_schedules()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC;";
	$rs=$DB->Execute($sql);
	$sql="select ID, team_name, schedules_ID from teams where leagues_ID=$LEAGUEID order by team_name ASC";
	$teams_rs=$DB->Execute($sql);
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ASSIGN_TEAM_SCHEDULES."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".SCHEDULE."</span></td><td><span class='table_row_title'>".TEAM."</span></td></tr>";
	while(!($rs->EOF))
	{
		$schedules_ID=$rs->fields("schedules_ID");
		echo "<tr>";
		echo "<td>$schedules_ID</td>";
		echo "<td>";
		echo "<select name='Teams_ID[$schedules_ID]'>";
		echo "<option value=''>".NONE."</option>";
		$teams_rs->MoveFirst();
		while(!($teams_rs->EOF))
		{
			$teams_ID=$teams_rs->fields("ID");
			$teams_name=$teams_rs->fields("team_name");
			$teams_schedules_ID=$teams_rs->fields("schedules_ID");
			$s="";
			if($teams_schedules_ID==$schedules_ID)
				$s="selected";
			echo "<option value='$teams_ID' $s>$teams_name</option>";
			$teams_rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		$rs->MoveNext();
	}
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_assign_team_schedules'>";
	echo "</form></table>";
}

function display_edit_team_schedule($Schedules_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select ID, schedules_ID from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC;";
	$rs=$DB->Execute($sql);
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='3'><span class='main_title'>".ASSIGN_TEAM_SCHEDULES."</td></tr>";
	echo "<tr><td colspan='3'>&nbsp;</td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".SELECT_SCHEDULE_EDIT."</span></td>";
	echo "<td>";
	echo "<select name='Schedules_ID'>";
	while(!($rs->EOF))
	{
		$current_ID=$rs->fields("ID");
		$current_schedules_ID=$rs->fields("schedules_ID");
		$sql="select team_name from teams where schedules_ID=$current_schedules_ID and leagues_ID=$LEAGUEID";
		$teams_rs=$DB->Execute($sql);
		//echo "$sql";
		if(!($teams_rs->EOF))
			$team_name=$teams_rs->fields("team_name");
		else
			$team_name="";
		if(strlen($team_name)>0)
			$display=$team_name;
		else
			$display=$current_schedules_ID;
		$s="";
		if($Schedules_ID==$current_ID)
			$s="selected";
		echo "<option value='$current_ID' $s>$display</option>";
		$rs->MoveNext();
	}
	echo "</select></td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
	echo "</tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='edit_team_schedule'>";
	echo "</form></table>";
	if(strlen($Schedules_ID)>0)
	{
		$sql="select * from schedules where ID=$Schedules_ID;";
		$rs=$DB->Execute($sql);
		$schedules_type_ID=$rs->fields("schedules_type_ID");
		$sql="select schedules_ID from schedules where schedules_type_ID=$schedules_type_ID and leagues_ID=$LEAGUEID order by schedules_ID ASC";
		$schedules_rs=$DB->Execute($sql);
		while(!($schedules_rs->EOF))
		{
			$current_schedules_ID=$schedules_rs->fields("schedules_ID");
			$sql="select team_name from teams where schedules_ID=$current_schedules_ID and leagues_ID=$LEAGUEID";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$team_name=$teams_rs->fields("team_name");
				if(strlen($team_name)>0)
					$teams_array[$current_schedules_ID]=$team_name;
			}
			$schedules_rs->MoveNext();
		}
		echo "<table>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".WEEK."</span></td>";
		echo "<td><span class='table_row_title'>".OPPONENT."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		if(!($rs->EOF))
		{
			$schedules_type_ID=$rs->fields("schedules_type_ID");
			for($i=1;$i<18;$i++)
			{
				$week="week_".$i;
				$current_Teams=$rs->fields($week);
				echo "<tr>";
				echo "<td>$i</td>";
				echo "<td>";
				echo "<select name='Teams_ID[$i]'>";
				echo "<option value='0'>".NONE."</option>";
				$schedules_rs->MoveFirst();
				while(!($schedules_rs->EOF))
				{
					$current_schedules_ID=$schedules_rs->fields("schedules_ID");
					$s="";
					if($current_schedules_ID==$current_Teams)
						$s="selected";
					if(array_key_exists($current_schedules_ID, $teams_array))
						$display=$teams_array[$current_schedules_ID];
					else
						$display=$current_schedules_ID;
					echo "<option value='$current_schedules_ID' $s>$display</option>";
					$schedules_rs->MoveNext();
				}
				echo "</select>";
				echo "</td></tr>";
			}
		}
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Schedules_ID' value='$Schedules_ID'>";
		echo "<input type=hidden name='Action' value='confirm_edit_team_schedule'>";
		echo "</form></table>";

	}
}

function display_edit_week_schedule($Week_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select schedules_type_ID from leagues where ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
	{
		$schedules_type_ID=$rs->fields("schedules_type_ID");
	}
	$sql="select * from schedules_type where ID=$schedules_type_ID;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
	{
		$schedules_title=$rs->fields("schedule_title");
		$number_of_teams=$rs->fields("number_of_teams");
		$number_of_weeks=$rs->fields("number_of_weeks");
		$games_per_week=$rs->fields("games_per_week");
	}
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='3'><span class='main_title'>".EDIT_WEEKLY_SCHEDULES."</td></tr>";
	echo "<tr><td colspan='3'>&nbsp;</td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".SELECT_WEEK_EDIT."</span></td>";
	echo "<td>";
	echo "<select name='Week_ID'>";
	for($i=1;$i<=$number_of_weeks;$i++)
	{
		$s="";
		if($Week_ID==$i)
			$s="selected";
		echo "<option value='$i' $s>".WEEK." $i</option>";
	}
	echo "</select></td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
	echo "</tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='edit_week_schedule'>";
	echo "</form></table>";

	if(strlen($Week_ID)>0)
	{
		$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC";
		$schedules_rs=$DB->Execute($sql);
		$schedulesID_teamname=get_schedulesID_teamname_array($LEAGUEID);

		echo "<table>";
		echo "<form id='schedule' name='schedule' method='post' action='$PHP_SELF?'>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td colspan=4><span class='table_row_title'>".WEEK." $Week_ID</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";

		?>
		<script type="text/javascript">
		function update_schedules(key, teamID, gameNumber, opponentID)
		{
			var curTeamID=0;
			var curGameID=0;
			var curOpponent=0;
			var optionID='';
			//alert(' - ' + teamID + ' - ' + gameNumber + ' - ' + opponentID);
			for(var i =1; i < Teams_ID_Game_Number.length; i++)
			{
				curTeamID=Teams_ID[i];
				curGameID=Teams_ID_Game_Number[i];
				optionID= 'Teams_ID_2_' + i;
				curOpponent = document.getElementById(optionID).value;
				if((curOpponent==teamID || curOpponent==opponentID) && key!=i && gameNumber==curGameID)
				{
					optionID= i + '_0_2';
					//alert(optionID + ' - ' + curOpponent + ' - ' + teamID + ' - ' + opponentID + ' -  ' + curGameID);
					document.getElementById(optionID).selected = true;
				}
			}
			if(opponentID>0)
			{

				for(var i =1; i <= Teams_ID_Game_Number.length; i++)
				{
					curTeamID=Teams_ID[i];
					curGameID=Teams_ID_Game_Number[i];

					if(curTeamID==opponentID && gameNumber==curGameID)
					{
						optionID= i + '_' + teamID + '_2';
						document.getElementById(optionID).selected = true;
					}
				}

			}

		}
		var Teams_ID = new Array();
		var Teams_ID_Game_Number = new Array();

		</script>
		<?php

		$games_array=get_games_array_byweek($Week_ID,$LEAGUEID, 1);
		foreach($games_array as $key => $val)
		{
			$teams=explode(":", $val);
			$schedules_ID_1=$teams[0];
			$teams_ID_1=get_teamsID_from_schedulesID($schedules_ID_1,$LEAGUEID);
			$schedules_ID_2=$teams[1];
			$teams_ID_2=get_teamsID_from_schedulesID($schedules_ID_2,$LEAGUEID);
			$game_number_per_week=$teams[2];
			echo "<tr><td>";
			?>
			<script type="text/javascript">
			Teams_ID[<?php echo $key; ?>]=<?php echo $schedules_ID_1; ?>;
			Teams_ID_Game_Number[<?php echo $key; ?>]=<?php echo $game_number_per_week; ?>;
			</script>
			<?php
			echo "<input type='hidden' name='Teams_ID_1_game_number[$key]' value='$game_number_per_week'>";
			if($games_per_week>1 || 1==1)
			{
				$display=$schedules_ID_1;
				if(array_key_exists($schedules_ID_1, $schedulesID_teamname))
					$display=$schedulesID_teamname[$schedules_ID_1];
				echo "<input type='hidden' name='Teams_ID_1[$key]' value='$schedules_ID_1'>";
				echo "$display";
			}
			else
			{
				echo "<select name='Teams_ID_1[$key]'>";
				echo "<option value='0'>".NONE."</option>";
				$schedules_rs->MoveFirst();
				while(!($schedules_rs->EOF))
				{
					$current_schedules_ID=$schedules_rs->fields("schedules_ID");
					$s="";
					if($current_schedules_ID==$schedules_ID_1)
						$s="selected";
					$display=$current_schedules_ID;
					if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
						$display=$schedulesID_teamname[$current_schedules_ID];
					echo "<option value='$current_schedules_ID' $s>$display</option>";
					$schedules_rs->MoveNext();
				}
				echo "</select>";
			}
			echo "</td>";
			echo "<td> ".VERSUS_SHORT." </td>";
			echo "<td>";
			echo "<input type='hidden' name='Teams_ID_2_game_number[$key]' value='$game_number_per_week'>";
			echo "<select id='Teams_ID_2_{$key}' name='Teams_ID_2[$key]' onchange=\"update_schedules('$key', '$schedules_ID_1', '$game_number_per_week', this.options[selectedIndex].value)\">";
			echo "<option id='{$key}_0_2' value='0'>".NONE."</option>";
			$schedules_rs->MoveFirst();
			while(!($schedules_rs->EOF))
			{
				$current_schedules_ID=$schedules_rs->fields("schedules_ID");
				if($schedules_ID_1!=$current_schedules_ID)
				{
					$s="";
					if($current_schedules_ID==$schedules_ID_2)
						$s="selected";
					$display=$current_schedules_ID;
					if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
						$display=$schedulesID_teamname[$current_schedules_ID];
					echo "<option id='{$key}_{$current_schedules_ID}_2' value='$current_schedules_ID' $s>$display</option>";
				}
				$schedules_rs->MoveNext();
			}
			echo "</select></td>";
			if($schedules_ID_1!=0 && $schedules_ID_2!=0)
			{
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Week_ID=$Week_ID&Action=remove_weeklygame&Schedules_ID_1=$schedules_ID_1&Schedules_ID_2=$schedules_ID_2&Game_Number_Per_Week=$game_number_per_week'>".REMOVE_GAME."</a></td>";
			}
			else
			{
				echo "<td></td>";
			}
			echo "</tr>";


		}
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Week_ID' value='$Week_ID'>";
		echo "<input type=hidden name='Action' value='confirm_edit_week_schedule'>";
		echo "</form></table>";


	}


}

?>