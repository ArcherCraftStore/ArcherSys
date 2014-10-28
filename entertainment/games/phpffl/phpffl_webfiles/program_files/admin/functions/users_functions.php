<?php
/*

function admin_user_main() - Displays the main view that is seen when Users is clicked on in the Admin section.

function display_add_user($Username="", $Password="", $Team_ID="", $is_superuser="", $First_Name="", $Last_Name="", $Email_Address="", $Telephone_Number="", $League_ID="") - Displays Add a New User.

function display_edit_user($Username) - Displays Edit for an existing User.

function display_view_user($Username) - Displays View for viewing all user data.


*/
function admin_user_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	$teams_array=get_teams_byleague_array($LEAGUEID);
	$sql="select users_ID, teams_ID from users_teams, teams where users_teams.teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	if(!$rs->EOF)
		$total_users=$rs->RecordCount();
	else
		$total_users=0;
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	
	echo "<tr><td colspan='9'><a
href=\"$PHP_SELF?Mode=$Mode&Action=add_new_user\">".ADD_NEW_USER."</a>&nbsp;&nbsp;&nbsp;<a
href=\"$PHP_SELF?Mode=$Mode&Action=add_existing_user\">".ADD_EXISTING_USER."</a></td></tr>";
	echo "</table>";
	display_signup_users();
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='9'><span class='thirteen_title'>".TOTAL_USERS.": $total_users</span></td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".USERNAME."</span></td>";
	echo "<td><span class='table_row_title'>".NAME."</span></td>";
	echo "<td><span class='table_row_title'>".TEAM_NAME."</span></td>";
	echo "<td></td><td></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='8'></td></tr>";
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$users_ID=$rs->fields("users_ID");
		$teams_ID=$rs->fields("teams_ID");
		$sql="select * from users where ID=$users_ID;";
		$users_rs=$DB->Execute($sql);
		$Username=$users_rs->fields("username");
		$First_Name=$users_rs->fields("first_name");
		$Last_Name=$users_rs->fields("last_name");
		$Team_Name=$teams_array[$teams_ID];
		
		if($Is_Superuser==1)
			$display_superuser=YES;
		else
			$display_superuser=NO;
		echo "<tr bgcolor='$bg'><td>$Username</td><td>$First_Name $Last_Name</td><td>$Team_Name</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_user&username=$Username'>".VIEW."</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_user&username=$Username'>".EDIT."</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=password_update&username=$Username'>".CHANGE_PASSWORD."</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=remove_user&Users_ID=$users_ID&Teams_ID=$teams_ID'>".REMOVE."</td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_user&Users_ID=$users_ID'>".DELETE."</td>";
		echo "</tr>";
		$rs->MoveNext();
	}
	echo "</table>";
}

function display_add_user($Username="", $Team_ID="", $Is_Superuser="", $First_Name="", $Last_Name="", $Email_Address="", $Telephone_Number="", $Gmt_Offset="", $Password="", $Languages_ID="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $ISSUPERUSER;
	
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_USER."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".USERNAME."</span></td><td><input type=\"text\" name=\"username\" value=\"$Username\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".PASSWORD."</span></td><td><input type=\"password\" name=\"Password\" value=\"$Password\"></td></tr>";
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
	
	
	echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td>";
	$sql="select * from teams where leagues_ID=$LEAGUEID order by team_name;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Team_ID'>";
		while(!($rs->EOF))
		{
			$cur_team_ID=$rs->fields("ID");
			$cur_team_name=$rs->fields("team_name");
			$selected="";
			if($cur_team_ID==$Team_ID)
				$selected="selected";
			
			echo "<option name=\"teams_ID\" value='$cur_team_ID' $selected>$cur_team_name</option>";
			$rs->MoveNext();
				}
		echo "</select>";
	}
	else
	{
		echo NA;
	}
	if($ISSUPERUSER==1)
	{
		echo "<tr><td><span class='table_row_title'>Superuser</span></td><td>";
		echo "<select name='is_superuser'>";
		echo "<option value='0'>".NO."</option>";
		$s="";
		if($Is_Superuser==1)
			$s="selected";
		echo "<option value='1' $s>".YES."</option>";
		echo "</select>";
		echo "</td></tr>";
	}
	else
	{
		echo "<input type='hidden' name='is_superuser' value='0'>";
	}
	echo "<tr><td><span class='table_row_title'>".FIRST_NAME."</span></td><td><input type=\"text\" name=\"first_name\" value=\"$First_Name\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LAST_NAME."</span></td><td><input type=\"text\" name=\"last_name\" value=\"$Last_Name\"></td></tr>";
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
	echo "<input type=hidden name='Action' value='confirm_add_new_user'>";
	echo "</form></table>";
}

function display_edit_user($Username)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $ISSUPERUSER;
	
	$sql="select users.*, users_teams.teams_ID from users, users_teams where username='$Username' and users.ID=users_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Users_ID=$rs->fields("ID");
		$Username=$rs->fields("username");
		$Gmt_Offset=$rs->fields("gmt_offset");
		$Password=$rs->fields("password");
		$Team_ID=$rs->fields("teams_ID");
		$Is_Superuser=$rs->fields("is_superuser");
		$First_Name=$rs->fields("first_name");
		$Last_Name=$rs->fields("last_name");
		$Email_Address=$rs->fields("email_address");
		$Telephone_Number=$rs->fields("telephone_number");
		$League_ID=$rs->fields("leagues_ID");
		$Languages_ID=$rs->fields("languages_ID");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='main_title'>".EDIT_USER."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".USERNAME."</span></td><td><input type=\"text\" name=\"New_Username\" value=\"$Username\"></td></tr>";
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
	echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td>";
	$sql="select * from teams where leagues_ID=$LEAGUEID order by team_name;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<select name='Team_ID'>";
		while(!($rs->EOF))
		{
			$cur_team_ID=$rs->fields("ID");
			$cur_team_name=$rs->fields("team_name");
			$selected="";
			if($cur_team_ID==$Team_ID)
				$selected="selected";
			
			echo "<option name=\"teams_ID\" value='$cur_team_ID' $selected>$cur_team_name</option>";
			$rs->MoveNext();
				
}
		echo "</select>";
	}
	else
	{
		echo NA;
	}
	if($ISSUPERUSER==1)
	{
		echo "<tr><td><span class='table_row_title'>".SUPERUSER."</span></td><td>";
		echo "<select name='is_superuser'>";
		echo "<option value='0'>".NO."</option>";
		$s="";
		if($Is_Superuser==1)
			$s="selected";
		echo "<option value='1' $s>".YES."</option>";
		echo "</select>";
		echo "</td></tr>";
	}
	else
	{
		echo "<input type='hidden' name='is_superuser' value='0'>";
	}
	echo "<tr><td><span class='table_row_title'>".FIRST_NAME."</span></td><td><input type=\"text\" name=\"first_name\" value=\"$First_Name\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LAST_NAME."</span></td><td><input type=\"text\" name=\"last_name\" value=\"$Last_Name\"></td></tr>";
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
	echo "<input type=hidden name='Previous_Team_ID' value='$Team_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_user'>";
	echo "</form></table>";
}

function display_view_user($Username)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;

	$sql="select ID, username, is_superuser, first_name, last_name, email_address, telephone_number, last_activity, gmt_offset, languages_ID from users where username='$Username'";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$Users_ID=$rs->fields("ID");
		$Username=$rs->fields("username");
		$Gmt_Offset=$rs->fields("gmt_offset");
		$gmt_offset_array=get_gmt_offset_array();
		foreach($gmt_offset_array as $key => $val)
		{
			if($Gmt_Offset==$key)
				$Gmt_Offset_Display=$val;
		}
		$Is_Superuser=$rs->fields("is_superuser");
		$Is_Superuser_Display=NO;
		if($Is_Superuser==1)
			$Is_Superuser_Display=YES;
		$First_Name=$rs->fields("first_name");
		$Last_Name=$rs->fields("last_name");
		$Email_Address=$rs->fields("email_address");
		$Telephone_Number=$rs->fields("telephone_number");
		$Languages_ID=$rs->fields("languages_ID");
		$Display_Languages_Name=get_language_name($Languages_ID);
		$Last_Activity=$rs->fields("last_activity");
		$Display_Last_Activity=display_users_time($Last_Activity);
		$sql="select max(login_date) as last_login from users_login_log where users_ID=$Users_ID;";
		$login_rs=$DB->Execute($sql);
		if(!($login_rs->EOF))
		{
			$Last_Login=$login_rs->fields("last_login");
			if(strlen($Last_Login)>0)
			{
				$Display_Last_Login=display_users_time($Last_Login);
			}
			else
			{
				$Display_Last_Login=NA;
			}
		}

		
		$sql="select team_name, leagues_ID from users_teams, teams where users_ID=$Users_ID and teams_ID=teams.ID;";
		$teams_rs=$DB->Execute($sql);
		while(!($teams_rs->EOF))
		{
			$Team_Name=$teams_rs->fields("team_name");
			$leagues_ID=$teams_rs->fields("leagues_ID");
			$League_Name=get_league_name($leagues_ID);
			$Team_Display=$Team_Display."$Team_Name (".LEAGUE.": $League_Name)<br>";
			$teams_rs->MoveNext();
		}
		
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
	echo "<tr><td colspan='2'><span class='table_row_title'>".USER_INFORMATION."</span></td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	
	
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".USERNAME."</span></td><td>$Username</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".GMT_OFFSET."</span></td><td>$Gmt_Offset_Display</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".NAME."</span></td><td>$First_Name $Last_Name</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".TEAMS."</span></td><td>$Team_Display</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".LANGUAGE."</span></td><td>$Display_Languages_Name</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".EMAIL_ADDRESS."</span></td><td>$Email_Address</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".TELEPHONE_NUMBER."</span></td><td>$Telephone_Number</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".SUPERUSER."</span></td><td>$Is_Superuser_Display</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".LAST_ACTIVITY."</span></td><td>$Display_Last_Activity</td></tr>";
	$bg=get_row_bg($bg);
	echo "<tr bgcolor='$bg'><td><span class='table_row_title'>".LAST_LOGIN."</span></td><td>$Display_Last_Login - <a href='$PHP_SELF?Mode=$Mode&Action=view_login_log&Users_ID=$Users_ID&Username=$Username'>".VIEW_LOG."</a></td></tr>";
	echo "</table>";
}




function update_user_password($Username)
{
	global $PHP_SELF, $DB, $Mode;

	$sql="select username from users where username = '$Username';";
	$rs = $DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".CHANGE_PASSWORD.": ".$Username."</span></td></tr>";
	echo "<tr><td colspan='1'>&nbsp;</td></tr>";
		while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$Username=$rs->fields("username");
		$rs->MoveNext();
}
	
	echo "<tr><td><span class='table_row_title'>".PASSWORD."</span></td><td><input type=\"text\" name=\"password\"></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='username' value='$Username'>";
	echo "<input type=hidden name='Action' value='confirm_password_update'>";
	echo "</form></table>";
}

function display_add_existing_user($leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;
	echo "<table>";
	echo "<tr><td colspan='2'><span class='main_title'>".ADD_EXISTING_USER."</a></td></tr>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".USER."</td><td>";
	echo "<select name='Users_ID'>";
	$sql="select ID, first_name, last_name, username from users order by last_name ASC, first_name ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$users_ID=$rs->fields("ID");
		$users_firstname=$rs->fields("first_name");
		$users_lastname=$rs->fields("last_name");
		$users_username=$rs->fields("username");
		if(!(is_user_in_league($users_ID, $leagues_ID)))
		{
			echo "<option value='$users_ID'>$users_lastname, $users_firstname ($users_username)</option>";
		}
		$rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM."</td><td>";
	echo "<select name='Teams_ID'>";
	$sql="select ID, team_name from teams where leagues_ID=$leagues_ID order by team_name ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$teams_ID=$rs->fields("ID");
		$teamname=$rs->fields("team_name");
		echo "<option value='$teams_ID'>$teamname</option>";
		$rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='username' value='$Username'>";
	echo "<input type=hidden name='Action' value='confirm_add_existing_user'>";
	echo "</form></table>";
	
}

function display_signup_users()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	$sql="select * from users_signup where (leagues_ID=0 or leagues_ID=$LEAGUEID) and status='New' order by signup_date ASC;";
	$rs=$DB->Execute($sql);
	
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='6'><span class='table_row_title'>".NEW_USER_REQUESTS."</span></td></tr>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".NAME."</span></td>";
		echo "<td><span class='table_row_title'>".SIGNUP_DATE."</span></td>";
		echo "<td><span class='table_row_title'>".LEAGUE_REQUESTED."</span></td>";
		echo "<td><span class='table_row_title'>".COMMENTS."</span></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$signup_ID=$rs->fields("ID");
			$first_name=$rs->fields("first_name");
			$last_name=$rs->fields("last_name");
			$signup_date=$rs->fields("signup_date");
			$leagues_ID=$rs->fields("leagues_ID");
			$comments=$rs->fields("user_comments");
			$comments=nl2br($comments);
			$signup_date=display_users_time($signup_date);
			if($leagues_ID==0)
			{
				$display_league=ANY_LEAGUE;
			}
			else
			{
				$sql="select league_name from leagues where ID=$leagues_ID;";
				$leagues_rs=$DB->Execute($sql);
				if(!($leagues_rs->EOF))
				{
					$display_league=$leagues_rs->fields("league_name");
				}
				else
				{
					$display_league=ANY_LEAGUE;
				}
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td>$first_name $last_name</td>";
			echo "<td>$signup_date</td>";
			echo "<td>$display_league</td>";
			echo "<td>$comments</td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=approve_user_signup&Signup_ID=$signup_ID'>".APPROVE."</a></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=reject_user_signup&Signup_ID=$signup_ID'>".REJECT."</a></td>";
			echo "</tr>";
			
			$rs->MoveNext();
		}
		echo "</table>";
	}


}
function display_signup_user($Signup_ID)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	$sql="select * from users_signup where ID=$Signup_ID;";
	$rs=$DB->Execute($sql);
	
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		$signup_ID=$rs->fields("ID");
		$first_name=$rs->fields("first_name");
		$last_name=$rs->fields("last_name");
		$team_name=$rs->fields("team_name");
		$signup_date=$rs->fields("signup_date");
		$leagues_ID=$rs->fields("leagues_ID");
		$comments=$rs->fields("user_comments");
		$comments=nl2br($comments);
		$signup_date=display_users_time($signup_date);
		if($leagues_ID==0)
		{
			$display_league=ANY_LEAGUE;
		}
		else
		{
			$sql="select league_name from leagues where ID=$leagues_ID;";
			$leagues_rs=$DB->Execute($sql);
			if(!($leagues_rs->EOF))
			{
				$display_league=$leagues_rs->fields("league_name");
			}
			else
			{
				$display_league=ANY_LEAGUE;
			}
		}
		
		echo "<tr><td><span class='table_row_title'>".NAME."</span></td><td>$first_name $last_name</td></tr>";
		echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td><td>$team_name</td></tr>";
		echo "<tr><td><span class='table_row_title'>".SIGNUP_DATE."</span></td><td>$signup_date</td></tr>";
		echo "<tr><td><span class='table_row_title'>".LEAGUE_REQUESTED."</span></td><td>$display_league</td></tr>";
		echo "<tr><td><span class='table_row_title'>".COMMENTS."</span></td><td>$comments</td></tr>";
		echo "</table>";
	}

}

function display_users_login_log($Users_ID, $Username)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID;
	
	$sql="select login_date, login_ip from users_login_log where users_ID=$Users_ID order by login_date DESC;";
	$rs=$DB->Execute($sql);
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='2'><span class='table_row_title'>$Username: ".LOGIN_LOG."</span></td></tr>";
		
	if(!($rs->EOF))
	{
		
		echo "<tr>";
		echo "<td><span class='table_row_title'>".DATE."</span></td>";
		echo "<td><span class='table_row_title'>".IP_ADDRESS."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$current_ip=$rs->fields("login_ip");
			$current_login_date=$rs->fields("login_date");
			$display_current_login_date=display_users_time($current_login_date);
			echo "<tr bgcolor='$bg'>";
			echo "<td>$display_current_login_date</td>";
			echo "<td>$current_ip</td>";
			echo "</tr>";
			$rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td colspan='2'>".NO_LOGIN_DATA_TO_DISPLAY."</td></tr>";
	}
	echo "</table>";
	
}
?>
