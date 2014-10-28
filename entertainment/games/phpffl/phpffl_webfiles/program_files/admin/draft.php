<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="draft" && $ISADMIN==1)
{

	Switch($Action)
	{
		case "draft_main":
		default:
			$Round=$_REQUEST['Round'];
			draft_leagues_main($Round);
		break;
		case "update_draft_order":
			$Round=$_REQUEST['Round'];
			$Teams_Order=$_REQUEST['Teams_Order'];
			foreach($Teams_Order as $key => $val)
			{
				$sql="update draft set teams_ID=$val where leagues_ID=$LEAGUEID and round=$Round and pick=$key;";
				$DB->Execute($sql);
			}
			draft_leagues_main($Round);
		break;
		case "create_draft_order":
			display_create_draft_order();
		break;
		case "confirm_create_draft_order":
			$Order_Type=$_REQUEST['Order_Type'];
			$Teams_Order=$_REQUEST['Teams_Order'];
			$Number_Teams=$_REQUEST['Number_Teams'];
			$Teams_Order_Test=array();
			$Teams_Order_Test_Pass=true;
			foreach($Teams_Order as $key => $val)
			{
				//var_dump($Teams_Order_Test);
				if(in_array($val, $Teams_Order_Test))
				{
					$Teams_Order_Test_Pass=false;
				}
				$Teams_Order_Test[]=$val;
			}
			if($Teams_Order_Test_Pass==true)
			{
				$sql="delete from draft_status where leagues_ID=$LEAGUEID;";
				$DB->Execute($sql);
				$sql="insert into draft_status (leagues_ID, next_pick_deadline, draftlive) values ('$LEAGUEID', '0', '0');";
				$DB->Execute($sql);
				$sql="delete from draft where leagues_ID=$LEAGUEID;";
				$DB->Execute($sql);
				$count=1;
				$sql="select draft_length_rounds from leagues where ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$draft_length_rounds=$rs->fields("draft_length_rounds");
				}
				$current_year=date("Y");
				for($i=1;$i<=$draft_length_rounds;$i++)
				{
					for($j=1;$j<=$Number_Teams;$j++)
					{
						
						if($i%2==1 || $Order_Type=="always_ascending")
						{
							$current_teams_ID=$Teams_Order[$j];
							
							//Account for traded picks
							$sql="select current_teams_ID from teams_traded_picks where traded_pick_teams_ID=$current_teams_ID and pick_round=$i and pick_year=$current_year and leagues_ID=$LEAGUEID;";
							$trades_rs=$DB->Execute($sql);
							if(!($trades_rs->EOF))
							{
								$current_teams_ID=$trades_rs->fields("current_teams_ID");
								
							}
							$sql="insert into draft (round, pick, teams_ID, leagues_ID, display_order) values ('$i', '$j', '$current_teams_ID', '$LEAGUEID', '$count');";
							$DB->Execute($sql);
						}
						else
						{
							$_j=$Number_Teams-$j+1;
							$current_teams_ID=$Teams_Order[$_j];
							
							//Account for traded picks
							$sql="select current_teams_ID from teams_traded_picks where traded_pick_teams_ID=$current_teams_ID and pick_round=$i and pick_year=$current_year and leagues_ID=$LEAGUEID;";
							$trades_rs=$DB->Execute($sql);
							if(!($trades_rs->EOF))
							{
								$current_teams_ID=$trades_rs->fields("current_teams_ID");
							}
							$sql="insert into draft (round, pick, teams_ID, leagues_ID, display_order) values ('$i', '$j', '$current_teams_ID', '$LEAGUEID', '$count');";
							$DB->Execute($sql);
						}
						$count++;
					}
				}
				draft_leagues_main(1);
			}
			else
			{
				echo "<span class='errors'>".TEAM_CANNOT_HAVE_MORE_ONE_PICK."<span><br>";
				display_create_draft_order();
			}
			
		break;
		case "create_random_draft_order":
			$teams_array=get_teams_byleague_array($LEAGUEID);
			$total_teams=count($teams_array);
			srand((float) microtime() * 10000000);
			$random_draft_order=array_rand($teams_array, $total_teams);
			$current_pick=1;
			foreach($random_draft_order as $key => $val)
			{
				$draft_order[$current_pick]=$val;
				$current_pick++;
			}
			display_create_draft_order($draft_order);
		break;
		case "update_time_length_per_pick":
			display_update_time_length_per_pick();
		break;
		case "confirm_update_default_time_length":
			$Length_Minutes=$_POST['Length_Minutes'];
			$Length_Seconds=$_POST['Length_Seconds'];
			$sql="select ID from draft_timer_length where leagues_ID=$LEAGUEID and is_default=1;";
			$draft_rs=$DB->Execute($sql);
			if($draft_rs->EOF)
			{
				$sql="insert into draft_timer_length (length_minutes, length_seconds, is_default, leagues_ID) values ('$Length_Minutes', '$Length_Seconds', '1', '$LEAGUEID');";
			}
			else
			{
				$sql="update draft_timer_length set length_minutes='$Length_Minutes', length_seconds='$Length_Seconds' where is_default=1 and leagues_ID=$LEAGUEID;";
			}
			$DB->Execute($sql);
			display_update_time_length_per_pick();
		break;
		case "confirm_update_time_length_per_pick":
			$Length_Minutes=$_POST['Length_Minutes'];
			$Length_Seconds=$_POST['Length_Seconds'];
			
			$sql="select length_minutes, length_seconds from draft_timer_length where is_default=1 and leagues_ID=$LEAGUEID;";
			$draft_rs=$DB->Execute($sql);
			if(!($draft_rs->EOF))
			{
				$default_length_minutes=$draft_rs->fields("length_minutes");
				$default_length_seconds=$draft_rs->fields("length_seconds");
			}
	
			foreach($Length_Minutes as $key => $val)
			{
				$current_round=$key;
				$current_length_minutes=$val;
				$current_length_seconds=$Length_Seconds[$key];
				if($current_length_minutes==$default_length_minutes && $current_length_seconds==$default_length_seconds)
				{
					$sql="delete from draft_timer_length where round=$current_round and leagues_ID=$LEAGUEID;";
					$DB->Execute($sql);
				}
				else
				{
					$sql="select ID from draft_timer_length where round=$current_round and leagues_ID=$LEAGUEID;";
					$draft_rs=$DB->Execute($sql);
					if($draft_rs->EOF)
					{
						$sql="insert into draft_timer_length (round, length_minutes, length_seconds, is_default, leagues_ID) values('$current_round', '$current_length_minutes', '$current_length_seconds', '0', '$LEAGUEID');";
						$DB->Execute($sql);
					}
					else
					{
						$sql="update draft_timer_length set length_minutes=$current_length_minutes, length_seconds=$current_length_seconds where round=$current_round and leagues_ID=$LEAGUEID;";
						$DB->Execute($sql);
					}
					
				}
			}
			display_update_time_length_per_pick();
		break;
		case "reset_player_ranking":
			echo SURE_YOU_WANT_TO_RESET_PLAYER_RANKING_ALL_TEAMS;
			echo "<br><a href='$PHP_SELF?Mode=$Mode&Action=confirm_reset_player_ranking'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_reset_player_ranking":
			@ini_set("max_execution_time", "300");
			$sql="select ID from teams where leagues_ID=$LEAGUEID;";
			$rs=$DB->Execute($sql);
			while(!($rs->EOF))
			{
				$current_teams_ID=$rs->fields("ID");
				set_team_autorank_players($current_teams_ID, $LEAGUEID);
				$rs->MoveNext();
			}
			draft_leagues_main($Round);
		break;
	}
}

?>

