<?php
/*

function admin_leagues_main() - Displays the main view that is seen when Leagues is clicked on in the Admin section.

function display_add_new_league($League_Name="", $League_Abbreviation="", $League_Motto="", $Public="") - Displays Add a New League.

function display_edit_league($Leagues_ID) - Displays Edit for an existing League.

*/

function admin_leagues_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $ISSUPERUSER, $USERSID;
	
	if($ISSUPERUSER==1)
	{
		$sql="select * from leagues order by league_name;";
	}
	else
	{
		$sql="select leagues.* from leagues, admin_users_leagues where leagues.ID=leagues_ID and users_ID=$USERSID;";
	}
	$rs = $DB->Execute($sql);
	$default_leagues_ID=0;
	$sql="select ID from leagues where is_default=1;";
	$default_rs=$DB->Execute($sql);
	if(!($default_rs->EOF))
	{
		$default_leagues_ID=$default_rs->fields("ID");
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".SELECT_LEAGUE_ADMIN."</span></td>";
	echo "<td>";
	echo "<select name=\"League_Session_ID\">";
	while(!($rs->EOF))
	{
		$league_ID=$rs->fields("ID");
		$is_league_admin=check_is_admin($USERSID, $LEAGUEID);
		$league_name=$rs->fields("league_name");
		if($is_league_admin==1)
		{
			$s="";
			if($league_ID==$LEAGUEID)
				$s="selected";
			echo "<option value=\"$league_ID\" $s>$league_name</option>";
		}
		$rs->MoveNext();
	}
	$rs->MoveFirst();
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='set_leagueid'>";
	echo "</form></table>";
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	if($ISSUPERUSER==1)
	{
		echo "<tr><td colspan='12'><a href=\"$PHP_SELF?Mode=$Mode&Action=add_new_league\">".ADD_NEW_LEAGUE."</a></td></tr>";
	}
	echo "<tr><td colspan='12'>&nbsp;</td></tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".LEAGUE_NAME."</span></td>";
	echo "<td><span class='table_row_title'>".TYPE."</span></td>";
	echo "<td><span class='table_row_title'>".TEAMS."</span></td>";
	echo "<td><span class='table_row_title'>".NUMBER_ADMINS."</span></td>";
	if($ISSUPERUSER==1)
	{
		echo "<td><span class='table_row_title'>".DEFAULT_TEXT."</span></td>";
	}
	echo "<td></td><td></td><td></td>";
	if($ISSUPERUSER==1)
	{
		echo "<td></td><td></td><td></td>";
	}
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='12'></td></tr>";
	while(!($rs->EOF))
	{
		$bg=get_row_bg($bg);
		$league_ID=$rs->fields("ID");
		$league_name=$rs->fields("league_name");
		$league_abbreviation=$rs->fields("league_abbv");
		$league_motto=$rs->fields("league_motto");
		$public=$rs->fields("public");
		$sql="select count(ID) as total_teams from teams where leagues_ID=$league_ID";
		$teams_rs=$DB->Execute($sql);
		if(!$teams_rs->EOF)
		{
			$total_teams=$teams_rs->fields("total_teams");
		}
		else
		{
			$total_teams=0;
		}
		$total_admins=0;
		$sql="select count(ID) as total_admins from admin_users_leagues where leagues_ID=$league_ID";
		$admins_rs=$DB->Execute($sql);
		if(!$teams_rs->EOF)
		{
			$total_admins=$admins_rs->fields("total_admins");
		}
		$public_value=$public;
		if($public==1)
			$public=PUBLIC_TEXT;
		else
			$public=PRIVATE_TEXT;
		echo "<tr bgcolor='$bg'>";
		echo "<td>$league_name</td>";
		echo "<td>$public</td>";
		echo "<td>$total_teams</td>";
		echo "<td>$total_admins</td>";
		if($ISSUPERUSER==1)
		{
			$c="";
			if($default_leagues_ID==$league_ID)
			{
				$c="checked";
			}
			if($public_value==1)
			{
				echo "<td><input type='radio' name='Default_Leagues_ID' value='$league_ID' $c></td>";
			}
			else
			{
				echo "<td>".NA."</td>";
			}
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=manage_admins&Leagues_ID=$league_ID'>".MANAGE_ADMINS."</a></td>";
		}
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=invite&Leagues_ID=$league_ID'>".INVITE."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_league&Leagues_ID=$league_ID'>".VIEW."</a></td>";
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_league&Leagues_ID=$league_ID'>".EDIT."</a></td>";
		
		if($ISSUPERUSER==1)
		{
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_league&Leagues_ID=$league_ID'>".DELETE."</a></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=restart_league&Leagues_ID=$league_ID'>".RESET_SEASON."</a></td>";
		}
		echo "</tr>";
		$rs->MoveNext();
	}
	if($ISSUPERUSER==1)
	{
		echo "<tr>";
		echo "<td>".NONE."</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		$c="";
		if($default_leagues_ID==0)
		{
			$c="checked";
		}
		echo "<td><input type='radio' name='Default_Leagues_ID' value='0' $c></td>";
		echo "<td></td>";
		echo "<td></td><td></td><td></td><td></td><td></td>";
		echo "</tr>";
		echo "<tr><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='update_default_league'>";
	}
	echo "</form></table>";
}

function display_add_new_league($League_Name="", $League_Abbreviation="", $League_Motto="", $Public="", $Trade_Deadline="", $Waiver_Deadline="", $Draft_Rounds="", $Draft_Pick_Trades="", $Days_Protest_Trades="", $Draft_Date="", $Allow_Auto_Waivers="", $Days_Clear_Waivers="", $Display_Draft_Timer="", $Sunday_Lock="", $Languages_ID="", $Display_Team_Logos="", $Max_Logo_Height="100", $Max_Logo_Width="100", $Short_Player_Names="", $Allow_Trade_Cancellations="", $Draft_Email_Notifications="", $Display_User_Contact_Details="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID;
	
	if(strlen($Public)<1)
		$Public=1;
		
	echo "<table>";
	echo "<form enctype='multipart/form-data' method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_LEAGUE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_NAME."</span></td><td><input type=\"text\" name=\"League_Name\" value=\"".htmlentities($League_Name)."\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".DEFAULT_LANGUAGE."</span></td><td>";
	echo "<select name=\"Languages_ID\">";
	$sql="select ID, language_name from languages order by language_name ASC;";
	$languages_rs=$DB->Execute($sql);
	while(!($languages_rs->EOF))
	{
		$current_languages_ID=$languages_rs->fields("ID");
		$current_languages_name=$languages_rs->fields("language_name");
		$s="";
		if($current_languages_ID==$Languages_ID)
			$s="selected";
		echo "<option value='$current_languages_ID' $s>$current_languages_name</option>";
		$languages_rs->MoveNext();
	}	
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TRADE_DEADLINE." (EST)</span></td><td>";
	date_input_display("Trade_Month", "Trade_Day", "Trade_Year", "Trade_Hour", "Trade_Minute", "Trade_Second", $Trade_Deadline);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".WAIVER_WIRE_DEADLINE." (EST)</span></td><td>";
	date_input_display("Waiver_Month", "Waiver_Day", "Waiver_Year", "Waiver_Hour", "Waiver_Minute", "Waiver_Second", $Waiver_Deadline);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_DATE."</span></td><td>";
	date_input_display("Draft_Month", "Draft_Day", "Draft_Year", "Draft_Hour", "Draft_Minute", "Draft_Second", $Draft_Date);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_ROUNDS_DRAFT."</span></td><td>";
	echo "<select name='Draft_Rounds'>";
	for($i=1;$i<51;$i++)
	{
		$s="";
		if($Draft_Rounds==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_PICK_TRADES."</span></td><td>";
	echo "<select name='Draft_Pick_Trades'>";
	echo "<option value='0' $s>".NOT_ALLOWED."</option>";
	
	for($i=1;$i<=21;$i++)
	{
		$s="";
		if($Draft_Pick_Trades==$i)
			$s="selected";
		if($i==1)
			echo "<option value='$i' $s>".ALLOWED." - $i ".FUTURE_YEAR."</option>";
		else
			echo "<option value='$i' $s>".ALLOWED." - $i ".FUTURE_YEARS."</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_PROTEST_TRADES."</span></td><td>";
	echo "<select name='Days_Protest_Trades'>";
	for($i=1;$i<22;$i++)
	{
		$s="";
		if($Days_Protest_Trades==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".AUTO_PROCESS_WAIVERS."</span></td><td>";
	echo "<select name='Allow_Auto_Waivers'>";
	
	echo "<option value='No'>".NO."</option>";
	if($Allow_Auto_Waivers=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_CLEAR_WAIVERS."</span></td><td>";
	echo "<select name='Days_Clear_Waivers'>";
	for($i=0;$i<15;$i++)
	{
		$s="";
		if($Days_Clear_Waivers==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".PUBLIC_TEXT."</span></td><td>";
	echo "<select name='Public'>";
	
	echo "<option value='1'>".PUBLIC_TEXT."</option>";
	$s="";
	if($Public==0)
		$s="selected";
	
	echo "<option value='0' $s>".PRIVATE_TEXT."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LOCK_LINEUPS_SUNDAY."</span></td><td>";
	echo "<select name='Sunday_Lock'>";
	
	echo "<option value='1'>".YES."</option>";
	$s="";
	if($Sunday_Lock=="0")
		$s="selected";
	
	echo "<option value='0' $s>".NO."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".USE_SHORT_PLAYER_NAMES."</span><br><span class='table_row_title_subheader'>(".FIRST_INITIAL_SCORING.")</span></td><td>";
	echo "<select name='Short_Player_Names'>";
	echo "<option value='Yes'>".YES."</option>";
	$s="";
	if($Short_Player_Names=="No")
		$s="selected";
	echo "<option value='No' $s>".NO."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".ALLOW_TRADE_CANCELLATIONS."</span><br><span class='table_row_title_subheader'>(".ALLOW_TRADE_CANCELLATIONS_DETAIL.")</span></td><td>";
	echo "<select name='Allow_Trade_Cancellations'>";
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Allow_Trade_Cancellations=="Yes")
		$s="selected";
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".DISPLAY_USER_CONTACT_INFO."</span></td><td>";
	echo "<select name='Display_User_Contact_Details'>";
	
	echo "<option value='0'>".NO."</option>";
	if($Display_User_Contact_Details==1)
		$s="selected";
	
	echo "<option value='1' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";

	echo "<tr><td><span class='table_row_title'>".DISPLAY_TEAM_LOGOS."</span></td><td>";
	echo "<select name='Display_Team_Logos'>";
	echo "<option value='Yes'>".YES."</option>";
	$s="";
	if($Display_Team_Logos=="No")
		$s="selected";
	echo "<option value='No' $s>".NO."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM_LOGO_DIMENSIONS."</span></td><td>";
	echo "<table><tr><td><input type=\"text\" name=\"Max_Logo_Height\" value=\"$Max_Logo_Height\" size=\"4\">".HEIGHT."</td><td>&nbsp;X&nbsp;</td><td><input type=\"text\" name=\"Max_Logo_Width\" value=\"$Max_Logo_Width\" size=\"4\">".WIDTH."</td><td>(".PIXELS.")</td></tr></table>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DISPLAY_TIMER_DRAFT."</span></td><td>";
	echo "<select name='Display_Draft_Timer'>";
	
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Display_Draft_Timer=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".EMAIL_NOTIFICATIONS_IN_DRAFT."</span><br><span class='table_row_title_subheader'>(".EMAIL_NOTIFICATIONS_IN_DRAFT_DETAIL.")</span></td><td>";
	echo "<select name='Draft_Email_Notifications'>";
	
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Draft_Email_Notifications=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".CHOOSE_OVERRIDE_LOGO_UPLOAD."</span><br><span class='table_row_title_subheader'>(".CHOOSE_OVERRIDE_LOGO_UPLOAD_DESCRIPTION.")</span></td><td><input name='Logo_Filename' type='file'/></td></tr>";

	echo "<tr><td><span class='table_row_title'>".LEAGUE_ABBREVIATION."</span></td><td><input type=\"text\" name=\"League_Abbreviation\" value=\"$League_Abbreviation\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_MOTTO."</span></td><td><textarea name=\"League_Motto\" rows=\"2\" cols=\"30\">$League_Motto</textarea></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_league'>";
	echo "</form></table>";

}

function display_edit_league($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $PHPFFL_IMAGE_PATH, $PHPFFL_FILE_PATH;
	
	$users_offset=get_users_offset($USERSID);
	$sql="select * from leagues where ID=$Leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($_rs->EOF))
	{
		$League_Name=$rs->fields("league_name");
		$League_Abbreviation=$rs->fields("league_abbv");
		$League_Motto=$rs->fields("league_motto");
		$Public=$rs->fields("public");
		$Trade_Deadline=$rs->fields("trade_deadline");
		$Waiver_Deadline=$rs->fields("waiver_deadline");
		$Draft_Date=$rs->fields("draft_date");
		$Draft_Date=display_users_time($Draft_Date,$users_offset, "Y-m-d H:i:s");
		$Draft_Rounds=$rs->fields("draft_length_rounds");
		$Draft_Pick_Trades=$rs->fields("draft_pick_trades_future_years");
		$Days_Protest_Trades=$rs->fields("days_protest_trade");
		$Allow_Auto_Waivers=$rs->fields("allow_auto_waivers");
		$Days_Clear_Waivers=$rs->fields("days_clear_waivers");
		$Display_Draft_Timer=$rs->fields("display_draft_timer");
		$Sunday_Lock=$rs->fields("sunday_lock");
		$Languages_ID=$rs->fields("default_languages_ID");
		$Display_Team_Logos=$rs->fields("display_team_logos");
		$Max_Logo_Height=$rs->fields("max_logo_height");
		$Max_Logo_Width=$rs->fields("max_logo_width");
		$Short_Player_Names=$rs->fields("short_player_names");
		$Draft_Email_Notifications=$rs->fields("draft_email_notifications");
		$Allow_Trade_Cancellations=$rs->fields("allow_trade_cancellations");
		$league_logo_filename=$rs->fields("league_logo");
		$Display_User_Contact_Details=$rs->fields("display_user_contact_details");
	}
	echo "<table>";
	echo "<form enctype='multipart/form-data' method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".EDIT_LEAGUE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_NAME."</span></td><td><input type=\"text\" name=\"League_Name\" value=\"".htmlentities($League_Name)."\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".DEFAULT_LANGUAGE."</span></td><td>";
	echo "<select name=\"Languages_ID\">";
	$sql="select ID, language_name from languages order by language_name ASC;";
	$languages_rs=$DB->Execute($sql);
	while(!($languages_rs->EOF))
	{
		$current_languages_ID=$languages_rs->fields("ID");
		$current_languages_name=$languages_rs->fields("language_name");
		$s="";
		if($current_languages_ID==$Languages_ID)
			$s="selected";
		echo "<option value='$current_languages_ID' $s>$current_languages_name</option>";
		$languages_rs->MoveNext();
	}	
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TRADE_DEADLINE." (EST)</span></td><td>";
	date_input_display("Trade_Month", "Trade_Day", "Trade_Year", "Trade_Hour", "Trade_Minute", "Trade_Second", $Trade_Deadline);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".WAIVER_WIRE_DEADLINE." (EST)</span></td><td>";
	date_input_display("Waiver_Month", "Waiver_Day", "Waiver_Year", "Waiver_Hour", "Waiver_Minute", "Waiver_Second", $Waiver_Deadline);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_DATE."</span></td><td>";
	date_input_display("Draft_Month", "Draft_Day", "Draft_Year", "Draft_Hour", "Draft_Minute", "Draft_Second", $Draft_Date);
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_ROUNDS_DRAFT."</span></td><td>";
	echo "<select name='Draft_Rounds'>";
	for($i=1;$i<51;$i++)
	{
		$s="";
		if($Draft_Rounds==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_PICK_TRADES."</span></td><td>";
	echo "<select name='Draft_Pick_Trades'>";
	echo "<option value='0' $s>".NOT_ALLOWED."</option>";
	for($i=1;$i<21;$i++)
	{
		$s="";
		if($Draft_Pick_Trades==$i)
			$s="selected";
		if($i==1)
			echo "<option value='$i' $s>".ALLOWED." - $i ".FUTURE_YEAR."</option>";
		else
			echo "<option value='$i' $s>".ALLOWED." - $i ".FUTURE_YEARS."</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_PROTEST_TRADES."</span></td><td>";
	echo "<select name='Days_Protest_Trades'>";
	for($i=1;$i<22;$i++)
	{
		$s="";
		if($Days_Protest_Trades==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".AUTO_PROCESS_WAIVERS."</span></td><td>";
	echo "<select name='Allow_Auto_Waivers'>";
	
	echo "<option value='No'>".NO."</option>";
	if($Allow_Auto_Waivers=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_CLEAR_WAIVERS."</span></td><td>";
	echo "<select name='Days_Clear_Waivers'>";
	for($i=0;$i<15;$i++)
	{
		$s="";
		if($Days_Clear_Waivers==$i)
			$s="selected";
		echo "<option value='$i' $s>$i</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".PUBLIC_TEXT."</span></td><td>";
	
	echo "<select name='Public'>";
	
	echo "<option value='1'>".PUBLIC_TEXT."</option>";
	$s="";
	if($Public==0)
		$s="selected";
	
	echo "<option value='0' $s>".PRIVATE_TEXT."</option>";
	echo "</select>";
	
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LOCK_LINEUPS_SUNDAY."</span></td><td>";
	echo "<select name='Sunday_Lock'>";
	
	echo "<option value='1'>".YES."</option>";
	$s="";
	if($Sunday_Lock=="0")
		$s="selected";
	
	echo "<option value='0' $s>".NO."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".USE_SHORT_PLAYER_NAMES."</span><br><span class='table_row_title_subheader'>(".FIRST_INITIAL_SCORING.")</span></td><td>";
	echo "<select name='Short_Player_Names'>";
	
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Short_Player_Names=="Yes")
		$s="selected";
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".ALLOW_TRADE_CANCELLATIONS."</span><br><span class='table_row_title_subheader'>(".ALLOW_TRADE_CANCELLATIONS_DETAIL.")</span></td><td>";
	echo "<select name='Allow_Trade_Cancellations'>";
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Allow_Trade_Cancellations=="Yes")
		$s="selected";
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".DISPLAY_USER_CONTACT_INFO."</span></td><td>";
	echo "<select name='Display_User_Contact_Details'>";
	
	echo "<option value='0'>".NO."</option>";
	if($Display_User_Contact_Details==1)
		$s="selected";
	
	echo "<option value='1' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";

	echo "<tr><td><span class='table_row_title'>".DISPLAY_TEAM_LOGOS."</span></td><td>";
	echo "<select name='Display_Team_Logos'>";
	echo "<option value='Yes'>".YES."</option>";
	$s="";
	if($Display_Team_Logos=="No")
		$s="selected";
	echo "<option value='No' $s>".NO."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".TEAM_LOGO_DIMENSIONS."</span></td><td>";
	echo "<table><tr><td><input type=\"text\" name=\"Max_Logo_Height\" value=\"$Max_Logo_Height\" size=\"4\">".HEIGHT."</td><td>&nbsp;X&nbsp;</td><td><input type=\"text\" name=\"Max_Logo_Width\" value=\"$Max_Logo_Width\" size=\"4\">".WIDTH."</td><td>(".PIXELS.")</td></tr></table>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DISPLAY_TIMER_DRAFT."</span></td><td>";
	echo "<select name='Display_Draft_Timer'>";
	
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Display_Draft_Timer=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".EMAIL_NOTIFICATIONS_IN_DRAFT."</span><br><span class='table_row_title_subheader'>(".EMAIL_NOTIFICATIONS_IN_DRAFT_DETAIL.")</span></td><td>";
	echo "<select name='Draft_Email_Notifications'>";
	
	echo "<option value='No'>".NO."</option>";
	$s="";
	if($Draft_Email_Notifications=="Yes")
		$s="selected";
	
	echo "<option value='Yes' $s>".YES."</option>";
	echo "</select>";
	echo "</td></tr>";
	
	

	echo "<tr><td><span class='table_row_title'>".CHOOSE_OVERRIDE_LOGO_UPLOAD."</span><br><span class='table_row_title_subheader'>(".CHOOSE_OVERRIDE_LOGO_UPLOAD_DESCRIPTION.")</span></td><td><input name='Logo_Filename' type='file'/></td></tr>";

	if(is_file($PHPFFL_FILE_ROOT."images/team_logos/$league_logo_filename"))
	{
		echo "<tr><td colspan='2'>";
		echo "<img src='{$PHPFFL_IMAGE_PATH}team_logos/$league_logo_filename' />";
		echo "<br><a href='$PHP_SELF?Mode=$Mode&Action=remove_league_logo&Leagues_ID=$Leagues_ID'>".REMOVE_LOGO."</a>";
		echo "</td></tr>";
	}
	
	echo "<tr><td><span class='table_row_title'>".LEAGUE_ABBREVIATION."</span></td><td><input type=\"text\" name=\"League_Abbreviation\" value=\"$League_Abbreviation\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_MOTTO."</span></td><td><textarea name=\"League_Motto\" rows=\"2\" cols=\"30\">$League_Motto</textarea></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Leagues_ID' value='$Leagues_ID'>";
	echo "<input type=hidden name='Action' value='confirm_edit_league'>";
	echo "</form></table>";



}

function display_manage_admins($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;
	
	$sql="select league_name from leagues where ID=$Leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$league_name=$rs->fields("league_name");
	}
	$sql="select * from admin_users_leagues where leagues_ID=$Leagues_ID;";
	$rs=$DB->Execute($sql);
	
	echo "<table>";
	echo "<tr><td><span class='main_title'>".MANAGE_ADMINS.": $league_name</span></td></tr>";
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Leagues_ID=$Leagues_ID&Action=add_admin_league'>".ADD_AN_ADMINISTRATOR."</a></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	if(!($rs->EOF))
	{
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr>";
		echo "<td></td>";
		echo "<td><span class='table_row_title'>".NAME."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='2'></td></tr>";
		while(!($rs->EOF))
		{
			$users_ID=$rs->fields("users_ID");
			$sql="select first_name, last_name from users where ID=$users_ID;";
			$users_rs=$DB->Execute($sql);
			if(!($users_rs->EOF))
			{
				$first_name=$users_rs->fields("first_name");
				$last_name=$users_rs->fields("last_name");
			}
			echo "<tr>";
			echo "<td><input type='checkbox' name='Users_ID[$users_ID]' value='1'></td>";
			echo "<td>$last_name, $first_name</td>";
			echo "</tr>";
			$rs->MoveNext();
		}
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value='".REMOVE_ADMINS."'></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Leagues_ID' value='$Leagues_ID'>";
		echo "<input type=hidden name='Action' value='remove_admins_league'>";
		echo "</form>";
	}
	else
	{
		echo "<tr><td><span class='table_row_title'>".NO_ADMINS_FOR_LEAGUE."</span></td></tr>";
	}
	echo "</table>";
}


function display_add_admin_league($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;
	
	$sql="select league_name from leagues where ID=$Leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$league_name=$rs->fields("league_name");
	}
	echo "<table>";
	echo "<tr><td><span class='main_title'>".ADD_AN_ADMINISTRATOR.": $league_name</span></td></tr>";
	echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Leagues_ID=$Leagues_ID&Action=manage_admins'>".BACK."</a></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td><span class='table_row_title'>".USER."</span></td>";
	echo "<td>";
	echo "<select name='Users_ID'>";
	$sql="select ID, last_name, first_name, username from users order by last_name ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$users_ID=$rs->fields("ID");
		$last_name=$rs->fields("last_name");
		$first_name=$rs->fields("first_name");
		$users_username=$rs->fields("username");
		$sql="select ID from admin_users_leagues where users_ID=$users_ID and leagues_ID=$Leagues_ID;";
		$admin_rs=$DB->Execute($sql);
		if($admin_rs->EOF)
		{
			echo "<option value='$users_ID'>$last_name, $first_name ($users_username)</option>";
		}
		$rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "</tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Leagues_ID' value='$Leagues_ID'>";
	echo "<input type=hidden name='Action' value='confirm_add_admin_league'>";
	echo "</form>";
	echo "</table>";
	

}


function display_view_league($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode, $USERSID;
	
	$sql="select * from leagues where ID=$Leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($_rs->EOF))
	{
		$League_Name=$rs->fields("league_name");
		$Languages_ID=$rs->fields("default_languages_ID");
		$Display_Languages_Name=get_language_name($Languages_ID);
		$League_Abbreviation=$rs->fields("league_abbv");
		$League_Motto=$rs->fields("league_motto");
		$Public=$rs->fields("public");
		$Trade_Deadline=$rs->fields("trade_deadline");
		$Trade_Deadline_timestamp=strtotime($Trade_Deadline);
		$Trade_Deadline=date("F, d Y H:i", $Trade_Deadline_timestamp);
		$Waiver_Deadline=$rs->fields("waiver_deadline");
		$Waiver_Deadline_timestamp=strtotime($Waiver_Deadline);
		$Waiver_Deadline=date("F, d Y H:i", $Waiver_Deadline_timestamp);
		$Draft_Date=$rs->fields("draft_date");
		$Draft_Date=display_users_time($Draft_Date);
		$Draft_Rounds=$rs->fields("draft_length_rounds");
		$Draft_Pick_Trades=$rs->fields("draft_pick_trades_future_years");
		$Days_Protest_Trades=$rs->fields("days_protest_trade");
		$Allow_Auto_Waivers=$rs->fields("allow_auto_waivers");
		$Days_Clear_Waivers=$rs->fields("days_clear_waivers");
		$Sunday_Lock=$rs->fields("sunday_lock");
		$Display_Team_Logos=$rs->fields("display_team_logos");
		$Max_Logo_Height=$rs->fields("max_logo_height");
		$Max_Logo_Width=$rs->fields("max_logo_width");
		$Short_Player_Names=$rs->fields("short_player_names");
		$Allow_Trade_Cancellations=$rs->fields("allow_trade_cancellations");
		$Draft_Email_Notifications=$rs->fields("draft_email_notifications");
		$Display_User_Contact_Details=$rs->fields("display_user_contact_details");
		if($Sunday_Lock==1)
			$display_sunday_lock="Yes";
		else
			$display_sunday_lock="No";
	}
	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".VIEW_LEAGUE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_NAME."</span></td><td>$League_Name</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DEFAULT_LANGUAGE."</span></td><td>$Display_Languages_Name</td></tr>";
	echo "<tr><td><span class='table_row_title'>".TRADE_DEADLINE." (EST)</span></td><td>$Trade_Deadline</td></tr>";
	echo "<tr><td><span class='table_row_title'>".WAIVER_WIRE_DEADLINE." (EST)</span></td><td>$Waiver_Deadline</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_DATE."</span></td><td>$Draft_Date</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_ROUNDS_DRAFT."</span></td><td>$Draft_Rounds</td></tr>";
	echo "<tr><td><span class='table_row_title'>".DRAFT_PICK_TRADES."</span></td><td>";
	if($Draft_Pick_Trades==0)
		echo NOT_ALLOWED;
	elseif($Draft_Pick_Trades==1)
		echo ALLOWED." - $Draft_Pick_Trades ".FUTURE_YEAR;
	else
		echo ALLOWED." - $Draft_Pick_Trades ".FUTURE_YEARS;
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_PROTEST_TRADES."</span></td><td>$Days_Protest_Trades</td></tr>";
	echo "<tr><td><span class='table_row_title'>".AUTO_PROCESS_WAIVERS."</span></td><td>$Allow_Auto_Waivers</td></tr>";
	echo "<tr><td><span class='table_row_title'>".NUMBER_DAYS_CLEAR_WAIVERS."</span></td><td>$Days_Clear_Waivers</td></tr>";
	echo "<tr><td><span class='table_row_title'>".PUBLIC_TEXT."</span></td><td>";
	if($Public==0)
		echo NO;
	else
		echo YES;
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LOCK_LINEUPS_SUNDAY."</span></td><td>";
	echo "$display_sunday_lock";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".USE_SHORT_PLAYER_NAMES."</span><br><span class='table_row_title_subheader'>(".FIRST_INITIAL_SCORING.")</span></td><td>";
	if($Short_Player_Names=="Yes")
		echo YES;
	else
		echo NO;
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".ALLOW_TRADE_CANCELLATIONS."</span><br><span class='table_row_title_subheader'>(".ALLOW_TRADE_CANCELLATIONS_DETAIL.")</span></td><td>";
	if($Allow_Trade_Cancellations=="Yes")
		echo YES;
	else
		echo NO;
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".DISPLAY_USER_CONTACT_INFO."</span></td><td>";
	if($Display_User_Contact_Details)
		echo YES;
	else
		echo NO;
	echo "</td></tr>";

	echo "<tr><td><span class='table_row_title'>".DISPLAY_TEAM_LOGOS."</span></td><td>";
	if($Display_Team_Logos=="Yes")
		echo YES;
	else
		echo NO;
	echo "</td></tr>";

	echo "<tr><td><span class='table_row_title'>".TEAM_LOGO_DIMENSIONS."</span></td><td>";
	echo "<table><tr><td>$Max_Logo_Height ".HEIGHT."</td><td>&nbsp;X&nbsp;</td><td>$Max_Logo_Width ".WIDTH."</td><td>(".PIXELS.")</td></tr></table>";
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".EMAIL_NOTIFICATIONS_IN_DRAFT."</span><br><span class='table_row_title_subheader'>(".EMAIL_NOTIFICATIONS_IN_DRAFT_DETAIL.")</span></td><td>";
	if($Draft_Email_Notifications=="Yes")
		echo YES;
	else
		echo NO;
	echo "</td></tr>";
	
	echo "<tr><td><span class='table_row_title'>".LEAGUE_ABBREVIATION."</span></td><td>$League_Abbreviation</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE_MOTTO."</span></td><td>$League_Motto</td></tr>";
	echo "</table>";

}

function display_invite($Leagues_ID, $Invite_Email="", $Invite_Subject="", $Invite_Text="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $PHPFFL_WEB_ROOT;
	
	$users_data_array=get_users_data_array($USERSID);
	$users_full_name=$users_data_array['first_name']." ".$users_data_array['last_name'];
	if(strlen($Invite_Text)<1)
	{
		$Invite_Text=INVITE_EMAIL_TEXT;
		$Invite_Text=str_replace("ACTUAL_NAME_HERE", "$users_full_name", $Invite_Text);
		$sql="select league_name from leagues where ID=$Leagues_ID;";
		$leagues_rs=$DB->Execute($sql);
		$leagues_name=$leagues_rs->fields("league_name");
		$Invite_Text=$Invite_Text."\n\n".LEAGUE.": $leagues_name\n";
		$Invite_Text=$Invite_Text.SIGNUP_HERE.": {$PHPFFL_WEB_ROOT}signup.php";
	}
	if(strlen($Invite_Subject)<1)
	{
		$Invite_Subject=INVITE_EMAIL_SUBJECT;
		$Invite_Subject=str_replace("ACTUAL_NAME_HERE", "$users_full_name", $Invite_Subject);
	}
	$Invite_Text=htmlentities($Invite_Text);
	$Invite_Subject=htmlentities($Invite_Subject);
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".EMAIL_ADDRESS."</td>";
	echo "<td><input type='text' name='Invite_Email' value='$Invite_Email' size='50'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".EMAIL_SUBJECT."</td>";
	echo "<td><input type='text' name='Invite_Subject' value=\"$Invite_Subject\" size='50'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".EMAIL_TEXT."</td>";
	echo "<td><textarea name='Invite_Text' cols='55' rows='10'>$Invite_Text</textarea></td>";
	echo "</tr>";
	echo "<tr><td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_invite'>";
	echo "</form>";
	echo "</table>";

}
?>