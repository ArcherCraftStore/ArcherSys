<?php 

function display_email_team($Teams_ID, $Email_Teams_ID="", $Email_Subject="", $Email_Message="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $PHPFFL_SEND_EMAILS;
	
	if($PHPFFL_SEND_EMAILS)
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td colspan='2'><span class='main_title'>".EMAIL_TEAM."</span></td></tr>";
		echo "<tr><td><span class='table_row_title'>".SELECT_TEAM."</span></td>";
		echo "<td>";
		echo "<select name='Email_Teams_ID'>";
		if(check_is_admin($USERSID, $LEAGUEID))
		{
			echo "<option value='All'>".ALL."</option>";
		}
		$sql="select ID, team_name from teams where ID<>$Teams_ID and leagues_ID=$LEAGUEID;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$current_teams_name=$rs->fields("team_name");
			$s="";
			if($Email_Teams_ID==$current_teams_ID)
				$s="selected";
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td><span class='table_row_title'>".SUBJECT."</span></td><td><input type='text' name='Email_Subject' value=\"$Email_Subject\"></td></tr>";
		echo "<tr><td><span class='table_row_title'>".MESSAGE."</span></td><td><textarea name='Email_Message' rows='6' cols='45'>$Email_Message</textarea></td></tr>";
		echo "<tr><td><span class='table_row_title'>".CC_MYSELF."</span></td><td><input type='checkbox' name='CC_Myself' value='1'></td></tr>";
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type='hidden' name='Action' value='confirm_email_team'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";
	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td colspan='2'><span class='main_title'>".TEAM_EMAILS."</span></td></tr>";
		$sql="select users_ID, teams_ID from users_teams, teams where teams.ID=teams_ID and leagues_ID=$LEAGUEID;";
		echo "<tr><td><span class='table_row_title'>".TEAM."</span></td><td><span class='table_row_title'>".EMAIL_ADDRESS."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		$rs=$DB->Execute($sql);
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$teams_ID=$rs->fields("teams_ID");
			$users_ID=$rs->fields("users_ID");
			$team_name=get_team_name($teams_ID);
			$users_email=get_users_email($users_ID);
			if(strlen($users_email)<1)
				$users_email=NA;
			echo "<tr bgcolor='$bg'>";
			echo "<td>$team_name</td>";
			echo "<td>$users_email</td>";
			echo "</tr>";
			$rs->MoveNext();
		}
		echo "</table>";
	
	
	}
	

}



?>
