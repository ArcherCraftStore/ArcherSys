<?php 


$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="players" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			admin_players_main($Current_Letter, $OrderBy, $SortBy);
		break;
		case "edit_player":
			$Players_ID=$_REQUEST['Players_ID'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_edit_player($Players_ID, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "confirm_edit_player":
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Players_ID=$_REQUEST['Players_ID'];
			$New_Players_ID=$_REQUEST['New_Players_ID'];
			$TeamID=$_REQUEST['TeamID'];
			$PositionID=$_REQUEST['PositionID'];
			$errors="";
			if(strlen($New_Players_ID)<1)
			{
				$errors=$errors.MUST_ENTER_PLAYERS_ID."<br>";
			}
			else
			{
				if($Players_ID!=$New_Players_ID)
				{
					$sql="select ID from players where ID='$New_Players_ID';";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$errors=$errors.PLAYERS_ID_ALREADY_EXISTS."<br>";
					}
				}
			}
			if(strlen($errors)<1)
			{
				$sql="update players set ID='$New_Players_ID', teamID='$TeamID', positionID='$PositionID' where ID='$Players_ID';";
				$DB->Execute($sql);
				$sql="update rosters set players_ID='$New_Players_ID' where players_ID='$Players_ID';";
				$DB->Execute($sql);
				display_edit_player($New_Players_ID, $Current_Letter, $OrderBy, $SortBy);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_player($Players_ID, $Current_Letter, $OrderBy, $SortBy);
			}
		break;
		case "add_player":
			display_add_player($Current_Letter, $OrderBy, $SortBy);
		break;
		case "confirm_add_player":
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Players_ID=$_REQUEST['Players_ID'];
			$TeamID=$_REQUEST['TeamID'];
			$PositionID=$_REQUEST['PositionID'];
			$FirstName=$_REQUEST['FirstName'];
			$LastName=$_REQUEST['LastName'];
			$errors="";
			if(strlen($Players_ID)<1)
			{
				$errors=$errors.MUST_ENTER_PLAYERS_ID."<br>";
			}
			else
			{
				
				$sql="select ID from players where ID='$Players_ID';";
				echo "$sql<br>";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.PLAYERS_ID_ALREADY_EXISTS."<br>";
				}
			}
			if(strlen($errors)<1)
			{
				$sql="insert into players (ID, teamID, positionID, lastname, firstname) values ('$Players_ID', '$TeamID', '$PositionID', '$LastName', '$FirstName');";
				$DB->Execute($sql);
				echo PLAYER_ADDED."<br>";
				admin_players_main($Current_Letter, $OrderBy, $SortBy);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$LastName=stripslashes($LastName);
				$FirstName=stripslashes($FirstName);
				display_add_player($Current_Letter, $OrderBy, $SortBy, $TeamID, $PositionID, $Players_ID, $LastName, $FirstName);
			}
		break;
		case "edit_player_stats":
			$Players_ID=$_REQUEST['Players_ID'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Week_ID=$_REQUEST['Week_ID'];
			edit_player_stats($Players_ID, $Week_ID, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "confirm_edit_player_stats":
			$Players_ID=$_REQUEST['Players_ID'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Week_ID=$_REQUEST['Week_ID'];
			$Game_ID=$_REQUEST['Game_ID'];
			$Stats_Override=$_REQUEST['Stats_Override'];
			$Random_Points=$_REQUEST['Random_Points'];
			$Statistic_Category_Value=$_REQUEST['Statistic_Category_Value'];
			$sql="delete from players_statistics_override where week_ID=$Week_ID and game_ID=$Game_ID and players_ID='$Players_ID';";
			$DB->Execute($sql);
			if($Stats_Override==1)
			{
				$sql="insert into players_statistics_override (week_ID, game_ID, players_ID) values ('$Week_ID', '$Game_ID', '$Players_ID')";
				$DB->Execute($sql);
			}
			$sql="select fantasy_value from players_statistics_fantasy where players_ID='$Players_ID' and week_ID=$Week_ID and game_ID=$Game_ID and leagues_ID=$LEAGUEID and scoring_categories_ID=0;";
			$random_rs=$DB->Execute($sql);
			if(!($random_rs->EOF))
			{
				$sql="update players_statistics_fantasy set fantasy_value=$Random_Points where players_ID='$Players_ID' and week_ID=$Week_ID and game_ID=$Game_ID and leagues_ID=$LEAGUEID and scoring_categories_ID=0;";
			}
			else
			{
				$sql="insert into players_statistics_fantasy (fantasy_value, players_ID, week_ID, game_ID, leagues_ID, scoring_categories_ID) values ('$Random_Points', '$Players_ID', '$Week_ID', '$Game_ID', '$LEAGUEID', 0);";
			}
			$DB->Execute($sql);
			if(is_array($Statistic_Category_Value))
			{
				foreach($Statistic_Category_Value as $key => $val)
				{
					$sql="select ID from players_statistics_actuals where week_ID=$Week_ID and game_ID=$Game_ID and players_ID='$Players_ID' and statistic_categories_ID=$key;";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$actuals_ID=$rs->fields("ID");
						$sql="update players_statistics_actuals set statistical_value=$val where ID=$actuals_ID;";
						$DB->Execute($sql);
					}
					else
					{
						$sql="insert into players_statistics_actuals (players_ID, week_ID, game_ID, statistical_value, statistic_categories_ID) values ('$Players_ID', '$Week_ID', '$Game_ID', '$val', '$key');";
						$DB->Execute($sql);
					}
					
				}
			
			}
			edit_player_stats($Players_ID, $Week_ID, $Current_Letter, $OrderBy, $SortBy);
			
			
		break;
	}
}



?>

