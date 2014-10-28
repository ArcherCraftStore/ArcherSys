<?php

include("program_files/config.php");
include("language/{$PHPFFL_DEFAULT_LANGUAGE_DIR}/login.php");

$Mode=$_REQUEST['Mode'];


Switch($Mode)
{
	case "confirm_login":
		$Username=$_REQUEST['Username'];
		$Password=$_REQUEST['Password'];
		$Remember_Me=$_REQUEST['Remember_Me'];
		if(1)
		{
			$Username=addslashes($Username);
		}
		$encrypted_password=md5($Password);
		$sql="select ID, leagues_ID from users where username='$Username' and password='$encrypted_password';";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{

			if($Remember_Me==1)
			{
				setcookie("Remember_User",$Username, time()+60*60*24*1000);
				setcookie("Remember_Pass",$Password, time()+60*60*24*1000);
			}
			$users_ID=$rs->fields("ID");
			$ip = getenv('REMOTE_ADDR');
			$current_date=gmdate("Y-m-d H:i:s");
			$sql="insert into users_login_log (users_ID, login_date, login_ip) values ('$users_ID', '$current_date', '$ip');";
			$DB->Execute($sql);
			session_start();
			session_register('USERSID');
			//$USERSID=$users_ID;
			$_SESSION['USERSID']=$users_ID;
			$sql="select leagues_ID from users_teams, teams where teams.ID=teams_ID and users_ID=$users_ID;";
			$leagues_rs=$DB->Execute($sql);
			$session_name=session_name();
			$session_id=session_id();
			if(!($leagues_rs->EOF))
			{
				$leagues_ID=$leagues_rs->fields("leagues_ID");
				session_register('LEAGUEID');
				$_SESSION['LEAGUEID']=$leagues_ID;
			}
			if(strlen($leagues_ID)>0)
			{
				$sql="select ID from custom_pages where leagues_ID=$leagues_ID and default_login_page=1;";
				$pages_rs=$DB->Execute($sql);
				if(!($pages_rs->EOF))
				{
					$pages_ID=$pages_rs->fields("ID");
					session_write_close();
					header("Location: {$PHPFFL_WEB_ROOT}custom_pages.php?&Pages_ID=$pages_ID&{$session_name}={$session_id}");
					exit();
				}
				else
				{
					session_write_close();
					header("Location: {$PHPFFL_WEB_ROOT}my_team.php?{$session_name}={$session_id}");
					exit();
				}
			}
			else
			{
				session_write_close();
				header("Location: {$PHPFFL_WEB_ROOT}leagues.php?{$session_name}={$session_id}");
				exit();
			}

		}
	default:
	case "login":
		$File_To_Include="program_files/login.php";
		$Page_Title=LOGIN;
	break;

}


include("template/header.php");
include("template/no_leftnav.php");
include($File_To_Include);
echo "</td></tr></table></td></tr></tbody></table>";
include("template/footer.php");
?>
<script type="text/javascript">
$(document).ready(function() {
   $("#Username").focus();

});
</script>
<?php
?>