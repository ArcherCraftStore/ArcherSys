<?php 

function update_config_global_main()
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_INSTALLED;
	

	$sql="select ID, value from config_global;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$fieldname=$rs->fields("ID");
		$$fieldname=$rs->fields("value");
		
		$rs->MoveNext();
	}
	$extra_br_tag="";
	if(strlen($File_Root)<1)
	{
		$File_Root=str_replace("install.php", "", $_SERVER['SCRIPT_FILENAME'] );
		$File_Root=str_replace("admin.php", "", $File_Root );
		echo "<span class='twelve_title'>Note: phpFFL has attempted to determine your file root. Please confirm that this is correct and click Submit.</span><br>";
		$extra_br_tag="<br>";
	}
	
	if(strlen($Web_Root)<1)
	{
		$Web_Root_Base="http://".$_SERVER['HTTP_HOST'];
		$Web_Root=$Web_Root_Base.str_replace("install.php", "", $PHP_SELF );
		$Web_Root=str_replace("admin.php", "", $Web_Root );
		echo "<span class='twelve_title'>Note: phpFFL has attempted to determine your web root. Please confirm that this is correct and click Submit.</span><br>";
		$extra_br_tag="<br>";
	}
	echo "$extra_br_tag";

	echo "<span class='twelve_title'>";
	echo PHPFFL_FILE_ROOT_LANG.": ";
	if(file_exists($File_Root."logout.php"))
	{
		echo " Passed Test. phpFFL was able to verify your file root.";
	}
	else
	{
		echo " WARNING, Failed Test. phpFFL was not able to verify your file root by finding this file. <br>{$File_Root}logout.php<br>Please verify this path is correct and update your settings if necessary.";
	}
	echo "</span>";
	echo "<br>";
	echo "<span class='twelve_title'>";
	echo PHPFFL_WEB_ROOT_LANG.": ";
	if(ini_get("allow_url_fopen"))
	{
		if(@fclose(@fopen("{$Web_Root}images/phpFFL_sml.jpg", "r")))
		{
			echo " Passed Test. phpFFL was able to verify your web root.";
		}
		else
		{
			echo " WARNING, Failed Test. phpFFL was not able to verify your web root by finding this file. <br>{$Web_Root}images/phpFFL_sml.jpg<br>Please verify this path is correct and update your settings if necessary.<br><br>";
		}
	}
	else
	{
		echo " Your php settings to not allow phpFFL to determine if your web root is set correctly.<br><br>";
	}
	echo "</span>";
		
	echo "<br><br>";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td width='100'><span class='table_row_title'>".PHPFFL_FILE_ROOT_LANG."</span><br><span class='table_row_title_subheader'>(".PHPFFL_FILE_ROOT_LANG_DETAIL.")</span></td><td><input size=\"50\" type=\"text\" name=\"File_Root\" value=\"".htmlentities($File_Root)."\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".PHPFFL_WEB_ROOT_LANG."</span><br><span class='table_row_title_subheader'>(".PHPFFL_WEB_ROOT_LANG_DETAIL.")</span></td><td><input size=\"50\" type=\"text\" name=\"Web_Root\" value=\"".htmlentities($Web_Root)."\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".ADMIN_EMAIL_ADDRESS_LANG."</span></td><td><input size=\"30\" type=\"text\" name=\"Sendmail_From\" value=\"".htmlentities($Sendmail_From)."\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".DEFAULT_LANGUAGE."</span></td><td>";
	echo "<select name=\"Default_Language\">";
	$sql="select ID, language_name from languages order by language_name ASC;";
	$languages_rs=$DB->Execute($sql);
	while(!($languages_rs->EOF))
	{
		$current_languages_ID=$languages_rs->fields("ID");
		$current_languages_name=$languages_rs->fields("language_name");
		$s="";
		if($current_languages_ID==$Default_Language)
			$s="selected";
		echo "<option value='$current_languages_ID' $s>$current_languages_name</option>";
		$languages_rs->MoveNext();
	}	
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='100'><span class='table_row_title'>".SEND_AUTOMATED_EMAILS_LANG."</span></td><td>";
	echo "<select name=\"Sendmail_Bool\">";
	echo "<option value=\"1\">".TRUE_LANG."</option>";
	$s="";
	if($Sendmail_Bool==0)
	{
		$s="selected";
	}
	echo "<option value=\"0\" $s>".FALSE_LANG."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td><span class='table_row_title'>".AUTORUN_PIN_LANG."</span><br><span class='table_row_title_subheader'>(".AUTORUN_PIN_LANG_DETAIL.")</span></td><td><input type=\"text\" name=\"Autorun_Pin\" value=\"".htmlentities($Autorun_Pin)."\"></td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_update_config_global'>";
	echo "</form>";
	echo "</table>";

}

function display_load_db_dump()
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_INSTALLED;
	

	echo "<table>";
	echo "<tr><td><span class='twelve_title'>Your database has been created, but the phpFFL tables have not been loaded yet. Please follow the install instructions to do that before you continue.</span></td></tr>";

	echo "</table>";


}
?>