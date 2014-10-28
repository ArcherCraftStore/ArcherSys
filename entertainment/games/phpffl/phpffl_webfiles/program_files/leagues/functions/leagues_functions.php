<?php

function select_leagues_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $USERSID, $ISSUPERUSER, $PHPFFL_WEB_ROOT, $PHPFFL_DEFAULT_LANGUAGE;
	
	$users_leagues_ID=0;
	
	if($ISSUPERUSER==1)
	{
		$sql="select * from leagues order by league_name;";
	}
	elseif(strlen($USERSID)>0)
	{
		$leagues_array=array();
		$sql="select leagues_ID from users_teams, teams where teams_ID=teams.ID and users_ID=$USERSID;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$leagues_array[]=$rs->fields("leagues_ID");
			$rs->MoveNext();
		}
		$sql="select leagues_ID from admin_users_leagues where users_ID=$USERSID;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$leagues_ID=$rs->fields("leagues_ID");
			if(!(in_array($leagues_ID, $leagues_array)))
			{
				$leagues_array[]=$leagues_ID;
			}
			$rs->MoveNext();
		}
		$sql="select ID from leagues where public=1 order by league_name;";
		$rs=$DB->Execute($sql);
		while(!($rs->EOF))
		{
			$leagues_ID=$rs->fields("ID");
			if(!(in_array($leagues_ID, $leagues_array)))
			{
				$leagues_array[]=$leagues_ID;
			}
			$rs->MoveNext();
		}
		if(is_array($leagues_array))
		{
			foreach($leagues_array as $key => $val)
			{
				$extra_logic=$extra_logic." or ID=$val";
			}
		}
		$sql="select * from leagues where 0=1 $extra_logic order by league_name;";
	}
	else
	{
		$sql="select * from leagues where public=1 order by league_name;";
	}
	
	$rs = $DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='{$PHPFFL_WEB_ROOT}statistics.php'>";
		echo "<tr><td><span class='table_row_title'>".SELECT_LEAGUE_TO_VIEW."</span></td>";
		echo "<td>";
		echo "<select name=\"League_Session_ID\">";
		while(!($rs->EOF))
		{
			$league_ID=$rs->fields("ID");
			$league_name=$rs->fields("league_name");
			$s="";
			if($league_ID==$LEAGUEID)
				$s="selected";
			echo "<option value=\"$league_ID\" $s>$league_name</option>";
			$rs->MoveNext();
		}
		$rs->MoveFirst();
		echo "</select>";
		echo "</td></tr>";

		echo "<tr><td><span class='table_row_title'>".LANGUAGE."</span></td><td>";

		echo "<select name=\"Languages_ID\">";
		$sql="select ID, language_name from languages order by language_name ASC;";
		$languages_rs=$DB->Execute($sql);
		while(!($languages_rs->EOF))
		{
			$current_languages_ID=$languages_rs->fields("ID");
			$current_languages_name=$languages_rs->fields("language_name");
			$s="";
			if($current_languages_ID==$PHPFFL_DEFAULT_LANGUAGE)
			{
				$s="selected";
			}
			echo "<option value='$current_languages_ID' $s>$current_languages_name</option>";
			$languages_rs->MoveNext();
		}	
		echo "</select>";
		echo "</td></tr>";

		echo "<tr><td colspan='3'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='set_leagueid'>";
		echo "</form></table>";
	}
	else
	{
		echo "<table>";
		echo "<tr><td><span class='table_row_title'>".THERE_ARE_NO_PUBLIC_LEAGUES." ".PLEASE_LOGIN_TO_VIEW_YOUR_LEAGUE."</td></tr>";
		echo "</table>";
	}




}



?>