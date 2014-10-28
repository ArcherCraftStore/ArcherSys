<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="starting_lineups" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_lineups_main();
		break;
		case "add_new_position":
			display_add_new_position();
		break;
		case "confirm_add_new_position":
			$Positions_ID=$_REQUEST['Positions_ID'];
			$Players_Required=$_REQUEST['Players_Required'];
			$errors="";
			
			$sql="select ID from starting_lineup_requirements where positions_ID=$Positions_ID and leagues_ID=$LEAGUEID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$errors=$errors.POSITION_ALREADY_EXISTS_IN_LINEUP." ".EDIT_NUMBER_PLYAERS_REQUIRED."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="select max(display_order) as max_order from starting_lineup_requirements where leagues_ID=$LEAGUEID";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
					$display_order=$rs->fields("max_order")+1;
				else
					$display_order=0;
				$sql="insert into starting_lineup_requirements (positions_ID, players_required, display_order, leagues_ID) values ('$Positions_ID', '$Players_Required', '$display_order', '$LEAGUEID');";
				$DB->Execute($sql);
				admin_lineups_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_add_new_position($Positions_ID, $Players_Required);
			}
		
		break;
		case "update_lineups_main":
			$Display_Order=$_REQUEST['Display_Order'];
			$Players_Required=$_REQUEST['Players_Required'];
			if(is_array($Display_Order))
			{
				foreach($Display_Order as $key => $val)
				{
					$sql="update starting_lineup_requirements set display_order=$val, players_required=$Players_Required[$key] where ID=$key";
					$DB->Execute($sql);
				}
			}
			admin_lineups_main();
		break;
		case "delete_position":
			$Lineups_ID=$_REQUEST['Lineups_ID'];
			echo SURE_WANT_DELETE_POSITION." ".WARNING_DELETE_POSITION."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_position&Lineups_ID=$Lineups_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_position":
			$Lineups_ID=$_REQUEST['Lineups_ID'];
			$sql="delete from starting_lineup_requirements where ID=$Lineups_ID;";
			$DB->Execute($sql);
			admin_lineups_main();
		break;
		case "lineup_submission_history":
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=starting_lineups_main'>".BACK."</a></td></tr>";
			echo "</table>";
			display_lineup_submission_history($Teams_ID);
		break;
		case "view_lineup_submission":
			$Lineup_ID=$_REQUEST['Lineup_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=lineup_submission_history&Teams_ID=$Teams_ID'>".BACK."</a></td></tr>";
			echo "</table>";
			display_view_lineup_submission($Lineup_ID);
		break;
		case "submit_starting_lineups":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Game_ID=$_REQUEST['Game_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=lineup_submission_history&Teams_ID=$Teams_ID'>".BACK."</a></td></tr>";
			echo "</table>";
			display_submit_starting_lineups($Teams_ID, $Game_ID);
		break;
		
		case "confirm_update_starting_lineup":
			$Starting_Lineup=$_REQUEST['Starting_Lineup'];
			$Game_ID=$_REQUEST['Game_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			$sql="select leagues_ID from teams where ID=$Teams_ID;";
			$teams_rs=$DB->Execute($sql);
			$current_week=get_current_startinglineup_week();
			$weeks_in_season=get_number_weeks_season();
			if(!($teams_rs->EOF))
			{
				$teams_leagues_ID=$teams_rs->fields("leagues_ID");
			}
			if($teams_leagues_ID==$LEAGUEID)
			{
				$duplicate_players=false;
				$players_test=array();
				if(is_array($Starting_Lineup))
				{
					//Test for Duplicate Players
					foreach($Starting_Lineup as $key => $val)
					{
						if(is_array($Starting_Lineup[$key]))
						{
							foreach($Starting_Lineup[$key] as $key2 => $val2)
							{
								if($val2!="ZZZ")
								{	
									if(!(in_array($val2, $players_test)))
									{
										$players_test[]=$val2;
									}
									else
									{
										$duplicate_players=true;
									}
								}
							}
						}
					}
					
					if($duplicate_players==true)
					{
						echo "<span class='errors'>".ENTERED_SAME_PLAYER_MORE_THAN_ONCE."<br></span>";
					}
					else
					{
						$sql="delete from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and weeks_ID=$Game_ID and games_ID=$Game_ID;";
						$DB->Execute($sql);
						for($i=$current_week+1; $i<=$weeks_in_season; $i++)
						{
							$sql="delete from starting_lineup_actuals where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and weeks_ID=$i and games_ID=$i;";
							$DB->Execute($sql);
						}
						foreach($Starting_Lineup as $key => $val)
						{
							if(is_array($Starting_Lineup[$key]))
							{
								foreach($Starting_Lineup[$key] as $key2 => $val2)
								{
									if($val2!="ZZZ")
									{	
										$sql="insert into starting_lineup_actuals (teams_ID, players_ID, weeks_ID, games_ID, leagues_ID, positions_ID) values ('$Teams_ID', '$val2', '$Game_ID', '$Game_ID', '$LEAGUEID', '$key');";
										$DB->Execute($sql);
										for($i=$current_week+1; $i<=$weeks_in_season; $i++)
										{
											if($Game_ID!=$i)
											{
												$sql="insert into starting_lineup_actuals (teams_ID, players_ID, weeks_ID, games_ID, leagues_ID, positions_ID) values ('$Teams_ID', '$val2', '$i', '$i', '$LEAGUEID', '$key');";
												$DB->Execute($sql);
											}
										}
										$position_name=get_lineup_position_name($key, "short");
										$sql="select firstname, lastname from players where ID='$val2';";
										$rs=$DB->Execute($sql);
										if(!($rs->EOF))
										{
											$firstname=$rs->fields("firstname");
											$lastname=$rs->fields("lastname");
											$starting_lineup_text=$starting_lineup_text."$position_name: $lastname, $firstname \n";
										}
										
										$DB->Execute($sql);
									}
								}
							}
						}
						$current_date=gmdate("Y-m-d H:i:s");
						$starting_lineup_text=mysql_escape_string($starting_lineup_text);
						$sql="insert into starting_lineup_submissions (teams_ID, weeks_ID, games_ID, users_ID, starting_lineup, submission_date, leagues_ID) values ('$Teams_ID', '$Game_ID', '$Game_ID', '$USERSID', '$starting_lineup_text', '$current_date', '$LEAGUEID');";
						$DB->Execute($sql);
					}
				}
				else
				{
					$Game_ID=get_current_startinglineup_week();
					if($Game_ID==-1)
					{	
						$sql="select max(week) as max_week from league_schedules;";
						$rs=$DB->Execute($sql);
						if(!($rs->EOF))
						{
							$Game_ID=$rs->fields("max_week");
						}
					}
				}
			}
			display_submit_starting_lineups($Teams_ID, $Game_ID);
		break;
	}
}



?>
