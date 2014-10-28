<?php 

function display_league_schedule($LEAGUEID)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH;
	$current_week=get_current_week(-5);
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
	echo "<tr><td><a name='top'><span class='table_row_title'>".WEEK."</span></a> ";
	for($i=1;$i<=$number_of_weeks;$i++)
	{
		echo " <a href='$PHP_SELF?Mode=$Mode&Action=schedules_main#$i'>$i</a>";
	}
	echo "</td>";
	echo "<td rowspan='2' valign='top'><a href='$PHP_SELF?Mode=$Mode&Action=&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='4'>";
	for($i=1;$i<=$number_of_weeks;$i++)
	{
		$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC";
		$schedules_rs=$DB->Execute($sql);
		$schedulesID_teamname=get_schedulesID_teamname_array($LEAGUEID);
		if($i>1)
		{
			echo "<tr><td colspan'3'>&nbsp;</td></tr>";
		}
		echo "<tr>";
		echo "<td colspan=3>";
		echo "<table width='100%'>";
		echo "<tr valign='middle'><td align='left'>";
		echo "<a name='$i'></a><span class='table_row_title'>".WEEK." $i </span>";
		echo "</td><td><a href='$PHP_SELF?Mode=live_scoring&Action=scoring_main&Week_ID=$i' title='".VIEW_DETAILED_RESULTS."'><img src='{$PHPFFL_IMAGE_PATH}arrow_right.gif' border='0'></a></td><td align='right'>";
		echo "<span class='eleven'><a href='$PHP_SELF?Mode=$Mode&Action=schedules_main#top'>".BACK_TO_TOP."</a></span>";
		echo "</td></tr></table>";
		
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
		$games_array=get_games_array_byweek($i,$LEAGUEID);
		$bg="";
		foreach($games_array as $key => $val)
		{
			$teams=explode(":", $val);
			$schedules_ID_1=$teams[0];
			$teams_ID_1=get_teamsID_from_schedulesID($schedules_ID_1,$LEAGUEID);
			$schedules_ID_2=$teams[1];
			$teams_ID_2=get_teamsID_from_schedulesID($schedules_ID_2,$LEAGUEID);
			$bg=get_row_bg($bg);
			echo "<tr bgcolor='$bg'><td>";
			$schedules_rs->MoveFirst();
			while(!($schedules_rs->EOF))
			{
				$current_schedules_ID=$schedules_rs->fields("schedules_ID");
				$display=$current_schedules_ID;
				if(array_key_exists($current_schedules_ID, $schedulesID_teamname))
					$display=$schedulesID_teamname[$current_schedules_ID];
				if($current_schedules_ID==$schedules_ID_1)
				{
					if($i<=$current_week)
					{
						$total_points=get_total_points_game($teams_ID_1, $i, $i, $LEAGUEID);
						echo "<a href='$PHP_SELF?Mode=$Mode&Action=display_game_detail&Team1_ID=$teams_ID_1&Team2_ID=$teams_ID_2&Week_ID=$i&Leagues_ID=$LEAGUEID'>$display ($total_points)</a>";
					}
					else
					{
						echo "$display";
					}
				}
				$schedules_rs->MoveNext();
			}
			if($schedules_ID_1==0)
				echo "None";
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
				{
					if($i<=$current_week)
					{
						$total_points=get_total_points_game($teams_ID_2, $i, $i, $LEAGUEID);
						echo "<a href='$PHP_SELF?Mode=$Mode&Action=display_game_detail&Team1_ID=$teams_ID_2&Team2_ID=$teams_ID_1&Week_ID=$i&Leagues_ID=$LEAGUEID'>$display ($total_points)</a>";
					}
					else
					{
						echo "$display";
					}
				}
				$schedules_rs->MoveNext();
			}
			if($schedules_ID_2==0)
				echo "None";
			echo "</select></td>";
			echo "</tr>";
			
			
		}
	}	
	echo "</table>";
}



?>
