<?php 

function display_admin_standings_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$sql="select ID, team_name, standings_team_text from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$teams_rs=$DB->Execute($sql);
	if(!($teams_rs->EOF))
	{
		$sql="select standings_footer_text from leagues where ID=$LEAGUEID;";
		$leagues_rs=$DB->Execute($sql);
		if(!($leagues_rs->EOF))
		{
			$standings_footer_text=$leagues_rs->fields("standings_footer_text");
			$standings_footer_text=htmlentities($standings_footer_text);
		}
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><span class='eleven_title'>".ADMIN_STANDINGS_DESCRIPTION."</td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td colspan='2'><span class='table_row_title'>".STANDINGS_PAGE_FOOTER_TEXT."</span><br><span class='table_row_title_subheader'>(".STANDINGS_PAGE_FOOTER_TEXT_DESCRIPTION.")</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		echo "<tr><td colspan='2'><textarea name='Standings_Footer_Text' rows='5' cols='40'>$standings_footer_text</textarea></td></tr>";
		//echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td colspan='2'><span class='table_row_title'>".STANDINGS_PAGE_TEAM_TEXT."</span><br><span class='table_row_title_subheader'>(".STANDINGS_PAGE_TEAM_TEXT_DESCRIPTION.")</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		$bg="";
		while(!($teams_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$current_teams_ID=$teams_rs->fields("ID");
			$current_team_name=$teams_rs->fields("team_name");
			$current_standings_team_text=$teams_rs->fields("standings_team_text");
			$current_standings_team_text=htmlentities($current_standings_team_text);
			echo "<tr bgcolor='$bg'><td><span class='table_row_title'>$current_team_name</span></td><td><input type=\"text\" name=\"Standings_Team_Text[$current_teams_ID]\" value=\"$current_standings_team_text\"></td></tr>";
			$teams_rs->MoveNext();
		}
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='confirm_update_standings_text'>";
		echo "</form>";
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_TEAMS_EXIST_FOR_LEAGUE."</span></td></tr>";
	}
	echo "</table>";



}

?>