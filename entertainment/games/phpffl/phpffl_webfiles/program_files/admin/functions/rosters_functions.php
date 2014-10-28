<?php

function display_roster_requirements_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$roster_requirements_array=get_roster_requirements_array($LEAGUEID);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".POSITION."</span></td>";
	echo "<td><span class='table_row_title'>".ROSTER_MINIMUM."</span></td>";
	echo "<td><span class='table_row_title'>".ROSTER_MAXIMUM."</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	$sql="select ID, short_description from positions where include_in_roster_requirements=1";
	$positions_rs=$DB->Execute($sql);
	while(!($positions_rs->EOF))
	{
		$current_positions_description=$positions_rs->fields("short_description");
		$current_positions_ID=$positions_rs->fields("ID");
		$current_max=$roster_requirements_array[$current_positions_ID]['max_players'];
		$current_min=$roster_requirements_array[$current_positions_ID]['min_players'];
		echo "<tr>";
		echo "<td>$current_positions_description</td>";

		echo "<td>";
		echo "<select name='Roster_Minimum[{$current_positions_ID}]'>";
		echo "<option value='0'>".NONE."</option>";
		for($i=1;$i<=10;$i++)
		{
			$s="";
			if($i==$current_min)
			{
				$s="selected";
			}
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "</td>";

		echo "<td>";
		echo "<select name='Roster_Maximum[{$current_positions_ID}]'>";
		echo "<option value='0'>".NONE."</option>";
		for($i=1;$i<=10;$i++)
		{
			$s="";
			if($i==$current_max)
			{
				$s="selected";
			}
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		$positions_rs->MoveNext();
	}
	echo "<tr><td><span class='twelve_title'>".ENTIRE_ROSTER."</span></td><td>".NA."</td><td>";
	$current_max=get_roster_maximum($LEAGUEID);
	echo "<input type='hidden' name='Roster_Minimum[0]' value='0'>";
	echo "<select name='Roster_Maximum[0]'>";
	echo "<option value='0'>".NONE."</option>";
	for($i=1;$i<=40;$i++)
	{
		$s="";
		if($i==$current_max)
		{
			$s="selected";
		}
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";

	echo "</td></tr>";
	echo "<tr><td colspan='4'><input type='Submit' name='Submit' value='".UPDATE_LINEUP_INFO."'></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='update_roster_requirements'>";
	echo "</form></table>";


}

?>
