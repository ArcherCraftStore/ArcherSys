<?php 

function calculate_team_stats($current_week, $LEAGUEID)
{
	global $DB;
	
	
	$sql="select schedules_type_ID from leagues where ID=$LEAGUEID;";
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
		$schedules_type_ID=$rs->fields("schedules_type_ID");
	
	$sql="select ID from schedules where leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	//If League has no schedule just total points for each team
	
	$sql="select ID from teams where leagues_ID=$LEAGUEID;";
	$teams_rs=$DB->Execute($sql);
	while(!($teams_rs->EOF))
	{
		$teams_ID=$teams_rs->fields("ID");
		$Wins[$teams_ID]=0;
		$Losses[$teams_ID]=0;
		$Ties[$teams_ID]=0;
		$Total_Points[$teams_ID]=0;
		$Total_Points_Control_Array[$teams_ID]=array();
		$teams_rs->MoveNext();
	}
	
	if($rs->EOF)
	{
		$sql="select ID from teams where leagues_ID=$LEAGUEID;";
		$teams_rs=$DB->Execute($sql);
		$total_points=0;
		while(!($teams_rs->EOF))
		{
			$teams_ID=$teams_rs->fields("ID");
			$total_points=0;
			for($i=1;$i<$current_week;$i++)
			{
				$current_points=get_total_points_game($teams_ID, $i, $i, $LEAGUEID);
				$total_points=$total_points+$current_points;
			}
			$sql="update teams set total_points=$total_points where ID=$teams_ID;";
			$DB->Execute($sql);
			$teams_rs->MoveNext();
		}
		
	}
	else
	{
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
		
		for($i=1;$i<$current_week;$i++)
		{
			$sql="select distinct(schedules_ID) from schedules where leagues_ID=$LEAGUEID order by schedules_ID ASC";
			$schedules_rs=$DB->Execute($sql);
			$schedulesID_teamname=get_schedulesID_teamname_array($LEAGUEID);
			$games_array=get_games_array_byweek($i,$LEAGUEID);
			$bg="";
			foreach($games_array as $key => $val)
			{
				$teams=explode(":", $val);
				$schedules_ID_1=$teams[0];
				$teams_ID_1=get_teamsID_from_schedulesID($schedules_ID_1,$LEAGUEID);
				$schedules_ID_2=$teams[1];
				$teams_ID_2=get_teamsID_from_schedulesID($schedules_ID_2,$LEAGUEID);
				
				$total_points1=get_total_points_game($teams_ID_1, $i, $i, $LEAGUEID);
				//echo "$i -> $total_points1 -> $teams_ID_1<br>";
				$total_points2=get_total_points_game($teams_ID_2, $i, $i, $LEAGUEID);
				
				if(is_array($Total_Points_Control_Array[$teams_ID_1]))
				{
					if(!(in_array($i, $Total_Points_Control_Array[$teams_ID_1])))
					{
						$Total_Points[$teams_ID_1]=$Total_Points[$teams_ID_1]+$total_points1;
					}
				}
				if(is_array($Total_Points_Control_Array[$teams_ID_2]))
				{
					if(!(in_array($i, $Total_Points_Control_Array[$teams_ID_2])))
					{
						$Total_Points[$teams_ID_2]=$Total_Points[$teams_ID_2]+$total_points2;
					}
				}
				//echo "Week $i: $teams_ID_1 ($total_points1) vs $teams_ID_2 ($total_points2)<br>";
				$Total_Points_Control_Array[$teams_ID_1][]=$i;
				$Total_Points_Control_Array[$teams_ID_2][]=$i;
				//Don't Update Records if team is not playing anyone
				if( $teams_ID_1!=0 && $teams_ID_2!=0  ) 
				{
				
					if($total_points1 > $total_points2)
					{
						$Wins[$teams_ID_1]=$Wins[$teams_ID_1]+1;
						$Losses[$teams_ID_2]=$Losses[$teams_ID_2]+1;
						
					}
					elseif($total_points2 > $total_points1)
					{
						
						$Wins[$teams_ID_2]=$Wins[$teams_ID_2]+1;
						$Losses[$teams_ID_1]=$Losses[$teams_ID_1]+1;
					}
					else
					{
						
						
						$Ties[$teams_ID_1]=$Ties[$teams_ID_1]+1;
						$Ties[$teams_ID_2]=$Ties[$teams_ID_2]+1;
					}
				}
				
			}
		}
		$teams_rs->MoveFirst();
		while(!($teams_rs->EOF))
		{
			$teams_ID=$teams_rs->fields("ID");
			$teams_wins=$Wins[$teams_ID];
			$teams_losses=$Losses[$teams_ID];
			$teams_ties=$Ties[$teams_ID];
			$teams_total_points=$Total_Points[$teams_ID];
			if(($teams_wins+$teams_losses)>0)
			{
				$winning_percentage=($teams_wins + ($teams_ties/2) )/($teams_wins+$teams_losses+$teams_ties);
			}
			else
			{
				$winning_percentage=0;
			}
			$sql="update teams set wins=$teams_wins, losses=$teams_losses, ties=$teams_ties, winning_percentage=$winning_percentage, total_points=$teams_total_points where ID=$teams_ID;";
			$DB->Execute($sql);
			$teams_rs->MoveNext();
		}	
	}


}




?>
