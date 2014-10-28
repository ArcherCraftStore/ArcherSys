<?php

$Action=$_REQUEST['Action'];

Switch($Action)
{

	case "confirm_login":
		echo "<span class='errors'>".LOGIN_FAILED_TRY_AGAIN."</span><br>";
	default:
		display_login_main();
	break;
	case "forgot_password":
		display_forgot_password();
	break;
	case "confirm_forgot_password":
		$Username=$_REQUEST['Username'];
		if(1)
		{
			$Username=addslashes($Username);
		}
		$sql="select ID, email_address from users where username='$Username';";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$email_address=$rs->fields("email_address");
			$users_ID=$rs->fields("ID");
			$Password= createRandomPassword();
			$InsertPassword=md5($Password);
			$sql="update users set password='$InsertPassword' where ID=$users_ID;";
			$DB->Execute($sql);
			$message=PASSWORD_RESET_HERE_IS_LOGIN."\n";
			$message=$message.USERNAME.": $Username\n";
			$message=$message.PASSWORD.": $Password\n";
			send_email($email_address, LOGIN_INFORMATION, $message);
			echo "<span class='table_row_title'>".PASSWORD_RESET_AND_EMAILED."</span>";
			display_login_main();
		}
		else
		{
			echo "<span class='errors'>".USERNAME_DOES_NOT_EXIST."</span><br>";
			display_forgot_password();
		}

	break;
}


function display_login_main()
{
	global $Mode, $PHP_SELF;
	$Remember_User=$_COOKIE["Remember_User"];
	$Remember_Pass=$_COOKIE["Remember_Pass"];
	if(strlen($Remember_User)>0 && strlen($Remember_Pass)>0)
	{
		$checked="checked=checked";
	}
	echo "<form method='post' action='$PHP_SELF' name='Login_Form' id='Login_Form'>";
	echo "<table cellpadding='3' cellspacing'2'>";
	echo "<tr><td><span class='table_row_title'>".USERNAME."</span></td><td><input type='text' name='Username' id='Username' value='$Remember_User'></td></tr>";
	echo "<tr><td><span class='table_row_title'>".PASSWORD."</span></td><td><input type='password' name='Password' value='$Remember_Pass'></td></tr>";
	echo "<tr><td colspan='2'><span class='eleven_title'>".REMEMBER_LOGIN_INFO.": </span><input type='checkbox' name='Remember_Me' value='1' $checked></td></tr>";
	echo "<tr><td colspan'2'><input type='Submit' name='Submit' value='".LOGIN."'></td></tr>";
	echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=forgot_password'>".FORGOT_PASSWORD."</a></td></tr>";
	echo "<input type='hidden' name='Mode' value='confirm_login'>";
	echo "<input type='hidden' name='Action' value='confirm_login'>";
	echo "</table>";
	echo "</form>";
}

function display_forgot_password()
{
	global $Mode;
	echo "<form method='post' action=''>";
	echo "<table cellpadding='3' cellspacing'2'>";
	echo "<tr><td colspan='2'><span class='main_title'>".FORGOT_PASSWORD."</span></td></tr>";
	echo "<tr><td><span class='table_row_title'>".USERNAME."</span></td><td><input type='text' name='Username' value=''></td></tr>";
	echo "<tr><td colspan'2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='confirm_forgot_password'>";
	echo "</table>";
	echo "</form>";

}

?>