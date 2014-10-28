<?php

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);

//To verify this page is included from admin.php
if($Mode=="schedules_templates" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			display_schedules_templates_main();
		break;
		case "select_new_schedule_template":
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			display_schedules_templates_main($Schedules_Type_ID);
		break;
		case "add_new_schedules_template":
			display_new_schedules_template();
		break;
		case "confirm_add_new_schedules_template":
			$Schedule_Title=$_REQUEST['Schedule_Title'];
			$Number_Of_Teams=$_REQUEST['Number_Of_Teams'];
			$Number_Of_Weeks=$_REQUEST['Number_Of_Weeks'];
			$Games_Per_Week=$_REQUEST['Games_Per_Week'];
			if(1)
			{
				$Schedule_Title=addslashes($Schedule_Title);
			}
			$sql="select ID from schedules_type where schedule_title='$Schedule_Title'";
			$rs=$DB->Execute($sql);
			$errors="";
			if(strlen($Schedule_Title)<1)
			{
				$errors=$errors.ENTER_NAME_SCHEDULE."<br>";
			}
			elseif(!($rs->EOF))
			{
				$errors=$errors.SCHEDULE_NAME_EXISTS_CHOOSE_DIFFERENT."<br>";
			}
			if(!(is_numeric($Number_Of_Teams)) || $Number_Of_Teams<2)
			{
				$errors=$errors.ENTER_GREATER_ONE_NUMBER_TEAMS."<br>";
			}
			if(!(is_numeric($Number_Of_Weeks)) || $Number_Of_Weeks<2)
			{
				$errors=$errors.ENTER_GREATER_ONE_NUMBER_WEEKS."<br>";
			}
			if(!(is_numeric($Games_Per_Week)) || $Games_Per_Week<1)
			{
				$errors=$errors.ENTER_GREATER_NUMBER_GAMES_PER_WEEK."<br>";
			}

			if(strlen($errors)<1)
			{
				$sql="insert into schedules_type (schedule_title, number_of_teams, number_of_weeks, games_per_week) values ('$Schedule_Title', '$Number_Of_Teams', '$Number_Of_Weeks', '$Games_Per_Week');";
				$DB->Execute($sql);
				$sql="select ID from schedules_type where schedule_title='$Schedule_Title'";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$schedules_type_ID=$rs->fields("ID");

					for($i=1;$i<=$Number_Of_Teams;$i++)
					{
						for($j=1;$j<=$Number_Of_Weeks;$j++)
						{
							for($k=1;$k<=$Games_Per_Week;$k++)
							{
								$sql="insert into schedules_templates (schedules_ID, schedules_type_ID, week_ID, opponent_ID, game_number_per_week) values ('$i','$schedules_type_ID','$j','0', '$k');";
								$DB->Execute($sql);
							}
						}
					}
				}
				display_schedules_templates_main($schedules_type_ID);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Schedule_Title=stripslashes($Schedule_Title);
				display_new_schedules_template($Schedule_Title, $Number_Of_Teams, $Number_Of_Weeks);
			}
		break;
		case "delete_schedule_templates":
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			echo SURE_DELETE_SCHEDULE_TEMPLATE." <br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_schedule_templates&Schedules_Type_ID=$Schedules_Type_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=select_new_schedule_template&Schedules_Type_ID=$Schedules_Type_ID'>".NO."</a>";
		break;
		case "confirm_delete_schedule_templates":
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			$sql="delete from schedules_type where ID=$Schedules_Type_ID;";
			$DB->Execute($sql);
			$sql="delete from schedules_templates where schedules_type_ID=$Schedules_Type_ID;";
			$DB->Execute($sql);
			display_schedules_templates_main();
		break;
		case "edit_week_schedule_templates":
			$Week_ID=$_REQUEST['Week_ID'];
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			display_edit_week_schedule_templates($Schedules_Type_ID, $Week_ID);
		break;
		case "confirm_edit_week_schedule_templates":
			$Teams_ID_1=$_REQUEST['Teams_ID_1'];
			$Teams_ID_2=$_REQUEST['Teams_ID_2'];
			$Teams_ID_1_game_number=$_REQUEST['Teams_ID_1_game_number'];
			$Teams_ID_2_game_number=$_REQUEST['Teams_ID_2_game_number'];
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			$Week_ID=$_REQUEST['Week_ID'];
			$errors="";
			$error_check=array();
			$games_per_week=get_number_games_per_week_schedule_type($Schedules_Type_ID);
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
						//echo "<br>$game_number_per_week -> $teams1_ID -> $teams2_ID ";
						if($teams1_ID!=0 && $teams2_ID!=0 && ($teams1_ID!=$teams2_ID))
						{
							if($teams1_ID!=0)
							{
								$sql="update schedules_templates set opponent_ID=$teams1_ID where schedules_ID=$teams2_ID and schedules_type_ID=$Schedules_Type_ID and week_ID=$Week_ID and game_number_per_week=$game_number_per_week;";
								$DB->Execute($sql);
							}
							if($teams2_ID!=0)
							{
								$sql="update schedules_templates set opponent_ID=$teams2_ID where schedules_ID=$teams1_ID and schedules_type_ID=$Schedules_Type_ID and week_ID=$Week_ID and game_number_per_week=$game_number_per_week;";
								$DB->Execute($sql);
							}
						}
					}
				}


				display_edit_week_schedule_templates($Schedules_Type_ID, $Week_ID);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_week_schedule_templates($Schedules_Type_ID, $Week_ID);
			}

		break;
		case "remove_weeklygame_templates":
			$Schedules_ID_1=$_REQUEST['Schedules_ID_1'];
			$Schedules_ID_2=$_REQUEST['Schedules_ID_2'];
			$Schedules_Type_ID=$_REQUEST['Schedules_Type_ID'];
			$Week_ID=$_REQUEST['Week_ID'];
			$Game_Number_Per_Week=$_REQUEST['Game_Number_Per_Week'];
			$sql="update schedules_templates set opponent_ID=0 where schedules_ID=$Schedules_ID_1 and schedules_type_ID=$Schedules_Type_ID and week_ID=$Week_ID and game_number_per_week=$Game_Number_Per_Week;";
			$DB->Execute($sql);
			$sql="update schedules_templates set opponent_ID=0 where schedules_ID=$Schedules_ID_2 and schedules_type_ID=$Schedules_Type_ID and week_ID=$Week_ID and game_number_per_week=$Game_Number_Per_Week;";
			$DB->Execute($sql);
			display_edit_week_schedule_templates($Schedules_Type_ID, $Week_ID);
		break;
	}

}




?>