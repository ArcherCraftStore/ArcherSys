<?php 

$Action=$_REQUEST['Action'];
//To verify this page is included from admin.php
if($Mode=="config_global" && $ISSUPERUSER==1)
{

	Switch($Action)
	{
		default:
			update_config_global_main();
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
			update_config_global_main();
		break;
	}
}

?>