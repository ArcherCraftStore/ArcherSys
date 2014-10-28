<?php

function display_standard_standings($leagues_ID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_ROOT;

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><strong>".DIVISION_STANDINGS."</strong></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=power_rankings_standings'>".POWER_RANKING."</a></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=standard_standings&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
	echo "</tr>";
	echo "</table>";

	$sql="select schedules_type_ID, standings_footer_text from leagues where ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$schedules_type_ID=$rs->fields("schedules_type_ID");
		$standings_footer_text=$rs->fields("standings_footer_text");
		$standings_footer_text=nl2br($standings_footer_text);

	}
	$number_games_per_week=get_number_games_per_week_schedule_type($schedules_type_ID);
	$current_week=get_current_week();
	$sql="select ID, division_name, division_logo_filename from divisions where leagues_ID=$leagues_ID order by display_order ASC;";
	$rs=$DB->Execute($sql);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$division_count=0;
	while(!($rs->EOF))
	{
		$divisions_ID=$rs->fields("ID");
		$divisions_name=$rs->fields("division_name");
		$division_logo_filename=$rs->fields("division_logo_filename");
		if($division_count>0)
			echo "<tr><td colspan='8'>&nbsp;</td></tr>";
		echo "<tr><td colspan='8' align='left' ><span class='main_title'>$divisions_name&nbsp;&nbsp;</span>";
		if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$division_logo_filename"))
		{
			echo "<img src='{$PHPFFL_IMAGE_PATH}team_logos/$division_logo_filename' align='bottom' />";
		}
		echo "</td></tr>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".TEAM."</span></td>";
		echo "<td><span class='table_row_title'>".WIN."</span></td>";
		echo "<td><span class='table_row_title'>".LOSS."</span></td>";
		echo "<td><span class='table_row_title'>".TIE."</span></td>";
		echo "<td><span class='table_row_title'>".WIN_PERCENTAGE_SHORT."</span></td>";
		echo "<td><span class='table_row_title'>".TOTAL_POINTS_SHORT."</span></td>";
		echo "<td><span class='table_row_title'>".AVERAGE."</span></td>";
		if(strlen($schedules_type_ID)>0 && $schedules_type_ID!=0)
		{
			echo "<td><span class='table_row_title'>".NEXT_OPPONENT."</span></td>";
		}
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='8'></td></tr>";
		$sql="select * from teams where divisions_ID=$divisions_ID order by winning_percentage DESC, total_points DESC, team_name ASC;";
		$teams_rs=$DB->Execute($sql);
		$bg="";
		while(!($teams_rs->EOF))
		{
			$bg=get_row_bg($bg);
			$team_ID=$teams_rs->fields("ID");
			$team_schedules_ID=$teams_rs->fields("schedules_ID");
			$team_name=$teams_rs->fields("team_name");
			$team_wins=$teams_rs->fields("wins");
			$team_losses=$teams_rs->fields("losses");
			$team_ties=$teams_rs->fields("ties");
			$team_winning_percentage=$teams_rs->fields("winning_percentage");
			$team_total_points=$teams_rs->fields("total_points");
			$standings_team_text=$teams_rs->fields("standings_team_text");
			$team_name_display=$team_name;
			if(strlen($standings_team_text)>0)
			{
				$team_name_display="{$standings_team_text} {$team_name}";
			}
			if($number_games_per_week>1)
			{
				if($current_week>1)
				{
					$number_of_weeks_played=$current_week;
					$number_of_weeks_played=$number_of_weeks_played-1;
					$team_average=number_format($team_total_points/$number_of_weeks_played, 2, '.', ',');
				}
				else
				{
					$team_average=0.00;
				}
			}
			else
			{
				$total_games=$team_wins+$team_losses+$team_ties;
				if($total_games>0)
				{
					$team_average=number_format($team_total_points/$total_games, 2, '.', ',');
				}
				else
				{
					$team_average=0.00;
				}
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='eleven_title'>$team_name_display</span></td>";
			echo "<td><span class='eleven_title'>$team_wins</span></td>";
			echo "<td><span class='eleven_title'>$team_losses</span></td>";
			echo "<td><span class='eleven_title'>$team_ties</span></td>";
			echo "<td><span class='eleven_title'>$team_winning_percentage</span></td>";
			echo "<td><span class='eleven_title'>$team_total_points</span></td>";
			echo "<td><span class='eleven_title'>$team_average</span></td>";
			if(strlen($schedules_type_ID)>0 && $schedules_type_ID!=0)
			{
				$team_opponent=NA;
				if(strlen($team_schedules_ID)>0 && $team_schedules_ID!=0)
				{
					$sql="select opponent_ID from schedules where schedules_ID=$team_schedules_ID and week_ID=$current_week and leagues_ID=$leagues_ID;";
					$schedules_rs=$DB->Execute($sql);
					$count=0;
					echo "<td><span class='eleven_title'>";
					while(!($schedules_rs->EOF))
					{
						$team_opponent_schedules_ID=$schedules_rs->fields("opponent_ID");
						$team_opponent_ID=get_teamsID_from_schedulesID($team_opponent_schedules_ID,$leagues_ID);
						$team_opponent=get_team_name($team_opponent_ID);
						if($count>0)
						{
							echo " / ";
						}
						if($team_opponent!=NA)
						{
							echo "<a href='{$PHPFFL_WEB_ROOT}statistics.php?Mode=teams&Action=teams_main&Teams_ID=$team_opponent_ID'>";
						}
						echo $team_opponent;
						if($team_opponent!=NA)
						{
							echo "</a>";
						}

						$count++;
						$schedules_rs->MoveNext();
					}
					echo "</span></td>";
				}

			}
			echo "</tr>";
			$teams_rs->MoveNext();
		}
		$division_count++;
		$rs->MoveNext();
	}
	if(strlen($standings_footer_text)>0)
	{
		echo "<tr><td colspan='9'>&nbsp;</td></tr>";
		echo "<tr><td colspan='9'><span class='standings_page_footer'>$standings_footer_text</span></td></tr>";
	}
	echo "</table>";
}


function display_power_ranking($leagues_ID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH;

	$sql="select schedules_type_ID, standings_footer_text from leagues where ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$schedules_type_ID=$rs->fields("schedules_type_ID");
		$standings_footer_text=$rs->fields("standings_footer_text");
		$standings_footer_text=nl2br($standings_footer_text);

	}
	$current_week=get_current_week();

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	$sql="select ID from divisions where leagues_ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=standard_standings'>".DIVISION_STANDINGS."</a></td>";
	}
	echo "<td><strong>".POWER_RANKING."</strong></td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=power_rankings_standings&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
	echo "</tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".TEAM."</span></td>";
	echo "<td><span class='table_row_title'>".WIN."</span></td>";
	echo "<td><span class='table_row_title'>".LOSS."</span></td>";
	echo "<td><span class='table_row_title'>".TIE."</span></td>";
	echo "<td><span class='table_row_title'>".WIN_PERCENTAGE_SHORT."</span></td>";
	echo "<td><span class='table_row_title'>".TOTAL_POINTS_SHORT."</span></td>";
	echo "<td><span class='table_row_title'>".AVERAGE."</span></td>";
	if(strlen($schedules_type_ID)>0 && $schedules_type_ID!=0)
	{
		echo "<td><span class='table_row_title'>".NEXT_OPPONENT."</span></td>";
	}
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='8'></td></tr>";
	$sql="select * from teams where leagues_ID=$leagues_ID order by winning_percentage DESC, total_points DESC, team_name ASC;";
	$teams_rs=$DB->Execute($sql);
	$bg="";
	while(!($teams_rs->EOF))
	{
		$bg=get_row_bg($bg);
		$team_ID=$teams_rs->fields("ID");
		$team_schedules_ID=$teams_rs->fields("schedules_ID");
		$team_name=$teams_rs->fields("team_name");
		$standings_team_text=$teams_rs->fields("standings_team_text");
		$team_name_display=$team_name;
		if(strlen($standings_team_text)>0)
		{
			$team_name_display="{$standings_team_text} {$team_name}";
		}

		$team_wins=$teams_rs->fields("wins");
		$team_losses=$teams_rs->fields("losses");
		$team_ties=$teams_rs->fields("ties");
		$team_winning_percentage=$teams_rs->fields("winning_percentage");
		$team_total_points=$teams_rs->fields("total_points");
		$total_games=$team_wins+$team_losses+$team_ties;
		if($total_games>0)
			$team_average=number_format($team_total_points/$total_games, 2, '.', ',');
		else
			$team_average=0.00;
		echo "<tr bgcolor='$bg'>";
		echo "<td><span class='eleven_title'>$team_name_display</span></td>";
		echo "<td><span class='eleven_title'>$team_wins</span></td>";
		echo "<td><span class='eleven_title'>$team_losses</span></td>";
		echo "<td><span class='eleven_title'>$team_ties</span></td>";
		echo "<td><span class='eleven_title'>$team_winning_percentage</span></td>";
		echo "<td><span class='eleven_title'>$team_total_points</span></td>";
		echo "<td><span class='eleven_title'>$team_average</span></td>";
		if(strlen($schedules_type_ID)>0 && $schedules_type_ID!=0)
		{
			$team_opponent=NA;
			if(strlen($team_schedules_ID)>0 && $team_schedules_ID!=0)
			{
				$sql="select opponent_ID from schedules where schedules_ID=$team_schedules_ID and week_ID=$current_week and leagues_ID=$leagues_ID;";
				$schedules_rs=$DB->Execute($sql);
				if(!($schedules_rs->EOF))
				{
					$team_opponent_schedules_ID=$schedules_rs->fields("opponent_ID");
					$team_opponent_ID=get_teamsID_from_schedulesID($team_opponent_schedules_ID,$leagues_ID);
					$team_opponent_name=get_team_name($team_opponent_ID);
				}
			}
			echo "<td><span class='eleven_title'>";
			if($team_opponent_name!=NA)
			{
				echo "<a href='{$PHPFFL_WEB_ROOT}statistics.php?Mode=teams&Action=teams_main&Teams_ID=$team_opponent_ID'>";
			}
			echo $team_opponent_name;
			if($team_opponent_name!=NA)
			{
				echo "</a>";
			}
			echo "</span></td>";
		}
		echo "</tr>";
		$teams_rs->MoveNext();
	}
	if(strlen($standings_footer_text)>0)
	{
		echo "<tr><td colspan='9'>&nbsp;</td></tr>";
		echo "<tr><td colspan='9'><span class='standings_page_footer'>$standings_footer_text</span></td></tr>";
	}
	echo "</table>";
}
?>