<?php
/*

function admin_divisions_main() - Displays the main view that is seen when Divisions is clicked on in the Admin section.

function display_add_division($Division_Name="") - Displays Add a New Division.

function display_edit_division($Division_ID) - Displays Edit for an existing Division.

*/

function admin_divisions_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select * from divisions where leagues_ID=$LEAGUEID order by display_order ASC, division_name ASC;";
	$rs = $DB->Execute($sql);
	$total_divisions=$rs->RecordCount();

	if($total_divisions>0)
		echo "<table width='75%'><tr><td><span class='eleven_title'>".UPDATE_DIVISION_BY_DROP_DOWN." ".CHANGE_DISPLAY_ORDER_USE_TEXT_BOX."</span></td></tr></table>";
	$sql="select * from divisions where leagues_ID=$LEAGUEID order by display_order ASC, division_name ASC;";
	$divisions_rs=$DB->Execute($sql);


	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='4'><a href=\"$PHP_SELF?Mode=$Mode&Action=add_new_division\">".ADD_NEW_DIVISION."</a></td></tr>";

	while(!($rs->EOF))
	{
		echo "<tr><td colspan='4' height='2'></td></tr>";
		$divisions_name=$rs->fields("division_name");
		$divisions_ID=$rs->fields("ID");
		$display_order=$rs->fields("display_order");
		echo "<tr>";
		echo "<td><span class='table_row_title'>$divisions_name</span></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_division&Division_ID=$divisions_ID'>".EDIT."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=update_divisionlogo&Division_ID=$divisions_ID'>".UPDATE_LOGO."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_division&Division_ID=$divisions_ID'>".DELETE."</a></td>";
		echo "<td><input type=\"text\" name=\"Display_Order[$divisions_ID]\" value=\"$display_order\" size=\"2\"></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
		$sql="select ID, team_name from teams where divisions_ID=$divisions_ID and leagues_ID=$LEAGUEID;";
		$teams_rs=$DB->Execute($sql);
		$bg="";
		while(!($teams_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$teams_ID=$teams_rs->fields("ID");
			$teams_name=$teams_rs->fields("team_name");
			echo "<tr bgcolor='$bg'>";
			echo "<td>$teams_name</td>";
			echo "<td colspan='4'><select name='Divisions_ID[$teams_ID]'>";
			$divisions_rs->MoveFirst();
			while(!($divisions_rs->EOF))
			{
				$current_divisions_ID=$divisions_rs->fields("ID");
				$current_divisions_name=$divisions_rs->fields("division_name");
				$s="";
				if($current_divisions_ID==$divisions_ID)
					$s="selected";
				echo "<option value='$current_divisions_ID' $s>$current_divisions_name</option>";
				$divisions_rs->MoveNext();
			}
			echo "</select></td></tr>";
			$teams_rs->MoveNext();
		}
		$rs->MoveNext();
	}
	//Display Teams with No Current Division


	$sql="select teams.ID, team_name from teams left outer join divisions on divisions_ID=divisions.ID where divisions.ID IS NULL and teams.leagues_ID=$LEAGUEID;";
	$teams_rs=$DB->Execute($sql);
	$teams_rs_total=$teams_rs->RecordCount();
	if($teams_rs_total>0)
	{
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".UNCATEGORIZED."</span></td>";
		echo "<td colspan='3'></td>";
		echo "</tr>";
		$bg="";
		while(!($teams_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$teams_ID=$teams_rs->fields("ID");
			$teams_name=$teams_rs->fields("team_name");
			echo "<tr bgcolor='$bg'>";
			echo "<td>$teams_name</td>";
			echo "<td colspan='3'><select name='Divisions_ID[$teams_ID]'>";
			echo "<option value='0'>".UNCATEGORIZED."</option>";
			$divisions_rs->MoveFirst();
			while(!$divisions_rs->EOF)
			{
				$current_divisions_ID=$divisions_rs->fields("ID");
				//echo "cur -> $current_divisions_ID<br>";
				$current_divisions_name=$divisions_rs->fields("division_name");
				echo "<option value='$current_divisions_ID'>$current_divisions_name</option>";
				$divisions_rs->MoveNext();
			}
			echo "</select></td></tr>";
			$teams_rs->MoveNext();
		}
	}
	echo "<tr><td colspan='4'>&nbsp;</td></tr>";
	echo "<tr><td colspan='4'><input type='Submit' name='Submit' value='".UPDATE_DIVISION_INFO."'></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='update_divisions_main'>";
	echo "</form></table>";

}

function display_add_division($Division_Name="", $Leagues_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	if(strlen($Leagues_ID)<1)
		$compare_leagues_ID=$LEAGUEID;
	else
		$compare_leagues_ID=$Leagues_ID;
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_DIVISION."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DIVISION_NAME."</span></td><td><input type=\"text\" name=\"Division_Name\" value=\"$Division_Name\"></td></tr>";
	echo "<input type='hidden' name='Leagues_ID' value='$LEAGUEID'>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_division'>";
	echo "</form></table>";
}

function display_edit_division($Division_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$sql="select division_name, leagues_ID from divisions where ID=$Division_ID;";
	$rs=$DB->Execute($sql);
	if(!$rs->EOF)
	{
		$Division_Name=$rs->fields("division_name");
		$Leagues_ID=$rs->fields("leagues_ID");
	}
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".EDIT_DIVISION."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DIVISION_NAME."</span></td><td><input type=\"text\" name=\"Division_Name\" value=\"$Division_Name\"></td></tr>";
	echo "<input type='hidden' name='Leagues_ID' value='$LEAGUEID'>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Division_ID' value='$Division_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_division'>";
	echo "</form></table>";
}

function display_update_divisionlogo($Division_ID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT;


	$league_logo_array=get_league_logo_array();
	$division_logo_filename=get_division_logo($Division_ID);
	$max_logo_height=$league_logo_array['max_logo_height'];
	$max_logo_width=$league_logo_array['max_logo_width'];
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td><span class='main_title'>".UPDATE_DIVISION_LOGO."</td></tr>";
	echo "<table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td>";
	if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$division_logo_filename"))
	{
		echo "<td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=delete_logo&Division_ID=$Division_ID'>".DELETE_LOGO."</a></td>";
	}
	echo "</tr>";
	echo "</table>";

	echo "<form enctype='multipart/form-data' method='post' action='$PHP_SELF?'>";
	echo "<table>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".CURRENT_DIVISION_LOGO."</span></td><td>";
	if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$division_logo_filename"))
	{
		echo "<img src='{$PHPFFL_IMAGE_PATH}team_logos/$division_logo_filename' />";
	}
	else
	{
		echo NO_LOGO_EXISTS_DIVISION;
	}
	echo "</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LOGO_DIMENSIONS."</span></td><td>{$max_logo_height} ".HEIGHT." X {$max_logo_width} ".WIDTH." (".PIXELS.")</td></tr>";
	echo "<tr><td><span class='table_row_title'>".CHOOSE_NEW_LOGO_UPLOAD."</span></td><td><input name='logo_filename' type='file' /></td></tr>";
	echo "<tr><td><input type='Submit' name='Submit' value='".SUBMIT."'></td></tr>";
	echo "<input type='hidden' name='Action' value='confirm_update_divisionlogo'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Division_ID' value='$Division_ID'>";
	echo "</table>";
	echo "</form>";

}





?>