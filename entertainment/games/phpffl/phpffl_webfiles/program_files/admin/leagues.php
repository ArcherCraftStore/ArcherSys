<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="leagues" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_leagues_main();
		break;
		case "set_leagueid":
			admin_leagues_main();
		break;
		case "add_new_league":
			if($ISSUPERUSER==1)
			{
				display_add_new_league();
			}
		break;
		case "confirm_add_new_league":
			if($ISSUPERUSER==1)
			{
				$League_Name=$_REQUEST['League_Name'];
				$Languages_ID=$_REQUEST['Languages_ID'];
				$League_Abbreviation=$_REQUEST['League_Abbreviation'];
				$League_Motto=$_REQUEST['League_Motto'];
				$Public=$_REQUEST['Public'];
				$Draft_Rounds=$_REQUEST['Draft_Rounds'];
				$Draft_Pick_Trades=$_REQUEST['Draft_Pick_Trades'];
				$Days_Protest_Trades=$_REQUEST['Days_Protest_Trades'];
				$Allow_Auto_Waivers=$_REQUEST['Allow_Auto_Waivers'];
				$Days_Clear_Waivers=$_REQUEST['Days_Clear_Waivers'];
				$Display_Draft_Timer=$_REQUEST['Display_Draft_Timer'];
				$Trade_Month=$_REQUEST['Trade_Month'];
				$Trade_Day=$_REQUEST['Trade_Day'];
				$Trade_Year=$_REQUEST['Trade_Year'];
				$Trade_Hour=$_REQUEST['Trade_Hour'];
				$Trade_Minute=$_REQUEST['Trade_Minute'];
				$Waiver_Month=$_REQUEST['Waiver_Month'];
				$Waiver_Day=$_REQUEST['Waiver_Day'];
				$Waiver_Year=$_REQUEST['Waiver_Year'];
				$Waiver_Hour=$_REQUEST['Waiver_Hour'];
				$Waiver_Minute=$_REQUEST['Waiver_Minute'];
				$Draft_Month=$_REQUEST['Draft_Month'];
				$Draft_Day=$_REQUEST['Draft_Day'];
				$Draft_Year=$_REQUEST['Draft_Year'];
				$Draft_Hour=$_REQUEST['Draft_Hour'];
				$Draft_Minute=$_REQUEST['Draft_Minute'];
				$Sunday_Lock=$_REQUEST['Sunday_Lock'];
				$Display_Team_Logos=$_REQUEST['Display_Team_Logos'];
				$Max_Logo_Height=$_REQUEST['Max_Logo_Height'];
				$Max_Logo_Width=$_REQUEST['Max_Logo_Width'];
				$Short_Player_Names=$_REQUEST['Short_Player_Names'];
				$Draft_Email_Notifications=$_REQUEST['Draft_Email_Notifications'];
				$Allow_Trade_Cancellations=$_REQUEST['Allow_Trade_Cancellations'];
				$Display_User_Contact_Details=$_REQUEST['Display_User_Contact_Details'];

				$gmt_offset=get_users_offset($USERSID);
				$gmt_offset=0-$gmt_offset;
				$Draft_Date_timestamp=mktime($Draft_Hour+$gmt_offset, $Draft_Minute, 0, $Draft_Month, $Draft_Day,$Draft_Year);
				$Draft_Date=date("Y-m-d H:i:s", $Draft_Date_timestamp);
				$Trade_Deadline="$Trade_Year-$Trade_Month-$Trade_Day $Trade_Hour:$Trade_Minute:00";
				$Waiver_Deadline="$Waiver_Year-$Waiver_Month-$Waiver_Day $Waiver_Hour:$Waiver_Minute:00";
				$Draft_Date_Pass="$Draft_Year-$Draft_Month-$Draft_Day $Draft_Hour:$Draft_Minute:00";
				$errors="";
				if(1)
				{
					$League_Name=addslashes($League_Name);
					$League_Abbreviation=addslashes($League_Abbreviation);
					$League_Motto=addslashes($League_Motto);
				}
				if(strlen($League_Name)<1)
				{
					$errors=$errors.PLEASE_ENTER_LEAGUE_NAME."<br>";
				}
				else
				{
					$sql="select league_name from leagues where league_name='$League_Name';";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
					{
						$errors=$errors.LEAGUE_EXISTS_ENTER_NEW_NAME."<br>";
					}
				}
				if($Display_Team_Logos=="Yes")
				{
					//check to make sure logo sizes are set
					if(strlen($Max_Logo_Height)<1)
					{
						$errors=$errors.PLEASE_ENTER_A_MAXIMUM_HEIGHT_LOGO."<br>";	
					}
					if(strlen($Max_Logo_Width)<1)
					{
						$errors=$errors.PLEASE_ENTER_A_MAXIMUM_WIDTH_LOGO."<br>";	
					}
				}
				if(strlen($errors)<1)
				{
					$sql="insert into leagues (league_name, league_abbv, league_motto, public, waiver_deadline, trade_deadline, draft_pick_trades_future_years, draft_length_rounds, days_protest_trade, draft_date, allow_auto_waivers, days_clear_waivers, display_draft_timer, sunday_lock, default_languages_ID, display_team_logos, max_logo_height, max_logo_width, short_player_names, allow_trade_cancellations, draft_email_notifications, display_user_contact_details) values ('$League_Name', '$League_Abbreviation', '$League_Motto', '$Public', '$Waiver_Deadline', '$Trade_Deadline', '$Draft_Pick_Trades', '$Draft_Rounds', '$Days_Protest_Trades', '$Draft_Date', '$Allow_Auto_Waivers', '$Days_Clear_Waivers', '$Display_Draft_Timer', '$Sunday_Lock', '$Languages_ID', '$Display_Team_Logos', '$Max_Logo_Height', '$Max_Logo_Width', '$Short_Player_Names', '$Allow_Trade_Cancellations', '$Draft_Email_Notifications', '$Display_User_Contact_Details');";
					$DB->Execute($sql);
					
					$sql="select max(ID) as maxID from leagues;";
					$leagues_rs=$DB->Execute($sql);
					$new_leagues_ID=$leagues_rs->fields("maxID");
					//Update League Logo
					$uploaddir = $PHPFFL_FILE_ROOT."images/team_logos/";
					$base_filename=basename($_FILES['Logo_Filename']['name']);
					$logo_filename="L".$new_leagues_ID."_".$base_filename;
					$uploadfile = $uploaddir . $logo_filename;
					if (move_uploaded_file($_FILES['Logo_Filename']['tmp_name'], $uploadfile)) 
					{
						@$new_logo_information=getimagesize($uploadfile);
						if(!$new_logo_information)
						{
							@unlink($uploadfile);
						}
						else
						{
							$sql="update leagues set league_logo='$logo_filename' where ID=$new_leagues_ID;";
							$DB->Execute($sql);
						}
					}

					admin_leagues_main();
				}
				else
				{
					echo "<span class='errors'>$errors</span>";
					$League_Name=stripslashes($League_Name);
					$League_Abbreviation=stripslashes($League_Abbreviation);
					$League_Motto=stripslashes($League_Motto);
					display_add_new_league($League_Name, $League_Abbreviation, $League_Motto, $Public,  $Trade_Deadline, $Waiver_Deadline, $Draft_Rounds, $Draft_Pick_Trades, $Days_Protest_Trades, $Draft_Date_Pass, $Allow_Auto_Waivers, $Days_Clear_Waivers, $Display_Draft_Timer, $Sunday_Lock, $Languages_ID, $Display_Team_Logos, $Max_Logo_Height, $Max_Logo_Width, $Short_Player_Names, $Allow_Trade_Cancellations, $Draft_Email_Notifications, $Display_User_Contact_Details);
				}
			}
		break;
		case "view_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			display_view_league($Leagues_ID);
		break;
		case "edit_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			display_edit_league($Leagues_ID);
		break;
		case "confirm_edit_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$League_Name=$_REQUEST['League_Name'];
			$Languages_ID=$_REQUEST['Languages_ID'];
			$League_Abbreviation=$_REQUEST['League_Abbreviation'];
			$League_Motto=$_REQUEST['League_Motto'];
			$Public=$_REQUEST['Public'];
			$Draft_Rounds=$_REQUEST['Draft_Rounds'];
			$Draft_Pick_Trades=$_REQUEST['Draft_Pick_Trades'];
			$Days_Protest_Trades=$_REQUEST['Days_Protest_Trades'];
			$Allow_Auto_Waivers=$_REQUEST['Allow_Auto_Waivers'];
			$Days_Clear_Waivers=$_REQUEST['Days_Clear_Waivers'];
			$Display_Draft_Timer=$_REQUEST['Display_Draft_Timer'];
			$Trade_Month=$_REQUEST['Trade_Month'];
			$Trade_Day=$_REQUEST['Trade_Day'];
			$Trade_Year=$_REQUEST['Trade_Year'];
			$Trade_Hour=$_REQUEST['Trade_Hour'];
			$Trade_Minute=$_REQUEST['Trade_Minute'];
			$Waiver_Month=$_REQUEST['Waiver_Month'];
			$Waiver_Day=$_REQUEST['Waiver_Day'];
			$Waiver_Year=$_REQUEST['Waiver_Year'];
			$Waiver_Hour=$_REQUEST['Waiver_Hour'];
			$Waiver_Minute=$_REQUEST['Waiver_Minute'];
			$Draft_Month=$_REQUEST['Draft_Month'];
			$Draft_Day=$_REQUEST['Draft_Day'];
			$Draft_Year=$_REQUEST['Draft_Year'];
			$Draft_Hour=$_REQUEST['Draft_Hour'];
			$Draft_Minute=$_REQUEST['Draft_Minute'];
			$Sunday_Lock=$_REQUEST['Sunday_Lock'];
			$Display_Team_Logos=$_REQUEST['Display_Team_Logos'];
			$Max_Logo_Height=$_REQUEST['Max_Logo_Height'];
			$Max_Logo_Width=$_REQUEST['Max_Logo_Width'];
			$Short_Player_Names=$_REQUEST['Short_Player_Names'];
			$Allow_Trade_Cancellations=$_REQUEST['Allow_Trade_Cancellations'];
			$Draft_Email_Notifications=$_REQUEST['Draft_Email_Notifications'];
			$Display_User_Contact_Details=$_REQUEST['Display_User_Contact_Details'];


			$gmt_offset=get_users_offset($USERSID);
			$gmt_offset=0-$gmt_offset;
			$Draft_Date_timestamp=mktime($Draft_Hour+$gmt_offset, $Draft_Minute, 0, $Draft_Month, $Draft_Day,$Draft_Year);
			$Draft_Date=date("Y-m-d H:i:s", $Draft_Date_timestamp);
				
			$Trade_Deadline="$Trade_Year-$Trade_Month-$Trade_Day $Trade_Hour:$Trade_Minute:00";
			$Waiver_Deadline="$Waiver_Year-$Waiver_Month-$Waiver_Day $Waiver_Hour:$Waiver_Minute:00";
			$errors="";
			if(1)
			{
				$League_Name=addslashes($League_Name);
				$League_Abbreviation=addslashes($League_Abbreviation);
				$League_Motto=addslashes($League_Motto);
			}
			if(strlen($League_Name)<1)
			{
				$errors=$errors.PLEASE_ENTER_LEAGUE_NAME."<br>";
			}
			else
			{
				$sql="select league_name from leagues where league_name='$League_Name' && ID<>$Leagues_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.LEAGUE_EXISTS_ENTER_NEW_NAME."<br>";
				}
			}
			if($Display_Team_Logos=="Yes")
			{
				//check to make sure logo sizes are set
				if(strlen($Max_Logo_Height)<1)
				{
					$errors=$errors.PLEASE_ENTER_A_MAXIMUM_HEIGHT_LOGO."<br>";	
				}
				if(strlen($Max_Logo_Width)<1)
				{
					$errors=$errors.PLEASE_ENTER_A_MAXIMUM_WIDTH_LOGO."<br>";	
				}
			}
			if(strlen($errors)<1)
			{
				
				$sql="update leagues set league_name='$League_Name', league_abbv='$League_Abbreviation', league_motto='$League_Motto', public='$Public', trade_deadline='$Trade_Deadline', waiver_deadline='$Waiver_Deadline', draft_pick_trades_future_years=$Draft_Pick_Trades, draft_length_rounds=$Draft_Rounds, days_protest_trade=$Days_Protest_Trades, draft_date='$Draft_Date', allow_auto_waivers='$Allow_Auto_Waivers', days_clear_waivers=$Days_Clear_Waivers, display_draft_timer='$Display_Draft_Timer', sunday_lock='$Sunday_Lock', default_languages_ID='$Languages_ID', display_team_logos='$Display_Team_Logos', max_logo_height='$Max_Logo_Height', max_logo_width='$Max_Logo_Width', short_player_names='$Short_Player_Names', allow_trade_cancellations='$Allow_Trade_Cancellations', draft_email_notifications='$Draft_Email_Notifications', display_user_contact_details='$Display_User_Contact_Details' where ID=$Leagues_ID;";
				$DB->Execute($sql);

				//Update League Logo
				$uploaddir = $PHPFFL_FILE_ROOT."images/team_logos/";
				$base_filename=basename($_FILES['Logo_Filename']['name']);
				$logo_filename="L".$Leagues_ID."_".$base_filename;
				$uploadfile = $uploaddir . $logo_filename;
				if (move_uploaded_file($_FILES['Logo_Filename']['tmp_name'], $uploadfile)) 
				{
					@$new_logo_information=getimagesize($uploadfile);
					if(!$new_logo_information)
					{
						@unlink($uploadfile);
					}
					else
					{
						$sql="update leagues set league_logo='$logo_filename' where ID=$Leagues_ID;";
						$DB->Execute($sql);
					}
				}
				admin_leagues_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_league($Leagues_ID);
			}
		break;
		case "delete_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			echo SURE_DELETE_LEAGUE." ".WARNING_DELETE_LEAGUE."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_league&Leagues_ID=$Leagues_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_league":
			if($ISSUPERUSER==1)
			{
				$Leagues_ID=$_REQUEST['Leagues_ID'];
				$sql="delete from leagues where ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from teams where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from divisions where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from admin_users_leagues where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from schedules where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from starting_lineup_actuals where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from starting_lineup_requirements where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from players_statistics_fantasy where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from scoring_categories_leagues_values where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from teams_traded_picks where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from waiver_wire where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from trades where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from trades_teams_players where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from rosters where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from future_draft_picks where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft_order where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from custom_pages where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft_rank_teams where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft_teams_target_position where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft_timer_length where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				
			}
			admin_leagues_main();
		break;
		case "manage_admins":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			if($ISSUPERUSER==1)
			{
				display_manage_admins($Leagues_ID);
			}
		break;
		case "remove_admins_league":
			if($ISSUPERUSER==1)
			{
				$Leagues_ID=$_REQUEST['Leagues_ID'];
				$Users_ID=$_REQUEST['Users_ID'];
				if(is_array($Users_ID))
				{
					foreach($Users_ID as $key => $val)
					{
						$sql="delete from admin_users_leagues where users_ID=$key and leagues_ID=$Leagues_ID;";
						$DB->Execute($sql);
					}
				}
				display_manage_admins($Leagues_ID);
			}
		break;
		case "add_admin_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			if($ISSUPERUSER==1)
			{
				display_add_admin_league($Leagues_ID);
			}
		break;
		case "confirm_add_admin_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$Users_ID=$_REQUEST['Users_ID'];
			if($ISSUPERUSER==1)
			{
				$sql="insert into admin_users_leagues (users_ID, leagues_ID) values ('$Users_ID', '$Leagues_ID');";
				$DB->Execute($sql);
				display_manage_admins($Leagues_ID);
			}
		
		break;
		case "restart_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			echo SURE_RESET_LEAGUE." <br>".WARNING_RESET_LEAGUE."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_restart_league&Leagues_ID=$Leagues_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_restart_league":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			if($ISSUPERUSER==1)
			{
				$sql="update draft set players_ID=NULL where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from draft_teams_target_position where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from players_statistics_actuals;";
				$DB->Execute($sql);
				$sql="delete from players_statistics_fantasy where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from players_statistics_override;";
				$DB->Execute($sql);
				$sql="delete from starting_lineup_actuals where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from starting_lineup_submissions where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from trades where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from trades_teams_players where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="delete from waiver_wire where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				$sql="update teams set wins=0, losses=0, ties=0, winning_percentage=0.0, total_points=0 where leagues_ID=$Leagues_ID;";
				$DB->Execute($sql);
				admin_leagues_main();
			}
		break;
		case "invite":
			display_invite($LEAGUEID);
		break;
		case "confirm_invite":
			$Invite_Email=$_POST['Invite_Email'];
			$Invite_Subject=$_POST['Invite_Subject'];
			$Invite_Text=$_POST['Invite_Text'];
			if(get_magic_quotes_gpc())
			{
				$Invite_Email=stripslashes($Invite_Email);
				$Invite_Subject=stripslashes($Invite_Subject);
				$Invite_Text=stripslashes($Invite_Text);
			}
			$errors="";
			if(strlen($Invite_Email)<1)
			{
				$errors=PLEASE_ENTER_EMAIL_ADDRESS."<br>";
			}
			if(strlen($errors)<1)
			{
				send_email($Invite_Email, $Invite_Subject, $Invite_Text);
				echo "<span class='table_row_title'>".INVITATION_SENT."</span><br><br>";
				display_invite($LEAGUEID);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_invite($LEAGUEID, $Invite_Email, $Invite_Subject, $Invite_Text);
			}
		break;
		case "update_default_league":
			$Default_Leagues_ID=$_REQUEST['Default_Leagues_ID'];
			$sql="update leagues set is_default=0;";
			$DB->Execute($sql);
			$sql="update leagues set is_default=1 where ID=$Default_Leagues_ID;";
			$DB->Execute($sql);
			admin_leagues_main();
		break;
		case "remove_league_logo":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$sql="select league_logo from leagues where ID=$Leagues_ID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$league_logo=$rs->fields("league_logo");
				@unlink($PHPFFL_FILE_ROOT."images/team_logos/$league_logo");
				$sql="update leagues set league_logo='' where ID=$Leagues_ID;";
				$DB->Execute($sql);
			}
			admin_leagues_main();
		break;
	}
}



?>