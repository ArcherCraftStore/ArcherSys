<?php



	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	session_start();

	/*Disable Magic Quotes If On*/
	#
	if ( (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime()))
	{
		function stripslashes_deep($value)
		{
			$value = is_array($value) ?
			array_map('stripslashes_deep', $value) :
			stripslashes($value);

			return $value;
		}
		$_POST = array_map('stripslashes_deep', $_POST);
		$_GET = array_map('stripslashes_deep', $_GET);
		$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
		$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}

	//Include ADODB Datbase Abstraction Library - http://adodb.sourceforge.net
	include('adodb/adodb.inc.php');
	$PHP_SELF=$_SERVER['PHP_SELF'];
	$IsAjax=$_GET['IsAjax'];
	$IsThickbox=$_GET['IsThickbox'];

	//Security Check
	if(strlen($_REQUEST['DATABASE_SERVER_PATH'])>0 || strlen($_REQUEST['DATABASE_USER'])>0  || strlen($_REQUEST['DATABASE_PASS'])>0  || strlen($_REQUEST['DATABASE_NAME'])>0 )
	{
		die("Security Check - common.php");
	}

	$DB = NewADOConnection($DATABASE_TYPE);
	$DATABASE_CONNECTION_STATUS=$DB->Connect($DATABASE_SERVER_PATH, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if(!($DATABASE_CONNECTION_STATUS))
	{
		die("<br><br><strong>Failed to connect to database. Please check your database connection settings.</strong>");
	}
	$sql="select ID, value, variable_name from config_global;";
	$rs=$DB->Execute($sql);
	if($rs)
	{
		while(!($rs->EOF))
		{
			$current_variable_name=$rs->fields("variable_name");
			$$current_variable_name=$rs->fields("value");
			define($current_variable_name, $rs->fields("value"));
			$rs->movenext();
		}
	}
	else
	{
		$PHPFFL_DB_NOT_LOADED=1;
	}

if($PHPFFL_INSTALLED && basename($PHP_SELF)!="install.php")
{
	if(file_exists($PHPFFL_FILE_ROOT."install.php") && $PHPFFL_DEVELOPMENT_INSTALL!=1)
	{
		die("NOTICE: You must delete install.php before using phpFFL for security reasons. If you need to you need to update any of the values in install.php you can do so in the Admin area of phpFFL or by uploading install.php again.");
	}
	$PHPFFL_IMAGE_PATH=$PHPFFL_WEB_ROOT."images/";
	$USERSID=$_SESSION['USERSID'];
	$LEAGUEID=$_SESSION['LEAGUEID'];
	$GO_TO_LOGIN=0;

	include("global/functions/global_functions.php");
	include("global/functions/mail_functions.php");

	//Check if Superuser or Admin
	if(strlen($USERSID)>0)
	{
		$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
		$ISSUPERUSER=check_is_superuser($USERSID);
		$current_date=gmdate("Y-m-d H:i:s");
		$sql="update users set last_activity='$current_date' where ID=$USERSID;";
		$DB->Execute($sql);
	}
	else
	{
		$ISADMIN=0;
		$ISSUPERUSER=0;
	}

	//Get LEAGUEID to set session to first time when set through Leagues
	if(strlen($_POST["League_Session_ID"])>0 && $_POST["Action"]=="set_leagueid")
	{

		$NEW_LEAGUEID=$_POST["League_Session_ID"];
		$Languages_ID=$_POST["Languages_ID"];
		if(strlen($Languages_ID)>0)
		{
			$_SESSION['DEFAULT_LANGUAGE']=$Languages_ID;
		}

	}//set Session on login
	elseif(strlen($USERSID)>0 && strlen($LEAGUEID)<1)
	{
		$sql="select leagues_ID from teams, users_teams where users_ID=$USERSID and teams.ID=teams_ID;";
		$rs=$DB->Execute($sql);
		$NEW_LEAGUEID=$rs->fields("leagues_ID");
	}
	elseif(strlen($LEAGUEID)<1)
	{
		if($PHPFFL_UPDATES_SCRIPT!=1)
		{
			$sql="select ID from leagues where is_default=1;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$NEW_LEAGUEID=$rs->fields("ID");
				$GO_TO_LOGIN=1;
			}
		}
	}
	//Set LEAGUEID session variable
	if(strlen($NEW_LEAGUEID)>0)
	{
		session_start();
		session_register('LEAGUEID');
		$_SESSION['LEAGUEID']=$NEW_LEAGUEID;
		$LEAGUEID=$NEW_LEAGUEID;
	}

	/*
	Set Language - overwrite config global variable PHPFFL_DEFAULT_LANGUAGE if user or league language is available.
	*/
	if(strlen($USERSID)>0)
	{
		//Set language for user
		$sql="select languages_ID from users where ID=$USERSID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$PHPFFL_DEFAULT_LANGUAGE=$rs->fields("languages_ID");
		}
	}
	elseif(strlen($_SESSION['DEFAULT_LANGUAGE'])>0)
	{
		$PHPFFL_DEFAULT_LANGUAGE=$_SESSION['DEFAULT_LANGUAGE'];
	}
	elseif(strlen($LEAGUEID)>0)
	{
		//Set language for league
		$sql="select default_languages_ID from leagues where ID=$LEAGUEID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$PHPFFL_DEFAULT_LANGUAGE=$rs->fields("default_languages_ID");
		}
	}


	$sql="select language_directory from languages where ID='$PHPFFL_DEFAULT_LANGUAGE';";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$PHPFFL_DEFAULT_LANGUAGE_DIR=$rs->fields("language_directory");
	}
	else
	{
		echo "Error loading language file. There is not a record for this language in the languages table. Please add this language to the languages table along with the directory name.<br>";
		echo "Languages ID: $PHPFFL_DEFAULT_LANGUAGE";
		die();
	}
	include(PHPFFL_FILE_ROOT."language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/general.php");

}
else
{
	if(basename($PHP_SELF)!="install.php")
	{
		die("Before you use phpFFL please go to install.php and update your installation settings. <br>install.php is located in the root directory of your phpFFL installation.");
	}
}










?>