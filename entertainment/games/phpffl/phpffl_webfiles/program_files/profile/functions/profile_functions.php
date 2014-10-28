<?php

function display_edit_profile($Username)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	if(strlen($LEAGUEID)<1)
		$leagues_ID=0;
	else
		$leagues_ID=$LEAGUEID;
	$sql="select * from users where username='$Username';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Users_ID=$rs->fields("ID");
		$sql="select teams_ID from teams, users_teams where teams_ID=teams.ID and users_ID=$Users_ID and teams.leagues_ID=$leagues_ID;";
		$teams_rs=$DB->Execute($sql);
		if(!($teams_rs->EOF))
		{
			$Team_ID=$teams_rs->fields("teams_ID");
		}
		$Username=$rs->fields("username");
		$Gmt_Offset=$rs->fields("gmt_offset");
		//$Team_ID=$rs->fields("teams_ID");
		$Is_Superuser=$rs->fields("is_superuser");
		$First_Name=$rs->fields("first_name");
		$Last_Name=$rs->fields("last_name");
		$Email_Address=$rs->fields("email_address");
		$Telephone_Number=$rs->fields("telephone_number");
		$League_ID=$rs->fields("leagues_ID");
		$Languages_ID=$rs->fields("languages_ID");
	}
	
	$Team_Name=get_team_name($Team_ID);

	
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='main_title'>".UPDATE_PROFILE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".FIRST_NAME."</span></td><td><input type=\"text\" name=\"first_name\" value=\"$First_Name\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LAST_NAME."</span></td><td><input type=\"text\" name=\"last_name\" value=\"$Last_Name\"></td></tr>";
	if($Team_Name!="N/A")
	{
		echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td><input type=\"text\" name=\"Team_Name\" value=\"$Team_Name\"></td></tr>";
	}
	echo "<tr><td><span class='table_row_title'>".GMT_OFFSET."</span></td><td>";
	echo "<select name=\"Gmt_Offset\">";
	$gmt_offset_array=get_gmt_offset_array();
	foreach($gmt_offset_array as $key => $val)
	{
		$s="";
		if($key==$Gmt_Offset)
			$s="selected";
		echo "<option value=\"$key\" $s>$val</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LANGUAGE."</span></td><td>";
	echo "<select name=\"Languages_ID\">";
	$sql="select ID, language_name from languages order by language_name ASC;";
	$languages_rs=$DB->Execute($sql);
	while(!($languages_rs->EOF))
	{
		$current_languages_ID=$languages_rs->fields("ID");
		$current_languages_name=$languages_rs->fields("language_name");
		$s="";
		if($current_languages_ID==$Languages_ID)
			$s="selected";
		echo "<option value='$current_languages_ID' $s>$current_languages_name</option>";
		$languages_rs->MoveNext();
	}	
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".EMAIL_ADDRESS."</span></td><td><input type=\"text\" name=\"email_address\" value=\"$Email_Address\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TELEPHONE_NUMBER."</span></td><td><input type=\"text\" name=\"telephone_number\" value=\"$Telephone_Number\"></td></tr>";
	
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='username' value='$Username'>";
	echo "<input type=hidden name='Users_ID' value='$Users_ID'>";
	echo "<input type='hidden' name='Teams_ID' value='$Team_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_profile'>";
	echo "</form></table>";
}

function display_change_password()
{
	global $PHP_SELF, $DB, $Mode;
	
	
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='2'><span class='main_title'>".CHANGE_PASSWORD."</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NEW_PASSWORD."</span></td>";
	echo "<td><input type='password' name='New_Password' value=''></td></tr>";
	echo "<tr><td><span class='table_row_title'>".CONFIRM_NEW_PASSWORD."</span></td>";
	echo "<td><input type='password' name='Confirm_New_Password' value=''></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_change_password'>";
	echo "</form></table>";
}

function display_update_teamlogo($Teams_ID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT;
	

	$league_logo_array=get_league_logo_array();
	$team_logo_filename=get_team_logo($Teams_ID);
	$max_logo_height=$league_logo_array['max_logo_height'];
	$max_logo_width=$league_logo_array['max_logo_width'];
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td><span class='main_title'>".UPDATE_TEAM_LOGO."</td></tr>";
	echo "<table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td>";
	if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$team_logo_filename"))
	{
		echo "<td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=delete_logo&Teams_ID=$Teams_ID'>".DELETE_LOGO."</a></td>";
	}
	echo "</tr>";
	echo "</table>";

	echo "<form enctype='multipart/form-data' method='post' action='$PHP_SELF?'>";
	echo "<table>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".CURRENT_TEAM_LOGO."</span></td><td>";
	if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$team_logo_filename"))
	{
		echo "<img src='{$PHPFFL_IMAGE_PATH}team_logos/$team_logo_filename' />";
	}
	else
	{
		echo NO_LOGO_EXISTS;
	}
	echo "</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM_LOGO_DIMENSIONS."</span></td><td>{$max_logo_height} ".HEIGHT." X {$max_logo_width} ".WIDTH." (".PIXELS.")</td></tr>";
	echo "<tr><td><span class='table_row_title'>".CHOOSE_NEW_LOGO_UPLOAD."</span></td><td><input name='logo_filename' type='file' /></td></tr>";
	echo "<tr><td><input type='Submit' name='Submit' value='".SUBMIT."'></td></tr>";
	echo "<input type='hidden' name='Action' value='confirm_update_teamlogo'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Teams_ID' value='$Teams_ID'>";
	echo "</table>";
	echo "</form>";

}


?>
