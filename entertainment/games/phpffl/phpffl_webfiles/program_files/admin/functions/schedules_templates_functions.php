<?php

function display_schedules_templates_main($Schedules_Type_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select * from schedules_type order by schedule_title ASC;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF) && strlen($Schedules_Type_ID)<1)
		$Schedules_Type_ID=$rs->fields("ID");

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".SELECT_SCHEDULE_TEMPLATE_ADMIN."</span></td>";
	echo "<td>";
	echo "<select name=\"Schedules_Type_ID\">";
	while(!$rs->EOF)
	{
		$schedules_ID=$rs->fields("ID");
		$schedules_title=$rs->fields("schedule_title");
		$s="";
		if($Schedules_Type_ID==$schedules_ID)
			$s="selected";
		echo "<option value='$schedules_ID' $s>$schedules_title</option>";
		$rs->MoveNext();
	}
	echo "</select>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Action' value='select_new_schedule_template'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form></table>";

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if(strlen($Schedules_Type_ID)>0)
	{
		$sql="select * from schedules_type where ID=$Schedules_Type_ID;";
		$rs = $DB->Execute($sql);
		if(!($rs->EOF))
		{
			$schedules_title=$rs->fields("schedule_title");
			$number_of_teams=$rs->fields("number_of_teams");
			$number_of_weeks=$rs->fields("number_of_weeks");
		}
		echo "<tr><td colspan='3'><span class='twelve_title'>".ADMIN.": $schedules_title</span></td></tr>";

		echo "<tr>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=add_new_schedules_template&Schedules_Type_ID=$Schedules_Type_ID'>".NEW_TEMPLATE."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_week_schedule_templates&Schedules_Type_ID=$Schedules_Type_ID'>".EDIT_TEMPLATE."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_schedule_templates&Schedules_Type_ID=$Schedules_Type_ID'>".DELETE_TEMPLATE."</a></td>";
		echo "</tr>";

		echo "<table border='0' cellpadding='4' cellspacing='4'>";
		for($i=1;$i<=$number_of_weeks;$i++)
		{
			$sql="select distinct(schedules_ID) from schedules_templates where schedules_type_ID=$Schedules_Type_ID order by schedules_ID ASC";
			$schedules_rs=$DB->Execute($sql);

			echo "<tr><td colspan='3'>&nbsp;</td></tr>";
			echo "<tr>";
			echo "<td colspan=3><span class='table_row_title'>".WEEK." $i</span></td>";
			echo "</tr>";
			echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
			$games_array=get_games_array_byweek_templates($i,$Schedules_Type_ID);
			foreach($games_array as $key => $val)
			{
				$teams=explode(":", $val);
				$schedules_ID_1=$teams[0];
				$schedules_ID_2=$teams[1];
				echo "<tr><td>";
				$schedules_rs->MoveFirst();
				while(!($schedules_rs->EOF))
				{
					$current_schedules_ID=$schedules_rs->fields("schedules_ID");
					$display=$current_schedules_ID;
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
	}
	else
	{
		echo "<tr><td><span class='twelve_title'>".SELECT_SCHEDULE_TEMPLATE."</span></td></tr>";
	}

	echo "</table>";

}

function display_new_schedules_template($Schedule_Title="", $Number_Of_Teams="", $Number_Of_Weeks="16", $Games_Per_Week="1")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_SCHEDULE_TEMPLATE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".SCHEDULE_NAME."</span></td><td><input type=\"text\" name=\"Schedule_Title\" value=\"$Schedule_Title\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_OF_TEAMS."</span></td><td><input type=\"text\" name=\"Number_Of_Teams\" value=\"$Number_Of_Teams\" size=\"2\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_OF_WEEKS."<br>(".INCLUDING_PLAYOFFS.")</span></td><td><input type=\"text\" name=\"Number_Of_Weeks\" value=\"$Number_Of_Weeks\" size=\"2\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".GAMES_PER_WEEK."</span></td><td><input type=\"text\" name=\"Games_Per_Week\" value=\"$Games_Per_Week\" size=\"2\"></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_schedules_template'>";
	echo "</form></table>";



}

function display_edit_week_schedule_templates($Schedules_Type_ID, $Week_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select * from schedules_type where ID=$Schedules_Type_ID;";
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
	echo "<tr><td colspan='3'><span class='main_title'>".EDIT_WEEKLY_SCHEDULES.": $schedules_title</td></tr>";
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
	echo "<input type=hidden name='Schedules_Type_ID' value='$Schedules_Type_ID'>";
	echo "<input type=hidden name='Action' value='edit_week_schedule_templates'>";
	echo "</form></table>";

	if(strlen($Week_ID)>0)
	{
		$sql="select distinct(schedules_ID) from schedules_templates where schedules_type_ID=$Schedules_Type_ID order by schedules_ID ASC";
		$schedules_rs=$DB->Execute($sql);

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
					//alert(optionID);
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
		echo "<table>";
		echo "<form id='schedule' name='schedule' method='post' action='$PHP_SELF?'>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td colspan=4><span class='table_row_title'>".WEEK." $Week_ID</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
		$games_array=get_games_array_byweek_templates($Week_ID,$Schedules_Type_ID);
		foreach($games_array as $key => $val)
		{
			$teams=explode(":", $val);
			$schedules_ID_1=$teams[0];
			$schedules_ID_2=$teams[1];
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
				echo "<input type='hidden' name='Teams_ID_1[$key]' value='$schedules_ID_1'>";
				echo "$schedules_ID_1";
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
					{
						$s="selected";
					}
					$display=$current_schedules_ID;
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
					echo "<option id='{$key}_{$current_schedules_ID}_2' value='$current_schedules_ID' $s>$display</option>";
				}
				$schedules_rs->MoveNext();
			}
			echo "</select></td>";
			if($schedules_ID_1!=0 && $schedules_ID_2!=0)
			{
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Week_ID=$Week_ID&Action=remove_weeklygame_templates&Schedules_ID_1=$schedules_ID_1&Schedules_ID_2=$schedules_ID_2&Schedules_Type_ID=$Schedules_Type_ID&Game_Number_Per_Week=$game_number_per_week'>".REMOVE_GAME."</a></td>";
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
		echo "<input type=hidden name='Schedules_Type_ID' value='$Schedules_Type_ID'>";
		echo "<input type=hidden name='Action' value='confirm_edit_week_schedule_templates'>";
		echo "</form></table>";


	}


}



?>

