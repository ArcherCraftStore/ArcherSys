<?php


function display_automated_scripts_main()
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_WEB_ROOT, $PHPFFL_AUTORUN_PIN;

	echo "<table><tr><td><span class='table_row_title'>".MANUALLY_RUN_AUTOMATED_SCRIPTS."</span></td></tr></table><br><br>";

	echo "<form action='{$PHPFFL_WEB_ROOT}/program_files/autorun/myffl/players.php' target='_blank' method='POST'>";
	echo "<input type='hidden' name='Autorun_Pin' value='".htmlentities($PHPFFL_AUTORUN_PIN)."'>";
	echo "<table>";
	echo "<tr><td colspan='3'><span class='table_row_title'>".UPDATE_PLAYERS.": </span>".UPDATE_PLAYERS_DESCRIPTION."</td></tr>";
	echo "<tr><td width='30'><span class='table_row_title'>".DAYS.": </span></td>";
	echo "<td width='40'><select name='Days'>";
	for($i=5;$i<=365;$i=$i+5)
	{
		echo "<option value='$i'>$i</option>";
	}
	echo "</select></td>";
	echo "<td><input type='Submit' name='Submit' value='".SUBMIT."'></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";

	echo "<form action='{$PHPFFL_WEB_ROOT}/program_files/autorun/myffl/statistics.php' target='_blank' method='POST'>";
	echo "<input type='hidden' name='Autorun_Pin' value='".htmlentities($PHPFFL_AUTORUN_PIN)."'>";
	echo "<table>";
	echo "<tr><td colspan='3'><span class='table_row_title'>".UPDATE_STATISTICS.": </span>".UPDATE_STATISTICS_DESCRIPTION."</td></tr>";
	echo "<tr><td colspan='3'><span class='table_row_title'>".UPDATE_ALL_GAMES_STATISTICS.": </span><input type='checkbox' name='Process_All' value='1'></td></tr>";
	echo "<tr><td width='30'><span class='table_row_title'>".WEEK.": </span></td>";
	echo "<td width='40'><select name='Week'>";
	for($i=1;$i<=17;$i++)
	{
		echo "<option value='$i'>$i</option>";
	}
	echo "</select></td>";
	echo "<td><input type='Submit' name='Submit' value='".SUBMIT."'></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";

	

	echo "<form action='{$PHPFFL_WEB_ROOT}/program_files/autorun/general/team_stats.php' target='_blank' method='POST'>";
	echo "<input type='hidden' name='Autorun_Pin' value='".htmlentities($PHPFFL_AUTORUN_PIN)."'>";
	echo "<table>";
	echo "<tr><td ><span class='table_row_title'>".UPDATE_TEAMSTATS.": </span>".UPDATE_TEAMSTATS_DESCRIPTION."</td></tr>";
	echo "<td><input type='Submit' name='Submit' value='".SUBMIT."'></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";


}


?>