<?php

function display_signup($Username="", $Password="", $Team_Name="", $League="", $Gmt_Offset="", $First_Name="", $Last_Name="", $Email="", $Telephone="", $Comments="")
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_WEB_ROOT;
	
	echo "<table border='0' cellpadding='4' cellspacing='3' width='80%'>";
	echo "<tr><td><span class='main_title'>".SIGN_UP."</span></td></tr>";
	echo "<tr><td>";
	echo ENTER_USER_INFO_CHOOSE_LEAGUE_TO_JOIN." ".SUBMIT_REGISTRATION_RECEIVE_EMAIL;  
	echo "</span></td></tr>";
	echo "</table>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF'>";
	echo "<tr><td><span class='table_row_title'>".USERNAME."</span></td>";
	echo "<td><input type='text' name='Username' value='$Username'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".PASSWORD."</span></td>";
	echo "<td><input type='text' name='Password' value='$Password'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TEAM_NAME."</span></td>";
	echo "<td><input type='text' name='Team_Name' value='$Team_Name'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LEAGUE."</span></td>";
	echo "<td>";
	$sql="select ID, league_name from leagues order by league_name ASC;";
	$rs=$DB->Execute($sql);
	echo "<select name='League'>";
	echo "<option value='0'>".ANY_LEAGUE."</option>";
	while(!($rs->EOF))
	{
		$leagues_ID=$rs->fields("ID");
		$leagues_name=$rs->fields("league_name");
		$s="";
		if($leagues_ID==$League)
			$s="selected";
		echo "<option value='$leagues_ID' $s>$leagues_name</option>";
		$rs->MoveNext();
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".GMT_OFFSET."</span></td><td>";
	echo "<select name=\"Gmt_Offset\">";
	$gmt_offset_array=get_gmt_offset_array();
	foreach($gmt_offset_array as $key => $val)
	{
		$s="";
		if($key==$Gmt_Offset)
			$s="selected";
		echo "<option value=\"$key\" $s>$val</option>";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".FIRST_NAME."</span></td>";
	echo "<td><input type='text' name='First_Name' value='$First_Name'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LAST_NAME."</span></td>";
	echo "<td><input type='text' name='Last_Name' value='$Last_Name'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".EMAIL_ADDRESS."</span></td>";
	echo "<td><input type='text' name='Email' value='$Email'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".TELEPHONE_NUMBER."</span></td>";
	echo "<td><input type='text' name='Telephone' value='$Telephone'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".COMMENTS."</span></td>";
	echo "<td><textarea name='Comments' cols='40' rows='3'>$Comments</textarea></td></tr>";

	if(extension_loaded('gd') && function_exists('imagettfbbox')) 
	{
		echo "<tr><td colspan='2'><img src=\"{$PHPFFL_WEB_ROOT}program_files/additional_programs/captcha/CaptchaSecurityImages.php\" />
	Security Code: <input id=\"security_code\" name=\"security_code\" type=\"text\" /></td></tr>";
	}

	echo "<tr><td></td><td align='left'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_signup'>";
	echo "</form></table>";



}

function display_league_settings($Leagues_ID)
{
	global $PHP_SELF, $DB, $Mode;
	
	$sql="select ID, league_name from leagues order by league_name;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		if(strlen($Leagues_ID)<1)
		{
			$Leagues_ID=$rs->fields("ID");
		}
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>".SELECT_LEAGUE_TO_VIEW."</span></td>";
		echo "<td>";
		echo "<select name=\"Leagues_ID\">";
		while(!($rs->EOF))
		{
			$league_ID=$rs->fields("ID");
			$league_name=$rs->fields("league_name");
			$s="";
			if($league_ID==$Leagues_ID)
			{
				$s="selected";
			}
			echo "<option value=\"$league_ID\" $s>$league_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='display_league_settings'>";
		echo "</form></table>";
		echo "<br>";
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".LEAGUE_SETTINGS."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		$sql="select * from leagues where ID=$Leagues_ID;";
		$leagues_rs=$DB->Execute($sql);
		if(!($leagues_rs->EOF))
		{
			$league_name=$leagues_rs->fields("league_name");
			$waiver_deadline=$leagues_rs->fields("waiver_deadline");
			$waiver_deadline=display_time($waiver_deadline);
			$trade_deadline=$leagues_rs->fields("trade_deadline");
			$trade_deadline=display_time($trade_deadline);
			$draft_date=$leagues_rs->fields("draft_date");
			$draft_date=display_time($draft_date);
			$draft_length_rounds=$leagues_rs->fields("draft_length_rounds");
			echo "<tr><td><span class='table_row_title'>".LEAGUE."</span></td><td>$league_name</td></tr>";
			echo "<tr><td><span class='table_row_title'>".NUMBER_ROUNDS_DRAFT."</span></td><td>$draft_length_rounds</td></tr>";
			echo "<tr><td><span class='table_row_title'>".DRAFT_DATE."</span></td><td>$draft_date</td></tr>";
			echo "<tr><td><span class='table_row_title'>".TRADE_DEADLINE."</span></td><td>$trade_deadline</td></tr>";
			echo "<tr><td><span class='table_row_title'>".WAIVER_WIRE_DEADLINE."</span></td><td>$waiver_deadline</td></tr>";
			
			
		}
		echo "</table>";
		echo "<br>";
		$sql="select distinct(position_description) from scoring_categories, scoring_categories_leagues_values where scoring_categories.ID=scoring_categories_ID and scoring_categories_leagues_values.leagues_ID=$Leagues_ID order by position_description ASC;";
		$scoring_rs=$DB->Execute($sql);
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".SCORING."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		while(!($scoring_rs->EOF))
		{
			$current_position_description=$scoring_rs->fields("position_description");
			$sql="select distinct(scoring_categories.ID) from scoring_categories, scoring_categories_leagues_values where position_description='$current_position_description' and scoring_categories.ID=scoring_categories_ID and leagues_ID=$Leagues_ID order by display_order ASC";
			$category_rs=$DB->Execute($sql);
			
			
			while(!($category_rs->EOF))
			{
				$categories_ID=$category_rs->fields("ID");
				display_scoring_category_detail($categories_ID, $Leagues_ID, $current_position_description, "table_row_title");
				$category_rs->MoveNext();
			}
			$scoring_rs->MoveNext();
		}
		echo "</table>";
	}
	else
	{
		echo "<table><tr><td>";
		echo THERE_ARE_NO_LEAGUES;
		echo "</td></tr></table>";
	}
}


?>
