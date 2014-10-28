<?php

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="teams" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_teams_main();
		break;
		case "add_new_team":
			display_add_team();
		break;
		case "confirm_add_new_team":
			$Team_Name=$_REQUEST['Team_Name'];
			$Divisions_ID=$_REQUEST['Divisions_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$errors="";
			if(1)
			{
				$Team_Name=addslashes($Team_Name);
			}
			if(strlen($Team_Name)<1)
			{
				$errors=$errors.ENTER_TEAM_NAME."<br>";
			}
			else
			{
				$sql="select team_name from teams where team_name='$Team_Name' and leagues_ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.TEAM_ALREADY_EXISTS_ENTER_DIFFERENT_NAME."<br>";
				}
			}
			if(strlen($errors)<1)
			{
				$sql="insert into teams (team_name, divisions_ID, leagues_ID) values ('$Team_Name', '$Divisions_ID', '$Leagues_ID');";
				$DB->Execute($sql);
				$teams_ID=$DB->Insert_Id();
				set_team_autorank_players($teams_ID, $LEAGUEID);
				admin_teams_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";

				$Team_Name=stripslashes($Team_Name);

				display_add_team($Team_Name, $Divisions_ID, $Leagues_ID);
			}
		break;
		case "edit_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			display_edit_team($Teams_ID);
		break;
		case "confirm_edit_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Team_Name=$_REQUEST['Team_Name'];
			$Divisions_ID=$_REQUEST['Divisions_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$errors="";
			if(1)
			{
				$Team_Name=addslashes($Team_Name);
			}
			if(strlen($Team_Name)<1)
			{
				$errors=$errors.ENTER_TEAM_NAME."<br>";
			}
			else
			{
				$sql="select team_name from teams where team_name='$Team_Name' && ID<>$Teams_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.TEAM_ALREADY_EXISTS_ENTER_DIFFERENT_NAME."<br>";
				}
			}
			if(strlen($errors)<1)
			{
				if(strlen($Divisions_ID)<1)
					$Divisions_ID=0;
				$sql="update teams set team_name='$Team_Name', divisions_ID=$Divisions_ID, leagues_ID=$Leagues_ID where ID=$Teams_ID;";
				$DB->Execute($sql);
				admin_teams_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_team($Teams_ID);
			}
		break;
		case "delete_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo SURE_DELETE_TEAM." ".WARNING_DELETE_TEAM."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_team&Teams_ID=$Teams_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$sql="delete from teams where ID=$Teams_ID;";
			$DB->Execute($sql);
			$sql="delete from rosters where current_teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			admin_teams_main();
		break;
		case "edit_roster":
			$Teams_ID=$_REQUEST['Teams_ID'];
			display_edit_roster($Teams_ID);
		break;
		case "add_player":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Is_Keeper=$_REQUEST['Is_Keeper'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_add_player_team($Teams_ID, $Is_Keeper, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "confirm_add_player":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Is_Keeper=$_REQUEST['Is_Keeper'];
			$Players_ID=$_REQUEST['Players_ID'];
			$sql="select ID from rosters where players_ID='$Players_ID' and leagues_ID=$LEAGUEID";
			$rs=$DB->Execute($sql);
			$errors="";
			if(!($rs->EOF))
			{
				$errors=$errors.PLAYER_ALREADY_ON_TEAM_IN_LEAGUE."<br>";
			}
			if(strlen($errors)<1)
			{
				if($Is_Keeper==1)
				{
					$sql="insert into rosters (players_ID, current_teams_ID, keeper_teams_ID, leagues_ID) values ('$Players_ID', '$Teams_ID', '$Teams_ID', '$LEAGUEID');";
				}
				else
				{
					$sql="insert into rosters (players_ID, current_teams_ID, leagues_ID) values ('$Players_ID', '$Teams_ID', '$LEAGUEID');";
				}
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
			}
			$DB->Execute($sql);
			display_edit_roster($Teams_ID);
		break;
			case "remove_player":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Players_ID=$_REQUEST['Players_ID'];
			$sql="select team_name from teams where ID=$Teams_ID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$Team_Name=$rs->fields("team_name");
			}
			$sql="select firstname, lastname from players where ID='$Players_ID';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$firstname=$rs->fields("firstname");
				$lastname=$rs->fields("lastname");
			}
			echo SURE_DELETE_PLAYER."<br>";
			echo "$Team_Name: $firstname $lastname<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_player&Teams_ID=$Teams_ID&Players_ID=$Players_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=edit_roster&Teams_ID=$Teams_ID'>".NO."</a>";
		break;
		case "confirm_remove_player":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Players_ID=$_REQUEST['Players_ID'];
			$sql="delete from rosters where players_ID='$Players_ID' and current_teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			display_edit_roster($Teams_ID);
		break;
		case "update_teamlogo":
			$Teams_ID=$_REQUEST['Teams_ID'];
			display_update_teamlogo($Teams_ID);
		break;
		case "confirm_update_teamlogo":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$errors="";
			$league_logo_array=get_league_logo_array();
			$sql="select team_logo_filename from teams where ID=$Teams_ID;";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$old_team_logo_filename=$teams_rs->fields("team_logo_filename");
			}
			$uploaddir = $PHPFFL_FILE_ROOT."images/team_logos/";
			$base_filename=basename($_FILES['logo_filename']['name']);
			$logo_filename=$Teams_ID."_".$base_filename;
			$uploadfile = $uploaddir . $logo_filename;
			if(strlen($base_filename)<1)
			{
				$errors=$errors.PLEASE_SELECT_LOGO."<br>";
			}
			elseif (move_uploaded_file($_FILES['logo_filename']['tmp_name'], $uploadfile)) {

				@$new_logo_information=getimagesize("{$PHPFFL_FILE_ROOT}images/team_logos/{$logo_filename}");
				$new_logo_width=$new_logo_information[0];
				$new_logo_height=$new_logo_information[1];
				if(!$new_logo_information)
				{
					$errors=$errors.INVALID_IMAGE_EXTENSION."<br>";
				}
				if($new_logo_height>$league_logo_array['max_logo_height'] || $new_logo_width>$league_logo_array['max_logo_width'])
				{
					$errors=$errors.IMAGE_DIMENSIONS.": $new_logo_height ".HEIGHT." X $new_logo_width ".WIDTH." (".PIXELS.")<br>";
				}
				if($new_logo_height>$league_logo_array['max_logo_height'])
				{
					$errors=$errors.RESIZE_LOGO_TOO_HEIGHT."<br>";
				}
				if($new_logo_width>$league_logo_array['max_logo_width'])
				{
					$errors=$errors.RESIZE_LOGO_TOO_WIDTH."<br>";
				}
				if(strlen($errors)<1)
				{
					$sql="update teams set team_logo_filename='$logo_filename' where ID=$Teams_ID;";
					$DB->Execute($sql);
					if(strlen($old_team_logo_filename)>0 && $old_team_logo_filename!=$logo_filename)
					{
						@unlink($uploaddir.$old_team_logo_filename);
					}
				}
				else
				{
					@unlink($uploadfile);
				}

			} else {

			   $errors=$errors.ERROR_UPLOADING_FILE."<br>";
			   if(!is_writable($uploaddir))
			   {
			   		$errors=$errors.DIRECTORY_NOT_WRITABLE_CONTACT_ADMIN."<br>";

			   }
			}
			if(strlen($errors)>0)
			{
				echo "<span class='errors'>$errors</span>";
			}
			display_update_teamlogo($Teams_ID);
		break;
		case "delete_logo":
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo SURE_DELETE_LOGO."<br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_logo&Teams_ID=$Teams_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_logo":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$team_logo_filename=get_team_logo($Teams_ID);
			if(strlen($team_logo_filename)>0)
			{
				@unlink("{$PHPFFL_FILE_ROOT}images/team_logos/{$team_logo_filename}");
				$sql="update teams set team_logo_filename='' where ID=$Teams_ID;";
				$DB->Execute($sql);
			}
			display_update_teamlogo($Teams_ID);
		break;
		case "move_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			display_move_team($Teams_ID);
		break;

		case "confirm_move_team":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$sql="delete from rosters where current_teams_ID=$Teams_ID and leagues_ID=$Leagues_ID;";
			$DB->Execute($sql);
			$sql="update teams set leagues_ID=$Leagues_ID where ID=$Teams_ID;";
			$DB->Execute($sql);
			admin_teams_main();
		break;
	}
}



?>