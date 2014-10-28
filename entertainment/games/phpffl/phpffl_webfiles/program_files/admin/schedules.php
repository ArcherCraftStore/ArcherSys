<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="schedules" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			display_schedules_main();
		break;
		case "select_new_schedule":
			display_select_new_schedule();
		break;
		case "confirm_select_new_schedule":
			
			$sql="delete from schedules where leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			$sql="update leagues set schedules_type_ID=$Schedules_Type_ID where ID=$LEAGUEID;";
			$DB->Execute($sql);
			
			$sql="select games_per_week from schedules_type where ID=$Schedules_Type_ID;";
			$schedules_rs=$DB->Execute($sql);
			if(!($schedules_rs->EOF))
			{
				$games_per_week=$schedules_rs->fields("games_per_week");
			}
			if($games_per_week>1)
			{
				//Temporary Fix for multiple games
				$sql="select * from schedules_templates where schedules_type_ID=$Schedules_Type_ID and opponent_ID=0;";
				$rs=$DB->Execute($sql);
				while(!($rs->EOF))
				{
					$current_week_ID=$rs->fields("week_ID");
					$current_schedules_ID=$rs->fields("schedules_ID");
					$current_ID=$rs->fields("ID");
					$current_week_ID=$rs->fields("week_ID");
					$sql="select schedules_ID from schedules_templates where opponent_ID=$current_schedules_ID and schedules_type_ID=$Schedules_Type_ID and week_ID=$current_week_ID;";
					$opponent_rs=$DB->Execute($sql);
					while(!($opponent_rs->EOF))
					{
						$opponent_schedules_ID=$opponent_rs->fields("schedules_ID");
						$sql="select ID from schedules_templates where schedules_type_ID=$Schedules_Type_ID and schedules_ID=$current_schedules_ID and opponent_ID=$opponent_schedules_ID and week_ID=$current_week_ID;";
						$gametest_rs=$DB->Execute($sql);
						if($gametest_rs->EOF)
						{
							$sql="update schedules_templates set opponent_ID=$opponent_schedules_ID where ID=$current_ID;";
							$DB->Execute($sql);
						}
						$opponent_rs->MoveNext();
					}
					$rs->MoveNext();
				}
			}

			$sql="select * from schedules_templates where schedules_type_ID=$Schedules_Type_ID order by week_ID ASC, schedules_ID ASC";
			$rs=$DB->Execute($sql);
			while(!($rs->EOF))
			{
				$schedules_ID=$rs->fields("schedules_ID");
				$week_ID=$rs->fields("week_ID");
				$opponent_ID=$rs->fields("opponent_ID");
				$game_number_per_week=$rs->fields("game_number_per_week");
				$sql="insert into schedules (schedules_ID, schedules_type_ID, week_ID, opponent_ID, leagues_ID, game_number_per_week) values ('$schedules_ID', '$Schedules_Type_ID', '$week_ID', '$opponent_ID', '$LEAGUEID', '$game_number_per_week');";
				$DB->Execute($sql);
				$rs->MoveNext();
			}
			display_schedules_main();
		break;
		
		case "edit_week_schedule":
			$Week_ID=$_REQUEST['Week_ID'];
			display_edit_week_schedule($Week_ID);
		break;
		case "confirm_edit_week_schedule":
			$Teams_ID_1=$_REQUEST['Teams_ID_1'];
			$Teams_ID_2=$_REQUEST['Teams_ID_2'];
			$Teams_ID_1_game_number=$_REQUEST['Teams_ID_1_game_number'];
			$Teams_ID_2_game_number=$_REQUEST['Teams_ID_2_game_number'];
			$Week_ID=$_REQUEST['Week_ID'];
			$week="week_".$Week_ID;
			$errors="";
			$error_check=array();
			$sql="select schedules_type_ID from leagues where ID=$LEAGUEID;";
			$league_rs=$DB->Execute($sql);
			$games_per_week=1;
			if(!($league_rs->EOF))
			{
				$schedules_type_ID=$league_rs->fields("schedules_type_ID");
				$games_per_week=get_number_games_per_week_schedule_type($schedules_type_ID);
			}
			if(is_array($Teams_ID_1))
			{
				foreach($Teams_ID_1 as $key => $val)
				{
					$teams2_ID=$Teams_ID_2[$key];
					if($val!=0 && $teams2_ID!=0)
					{
						if(is_array($error_check[$val]) )
						{
							if(!(in_array($teams2_ID, $error_check[$val])))
							{
								$error_check[$val][]=$teams2_ID;
							}
						}
						else
						{
							$error_check[$val][]=$teams2_ID;
						}
					}
				}
			}
			if(is_array($Teams_ID_2))
			{
				foreach($Teams_ID_2 as $key => $val)
				{
					$teams1_ID=$Teams_ID_1[$key];
					if($val!=0 && $teams1_ID!=0)
					{
						if(is_array($error_check[$val]))
						{
							if(!(in_array($teams1_ID, $error_check[$val])))
							{
								$error_check[$val][]=$teams1_ID;
							}
						}
						else
						{
							$error_check[$val][]=$teams1_ID;
						}
					}
				}
			}
			
			foreach($error_check as $key => $val)
			{
				if(is_array($val))
				{
					$number_of_games_scheduled=count($val);
					if($number_of_games_scheduled > $games_per_week)
					{
						$error_text=TEAM_CANNOT_PLAY_MORE_ONE_GAME_WEEK;
						$error_text=str_replace(ACTUAL_NUMBER_GAMES_HERE, $games_per_week, $error_text);
						$errors=$error_text."<br>";
					}
				}
			}
			if(strlen($errors)<1)
			{
				if(is_array($Teams_ID_1))
				{
					foreach($Teams_ID_1 as $key => $val)
					{
						$teams1_ID=$Teams_ID_1[$key];
						$teams2_ID=$Teams_ID_2[$key];
						$game_number_per_week=$Teams_ID_1_game_number[$key];
						if($teams1_ID!=0 && $teams2_ID!=0 && ($teams1_ID!=$teams2_ID))
						{
								echo "<hr>";
							if($teams1_ID!=0)
							{
								$sql="update schedules set opponent_ID=$teams1_ID where schedules_ID=$teams2_ID and leagues_ID=$LEAGUEID and week_ID=$Week_ID and game_number_per_week=$game_number_per_week;";
								echo "1 - $sql<br>";
								$DB->Execute($sql);
							}
							if($teams2_ID!=0)
							{
								$sql="update schedules set opponent_ID=$teams2_ID where schedules_ID=$teams1_ID and leagues_ID=$LEAGUEID and week_ID=$Week_ID and game_number_per_week=$game_number_per_week;";
									echo "2 - $sql<br>";
								$DB->Execute($sql);
							}
						}
					}
				}
				display_edit_week_schedule($Week_ID);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_week_schedule($Week_ID);
			}
			
		break;
		case "remove_weeklygame":
			$Schedules_ID_1=$_REQUEST['Schedules_ID_1'];
			$Schedules_ID_2=$_REQUEST['Schedules_ID_2'];
			$Week_ID=$_REQUEST['Week_ID'];
			$Game_Number_Per_Week=$_REQUEST['Game_Number_Per_Week'];
			$sql="update schedules set opponent_ID=0 where schedules_ID=$Schedules_ID_1 and leagues_ID=$LEAGUEID and week_ID=$Week_ID and game_number_per_week=$Game_Number_Per_Week;";
			$DB->Execute($sql);
			$sql="update schedules set opponent_ID=0 where schedules_ID=$Schedules_ID_2 and leagues_ID=$LEAGUEID and week_ID=$Week_ID and game_number_per_week=$Game_Number_Per_Week;";
			$DB->Execute($sql);
			display_edit_week_schedule($Week_ID);
		break;
		case "remove_schedule":
			echo SURE_WANT_TO_REMOVE_SCHEDULE." ".WARNING_DELETE_SCHEDULE."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_schedule'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_remove_schedule":
			$sql="update leagues set schedules_type_ID=0 where ID=$LEAGUEID;";
			$DB->Execute($sql);
			$sql="delete from schedules where leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			display_schedules_main();
		break;
		case "assign_team_schedules":
			display_assign_team_schedules();
		break;
		case "confirm_assign_team_schedules";
			$Teams_ID=$_REQUEST['Teams_ID'];
			$errors="";
			$temp=array();
			if(is_array($Teams_ID))
			{
				foreach($Teams_ID as $key => $val)
				{
					if(strlen($val)>0)
					{
						if(in_array($val, $temp))
						{
							$errors="$val -> ".SAME_TEAM_MORE_ONE_SCHEDULE."<br>";
						}
					}
					$temp[]=$val;
				}
				if(strlen($errors)<1)
				{
					$sql="update teams set schedules_ID=NULL where leagues_ID=$LEAGUEID;";
					$DB->Execute($sql);
					foreach($Teams_ID as $key => $val)
					{
						if(strlen($val)>0)
						{
							$sql="update teams set schedules_ID=$key where ID=$val;";
							$DB->Execute($sql);
						}
					}
					display_schedules_main();
				}
				else
				{
					echo "<span class='errors'>$errors</span>";
					display_assign_team_schedules();
				}	
			}
			
		break;
	}
	
}




?>
