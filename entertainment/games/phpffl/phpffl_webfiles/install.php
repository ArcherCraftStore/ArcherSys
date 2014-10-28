<?php 

include("program_files/config.php");
include("program_files/admin/functions/config_global_functions.php");
include("language/english/admin.php");
include("language/english/general.php");
?><html>
<head>
<title>phpFFL : Free Online Fantasy Football League Manager</title>
<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body><?php
$Action=$_POST['Action'];
Switch($Action)
{
	case "install_main":
	default:
		if($PHPFFL_DB_NOT_LOADED)
		{
			display_load_db_dump();
		}
		else
		{
			update_config_global_main();
		}
	break;
	case "confirm_update_config_global":
		$Config_Array['File_Root']=$_POST['File_Root'];
		$Config_Array['Web_Root']=$_POST['Web_Root'];
		$Config_Array['Sendmail_From']=$_POST['Sendmail_From'];
		$Config_Array['Sendmail_Bool']=$_POST['Sendmail_Bool'];
		$Config_Array['Autorun_Pin']=$_POST['Autorun_Pin'];
		$Config_Array['Default_Language']=$_POST['Default_Language'];
		foreach($Config_Array as $key => $val)
		{
			if(1)
			{
				$val=addslashes($val);
			}
			$sql="update config_global set value='$val' where ID='$key';";
			$DB->Execute($sql);
		}
		$sql="update config_global set value='1' where ID='Installed';";
		$DB->Execute($sql);
		$PHPFFL_INSTALLED=1;
		update_config_global_main();
	break;
}

?></body></html>